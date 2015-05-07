<?php

namespace VTF;

use VTF;

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
	private static $_instance = null;
	private static $_config = null;
	private $_frontController = null;
	public static $sitepath = '';
	private $_router = null;
	public $_dbConnections = array();

	/**
	 * Initiates the Application
	 *
	 * @throws \Exception
	 */
	public function run()
	{
		$this->_frontController = FrontController::getInstance();

		if($this->_router instanceof VTF\Routers\IRouter) {
			$this->_frontController->setRouter($this->_router);
		}else{
			if ($this->_router == 'jsonRPC') {
				//TODO: some day.
				$this->_frontController->setRouter(null);
			} else {
				$this->_frontController->setRouter(new VTF\Routers\DefaultRouter());
			}
		}

		$this->_frontController->dispatch();
	}

	/**
	 * Main App Instance creator
	 * @return \VTF\ConfigParser
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {

			if(defined('SITE_PATH')){
				self::$sitepath = SITE_PATH;
			}else{
				self::$sitepath =
					@realpath(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
			}

			require 'AutoLoader.php';
			$loader = new AutoLoader();
			$loader->register(self::$sitepath);

			self::$_config = ConfigParser::getInstance(self::$sitepath.DIRECTORY_SEPARATOR.'config');

			self::$_instance = new App();
		}

		return self::$_instance;
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
		if(empty($connection)){
			throw new \Exception('Database profile not set.');
		}
		if(isset($this->_dbConnections[$connection])){
			return $this->_dbConnections[$connection];
		}

		$_cnf = $this->getConfig()->db;
		if(!isset($_cnf[$connection])){
			throw new \Exception('Missing config for this database connection');
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
	 * @return VTF\
	 */
	public function getConfig ()
	{
		return self::$_config;
	}

	/**
	 * @return VTF\Routers\DefaultRouter
	 */
	public function  getRouter ()
	{
		return $this->_router;
	}

	/**
	 * Sets the router
	 * @param $router
	 */
	public function  setRouter ($router = null)
	{
		$this->_router = $router;
	}

}
