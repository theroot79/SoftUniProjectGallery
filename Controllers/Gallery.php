<?php

namespace Controllers;

use Models;
use \Lib\Paging;

class Gallery extends Base
{
	public function index(){
		@header("Location:/gallery/view/");
	}

	public function view(){

		$this->view->pageTitle = 'Gallery';

		$dataPhotos = new Models\Photos();
		$this->total = $dataPhotos->getTotalPhotos();

		if($this->input->hasGet(0)){
			if($this->input->get(0) == 'page' && is_numeric($this->input->get(1))){
				$this->page = intval($this->input->get(1));
				if($this->page < 0)$this->page = 0;
				if($this->page > ($this->total - 1)) $this->page = 0;
			}
		}

		$this->view->photos = $dataPhotos->getLatestPhotos($this->page,$this->offset);

		$this->view->appendToLayout('body','gallery');

		$paging = '';
		if($this->total > $this->offset) {
			$pagingObj = new Paging();
			$paging = $pagingObj->display($this->total,$this->page, $this->offset,'/gallery/view');
		}

		$this->view->display('layouts/default',
			array('menuName' => 'photos','paging'=>$paging, 'errors' => $this->errors));
	}
}