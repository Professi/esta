<?php

/**
 * This is the model class for table "parents".
 *
 * The followings are the available columns in table 'parents':
 * @property integer $id_parents
 * @property integer $parent1
 * @property integer $parent2
 * @property string $pw
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Parent $parent10
 * @property ParentsPupils[] $parentsPupils
 */
class Parents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parents the static model class
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
		return 'parents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent1, pw', 'required'),
			array('parent1, parent2', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_parents, parent1, parent2, pw', 'safe', 'on'=>'search'),
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
			'appointments' => array(self::HAS_MANY, 'Appointment', 'id_parents'),
			'parent10' => array(self::BELONGS_TO, 'Parent', 'parent1'),
			'parentsPupils' => array(self::HAS_MANY, 'ParentsPupils', 'id_parents'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_parents' => 'Id Parents',
			'parent1' => 'Parent1',
			'parent2' => 'Parent2',
			'pw' => 'Pw',
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

		$criteria->compare('id_parents',$this->id_parents);
		$criteria->compare('parent1',$this->parent1);
		$criteria->compare('parent2',$this->parent2);
		$criteria->compare('pw',$this->pw,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}