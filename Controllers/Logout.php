<?php

namespace Controllers;

use Models;

class Logout extends Base
{

	public function index()
	{

		$this->auth->logout();

		@header("Location:/");

	}
}