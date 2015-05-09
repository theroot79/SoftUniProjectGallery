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
	/**
	 * @var \VTF\InputData
	 */
	private static $_instance = null;

	/**
	 * @var Array
	 */
	private $_get = null;

	/**
	 * @var Array
	 */
	private $_post = null;

	/**
	 * @var Array
	 */
	private $_cookies = null;

	public function __construct()
	{
		$this->_cookies = $_COOKIE;
		$this->setPost($_POST);
		$this->setGet($_GET);
	}

	/**
	 * Sets _POST data.
	 *
	 * @param $post array
	 */
	public function setPost($post)
	{
		if (is_array($post))
			$this->_post = $post;
	}

	/**
	 * Sets _GET data
	 * @param $get array
	 */
	public function setGet($get)
	{
		if (is_array($get)) {
			$this->_get = $get;
		}
	}

	/**
	 * Checks for POST parameter
	 *
	 * @param $post string
	 * @return bool
	 */
	public function hasPost($post)
	{
		return array_key_exists($post, $this->_post);
	}

	/**
	 * Checks does cookie exists based on key.
	 *
	 * @param $cookie string
	 * @return bool
	 */
	public function hasCookie($cookie)
	{
		return array_key_exists($cookie, $this->_cookies);
	}

	/**
	 * Checks does _GET exists based on key.
	 *
	 * @param $get string
	 * @return bool
	 */
	public function hasGet($get)
	{
		return array_key_exists($get, $this->_get);
	}

	/**
	 * Reads value from the collected _GET data
	 *
	 * @param $key string Key for _GET array of data
	 * @param null $normalize
	 * @param null $default Default value to return
	 * @return bool|float|int|mixed|null
	 */
	public function get($key, $normalize = null, $default = null)
	{
		if ($this->hasGet($key)) {
			if ($normalize !== null) {
				return Common::normalize($this->_get[$key], $normalize);
			}
			return $this->_get[$key];

		}

		return $default;
	}

	/**
	 * Reads value from the collected _POST data
	 *
	 * @param $name
	 * @param null $normalize
	 * @param null $default
	 * @return bool|float|int|mixed|null
	 */
	public function post($name, $normalize = null, $default = null)
	{
		if ($this->hasPost($name)) {
			if ($normalize !== null) {
				return Common::normalize($this->_post[$name], $normalize);
			}
			return $this->_post[$name];

		}
		return $default;
	}

	/**
	 * Reads value from the collected _COOKIE data
	 *
	 * @param $name
	 * @param null $normalize
	 * @param null $default
	 * @return bool|float|int|mixed|null
	 */
	public function cookie($name, $normalize = null, $default = null)
	{
		if ($this->hasCookie($name)) {
			if ($normalize !== null) {
				return Common::normalize($this->_cookies[$name], $normalize);
			}
			return $this->_cookies[$name];

		}
		return $default;
	}

	/**
	 * Another singleton class.
	 *
	 * @return InputData
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new InputData();
		}

		return self::$_instance;
	}
}