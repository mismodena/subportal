<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
        private $_id;
         
	public function authenticate()
	{
                $username = strtolower($this->username);
		$user = User::model()->find('usernik=?', array($username));
 
		if($user === null)
		    $this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($user->userpsw !== md5($this->password))
		    $this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
                {
		    $this->_id = $user->userid;
                    $this->setState('deptid', $user->deptid);
                    $this->setState('branch', $user->branch);
                    $this->setState('idcard', $user->idcard);
                    $this->setState('usrid', $user->userid);
                    $this->setState('level', $user->userlevel);
                    $this->setState('kodeasset', $user->kodeasset);
                    $this->setState('idgrp', $user->idgrp);
                    $this->username = $user->username;
		    $this->errorCode = self::ERROR_NONE;
	  	}
	   	return $this->errorCode == self::ERROR_NONE;
	}
        
        public function getId()
	{
		return $this->_id;
	}
}