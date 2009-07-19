<?php 
/* SVN FILE: $Id$ */
/* AccountsController Test cases generated on: 2009-07-18 21:07:58 : 1247921038*/
App::import('Controller', 'Accounts');

class TestAccounts extends AccountsController {
	public $autoRender = false;
}

class AccountsControllerTest extends CakeTestCase {
	public $Accounts = null;

	public function startTest() {
		$this->Accounts = new TestAccounts();
		$this->Accounts->constructClasses();
	}

	public function testAccountsControllerInstance() {
		$this->assertTrue(is_a($this->Accounts, 'AccountsController'));
	}

	public function endTest() {
		unset($this->Accounts);
	}
}
?>