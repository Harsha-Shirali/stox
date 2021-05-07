	<div class="faqs index content-with-left-menu">
	<h2><?php echo __('FAQs'); ?></h2>
	<div >
        <?php echo $this->Form->create('Faq',array('type'=>'get')); ?>
        
        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php //echo $this->Form->submit('searchicn.png', array('border'=>0,'class'=>'searchicn','title'=>'Search for Creator')); ?>
        <?php echo $this->Form->end(); ?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
			<th><?php echo $this->Paginator->sort('question'); ?></th>
			<th><?php echo $this->Paginator->sort('answer'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
	<?php foreach ($faqs as $faq): ?>
	<tr>
		<td><?php echo $i; ?>&nbsp;</td>
		<td><?php echo h($faq['Faq']['question']); ?>&nbsp;</td>
		<td><?php echo h($faq['Faq']['answer']); ?>&nbsp;</td>
		<td><?php echo h(ucfirst($faq['Faq']['status'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $faq['Faq']['id']),array('class'=>'view-icon','title'=>'View')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $faq['Faq']['id']),array('class'=>'edit-icon','title'=>'Edit')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $faq['Faq']['id']),array('class'=>'delete-icon','title'=>'Delete'),  __('Are you sure you want to delete?', $faq['Faq']['id'])); ?>
		</td>
	</tr>
<?php $i++; endforeach; ?>
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
		<li><?php echo $this->Html->link(__('New FAQ'), array('action' => 'add')); ?></li>
	</ul>
</div>
