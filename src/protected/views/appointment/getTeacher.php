<?php
/**
 * Auswahl der Lehrer
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
/* @var $this AppointmentController */
/* @var $model User */
$this->setPageTitle(Yii::t('app', 'Lehrerauswahl'));
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="subheader"><?php echo Yii::t('app', 'Lehrerauswahl');?></h2>
        <hr>
        <div class="panel">
            <p><?php echo Yii::t('app', 'Klicken Sie auf einen Buchstaben um sich alle Lehrer, deren Name mit diesem Buchstaben beginnt, anzeigen zu lassen.'); ?><br> 
                <?php echo Yii::t('app', 'Drücken Sie auf den Stern um eine Liste mit allen Lehrer zu erhalten.');?>
            </p>
            <p class="js_show" style="display: none;"><?php echo Yii::t('app', 'Sie können alternativ auch den Namen in das Suchfeld eingeben um alle zutreffenden Möglichkeiten zu sehen.'); ?></p>
            <p><?php echo Yii::t('app', 'Wenn Sie den richtigen Lehrer gefunden haben, klicken Sie einfach auf das Uhrsymbol neben seinem Namen um zu der Terminvereinbarung des Lehres zu gelangen.'); ?> 
            </p>
        </div>
        <div class="row">
            <div class="ten columns centered text-center">
                <fieldset>
                    <div class="hide-for-small" style="line-height:2em;" >
                        <div style="margin-bottom: .6em;">
                            <div style="margin-bottom: .6em;">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=a" class="small teacher button">A</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=b" class="small teacher button">B</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=c" class="small teacher button">C</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=d" class="small teacher button">D</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=e" class="small teacher button">E</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=f" class="small teacher button">F</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=g" class="small teacher button">G</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=h" class="small teacher button">H</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=i" class="small teacher button">I</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=j" class="small teacher button">J</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=k" class="small teacher button">K</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=l" class="small teacher button">L</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=m" class="small teacher button">M</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=n" class="small teacher button">N</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=o" class="small teacher button">O</a>
                            </div>
                            <div>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=p" class="small teacher button">P</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=q" class="small teacher button">Q</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=r" class="small teacher button">R</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=s" class="small teacher button">S</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=t" class="small teacher button">T</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=u" class="small teacher button">U</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=v" class="small teacher button">V</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=w" class="small teacher button">W</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=x" class="small teacher button">X</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=y" class="small teacher button">Y</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=z" class="small teacher button">Z</a>
                                <?php if(strpos(Yii::app()->language, 'de') == 0) {?>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=ü" class="small teacher button">ä</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=ö" class="small teacher button">ö</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=ä" class="small teacher button">ü</a>
                                <?php } ?>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=" class="small teacher button">*</a>
                            </div>
                        </div>
                    </div>
                        <div class="show-for-small" style="line-height:2.5em;">
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=a" class="small teacher button">A</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=b" class="small teacher button">B</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=c" class="small teacher button">C</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=d" class="small teacher button">D</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=e" class="small teacher button">E</a>
                            </div>
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=f" class="small teacher button">F</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=g" class="small teacher button">G</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=h" class="small teacher button">H</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=i" class="small teacher button">I</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=j" class="small teacher button">J</a>
                            </div>
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=k" class="small teacher button">K</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=l" class="small teacher button">L</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=m" class="small teacher button">M</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=n" class="small teacher button">N</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=o" class="small teacher button">O</a>
                            </div>
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=p" class="small teacher button">P</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=q" class="small teacher button">Q</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=r" class="small teacher button">R</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=s" class="small teacher button">S</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=t" class="small teacher button">T</a>
                            </div>
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=u" class="small teacher button">U</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=v" class="small teacher button">V</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=w" class="small teacher button">W</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=x" class="small teacher button">X</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=y" class="small teacher button">Y</a>
                            </div>
                            <div class="left">
                                <a href="index.php?r=appointment/getTeacher&amp;letter=z" class="small teacher button">Z</a>
                                <?php if(strpos(Yii::app()->language, 'de') == 0) {?>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=ae" class="small teacher button">ä</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=oe" class="small teacher button">ö</a>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=ue" class="small teacher button">ü</a>
                                <?php } ?>
                                <a href="index.php?r=appointment/getTeacher&amp;letter=" class="small teacher button">*</a>
                            </div>
                            <div style="clear:both;"></div> 
                        </div>
                        <br>
                        <div class="row collapse js_show" style="display:none;">
                            <div class="three columns">
                                <span class="prefix"><?php echo Yii::t('app', 'Lehrername'); ?></span>
                            </div>
                            <div class="nine columns mobile-input">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'name' => 'teacher-ac',
                                    'sourceUrl' => 'index.php?r=user/search&role=2',
                                    'options' => array(
                                        'minLength' => '2',
                                    ),
                                    'htmlOptions' => array(
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                </fieldset>
            </div>
        </div>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'teacher-grid',
            'dataProvider' => $dataProvider->searchTeacher(),
            'columns' => array(
                'title',
                'firstname',
                'lastname',
                array(
                    'class' => 'CustomButtonColumn', //ändern für zB. Termin vereinbaren
                    'template' => '{date}',
                    'buttons' => array(
                        'date' => array(
                            'label' => Yii::t('app','Termin vereinbaren'),
                            'url' => '"index.php?r=Appointment/makeAppointment&teacher=".$data->id',
                            'imageUrl' => Yii::app()->request->baseUrl . '/img/alarm.png',
                            'options' => array('class' => 'column-button alarm_png',),
                        ),
                    ),
                ),
            )
        ));
        ?>
    </div>
</div>
