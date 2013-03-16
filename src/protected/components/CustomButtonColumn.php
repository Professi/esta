<?php

/*

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
/**
 * Ersetzt die Bilder die bei den Tabellenbuttons angezeigt werden und initialisiert die Elternklasse CButtonColumn
 *
 * @author David Mock
 */
class CustomButtonColumn extends CButtonColumn  {
    
  public function init()
      {
        $this->viewButtonImageUrl=Yii::app()->request->baseUrl.'/img/search.svg';
        $this->viewButtonOptions=array('class' => 'column-button');
        $this->updateButtonImageUrl=Yii::app()->request->baseUrl.'/img/pencil.svg';
        $this->updateButtonOptions=array('class' => 'column-button');
        $this->deleteButtonImageUrl=Yii::app()->request->baseUrl.'/img/remove.svg';
        $this->deleteButtonOptions=array('class' => 'column-button delete');
        return parent::init();
      }
}
?>
