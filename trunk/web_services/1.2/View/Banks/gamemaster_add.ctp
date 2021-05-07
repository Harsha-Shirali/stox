<div class="banks form content-without-left-menu">
    <?php echo $this->Form->create('Bank', array('novalidate' => true)); ?>
    <fieldset>
        <legend><?php echo __('Add Bank'); ?></legend>
        <?php
        echo $this->Form->input('assets');
        echo $this->Form->input('product_name');
        echo $this->Form->input('type', array('options' => array('' => 'Select Type', 'trade' => 'Trade', 'cash' => 'Cash')));
        echo $this->Form->input('price');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
