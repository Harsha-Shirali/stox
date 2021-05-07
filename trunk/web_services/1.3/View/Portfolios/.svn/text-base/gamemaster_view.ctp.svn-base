<div class="portfolios view content-without-left-menu">
    <h2><?php echo __('Portfolio'); ?></h2>
    <dl>
        <dt><?php echo __('User'); ?></dt>
        <dd>
            <?php echo $this->Html->link($portfolio['User']['username'], array('controller' => 'users', 'action' => 'view', $portfolio['User']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Game'); ?></dt>
        <dd>
            <?php echo $this->Html->link($portfolio['Game']['name'], array('controller' => 'games', 'action' => 'view', $portfolio['Game']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Portfolio Name'); ?></dt>
        <dd>
            <?php echo h($portfolio['Portfolio']['portfolio_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Available Cash'); ?></dt>
        <dd>
            <?php echo h($portfolio['Portfolio']['net_value']); ?>
            &nbsp;
        </dd>
        <!-- Here  adding the portfolio net value and the sum of user stock value for current portfoilio : @variable: $net_value-->
        <?php
        $net_value = $portfolio['Portfolio']['net_value'];
        foreach ($portfolio['UserStock'] as $userStock):
            if ($userStock['status'] == 'buy') {
                $net_value+=$userStock['total_amount'];
            }
        endforeach;
        ?>
        <dt><?php echo __('Portfolio worth'); ?></dt>
        <dd>
            <?php echo h($net_value); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Available Trades'); ?></dt>
        <dd>
            <?php echo h($portfolio['Portfolio']['trades']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<?php if (!empty($portfolio['UserStock'])): ?>
    <div class="related">
        <h3><?php echo __('Related User Stocks'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Share'); ?></th>
                <th><?php echo __('Quantity'); ?></th>
                <th><?php echo __('Total Amount'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($portfolio['UserStock'] as $userStock):
                ?>
                <tr>
                    <td><?php echo $userStock['Share']['symbol']; ?></td>
                    <td><?php echo $userStock['quantity']; ?></td>
                    <td><?php echo $userStock['total_amount']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__(''), array('controller' => 'user_stocks', 'action' => 'view', $userStock['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>
<?php if (!empty($portfolio['Watchlist'])): ?>
    <div class="related">
        <h3><?php echo __('Related User Watchlist'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Share'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($portfolio['Watchlist'] as $Watchlist):
                ?>
                <tr>
                    <td><?php echo $Watchlist['Share']['symbol']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__(''), array('controller' => 'watchlists', 'action' => 'view', $Watchlist['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>