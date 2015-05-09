<?php

namespace VTF\Sessions;

/**
 * Implementation of native session support
 *
 * Class NativeSessions
 * @package VTF\Sessions
 */
class NativeSession implements ISession
{

	public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false)
	{
		if (empty($name)) {
			$name = '_sess';
		}

		session_name($name);
		session_set_cookie_params($lifetime, $path, $domain, $secure, true);
		session_start();
	}

	public function getSessionId()
	{
		return session_id();
	}

	public function saveSessionId()
	{
		session_write_close();
	}

	public function saveSession()
	{
		session_write_close();
	}

	public function destroySessionId()
	{
		session_destroy();
	}

	public function __get($name)
	{
		if (!isset($_SESSION[$name])) $_SESSION[$name] = null;
		return $_SESSION[$name];
	}

	public function __set($name, $value)
	{
		$_SESSION[$name] = $value;
	}
}