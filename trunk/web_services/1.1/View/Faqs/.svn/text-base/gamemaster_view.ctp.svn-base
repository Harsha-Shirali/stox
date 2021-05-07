<div class="faqs view content-with-left-menu">
    <h2><?php echo __('FAQ'); ?></h2>
    <dl>
        <dt><?php echo __('Question'); ?></dt>
        <dd>
            <?php echo h($faq['Faq']['question']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Answer'); ?></dt>
        <dd>
            <?php echo h($faq['Faq']['answer']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Status'); ?></dt>
        <dd>
            <?php echo h(ucfirst($faq['Faq']['status'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($faq['Faq']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($faq['Faq']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($faq['Faq']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($faq['Faq']['modified']))); ?>
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
        <li><?php echo $this->Html->link(__('Edit FAQ'), array('action' => 'edit', $faq['Faq']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete FAQ'), array('action' => 'delete', $faq['Faq']['id']), null, __('Are you sure you want to delete?', $faq['Faq']['id'])); ?> </li>
    </ul>
</div>
