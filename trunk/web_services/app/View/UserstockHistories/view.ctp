<div class="userstockHistories view">
<h2><?php  echo __('Userstock History'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Stock'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userstockHistory['UserStock']['id'], array('controller' => 'user_stocks', 'action' => 'view', $userstockHistory['UserStock']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Share'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userstockHistory['Share']['id'], array('controller' => 'shares', 'action' => 'view', $userstockHistory['Share']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userstockHistory['User']['username'], array('controller' => 'users', 'action' => 'view', $userstockHistory['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price At That Point'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['price_at_that_point']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Portfolio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userstockHistory['Portfolio']['id'], array('controller' => 'portfolios', 'action' => 'view', $userstockHistory['Portfolio']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($userstockHistory['UserstockHistory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Userstock History'), array('action' => 'edit', $userstockHistory['UserstockHistory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Userstock History'), array('action' => 'delete', $userstockHistory['UserstockHistory']['id']), null, __('Are you sure you want to delete # %s?', $userstockHistory['UserstockHistory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Userstock Histories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Userstock History'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
	</ul>
</div>
