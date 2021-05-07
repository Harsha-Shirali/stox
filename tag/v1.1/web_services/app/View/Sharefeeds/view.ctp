<div class="sharefeeds view">
<h2><?php  echo __('Sharefeed'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timestamp'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['timestamp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Symbol'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['symbol']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Code'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['exchange_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Trade Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['last_trade_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Todays Closing Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['todays_closing_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cumulative Volume'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['cumulative_volume']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Trade Time'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['last_trade_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['open_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Days High Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['days_high_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Days Low Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['days_low_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Previous Close Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['previous_close_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bid Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['bid_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ask Price'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['ask_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bid Size'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['bid_size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ask Size'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['ask_size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($sharefeed['Sharefeed']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sharefeed'), array('action' => 'edit', $sharefeed['Sharefeed']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sharefeed'), array('action' => 'delete', $sharefeed['Sharefeed']['id']), null, __('Are you sure you want to delete # %s?', $sharefeed['Sharefeed']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sharefeeds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sharefeed'), array('action' => 'add')); ?> </li>
	</ul>
</div>
