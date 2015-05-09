<?php

namespace VTF\Routers;

/**
 * Json-RPC Router
 *
 * Class JsonRPCRouter
 * @package VTF\Routers
 */
class JsonRPCRouter implements IRouter
{
	private $_map = array();
	private $_postParams = array();
	private $_requestId;

	public function __construct()
	{
		if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_SERVER['CONTENT_TYPE']) ||
			$_SERVER['CONTENT_TYPE'] != 'application/json'
		) {
			throw new \Exception('Require json request!', 400);
		}
	}

	/**
	 * Parses the URI.
	 */
	public function getURI()
	{
		if (!is_array($this->_map) || count($this->_map) == 0) {
			$app = \VTF\App::getInstance();
			if (isset($app->getConfig()->rpcRouters)) {
				$rpcRouterConfig = $app->getConfig()->rpcRouters;
				if (is_array($rpcRouterConfig) && count($rpcRouterConfig) > 0) {
					$this->_map = $rpcRouterConfig;
				} else {
					throw new \Exception('Router requires method map/config for Json-RPC', 400);
				}
			}
		}

		$request = json_decode(file_get_contents('php://input'), true);
		if (is_array($request) == false || !isset($request['method'])) {
			throw new \Exception('Require JSON request', 400);
		} else {
			if ($this->_map[$request['method']]) {
				if (isset($request['id'])) $this->_requestId = intval($request['id']);
				if (isset($request['params'])) $this->_postParams = $request['params'];

				return $this->_map[$request['method']];
			} else {
				throw new \Exception('JSON method not found', 400);
			}
		}
	}

	public function getRequestId()
	{
		return $this->_requestId;
	}

	public function getPost()
	{
		return $this->_postParams;
	}

	public function setMethodsMap($arr)
	{
		if (is_array($arr)) {
			$this->_map = $arr;
		}
	}
}