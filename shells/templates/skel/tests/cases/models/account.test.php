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
			'name'  => 'Lorem ipsum dolor sit amet',
			'email'  => 'foo@hoge.hage',
			'password'  => 'Lorem ipsum dolor sit amet',
			'expires'  => '2009-07-18 21:40:02',
			'email_checkcode'  => 'Lorem ipsum dolor sit amet',
			'password_checkcode'  => 'Lorem ipsum dolor sit amet',
			'disabled'  => 1,
			'email_tmp'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}

	function testAccountChangeEmailAndConfirmEmail() {
		// メールアドレスバリデーションで失敗
		$data = array('Account' => array(
			'id' => 1,
			'email' => 'foo',
		));
		$results = $this->Account->changeEmail($data);
		$this->assertIdentical($results, false);
		// 同一メールアドレスで失敗
		$this->Account->create();
		$this->Account->saveField('email', 'bar@hoge.hage');
		$data = array('Account' => array(
			'id' => 1,
			'email' => 'bar@hoge.hage',
		));
		$results = $this->Account->changeEmail($data);
		$this->assertIdentical($results, false);
		// 成功
		$data = array('Account' => array(
			'id' => 1,
			'email' => 'slywalker.net@gmail.com',
		));
		$results = $this->Account->changeEmail($data);
		$this->assertTrue(!empty($results));
		$this->assertIdentical($results['Account']['email_tmp'], $data['Account']['email']);
		$emailCheckcode = $results['Account']['email_checkcode'];
		// データが置き換わっているか確認
		$this->Account->recursive = -1;
		$results = $this->Account->find('first', array('Account.id' => 1));
		$this->assertTrue(!empty($results));
		$this->assertIdentical($results['Account']['email'], 'foo@hoge.hage');
		$this->assertIdentical($results['Account']['email_tmp'], $data['Account']['email']);
		// 確認テスト
		$results = $this->Account->confirmEmail('Lorem ipsum dolor sit amet');
		$this->assertIdentical($results, false);
		$results = $this->Account->confirmEmail($emailCheckcode);
		$this->assertTrue(!empty($results));
		$this->assertIdentical($results['Account']['email'], $data['Account']['email']);
		$this->assertIdentical($results['Account']['email_tmp'], '');
		$this->assertIdentical($results['Account']['email_checkcode'], '');
		$this->assertIdentical($results['Account']['expires'], null);
	}

	function testAccountForgotPassword() {
		$results = $this->Account->forgotPassword('not_exist_email');
		$this->assertIdentical($results, false);

		$results = $this->Account->forgotPassword('foo@hoge.hage');
		$this->assertTrue(!empty($results));
	}

	function testAccountRegisterAndConfirmRegister() {
		// メールアドレスバリデーションで失敗
		$data = array('Account' => array(
			'name' => 'Lorem ipsum dolor sit amet',
			'email' => 'foo',
			'password' => 'Lorem ipsum dolor sit amet',
		));
		$results = $this->Account->register($data);
		$this->assertIdentical($results, false);
		// 成功
		$data = array('Account' => array(
			'name' => 'test',
			'email'  => 'slywalker.net@gmail.com',
			'password' => 'pass',
		));
		$results = $this->Account->register($data);
		$this->assertTrue(!empty($results));
		$this->assertIdentical($results['Account']['disabled'], 1);
		$emailCheckcode = $results['Account']['email_checkcode'];
		// 確認テスト
		$results = $this->Account->confirmRegister('Lorem ipsum dolor sit amet');
		$this->assertIdentical($results, false);
		$results = $this->Account->confirmRegister($emailCheckcode);
		$this->assertTrue(!empty($results));
		$this->assertIdentical($results['Account']['disabled'], 0);
		$this->assertIdentical($results['Account']['email_checkcode'], '');
		$this->assertIdentical($results['Account']['expires'], null);		
	}
}
?>