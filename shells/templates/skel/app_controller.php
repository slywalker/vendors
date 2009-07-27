<?php
class AppController extends Controller {
	public $components = array('DebugKit.Toolbar');
	public $helpers = array('Time', 'AppPaginator');
}
?>