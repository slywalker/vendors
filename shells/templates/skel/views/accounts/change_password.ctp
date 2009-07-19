<div id="main">
	<div class="accounts form">
		<?php
		echo $form->create('Account', array('action' => 'change_password'));
		echo $form->inputs(array(
			'legend' => __('Change Password', true),
			'id',
			'raw_password' => array('type' => 'password', 'label' => __('Password', true)),
			'raw_password_confirm' => array('type' => 'password', 'label' => __('Password Confirm', true)),
		));
		echo $form->end(__('Submit', true));
		?>
	</div>
</div>
<div id="sidebar">
	<div class="block">
		<h3><?php __('Actions');?></h3>
		<?php
		$li = array();
		$li[] =$html->link(__('View Account', true), array('action' => 'view', $form->value('Account.id')));
		echo $html->nestedList($li, array('class'=>'navigation'));
		?>
	</div>
	<div class="block notice">
		<h4>Notice Title</h4>
		<p>Morbi posuere urna vitae nunc. Curabitur ultrices, lorem ac aliquam blandit, lectus eros hendrerit eros, at eleifend libero ipsum hendrerit urna. Suspendisse viverra. Morbi ut magna. Praesent id ipsum. Sed feugiat ipsum ut felis. Fusce vitae nibh sed risus commodo pulvinar. Duis ut dolor. Cras ac erat pulvinar tortor porta sodales. Aenean tempor venenatis dolor.</p>
	</div>
</div>
