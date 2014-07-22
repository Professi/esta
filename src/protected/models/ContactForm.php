<?php

/**
 * ContactForm ist die Datenstruktur um Kontaktformdaten zu behalten. 
 */
/*
 * Es wird in der 'contact' action von 'SiteController' verwendet.
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
class ContactForm extends CFormModel {

    /** @var string Name der Person die Kontakt aufnehmen möchte */
    public $name;

    /** @var string E-Mail Adresse */
    public $email;

    /** @var string Betreff */
    public $subject;

    /** @var string Inhalt der Nachricht */
    public $body;

    /** @var string Sicherheitscode */
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('name, email, subject, body', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            array('body', 'length', 'min' => 10),
            array('name,email,subject,body,email', 'length', 'max' => 255),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'verifyCode' => Yii::t('app', 'Sicherheitscode'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'E-Mail'),
            'subject' => Yii::t('app', 'Betreff'),
            'body' => Yii::t('app', 'Ihre Nachricht'),
        );
    }

}
