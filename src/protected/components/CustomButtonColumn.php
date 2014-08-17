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
        $this->viewButtonImageUrl = false;
        $this->viewButtonLabel = '<i class="fi-magnifying-glass"></i>';
        $this->viewButtonOptions = array('class' => 'table-button view','title' => Yii::t('zii', 'View'));
        $this->updateButtonImageUrl = false;
        $this->updateButtonLabel = '<i class="fi-pencil"></i>';
        $this->updateButtonOptions = array('class' => 'table-button update','title' => Yii::t('zii', 'Update'));
        $this->deleteButtonImageUrl = false;
        $this->deleteButtonLabel = '<i class="fi-trash"></i>';
        $this->deleteButtonOptions = array('class' => 'table-button delete','title' => Yii::t('zii', 'Delete'));
        
        $this->htmlOptions = array('class' => 'text-center');
        $this->headerHtmlOptions = array();
        $this->footerHtmlOptions = array();
        
        return parent::init();
    }

}

?>
