<?php 
/* SVN FILE: $Id$ */
/* Account Fixture generated on: 2009-07-18 21:07:02 : 1247920802*/

class AccountFixture extends CakeTestFixture {
	public $name = 'Account';
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'email' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'expires' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'email_checkcode' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'password_checkcode' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'disabled' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'email_tmp' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	public $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'email'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'expires'  => '2009-07-18 21:40:02',
		'email_checkcode'  => 'Lorem ipsum dolor sit amet',
		'password_checkcode'  => 'Lorem ipsum dolor sit amet',
		'disabled'  => 1,
		'email_tmp'  => 'Lorem ipsum dolor sit amet'
	));
}
?>