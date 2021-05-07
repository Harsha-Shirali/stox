<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('cake_dev', 'TOP STOX');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('style');
        echo $this->Html->script('jquery-1.11.1.min');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        <script type="text/javascript">

            $(function() {
                $('#flashMessage').click(function() {
                    $(this).fadeOut();
                });
                setTimeout(function() {
                    //	document.getElementsByClassName('message').style.display = 'none';
                    $('#flashMessage').fadeOut();

                }, 5000);
            })
        </script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div class="logo">
                    <a href="#"><img src="<?php echo ROOTPATH; ?>img/logo.png"></a>
                </div>
                <div class="logout"><?php echo $this->Html->link('Logout', array('gamemaster' => true, 'controller' => 'users', 'action' => 'logout')); ?></div>
                <?php echo $this->element("menu"); ?>
            </div>
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
<!--                <div class="left">All Rights Reserved. STOX</div>
                <div class="right">Web Master : <a href="http://www.softwaysolutions.com">Softway Solutions</a></div>-->
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
