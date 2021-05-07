<div class="games index content-with-left-menu">
    <h2><?php echo __('Games'); ?></h2>
    <div >
        <?php echo $this->Form->create('Game', array('type' => 'get')); ?>

        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php //echo $this->Form->submit('searchicn.png', array('border'=>0,'class'=>'searchicn','title'=>'Search for Creator')); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('type'); ?></th>
            <th><?php echo $this->Paginator->sort('status'); ?></th>
            <th><?php echo $this->Paginator->sort('default_trades'); ?></th>
            <th><?php echo $this->Paginator->sort('default_net_value', 'Default Cash'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($games as $game): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td><?php echo h($game['Game']['name']); ?>&nbsp;</td>
                <td><?php echo h(ucfirst($game['Game']['type'])); ?>&nbsp;</td>
                <td><?php echo h(ucfirst($game['Game']['status'])); ?>&nbsp;</td>
                <td><?php echo h($game['Game']['default_trades']); ?>&nbsp;</td>
                <td><?php echo h($game['Game']['default_net_value']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__(''), array('action' => 'view', $game['Game']['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                    <?php echo $this->Html->link(__(''), array('action' => 'edit', $game['Game']['id']), array('class' => 'edit-icon', 'title' => 'Edit')); ?>
                    <?php echo $this->Form->postLink(__(''), array('action' => 'delete', $game['Game']['id']), array('class' => 'delete-icon', 'title' => 'Delete'), __('Are you sure you want to delete?', $game['Game']['id'])); ?>
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
        <li><?php echo $this->Html->link(__('New Game'), array('action' => 'add')); ?></li>
    </ul>
</div>
