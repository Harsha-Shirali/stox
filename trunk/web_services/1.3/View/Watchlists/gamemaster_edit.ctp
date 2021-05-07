<div class="watchlists form">
<?php echo $this->Form->create('Watchlist'); ?>
	<fieldset>
		<legend><?php echo __('Edit Watchlist'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('portfolio_id');
		echo $this->Form->input('share_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Watchlist.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Watchlist.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Watchlists'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
	</ul>
</div>
