<?php 
class AccountsSchema extends CakeSchema {
	var $name = 'Accounts';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'hash_password' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'expires' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'email_checkcode' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'password_checkcode' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'disabled' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'email_tmp' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>