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

    /** @var string E-Mail Adresse */
    public $email;

    /**
     * validation rules
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(array('file', 'file', 'types' => 'csv', 'maxSize' => 5242880,
                'allowEmpty' => true, 'wrongType' => 'Nur CSV Dateien erlaubt.',
                'tooLarge' => 'Datei ist zu groß. Die Begrenzung liegt bei 5 MB.'));
    }

    /**
     * Attributlabels
     * @return array Labels
     */
    public function attributeLabels() {
        return array('file' => 'CSV Datei hochladen');
    }

    /**
     * Creates Teachers with csv file
     * csv must have these columns: Nachname, Vorname, Email, Titel
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param resource $fp
     * @param string $msg
     * @return boolean
     */
    public function createTeachers(&$fp, &$msg) {
        $first = true;
        $rc = true;
        $stdPassword = "";
        do {
            if (!$first && ($line[0] != "Vorname" && !$line[1] != "Nachname" && $line[2] != 'Email')) {
                if ($line[2] != NULL) {
                    $email = self::encodingString($line[2]);
                } else {
                    $uml = array("Ö" => "Oe", "ö" => "oe", "Ä" => "Ae", "ä" => "ae", "Ü" => "Ue", "ü" => "ue", "ß" => "ss",);
                    $email = preg_replace("/\s+/", "", strtolower(substr(strtr(self::encodingString($line[1]), $uml), 0, 1)))
                            . '.' . preg_replace("/\s+/", "", strtolower(strtr(self::encodingString($line[0]), $uml))) . '@'
                            . Yii::app()->params['teacherMail'];
                }
                $model = $this->setTeacherModel($email, self::encodingString($line[0]), self::encodingString($line[1]), 1, 2, self::encodingString($line[3]), $stdPassword);
                if ($model->insert() && Yii::app()->params['randomTeacherPassword']) {
                    $mail = new Mail();
                    $mail->sendRandomUserPassword($model->email, $model->password);
                }
                if ($model->hasErrors()) {
                    $rc = false;
                    $msg .= "<-" . $model->email . " " . $model->firstname . " " . $model->lastname . "->" . self::convert_multi_array($model->errors) . "|<br>";
                }
            } else {
                $first = false;
            }
        } while (($line = fgetcsv($fp, 1000, ";")) != FALSE);
        return $rc;
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
        $model->setSomeAttributes($email, $lastname, $firstname, $state, $role);
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

}

?>
