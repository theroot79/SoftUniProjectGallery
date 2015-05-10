<?php

namespace Controllers;

use Models;

class Search extends Base
{
	public function index(){

		$this->view->pageTitle = 'Albums';
		$searchStr = '';

		if($this->input->hasPost('search') == false){
			@header("Location:/");
		}

		if($this->input->post('search')){
			$searchStr = $this->input->post('search');
		}else{
			@header("Location:/");
		}


		$dataAlbums = new Models\Albums();
		$dataCategories = new Models\Categories();

		$this->view->categories = $dataCategories->getAllCategories();
		$this->view->albums = $dataAlbums->searchAlbums($searchStr);

		$this->view->appendToLayout('body','search');

		$this->view->display('layouts/default',
			array('menuName' => 'search', 'errors' => $this->errors));
	}
}