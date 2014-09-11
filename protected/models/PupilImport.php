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
//
//    public $firstname;
//    public $lastname;
//    public $group;
//    public $delimiter;
//    public $file;
//
//    public function init() {
//        parent::init();
//        $this->lastname = Yii::t('app', 'Nachname');
//        $this->firstname = Yii::t('app', 'Vorname');
//        $this->delimiter = ';';
//    }
//    
//    public function rules() {
// return array(
//            array('file', 'file', 'types' => 'csv', 'maxSize' => self::getMaxSizeInBytes() - 100,
//                'allowEmpty' => true, 'wrongType' => Yii::t('app', 'Nur CSV Dateien erlaubt.'),
//                'tooLarge' => Yii::t('app', 'Datei ist zu groß. Die Begrenzung liegt bei {size}.', array('{size}' => self::getMaxSize()))),
//            array('firstname, lastname,delimiter', 'required'),
//            array('delimiter', 'length', 'max' => 1),
//            array('firstname,lastname,delimite', 'safe'),
//        );    }
//
//    public function attributeLabels() {
//        return array(
//            'file' => Yii::t('app', 'CSV Datei hochladen'),
//            'firstname' => $this->names()['firstname'],
//            'lastname' => $this->names()['lastname'],
//            'delimiter' => Yii::t('app', 'Seperator'),
//        );
//    }
//    
//    public function names() {
//        return array('firstname' => Yii::t('app', 'Vorname'), 'lastname' => Yii::t('app', 'Nachname'));
//    }
    
    
//    private function generateFromCsv(&$fp, &$msg) {
//        $first = true;
//        $rc = true;
//        $stdPassword = "";
//        while ($rc && ($line = fgetcsv($fp, 0, $this->delimiter)) != FALSE) {
//            if (!$first) {
//                $model = $this->setTeacherModel($this->generateMail($line), self::encodingString($line[$this->getPos($this->lastname)]), self::encodingString($line[$this->getPos($this->firstname)]), 1, 2, self::encodingString($line[$this->getPos($this->title)]), $stdPassword);
//                $this->saveModel($model);
//                $rc = $this->checkModelErrors($model, $msg);
//            } else {
//                $this->firstLoopRun($line);
//                if ($this->hasErrors()) {
//                    $rc = false;
//                    $msg = Yii::t('app', 'Lehrerliste konnte nicht importiert werden. Entweder ist die importierte CSV Datei fehlerhaft oder die Spaltennamen sind nicht korrekt eingetragen.');
//                }
//                $first = false;
//            }
//        }
//        return $rc;
//    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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
        
}
