<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $_id;
    private $_uuid;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$name = strtolower($this->username);
		$user = Users::model()->find('LOWER(name)=? AND uuid=?', [$name, $this->password]);

		if(!$user) {
			$this->setState('isGuest', true);
			$this->setState('userId', false);
            $this->setState('uuid', false);
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else {
			$this->username = $user->name;
            $this->_id =  $user->id;
            $this->_uuid =  $user->uuid;
			$this->setState('userId', $user->id);
            $this->setState('uuid', $user->uuid);
			$this->setState('isGuest', false);
            Yii::app()->request->cookies['uuid'] = new CHttpCookie('uuid', $user->uuid);
            Yii::app()->request->cookies['name'] = new CHttpCookie('name', $user->name);
            $this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;

	}

    public function getId()
    {
        return $this->_id;
    }

    public function getUuid()
    {
        return $this->_uuid;
    }

}