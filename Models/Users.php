<?php

namespace Models;

class Users extends Main
{
	/**
	 * Get All Users
	 *
	 * @return bool
	 */
	public function getAllUsers()
	{
		$q = $this->prepare("SELECT * FROM `users` ORDER BY `uid` DESC ");
		$q->execute();
		$result = $q->fetchAllAssoc();
		if(count($result) > 0){
			return $result;
		}

		return false;
	}

	/**
	 * Deletes user.
	 *
	 * @param $uid
	 * @param $admin
	 * @return bool
	 */
	public function delUser($uid, $admin)
	{
		$q = $this->prepare("DELETE FROM `users` WHERE `uid` = :uid AND `uid` != :adminid");
		$q->bindParam(':uid', $uid);
		$q->bindParam(':adminid',$admin);
		$q->execute();
		$result = $q->getAffectedRows();
		if ($result >= 0) {
			return true;
		}
		return false;
	}

	/**
	 * Change Role
	 *
	 * @param $uid
	 * @param $role
	 * @return bool
	 */
	public function changeRole($uid, $role)
	{
		$q = $this->prepare("UPDATE `users` SET `role` = :role WHERE `uid` = :uid ");
		$q->bindParam(':role',$role);
		$q->bindParam(':uid', $uid);
		$q->execute();
		$result = $q->getAffectedRows();
		if ($result >= 0) {
			return true;
		}
		return false;
	}
}