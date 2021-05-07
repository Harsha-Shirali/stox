<div class="index content-with-left-menu">
    <h2><?php echo __('Search Stocks'); ?></h2>
    <div>
        <?php echo $this->Form->create('Share', array('type' => 'get')); ?>
        <?php
        if (!isset($search)) {
            $search = "";
        }
        echo $this->Form->input('search', array('label' => false, 'type' => 'text', 'value' => $search, 'placeholder' => 'Search', 'class' => 'searchbar'));
        ?>
        <?php echo $this->Form->end(__('Search')); ?>
    </div>
    <?php if (isset($shares)) { ?>   
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id', 'S.No.'); ?></th>
                <th><?php echo $this->Paginator->sort('share'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php $i = $this->Paginator->counter('{:start}'); ?>
            <?php foreach ($shares as $share): ?>
                <tr>
                    <td><?php echo $i; ?>&nbsp;</td>
                    <td><?php echo h($share['Share']['symbol']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Form->postLink(__('Add'), array('controller' => 'watchlist_preloads', 'action' => 'add', $share['Share']['id']), array('title' => 'Delete'), __('Are you sure you want to add?', $share['Share']['id'])); ?>
                    </td>
                </tr>
                <?php $i++;
            endforeach; ?>
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
<?php } ?>   
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Default Watchlist'), array('controller' => 'watchlist_preloads', 'action' => 'index')); ?></li>
    </ul>
</div>
