<div class="users">
    <?php echo $this->Form->create('User', array('novalidate' => true)); ?>
    <fieldset>
        <legend><?php echo __('login'); ?></legend>
        <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
