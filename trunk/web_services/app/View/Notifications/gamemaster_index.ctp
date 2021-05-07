<div class="notifications index content-with-left-menu">
    <h2><?php echo __('Notifications'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('message'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>			
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($notifications as $notification): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td><?php echo h($notification['Notification']['message']); ?>&nbsp;</td>
                <td>
                    <?php if($notification['Notification']['created']!=0) { ?>
                    <?php echo h(date('M d, Y H:i:s', strtotime($notification['Notification']['created']))); ?>
                    <?php } else { ?>
                        ---
                    <?php } ?>
                    &nbsp;
                </td>                
                <td class="actions">
                    <?php echo $this->Html->link(__(''), array('action' => 'view', $notification['Notification']['id']), array('class'=>'view-icon','title'=>'View')); ?>
                    <?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $notification['Notification']['id'])); ?>
                    <?php echo $this->Form->postLink(__(''), array('action' => 'delete', $notification['Notification']['id']), array('class'=>'delete-icon','title'=>'Delete'), __('Are you sure you want to delete?', $notification['Notification']['id'])); ?>
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
        <li><?php echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?></li>
    </ul>
</div>
