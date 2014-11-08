<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Footer extends Controller_Base {
	
	public function action_index()
	{
		$items = DB::select('*')
			->from('footer')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute();
		$content = $items->count() ? $items->get('content') : '';
		
		$page = View::factory('footer/index')
			->set('content', $content);

		$this->output($page, 'setting');
	}
	
	public function action_save()
	{
		$data = array();
		$data['content'] = Arr::get($_POST, 'content', '');
		
		try {
			$rows = DB::update('footer')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->execute();
					
			if ( empty($rows) ) {
				$data['agency_id']  = $this->auth->agency_id;
				DB::insert('footer', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/agency/index/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
