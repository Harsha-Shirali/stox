<div class="transactions form">
<?php echo $this->Form->create('Transaction', array('novalidate' => true)); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Transaction'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('portfolio_id');
		echo $this->Form->input('status',array('options'=>array('complete'=>'complate', 'pending'=>'pending')));
		echo $this->Form->input('assets');
		echo $this->Form->input('type',array('options'=>array('trade'=>'trade','cash'=>'cash', 'portfolio'=>'portfolio')));
		echo $this->Form->input('price');
		echo $this->Form->input('comments');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
	</ul>
</div>
