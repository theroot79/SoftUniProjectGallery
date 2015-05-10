<?php

namespace Controllers\Admin;

use Models;

class Users extends \Controllers\Base
{
	public function index(){

		$this->view->pageTitle = 'Admin -> Users';

		$this->requireAdmin();
		$this->view->appendToLayout('body','admin/index');

		$this->view->display('layouts/admin',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}

	public function view(){

		$this->view->pageTitle = 'Admin -> Users';
		$dataUsers = new Models\Users();

		$adminid = $this->requireAdmin();

		$this->view->pageTitle = 'Sign Up';

		if ($this->input->hasPostReques() && $this->input->hasPost('role')) {


			/**
			 * SET ROLE PROCESS
			 */
			$role = $this->input->post('role');
			$userid = $this->input->post('userid');

			if ($adminid != $userid) {
				$dataUsers->changeRole($userid, $role);
				@header("Location:/admin/users/view/");
			} else {
				$this->AddErrorMessage('Can not change your self.');
			}
		}


		$this->view->users = $dataUsers->getAllUsers();

		$this->view->appendToLayout('body','admin/users');

		$this->view->display('layouts/admin',
			array('menuName' => 'albums', 'errors' => $this->errors));
	}

	public function del(){

		$dataUsers = new Models\Users();

		$adminid = $this->requireAdmin();

		if($adminid < 1)return;

		$userid = 0;

		if($this->input->get(0) && is_numeric($this->input->get(0))){
			$userid = $this->input->get(0);
		}else{
			@header("Location:/myalbums/");
		}

		if ($userid > 0) {
			$dataUsers->delUser($userid, $adminid);
			@header("Location:/admin/users/view/");
		}
	}
}