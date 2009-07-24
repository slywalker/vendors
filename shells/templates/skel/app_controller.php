<?php
class AppController extends Controller {
	public $components = array(
		'Security', 'Auth',
		'ToolKit.Qdmail', 'ToolKit.Qdsmtp',
		'DebugKit.Toolbar',
	);
	public $helpers = array('AppPaginator');
	
	public function beforeFilter() {
		$this->Security->disabledFields = array('hash_password');
		if (isset($this->data['Account']['password'])) {
			$this->data['Account']['hash_password'] = $this->data['Account']['password'];
		}
		if (!empty($this->params[Configure::read('Routing.admin')])) {
			$this->__adminSettings();
		} else {
			$this->__authSettings();
		}
	}

	private function __authSettings() {
		$this->Auth->userModel = 'Account';
		$this->Auth->fields = array('username' => 'email', 'password' => 'hash_password');
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home');
		$this->Auth->userScope = array('Account.disabled' => 0);
		$this->Auth->allow('*');
		$this->Auth->deny('add', 'edit', 'delete');
		$account = $this->Auth->user();
		Configure::write('Auth', $account['Account']);
	}

	private function __adminSettings() {
		if (config('basic')) {
			$Basic = new BASIC_CONFIG;
			$users = $Basic->default;
			$this->Security->loginOptions = array('type'=>'basic');
			$this->Security->loginUsers = $users;
			$this->Security->requireLogin('*');
			$this->Auth->allow('*');
		}
	}

	protected function _send($to, $subject, $template = 'default') {
		if (config('smtp')) {
			$Smtp = new SMTP_CONFIG;
			$params = $Smtp->default;
			$this->Qdmail->smtp(true);
			$this->Qdmail->smtpServer($params);
		}
		//$this->Qdmail->debug(2);
		$this->Qdmail->to($to);
		$this->Qdmail->from('noreplay@'.env('HTTP_HOST'));
		$this->Qdmail->subject($subject);
		
		$view = $this->view;
		$this->view = 'View';
		$this->Qdmail->cakeText(null, $template, null, null, 'iso-2022-jp');
		$this->view = $view;
		
		return $this->Qdmail->send();
	}
}
?>