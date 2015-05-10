<?php

namespace Lib;

use \VTF\App;
use \VTF\Db;


class Auth{

	/**
	 * Auth instance
	 *
	 * @var Auth|null
	 */
	private static $_instance = null;

	/**
	 * Is the user logged in ?
	 * @var bool
	 */
	private static $is_logged_in = false;

	/**
	 * User info.
	 *
	 * @var array
	 */
	private static $user = array();

	/**
	 * @var \VTF\App
	 */
	private $app;

	/**
	 * @var \VTF\Db\Db
	 */
	private $db;

	private function __construct(){
		$this->app = App::getInstance();
		$this->db = new Db\Db();

		if($this->app->getSession()->user != null && @is_array($this->app->getSession()->user)){
			$user = $this->app->getSession()->user;
			self::$is_logged_in = true;
			self::$user = $user;
		}
	}

	/**
	 * @return Auth|null
	 */
	public static function getInstance ()
	{

		if(self::$_instance == null){
			self::$_instance = new Auth();
		}

		return self::$_instance;
	}

	/**
	 * Returns true if the user is logged in.
	 *
	 * @return bool
	 */
	public function is_loggedin(){
		return self::$is_logged_in;
	}

	/**
	 * Returns user profile
	 * @return array
	 */
	public function user(){
		return self::$user;
	}

	/**
	 * Login procedure.
	 *
	 * @param $email
	 * @param $password
	 * @return bool
	 */
	public function login($email, $password)
	{
		$q = $this->db->prepare("SELECT * FROM `users` WHERE `email`=:email AND `password`=MD5(:password)");
		$q->bindParam(':email', $email, \PDO::PARAM_STR);
		$q->bindParam(':password', $password, \PDO::PARAM_STR);
		$q->execute();
		$result = $q->fetchAllAssoc();
		if(is_array($result) && count($result) > 0){
			$result = $result[0];
			if (is_array($result) && isset($result['state']) && ($result['state'] == 0)) {
				unset($result['password']);
				self::$user = $result;
				$this->app->getSession()->user = $result;
				return $result;
			}
		}
		return false;
	}

	/**
	 * Update profile procedure.
	 *
	 * @param $fname
	 * @param $lname
	 * @param $password
	 * @return string
	 */
	public function updateProfile($fname, $lname, $password)
	{
		$passUpd = "";
		if(!empty($password))$passUpd = ",`password`='.md5($password).'";

		$q = $this->db->prepare("UPDATE `users` SET `fname`=:fname,`lname`=:lname $passUpd WHERE `email`=:email ");
		$q->bindParam(':fname', $fname, \PDO::PARAM_STR);
		$q->bindParam(':lname', $lname, \PDO::PARAM_STR);
		$q->bindParam(':email', self::$user['email'], \PDO::PARAM_STR);
		$q->execute();

		$result = $q->getAffectedRows();

		if($result !== false && is_numeric($result)){
			self::$user['fname'] = $fname;
			self::$user['lname'] = $lname;

			$this->app->getSession()->user = self::$user;

			return $result;
		}else{
			return $q->getErrors();
		}
	}

	/**
	 * Register procedure.
	 *
	 * @param $fname
	 * @param $lname
	 * @param $email
	 * @param $password
	 * @return bool|string
	 */
	public function register($fname, $lname, $email, $password)
	{
		$q = $this->db->prepare("INSERT INTO users (fname,lname,email,password)	VALUES (:fname,:lname,:email,MD5(:password))");
		$q->bindParam(':fname', $fname, \PDO::PARAM_STR);
		$q->bindParam(':lname', $lname, \PDO::PARAM_STR);
		$q->bindParam(':email', $email, \PDO::PARAM_STR);
		$q->bindParam(':password', $password, \PDO::PARAM_STR);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result !== false && $result != 0){
			return $this->login($email,$password);
		}else{
			return $q->getErrors();
		}
	}

	/**
	 * Logout procedure.
	 *
	 */
	public function logout()
	{
		$this->app->getSession()->destroySessionId();
		$this->app->getSession()->user = null;
		self::$is_logged_in = false;
		self::$user = array();
	}
}