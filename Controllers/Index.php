<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Index extends Base
{
	public function index(){

		$dataPhotos = new Models\Photos();
		$dataAlbums = new Models\Albums();

		$this->view->pageTitle = 'Vasil Tsintsev&lsquo;s Gallery';

		$this->view->albums = $dataAlbums->getLatestAlbums();
		$this->view->photos = $dataPhotos->getLatestPhotos();


		$this->view->appendToLayout('body','index');
		$this->view->display('layouts/default',
			array('menuName'=>'singup','errors' => $this->errors));
	}



	public function fnf404($ctrl){

		$view = View::getInstance();
		$view->ctrl = $ctrl;
		$view->appendToLayout('body','errors/404');
		$view->display('layouts/default', array('menuName'=>'404','errors' => ''));
	}
}