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



		$this->totalPhotos = $data->getTotalPhotos();

		$view = View::getInstance();
		$view->title = 'Vasil Tsintsev&lsquo;s Gallery';
		$view->searchString = '';
		$view->latestPhotos = $data->getLatestPhotos();
		$view->photoObj =  new Models\Photo();


		$view->appendToLayout('header','header');
		$view->appendToLayout('body','index');
		$view->appendToLayout('footer','footer');
		$view->display('layouts/default', array('menuName'=>'photos'));
	}
}