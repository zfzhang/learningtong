<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller {
	
	public function action_index()
	{
		$page = View::factory('agency/index')->render();
		$this->response->body($page);
	}
	
	public function action_pro() 
	{
		$page = View::factory('agency/pro')->render();
		$this->response->body($page);
	}
	
	public function action_solution() 
	{
		$page = View::factory('agency/solution')->render();
		$this->response->body($page);
	}
	
	public function action_us() 
	{
		$page = View::factory('agency/us')->render();
		$this->response->body($page);
	}
	
	public function action_view() 
	{
		$page = View::factory('agency/view')->render();
		$this->response->body($page);
	}
	
	public function action_detail() 
	{
		$page = View::factory('agency/detail')->render();
		$this->response->body($page);
	}
	
}
