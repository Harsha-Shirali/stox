<div class="games form content-without-left-menu">
    <?php echo $this->Form->create('Game', array('novalidate' => true)); ?>
    <fieldset>
        <legend><?php echo __('Add Game'); ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('type', array('options' => array('free' => 'Free', 'paid' => 'Paid')));
        echo $this->Form->input('status', array('options' => array('active' => 'Active', 'inactive' => 'Inactive')));
        echo $this->Form->input('default_trades');
        echo $this->Form->input('default_net_value', array('label' => 'Default Cash'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
