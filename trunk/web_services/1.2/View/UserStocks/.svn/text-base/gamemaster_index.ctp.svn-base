<div class="userStocks index content-without-left-menu">
    <h2><?php echo __('User Stocks'); ?></h2>
    <div >
        <?php echo $this->Form->create('UserStocks', array('type' => 'get')); ?>
        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->input('username', array('label' => 'User name', 'type' => 'checkbox', 'value' => $username, 'placeholder' => 'User name', 'class' => 'searchbar', 'checked' => $username)); ?>
        <?php echo $this->Form->input('portfolio', array('label' => 'Portfolio', 'type' => 'checkbox', 'value' => $portfolio, 'placeholder' => 'Portfolio name', 'class' => 'searchbar', 'checked' => $portfolio)); ?>
        <?php echo $this->Form->input('share', array('label' => 'Share', 'type' => 'checkbox', 'value' => $share, 'placeholder' => 'Share', 'class' => 'searchbar', 'checked' => $share)); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('share_id'); ?></th>
            <th><?php echo $this->Paginator->sort('portfolio_id'); ?></th>
            <th><?php echo $this->Paginator->sort('quantity'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($userStocks as $userStock): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($userStock['User']['username'], array('controller' => 'users', 'action' => 'view', $userStock['User']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($userStock['Share']['symbol'], array('controller' => 'shares', 'action' => 'view', $userStock['Share']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($userStock['Portfolio']['portfolio_name'], array('controller' => 'portfolios', 'action' => 'view', $userStock['Portfolio']['id'])); ?>
                </td>
                <td><?php echo h($userStock['UserStock']['quantity']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__(''), array('action' => 'view', $userStock['UserStock']['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                </td>
            </tr>
        <?php $i++; endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	
    </p>
    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>
