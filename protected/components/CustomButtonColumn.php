<?php
/**
 * Ersetzt die Bilder die bei den Tabellenbuttons angezeigt werden und initialisiert die Elternklasse CButtonColumn
 */
/**Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class CustomButtonColumn extends CButtonColumn {

    /**
     * Ersetzt die Bilder die bei den Tabellenbuttons angezeigt werden und initialisiert die Elternklasse CButtonColumn
     * @author David Mock
     * @return void parent::init();
     */
    public function init() {
        $this->viewButtonImageUrl = Yii::app()->request->baseUrl . '/img/search.png';
        $this->viewButtonOptions = array('class' => 'column-button view');
        $this->updateButtonImageUrl = Yii::app()->request->baseUrl . '/img/pencil.png';
        $this->updateButtonOptions = array('class' => 'column-button update');
        $this->deleteButtonImageUrl = Yii::app()->request->baseUrl . '/img/remove.png';
        $this->deleteButtonOptions = array('class' => 'column-button delete');
        return parent::init();
    }

}

?>
