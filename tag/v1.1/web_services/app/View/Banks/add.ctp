<div class="banks form">
<?php echo $this->Form->create('Bank'); ?>
	<fieldset>
		<legend><?php echo __('Add Bank'); ?></legend>
	<?php
		echo $this->Form->input('virtual_money');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Banks'), array('action' => 'index')); ?></li>
	</ul>
</div>
