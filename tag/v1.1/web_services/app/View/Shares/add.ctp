<div class="shares form">
<?php echo $this->Form->create('Share'); ?>
	<fieldset>
		<legend><?php echo __('Add Share'); ?></legend>
	<?php
		echo $this->Form->input('timestamp');
		echo $this->Form->input('symbol');
		echo $this->Form->input('exchange_id');
		echo $this->Form->input('last_trade_price');
		echo $this->Form->input('todays_closing_price');
		echo $this->Form->input('cumulative_volume');
		echo $this->Form->input('last_trade_time');
		echo $this->Form->input('open_price');
		echo $this->Form->input('days_high_price');
		echo $this->Form->input('days_low_price');
		echo $this->Form->input('previous_close_price');
		echo $this->Form->input('bid_price');
		echo $this->Form->input('ask_price');
		echo $this->Form->input('bid_size');
		echo $this->Form->input('ask_size');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Shares'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Share Logs'), array('controller' => 'share_logs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share Log'), array('controller' => 'share_logs', 'action' => 'add')); ?> </li>
	</ul>
</div>
