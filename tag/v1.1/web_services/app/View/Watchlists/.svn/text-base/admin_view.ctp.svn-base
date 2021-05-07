<div class="watchlists view content-with-left-menu">
<h2><?php  echo __('Watchlist'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($watchlist['Watchlist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Portfolio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($watchlist['Portfolio']['id'], array('controller' => 'portfolios', 'action' => 'view', $watchlist['Portfolio']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Share'); ?></dt>
		<dd>
			<?php echo $this->Html->link($watchlist['Share']['id'], array('controller' => 'shares', 'action' => 'view', $watchlist['Share']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($watchlist['Watchlist']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($watchlist['Watchlist']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<!-- <li><?php //echo $this->Html->link(__('Edit Watchlist'), array('action' => 'edit', $watchlist['Watchlist']['id'])); ?> </li> -->
		<li><?php echo $this->Form->postLink(__('Delete Watchlist'), array('action' => 'delete', $watchlist['Watchlist']['id']), null, __('Are you sure you want to delete # %s?', $watchlist['Watchlist']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Watchlists'), array('action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Watchlist'), array('action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Shares'), array('controller' => 'shares', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Share'), array('controller' => 'shares', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
