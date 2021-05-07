<div class="users view content-with-left-menu">
    <h2><?php echo __('User'); ?></h2>
    <div class="profile_page_elements">
        <dl>
            <dt><?php echo __('Username'); ?></dt>
            <dd>
                <?php echo h($user['User']['username']); ?>
                &nbsp;
            </dd>
            <?php if ($user['User']['facebook_id'] != '') { ?>	
                <dt><?php echo __('Facebook Id'); ?></dt>
                <dd>
                    <?php echo h($user['User']['facebook_id']); ?>
                    &nbsp;
                </dd>
            <?php } if ($user['User']['device_id'] != '') { ?>
                <dt><?php echo __('Device Id'); ?></dt>
                <dd>
                    <?php echo h($user['User']['device_id']); ?>
                    &nbsp;
                </dd>
            <?php } ?>
            <dt><?php echo __('Job Title'); ?></dt>
            <dd>
                <?php echo h($user['User']['job_title']); ?>
                &nbsp;
            </dd>
            <?php if ($user['User']['biodata'] != '') { ?>	
                <dt><?php echo __('Biodata'); ?></dt>
                <dd>
                    <?php echo h($user['User']['biodata']); ?>
                    &nbsp;
                </dd>
            <?php } ?>
            <dt><?php echo __('Email'); ?></dt>
            <dd>
                <?php echo h($user['User']['email']); ?>
                &nbsp;
            </dd>
        </dl>
    </div>
    <div class="profile_pic">        
        <?php if ($user['User']['image'] != '') { ?>	
            <p><b><?php echo __('Profile Pic'); ?></b></p>      
            <img src="<?php echo ROOTPATH; ?>/files/uploads/profile_default.jpg">
        <?php } ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete this user?', $user['User']['id'])); ?> </li>
    </ul>
</div>
<div class="related">
    <?php if (!empty($user['Portfolio'])): ?>
        <h3><?php echo __('Related Portfolios'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Game'); ?></th>
                <th><?php echo __('Trades'); ?></th>
                <th><?php echo __('Portfolio Name'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($user['Portfolio'] as $portfolio):
                ?>
                <tr>
                    <td><?php echo $portfolio['Game']['name']; ?></td>
                    <td><?php echo $portfolio['trades']; ?></td>
                    <td><?php echo $portfolio['portfolio_name']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__(''), array('controller' => 'portfolios', 'action' => 'view', $portfolio['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<div class="related">
    <?php if (!empty($user['UserStock'])): ?>
        <h3><?php echo __('Related User Stocks'); ?></h3>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Share'); ?></th> 
                <th><?php echo __('Quantity'); ?></th>
                <th><?php echo __('Amount'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($user['UserStock'] as $userStock): //pr($userStock); 
                ?>
                <tr>
                    <td><?php echo $userStock['Share']['symbol']; ?></td> 
                    <td><?php echo $userStock['quantity']; ?></td>
                    <td><?php echo isset($userStock['amount']) ? $userStock['amount'] : '0.00'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>  
</div>