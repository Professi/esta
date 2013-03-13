<?php

/**
 * This is the model class for table "tan".
 *
 * The followings are the available columns in table 'tan':
 * @property integer $tan
 * @property boolean $used
 */
class Tan extends CActiveRecord {

    public $tan_count = 0;
    public $id = 0;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
           // array('tan_count', 'required'),
            array('tan_count', 'numerical', 'integerOnly' => true, 'min'=>1, 'max'=>Yii::app()->params['maxTanGen']),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tan, used', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tan' => 'Tan',
            'used' => 'Benutzt',
            'tan_count' => 'Anzahl',
        );
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('tan', $this->tan, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

}