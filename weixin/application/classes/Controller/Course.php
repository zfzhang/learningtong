<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Course extends Controller_Base {

	public function action_list() 
	{
		$class_id  = intval($this->request->query('class_id'));
		$for = Arr::get($_GET, 'for', '');
		
		try {
			$classes = DB::select('*')
				->from('classes')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $class_id)
				->limit(1)
				->execute()
				->as_array();
			if ( count($classes) == 0 ) {
				HTTP::redirect('/classes/list/');
			}
				
			$items = DB::select('*')
				->from('courses')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('class_id', '=', $class_id)
				->execute()
				->as_array();
				
			$signup_explain = DB::select('content')
				->from('signup_explain')
				->where('agency_id', '=', $this->auth->agency_id)
				->execute();
			
			$page = View::factory('course/list')
				->set('class',   $classes[0])
				->set('items',   $items)
				->set('for',     $for)
				->set('explain', $signup_explain->count() ? $signup_explain->get('content') : '');
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
		
		try {
			$courses = DB::select('*')
				->from('courses')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->limit(1)
				->execute()
				->as_array();
			if ( empty($courses) ) {
				HTTP::redirect('/course/list/');
			}
			
			$classes = DB::select('id','name')
				->from('classes')
				->where('id', '=', $courses[0]['class_id'])
				->execute();
			
			$page = View::factory('course/detail')
				->set('item',  $courses[0])
				->set('class', $classes->get('name'));
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
