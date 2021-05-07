<div class="userStocks view content-without-left-menu">
    <h2><?php echo __('User Stock'); ?></h2>
    <dl>
        <dt><?php echo __('User'); ?></dt>
        <dd>
            <?php echo $this->Html->link($userStock['User']['username'], array('controller' => 'users', 'action' => 'view', $userStock['User']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Share'); ?></dt>
        <dd>
            <?php echo $this->Html->link($userStock['Share']['symbol'], array('controller' => 'shares', 'action' => 'view', $userStock['Share']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Portfolio'); ?></dt>
        <dd>
            <?php echo $this->Html->link($userStock['Portfolio']['portfolio_name'], array('controller' => 'portfolios', 'action' => 'view', $userStock['Portfolio']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Quantity'); ?></dt>
        <dd>
            <?php echo h($userStock['UserStock']['quantity']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Total Amount'); ?></dt>
        <dd>
            <?php echo h($userStock['UserStock']['total_amount']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
