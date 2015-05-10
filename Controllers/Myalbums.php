<?php

namespace Controllers;

use Models;
use \VTF\Validation;

class Myalbums extends Base
{
	public function index(){

		$this->view->pageTitle = 'User&lsquo;s Albums';

		$dataAlbums = new Models\Albums();
		$dataCategories = new Models\Categories();

		$userid = 0;
		if(isset($this->view->user['uid'])){
			$userid = intval($this->view->user['uid']);
		}
		if($userid < 1)header("Location:/signup/");

		/**
		 * Actions -->
		 */

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			/**
			 * ADD ALBUM
			 */
			if ($this->input->post('action') == 'addalbum') {

				$albumName = $this->input->post('name');
				$validate->setRule('alphabetspace',$albumName);
				$validate->setRule('minlength',$albumName,2,'minlength');
				$validAlbumName = $validate->validate();

				if($validAlbumName == true){

					$a = $dataAlbums->addAlbum($userid, $albumName);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Album - created!');
					} else {
						$this->AddErrorMessage('Failed to add album, maybe already exist!');
					}

				}else{
					$this->AddErrorMessage('Add valid Album name ! Must be a word, no special symbols and number.');
				}
			}

			/**
			 * ADD CATEGORY
			 */
			if ($this->input->post('action') == 'add-category') {

				$catName = $this->input->post('name');
				$validate->setRule('alphabetspace',$catName);
				$validate->setRule('minlength',$catName,2,'minlength');
				$validCatName = $validate->validate();

				if($validCatName == true){
					$a = $dataCategories->addCategory($userid, $catName);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Category - created!');
					} else {
						$this->AddErrorMessage('Failed to add category, maybe already exist!');
					}
				}else{
					$this->AddErrorMessage('Add valid Category name ! Must be a word, no special symbols and number.');
				}
			}

			/**
			 * EDIT CATEGORY
			 */
			if ($this->input->post('action') == 'edit-category') {

				$catId = $this->input->post('category','number',1);

				$catName = $this->input->post('name');
				$validate->setRule('alphabetspace',$catName);
				$validate->setRule('minlength',$catName,2,'minlength');
				$validCatName = $validate->validate();

				if($validCatName == true){
					$a = $dataCategories->editCategory($catId, $catName);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Category - edited!');
					} else {
						$this->AddErrorMessage('Failed to edit category, maybe same name already exist!');
					}
				}else{
					$this->AddErrorMessage('Enter valid Category name ! Must be a word, no special symbols and number.');
				}

			}

			/**
			 * DELETE CATEGORY
			 */
			if ($this->input->post('action') == 'del-category') {

				$catId = $this->input->post('category','number',1);

				$a = $dataCategories->delCategory($catId);
				if ($a != false && is_numeric($a)) {
					$this->AddNoticeMessage('Category - deleted!');
				} else {
					$this->AddErrorMessage('Failed to delete category!');
				}

			}
		}


		/**
		 * Views --->
		 */
		$this->view->userAlbums = $dataAlbums->getLatestAlbums($userid);
		$this->view->userCategories = $dataCategories->getAllCategories();

		$this->view->appendToLayout('body','loggedin/myalbums');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}


	public function edit(){

		$this->view->pageTitle = 'Edit User&lsquo;s Albums';

		$dataAlbums = new Models\Albums();
		$dataCategories = new Models\Categories();
		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$albumId = $this->input->get(0);
		}else{
			@header("Location:/myalbums/");
		}

		$userid = 0;
		if(isset($this->view->user['uid'])){
			$userid = intval($this->view->user['uid']);
		}
		if($userid < 1)header("Location:/signup/");

		/**
		 * Actions -->
		 */

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			$tmpAlbum = $dataAlbums->getAlbumData($albumId);

			/**
			 * EDIT ALBUM
			 */
			if ($this->input->post('action') == 'editalbum') {

				$catId = $this->input->post('category','number',1);

				$albumName = $this->input->post('name');
				$validate->setRule('alphabetspace',$albumName);
				$validate->setRule('minlength',$albumName,2,'minlength');
				$validAlbumName = $validate->validate();

				if($validAlbumName == true){
					$a = $dataAlbums->editAlbum($albumId, $catId, $albumName, $tmpAlbum['name']);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Album - edited!');
					} else {
						$this->AddErrorMessage('Failed to edit Album,
												maybe same name already exist, or no changes detected!');
					}
				}else{
					$this->AddErrorMessage('Enter valid Album name ! Must be a word, no special symbols and number.');
				}

			}
		}


		/**
		 * Views --->
		 */
		$this->view->album = $dataAlbums->getAlbumData($albumId);
		$this->view->userCategories = $dataCategories->getAllCategories();

		$this->view->appendToLayout('body','loggedin/edit-albums');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}

	public function del(){

		$this->view->pageTitle = 'Delete User&lsquo;s Albums';
		$albumId = 0;

		$dataAlbums = new Models\Albums();
		$dataCategories = new Models\Categories();
		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$albumId = $this->input->get(0);
		}else{
			@header("Location:/myalbums/");
		}

		$userid = 0;
		if(isset($this->view->user['uid'])){
			$userid = intval($this->view->user['uid']);
		}
		if($userid < 1)header("Location:/signup/");

		/**
		 * Actions -->
		 */

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			/**
			 * DEL ALBUM
			 */
			if ($this->input->post('action') == 'delalbum') {

				$a = $dataAlbums->delAlbum($albumId, $this->auth->user());
				if ($a != false && is_numeric($a)) {
					@header("Location:/myalbums/");
				} else {
					$this->AddErrorMessage('Failed to delete Album, probably you are not allowed!');
				}

			}
		}


		/**
		 * Views --->
		 */
		$this->view->album = $dataAlbums->getAlbumData($albumId);
		$this->view->userCategories = $dataCategories->getAllCategories();

		$this->view->appendToLayout('body','loggedin/del-albums');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}
}