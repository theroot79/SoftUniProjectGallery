<?php

namespace Controllers\Admin;

use VTF\DefaultController;
use VTF\Validation;
use VTF\View;
use Models;

class Index extends \Controllers\Base
{
	public function index(){

		$this->view->pageTitle = 'Administration page';

		$this->view->appendToLayout('body','admin/index');

		$this->view->display('layouts/admin',
			array('menuName'=>'singup','errors' => $this->errors));
	}
}