<?php

/**
 * This is the model class for table "appointment".
 *
 * The followings are the available columns in table 'appointment':
 * @property integer $id
 * @property string $time
 * @property integer $date_id
 * @property integer $parent_child_id
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property Date $date
 * @property ParentChild $parentChild
 * @property User $user
 */
class Appointment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Appointment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'appointment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time, date_id, parent_child_id, user_id', 'required'),
            array('date_id, parent_child_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, time, date_id, parent_child_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'date' => array(self::BELONGS_TO, 'Date', 'date_id'),
            'parentChild' => array(self::BELONGS_TO, 'ParentChild', 'parent_child_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'time' => 'Zeit',
            'date_id' => 'Datum',
            'parent_child_id' => 'Benutzer',
            'user_id' => 'Lehrer',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('date_id', $this->date_id);
        $criteria->compare('parent_child_id', $this->parent_child_id);
        $criteria->compare('user_id', $this->user_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     * Prüft ob der Lehrer vorhanden ist, ob der vermeintlich gewählte Lehrer überhaupt die Rolle hat und prüft ob die Elternkindverknüpfung existiert.
     * Prüft ebenfalls ob bereits ein Termin bei diesem Lehrer besteht
     *
     */
    public function afterValidate() {
        $rc = parent::afterValidate();
        if ($rc && User::model()->countByAttributes(array('id' => $this->user_id)) != 1 || UserRole::model()->findByAttributes(array('user_id' => $this->user_id))->role_id != 2 || ParentChild::model()->countByAttributes(array('id' => $this->parent_child_id)) != 1) {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Sie haben keine gültige Lehrkraft ausgewählt.');
        } else if ($rc && Appointment::model()->countByAttributes(array('user_id' => $this->user_id, 'parent_child_id' => $this->parent_child_id)) >= 1) {
            Yii::app()->user->setFlash('failMsg', 'Leider haben Sie bereits einen Termin bei diesem Lehrer gebucht. Daher können Sie keinen weiteren buchen.');
            $rc = false;
        }
        return $rc;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     * Prüft ob die maximal Anzahl von Terminen überschritten wurde
     */
    public function beforeSave() {
        $rc = parent::beforeSave();
        if (!Yii::app()->user->checkAccess('1') && $rc) {
            if (Appointment::model()->countByAttributes(array('parent_child_id' => $this->parent_child_id)) >= Yii::app()->params['maxAppointmentsPerChild']) {
                $rc = false;
                Yii::app()->user->setFlash('failMsg', 'Leider konnte Ihr Termin nicht gebucht haben, da Sie die maximale Anzahl von '
                        . Yii::app()->params['maxAppointmentsPerChild'] . 'überschritten haben.');
                $this->addError('parent_child_id', 'Sie haben die maximal Anzahl von Terminen überschritten.');
            } else {
                Yii::app()->user->setFlash('success', 'Ihr Termin wurde erfolgreich gebucht.');
            }
        }
        return $rc;
    }

}