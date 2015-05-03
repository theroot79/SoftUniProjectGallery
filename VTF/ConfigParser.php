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
	private static $_instance = null;
	private static $_configItems = array();

	/**
	 * Sets the config folder and parses for config files.
	 *
	 * @param string $configFolder
	 * @param string $configFile
	 * @throws \Exception
	 */
	public function setConfig($configFolder = '/www/domain.com/config', $configFile = 'settings.ini')
	{
		if ($configFolder == null || empty($configFolder) || ($configFolder == '/www/domain.com/config')) {
			throw new \Exception('Please, setup config folder!');
		}

		if (is_dir($configFolder) && is_readable($configFolder)) {

			$configFolder = rtrim($configFolder, '\\');
			$configFolder = rtrim($configFolder, '/');

			$parse = @parse_ini_file($configFolder . DIRECTORY_SEPARATOR . $configFile, true);

			if ($parse !== false) {
				self::$_configItems = $parse;
			} else {
				throw new \Exception('Failed to parse the config file!');
			}

		} else {
			throw new \Exception('Something is wrong with the config folder, check the exception!');
		}
	}

	public function getConfig(){
		return self::$_configItems;
	}

	/**
	 * Returns desired configuration value;
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name = 'setting_key')
	{
		if (isset(self::$_configItems[$name]) && @array_key_exists($name, self::$_configItems)) {
			return self::$_configItems[$name];
		}
		return '';
	}

	/**
	 * Create singleton instance of the class
	 *
	 * @param string $configFolder
	 * @param string $configFile
	 * @return ConfigParser
	 * @throws \Exception
	 */
	public static function getInstance($configFolder = 'config', $configFile = 'settings.ini')
	{
		if (self::$_instance === null) {
			self::$_instance = new ConfigParser();
			self::$_instance->setConfig($configFolder, $configFile);
		}

		return self::$_instance;
	}
}