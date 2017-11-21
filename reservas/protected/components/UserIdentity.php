<?php /**
    This file is part of Sistema de Reservas.
    Copyright (C) 2017  Tarlis Tortelli Portela <tarlis@tarlis.com.br>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/?>
<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$record = User::model()->findByAttributes(array('user' => $this->username));
		
		if ($record === null)
			$this -> errorCode = self::ERROR_USERNAME_INVALID;
		else if ($record->initialPassword !== crypt($this->password, $record->initialPassword))
			$this -> errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this -> _id = $record -> id;
			$this -> setState('name', $record->name);
            $this -> setState('user', $record->user);
            $this -> setState('email', $record->email);
			
			$this -> errorCode = self::ERROR_NONE;
		}
		return !$this -> errorCode;
	}

	public function getId() {
		return $this -> _id;
	}

}
