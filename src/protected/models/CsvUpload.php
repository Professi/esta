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
     * Validierungsregeln
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

}

?>
