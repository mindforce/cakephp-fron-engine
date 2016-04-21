<?php $this->extend('/Admin/Common/index'); ?>

<?php $this->assign('title', __d('front-engine', 'Menu manager')); ?>

<table class="table table-striped">
	<tr>
		<th><?= $this->Paginator->sort('id'); ?></th>
		<th><?= $this->Paginator->sort('title'); ?></th>
		<th><?= $this->Paginator->sort('link'); ?></th>
		<th><?= $this->Paginator->sort('home'); ?></th>
		<th><?= $this->Paginator->sort('state'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($links as $link): ?>
	<tr>
		<td><?= h($link->id); ?>&nbsp;</td>
		<td><?= h($link->title); ?>&nbsp;</td>
		<td><?= h($link->link); ?>&nbsp;</td>
		<td><?= $link->home ? $this->Html->icon('check', ['iconSet' => 'fa']) : $this->Html->icon('times', ['iconSet' => 'fa']); ?>&nbsp;</td>
		<td><?= $link->state ? $this->Html->icon('check', ['iconSet' => 'fa']) : $this->Html->icon('times', ['iconSet' => 'fa']); ?>&nbsp;</td>
		<td class="actions">
			<?= $this->Html->link(__('Edit'), ['controller' => 'Links', 'action' => 'edit', $link->id], ['class' => 'btn btn-sm btn-warning', 'icon' => 'edit']); ?>
			<?= $this->Html->link(__('Delete'), ['controller' => 'Links', 'action' => 'delete', $link->id], ['title' => __('Are you sure you want to delete # {0}?', $link->id), 'class' => 'btn btn-sm btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>


<?php $this->start('actions'); ?>
<div class="btn-group">
	<?php if($menuId = $this->request->data('menu_id')): ?>
		<?= $this->Html->link(__('New Link'), ['controller' => 'Links', 'action' => 'add', $menuId], ['class' => 'btn btn-primary']); ?>
	<?php endif; ?>
	<?= $this->Html->link(__('New Menu'), ['action' => 'add'], ['class' => 'btn btn-default']); ?>
	<?php if($menuId = $this->request->data('menu_id')): ?>
		<?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menuId], ['class' => 'btn btn-warning']); ?>
		<?= $this->Html->link(__('Delete Menu'), ['action' => 'delete', $menuId], ['class' => 'btn btn-danger']); ?>
	<?php endif; ?>
</div>
<?php $this->end(); ?>
