<?php

namespace Controllers;

use Models;
use \VTF\Validation;

class Myphotos extends Base
{
	public function index(){
		@header("Location:/myalbums/");
	}


	public function viewalbum(){

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

		}


		/**
		 * Views --->
		 */
		$this->view->userAlbums = $dataAlbums->getLatestAlbums($userid);
		$this->view->userCategories = $dataCategories->getAllCategories();

		$this->view->appendToLayout('body','loggedin/my-photos');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}


}