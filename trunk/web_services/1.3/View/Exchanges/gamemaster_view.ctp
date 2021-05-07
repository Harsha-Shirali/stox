<div class="exchanges view content-with-left-menu">
    <h2><?php echo __('Exchange'); ?></h2>
    <dl>
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
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Exchange'), array('action' => 'edit', $exchange['Exchange']['id'])); ?> </li>
    </ul>
</div>