<div id="main">
	<div class="accounts form">
		<?php
		echo $form->create('Account', array('action' => 'register'));
		echo $form->inputs(array(
			'legend' => __('Add Account', true),
			'name',
			'email',
			'email_confirm',
			'raw_password' => array('type' => 'password', 'label' => __('Password', true)),
			'raw_password_confirm' => array('type' => 'password', 'label' => __('Password Confirm', true)),
		));
		echo $form->end(__('Submit', true));
		?>
	</div>
</div>
<div id="sidebar">
	<div class="block notice">
		<h4>Notice Title</h4>
		<p>Morbi posuere urna vitae nunc. Curabitur ultrices, lorem ac aliquam blandit, lectus eros hendrerit eros, at eleifend libero ipsum hendrerit urna. Suspendisse viverra. Morbi ut magna. Praesent id ipsum. Sed feugiat ipsum ut felis. Fusce vitae nibh sed risus commodo pulvinar. Duis ut dolor. Cras ac erat pulvinar tortor porta sodales. Aenean tempor venenatis dolor.</p>
	</div>
</div>