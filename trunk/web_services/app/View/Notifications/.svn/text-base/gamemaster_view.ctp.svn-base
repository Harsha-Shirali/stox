<div class="notifications view content-with-left-menu">
    <h2><?php echo __('Notification'); ?></h2>
    <dl>
<!--        <dt><?php //echo __('Id'); ?></dt>
        <dd>
            <?php //echo h($notification['Notification']['id']); ?>
            &nbsp;
        </dd>-->
        <dt><?php echo __('Message'); ?></dt>
        <dd>
            <?php echo h($notification['Notification']['message']); ?>            
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($notification['Notification']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($notification['Notification']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>        
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>        
        <li><?php echo $this->Form->postLink(__('Delete Notification'), array('action' => 'delete', $notification['Notification']['id']), null, __('Are you sure you want to delete?', $notification['Notification']['id'])); ?> </li>
        <!--<li><?php //echo $this->Html->link(__('List Notifications'), array('action' => 'index')); ?> </li>-->
        <li><?php echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?> </li>
    </ul>
</div>
