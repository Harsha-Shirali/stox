<div class="users form content-with-left-menu">
<?php echo $this->Form->create('User', array('novalidate' => true)); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php 
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('role',array('options'=>array('User'=>'User','Guest'=>'Guest')));
		echo $this->Form->input('is_registered',array('options'=>array('yes'=>'Yes','no'=>'No')));
		echo $this->Form->input('facebook_id',array('type'=>'text'));
		//echo $this->Form->input('device_id',array('type'=>'text'));
		echo $this->Form->input('status',array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		echo $this->Form->input('job_title');
		echo $this->Form->input('biodata');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('List User Logs'), array('controller' => 'user_logs', 'action' => 'index')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('New User Log'), array('controller' => 'user_logs', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
