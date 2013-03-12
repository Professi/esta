<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewPw
 *
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */
class NewPw extends CFormModel {

    public $password;
    public $password_repeat;
    public $activationKey;

    public function rules() {
        return array(
            array('password','activationKey', 'required'),
            array('password', 'length', 'max' => 128, 'min' => 8),
            array('password', 'compare', "on" => "insert"),
            array('password_repeat', 'safe'), //allow bulk assignment 
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'password' => 'Passwort',
            'password_repeat' => 'Passwort wiederholen',
        );
    }

}

?>
