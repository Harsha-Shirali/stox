<div class="banks view content-with-left-menu">
    <h2><?php echo __('Bank'); ?></h2>
    <dl>
        <dt><?php echo __('Assets'); ?></dt>
        <dd>
            <?php echo h($bank['Bank']['assets']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Type'); ?></dt>
        <dd>
            <?php echo h(ucfirst($bank['Bank']['type'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Price'); ?></dt>
        <dd>
            <?php echo h($bank['Bank']['price']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>	
            <?php if ($bank['Bank']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($bank['Bank']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($bank['Bank']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($bank['Bank']['modified']))); ?>
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
        <li><?php echo $this->Html->link(__('Edit Bank'), array('action' => 'edit', $bank['Bank']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Bank'), array('action' => 'delete', $bank['Bank']['id']), null, __('Are you sure you want to delete?', $bank['Bank']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('New Bank'), array('action' => 'add')); ?> </li>
    </ul>
</div>
