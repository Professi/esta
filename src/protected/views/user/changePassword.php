<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php if (Yii::app()->user->isGuest) { //  && !isset($_POST['email'])?>
    <div><p>Wollen Sie wirklich ihr Passwort ändern. Bitte EMail adresse angeben.</p></div>
    <?php
 //   echo $this->renderPartial('pwChangeForm', array('model' => $model));
} else {
    ?>
    <?php if (isset(Yii::app()->user->getFlash('success'))) {
        ?>  <div><p><?php // echo Yii::app()->user->getFlash('success'); ?></p></div><?php
    } else {
        if (isset(Yii::app()->user->getFlash('failMsg'))) {
            ?> <div><p><?php //echo Yii::app()->user->getFlash('failMsg'); ?></p></div>  
            <?
        }
    }
}
?>