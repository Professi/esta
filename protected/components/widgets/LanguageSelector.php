<?php
/*
 * http://www.yiiframework.com/wiki/293/manage-target-language-in-multilingual-applications-a-language-selector-widget-i18n/
 */
class LanguageSelector extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language;
        $languages = Yii::app()->params->languages;
        $this->render('languageSelector', array('currentLang' => $currentLang, 'languages'=>$languages));
    }
}
