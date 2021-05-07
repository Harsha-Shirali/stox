<div class="shares view">
<h2><?php  echo __('Share'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($share['Share']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timestamp'); ?></dt>
		<dd>
			<?php echo h($share['Share']['timestamp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Symbol'); ?></dt>
		<dd>
			<?php echo h($share['Share']['symbol']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Id'); ?></dt>
		<dd>
			<?php echo h($share['Share']['exchange_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Trade Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['last_trade_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Todays Closing Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['todays_closing_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cumulative Volume'); ?></dt>
		<dd>
			<?php echo h($share['Share']['cumulative_volume']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Trade Time'); ?></dt>
		<dd>
			<?php echo h($share['Share']['last_trade_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['open_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Days High Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['days_high_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Days Low Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['days_low_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Previous Close Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['previous_close_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bid Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['bid_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ask Price'); ?></dt>
		<dd>
			<?php echo h($share['Share']['ask_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bid Size'); ?></dt>
		<dd>
			<?php echo h($share['Share']['bid_size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ask Size'); ?></dt>
		<dd>
			<?php echo h($share['Share']['ask_size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($share['Share']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($share['Share']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Share'), array('action' => 'edit', $share['Share']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Share'), array('action' => 'delete', $share['Share']['id']), null, __('Are you sure you want to delete # %s?', $share['Share']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shares'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Share Logs'), array('controller' => 'share_logs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Share Log'), array('controller' => 'share_logs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Share Logs'); ?></h3>
	<?php if (!empty($share['ShareLog'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Share Id'); ?></th>
		<th><?php echo __('Timestamp'); ?></th>
		<th><?php echo __('Symbol'); ?></th>
		<th><?php echo __('Exchange Id'); ?></th>
		<th><?php echo __('Last Trade Price'); ?></th>
		<th><?php echo __('Last Trade Price Old'); ?></th>
		<th><?php echo __('Todays Closing Price'); ?></th>
		<th><?php echo __('Todays Closing Price Old'); ?></th>
		<th><?php echo __('Cumulative Volume'); ?></th>
		<th><?php echo __('Cumulative Volume Old'); ?></th>
		<th><?php echo __('Last Trade Time'); ?></th>
		<th><?php echo __('Last Trade Time Old'); ?></th>
		<th><?php echo __('Open Price'); ?></th>
		<th><?php echo __('Open Price Old'); ?></th>
		<th><?php echo __('Days High Price'); ?></th>
		<th><?php echo __('Days High Price Old'); ?></th>
		<th><?php echo __('Days Low Price'); ?></th>
		<th><?php echo __('Days Low Price Old'); ?></th>
		<th><?php echo __('Previous Close Price'); ?></th>
		<th><?php echo __('Previous Close Price Old'); ?></th>
		<th><?php echo __('Bid Price'); ?></th>
		<th><?php echo __('Bid Price Old'); ?></th>
		<th><?php echo __('Ask Price'); ?></th>
		<th><?php echo __('Ask Price Old'); ?></th>
		<th><?php echo __('Bid Size'); ?></th>
		<th><?php echo __('Bid Size Old'); ?></th>
		<th><?php echo __('Ask Size'); ?></th>
		<th><?php echo __('Ask Size Old'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($share['ShareLog'] as $shareLog): ?>
		<tr>
			<td><?php echo $shareLog['id']; ?></td>
			<td><?php echo $shareLog['share_id']; ?></td>
			<td><?php echo $shareLog['timestamp']; ?></td>
			<td><?php echo $shareLog['symbol']; ?></td>
			<td><?php echo $shareLog['exchange_id']; ?></td>
			<td><?php echo $shareLog['last_trade_price']; ?></td>
			<td><?php echo $shareLog['last_trade_price_old']; ?></td>
			<td><?php echo $shareLog['todays_closing_price']; ?></td>
			<td><?php echo $shareLog['todays_closing_price_old']; ?></td>
			<td><?php echo $shareLog['cumulative_volume']; ?></td>
			<td><?php echo $shareLog['cumulative_volume_old']; ?></td>
			<td><?php echo $shareLog['last_trade_time']; ?></td>
			<td><?php echo $shareLog['last_trade_time_old']; ?></td>
			<td><?php echo $shareLog['open_price']; ?></td>
			<td><?php echo $shareLog['open_price_old']; ?></td>
			<td><?php echo $shareLog['days_high_price']; ?></td>
			<td><?php echo $shareLog['days_high_price_old']; ?></td>
			<td><?php echo $shareLog['days_low_price']; ?></td>
			<td><?php echo $shareLog['days_low_price_old']; ?></td>
			<td><?php echo $shareLog['previous_close_price']; ?></td>
			<td><?php echo $shareLog['previous_close_price_old']; ?></td>
			<td><?php echo $shareLog['bid_price']; ?></td>
			<td><?php echo $shareLog['bid_price_old']; ?></td>
			<td><?php echo $shareLog['ask_price']; ?></td>
			<td><?php echo $shareLog['ask_price_old']; ?></td>
			<td><?php echo $shareLog['bid_size']; ?></td>
			<td><?php echo $shareLog['bid_size_old']; ?></td>
			<td><?php echo $shareLog['ask_size']; ?></td>
			<td><?php echo $shareLog['ask_size_old']; ?></td>
			<td><?php echo $shareLog['created']; ?></td>
			<td><?php echo $shareLog['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'share_logs', 'action' => 'view', $shareLog['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'share_logs', 'action' => 'edit', $shareLog['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'share_logs', 'action' => 'delete', $shareLog['id']), null, __('Are you sure you want to delete # %s?', $shareLog['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Share Log'), array('controller' => 'share_logs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
