<div class="users view content-with-left-menu">
<h2><?php  echo __('User'); ?></h2>
<div class="profile_page_elements">
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<?php if($user['User']['facebook_id']!=''){?>	
			<dt><?php echo __('Facebook Id'); ?></dt>
			<dd>
				<?php echo h($user['User']['facebook_id']); ?>
				&nbsp;
			</dd>
		<?php }
 			 if($user['User']['device_id']!=''){?>
		<dt><?php echo __('Device Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['device_id']); ?>
			&nbsp;
		</dd>
		<?php }?>
		<dt><?php echo __('Job Title'); ?></dt>
		<dd>
			<?php echo h($user['User']['job_title']); ?>
			&nbsp;
		</dd>
		<?php if($user['User']['biodata']!=''){?>	
		<dt><?php echo __('Biodata'); ?></dt>
		<dd>
			<?php echo h($user['User']['biodata']); ?>
			&nbsp;
		</dd>
		<?php }?>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>

	</dl>
    </div>
    <div class="profile_pic">
    
    		<?php if($user['User']['image']!=''){?>	
		<p><b><?php echo __('Profile Pic'); ?></b></p>
		

				<img src="<?php echo ROOTPATH;?>/files/uploads/profile_default.jpg">
			</div>
		</dd>	
		<?php }?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Portfolios'), array('controller' => 'portfolios', 'action' => 'index')); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('List User Logs'), array('controller' => 'user_logs', 'action' => 'index')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('New User Log'), array('controller' => 'user_logs', 'action' => 'add')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('List User Stocks'), array('controller' => 'user_stocks', 'action' => 'index')); ?> </li> -->
		<!-- <li><?php //echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li> -->
	</ul>
</div>
<div class="related">
	
	<?php if (!empty($user['Portfolio'])): ?>
	<h3><?php echo __('Related Portfolios'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<!-- <th><?php //echo __('User Id'); ?></th> -->
		<th><?php echo __('Game'); ?></th>
		<!-- <th><?php //echo __('Net Value'); ?></th> -->
		<th><?php echo __('Trades'); ?></th>
		<th><?php echo __('Portfolio Name'); ?></th>
		<th><?php echo __('Is Public'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th> 
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Portfolio'] as $portfolio):  ?>
		<tr>
			<td><?php echo $portfolio['id']; ?></td>
			<!-- <td><?php //echo $portfolio['user_id']; ?></td> -->
			<td><?php echo $portfolio['Game']['name']; ?></td>
			<!-- <td><?php //echo $portfolio['net_value']; ?></td> -->
			<td><?php echo $portfolio['trades']; ?></td>
			<td><?php echo $portfolio['portfolio_name']; ?></td>
			<td><?php echo ucfirst($portfolio['is_public']); ?></td>
			<td><?php echo $portfolio['created']; ?></td>
			<td><?php echo $portfolio['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__(''), array('controller' => 'portfolios', 'action' => 'view', $portfolio['id']),array('class'=>'view-icon','title'=>'View')); ?>
				<?php echo $this->Html->link(__(''), array('controller' => 'portfolios', 'action' => 'edit', $portfolio['id']),array('class'=>'edit-icon','title'=>'Edit')); ?>
				<?php echo $this->Form->postLink(__(''), array('controller' => 'portfolios', 'action' => 'delete', $portfolio['id']),array('class'=>'delete-icon','title'=>'Delete'), null, __('Are you sure you want to delete # %s?', $portfolio['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<!-- <div class="actions">
		<ul>
			<li><?php //echo $this->Html->link(__('New Portfolio'), array('controller' => 'portfolios', 'action' => 'add')); ?> </li>
		</ul>
	</div> -->
</div>

<div class="related">
	
	<?php if (!empty($user['UserStock'])): ?>
	<h3><?php echo __('Related User Stocks'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<!-- <th><?php //echo __('User Id'); ?></th>-->
		<th><?php echo __('Share'); ?></th> 
		<!-- <th><?php //echo __('Portfolio Id'); ?></th> -->
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Amount'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th> 
		<!--<th class="actions"><?php //echo __('Actions'); ?></th>-->
	</tr>
	<?php
		$i = 0;
		foreach ($user['UserStock'] as $userStock): //pr($userStock); ?>
		<tr>
			<td><?php echo $userStock['id']; ?></td>
			<!-- <td><?php //echo $userStock['user_id']; ?></td>-->
			<td><?php echo $userStock['Share']['symbol']; ?></td> 
			<!-- <td><?php //echo $userStock['portfolio_id']; ?></td> -->
			<td><?php echo $userStock['status']; ?></td>
			<td><?php echo $userStock['quantity']; ?></td>
			<td><?php echo isset($userStock['amount'])?$userStock['amount']:'0.00'; ?></td>
			<td><?php echo $userStock['created']; ?></td>
			<td><?php echo $userStock['modified']; ?></td>
			<!-- <td class="actions">
				<?php //echo $this->Html->link(__(''), array('controller' => 'user_stocks', 'action' => 'view', $userStock['id']),array('class'=>'view-icon','title'=>'View')); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'user_stocks', 'action' => 'edit', $userStock['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'user_stocks', 'action' => 'delete', $userStock['id']), null, __('Are you sure you want to delete # %s?', $userStock['id'])); ?>
			</td>  -->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<!-- <div class="actions">
		<ul>
			<li><?php// echo $this->Html->link(__('New User Stock'), array('controller' => 'user_stocks', 'action' => 'add')); ?> </li>
		</ul>
	</div> -->
</div>

<div class="related">
	<?php if (!empty($user['UserLog'])): ?>
	<h3><?php echo __('Related User Logs'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<!-- <th><?php //echo __('User Id'); ?></th> -->
		<th><?php echo __('Device Id'); ?></th>
		<th><?php echo __('Action'); ?></th>
		<th><?php echo __('Comments'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th> 
		<!-- <th class="actions"><?php //echo __('Actions'); ?></th>-->
	</tr>
	<?php
		$i = 0;
		foreach ($user['UserLog'] as $userLog): ?>
		<tr>
			<td><?php echo $userLog['id']; ?></td>
			<!-- <td><?php //echo $userLog['user_id']; ?></td> -->
			<td><?php echo $userLog['device_id']; ?></td>
			<td><?php echo $userLog['action']; ?></td>
			<td><?php echo $userLog['comments']; ?></td>
			<td><?php echo $userLog['created']; ?></td>
			<td><?php echo $userLog['modified']; ?></td>
			 <!--<td class="actions">
				<?php echo $this->Html->link(__(''), array('controller' => 'user_logs', 'action' => 'view', $userLog['id']),array('class'=>'view-icon','title'=>'View')); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'user_logs', 'action' => 'edit', $userLog['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'user_logs', 'action' => 'delete', $userLog['id']), null, __('Are you sure you want to delete # %s?', $userLog['id'])); ?>
			</td> -->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<!-- <div class="actions">
		<ul>
			<li><?php //echo $this->Html->link(__('New User Log'), array('controller' => 'user_logs', 'action' => 'add')); ?> </li>
		</ul>
	</div> -->
</div>
