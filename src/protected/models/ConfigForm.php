<?php

/** Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class ConfigForm extends CFormModel {
    public $adminEmail;
    public $dateTimeFormat;
    public $emailHost;
    public $fromMailHost;
    public $fromMail;
    public $teacherMail;
    public $schoolName;
    public $virtualHost;
    public $mailsActivated;
    public $maxChild;
    public $maxTanGen;
    public $maxAppointmentsPerChild;
    public $randomTeacherPassword;
    public $defaultTeacherPassword;
    public $minLengthPerAppointment;
    public $banUsers;
    public $durationTempBans;
    public $maxAttemptsForLogin;
    public $salt;
    public $installed;
    
    public function init() {
        $arr = Yii::app()->params->toArray();
        $this->attributes = $arr;
    }
    
    public function rules() {
        return array(
            array('adminEmail,dateTimeFormat,emailHost,fromMailHost,fromMail'.
                ',teacherMail,schoolName,virtualHost,mailsActivated,maxChild,'
                .'maxTanGen,maxAppointmentsPerChild,randomTeacherPassword,'.
                'defaultTeacherPassword,minLengthPerAppointment,banUsers,'.
                'durationTempBans,maxAttemptsForLogin', 'safe'),
            array('salt,installed','safe','on'=>Yii::app()->params['installed']==0)
        );
    }
    
    
}

?>
