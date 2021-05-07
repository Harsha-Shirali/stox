<div class="banks index content-with-left-menu">
    <h2><?php echo __('Banks'); ?></h2>
    <div >
        <?php echo $this->Form->create('Bank', array('type' => 'get')); ?>
        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('assets'); ?></th>
            <th><?php echo $this->Paginator->sort('product_name'); ?></th>
            <th><?php echo $this->Paginator->sort('type'); ?></th>
            <th><?php echo $this->Paginator->sort('price'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($banks as $bank): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td><?php echo h($bank['Bank']['assets']); ?>&nbsp;</td>
                <td><?php echo h($bank['Bank']['product_name']); ?>&nbsp;</td>
                <td><?php echo h(ucfirst($bank['Bank']['type'])); ?>&nbsp;</td>
                <td><?php echo h($bank['Bank']['price']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__(''), array('action' => 'view', $bank['Bank']['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                    <?php echo $this->Html->link(__(''), array('action' => 'edit', $bank['Bank']['id']), array('class' => 'edit-icon', 'title' => 'Edit')); ?>
                    <?php echo $this->Form->postLink(__(''), array('action' => 'delete', $bank['Bank']['id']), array('class' => 'delete-icon', 'title' => 'Delete'), __('Are you sure you want to delete?', $bank['Bank']['id'])); ?>
                </td>
            </tr>
            <?php $i++;
        endforeach; ?>
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
        <li><?php echo $this->Html->link(__('New Bank'), array('action' => 'add')); ?></li>
    </ul>
</div>
