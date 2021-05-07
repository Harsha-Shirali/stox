<div class="exchanges form">
<?php echo $this->Form->create('Exchange'); ?>
	<fieldset>
		<legend><?php echo __('Edit Exchange'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Exchange.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Exchange.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exchanges'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sharefeeds'), array('controller' => 'sharefeeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sharefeed'), array('controller' => 'sharefeeds', 'action' => 'add')); ?> </li>
	</ul>
</div>
