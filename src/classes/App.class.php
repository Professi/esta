<?php

/**
 * Description of App
 *
 * @author cehringfeld
 */
class App {
    private $t = ""; //Objekt von Klasse Template
    private $contentArray = "";

    public function buildWordArray() {
        $contentArray = array(
            "SEITENTITEL" => "Elternsprechtag"
        );
        $this->contentArray = $contentArray;
    }

    public function genHeader() {
        global $step;
        global $searchWord, $step, $usermanagement;
        if ($this->rolle == USER || $this->rolle == "") {
            $step = "";
            $this->rolle = "";
        } else if ($this->rolle == TERMIN) {
            $usermanagement = 0;
        }
        $t = new Template();
        self::buildWordArray($step, $usermanagement, $searchWord);
        self::tplData(HEADER, $this->contentArray, $t);
        $this->t = $t;
    }

    public function genMain() {
        $t = new Template();
        self::buildWordArray();
        self::tplData(MAIN, $this->contentArray, $t);
        echo $this->t->template;
    }

    public function genFooter() {
        if ($this->t instanceof Template) {
            self::tplData(FOOTER, $this->contentArray, $this->t);
            echo $this->t->template;
        }
    }

    public function tplData($templateData, $contentArray, $t) {
        $templatecontent = $t->get_tpldata($templateData);
        $t->templateparser($templatecontent, $contentArray);
        $this->t = $t;
    }

}

?>
