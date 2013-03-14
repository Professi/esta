<?php

class CsvUpload extends CFormModel {
 
    public $csv;
 
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //note you wont need a safe rule here
            array('file', 'allowEmpty' => true, 'types' => 'csv'),
        );
    }
 
}
?>
