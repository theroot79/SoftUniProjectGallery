<?php

namespace VTF\Sessions;

interface ISession
{
	public function getSessionId();

	public function saveSessionId();

	public function destroySessionId();

	public function __get($name);

	public function __set($name, $value);
}