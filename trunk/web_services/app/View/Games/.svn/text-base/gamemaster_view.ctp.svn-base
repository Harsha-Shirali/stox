<div class="games view content-with-left-menu">
    <h2><?php echo __('Game'); ?></h2>
    <dl>
<!--        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($game['Game']['id']); ?>
            &nbsp;
        </dd>-->
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($game['Game']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Type'); ?></dt>
        <dd>
            <?php echo h(ucfirst($game['Game']['type'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Status'); ?></dt>
        <dd>
            <?php echo h(ucfirst($game['Game']['status'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Default Trades'); ?></dt>
        <dd>
            <?php echo h($game['Game']['default_trades']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Default Cash'); ?></dt>
        <dd>
            <?php echo h($game['Game']['default_net_value']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($game['Game']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($game['Game']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($game['Game']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($game['Game']['modified']))); ?>
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
        <li><?php echo $this->Html->link(__('Edit Game'), array('action' => 'edit', $game['Game']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Game'), array('action' => 'delete', $game['Game']['id']), null, __('Are you sure you want to delete?', $game['Game']['id'])); ?> </li>
        <!--<li><?php //echo $this->Html->link(__('List Games'), array('action' => 'index')); ?> </li>-->
        <li><?php echo $this->Html->link(__('New Game'), array('action' => 'add')); ?> </li>
    </ul>
</div>
