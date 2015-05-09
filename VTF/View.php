<?php

namespace VTF;

/**
 * View management.
 *
 * Class View
 * @package VTF
 */
class View
{
	private static $_instance = null;
	private $data = array();
	private $viewPath = null;
	private $viewDir = null;
	private $_layoutComponents = array();
	private $_layoutData = array();
	private $extension = '.php';

	private function __construct()
	{
		if (isset(App::getInstance()->getConfig()->app['viewDirectory'])) {
			$viewPath = App::getInstance()->getConfig()->app['viewDirectory'];
			if(!empty($viewPath)) $this->viewPath = $viewPath;
		}else{
			$this->viewPath = realpath(SITE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
		}
	}

	/**
	 * Creates instance of view class
	 *
	 * @return View
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new \VTF\View();
		}
		return self::$_instance;
	}

	/**
	 * Save another not-standart view directory
	 *
	 * @param $path
	 * @throws \Exception
	 */
	public function setViewDirectory($path)
	{
		$path = trim($path);
		if ($path !== null && !empty($path)) {
			$path = realpath($path) . DIRECTORY_SEPARATOR;

			if (is_dir($path) && is_readable($path)) {
				$this->viewDir = $path;
			} else {
				throw new \Exception('view path problem.');
			}
		} else {
			throw new \Exception('view path can not be set.');
		}
	}

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		if(isset($this->data[$name])) {
			return $this->data[$name];
		}else{
			throw new \Exception('Missing variable: '.$name);
		}
	}

	public function display($name, $data = array(), $returnAsString = false){

		if(is_array($data) && count($data) > 0){
			$this->data = array_merge($this->data, $data);
		}

		if(count($this->_layoutComponents) > 0){
			foreach ( $this->_layoutComponents as $k => $component){
				$fToInc = $this->_includeFile($component);
				if($fToInc !== null){
					$this->_layoutData[$k] = $fToInc;
				}
			}
		}

		if($returnAsString == true){
			return $this->_includeFile($name);
		}else{
			print $this->_includeFile($name);
		}
	}

	private function _includeFile($file)
	{
		if($this->viewDir == null){
			$this->setViewDirectory($this->viewPath);
		}

		$__fpath = $this->viewDir . str_replace('/',DIRECTORY_SEPARATOR, $file) . $this->extension;

		if(file_exists($__fpath) && is_readable($__fpath)){
			ob_start();
			include $__fpath;
			return ob_get_clean();
		}else{
			throw new \Exception('View '.$file.' can not be included');
		}
	}

	public function getLayoutData($key)
	{
		if(isset($this->_layoutData[$key])){
			return $this->_layoutData[$key];
		}else{
			throw new \Exception('There is no layout component: '.$key.' !');
		}
	}

	public function appendToLayout($key, $template)
	{
		if($key !== null & $template !== null){
			$this->_layoutComponents[$key] = $template;
		}else{
			throw new \Exception('Layout requires valid key and template.');
		}

	}
}