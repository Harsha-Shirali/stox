<div class="portfolios view content-without-left-menu">
    <h2><?php echo __('Portfolio'); ?></h2>
    <dl>
<!--        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($portfolio['Portfolio']['id']); ?>
            &nbsp;
        </dd>-->
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
<!--        <dt><?php echo __('Previous Net Value'); ?></dt>
        <dd>
            <?php echo h($portfolio['Portfolio']['previous_net_value']); ?>
            &nbsp;
        </dd>-->
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
<!--        <dt><?php echo __('Is Public'); ?></dt>
        <dd>
            <?php echo h(ucfirst($portfolio['Portfolio']['is_public'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Is Paid'); ?></dt>
        <dd>
            <?php echo h(ucfirst($portfolio['Portfolio']['is_paid'])); ?>
            &nbsp;
        </dd>-->
<!--        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php if ($portfolio['Portfolio']['created'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($portfolio['Portfolio']['created']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php if ($portfolio['Portfolio']['modified'] != 0) { ?>
                <?php echo h(date('M d, Y H:i:s', strtotime($portfolio['Portfolio']['modified']))); ?>
            <?php } else { ?>
                ---
            <?php } ?>
            &nbsp;
        </dd>-->
    </dl>
</div>
<!--<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Portfolio'), array('action' => 'edit', $portfolio['Portfolio']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Portfolio'), array('action' => 'delete', $portfolio['Portfolio']['id']), null, __('Are you sure you want to delete # %s?', $portfolio['Portfolio']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Portfolios'), array('action' => 'index')); ?> </li>
         <li><?php //echo $this->Html->link(__('New Portfolio'), array('action' => 'add'));  ?> </li> 
        <li><?php //echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index'));  ?> </li>
         <li><?php //echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'));  ?> </li> 
        <li><?php //echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index'));  ?> </li>
        <li><?php //echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add'));  ?> </li>
        <li><?php echo $this->Html->link(__('List Transactions'), array('controller' => 'transactions', 'action' => 'index', 'portfolio_id' => $portfolio['Portfolio']['id'])); ?> </li>
         <li><?php //echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add'));  ?> </li> 
        <li><?php echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index', 'portfolio_id' => $portfolio['Portfolio']['id'])); ?> </li>
         <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add'));  ?> </li> 
    </ul>
</div>-->
<?php //if (!empty($portfolio['Transaction'])): ?>
<!--    <div class="related">
        <h3><?php echo __('Related Transactions'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Status'); ?></th>
                <th><?php echo __('Assets'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th><?php echo __('Price'); ?></th>
                <th><?php echo __('Comments'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($portfolio['Transaction'] as $transaction):
                ?>
                <tr>
                    <td><?php echo $transaction['id']; ?></td>
                    <td><?php echo ucfirst($transaction['status']); ?></td>
                    <td><?php echo $transaction['assets']; ?></td>
                    <td><?php echo ucfirst($transaction['type']); ?></td>
                    <td><?php echo $transaction['price']; ?></td>
                    <td><?php echo $transaction['comments']; ?></td>
                    <td>
                        <?php if ($transaction['created'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($transaction['created']))); ?>
                        <?php } else { ?>
                            ---
        <?php } ?>
                    </td>
                    <td>
                        <?php if ($transaction['modified'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($transaction['modified']))); ?>
                        <?php } else { ?>
                            ---
        <?php } ?>
                    </td>
                    <td class="actions">
                        <?php echo $this->Html->link(__(''), array('controller' => 'transactions', 'action' => 'view', $transaction['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                        <?php //echo $this->Html->link(__('Edit'), array('controller' => 'transactions', 'action' => 'edit', $transaction['id'])); ?>
        <?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'transactions', 'action' => 'delete', $transaction['id']), null, __('Are you sure you want to delete # %s?', $transaction['id']));  ?>
                    </td>
                </tr>
    <?php endforeach; ?>
        </table>

         <div class="actions">
                <ul>
                        <li><?php //echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add'));  ?> </li>
                </ul>
        </div> 
    </div>-->
<?php //endif; ?>
<?php if (!empty($portfolio['UserStock'])): ?>
    <div class="related">
        <h3><?php echo __('Related User Stocks'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <!--<th><?php echo __('Id'); ?></th>-->
                <th><?php echo __('Share'); ?></th>
                <!--<th><?php echo __('Status'); ?></th>-->
                <!--<th><?php echo __('Is Pending'); ?></th>-->
                <th><?php echo __('Quantity'); ?></th>
                <th><?php echo __('Total Amount'); ?></th>
                <!--<th><?php echo __('Created'); ?></th>-->
                <!--<th><?php echo __('Modified'); ?></th>-->
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($portfolio['UserStock'] as $userStock):
                ?>
                <tr>
                    <!--<td><?php echo $userStock['id']; ?></td>-->
                    <td><?php echo $userStock['Share']['symbol']; ?></td>
                    <!--<td><?php echo ucfirst($userStock['status']); ?></td>-->
                    <!--<td><?php echo ucfirst($userStock['is_pending']); ?></td>-->
                    <td><?php echo $userStock['quantity']; ?></td>
                    <td><?php echo $userStock['total_amount']; ?></td>
<!--                    <td>
                        <?php if ($userStock['created'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($userStock['created']))); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($userStock['modified'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($userStock['modified']))); ?>
                        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>-->
                    <td class="actions">
                        <?php echo $this->Html->link(__(''), array('controller' => 'user_stocks', 'action' => 'view', $userStock['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
        <?php //echo $this->Html->link(__('Edit'), array('controller' => 'user_stocks', 'action' => 'edit', $userStock['id']));  ?>
                <?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'user_stocks', 'action' => 'delete', $userStock['id']), null, __('Are you sure you want to delete # %s?', $userStock['id']));  ?>
                    </td>
                </tr>
    <?php endforeach; ?>
        </table>

        <!-- <div class="actions">
                <ul>
                        <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add'));  ?> </li>
                </ul>
        </div> -->
    </div>
<?php endif; ?>

<?php if (!empty($portfolio['Watchlist'])): ?>
    <div class="related">
        <h3><?php echo __('Related User Watchlist'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <!--<th><?php echo __('Id'); ?></th>-->
                <!-- <th><?php //echo __('Portfolio Id');  ?></th> -->
                <th><?php echo __('Share'); ?></th>
                <!--<th><?php echo __('Created'); ?></th>-->
                <!--<th><?php echo __('Modified'); ?></th>-->
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($portfolio['Watchlist'] as $Watchlist):
                ?>
                <tr>
                    <!--<td><?php echo $Watchlist['id']; ?></td>-->
                    <!-- <td><?php //echo $Watchlist['portfolio_id']; ?></td> -->
                    <td><?php echo $Watchlist['Share']['symbol']; ?></td>
<!--                    <td>
                        <?php if ($Watchlist['created'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($Watchlist['created']))); ?>
        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($Watchlist['modified'] != 0) { ?>
                            <?php echo h(date('M d, Y H:i:s', strtotime($Watchlist['modified']))); ?>
        <?php } else { ?>
                            ---
                        <?php } ?>
                    </td>-->
                    <td class="actions">
        <?php echo $this->Html->link(__(''), array('controller' => 'watchlists', 'action' => 'view', $Watchlist['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                <?php //echo $this->Html->link(__('Edit'), array('controller' => 'user_stocks', 'action' => 'edit', $Watchlist['id']));  ?>
                <?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'user_stocks', 'action' => 'delete', $Watchlist['id']), null, __('Are you sure you want to delete # %s?', $Watchlist['id'])); ?>
                    </td>
                </tr>
    <?php endforeach; ?>
        </table>

        <!-- <div class="actions">
                <ul>
                        <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add'));  ?> </li>
                </ul>
        </div> -->
    </div>

<?php endif; ?>