<?php
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this AppointmentController */
/* @var $model User */
?>
<div class="row">
        <div class="twelve columns centered">
                <div class="panel">
                        <p>	Klicken Sie auf einen Buchstaben um sich alle Lehrer, deren Name mit diesem Buchstaben beginnt, anzeigen zu lassen.<br> 
                                Drücken Sie auf den Stern um eine Liste mit allen Lehrer zu erhalten.<br>
                                Sie können alternativ auch den Namen in das Suchfeld eingeben um alle zutreffenden Möglichkeiten zu sehen.<br>
                                Wenn Sie den richtigen Lehrer gefunden haben, 
                                klicken Sie einfach auf das Uhrsymbol neben seinem Namen um zu der Terminvereinbarung des Lehres zu gelangen.
                        </p>
                </div>
            <div class="row">
                <div class="ten columns centered text-center">
                    <fieldset>
                    <div class="hide-for-small" style="line-height:2em;" >
                        <a href="index.php?r=appointment/getTeacher&letter=a" class="tiny teacher button">A</a>
                        <a href="index.php?r=appointment/getTeacher&letter=b" class="tiny teacher button">B</a>
                        <a href="index.php?r=appointment/getTeacher&letter=c" class="tiny teacher button">C</a>
                        <a href="index.php?r=appointment/getTeacher&letter=d" class="tiny teacher button">D</a>
                        <a href="index.php?r=appointment/getTeacher&letter=e" class="tiny teacher button">E</a>
                        <a href="index.php?r=appointment/getTeacher&letter=f" class="tiny teacher button">F</a>
                        <a href="index.php?r=appointment/getTeacher&letter=g" class="tiny teacher button">G</a>
                        <a href="index.php?r=appointment/getTeacher&letter=h" class="tiny teacher button">H</a>
                        <a href="index.php?r=appointment/getTeacher&letter=i" class="tiny teacher button">I</a>
                        <a href="index.php?r=appointment/getTeacher&letter=j" class="tiny teacher button">J</a>
                        <a href="index.php?r=appointment/getTeacher&letter=k" class="tiny teacher button">K</a>
                        <a href="index.php?r=appointment/getTeacher&letter=l" class="tiny teacher button">L</a>
                        <a href="index.php?r=appointment/getTeacher&letter=m" class="tiny teacher button">M</a>
                        <a href="index.php?r=appointment/getTeacher&letter=n" class="tiny teacher button">N</a>
                        <a href="index.php?r=appointment/getTeacher&letter=o" class="tiny teacher button">O</a><br>
                        <a href="index.php?r=appointment/getTeacher&letter=p" class="tiny teacher button">P</a>
                        <a href="index.php?r=appointment/getTeacher&letter=q" class="tiny teacher button">Q</a>
                        <a href="index.php?r=appointment/getTeacher&letter=r" class="tiny teacher button">R</a>
                        <a href="index.php?r=appointment/getTeacher&letter=s" class="tiny teacher button">S</a>
                        <a href="index.php?r=appointment/getTeacher&letter=t" class="tiny teacher button">T</a>
                        <a href="index.php?r=appointment/getTeacher&letter=u" class="tiny teacher button">U</a>
                        <a href="index.php?r=appointment/getTeacher&letter=v" class="tiny teacher button">V</a>
                        <a href="index.php?r=appointment/getTeacher&letter=w" class="tiny teacher button">W</a>
                        <a href="index.php?r=appointment/getTeacher&letter=x" class="tiny teacher button">X</a>
                        <a href="index.php?r=appointment/getTeacher&letter=y" class="tiny teacher button">Y</a>
                        <a href="index.php?r=appointment/getTeacher&letter=z" class="tiny teacher button">Z</a>
                        <a href="index.php?r=appointment/getTeacher&letter=ä" class="tiny teacher button">&Auml;</a>
                        <a href="index.php?r=appointment/getTeacher&letter=ö" class="tiny teacher button">&Ouml</a>
                        <a href="index.php?r=appointment/getTeacher&letter=ü" class="tiny teacher button">&Uuml;</a>
                        <a href="index.php?r=appointment/getTeacher&letter=" class="tiny teacher button">*</a>
                    </div>
                    <div class="show-for-small" style="line-height:2.5em;">
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=a" class="small teacher button">A</a>
                            <a href="index.php?r=appointment/getTeacher&letter=b" class="small teacher button">B</a>
                            <a href="index.php?r=appointment/getTeacher&letter=c" class="small teacher button">C</a>
                            <a href="index.php?r=appointment/getTeacher&letter=d" class="small teacher button">D</a>
                            <a href="index.php?r=appointment/getTeacher&letter=e" class="small teacher button">E</a>
                        </div>
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=f" class="small teacher button">F</a>
                            <a href="index.php?r=appointment/getTeacher&letter=g" class="small teacher button">G</a>
                            <a href="index.php?r=appointment/getTeacher&letter=h" class="small teacher button">H</a>
                            <a href="index.php?r=appointment/getTeacher&letter=i" class="small teacher button">I</a>
                            <a href="index.php?r=appointment/getTeacher&letter=j" class="small teacher button">J</a>
                        </div>
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=k" class="small teacher button">K</a>
                            <a href="index.php?r=appointment/getTeacher&letter=l" class="small teacher button">L</a>
                            <a href="index.php?r=appointment/getTeacher&letter=m" class="small teacher button">M</a>
                            <a href="index.php?r=appointment/getTeacher&letter=n" class="small teacher button">N</a>
                            <a href="index.php?r=appointment/getTeacher&letter=o" class="small teacher button">O</a>
                        </div>
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=p" class="small teacher button">P</a>
                            <a href="index.php?r=appointment/getTeacher&letter=q" class="small teacher button">Q</a>
                            <a href="index.php?r=appointment/getTeacher&letter=r" class="small teacher button">R</a>
                            <a href="index.php?r=appointment/getTeacher&letter=s" class="small teacher button">S</a>
                            <a href="index.php?r=appointment/getTeacher&letter=t" class="small teacher button">T</a>
                        </div>
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=u" class="small teacher button">U</a>
                            <a href="index.php?r=appointment/getTeacher&letter=v" class="small teacher button">V</a>
                            <a href="index.php?r=appointment/getTeacher&letter=w" class="small teacher button">W</a>
                            <a href="index.php?r=appointment/getTeacher&letter=x" class="small teacher button">X</a>
                            <a href="index.php?r=appointment/getTeacher&letter=y" class="small teacher button">Y</a>
                        </div>
                        <div class="left">
                            <a href="index.php?r=appointment/getTeacher&letter=z" class="small teacher button">Z</a>
                            <a href="index.php?r=appointment/getTeacher&letter=ä" class="small teacher button">&Auml;</a>
                            <a href="index.php?r=appointment/getTeacher&letter=ö" class="small teacher button">&Ouml;</a>
                            <a href="index.php?r=appointment/getTeacher&letter=ü" class="small teacher button">&Uuml;</a>
                            <a href="index.php?r=appointment/getTeacher&letter=" class="small teacher button">*</a>
                        </div>
                        <div style="clear:both;"></div> 
                    </div>
                    <br>
                    <div class="row collapse">
                        <div class="three columns">
                            <span class="prefix">Lehrername</span>
                        </div>
                        <div class="nine columns mobile-input">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'name'=>'teacher-ac',
                                //'source'=>$dataProvider,
                                // additional javascript options for the autocomplete plugin
                                'sourceUrl'=>'index.php?r=user/search',
                                'options'=>array(
                                    'minLength'=>'2',
                                ),
                                'htmlOptions'=>array(
                                    //'style'=>'height:20px;',
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
    /**
     * @todo Suche einbauen
     */
    //   'filter' => $dataProvider, 
    'columns' => array(
        'title',
        'firstname',
        'lastname',        
        array(
            'class' => 'CustomButtonColumn', //ändern für zB. Termin vereinbaren
            'template' => '{date}',
            'buttons' => array(
                'date' => array(
                    'label' => 'Termin vereinbaren',
                    'imageUrl' => Yii::app()->request->baseUrl.'/img/alarm.svg',
                    'options' => array('class' => 'column-button')
                ),
            ),
        ),
    )
));
?>
        </div>
</div>
