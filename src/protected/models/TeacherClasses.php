<?php

/**
 * This is the model class for table "teacher_classes".
 *
 * The followings are the available columns in table 'teacher_classes':
 * @property integer $id_teacher_classes
 * @property integer $id_teacher
 * @property integer $id_schoolclass
 *
 * The followings are the available model relations:
 * @property Teachers $idTeacher
 * @property Schoolclasses $idSchoolclass
 */
class TeacherClasses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TeacherClasses the static model class
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
		return 'teacher_classes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_teacher_classes, id_teacher, id_schoolclass', 'required'),
			array('id_teacher_classes, id_teacher, id_schoolclass', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_teacher_classes, id_teacher, id_schoolclass', 'safe', 'on'=>'search'),
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
			'idSchoolclass' => array(self::BELONGS_TO, 'Schoolclasses', 'id_schoolclass'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_teacher_classes' => 'Id Teacher Classes',
			'id_teacher' => 'Id Teacher',
			'id_schoolclass' => 'Id Schoolclass',
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

		$criteria->compare('id_teacher_classes',$this->id_teacher_classes);
		$criteria->compare('id_teacher',$this->id_teacher);
		$criteria->compare('id_schoolclass',$this->id_schoolclass);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}