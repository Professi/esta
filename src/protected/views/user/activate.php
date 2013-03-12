<?php
/* @var $this UserController */
?>
<div class="row">
    <div class="twelve columns ">
        <div class="panel">
            <?php if (Yii::app()->user->hasFlash('success')) { ?>
                <h4>Ihr Account wurde aktiviert.</h4>
                <div class="flash-success">
                    <?php echo Yii::app()->user->getFlash('success');
                } else {
                    ?>
                    <h4> Ihr Account konnte leider nicht aktiviert werden. </h4>
                    <div> <?php echo Yii::app()->user->getFlash('activateFail'); ?> </div>
<?php } ?>
            </div>
            </p>
        </div>
    </div>
    <p class="text-center"><?php echo CHtml::link('<b>Zur&uuml;ck zur Startseite</b>', 'index.php'); ?></p>
</div>

