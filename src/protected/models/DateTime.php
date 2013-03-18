<?php

/**
 * This is the model class for table "dateTime".
 *
 * The followings are the available columns in table 'dateTime':
 * @property integer $id
 * @property string $time
 * @property integer $date_id
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Date $date
 */
class DateTime extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DateTime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dateTime';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_id', 'required'),
			array('date_id', 'numerical', 'integerOnly'=>true),
			array('time', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, date_id', 'safe', 'on'=>'search'),
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
			'appointments' => array(self::HAS_MANY, 'Appointment', 'dateTime_id'),
			'date' => array(self::BELONGS_TO, 'Date', 'date_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time' => 'Time',
			'date_id' => 'Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('date_id',$this->date_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}