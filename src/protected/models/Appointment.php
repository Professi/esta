<?php

/**
 * This is the model class for table "appointment".
 *
 * The followings are the available columns in table 'appointment':
 * @property integer $id
 * @property integer $parent_child_id
 * @property string $user_id
 * @property integer $dateTime_id
 *
 * The followings are the available model relations:
 * @property DateTime $dateTime
 * @property ParentChild $parentChild
 * @property User $user
 */
 /**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
	
	    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dateAndTime_id, parent_child_id, user_id', 'required'),
            array('dateAndTime_id, parent_child_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, dateAndTime_id, parent_child_id, user_id', 'safe', 'on' => 'search'),
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
			'dateAndTime' => array(self::BELONGS_TO, 'DateAndTime', 'dateAndTime_id'),
			'parentChild' => array(self::BELONGS_TO, 'ParentChild', 'parent_child_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_child_id' => 'Eltern',
			'user_id' => 'Lehrer',
			'dateAndTime_id' => 'Datum',
                        'time' => 'Zeit',
                        'date_id' => 'Datum',
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
		$criteria->compare('parent_child_id',$this->parent_child_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('dateAndTime_id',$this->dateAndTime_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
