<?php


namespace VTF\Sessions;

class DBSession extends \VTF\Db\Db implements ISession
{
	private $sessionName;
	private $tableName;
	private $lifetime;
	private $path;
	private $domain;
	private $secure;
	private $sessionId;
	private $sessionData = array();

	public function __construct($dbConn, $name, $table = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = false){
		parent::__construct($dbConn);
		$this->tableName = $table;
		$this->sessionName = $name;
		$this->lifetime = $lifetime;
		$this->path = $path;
		$this->domain = $domain;
		$this->secure = $secure;
		if(isset($_COOKIE[$name])) {
			$this->sessionId = $_COOKIE[$name];
		}else{
			$this->sessionId = null;
		}

		if(rand(0,20) == 1){
			$this->garbageCollector();
		}

		if(strlen($this->sessionId) < 32){
			$this->_startNewSession();
		}else if ($this->_validateSession() == false){
			$this->_startNewSession();
		}
	}

	private function garbageCollector(){
		$this->prepare('DELETE FROM `'.$this->tableName.'` WHERE `valid_until`<?', array(time()) )->execute();
	}


	private function _startNewSession(){
		$validuntil = (time() + $this->lifetime);

		$this->sessionId = md5(uniqid('vtf'));
		$this->prepare('INSERT INTO `'.$this->tableName.'` (`sessid`,`valid_until`) VALUES (?,?)',
			array($this->sessionId,$validuntil))->execute();
		setcookie($this->sessionName,$this->sessionId,$validuntil,$this->path,$this->domain,$this->secure,true);

	}

	private function _validateSession(){
		if ($this->sessionId){
			$q = $this->prepare('SELECT * FROM `'.$this->tableName.'` WHERE `sessid`=? AND `valid_until`<=?',
					array($this->sessionId,(time() + $this->lifetime)))->execute()->fetchAllAssoc();
			if(is_array($q) && count($q) == 1 && isset($q[0])){
				$this->sessionData = unserialize($q[0]['sess_data']);
				return true;
			}
		}
		return false;
	}

	public function saveSession()
	{
		if(isset($this->sessionId) && !empty($this->sessionId)){
			$validuntil = (time() + $this->lifetime);
			$this->prepare('UPDATE `'.$this->tableName.'` SET `sess_data`=?, `valid_until`=? WHERE `sessid`=? ',
				array(serialize($this->sessionData),$validuntil,$this->sessionId))->execute();
			setcookie($this->sessionName,$this->sessionId,$validuntil,$this->path,$this->domain,$this->secure,true);
		}
	}
	public function getSessionId()
	{
		return $this->sessionId;
	}

	public function saveSessionId()
	{
		$this->saveSessionId();
	}

	public function destroySessionId()
	{
		if(isset($this->sessionId) && !empty($this->sessionId)){
			$this->prepare('DELETE FROM `'.$this->tableName.'` WHERE `sessid`=? ',
				array($this->sessionId))->execute();
		}
	}

	public function __get($name)
	{
		if(!isset($this->sessionData[$name])) $this->sessionData[$name] = null;
		return $this->sessionData[$name];
	}

	public function __set($name, $value)
	{
		$this->sessionData[$name] = $value;
	}
}