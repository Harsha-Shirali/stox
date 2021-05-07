<div class="users form content-without-left-menu">
    <h2><?php echo __('Change Password'); ?></h2>
    <?php echo $this->Form->create('User'); ?>
    <table class="gry_bg">
        <tr>
            <td>
                <?php echo __('Old Password'); ?>
                <span style="color:red">*</span>
            </td>
            <td>
                <?php echo $this->Form->password('old_password'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo __('New Password'); ?>
                <span style="color:red">*</span>
            </td>
            <td>
                <?php echo $this->Form->password('new_password'); ?>                                
            </td>
        </tr>
        <tr>
            <td>
                <?php echo __('Retype Password'); ?>
                <span style="color:red">*</span>
            </td>
            <td>
                <?php echo $this->Form->password('retype_password'); ?>
            </td>
        </tr>					
        <tr>
            <td colspan="2">
                <?php echo $this->Form->submit(); ?>
            </td>
        </tr>
    </table>
    <?php echo $this->Form->end(); ?>
</div>