<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('Add Link')); ?>

<?php $this->assign('form_create', $this->Form->create($link)); ?>
<div class="col-md-7">
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('menu_id', array(
			'type' => 'select2',
			'options' => $menus,
			'default' => $link->menu_id
		));
		echo $this->Form->input('parent_id', array(
			'type' => 'select2',
			'options' => $links,
			'empty' => array('' => '')
		));
		echo $this->Form->input('title', array(
			'type' => 'text',
		));
		echo $this->Form->input('link', array(
			'type' => 'text',
		));
	?>
</div>
<div class="col-md-5">
	<?php
		echo $this->Form->input('homepage', array(
			'type' => 'switcher',
			'label' => __d('front_engine', 'Set as homepage')
		));
		echo $this->Form->input('state', array(
			'type' => 'switcher',
			'label' => __d('front_engine', 'State')
		));
	?>
</div>
<div class="clearfix"></div>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

<?php $this->assign('form_end', $this->Form->end()); ?>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('Back to Menu'), ['action' => 'index', '?' => ['menu_id' => $link->menu_id]], ['class' => 'btn btn-primary']); ?>
</div>
<?php $this->end(); ?>
