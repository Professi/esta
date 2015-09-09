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

/**
 * Description of TimeSpan
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class TimeSpan extends CFormModel {

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('begin, end', 'required'),
            array('begin, end', 'date', 'format' => 'H:m'),
            array('begin, end', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'begin' => Yii::t('app', 'Anfang'),
            'end' => Yii::t('app', 'Ende'),
        );
    }

}
