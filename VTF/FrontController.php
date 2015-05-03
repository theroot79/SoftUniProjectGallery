<?php

namespace VTF;

/**
 * Application Front Controller
 *
 * Class FrontController
 * @package VTF
 */
class FrontController
{
	private static $_instance = null;

	public function dispatch()
	{

		$router = new Routers\DefaultRouter();
		$router->parse();
	}

	/**
	 * Front Controller Instance creator
	 *
	 * @return \VTF\FrontController
	 */
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new FrontController();
		}

		return self::$_instance;
	}
}