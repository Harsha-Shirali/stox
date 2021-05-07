<div class="watchlists index content-with-left-menu">
	<h2><?php echo __('Watchlists'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('portfolio_id'); ?></th>
			<th><?php echo $this->Paginator->sort('share_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($watchlists as $watchlist): ?>
	<tr>
		<td><?php echo h($watchlist['Watchlist']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($watchlist['Portfolio']['id'], array('controller' => 'portfolios', 'action' => 'view', $watchlist['Portfolio']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($watchlist['Share']['id'], array('controller' => 'shares', 'action' => 'view', $watchlist['Share']['id'])); ?>
		</td>
		<td><?php echo h($watchlist['Watchlist']['created']); ?>&nbsp;</td>
		<td><?php echo h($watchlist['Watchlist']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $watchlist['Watchlist']['id']),array('class'=>'view-icon','title'=>'View')); ?>
			<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $watchlist['Watchlist']['id'])); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $watchlist['Watchlist']['id']),array('class'=>'delete-icon','title'=>'Delete'), null, __('Are you sure you want to delete # %s?', $watchlist['Watchlist']['id'])); ?>
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
		<!-- <li><?php //echo $this->Html->link(__('New Watchlist'), array('action' => 'add')); ?></li> -->
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
