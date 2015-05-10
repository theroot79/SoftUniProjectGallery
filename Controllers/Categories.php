<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Categories extends DefaultController
{

	private $dataAlbums;
	private $dataPhotos;

	public function __construct(){

		$this->dataAlbums = new Models\Albums();
		$this->dataPhotos = new Models\Photos();

	}

	public function index(){

		$view = View::getInstance();
		$view->title = 'Vasil Tsintsev&lsquo;s Gallery';
		$view->searchString = '';


		$view->appendToLayout('body','index');
		$view->display('layouts/default', array('menuName'=>'photos'));
	}
}