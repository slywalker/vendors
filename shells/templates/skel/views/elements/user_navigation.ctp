<?php
$li = array();
$li[] = $html->link('Sign In', array('controller' => 'accounts', 'action' => 'login'));
$li[] = $html->link('Sign Out', array('controller' => 'accounts', 'action' => 'logout'));
echo $html->nestedList($li);
?>