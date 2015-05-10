<?php

namespace Controllers;

use Models;
use \VTF\Validation;

class Photo extends Base
{
	public function index(){
		@header("Location:/");
	}

	public function view(){

		$albumId = 0;$photoId = 0;
		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$photoId = $this->input->get(0);
		}else{
			@header("Location:/");
		}

		$dataPhotos = new Models\Photos();
		$dataAlbums = new Models\Albums();
		$dataComments = new Models\Comments();

		$this->view->photo = $dataPhotos->getPhotoById($photoId);
		$albumId = $this->view->photo['aid'];

		$this->view->pageTitle = 'Photo '.$this->view->photo['name'];

		$this->view->album = $dataAlbums->getAlbumData($albumId);


		/**
		 * Actions -->
		 */

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			/**
			 * ADD COMMENT
			 */
			if ($this->input->post('action') == 'addcomment') {

				$name = $this->input->post('name');
				$comment = $this->input->post('comment','string');

				$validate->setRule('minlength',$name,4,'minlength');
				$validate->setRule('alphabetspace',$name);
				$validName = $validate->validate();

				$validate->clearRules();
				$validate->setRule('minlength',$comment,5,'minlength');
				$validComment = $validate->validate();

				if($validName == true && $validComment == true) {

					$u = $dataComments->addComments($albumId,$photoId,$name, $comment);

					if ($u != false && ($u > 0)) {
						$this->AddNoticeMessage('Comment added !');
					} else {
						$this->AddErrorMessage('Failed to add comment');
					}
				}else{
					if($validName == false)$this->AddErrorMessage('Please enter valid name');
					if($validComment == false)$this->AddErrorMessage('Please enter valid comment');
				}
			}
		}


		/**
		 * <-- End of actions
		 */

		$this->view->comments = $dataComments->getComments($albumId, $photoId);
		$this->view->appendToLayout('body','photo');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}
}