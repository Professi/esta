<?php

/**
 * Description of Template
 *
 * Generates with a PHP String, correct HTML Code
 * @author Christian Ehringfeld
 */
class Template {

    public $template = "";

    /*
     * Name: templateparser(Datei, Platzhalter Array)
     * Autor:Christian Ehringfeld
     * Funktion: ersetzt Platzhalter in Template
     */

    public function templateparser($templatedata, $wertearray) {
        if (is_array($wertearray)) {
            foreach ($wertearray as $key => $value) {
                $suchmuster = "/<%%(" . strtoupper($key) . ")%%>/si";
                //Gefundene Platzhalter mit Werten aus wertearray ersetzen
                $templatedata = preg_replace($suchmuster, $value, $templatedata);
            }
            //Nicht ersetzte Platzhalter aus Template entfernen
            $templatedata = preg_replace("/((<%%)(.+?)(%%>))/si", '', $templatedata);
        }
        $this->template .= (implode("", $templatedata));
    }

    /*
     * Name: get_tpldata(Datei)
     * Autor: Christian Ehringfeld
     * Funktion: Prüft ob eine Datei vorhanden ist, die geöffnet werden soll.
     * Falls die Datei vorhanden ist, wird sie zurückgegeben.
     */

    public function get_tpldata($templateData) {
        if (file_exists($templateData)) {
            $templatecontent = file($templateData);
        } else {
            echo "Datei konnte nicht geöffnet werden!";
        }
        return $templatecontent;
    }
    
    
    
}

?>
