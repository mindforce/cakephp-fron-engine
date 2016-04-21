<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('Edit Menu')); ?>

<?php $this->assign('form_create', $this->Form->create($menu)); ?>

<?php
	echo $this->Form->input('id');
	echo $this->Form->input('title');
?>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

<?php $this->assign('form_end', $this->Form->end()); ?>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('List Menus'), ['action' => 'index'], ['class' => 'btn btn-primary']); ?>
	<?= $this->Html->link(__('Delete Menu'), ['action' => 'delete', $menu->id], ['title' => __('Are you sure you want to delete # {0}?', $menu->title), 'class' => 'btn btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
</div>
<?php $this->end(); ?>
