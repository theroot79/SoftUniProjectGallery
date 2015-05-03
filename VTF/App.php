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
	private static $_frontController = null;
	public static $sitepath = '';
	public $config = null;

	public function run()
	{
		if(defined('SITE_PATH')){
			self::$sitepath = SITE_PATH;
		}else{
			self::$sitepath =
				@realpath(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
		}

		require 'AutoLoader.php';
		$loader = new AutoLoader();
		$loader->register(self::$sitepath);

		$configObj = ConfigParser::getInstance(self::$sitepath.DIRECTORY_SEPARATOR.'config');
		$config = $configObj->getConfig();

		$this->config = $config;

		self::$_frontController = FrontController::getInstance();
		self::$_frontController->dispatch();
	}

	/**
	 * Main App Instance creator
	 * @return \VTF\App
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new App();
		}

		return self::$_instance;
	}

}
