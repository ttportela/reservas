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
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $name
 * @property string $user
 * @property string $password
 *
 * The followings are the available model relations:
 * @property Reserves[] $reserves
 */
class User extends ActiveRecord
{
	// holds the password confirmation word
    public $repeat_password;
    public $verification;
 
    //will hold the encrypted password for update actions.
    public $initialPassword;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, user, password', 'required'),
			array('user','unique', 'className' => 'User'),
            array('user',
                'match', 'pattern' => '/^[a-z0-9_-]+\.[a-z]+$/i',
                'message' => 'Nome de usuário inválido, são aceitos: "a-z", "A-Z", "0-9", ".", "_"',
            ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//password and repeat password
            array('password, repeat_password', 'required', 'on'=>'insert'),
            array('password, repeat_password', 'length', 'min'=>3, 'max'=>20),
            array('password', 'compare', 'compareAttribute'=>'repeat_password'),
			array('id, name, user, password', 'safe', 'on'=>'search'),
            array('verification', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bookings' => array(self::HAS_MANY, 'Booking', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nome',
			'user' => 'Usuário',
			'password' => 'Senha',
			'repeat_password' => 'Repetir Senha',
			'verification' => 'Código de Verificação',
		);
	}

	public function toString()
	{
		return $this->name ." (".$this->user.")";
	}

	public function getEmail()
	{
		return $this->user . "@ifpr.edu.br";
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
        
        // Cript. password:
		$salt = openssl_random_pseudo_bytes(22);
		$salt = '$2a$%13$' . strtr($salt, array('_' => '.', '~' => '/'));
		
		//add the password hash if it's a new record
        if ($this->getIsNewRecord())
        {
            //creates the password hash from the plaintext password
            $this->password = crypt($this->password, $salt);                         
        }       
        else if (!empty($this->password)&&!empty($this->repeat_password)&&($this->password===$this->repeat_password)) 
        //if it's not a new password, save the password only if it not empty and the two passwords match
        {
            $this->password = crypt($this->password, $salt);
        }
        
		if (parent::beforeSave()) {
			$arrayForeignKeys=$this->tableSchema->foreignKeys;
		    foreach ($this->attributes as $name=>$value) {
		      if (array_key_exists($name, $arrayForeignKeys) && $this->metadata->columns[$name]->allowNull && trim($value)=='') {       
		        $this->$name=null;
			  }
		    }
			return true;
        }
        return false;
	}
 
    public function afterFind()
    {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
        $this->password = null;
 
        parent::afterFind();
    }
}
