<?php

/**
 * Dies ist Formmodel um eine Lehrer CSV Datei zu importieren.
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class CsvUpload extends CFormModel {

    /** @var file CSV Datei */
    public $file;

    /** @var string Vorname */
    public $firstname;

    /** @var string Nachname */
    public $lastname;

    /** @var string Titel */
    public $title;
    public $delimiter;

    /** @var string E-Mail Adresse */
    public $email = 'Email';
    public static $uml = array("Ö" => "Oe", "ö" => "oe", "Ä" => "Ae", "ä" => "ae", "Ü" => "Ue", "ü" => "ue", "ß" => "ss",);
    private $positions = array();

    public function init() {
        parent::init();
        $this->firstname = Yii::t('app', 'Vorname');
        $this->lastname = Yii::t('app', 'Nachname');
        $this->title = Yii::t('app', 'Titel');
        $this->delimiter = ';';
    }

    /**
     * validation rules
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('file', 'file', 'types' => 'csv', 'maxSize' => self::getMaxSizeInBytes() - 100,
                'allowEmpty' => true, 'wrongType' => Yii::t('app', 'Nur CSV Dateien erlaubt.'),
                'tooLarge' => Yii::t('app', 'Datei ist zu groß. Die Begrenzung liegt bei {size}.', array('{size}' => self::getMaxSize()))),
            array('firstname, lastname,email,title,delimiter', 'required'),
            array('delimiter', 'length', 'max' => 1),
            array('firstname,lastname,email,title,delimiter', 'safe'),
        );
    }

    /**
     * Attributlabels
     * @return array Labels
     */
    public function attributeLabels() {
        return array('file' => Yii::t('app', 'CSV Datei hochladen'),
            'firstname' => Yii::t('app', "Vorname"),
            'lastname' => Yii::t('app', 'Nachname'),
            'email' => Yii::t('app', 'E-Mail'),
            'title' => Yii::t('app', 'Titel'),
            'delimiter' => Yii::t('app', 'Seperator'),
        );
    }

    /**
     * Creates Teachers with csv file
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param resource $fp
     * @param string $msg
     * @return boolean
     */
    public function createTeachers(&$fp, &$msg) {
        set_time_limit(0);
        $rc = $this->generateFromCsv($fp, $msg);
        return $rc;
    }

    private function generateFromCsv(&$fp, &$msg) {
        $first = true;
        $rc = true;
        $stdPassword = "";
        while ($rc && ($line = fgetcsv($fp, 0, $this->delimiter)) != FALSE) {
            if (!$first) {
                $model = $this->setTeacherModel($this->generateMail($line), self::encodingString($line[$this->getPos($this->lastname)]), self::encodingString($line[$this->getPos($this->firstname)]), 1, 2, self::encodingString($line[$this->getPos($this->title)]), $stdPassword);
                $this->saveModel($model);
                $rc = $this->checkModelErrors($model, $msg);
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
        if (count($line) >= 4) {
            foreach ($line as $val) {
                if (!empty($val)) {
                    $this->positions[$val] = $i;
                    $i++;
                }
            }
            $this->checkForColumn($this->firstname, 'firstname');
            $this->checkForColumn($this->lastname, 'lastname');
            $this->checkForColumn($this->email, 'email');
            $this->checkForColumn($this->title, 'title');
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

    private function existsKeys($key) {
        return array_key_exists($key, $this->positions);
    }

    private function checkModelErrors(&$model, &$msg) {
        if ($model->hasErrors()) {
            $msg .= "<-" . $model->email . " " . $model->firstname . " " . $model->lastname . "->" . self::convert_multi_array($model->errors) . "|<br>";
            return false;
        }
        return true;
    }

    private function saveModel(&$model) {
        if ($model->save() && Yii::app()->params['randomTeacherPassword']) {
            $mail = new Mail();
            $mail->sendRandomUserPassword($model->email, $model->password);
        }
    }

    private function generateMail(&$line) {
        if ($line[$this->getPos($this->email)] != NULL) {
            return self::encodingString($line[$this->getPos($this->email)]);
        } else {
            return (preg_replace("/\s+/", "", strtolower(substr(strtr(self::encodingString($line[$this->getPos($this->lastname)]), self::$uml), 0, 1)))
                    . '.' . preg_replace("/\s+/", "", strtolower(strtr(self::encodingString($line[$this->getPos($this->firstname)]), self::$uml))) . '@'
                    . $this->getDomainLink());
        }
    }

    private function getPos($attr) {
        return $this->positions[$attr];
    }

    /**
     * creates new Teacher Model and sets the attributes
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $email
     * @param string $lastname
     * @param string $firstname
     * @param integer $state
     * @param integer $role
     * @param string $title
     * @param string $stdPassword
     * @return \User
     */
    private function setTeacherModel($email, $lastname, $firstname, $state, $role, $title, &$stdPassword = "") {
        $model = new User();
        $model->setSomeAttributes($email, $firstname, $lastname, $state, $role);
        $model->title = $title;
        if (Yii::app()->params['randomTeacherPassword']) {
            $passGen = new PasswordGenerator();
            $model->password = $passGen->generate();
        } else if ($stdPassword != "" && strlen($stdPassword) > 59) {
            $model->password = $stdPassword;
        } else {
            $stdPassword = $model->encryptPassword(Yii::app()->params['defaultTeacherPassword']);
            $model->password = $stdPassword;
        }
        $model->password_repeat = $model->password;
        return $model;
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

    public function getDomainLink() {
        return Yii::app()->params['emailHost'] != 'localhost' ? Yii::app()->params['emailHost'] : Yii::app()->params['schoolWebsiteLink'];
    }

}

?>
