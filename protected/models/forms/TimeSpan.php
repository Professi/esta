<?php

/* Copyright (C) 2015  Christian Ehringfeld, David Mock
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

class TimeSpan extends CFormModel
{
    public $begin;
    public $end;
    public $duration;

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('begin, end, duration', 'required'),
            array('begin, end', 'date', 'format' => 'H:m'),
            array('duration', 'numerical', 'integerOnly' => true, 'min' => Yii::app()->params['minLengthPerAppointment']),
            array('duration', 'date', 'format' => 'm'),
            array('begin, end, duration', 'safe'),
        );
    }

    public function validate($attributes = null, $clearErrors = true)
    {
        $rc = parent::validate($attributes, $clearErrors);
        if (!is_numeric((strtotime($this->end) - strtotime($this->begin)) / 60 / $this->duration)) {
            $rc = false;
            $this->addError('duration', Yii::t('app', 'Leider ist es anhand Ihrer Angaben nicht möglich immer gleichlange Termine zu erstellen.'));
        }
        return $rc;
    }

    public function attributeLabels()
    {
        return array(
            'begin' => Yii::t('app', 'Anfang'),
            'end' => Yii::t('app', 'Ende'),
            'duration' => Yii::t('app', 'Dauer eines Termins'),
        );
    }
}
