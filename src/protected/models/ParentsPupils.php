<?php

/**
 * This is the model class for table "parents_pupils".
 *
 * The followings are the available columns in table 'parents_pupils':
 * @property integer $id_parents_pupils
 * @property integer $id_parents
 * @property integer $id_pupil
 *
 * The followings are the available model relations:
 * @property Parents $idParents
 * @property Pupils $idPupil
 */
class ParentsPupils extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ParentsPupils the static model class
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
		return 'parents_pupils';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_parents_pupils, id_parents, id_pupil', 'required'),
			array('id_parents_pupils, id_parents, id_pupil', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_parents_pupils, id_parents, id_pupil', 'safe', 'on'=>'search'),
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
			'idParents' => array(self::BELONGS_TO, 'Parents', 'id_parents'),
			'idPupil' => array(self::BELONGS_TO, 'Pupils', 'id_pupil'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_parents_pupils' => 'Id Parents Pupils',
			'id_parents' => 'Id Parents',
			'id_pupil' => 'Id Pupil',
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

		$criteria->compare('id_parents_pupils',$this->id_parents_pupils);
		$criteria->compare('id_parents',$this->id_parents);
		$criteria->compare('id_pupil',$this->id_pupil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}