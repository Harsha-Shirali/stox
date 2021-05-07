<div class="exchanges view content-with-left-menu">
    <h2><?php echo __('Exchange'); ?></h2>
    <dl>
<!--        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($exchange['Exchange']['id']); ?>
            &nbsp;
        </dd>-->
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($exchange['Exchange']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Full name'); ?></dt>
        <dd>
            <?php echo h($exchange['Exchange']['full_name']); ?>
            &nbsp;
        </dd>
<!--        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($exchange['Exchange']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($exchange['Exchange']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($exchange['Exchange']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($exchange['Exchange']['modified']))); ?>
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
        <li><?php echo $this->Html->link(__('Edit Exchange'), array('action' => 'edit', $exchange['Exchange']['id'])); ?> </li>
        <!--<li><?php //echo $this->Html->link(__('List Exchanges'), array('action' => 'index')); ?> </li>-->
    </ul>
</div>

