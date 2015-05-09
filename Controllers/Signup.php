<?php

namespace Controllers;

use Models;
use \VTF\Validation;

class SignUp extends Base
{

	public function index()
	{

		$this->view->pageTitle = 'Sign Up';

		if ($this->input->hasPostReques() && $this->input->hasPost('action')) {

			$validate = new Validation();

			/**
			 * LOGIN PROCEDURE
			 */
			if (($this->input->hasPost('action') == true) && ($this->input->post('action') == 'login')) {

				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$validMail = $validate->email($email);

				$validate->setRule('minlength',$password,4,'minlength');
				$validPass = $validate->validate();

				if($validMail == true && $validPass == true) {

					$u = $this->auth->login($email, $password);
					if ($u != false && is_array($u)) {
						$this->view->user = $u;
						$this->view->loggedin = true;
						@header("Location:/");
					} else {
						$this->AddErrorMessage('Wrong email/password !');
					}
				}else{
					if($validMail == false)$this->AddErrorMessage('Please enter valid Email address!');
					if($validPass == false)$this->AddErrorMessage('Please enter valid password, min length 4 !');
				}
			}

			/**
			 * REGISTRATION PROCEDURE
			 */
			if (($this->input->hasPost('action') == true) && ($this->input->post('action') == 'register')) {

				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$validate->setRule('alphabet',$fname);
				$validate->setRule('minlength',$fname,4,'fname');
				$validFname = $validate->validate();

				$validate->clearRules();

				$validate->setRule('alphabet',$lname);
				$validate->setRule('minlength',$lname,4,'lname');
				$validLname = $validate->validate();

				$validate->clearRules();
				$validate->email($email);
				$validMail = $validate->email($email);

				$validate->setRule('minlength',$password,4,'minlength');
				$validPass = $validate->validate();

				if($validFname == true && $validLname == true && $validMail == true && $validPass == true) {

					$u = $this->auth->register($fname, $lname, $email, $password);

					if ($u != false && $u != 0 && is_array($u)) {
						$this->view->user = $u;
						$this->view->loggedin = true;
						@header("Location:/");
					} else {
						$this->AddErrorMessage($u);
					}
				}else{
					if($validFname == false)$this->AddErrorMessage('Please enter valid First Name!');
					if($validLname == false)$this->AddErrorMessage('Please enter valid Last Name!');
					if($validMail == false)$this->AddErrorMessage('Please enter valid Email address!');
					if($validPass == false)$this->AddErrorMessage('Please enter valid password, min length 4!');
				}

			}

		}

		$this->view->appendToLayout('body', 'signup');

		$this->view->display('layouts/default', array('menuName' => 'singup','errors' => $this->errors));
	}
}