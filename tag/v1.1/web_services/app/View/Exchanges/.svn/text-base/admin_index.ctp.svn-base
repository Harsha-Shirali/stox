<div class="exchanges index content-without-left-menu">
	<h2><?php echo __('Exchanges'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('full_name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($exchanges as $exchange): ?>
	<tr>
		<td><?php echo h($exchange['Exchange']['id']); ?>&nbsp;</td>
		<td><?php echo h($exchange['Exchange']['name']); ?>&nbsp;</td>
		<td><?php echo h($exchange['Exchange']['full_name']); ?>&nbsp;</td>
		<td><?php echo h($exchange['Exchange']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $exchange['Exchange']['id']),array('class'=>'view-icon','title'=>'View')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $exchange['Exchange']['id']),array('class'=>'edit-icon','title'=>'Edit')); ?>
			<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $exchange['Exchange']['id']), null, __('Are you sure you want to delete # %s?', $exchange['Exchange']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<!-- div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New Exchange'), array('action' => 'add')); ?></li>
		<li><?php// echo $this->Html->link(__('List Sharefeeds'), array('controller' => 'sharefeeds', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Sharefeed'), array('controller' => 'sharefeeds', 'action' => 'add')); ?> </li>
	</ul> 
</div>-->
