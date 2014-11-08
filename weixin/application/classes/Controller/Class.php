<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Class extends Controller_Base {

	public function action_index()
	{
		$entity_id = intval($this->request->query('entity_id'));
		$for = Arr::get($_GET, 'for', '');
		
		$entities = $this->entities();
		if ( $entity_id < 1 ) {
			foreach ( $entities as $key => $value ) {
				$entity_id = $key;
				break;
			}
		}
				
		try {			
			$list = DB::select('id','name')
				->from('classes')
				->where('agency_id', '=', $this->auth->agency_id);
			if ( $entity_id ) {
				$list->where('entity_id', '=', $entity_id);
			}
			$items = $list->execute();
			
			$page = View::factory('classes/list')
				->set('items',     $items)
				->set('entity_id', $entity_id)
				->set('entities',  $entities)
				->set('for',       $for);
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
