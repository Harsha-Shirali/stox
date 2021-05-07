<div class="portfolios index content-without-left-menu">
    <h2><?php echo __('Portfolios'); ?></h2>
    <div >
        <?php echo $this->Form->create('Portfolio', array('type' => 'get')); ?>
        <?php echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar')); ?>
        <?php echo $this->Form->submit('search'); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('game_id'); ?></th>
            <th><?php echo $this->Paginator->sort('portfolio_name'); ?></th>
            <th><?php echo $this->Paginator->sort('net_value', 'Portfolio worth'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $i = $this->Paginator->counter('{:start}'); ?>
        <?php foreach ($portfolios as $portfolio): ?>
            <tr>
                <td><?php echo $i; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($portfolio['User']['username'], array('controller' => 'users', 'action' => 'view', $portfolio['User']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($portfolio['Game']['name'], array('controller' => 'games', 'action' => 'view', $portfolio['Game']['id'])); ?>
                </td>
                <td><?php echo h($portfolio['Portfolio']['portfolio_name']); ?>&nbsp;</td>
                <td><?php echo h($portfolio['Portfolio']['net_value']); ?>&nbsp;</td>
                <td>
                    <?php if ($portfolio['Portfolio']['created'] != 0) { ?>
                        <?php echo h(date('M d, Y H:i:s', strtotime($portfolio['Portfolio']['created']))); ?>
                    <?php } else { ?>
                        ---
                    <?php } ?>
                    &nbsp;
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__(''), array('action' => 'view', $portfolio['Portfolio']['id']), array('class' => 'view-icon', 'title' => 'View')); ?>
                </td>
            </tr>
        <?php $i++; endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>
    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>