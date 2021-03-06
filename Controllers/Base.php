<?php

namespace Controllers;

use VTF\InputData;
use VTF\DefaultController;
use VTF\View;
use VTF\App;
use VTF\Db\Db;
use Lib\Auth;

/**
 * Base Controller
 *
 * Class Base
 * @package Controllers
 */
class Base extends DefaultController{

	/**
	 * @var View
	 */
	public $view;

	/**
	 * Errors container
	 *
	 * @var string
	 */
	public $errors = '';

	/**
	 * Notices container
	 *
	 * @var string
	 */
	public $notices = '';

	/**
	 * Input Data
	 *
	 * @var \VTF\InputData
	 */
	public $input;


	/**
	 * App instanse
	 *
	 * @var App
	 */
	public $app;

	/**
	 * Auth module
	 *
	 * @var Auth|null
	 */
	public $auth;

	/**
	 * Total Items Found
	 *
	 * @var int $total
	 */
	public $total = 0;

	/**
	 * Current page
	 *
	 * @var int $page
	 */
	public $page = 0;

	/**
	 * Items per page
	 *
	 * @var int $offset
	 */
	public $offset = 8;

	public function __construct()
	{
		$this->app = App::getInstance();
		$this->input = InputData::getInstance();
		$this->auth = Auth::getInstance();

		$this->view = View::getInstance();
		$this->view->pageTitle = 'Homepage';
		$this->view->searchString = '';
		$this->view->user = array('email'=>'','fname'=>'','role'=>'user');

		if($this->auth->user() && is_array($this->auth->user())){
			$this->view->user = $this->auth->user();
			$this->view->loggedin = true;
		}


		$this->view->appendToLayout('header','header');
		$this->view->appendToLayout('header-admin','header-admin');
		$this->view->appendToLayout('footer','footer');
	}

	public function AddErrorMessage($message){
		$this->errors.='
		<div class="errormsg">'.$message.'</div>';
	}

	public function AddNoticeMessage($notice){
		$this->errors.='
		<div class="backmsg">'.$notice.'</div>';
	}

	public function requireLogin()
	{
		$user = $this->auth->user();
		$userid = 0;
		if(isset($user['uid'])){
			$userid = intval($user['uid']);
		}
		if($userid < 1)header("Location:/signup/");
		return $userid;
	}

	public function requireAdmin()
	{
		$user = $this->auth->user();
		$userid = 0;
		if(isset($user['uid']) && $user['role'] == 'admin'){
			$userid = intval($user['uid']);
		}
		if($userid < 1)header("Location:/signup/");
		return $userid;
	}
}
