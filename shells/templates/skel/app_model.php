<?php
class AppModel extends Model {
	public $actsAs = array('Containable');

	//Validation message i18n
	function invalidate($field, $value = true){
		parent::invalidate($field, $value);
		$this->validationErrors[$field] = __($value, true);
	}
}
?>