<?php

namespace VTF;

/**
 * <h1> Framework application by Vasil Tsitsev / http://tsintsev.com
 * Class FrameWorkApp
 *
 * @author Vasil Tsintsev
 * @version 1.0
 * @package VTF
 */
class App
{
	/**
	 * @var \VTF\App
	 */
	private static $_instance = null;

	/**
	 * @var \VTF\ConfigParser
	 */
	private $_config = null;

	/**
	 * @var \VTF\FrontController
	 */
	private $_frontController = null;

	/**
	 * @var string
	 */
	public static $sitepath = '';

	/**
	 * @var \VTF\Routers\IRouter
	 */
	private $_router = null;

	/**
	 * @var \VTF\Sessions\ISession
	 */
	private $_session;

	/**
	 * @var \VTF\Db\Db
	 */
	public $db = array();

	public function __construct()
	{
		set_exception_handler(array($this, '_exceptionHandler'));

		if (defined('SITE_PATH')) {
			self::$sitepath = SITE_PATH;
		} else {
			self::$sitepath =
				@realpath(dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
		}

		require 'AutoLoader.php';
		$loader = new AutoLoader();
		$loader->register(self::$sitepath);

		$this->_config = ConfigParser::getInstance(self::$sitepath . DIRECTORY_SEPARATOR . 'config');
	}

	/**
	 * Initiates the Application
	 *
	 * @throws \Exception
	 */
	public function run()
	{
		$this->setRouter();

		$this->db = new Db\Db();

		$this->_frontController = FrontController::getInstance();

		if ($this->_router instanceof Routers\IRouter) {
			$this->_frontController->setRouter($this->_router);
		} else {
			if ($this->_router == 'jsonRPC') {
				$this->_frontController->setRouter(null);
			} else {
				$this->_frontController->setRouter(new Routers\DefaultRouter());
			}
		}

		$s = $this->_config->app['session'];
		$_s = null;
		if ($s['autostart'] == true) {
			if ($s['type'] == 'native') {
				$_s = new Sessions\NativeSession($s['name'], $s['lifetime'], $s['path'], $s['domain'], $s['secure']);
			} else if ($s['type'] == 'database') {
				$_s = new Sessions\DBSession($s['db'], $s['name'], $s['dbtable'], $s['lifetime'], $s['path'], $s['domain'], $s['secure']);
			} else {
				throw new \Exception('Not implemented', 500);
			}
			$this->setSession($_s);
		}

		$this->_frontController->dispatch();
	}

	/**
	 * Returns Session instance
	 *
	 * @return \VTF\Sessions\ISession
	 */
	public function getSession()
	{
		return $this->_session;
	}

	/**
	 * Create another session implementation
	 *
	 * @param Sessions\ISession $session
	 */
	public function setSession(Sessions\ISession $session)
	{
		$this->_session = $session;
	}

	/**
	 * Connects to database;
	 *
	 * @param string $connection
	 * @return \PDO
	 * @throws \Exception
	 */
	public function getDbConnection($connection = 'default')
	{
		if (empty($connection)) {
			throw new \Exception('Database profile not set.', 500);
		}
		if (isset($this->_dbConnections[$connection])) {
			return $this->_dbConnections[$connection];
		}

		$_cnf = $this->_config->db;
		if (!isset($_cnf[$connection])) {
			throw new \Exception('Missing config for this database connection', 500);
		}

		$db = new \PDO($_cnf[$connection]['connection_url'],
			$_cnf[$connection]['username'],
			$_cnf[$connection]['password'],
			$_cnf[$connection]['pdo_options']);

		$this->_dbConnections[$connection] = $db;
		return $db;
	}

	/**
	 * Config Getter
	 *
	 * @return \VTF\ConfigParser
	 */
	public function getConfig()
	{
		return $this->_config;
	}

	/**
	 * @return \VTF\Routers\DefaultRouter
	 */
	public function getRouter()
	{
		return $this->_router;
	}

	/**
	 * Sets the router
	 * @param $router
	 */
	public function setRouter($router = null)
	{
		$this->_router = $router;
	}

	/**
	 * Main App Instance creator
	 *
	 * @return \VTF\App
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new App();
		}

		return self::$_instance;
	}

	public function _exceptionHandler(\Exception $ex)
	{
		if ($this->_config !== null && isset($this->_config->app['displayExceptions']) &&
			$this->_config->app['displayExceptions'] == true
		) {
			print '<pre>' . print_r($ex, true) . '</pre>';
		} else {
			$this->displayError($ex->getCode());
		}
	}

	public function displayError($error = 500)
	{
		try {
			$view = \VTF\View::getInstance();
			$view->display('errors/' . $error);
		} catch (\Exception $ex) {
			Common::headerStatus($error);
			exit('<h1>' . $error . '</h1>');
		}
	}

	public function __destruct()
	{
		if ($this->_session != null && $this->_session instanceof Sessions\ISession) {
			$this->_session->saveSession();
		}
	}
}
