<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
		<?php echo $content; ?>
<div class="push"></div>
<div class="row">
	<div id="sidebar" class="twelve columns">
	<?php
		$this->beginWidget('zii.widgets.CPortlet');
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'button-group even'),
		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>