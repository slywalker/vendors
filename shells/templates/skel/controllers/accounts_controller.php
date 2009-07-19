<?php
class AccountsController extends AppController {
	public $name = 'Accounts';
	public $components = array('ToolKit.Qdmail', 'ToolKit.Qdsmtp');
	private $_id = null;

	public function beforeFilter() {
		parent::beforeFilter();
		if (isset($this->Auth)) {
			$this->Auth->allow('register', 'forgot_password', 'confirm_register', 'confirm_email', 'change_password');
			$this->_id = $this->Auth->user('id');
		}
	}

	public function index() {
		$this->Account->recursive = 0;
		$this->set('accounts', $this->paginate());
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('account', $this->Account->read(null, $id));
	}

	public function add() {
		if ($this->data) {
			$this->Account->create();
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The Account has been saved', true), 'default', array('class' => 'message success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Account could not be saved. Please, try again.', true));
			}
		}
	}

	public function edit($id = null) {
		if (!$id && !$this->data) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->data) {
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The Account has been saved', true), 'default', array('class' => 'message success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Account could not be saved. Please, try again.', true));
			}
		} else {
			$this->data = $this->Account->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			if (isset($this->data['delete'])) {
				if ($this->Account->deleteAll(array('Account.id' => $this->data['delete']))) {
					$this->Session->setFlash(__('Account deleted', true), 'default', array('class' => 'message success'));
				}
			}
		} else {
			if ($this->Account->delete($id)) {
				$this->Session->setFlash(__('Account deleted', true), 'default', array('class' => 'message success'));
			}
		}
		$this->redirect(array('action'=>'index'));
	}

	public function login() {
		
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function register() {
		if ($this->data) {
			$this->Account->begin();
			if ($account = $this->Account->register($this->data)) {
				// sendmail
				$this->set(compact('account'));
				if ($this->_sendMail($account['Account']['email'], 'Confirm Register', 'confirm_register')) {
					$this->Account->commit();
					$this->Session->setFlash(__('A confirm mail has been sent', true), 'default', array('class' => 'message success'));
					$this->redirect(array('action'=>'login'));
				}
			}
			$this->Account->rollback();
			$this->Session->setFlash(__('The Account could not be saved. Please, try again.', true));
		}
	}

	public function forgot_password() {
		if (isset($this->data['Account']['email'])) {
			$this->Account->begin();
			if ($account = $this->Account->forgotPassword($this->data['Account']['email'])) {
				// sendmail
				$this->set(compact('account'));
				if ($this->_sendMail($account['Account']['email'], 'Change Password', 'forgot_password')) {
					$this->Account->commit();
					$this->Session->setFlash(__('A confirm mail has been sent', true), 'default', array('class' => 'message success'));
					$this->redirect(array('action'=>'login'));
				}
			}
			$this->Account->rollback();
			$this->Session->setFlash(__('A confirm mail has been sent', true), 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'login'));
		}
	}

	public function confirm_register($emailCheckcode = null) {
		if ($this->Account->confirmRegister($emailCheckcode)) {
			$this->Session->setFlash(__('Confirm has been success', true), 'default', array('class' => 'message success'));
		} else {
			$this->Session->setFlash(__('Confirm could not be success. Please, try again.', true));
		}
		$this->redirect(array('action'=>'login'));
	}

	public function confirm_email($emailCheckcode = null) {
		if ($this->Account->confirmEmail($emailCheckcode)) {
			$this->Session->setFlash(__('Confirm has been success', true), 'default', array('class' => 'message success'));
		} else {
			$this->Session->setFlash(__('Confirm could not be success. Please, try again.', true));
		}
		$this->redirect(array('action'=>'login'));
	}


	public function change_email() {
		$id = $this->_id;
		if (!$id && !$this->data) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'login'));
		}
		if ($this->data) {
			$this->Account->begin();
			if ($account = $this->Account->changeEmail($this->data)) {
				// sendmail
				$this->set(compact('account'));
				if ($this->_sendMail($account['Account']['email'], 'Confirm Email', 'confirm_email')) {
					$this->Account->commit();
					$this->Session->setFlash(__('A confirm mail has been sent', true), 'default', array('class' => 'message success'));
					$this->redirect(array('action'=>'login'));
				}
			}
			$this->Account->rollback();
			$this->Session->setFlash(__('The Email could not be changed. Please, try again.', true));
		} else {
			$this->data = $this->Account->read(null, $id);
		}
	}

	public function change_password($id = null) {
		if (is_null($id)) {
			$id = $this->_id;
		} else {
			$id = $this->Account->field('id', array('password_checkcode' => $id));
		}
		if (!$id && !$this->data) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'login'));
		}
		if ($this->data) {
			$this->data['Account']['password'] = $this->Auth->password($this->data['Account']['raw_password']);
			$this->Account->begin();
			if ($account = $this->Account->save($this->data)) {
				$this->Account->commit();
				$this->Session->setFlash(__('The Password has been changed', true), 'default', array('class' => 'message success'));
				$this->redirect(array('action'=>'login'));
			}
			$this->Account->rollback();
			$this->Session->setFlash(__('The Password could not be changed. Please, try again.', true));
		} else {
			$this->data = $this->Account->read(null, $id);
		}
	}

	private function _sendMail($to, $subject, $template = 'default') {
		$params = array(
			'host'=>'smtp.yourserver',
			'port'=>587,
			'from'=>'info@yourdomain',
			'user'=>'user',
			'pass'=>'pass',
			'protocol'=>'SMTP_AUTH',
		);
		$this->Qdmail->smtp(true);
		$this->Qdmail->smtpServer($params);
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