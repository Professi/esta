<?php

?>

<div class="row" id="room-assignall-workspace">
    <div class="small-12 columns">
        <div class="row collapse">
            <div class="small-4 columns">
                <span class="prefix"><?= Yii::t('app', 'Elternsprechtag'); ?></span>
            </div>
            <div class="small-8 columns">
                <?= Select2::dropDownList('', '', $dates, array('id' => 'room-assignall-date')); ?>
            </div>
        </div>
    </div>
    <div class="small-12 columns" id="room-assignall-template">
        <fieldset>
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix"><?= Yii::t('app','Lehrer') ?></span>
                </div>
                <div class="small-4 columns">
                    <input type="text" disabled id="room-assignall-teacher" data-id=""/>
                </div>
                <div class="small-1 columns">&nbsp;</div>
                <div class="small-2 columns">
                    <span class="prefix"><?= Yii::t('app','Raum') ?></span>
                </div>
                <div class="small-3 columns">
                    <input type="text" placeholder="<?= Yii::t('app', 'Geben Sie eine Raumnamen ein') ?>" id="room-assignall-room" />
                </div>
                <div class="row collapse" id="room-assignall-status">
                    <div class="small-1 columns">
                        <div class="small secondary button right prefix"><i class="fi-cloud"></i></div>
                    </div>
                    <div class="small-11 columns">
                        <input type="text" disabled />
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="small button" id="room-assignall-button"><?= Yii::t('app', 'Alles verknüpfen') ?></div>
    <div class="small button" id="room-assignall-errors"><?= Yii::t('app', 'Fehler suchen') ?></div>
</div>
<script>
    var teachers = <?= CJSON::encode($teachers) ?>,
        msg_assignall_button = "<?= Yii::t('app','Wirklich allen Lehrern Räume zuweisen für den ') ?>";
</script>