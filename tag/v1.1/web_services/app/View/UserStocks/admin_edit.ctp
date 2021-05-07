<div class="userStocks form content-with-left-menu">
<?php echo $this->Form->create('UserStock'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User Stock'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('share_id');
		echo $this->Form->input('portfolio_id');
		echo $this->Form->input('status',array('options'=>array('buy'=>'Buy','sell'=>'Sell')));
		echo $this->Form->input('is_pending',array('options'=>array('yes'=>'Yes','no'=>'No')));
		echo $this->Form->input('quantity');
		echo $this->Form->input('total_amount');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UserStock.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('UserStock.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Stocks'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
