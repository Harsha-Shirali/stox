<div class="watchlistPreloads index">
	<h2><?php echo __('Watchlist Preloads'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('share_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($watchlistPreloads as $watchlistPreload): ?>
	<tr>
		<td><?php echo h($watchlistPreload['WatchlistPreload']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($watchlistPreload['Share']['id'], array('controller' => 'shares', 'action' => 'view', $watchlistPreload['Share']['id'])); ?>
		</td>
		<td><?php echo h($watchlistPreload['WatchlistPreload']['created']); ?>&nbsp;</td>
		<td><?php echo h($watchlistPreload['WatchlistPreload']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $watchlistPreload['WatchlistPreload']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $watchlistPreload['WatchlistPreload']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $watchlistPreload['WatchlistPreload']['id']), null, __('Are you sure you want to delete # %s?', $watchlistPreload['WatchlistPreload']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Watchlist Preload'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
	</ul>
</div>
