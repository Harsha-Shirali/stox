<div class="faqs form content-with-left-menu">
    <?php echo $this->Form->create('Faq', array('novalidate' => true)); ?>
    <fieldset>
        <legend><?php echo __('Edit FAQ'); ?></legend>
        <?php
        echo $this->Form->input('id');
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
        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Faq.id')), null, __('Are you sure you want to delete?', $this->Form->value('Faq.id'))); ?></li>
    </ul>
</div>
