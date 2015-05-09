<?php

namespace VTF;

/**
 * Autoloads Classes.
 *
 * Class AutoLoader
 * @package VTF
 */
final class AutoLoader
{
	/**
	 * @var array
	 */
	private $documentRoot = '';

	/**
	 * @param $class
	 * @return bool
	 * @throws \Exception File/Class not found.
	 */
	public function loadClass($class)
	{
		if(empty($this->documentRoot)){
			throw new \Exception(' Document Root not set! ', 500);
		}
		$class = @str_replace("\\",DIRECTORY_SEPARATOR,$class);

		$file = $this->documentRoot.DIRECTORY_SEPARATOR.$class.'.php';

		if ($file !== null && !empty($file) && file_exists($file)) {
			require $file;
		}else{
			throw new \Exception(' File / Class : ' . $file .' not found !', 500);
		}

		return true;
	}

	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param $documentRoot string
	 */
	public function register($documentRoot = '')
	{
		$this->documentRoot = $documentRoot;
		spl_autoload_register(array($this, 'loadClass'), true, false);
	}

	/**
	 * Removes this instance from the registered autoloaders.
	 */
	public function unregister()
	{
		spl_autoload_unregister(array($this, 'loadClass'));
	}
}