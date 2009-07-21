<?php
class AppController extends Controller {
	public $components = array(
		'Auth',
		'DebugKit.Toolbar',
	);
	public $helpers = array('AppPaginator');
	
	public function beforeFilter() {
		if (isset($this->Auth)) {
			$this->_authSettings();
		}
	}

	private function _authSettings() {
		if (isset($this->data['Account']['password'])) {
			$this->data['Account']['hash_password'] = $this->data['Account']['password'];
		}
		$this->Auth->userModel = 'Account';
		$this->Auth->fields = array('username' => 'email', 'password' => 'hash_password');
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home');
		$this->Auth->userScope = array('Account.disabled' => 0);
	}
}
?>