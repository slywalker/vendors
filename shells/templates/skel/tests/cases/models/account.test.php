<?php 
/* SVN FILE: $Id$ */
/* Account Test cases generated on: 2009-07-18 21:07:02 : 1247920802*/
App::import('Model', 'Account');

class AccountTestCase extends CakeTestCase {
	public $Account = null;
	public $fixtures = array('app.account');

	function startTest() {
		$this->Account =& ClassRegistry::init('Account');
	}

	function testAccountInstance() {
		$this->assertTrue(is_a($this->Account, 'Account'));
	}

	function testAccountFind() {
		$this->Account->recursive = -1;
		$results = $this->Account->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Account' => array(
			'id'  => 1,
			'name'  => 1,
			'email'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'expires'  => '2009-07-18 21:40:02',
			'email_checkcode'  => 'Lorem ipsum dolor sit amet',
			'password_checkcode'  => 'Lorem ipsum dolor sit amet',
			'disabled'  => 1,
			'email_tmp'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>