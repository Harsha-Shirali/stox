<div class="exchanges form">
<?php echo $this->Form->create('Exchange'); ?>
	<fieldset>
		<legend><?php echo __('Add Exchange'); ?></legend>
	<?php
		echo $this->Form->input('code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Exchanges'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sharefeeds'), array('controller' => 'sharefeeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sharefeed'), array('controller' => 'sharefeeds', 'action' => 'add')); ?> </li>
	</ul>
</div>
