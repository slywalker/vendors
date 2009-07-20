<?php
class Account extends AppModel {
	public $name = 'Account';
	public $validate = array(
		'name' => array(
			array(
				'rule' => array('isUnique'),
				'message' => 'This field must be unique',
			),
			array(
				'rule' => array('notEmpty'),
			),
		),
		'email' => array(
			array(
				'rule' => array('checkCompare', '_confirm'),
				'message' => 'This field is differ with confirm',
			),
			array(
				'rule' => array('isUnique'),
				'message' => 'This field must be unique',
			),
			array(
				'rule' => array('email'),
			),
		),
		'raw_password' => array(
			array(
				'rule' => array('checkCompare', '_confirm'),
				'message' => 'This field is differ with confirm',
			),
			array(
				'rule' => array('notEmpty'),
			),
		),
		'password' => array('notempty'),
		//'email_checkcode' => array('notempty'),
		//'password_checkcode' => array('notempty'),
		'disabled' => array('numeric'),
	);

	public function register($data) {
		// 期限切れregister削除
		$conditions = array(
			'NOT' => array($this->alias.'.email_checkcode' => null),
			$this->alias.'.disabled' => 1,
			$this->alias.'.expires <' => date('Y-m-d H:i:s'),
		);
		$this->deleteAll($conditions);
		// データ追加
		$data[$this->alias]['email_checkcode'] = String::uuid();
		$data[$this->alias]['disabled'] = 1;
		$data[$this->alias]['expires'] = date('Y-m-d H:i:s', strtotime('now '.$expires));
		$this->create();
		return $this->save($data);
	}

	public function changeEmail($data) {
		$this->set($data);
		if (!$this->validates()) {
			return false;
		}
		// uuid発行
		$_data = array(
			$this->alias => array(
				'id' => $data[$this->alias]['id'],
				'email_tmp' => $data[$this->alias]['email'],
				'email_checkcode' => String::uuid(),
				'expires' => date('Y-m-d H:i:s', strtotime('now '.$expires)),
			),
		);
		return $this->save($_data, false, array('id', 'email_tmp', 'email_checkcode', 'expires'));
	}

	public function forgotPassword($email) {
		// email存在確認
		$conditions = array($this->alias.'.email' => $email);
		$data = $this->find('first', compact('conditions'));
		if (!$data) {
			return false;
		}
		// uuid発行
		$_data = array(
			$this->alias => array(
				'id' => $data[$this->alias]['id'],
				'email' => $data[$this->alias]['email'],
				'password_checkcode' => String::uuid(),
				'expires' => date('Y-m-d H:i:s', strtotime('now '.$expires)),
			),
		);
		return $this->save($_data, false, array('id', 'email', 'password_checkcode', 'expires'));
	}

	private function _findByEmailCheckcode($emailCheckcode) {
		// checkcode存在確認
		$conditions = array(
			$this->alias.'.email_checkcode' => $emailCheckcode,
			$this->alias.'.expires >' => date('Y-m-d H:i:s'),
		);
		return $this->find('first', compact('conditions'));
	}

	public function confirmRegister($emailCheckcode) {
		$data = $this->_findByEmailCheckcode($emailCheckcode);
		if (!$data) {
			return false;
		}
		// データ更新
		$_data = array(
			$this->alias => array(
				'id' => $data[$this->alias]['id'],
				'email_checkcode' => '',
				'disabled' => 0,
				'expires' => null,
			)
		);
		return $this->save($_data, false, array('id', 'email_checkcode', 'disabled', 'expires'));
	}

	public function confirmEmail($emailCheckcode) {
		$data = $this->_findByEmailCheckcode($emailCheckcode);
		if (!$data) {
			return false;
		}
		// データ更新
		$_data = array(
			$this->alias => array(
				'id' => $data[$this->alias]['id'],
				'email_checkcode' => '',
				'email' => $data[$this->alias]['email_tmp'],
				'email_tmp' => '',
				'expires' => null,
			),
		);
		return $this->save($_data, false, array('id', 'email_checkcode', 'email', 'email_tmp', 'expires'));
	}

}
?>