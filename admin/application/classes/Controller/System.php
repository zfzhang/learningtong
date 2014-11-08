<?php defined('SYSPATH') or die('No direct script access.');

class Controller_System extends Controller_Base {
	
	public function action_index()
	{
		$page = View::factory('index');
		$this->output($page, 'baseinfo');
	}
	
	public function action_backup() 
	{
		$page = View::factory('system/backup');
		$this->output($page, 'backup');
	}
	
}
