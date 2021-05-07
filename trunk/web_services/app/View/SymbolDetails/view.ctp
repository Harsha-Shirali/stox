<div class="symbolDetails view">
<h2><?php  echo __('Symbol Detail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Symbol'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['symbol']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Name'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['exchange_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Symbol Full Name'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['symbol_full_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($symbolDetail['SymbolDetail']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Symbol Detail'), array('action' => 'edit', $symbolDetail['SymbolDetail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Symbol Detail'), array('action' => 'delete', $symbolDetail['SymbolDetail']['id']), null, __('Are you sure you want to delete # %s?', $symbolDetail['SymbolDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Symbol Details'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Symbol Detail'), array('action' => 'add')); ?> </li>
	</ul>
</div>
