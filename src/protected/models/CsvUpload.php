<?php

class CsvUpload extends CFormModel {

    public $file;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //note you wont need a safe rule here
            array('file', 'file', 'allowEmpty' => true, 'types' => 'csv'),
        );
    }

}

?>
