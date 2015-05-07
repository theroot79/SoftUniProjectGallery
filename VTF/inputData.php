<?php

namespace VTF;

/**
 * Proceeds the input data.
 *
 * Class InputData
 * @package VTF
 */
class InputData
{

	private static $_instance = null;
	private $_get = null;
	private $_post = null;
	private $_cookies = null;

	public function __construct()
	{
		$this->_cookies = $_COOKIE;
		$this->setPost($_POST);
		$this->setGet($_GET);
	}


	public function setPost($post)
	{
		if(is_array($post))
			$this->_post = $post;
	}

	public function setGet($get)
	{
		if(is_array($get)){
			$this->_get = $get;
		}
	}

	public function hasPost($post)
	{
		return array_key_exists($post,$this->_post);
	}

	public function hasCookie($cookie)
	{
		return array_key_exists($cookie,$this->_cookies);
	}

	public function hasGet($get)
	{
		return array_key_exists($get,$this->_get);
	}

	public function get($id, $normalize = null, $default = null)
	{
		if($this->hasGet($id)){
			if($normalize !== null){
				return Common::normalize($this->_get[$id], $normalize);
			}
			return $this->_get[$id];

		}

		return $default;
	}

	public function post($name, $normalize = null, $default = null)
	{
		if($this->hasPost($name)){
			if($normalize !== null){
				return Common::normalize($this->_post[$name], $normalize);
			}
			return $this->_post[$name];

		}
		return $default;
	}

	public function cookie($name, $normalize = null, $default = null)
	{
		if($this->hasCookie($name)){
			if($normalize !== null){
				return Common::normalize($this->_cookies[$name], $normalize);
			}
			return $this->_cookies[$name];

		}
		return $default;
	}

	/**
	 * Another singleton class.
	 *
	 * @return null|App
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new App();
		}

		return self::$_instance;
	}
}