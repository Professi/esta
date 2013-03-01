<?php

/**
 * This is the model class for table "pupils".
 *
 * The followings are the available columns in table 'pupils':
 * @property integer $id_pupil
 * @property string $firstname
 * @property string $lastname
 * @property integer $id_schoolclass
 * @property string $bDay
 *
 * The followings are the available model relations:
 * @property ParentsPupils[] $parentsPupils
 * @property Schoolclasses $idSchoolclass
 */
class Pupils extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pupils the static model class
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
		return 'pupils';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, id_schoolclass', 'required'),
			array('id_schoolclass', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, bDay', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_pupil, firstname, lastname, id_schoolclass, bDay', 'safe', 'on'=>'search'),
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
			'parentsPupils' => array(self::HAS_MANY, 'ParentsPupils', 'id_pupil'),
			'idSchoolclass' => array(self::BELONGS_TO, 'Schoolclasses', 'id_schoolclass'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pupil' => 'Id Pupil',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'id_schoolclass' => 'Id Schoolclass',
			'bDay' => 'B Day',
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

		$criteria->compare('id_pupil',$this->id_pupil);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('id_schoolclass',$this->id_schoolclass);
		$criteria->compare('bDay',$this->bDay,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}