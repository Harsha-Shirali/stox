<div class="watchlistPreloads form">
<?php echo $this->Form->create('WatchlistPreload'); ?>
	<fieldset>
		<legend><?php echo __('Add Watchlist Preload'); ?></legend>
	<?php
		echo $this->Form->input('share_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Watchlist Preloads'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
	</ul>
</div>
