<?php
$this->renderPartial('indexTeacher', array(
                'dataProvider' => $dataProvider->customSearch()
            ));
$this->renderPartial('indexBlockApp', array(
                'dataProviderBlock' => $blockedApp->search(),
            ));
?>
