<div class="row">
    <div class="small-12 columns">
        <fieldset>
            <legend><?= Yii::t('app', 'Raum & Lehrer verknüpfen') ?></legend>

            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?php echo Yii::t('app', 'Lehrer'); ?></span>
                </div>
                <div class="small-8 columns">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id' => 'room-assign-teacher',
                        'name' => '',
                        'sourceUrl' => 'index.php?r=user/search&role=2',
                        'options' => array(
                            'minLength' => '1',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => Yii::t('app', 'Geben Sie einen Nachnamen ein'),
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?php echo Yii::t('app', 'Raum'); ?></span>
                </div>
                <div class="small-8 columns">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'id' => 'room-assign-room',
                        'name' => '',
                        'sourceUrl' => 'index.php?r=room/search',
                        'options' => array(
                            'minLength' => '1',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => Yii::t('app', 'Geben Sie einen Raumnamen ein'),
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?= Yii::t('app', 'Elternsprechtag'); ?></span>
                </div>
                <div class="small-8 columns">
                    <?= Select2::dropDownList('', '', $dates, array('id' => 'room-assign-date')); ?>
                </div>
            </div>
            <div class="small button" id="room-assign-button"><?= Yii::t('app', 'Verknüpfen'); ?></div>
            <div class="row collapse" id="room-assign-status">
                <div class="small-1 columns">
                    <div class="small secondary button right prefix"><i class="fi-cloud"></i></div>
                </div>
                <div class="small-11 columns">
                    <input type="text" disabled />
                </div>
            </div>
        </fieldset>
    </div>
</div>