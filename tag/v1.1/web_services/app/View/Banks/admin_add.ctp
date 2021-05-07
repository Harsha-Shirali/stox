<div class="banks form content-with-left-menu">
<?php echo $this->Form->create('Bank', array('novalidate' => true)); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Bank'); ?></legend>
	<?php
		echo $this->Form->input('assets');
		echo $this->Form->input('type',array('options'=>array(''=>'Select Type','trade'=>'Trade','cash'=>'Cash')));
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
