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

		$this->view->pageTitle = 'User&lsquo;s Photos';

		$dataAlbums = new Models\Albums();
		$dataPhotos = new Models\Photos();

		$userid = $this->requireLogin();

		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$albumId = $this->input->get(0);
		}else{
			@header("Location:/myalbums/");
		}

		/**
		 * Actions -->
		 */

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			/**
			 * ADD ALBUM
			 */
			if ($this->input->post('action') == 'addfile') {

				$photoName = $this->input->post('name');
				$validate->setRule('alphabetspace',$photoName);
				$validate->setRule('minlength',$photoName,2,'minlength');
				$validPhotoName = $validate->validate();

				if($validPhotoName == true){

					$a = $dataPhotos->addPhoto($userid, $albumId, $photoName, $_FILES);
					if ($a != false && is_numeric($a)) {
						$this->AddNoticeMessage('Photo added!');
					} else {
						$this->AddErrorMessage('Failed to add photo, maybe photo with that name already exist!');
					}

				}else{
					$this->AddErrorMessage('Add valid Photo name ! Must be a word, no special symbols and number.');
				}
			}
		}


		/**
		 * Views --->
		 */
		$this->view->userAlbums = $dataAlbums->getLatestAlbums($userid);
		$this->view->userPhotos = $dataPhotos->getPhotosByAlbum($albumId, $userid);

		$this->view->appendToLayout('body','loggedin/my-photos');

		$this->view->display('layouts/default',
			array('menuName' => 'myalbums', 'errors' => $this->errors));
	}


	public function del(){

		$this->view->pageTitle = 'User&lsquo;s Photos';

		$dataPhotos = new Models\Photos();

		$userid = $this->requireLogin();

		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$photoId = $this->input->get(0);
		}else{
			@header("Location:/myalbums/");
		}

		if ($photoId > 0) {
			$del = $dataPhotos->delPhoto($userid, $photoId);
			if(is_numeric($del) && $del > 0){
				@header("Location:/myphotos/viewalbum/".$del);
			}else{
				@header("Location:/myalbums/");
			}
		}
	}
}