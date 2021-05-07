<div class="sharefeeds index">
	<h2><?php echo __('Sharefeeds'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('timestamp'); ?></th>
			<th><?php echo $this->Paginator->sort('symbol'); ?></th>
			<th><?php echo $this->Paginator->sort('exchange_code'); ?></th>
			<th><?php echo $this->Paginator->sort('last_trade_price'); ?></th>
			<th><?php echo $this->Paginator->sort('todays_closing_price'); ?></th>
			<th><?php echo $this->Paginator->sort('cumulative_volume'); ?></th>
			<th><?php echo $this->Paginator->sort('last_trade_time'); ?></th>
			<th><?php echo $this->Paginator->sort('open_price'); ?></th>
			<th><?php echo $this->Paginator->sort('days_high_price'); ?></th>
			<th><?php echo $this->Paginator->sort('days_low_price'); ?></th>
			<th><?php echo $this->Paginator->sort('previous_close_price'); ?></th>
			<th><?php echo $this->Paginator->sort('bid_price'); ?></th>
			<th><?php echo $this->Paginator->sort('ask_price'); ?></th>
			<th><?php echo $this->Paginator->sort('bid_size'); ?></th>
			<th><?php echo $this->Paginator->sort('ask_size'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sharefeeds as $sharefeed): ?>
	<tr>
		<td><?php echo h($sharefeed['Sharefeed']['id']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['timestamp']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['symbol']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['exchange_code']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['last_trade_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['todays_closing_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['cumulative_volume']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['last_trade_time']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['open_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['days_high_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['days_low_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['previous_close_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['bid_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['ask_price']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['bid_size']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['ask_size']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['created']); ?>&nbsp;</td>
		<td><?php echo h($sharefeed['Sharefeed']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $sharefeed['Sharefeed']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sharefeed['Sharefeed']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sharefeed['Sharefeed']['id']), null, __('Are you sure you want to delete # %s?', $sharefeed['Sharefeed']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Sharefeed'), array('action' => 'add')); ?></li>
	</ul>
</div>
