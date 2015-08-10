<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;

class User extends Model
{
	const ROLE_GUEST = 'guest';
	
	protected static $_auth = null;

	public function initialize()
	{
		$this->setSource("users");
		
		$this->hasMany("robots_id", "Robots", "id");
	}
	
	public function validation()
    {
		$this->validate(new RegexValidator(array(
            'field' => 'login',
			'pattern' => '/^[A-Za-z0-9_]{5,20}+$/',
			'message' => 'Sorry, The invalid login.'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'login',
            'message' => 'Sorry, That login is already taken'
        )));
        $this->validate(new EmailValidator(array(
            'field' => 'email'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'email',
            'message' => 'Sorry, The email was registered by another user'
        )));
		$this->validate(new RegexValidator(array(
            'field' => 'password',
			'pattern' => '/^[a-z0-9]{5,20}+$/',
			'message' => 'Sorry, The invalid password.'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
	
	public function beforeSave()
	{
		$this->password = $this->getDi()->getShared('security')->hash($this->password);
	}
	
	public function getName()
	{
		return $this->login?$this->login:$this->email;
	}
	
	public function sessionStart()
	{
		$this->getDI()->getSession()->set('auth', array(
            'id' => $this->id,
            'email' => $this->email
        ));
	}
	
	public static function getRole($di)
	{
		if(! self::$_auth && $di->getSession()->has('auth'))
		{
			self::$_auth = $di->getSession()->get('auth');
			$user = User::findFirst(self::$_auth['id']);
		}
		else
			$user = false;
		
		if($user != false)
			return $user->role;
		else
			return User::ROLE_GUEST;
	}
	
	// public static function setAuth()
	// {
		// if($di->getSession()->has('auth'))
		// {
			// self::$_auth = $di->getSession()->get('auth');
		// }
		// else
			// $user = false;
	// }
	
	public static function getAuth()
	{
		return self::$_auth;
	}
}