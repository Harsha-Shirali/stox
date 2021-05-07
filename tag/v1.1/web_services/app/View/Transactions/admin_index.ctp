<div class="transactions index content-with-left-menu">
	<h2><?php echo __('Transactions'); ?></h2>
	<div >
        <?php echo $this->Form->create('Transaction',array('type'=>'get')); ?>
        
        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->input('username', array('label' => 'User name', 'type' => 'checkbox', 'value' => $username, 'placeholder' => 'User name', 'class' => 'searchbar','checked'=>$username)); ?>
         <?php echo $this->Form->input('portfolio', array('label' => 'Portfolio', 'type' => 'checkbox', 'value' => $portfolio, 'placeholder' => 'Portfolio name', 'class' => 'searchbar','checked'=>$portfolio)); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php //echo $this->Form->submit('searchicn.png', array('border'=>0,'class'=>'searchicn','title'=>'Search for Creator')); ?>
        <?php echo $this->Form->end(); ?>
	</div>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('portfolio_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('assets'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('comments'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
		<td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($transaction['User']['username'], array('controller' => 'users', 'action' => 'view', $transaction['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($transaction['Portfolio']['portfolio_name'], array('controller' => 'portfolios', 'action' => 'view', $transaction['Portfolio']['id'])); ?>
		</td>
		<td><?php echo h(ucfirst($transaction['Transaction']['status'])); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['assets']); ?>&nbsp;</td>
		<td><?php echo h(ucfirst($transaction['Transaction']['type'])); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['price']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['comments']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $transaction['Transaction']['id']),array('class'=>'view-icon','title'=>'View')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $transaction['Transaction']['id']),array('class'=>'edit-icon','title'=>'Edit')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $transaction['Transaction']['id']),array('class'=>'delete-icon','title'=>'Delete'), null, __('Are you sure you want to delete # %s?', $transaction['Transaction']['id'])); ?>
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
		<!-- <li><?php //echo $this->Html->link(__('New Transaction'), array('action' => 'add')); ?></li> -->
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
