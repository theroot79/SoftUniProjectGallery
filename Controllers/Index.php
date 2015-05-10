<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Index extends Base
{
	public function index(){

		$data = new Models\Photos();

		$this->totalPhotos = $data->getTotalPhotos();

		$view = View::getInstance();
		$view->title = 'Vasil Tsintsev&lsquo;s Gallery';
		$view->searchString = '';
		$view->latestPhotos = $data->getLatestPhotos();


		$view->appendToLayout('body','index');
		$view->display('layouts/default',
			array('menuName'=>'singup','errors' => $this->errors));
	}

	public function fnf404($ctrl){

		$view = View::getInstance();
		$view->ctrl = $ctrl;
		$view->appendToLayout('body','errors/404');
		$view->display('layouts/default', array('menuName'=>'404','errors' => ''));
	}
}