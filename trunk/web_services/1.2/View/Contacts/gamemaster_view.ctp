<div class="contacts view content-with-left-menu">
    <h2><?php echo __('Contact'); ?></h2>
    <dl>
        <dt><?php echo __('Subject'); ?></dt>
        <dd>
            <?php echo h($contact['Contact']['subject']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Queries'); ?></dt>
        <dd>
            <?php echo h($contact['Contact']['queries']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete Contact'), array('action' => 'delete', $contact['Contact']['id']), null, __('Are you sure you want to delete?', $contact['Contact']['id'])); ?> </li>
    </ul>
</div>