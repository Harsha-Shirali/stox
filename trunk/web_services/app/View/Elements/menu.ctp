
<ul class="headre_menu">
	<li><?php echo $this->Html->link('Users',array('gamemaster'=>true,'controller'=>'users', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Portfolios',array('gamemaster'=>true,'controller'=>'Portfolios', 'action'=>'index')); ?></li>
	<!--<li><?php echo $this->Html->link('Transactions',array('gamemaster'=>true,'controller'=>'Transactions', 'action'=>'index')); ?></li>-->
	<li><?php echo $this->Html->link('User Stocks',array('gamemaster'=>true,'controller'=>'user_stocks', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Exchanges',array('gamemaster'=>true,'controller'=>'exchanges', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Contact Us',array('gamemaster'=>true,'controller'=>'contacts', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Feedbacks',array('gamemaster'=>true,'controller'=>'feedbacks', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('FAQs',array('gamemaster'=>true,'controller'=>'faqs', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Games',array('gamemaster'=>true,'controller'=>'games', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('Banks',array('gamemaster'=>true,'controller'=>'banks', 'action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('Notifications',array('gamemaster'=>true,'controller'=>'notifications', 'action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('Default Watchlist',array('gamemaster'=>true,'controller'=>'watchlist_preloads', 'action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('Change Password',array('gamemaster'=>true,'controller'=>'users', 'action'=>'changepassword')); ?></li>
</ul>