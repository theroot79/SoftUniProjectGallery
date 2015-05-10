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

		$albumId = 0;
		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$albumId = $this->input->get(0);
		}else{
			@header("Location:/");
		}

		$dataAlbums = new Models\Albums();
		$dataPhotos = new Models\Photos();
		$dataComments = new Models\Comments();
		$dataVotes = new Models\Votes();

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
				$validate->setRule('minlength',$comment,10,'minlength');
				$validComment = $validate->validate();

				if($validName == true && $validComment == true) {

					$u = $dataComments->addComments($albumId,0,$name, $comment);

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

		$this->view->album = $dataAlbums->getAlbumData($albumId);
		$this->view->pageTitle = 'Album '.$this->view->album['name'];
		$this->view->photos = $dataPhotos->getPhotosByAlbum($albumId);
		$this->view->comments = $dataComments->getComments($albumId);
		$this->view->appendToLayout('body','photo');

		$this->view->display('layouts/default',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}
}