<div class="portfolios view">
<h2><?php  echo __('Portfolio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($portfolio['User']['username'], array('controller' => 'users', 'action' => 'view', $portfolio['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Game'); ?></dt>
		<dd>
			<?php echo $this->Html->link($portfolio['Game']['name'], array('controller' => 'games', 'action' => 'view', $portfolio['Game']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Net Value'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['net_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trades'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['trades']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Portfolio Name'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['portfolio_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Public'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['is_public']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Paid'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['is_paid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($portfolio['Portfolio']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Portfolio'), array('action' => 'edit', $portfolio['Portfolio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Portfolio'), array('action' => 'delete', $portfolio['Portfolio']['id']), null, __('Are you sure you want to delete # %s?', $portfolio['Portfolio']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>
	</ul>
</div>
