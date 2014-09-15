<?php

/**
 * Dies ist Formmodel um eine Lehrer CSV Datei zu importieren.
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of PupilImport
 *
 * @author cehringfeld
 */
class PupilImport extends CFormModel {

    public $firstname;
    public $lastname;
    public $group;
    public $delimiter;
    public $file;
    private $model = array();
    private $positions = array();
    
    public function init() {
        parent::init();
        $this->lastname = Yii::t('app', 'Nachname');
        $this->firstname = Yii::t('app', 'Vorname');
        $this->group = Yii::t('app', 'Gruppe');
        $this->delimiter = ';';
    }

    public function rules() {
        return array(
            array('file', 'file', 'types' => 'csv', 'maxSize' => self::getMaxSizeInBytes() - 100,
                'allowEmpty' => true, 'wrongType' => Yii::t('app', 'Nur CSV Dateien erlaubt.'),
                'tooLarge' => Yii::t('app', 'Datei ist zu groß. Die Begrenzung liegt bei {size}.', array('{size}' => self::getMaxSize()))),
            array('firstname, lastname,delimiter', 'required'),
            array('delimiter', 'length', 'max' => 1),
            array('firstname,lastname,delimiter', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'file' => Yii::t('app', 'CSV Datei hochladen'),
            'group' => Yii::t('app', 'group'),
            'firstname' => $this->names()['firstname'],
            'lastname' => $this->names()['lastname'],
            'delimiter' => Yii::t('app', 'Seperator'),
        );
    }

//    
    public function names() {
        return array('firstname' => Yii::t('app', 'Vorname'), 'lastname' => Yii::t('app', 'Nachname'));
    }

    private function generateFromCsv(&$fp, &$msg) {
        $first = true;
        $rc = true;
        while ($rc && ($line = fgetcsv($fp, 0, $this->delimiter)) != FALSE) {
            if (!$first) {
                $firstname = $line[$this->getPos($this->firstname)];
                $lastname = $line[$this->getPos($this->lastname)];
                
            } else {
                $this->firstLoopRun($line);
                if ($this->hasErrors()) {
                    $rc = false;
                    $msg = Yii::t('app', 'Lehrerliste konnte nicht importiert werden. Entweder ist die importierte CSV Datei fehlerhaft oder die Spaltennamen sind nicht korrekt eingetragen.');
                }
                $first = false;
            }
        }
        return $rc;
    }
    
        private function firstLoopRun(&$line) {
        $i = 0;
        $this->positions = array();
        if (count($line) >= 2) {
            foreach ($line as $val) {
                if (!empty($val)) {
                    $this->positions[$val] = $i;
                    $i++;
                }
            }
            $this->checkForColumn($this->firstname, 'firstname');
            $this->checkForColumn($this->lastname, 'lastname');
        } else {
            $this->addError('file', Yii::t('app', 'Ungültiges CSV Format und/oder falsche Angabe des Seperators.'));
        }
    }
    
        private function columnNotExists($column, $attrName) {
        $this->addError($attrName, Yii::t('app', 'Spalte {column} existiert nicht.', array('{column}' => $column)));
    }

    private function checkForColumn($column, $attrName) {
        if (!$this->existsKeys($column)) {
            $this->columnNotExists($column, $attrName);
        }
    }
    
    
    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * renders showGenTans when allowParentsToManageChilds activated
     * @param Tan $model
     */
    private function tansNotForParentsManagement(&$model) {
        $validate = true;
        $model = $this->iterateOverTans($_POST['Tan'], $validate);
        if (!empty($model) && $validate) {
            foreach ($model as $newTan) {
                if ($newTan->child instanceof Child && $newTan->child->save()) {
                    $newTan->child_id = $newTan->child->getPrimaryKey();
                    $newTan->insert();
                }
            }
            $dataProvider = new CArrayDataProvider($model, array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
            $this->render('showGenTans', array('dataProvider' => $dataProvider));
        } else {
            $this->renderFormGenTans($model);
        }
    }

    private function createTan($firstname, $lastname, $group) {
        $tan = new Tan();
        if (Yii::app()->params['allowGroups'] && !empty($group)) {
            $groupModel = Group::model()->findByAttributes(array('groupname' => $group));
            if(is_null($groupModel)) {
                $groupModel = new Group();
                $groupModel->groupname = $group;
                $groupModel->insert();
            }
            $tan->group_id = $groupModel->id;
        }
        $tan->childFirstname = $firstname;
        $tan->childLastname = $lastname;
        $tan->tan_count = 1;
        if ($tan->validate()) {
            $tan->generateTan(false);
            $model[] = $tan;
        }
    }

    /**
     * Konvertiert eine Datei in ISO-8859-1 in UTF-8
     * @param string $toEncode
     * @return string
     * 
     */
    static public function encodingString($toEncode, $to = 'UTF-8', $from = 'ISO-8859-1') {
        return mb_convert_encoding($toEncode, $to, $from);
    }

    /**
     * creates nicely formatted string from array
     * @param array $array
     * @return string
     */
    static public function convert_multi_array($array) {
        return implode("&", array_map(function($a) {
                    return implode("~", $a);
                }, $array));
    }

    static private function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    static public function getMaxSizeInBytes() {
        return self::return_bytes(ini_get('post_max_size'));
    }

    static public function getMaxSize() {
        return ini_get('post_max_size');
    }

    private function getPos($attr) {
        return $this->positions[$attr];
    }
    
}
