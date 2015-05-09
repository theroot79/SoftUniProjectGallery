<?php


namespace Controllers;

class Index
{
	public function index(){

		$view = \VTF\View::getInstance();
		$view->title = 'Test';
		$view->appendToLayout('header','header');
		$view->appendToLayout('body','index');
		$view->appendToLayout('footer','footer');
		$view->display('layouts/default');
	}

}