<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Categories extends Base
{

	public function index(){

		$this->view->pageTitle = 'Categories';

		$dataCategories = new Models\Categories();
		$dataAlbums = new Models\Albums();

		$this->view->categories = $dataCategories->getAllCategories();

		$this->view->albums = $dataAlbums->getAlbumsByCategory();

		$this->view->appendToLayout('body','categories');

		$this->view->display('layouts/default',
			array('menuName' => 'categories', 'errors' => $this->errors));
	}
}