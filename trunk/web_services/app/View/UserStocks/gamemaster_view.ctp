<div class="userStocks view content-without-left-menu">
<h2><?php  echo __('User Stock'); ?></h2>
	<dl>
<!--		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userStock['UserStock']['id']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userStock['User']['username'], array('controller' => 'users', 'action' => 'view', $userStock['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Share'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userStock['Share']['symbol'], array('controller' => 'shares', 'action' => 'view', $userStock['Share']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Portfolio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userStock['Portfolio']['portfolio_name'], array('controller' => 'portfolios', 'action' => 'view', $userStock['Portfolio']['id'])); ?>
			&nbsp;
		</dd>
<!--		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h(ucfirst($userStock['UserStock']['status'])); ?>
			&nbsp;
		</dd>-->
<!--		<dt><?php echo __('Is Pending'); ?></dt>
		<dd>
			<?php echo h(ucfirst($userStock['UserStock']['is_pending'])); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($userStock['UserStock']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Amount'); ?></dt>
		<dd>
			<?php echo h($userStock['UserStock']['total_amount']); ?>
			&nbsp;
		</dd>
<!--		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php if ($userStock['UserStock']['created'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($userStock['UserStock']['created']))); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php if ($userStock['UserStock']['modified'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($userStock['UserStock']['modified']))); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
			&nbsp;
		</dd>-->
	</dl>
</div>
<!--<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Stock'), array('action' => 'edit', $userStock['UserStock']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Stock'), array('action' => 'delete', $userStock['UserStock']['id']), null, __('Are you sure you want to delete # %s?', $userStock['UserStock']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Stocks'), array('action' => 'index')); ?> </li>
		 <li><?php //echo $this->Html->link(__('New User Stock'), array('action' => 'add')); ?> </li> 
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		 <li><?php //echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li> 
		 <li><?php //echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li> 
		 <li><?php //echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li> 
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		 <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> 
	</ul>
</div>-->
