<div class="userStocks form">
<?php echo $this->Form->create('UserStock'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add User Stock'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('share_id');
		echo $this->Form->input('portfolio_id');
		echo $this->Form->input('status');
		echo $this->Form->input('is_pending');
		echo $this->Form->input('quantity');
		echo $this->Form->input('total_amount');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Stocks'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
	</ul>
</div>
