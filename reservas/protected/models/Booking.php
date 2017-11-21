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
 * This is the model class for table "bookings".
 *
 * The followings are the available columns in table 'bookings':
 * @property string $id
 * @property string $resources_id
 * @property string $users_id
 * @property string $from
 * @property string $to
 *
 * The followings are the available model relations:
 * @property Resources $resources
 * @property Users $users
 */
class Booking extends ActiveRecord
{
    public $repeat_days;
    public $repeat_periods;
    public $repeat_periods_class;
    public $repeat_to;
    public $from_date;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bookings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resources_id, users_id, from, to', 'required'),
			array('resources_id, users_id', 'length', 'max'=>20),
            array('from', 'dateInFuture'),
            array('to', 'compare', 'compareAttribute'=>'from', 'operator'=>'>', 'allowEmpty'=>false , 'message'=>'Data de reserva "Até" não pode ser menor que data "De".'),
            array('from', 'dateRangeExists'),
            array('approved','type','type'=>'boolean'),
            // array('approved', 'default', 'value'=>(Yii::app()->helper->isAdmin()? true : ($this->resource->approval? false : true)), 'on' => 'create'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, resources_id, users_id, from, to, approved', 'safe', 'on'=>'search'),
            array('from_date, repeat_days, repeat_periods, repeat_periods_class, repeat_to', 'safe'),
		);
	}
    
    public function dateInFuture($attribute, $params) {
        if (strtotime($this->$attribute) < strtotime(date(" "))) {
            $this->addError($attribute, 'A data "'.$this->getAttributeLabel($attribute).'" é menor que a data atual. A reserva não pode ser feita retroativa.');
             return false;
        }
        
        return true;
    }
    
    public function dateRangeExists($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->addCondition(
            "t.resources_id = '$this->resources_id' AND ".
            (!$this->isNewRecord? "t.id <> '$this->id' AND " : "").
            "(('{$this->from}' <= t.to) AND (t.from <= '{$this->to}'))");
        
        $record = self::model()->exists($criteria); 

        if(!empty($record)) {
             $this->addError('from', 'Já existe uma reserva em conflito com este período de datas.');
             return false;
        }
    }
    
    public function dateRange() {
        $this->from = $this->from_date." ".$this->from;
        $this->to = $this->from_date." ".$this->to;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'resource' => array(self::BELONGS_TO, 'Resource', 'resources_id'),
			'user' => array(self::BELONGS_TO, 'User', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'resources_id' => 'Item / Sala',
			'users_id' => 'Usuário',
			'from' => 'De',
			'to' => 'Até',
			'approved' => 'Status',
			'from_date' => 'Data',
            'repeat_periods' => 'Período',
            'repeat_periods_class' => 'Aulas',
            'repeat_days' => 'Dias da Semana',
			'repeat_to' => 'Repetir Até',
		);
	}

	public function toString()
	{
		return $this->resource->text .' ›› '.$this->user->name.' ['.date("d/m/Y H:i",strtotime($this->from)).' - '.date("d/m/Y H:i",strtotime($this->to)).']';
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
		$criteria->compare('resources_id',$this->resources_id,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('approved',$this->approved, true);
        
        if (!Yii::app()->helper->isAdmin()) {
			$criteria->compare('t.users_id',Yii::app()->user->id, true);
		}
        
        $criteria->order = "t.from DESC, t.to DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function defaultScope()
    {
        if (Yii::app()->helper->isAdmin()) {
            return parent::defaultScope();
        } else 
            return array(
                'condition'=>'t.users_id=' . Yii::app()->user->id . ' AND t.to>=NOW()',
            );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Booking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function afterFind()
    {
        $this->from = substr($this->from, 0, -3);
        $this->to = substr($this->to, 0, -3);

        parent::afterFind();
    }
    
	public function beforeSave() {
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
}
