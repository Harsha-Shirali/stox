<div class="games form content-with-left-menu">
<?php echo $this->Form->create('Game', array('novalidate' => true)); ?>
	<fieldset>
		<legend><?php echo __('Edit Game'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('type',array('options'=>array('free'=>'Free','paid'=>'Paid')));
		echo $this->Form->input('status',array('options'=>array('active'=>'Active', 'inactive'=>'Inactive')));
		echo $this->Form->input('default_trades');
		echo $this->Form->input('default_net_value', array('label' => 'Default Cash'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Game.id')), null, __('Are you sure you want to delete?', $this->Form->value('Game.id'))); ?></li>
		<!--<li><?php //echo $this->Html->link(__('List Games'), array('action' => 'index')); ?></li>-->
	</ul>
</div>
