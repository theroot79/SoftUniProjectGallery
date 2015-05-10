<?php

namespace Controllers;

use Models;
use \Lib\Paging;

class Albums extends Base
{
	public function index(){
		@header("Location:/albums/view");
	}

	public function view(){

		$this->view->pageTitle = 'Albums';

		$dataAlbums = new Models\Albums();

		$this->total = $dataAlbums->getTotalAlbums();

		if($this->input->hasGet(0)){
			if($this->input->get(0) == 'page' && is_numeric($this->input->get(1))){
				$this->page = intval($this->input->get(1));
				if($this->page < 0)$this->page = 0;
				if($this->page > ($this->total - 1)) $this->page = 0;
			}
		}

		$this->view->latestAlbums = $dataAlbums->getLatestAlbums(0,$this->page,$this->offset);

		$paging = '';
		if($this->total > $this->offset) {
			$pagingObj = new Paging();
			$paging = $pagingObj->display($this->total,$this->page, $this->offset,'/albums/view');
		}

		$this->view->appendToLayout('body','albums');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'paging'=>$paging, 'errors' => $this->errors));
	}
}