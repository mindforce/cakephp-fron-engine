<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('Add Menu')); ?>

<?php $this->assign('form_create', $this->Form->create($menu)); ?>

<?= $this->Form->input('title', array('class'=>'required')); ?>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

<?php $this->assign('form_end', $this->Form->end()); ?>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('List Menus'), ['action' => 'index'], ['class' => 'btn btn-primary']); ?>
</div>
<?php $this->end(); ?>
