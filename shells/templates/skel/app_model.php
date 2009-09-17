<?php
class AppModel extends Model {
	public $recursive = -1;
	public $actsAs = array('Containable');

	public function find($type, $options = array()) {
		$method = null;
		if(is_string($type)) {
			$method = sprintf('__find%s', Inflector::camelize($type));
		}

		if($method && method_exists($this, $method)) {
			return $this->{$method}($options);
		} else {
			$args = func_get_args();
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
	
	/* example
	private function __findLatest($options) {
		$default = array(
			'conditions' => array('published' => true),
			'order' => array('created' => 'desc'),
			'limit' => 10,
		);
		$options = am($default, $options);
		return parent::find('all', $options);
	}
	*/
}
?>