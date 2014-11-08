<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Servicedays extends Controller_Base {
		
	public function action_list() 
	{
		try {
			$items = DB::select('*')
				->from('service_days')
				->execute()
				->as_array();
				
			$page = View::factory('service_days/list')
				->set('items', $items);
			$this->output($page, 'setting');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_add() 
	{
		$page = View::factory('service_days/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit() 
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('service_days')
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/servicedays/list');
		}
		
		$page = View::factory('service_days/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		$data['days']   = intval($this->request->post('days'));
		$data['name']   = $this->request->post('name');
		$data['remark'] = $this->request->post('remark');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('service_days')
					->set($data)
					->where('id', '=', $id)
					->execute();
			} else {
				DB::insert('service_days', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/servicedays/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		DB::update('service_days')
			->set(array('status' => STATUS_DELETED))
			->where('id', '=', $id)
			->execute();
		HTTP::redirect('/servicedays/list/');
	}
		
}
