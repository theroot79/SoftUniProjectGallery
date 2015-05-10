<?php

namespace Controllers;

use Models;

class Albums extends Base
{
	public function index(){

		$this->view->pageTitle = 'Albums';

		$data = new Models\Albums();

		$this->view->totalAlbumss = $data->getTotalAlbums();
		$this->view->latestAlbums = $data->getLatestAlbums();

		$this->view->appendToLayout('body','albums');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}
}