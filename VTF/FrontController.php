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
	public $ns = null;
	public $controller = null;
	public $method = null;
	private $router = null;

	public function setRouter (Routers\IRouter $router)
	{
		$this->router = $router;
	}

	public function getRouter ()
	{
		return $this->router;
	}


	/**
	 * Dispatch method.
	 */
	public function dispatch()
	{
		if($this->router == null)
		{
			throw new \Exception('Set router first !');
		}

		$_url = $this->router->getURI();

		$route = null;

		$configObj = App::getInstance()->getConfig();
		$routes = $configObj->routes;

		$urlBase = @explode(DIRECTORY_SEPARATOR,$_url);
		$userSetController = null;

		if($routes !== null && is_array($routes) && count($routes) > 0){
			if(isset($urlBase[0]) && !empty($urlBase[0])) {
				foreach ($routes as $k => $route) {
					if ($urlBase[0] == $k) {
						@array_shift($urlBase);
						$this->ns = $route['namespace'];
						if(isset($route['controller'])){
							$userSetController = $route['controller'];
						}
						break;
					}
				}
			}
		}else{
			//TODO: error handler
			throw new \Exception('Routes Config file not found');
		}

		if($this->ns == null && isset($routes['*']['namespace'])){
			$this->ns = $routes['*']['namespace'];
			if(isset($routes['*']['controller']))$userSetController = $routes['*']['controller'];
		}else if(!isset($routes['*']['namespace'])){
			//TODO handle Errors.
			throw new \Exception('Default Routes missing!');
		}


		if(isset($urlBase[0]) && !empty($urlBase[0]) ){
			$this->controller = strtolower($urlBase[0]);
			if(isset($urlBase[1]) && !empty($urlBase[1])){
				$this->method = strtolower($urlBase[1]);
			}else{
				$this->method = $this->getDefaultMethod();
			}
		}else{
			$this->controller = $this->getDefaultController();
			$this->method = $this->getDefaultMethod();
		}

		if($userSetController != null){
			if(isset($userSetController[$this->controller]['method'][$this->method])){
				$this->method = strtolower($userSetController[$this->controller]['method'][$this->method]);
			}

			if(isset($userSetController[$this->controller]['changeto']))
				$this->controller = strtolower($userSetController[$this->controller]['changeto']);

		}

		$callController = null;
		$callMethod = null;
		$controllerToLoad = $this->ns.'\\'.ucfirst($this->controller);

		if(class_exists($controllerToLoad)) {
			$callController = new $controllerToLoad();
		}else{
			//TODO handle Errors.
			throw new \Exception('Missing Controller');
		}


		if($callController != null && method_exists($callController,$this->method)) {
			$callMethod = $callController->{$this->method}();
		}else{
			//TODO handle Errors.
			throw new \Exception('Method doesnt Exist yet');
		}

	}

	public function getDefaultController ()
	{
		$config = App::getInstance()->getConfig();
		if(isset($config->app['default_controller'])){
			return strtolower($config->app['default_controller']);
		}
		return 'Index';
	}

	public function getDefaultMethod ()
	{
		$config = App::getInstance()->getConfig();
		if(isset($config->app['default_method'])){
			return strtolower($config->app['default_method']);
		}
		return 'index';
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