<?php

namespace Controllers;

use Models;
use \VTF\Validation;

class Profile extends Base
{

	public function index(){

		$this->view->pageTitle = 'User Profile';

		if($this->input->hasPostReques() && $this->input->hasPost('action'))
		{
			$validate = new Validation();

			if(($this->input->hasPost('action') == true) && ($this->input->post('action') == 'update')){

				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$password = $this->input->post('password');

				$validate->setRule('alphabet',$fname);
				$validate->setRule('minlength',$fname,4,'fname');
				$validFname = $validate->validate();

				$validate->clearRules();

				$validate->setRule('alphabet',$lname);
				$validate->setRule('minlength',$lname,4,'lname');
				$validLname = $validate->validate();

				$validate->clearRules();

				if(!empty($password)) {
					$validate->setRule('minlength', $password, 4, 'minlength');
					$validPass = $validate->validate();
				}else{
					$validPass = true;
				}

				if($validFname == true && $validLname == true && $validPass == true) {

					$u = $this->auth->updateProfile($fname, $lname, $password);
					if ($u != false && $u >= 0) {
						@header("Location:/profile/");
					} else {
						$this->AddErrorMessage($u);
					}
				}else{
					if($validFname == false)$this->AddErrorMessage('Please enter valid First Name!');
					if($validLname == false)$this->AddErrorMessage('Please enter valid Last Name!');
					if($validPass == false)$this->AddErrorMessage('Please enter valid password, min length 4!');
				}
			}
		}

		$this->view->appendToLayout('body','profile');

		$this->view->display('layouts/default',
			array('menuName'=>'singup','var' => $this->view, 'errors' => $this->errors));
	}
}