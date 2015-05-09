<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;

class Index extends DefaultController
{
	public function index(){

		//$validate = new Validation();
		//$validate->setRule('minlength','test',20,'minlength');
		//var_dump($validate->validate());


		$view = View::getInstance();
		$view->title = 'Test';
		$view->appendToLayout('header','header');
		$view->appendToLayout('body','index');
		$view->appendToLayout('footer','footer');
		$view->display('layouts/default');
	}

}