<?php

class CsvUpload extends CFormModel {

    public $file;
    public $firstname;
    public $lastname;
    public $title;
    public $email;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(array('file', 'file', 'types' => 'csv', 'maxSize' => 5242880,
                'allowEmpty' => true, 'wrongType' => 'Nur CSV Dateien erlaubt.',
                'tooLarge' => 'Datei ist zu groß. Die Begrenzung liegt bei 5 MB.'));
    }

    public function attributeLabels() {
        return array('file' => 'CSV Datei hochladen');
    }

}

?>
