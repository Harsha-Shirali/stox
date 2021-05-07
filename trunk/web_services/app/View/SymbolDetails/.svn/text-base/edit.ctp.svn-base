<div class="symbolDetails form">
<?php echo $this->Form->create('SymbolDetail'); ?>
	<fieldset>
		<legend><?php echo __('Edit Symbol Detail'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('symbol');
		echo $this->Form->input('exchange_name');
		echo $this->Form->input('symbol_full_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SymbolDetail.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SymbolDetail.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Symbol Details'), array('action' => 'index')); ?></li>
	</ul>
</div>
