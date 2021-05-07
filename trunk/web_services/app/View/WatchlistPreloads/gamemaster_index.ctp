<?php //pr($WatchlistPreloads); exit;
?>

<div class="index content-with-left-menu">
    <h2><?php echo __('Default Watchlist'); ?></h2>
    
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id','S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('share'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($WatchlistPreloads as $WatchlistPreload): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td><?php echo h($WatchlistPreload['Share']['symbol']); ?>&nbsp;</td>
           
                <td class="actions">
                    <?php echo $this->Form->postLink(__(''), array('action' => 'delete', $WatchlistPreload['WatchlistPreload']['id']), array('class' => 'delete-icon', 'title' => 'Delete'), __('Are you sure you want to delete?', $WatchlistPreload['WatchlistPreload']['id'])); ?>
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
        <li><?php echo $this->Html->link(__('Add to watchlist'), array('controller'=>'shares', 'action' => 'addpreload')); ?></li>
    </ul>
</div>
