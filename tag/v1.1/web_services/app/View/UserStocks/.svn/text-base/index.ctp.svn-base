<div class="userStocks index">
	<h2><?php echo __('User Stocks'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('share_id'); ?></th>
			<th><?php echo $this->Paginator->sort('portfolio_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('amount'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($userStocks as $userStock): ?>
	<tr>
		<td><?php echo h($userStock['UserStock']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userStock['User']['username'], array('controller' => 'users', 'action' => 'view', $userStock['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userStock['Share']['id'], array('controller' => 'shares', 'action' => 'view', $userStock['Share']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userStock['Portfolio']['id'], array('controller' => 'portfolios', 'action' => 'view', $userStock['Portfolio']['id'])); ?>
		</td>
		<td><?php echo h($userStock['UserStock']['status']); ?>&nbsp;</td>
		<td><?php echo h($userStock['UserStock']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($userStock['UserStock']['amount']); ?>&nbsp;</td>
		<td><?php echo h($userStock['UserStock']['created']); ?>&nbsp;</td>
		<td><?php echo h($userStock['UserStock']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userStock['UserStock']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userStock['UserStock']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userStock['UserStock']['id']), null, __('Are you sure you want to delete # %s?', $userStock['UserStock']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Stock'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
	</ul>
</div>
