<?php

namespace Controllers;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Albums extends Base
{
	public function index(){

		//$validate = new Validation();
		//$validate->setRule('minlength','test',20,'minlength');
		//var_dump($validate->validate());

		$data = new Models\Albums();

		$this->totalAlbumss = $data->getTotalAlbums();

		$view = View::getInstance();
		$view->title = 'Vasil Tsintsev&lsquo;s Gallery | Albums';
		$view->searchString = '';
		$view->latestAlbums = $data->getLatestAlbums();
		$view->albumObj =  new Models\Album();


		$view->appendToLayout('body','albums');

		$view->display('layouts/default',
			array('menuName' => 'singup', 'var' => $this->view, 'errors' => $this->errors));
	}
}