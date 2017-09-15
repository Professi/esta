<?php

/**
 * Dies ist das Formmodel um eine Lehrer CSV Datei zu importieren.
 */
/* Copyright (C) 2014  Christian Ehringfeld, David Mock
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

class PupilImport extends CFormModel
{
    public $firstname;
    public $lastname;
    public $group;
    public $delimiter;
    public $file;
    private $model = array();
    private $positions = array();
    private $fp;

    public function init()
    {
        parent::init();
        $this->lastname = Yii::t('app', 'Nachname');
        $this->firstname = Yii::t('app', 'Vorname');
        $this->group = Yii::t('app', 'Gruppe');
        $this->delimiter = ';';
    }

    public function rules()
    {
        return array(
            array('file', 'file', 'types' => 'csv', 'maxSize' => ByteConverter::getMaxSizeInBytes() - 100,
                'allowEmpty' => true, 'wrongType' => Yii::t('app', 'Nur CSV Dateien erlaubt.'),
                'tooLarge' => Yii::t('app', 'Datei ist zu groß. Die Begrenzung liegt bei {size}.', array('{size}' => ByteConverter::getMaxSize()))),
            array('firstname, lastname,delimiter', 'required'),
            array('delimiter', 'length', 'max' => 1),
            array('firstname,lastname,delimiter,group', 'safe'),
        );
    }

    public function getModel()
    {
        return $this->model;
    }

    public function attributeLabels()
    {
        return array(
            'file' => Yii::t('app', 'CSV Datei hochladen'),
            'group' => $this->names()['group'],
            'firstname' => $this->names()['firstname'],
            'lastname' => $this->names()['lastname'],
            'delimiter' => Yii::t('app', 'Feldtrenner'),
        );
    }

    public function names()
    {
        return array('firstname' => Yii::t('app', 'Vorname'), 'lastname' => Yii::t('app', 'Nachname'), 'group' => Yii::t('app', 'Gruppe'));
    }

    public function createTans()
    {
        $file = CUploadedFile::getInstance($this, 'file');
        $this->fp = fopen($file->tempName, 'r');
        $msg = "";
        if ($this->fp) {
            if (!$this->generateFromCsv($msg)) {
                Yii::app()->user->setFlash('failMsg', $msg);
            } else {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Schülerliste erfolgreich importiert.'));
            }
            fclose($this->fp);
        }
    }

    private function generateFromCsv(&$msg)
    {
        $first = true;
        $rc = true;
        while ($rc && ($line = fgetcsv($this->fp, 0, $this->delimiter)) != false) {
            if (!$first) {
                $group = '';
                $firstname = $line[$this->getPos($this->firstname)];
                $lastname = $line[$this->getPos($this->lastname)];
                if (Yii::app()->params['allowGroups']) {
                    $group = $line[$this->getPos($this->group)];
                }
                $this->createTan($firstname, $lastname, $group);
            } else {
                $this->firstLoopRun($line);
                if ($this->hasErrors()) {
                    $rc = false;
                    $msg = Yii::t('app', 'Schülerliste konnte nicht importiert werden. Entweder ist die importierte CSV Datei fehlerhaft oder die Spaltennamen sind nicht korrekt eingetragen.');
                }
                $first = false;
            }
        }
        return $rc;
    }

    private function firstLoopRun($line)
    {
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
            if (Yii::app()->params['allowGroups']) {
                $this->checkForColumn($this->group, 'group');
            }
        } else {
            $this->addError('file', Yii::t('app', 'Ungültiges CSV Format und/oder falsche Angabe des Feldtrenners.'));
        }
    }

    private function existsKeys($key)
    {
        return array_key_exists($key, $this->positions);
    }

    private function columnNotExists($column, $attrName)
    {
        $this->addError($attrName, Yii::t('app', 'Spalte {column} existiert nicht.', array('{column}' => $column)));
    }

    private function checkForColumn($column, $attrName)
    {
        if (!$this->existsKeys($column)) {
            $this->columnNotExists($column, $attrName);
        }
    }

    private function createTan($firstname, $lastname, $group)
    {
        $tan = new Tan();
        if (Yii::app()->params['allowGroups'] && !empty($group)) {
            $groupModel = Group::model()->findByAttributes(array('groupname' => $group));
            if (is_null($groupModel)) {
                $groupModel = new Group();
                $groupModel->groupname = $group;
                $groupModel->insert();
            }
            $tan->group_id = $groupModel->id;
        }
        $tan->childFirstname = $firstname;
        $tan->childLastname = $lastname;
        $tan->generateTan();
        $tan->tan_count = 1;
        $this->model[] = $tan;
    }

    private function getPos($attr)
    {
        return $this->positions[$attr];
    }
}
