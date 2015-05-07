<?php

namespace VTF;

use VTF;

/**
 * Parses a single config file.
 *
 * Class ConfigParser
 * @package VTF
 */
final class ConfigParser
{
	private static $_configFolder = 'config';
	private $_configItems = array();
	private static $_instance = null;

	public function includeConfigFile($path)
	{
		if ($path !== null){
			$_file = @realpath($path);
			if($_file != false && file_exists($_file) && is_readable($_file)) {
				$_basename = explode('.php', basename($_file))[0];
				$this->_configItems[$_basename] = include $_file;
			}else{
				//TODO: error handler
				throw new \Exception('Config File not found ');
			}
		}
	}

	/**
	 * Returns desired configuration value;
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name = 'filename')
	{
		if (!isset($this->_configItems[$name])) {
			$this->includeConfigFile(self::$_configFolder.DIRECTORY_SEPARATOR.$name.'.php');
		}
		if (array_key_exists($name, $this->_configItems)){
			return $this->_configItems[$name];
		}
		return '';
	}

	/**
	 * Create singleton instance of the class
	 *
	 * @param string $configFolder
	 * @return ConfigParser
	 * @throws \Exception
	 */
	public static function getInstance($configFolder = '/www/domain.com/www/roo/config')
	{
		if (self::$_instance === null) {
			self::$_instance = new ConfigParser();
			self::$_configFolder = $configFolder;
		}

		return self::$_instance;
	}
}