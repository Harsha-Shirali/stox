<div class="userstockHistories index">
	<h2><?php echo __('Userstock Histories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_stock_id'); ?></th>
			<th><?php echo $this->Paginator->sort('share_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('price_at_that_point'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('portfolio_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($userstockHistories as $userstockHistory): ?>
	<tr>
		<td><?php echo h($userstockHistory['UserstockHistory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userstockHistory['UserStock']['id'], array('controller' => 'user_stocks', 'action' => 'view', $userstockHistory['UserStock']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userstockHistory['Share']['id'], array('controller' => 'shares', 'action' => 'view', $userstockHistory['Share']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userstockHistory['User']['username'], array('controller' => 'users', 'action' => 'view', $userstockHistory['User']['id'])); ?>
		</td>
		<td><?php echo h($userstockHistory['UserstockHistory']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($userstockHistory['UserstockHistory']['price_at_that_point']); ?>&nbsp;</td>
		<td><?php echo h($userstockHistory['UserstockHistory']['type']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userstockHistory['Portfolio']['id'], array('controller' => 'portfolios', 'action' => 'view', $userstockHistory['Portfolio']['id'])); ?>
		</td>
		<td><?php echo h($userstockHistory['UserstockHistory']['created']); ?>&nbsp;</td>
		<td><?php echo h($userstockHistory['UserstockHistory']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userstockHistory['UserstockHistory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userstockHistory['UserstockHistory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userstockHistory['UserstockHistory']['id']), null, __('Are you sure you want to delete # %s?', $userstockHistory['UserstockHistory']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Userstock History'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
	</ul>
</div>
