<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller_Base
{
	
	public function action_index()
	{
		if ( isset($_GET['redirect']) ) {
			$redirect = '/' . str_replace('-', '/', $_GET['redirect']);
			$uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
			$id   = isset($_GET['id']) ? $_GET['id'] : '';
			$url  = $redirect . '?uuid=' . $uuid . '&id=' . $id;
			header("location:$url");
			exit;
		}
		
		$items = DB::select('*')
			->from('introductions')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/index')
			->set('content', $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
	public function action_show()
	{
		$items = DB::select('*')
			->from('images')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute()
			->as_array();
		
		$page = View::factory('agency/show')
			->set('items', $items);
		$this->output($page);
	}
	
	public function action_contact()
	{
		$items = DB::select('*')
			->from('contacts')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/contact')
			->set('content',  $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
	public function action_teachers()
	{
		$items = DB::select('*')
			->from('teachers')
			->where('agency_id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		
		$page = View::factory('agency/teachers')
			->set('content', $items->count() ? $items->get('content') : '');

		$this->output($page);
	}
	
}
