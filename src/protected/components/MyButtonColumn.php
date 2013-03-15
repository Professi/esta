<?php

/*

/**
 * Ersetzt die Bilder die bei den Tabellenbuttons angezeigt werden und initialisiert die Elternklasse CButtonColumn
 *
 * @author David Mock
 */
class MyButtonColumn extends CButtonColumn  {
    
  public function init()
      {
        $this->viewButtonImageUrl=Yii::app()->request->baseUrl.'/img/search.svg';
        $this->viewButtonOptions=array('class' => 'column-button');
        $this->updateButtonImageUrl=Yii::app()->request->baseUrl.'/img/pencil.svg';
        $this->updateButtonOptions=array('class' => 'column-button');
        $this->deleteButtonImageUrl=Yii::app()->request->baseUrl.'/img/remove.svg';
        $this->deleteButtonOptions=array('class' => 'column-button');
        return parent::init();
      }
}
?>
