<?php

namespace Controllers\Admin;

use Models;
use \VTF\Validation;

class Albums extends \Controllers\Base
{
	public function index(){

		$this->view->pageTitle = 'Admin - Manage Albums';

		$dataAlbums = new Models\Albums();
		$dataCategories = new Models\Categories();
		$user = $this->auth->user();

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			if ($this->input->post('action') == 'addalbum') {

				$albumName = $this->input->post('name');
				$validate->setRule('alphabetspace', $albumName);
				$validate->setRule('minlength', $albumName, 2, 'minlength');
				$validAlbumName = $validate->validate();

				if ($validAlbumName == true) {

					$a = $dataAlbums->addAlbum($user['uid'], $albumName);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Album - created!');
					} else {
						$this->AddErrorMessage('Failed to add album, maybe already exist!');
					}

				} else {
					$this->AddErrorMessage('Add valid Album name ! Must be a word, no special symbols and number.');
				}
			}
		}

		$this->view->albums = $dataAlbums->getLatestAlbums();
		$this->view->categories = $dataCategories->getAllCategories();

		$this->view->appendToLayout('body','admin/albums');


		$this->view->display('layouts/admin',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}

	public function del(){

		$dataAlbums = new Models\Albums();

		$adminid = $this->requireAdmin();

		if($adminid < 1)return;

		$albumid = 0;

		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$albumid = intval($this->input->get(0));
		}else{
			@header("Location:/admin/albums");
		}

		$dataAlbums->delAlbumByAdmin($albumid);
		@header("Location:/admin/albums");
	}
}