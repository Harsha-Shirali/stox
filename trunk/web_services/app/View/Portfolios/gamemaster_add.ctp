<div class="portfolios form">
<?php echo $this->Form->create('Portfolio', array('novalidate' => true)); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Portfolio'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('game_id');
		echo $this->Form->input('portfolio_name');
		echo $this->Form->input('net_value');
		echo $this->Form->input('previous_net_value');
		echo $this->Form->input('trades');
		echo $this->Form->input('is_public',array('options'=>array('yes'=>'Yes','no'=>'No')));
		echo $this->Form->input('is_paid',array('options'=>array('yes'=>'Yes','no'=>'No')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Portfolios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<!--<li><?php //echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>-->
		<li><?php echo $this->Html->link(__('List Transactions'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
