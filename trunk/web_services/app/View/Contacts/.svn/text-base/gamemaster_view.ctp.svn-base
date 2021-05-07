<div class="contacts view content-with-left-menu">
    <h2><?php echo __('Contact'); ?></h2>
    <dl>
<!--        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($contact['Contact']['id']); ?>
            &nbsp;
        </dd>-->
        <dt><?php echo __('Subject'); ?></dt>
        <dd>
            <?php echo h($contact['Contact']['subject']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Queries'); ?></dt>
        <dd>
            <?php echo h($contact['Contact']['queries']); ?>
            &nbsp;
        </dd>
<!--        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($contact['Contact']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($contact['Contact']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($contact['Contact']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($contact['Contact']['modified']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>-->
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
    <!-- 	<li><?php // echo $this->Html->link(__('Edit Contact'), array('action' => 'edit', $contact['Contact']['id']));  ?> </li> -->
        <li><?php echo $this->Form->postLink(__('Delete Contact'), array('action' => 'delete', $contact['Contact']['id']), null, __('Are you sure you want to delete?', $contact['Contact']['id'])); ?> </li>
        <!--<li><?php echo $this->Html->link(__('List Contacts'), array('action' => 'index')); ?> </li>-->
        <!-- <li><?php //echo $this->Html->link(__('New Contact'), array('action' => 'add'));  ?> </li> -->
    </ul>
</div>
