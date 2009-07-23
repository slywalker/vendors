<?php
$li = array();
if ($session->check('Auth.Account')) {
	$li[] = $html->link(__('Account', true), array('controller' => 'accounts', 'action' => 'view', 'admin' => false, 'plugin' => false));
	$li[] = $html->link(__('Sign Out', true), array('controller' => 'accounts', 'action' => 'logout', 'admin' => false));
} else {
	$li[] = $html->link(__('Sign In', true), array('controller' => 'accounts', 'action' => 'login', 'admin' => false, 'plugin' => false));
}
echo $html->nestedList($li);
?>