<div class="faqs form content-with-left-menu">
    <?php echo $this->Form->create('Faq', array('novalidate' => true)); ?>
    <fieldset>
        <legend><?php echo __('Add Faq'); ?></legend>
        <?php
        echo $this->Form->input('question');
        echo $this->Form->input('answer');
        echo $this->Form->input('status', array('options' => array('active' => 'Active', 'inactive' => 'Inactive')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Faqs'), array('action' => 'index')); ?></li>
    </ul>
</div>
