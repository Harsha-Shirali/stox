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
            <?php echo $cakeDescription ?> :
            <?php //echo $title_for_layout; ?>
            Admin
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('style');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1 class="login_header" style="text-align:center;">TOP STOX</h1>
            </div>
            <div id="content">
                <div class="loginbox">
                    <div class="login_logo_box">
                        <img src="<?php echo ROOTPATH; ?>img/logo.png">
                    </div>
                    <?php echo $this->Session->flash(); ?>

                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>
            <div id="footer">
<!--                <div class="left">All Rights Reserved. STOX</div>
                <div class="right">Web Master : <a href="http://www.softwaysolutions.com">Softway Solutions</a></div>-->
            </div>
        </div>
        <?php // echo $this->element('sql_dump');  ?>
    </body>
</html>
