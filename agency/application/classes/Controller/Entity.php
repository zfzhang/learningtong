<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Entity extends Controller_Base {
	
	public function action_list()
	{
		$items = DB::select('*')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('entities.status', '>', STATUS_DELETED)
			->execute()
			->as_array();
									
		$page = View::factory('entity/list')
			->set('items', $items);

		$this->output($page, 'setting');
	}
	
	public function action_add()
	{
		$page = View::factory('entity/add');
		$this->output($page, 'setting');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/entity/list/');
		}
		
		$page = View::factory('entity/edit')
			->set('item', $items[0]);
		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['name']      = $this->request->post('name');
		$data['addr']      = $this->request->post('addr');
		$data['mobile']    = $this->request->post('mobile');
		$data['contact']   = $this->request->post('contact');
		$data['remark']    = strval($this->request->post('remark'));
		$data['email']     = strval($this->request->post('mail'));
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$id = intval( $this->request->post('id') );
		try {
			if ( $id ) {					
				DB::update('entities')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();		
			} else {
				$agencies = DB::select('entity_num')
					->from('agencies')
					->where('id', '=', $this->auth->agency_id)
					->execute();
				$expr = DB::expr('COUNT(0)');
				$items = DB::select($expr)
					->from('entities')
					->where('agency_id', '=', $this->auth->agency_id)
					->execute();
				if ( $items->get('COUNT(0)') >= $agencies->get('entity_num') ) {
					$page = View::factory('entity/limit');
					$this->output($page);
					return;
				}
			
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('entities', array_keys($data))
					->values($data)
					->execute();
			}
			HTTP::redirect('/entity/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
		
			$data = array(
				'status'      => STATUS_DELETED,
				'modified_at' => date('Y-m-d H:i:s')
			);
			
			DB::update('entities')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
				
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
			return;
		}
		
		HTTP::redirect('/entity/list/');
	}
	
	public function action_courses()
	{
		$id = intval($this->request->query('id'));
		
		$queryItems = DB::select('courses.id','courses.name')
			->from('courses')
			->join('classes')
			->on('courses.class_id', '=', 'classes.id')
			->join('entities')
			->on('classes.entity_id', '=', 'entities.id')
			->where('courses.agency_id', '=', $this->auth->agency_id);
		if ( $id ) {
			$queryItems->where('classes.entity_id', '=', $id);
		}
		$items = $queryItems->execute()
			->as_array();
		echo json_encode($items);exit;
	}
}
