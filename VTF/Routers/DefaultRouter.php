<?php

namespace VTF\Routers;

/**
 * Main URL router
 *
 * Class DefaultRouter
 * @package VTF\Routers
 */
class DefaultRouter implements IRouter
{

	/**
	 * Parses the URI.
	 */
	public function getURI()
	{
		$_url = substr(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']), 1);
		$_url .= $_SERVER['REQUEST_URI'];
		$_url = ltrim($_url, DIRECTORY_SEPARATOR);
		return $_url;
	}

	public function getPOST()
	{
		return $_POST;
	}
}