<?php
    echo $this->layout = "";
    $cakeDescription = __d('cake_dev', 'TOP STOX: admin');
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
        <style>
            p {
                font-size: 14px;
                line-height: 1.50em;
                margin: 1.25em 0;
                text-align: justify;
                margin-bottom:20px;
                
            }
        </style>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div class="logo">
                    <a href="#"><img src="<?php echo ROOTPATH; ?>img/logo.png"></a>
                </div>                
            </div>
            <div id="content">
                <h3>Top Stox</h3>
                <p style="height:auto;">Top Stox is a stock market trading simulation game. This app is free to download!<br><br>For the novice, Top Stox is a great, free way to learn about the stock market and general business world. For the pro, Top Stox is the ideal testing ground to try out new trading strategies and techniques.<br><br>Using real data reflecting the stock market’s activity, you can buy, sell, and trade stocks accordingly. (Using fake money, of course.)<br><br>There are two game modes: <br><br>1.) Portfolio Game<br><br>The Portfolio Game is an ongoing game format, with the option to reset a portfolio via an in-app purchase. At the onset, you will have the option to create a portfolio with up to $10,000.00 for purchasing stocks. You will also have the ability to acquire multiple portfolios and additional funds through in-app purchases as well.<br><br>2.) DayTradeGame<br><br>Similar to the Portfolio Game, the DayTrade game gives the user $10,000.00 to start, with the ability to add funds if necessary. This game tracks your daily gains and then resets to its original $10,000 starting value each morning.<br>Challenge your friends, family, and colleagues to find out who can make the most money and see who has the best strategies.</p>
                <a href="https://itunes.apple.com/us/app/top-stox/id921444718?mt=8" target="_blank"><img src="<?php echo ROOTPATH; ?>img/itunes_img.png"></a>
            </div>
            <div id="footer">
                <div class="left">All Rights Reserved. TOP STOX</div>
                <div class="right">Web Master : <a href="http://www.softwaysolutions.com">Softway Solutions</a></div>
            </div>
        </div>        
    </body>
</html>