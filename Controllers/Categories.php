<?php

namespace Controllers;

use Models;
use \Lib\Paging;


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

	public function view(){

		$this->view->pageTitle = 'Categories';

		$dataCategories = new Models\Categories();
		$dataAlbums = new Models\Albums();

		$cid = 0;

		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$cid = intval($this->input->get(0));
		}else{
			@header("Location:/categories");
		}

		if($this->input->hasGet(1)){
			if($this->input->get(1) == 'page' && is_numeric($this->input->get(2))){
				$this->page = intval($this->input->get(2));
			}
		}

		$this->view->categories = $dataCategories->getAllCategories();
		$this->view->category = $this->view->categories[$cid];

		$this->total = @count($dataAlbums->getAlbumsByCategory($cid));
		$this->view->albums = $dataAlbums->getAlbumsByCategory($cid, $this->page, $this->offset);

		$paging = '';

		if($this->total > $this->offset) {
			$pagingObj = new Paging();
			$paging = $pagingObj->display($this->total,$this->page, $this->offset,'/categories/view/'.$cid);
		}


		$this->view->appendToLayout('body','bycategory');

		$this->view->display('layouts/default',
			array('menuName' => 'categories', 'paging'=>$paging, 'errors' => $this->errors));
	}
}