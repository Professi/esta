<?php

/**
 * This is the model class for table "appointment".
 *
 * The followings are the available columns in table 'appointment':
 * @property integer $id_appointment
 * @property integer $id_teacher
 * @property integer $id_parents
 * @property integer $numOfTeacher
 * @property integer $id_date
 *
 * The followings are the available model relations:
 * @property Teachers $idTeacher
 * @property Parents $idParents
 * @property Date $idDate
 */
class Appointment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Appointment the static model class
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
		return 'appointment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_teacher, id_parents, numOfTeacher, id_date', 'required'),
			array('id_teacher, id_parents, numOfTeacher, id_date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_appointment, id_teacher, id_parents, numOfTeacher, id_date', 'safe', 'on'=>'search'),
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
			'idTeacher' => array(self::BELONGS_TO, 'Teachers', 'id_teacher'),
			'idParents' => array(self::BELONGS_TO, 'Parents', 'id_parents'),
			'idDate' => array(self::BELONGS_TO, 'Date', 'id_date'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_appointment' => 'Id Appointment',
			'id_teacher' => 'Id Teacher',
			'id_parents' => 'Id Parents',
			'numOfTeacher' => 'Num Of Teacher',
			'id_date' => 'Id Date',
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

		$criteria->compare('id_appointment',$this->id_appointment);
		$criteria->compare('id_teacher',$this->id_teacher);
		$criteria->compare('id_parents',$this->id_parents);
		$criteria->compare('numOfTeacher',$this->numOfTeacher);
		$criteria->compare('id_date',$this->id_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}