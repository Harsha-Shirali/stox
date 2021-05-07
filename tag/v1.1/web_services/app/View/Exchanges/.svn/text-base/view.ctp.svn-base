<div class="exchanges view">
<h2><?php  echo __('Exchange'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($exchange['Exchange']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($exchange['Exchange']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($exchange['Exchange']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($exchange['Exchange']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Exchange'), array('action' => 'edit', $exchange['Exchange']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Exchange'), array('action' => 'delete', $exchange['Exchange']['id']), null, __('Are you sure you want to delete # %s?', $exchange['Exchange']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Exchanges'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exchange'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sharefeeds'), array('controller' => 'sharefeeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sharefeed'), array('controller' => 'sharefeeds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Sharefeeds'); ?></h3>
	<?php if (!empty($exchange['Sharefeed'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Timestamp'); ?></th>
		<th><?php echo __('Symbol'); ?></th>
		<th><?php echo __('Exchange Id'); ?></th>
		<th><?php echo __('Last Trade Price'); ?></th>
		<th><?php echo __('Todays Closing Price'); ?></th>
		<th><?php echo __('Cumulative Volume'); ?></th>
		<th><?php echo __('Last Trade Time'); ?></th>
		<th><?php echo __('Open Price'); ?></th>
		<th><?php echo __('Days High Price'); ?></th>
		<th><?php echo __('Days Low Price'); ?></th>
		<th><?php echo __('Previous Close Price'); ?></th>
		<th><?php echo __('Bid Price'); ?></th>
		<th><?php echo __('Ask Price'); ?></th>
		<th><?php echo __('Bid Size'); ?></th>
		<th><?php echo __('Ask Size'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($exchange['Sharefeed'] as $sharefeed): ?>
		<tr>
			<td><?php echo $sharefeed['id']; ?></td>
			<td><?php echo $sharefeed['timestamp']; ?></td>
			<td><?php echo $sharefeed['symbol']; ?></td>
			<td><?php echo $sharefeed['exchange_id']; ?></td>
			<td><?php echo $sharefeed['last_trade_price']; ?></td>
			<td><?php echo $sharefeed['todays_closing_price']; ?></td>
			<td><?php echo $sharefeed['cumulative_volume']; ?></td>
			<td><?php echo $sharefeed['last_trade_time']; ?></td>
			<td><?php echo $sharefeed['open_price']; ?></td>
			<td><?php echo $sharefeed['days_high_price']; ?></td>
			<td><?php echo $sharefeed['days_low_price']; ?></td>
			<td><?php echo $sharefeed['previous_close_price']; ?></td>
			<td><?php echo $sharefeed['bid_price']; ?></td>
			<td><?php echo $sharefeed['ask_price']; ?></td>
			<td><?php echo $sharefeed['bid_size']; ?></td>
			<td><?php echo $sharefeed['ask_size']; ?></td>
			<td><?php echo $sharefeed['created']; ?></td>
			<td><?php echo $sharefeed['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sharefeeds', 'action' => 'view', $sharefeed['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sharefeeds', 'action' => 'edit', $sharefeed['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sharefeeds', 'action' => 'delete', $sharefeed['id']), null, __('Are you sure you want to delete # %s?', $sharefeed['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sharefeed'), array('controller' => 'sharefeeds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
