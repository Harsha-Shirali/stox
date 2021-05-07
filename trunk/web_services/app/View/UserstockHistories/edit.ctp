<div class="userstockHistories form">
<?php echo $this->Form->create('UserstockHistory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Userstock History'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_stock_id');
		echo $this->Form->input('share_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('price_at_that_point');
		echo $this->Form->input('type');
		echo $this->Form->input('portfolio_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UserstockHistory.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('UserstockHistory.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Userstock Histories'), array('action' => 'index')); ?></li>
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
