<?php

/**
 * This is the model class for table "schoolclasses".
 *
 * The followings are the available columns in table 'schoolclasses':
 * @property integer $id_schoolclass
 * @property string $classname
 *
 * The followings are the available model relations:
 * @property Pupils[] $pupils
 * @property TeacherClasses[] $teacherClasses
 */
class Schoolclasses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Schoolclasses the static model class
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
		return 'schoolclasses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classname', 'required'),
			array('classname', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_schoolclass, classname', 'safe', 'on'=>'search'),
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
			'pupils' => array(self::HAS_MANY, 'Pupils', 'id_schoolclass'),
			'teacherClasses' => array(self::HAS_MANY, 'TeacherClasses', 'id_schoolclass'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_schoolclass' => 'Id Schoolclass',
			'classname' => 'Classname',
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

		$criteria->compare('id_schoolclass',$this->id_schoolclass);
		$criteria->compare('classname',$this->classname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}