<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agencytype extends Controller_Base {
		
	public function action_list() 
	{
		try {
			$items = DB::select('*')
				->from('agency_types')
				->execute()
				->as_array();
				
			$page = View::factory('agency_type/list')
				->set('items', $items);
			$this->output($page, 'setting');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_add() 
	{
		$page = View::factory('agency_type/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit() 
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('agency_types')
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/agencytype/list');
		}
		
		$page = View::factory('agency_type/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		$data['name']   = $this->request->post('name');
		$data['remark'] = $this->request->post('remark');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('agency_types')
					->set($data)
					->where('id', '=', $id)
					->execute();
			} else {
				DB::insert('agency_types', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/agencytype/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		DB::update('agency_types')
			->set(array('status' => STATUS_DELETED))
			->where('id', '=', $id)
			->execute();
		HTTP::redirect('/agencytype/list/');
	}
		
}
