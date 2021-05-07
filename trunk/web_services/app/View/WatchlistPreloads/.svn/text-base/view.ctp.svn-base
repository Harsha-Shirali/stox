<div class="watchlistPreloads view">
<h2><?php  echo __('Watchlist Preload'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($watchlistPreload['WatchlistPreload']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Share'); ?></dt>
		<dd>
			<?php echo $this->Html->link($watchlistPreload['Share']['id'], array('controller' => 'shares', 'action' => 'view', $watchlistPreload['Share']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($watchlistPreload['WatchlistPreload']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($watchlistPreload['WatchlistPreload']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Watchlist Preload'), array('action' => 'edit', $watchlistPreload['WatchlistPreload']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Watchlist Preload'), array('action' => 'delete', $watchlistPreload['WatchlistPreload']['id']), null, __('Are you sure you want to delete # %s?', $watchlistPreload['WatchlistPreload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Watchlist Preloads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Watchlist Preload'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
	</ul>
</div>
