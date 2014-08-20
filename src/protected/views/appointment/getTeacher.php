<?php
/**
 * Auswahl der Lehrer
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
    <div class="small-12 columns small-centered">
        <h2 class="subheader"><?php echo Yii::t('app', 'Lehrerauswahl');?></h2>
        <hr>
        <div class="paper panel">
            <p><?php echo Yii::t('app', 'Klicken Sie auf einen Buchstaben um sich alle Lehrer, deren Name mit diesem Buchstaben beginnt, anzeigen zu lassen.'); ?><br> 
                <?php echo Yii::t('app', 'Drücken Sie auf den Stern um eine Liste mit allen Lehrer zu erhalten.');?>
            </p>
            <p class="js_show" style="display: none;"><?php echo Yii::t('app', 'Sie können alternativ auch den Namen in das Suchfeld eingeben um alle zutreffenden Möglichkeiten zu sehen.'); ?></p>
            <p><?php echo Yii::t('app', 'Wenn Sie den richtigen Lehrer gefunden haben, klicken Sie einfach auf das Uhrsymbol neben seinem Namen um zu der Terminvereinbarung des Lehres zu gelangen.'); ?> 
            </p>
        </div>
    </div>
</div>
<div class="row">
    <fieldset class="small-12 columns small-centered text-center">
        <div class="row collapse">
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=a" class="tiny teacher button">A</a>        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=b" class="tiny teacher button">B</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=c" class="tiny teacher button">C</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=d" class="tiny teacher button">D</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=e" class="tiny teacher button">E</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=f" class="tiny teacher button">F</a>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=g" class="tiny teacher button">G</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=h" class="tiny teacher button">H</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=i" class="tiny teacher button">I</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=j" class="tiny teacher button">J</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=k" class="tiny teacher button">K</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=l" class="tiny teacher button">L</a>                        
            </div>
        </div>
        <div class="row collapse">
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=m" class="tiny teacher button">M</a>                        
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=n" class="tiny teacher button">N</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=o" class="tiny teacher button">O</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=p" class="tiny teacher button">P</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=q" class="tiny teacher button">Q</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=r" class="tiny teacher button">R</a>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=s" class="tiny teacher button">S</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=t" class="tiny teacher button">T</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=u" class="tiny teacher button">U</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=v" class="tiny teacher button">V</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=w" class="tiny teacher button">W</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=x" class="tiny teacher button">X</a>                        
            </div>
        </div>
        <div class="row collapse">
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=y" class="tiny teacher button">Y</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=z" class="tiny teacher button">Z</a>
            </div>
            <?php if(strpos(Yii::app()->language, 'de') == 0) {?>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=ü" class="tiny teacher button">&Auml;</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=ö" class="tiny teacher button">&Ouml;</a>
            </div>
            <div class="small-2 columns">
                <a href="index.php?r=appointment/getTeacher&amp;letter=ä" class="tiny teacher button">&Uuml;</a>                            
            </div>
            <?php } ?>
            <div class="small-2 columns end">
                <a href="index.php?r=appointment/getTeacher&amp;letter=" class="tiny teacher button">*</a>
            </div>
        </div>
        <div class="row collapse js_show" style="display:none;">
            <br>
            <div class="small-4 columns">
                <span class="prefix"><?php echo Yii::t('app', 'Lehrername'); ?></span>
            </div>
            <div class="small-8 columns mobile-input">
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
<div class="row">
    <div class="small-12 columns small-centered">
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
                            'label' => '<i class="fi-clock"></i>',
                            /** @todo must be changed, user can manipulate it */
                            'url' => '"index.php?r=Appointment/makeAppointment&teacher=".$data->id',
                            'imageUrl' => false,
                            'options' => array('class' => 'table-button clock',
                                'title' => Yii::t('app','Termin vereinbaren')),
                        ),
                    ),
                ),
            )
        ));
        ?>
    </div>
</div>
        
