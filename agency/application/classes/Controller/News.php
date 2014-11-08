<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Base {
	
	public function action_list()
	{		
		$title   = strval($this->request->query('title'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'users.id')
				->where('news.agency_id', '=', $this->auth->agency_id)
				->where('news.status', '>', STATUS_DELETED);
			
			$queryList = DB::select('news.id','news.status','news.title','news.created_at','news.modified_at','users.username')
				->from('news')
				->join('users')
				->on('news.created_by', '=', 'users.id')
				->where('news.agency_id', '=', $this->auth->agency_id)
				->where('news.status', '>', STATUS_DELETED);
				
			if ( $title ) {
				$queryCount->where('news.title', 'like', '%'.$title.'%');
				$queryList->where('news.title', 'like',  '%'.$title.'%');
			}
				
			$cnt = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queryList->order_by('news.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute();
			
			$page = View::factory('news/list')
				->set('items', $items);
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'news');
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$upload_dir = $this->get_upload_dir('news');
		Session::instance()->set('upload_dir', $upload_dir);
		$page = View::factory('news/add')
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);
		$this->output($page, 'news');
	}
	
	public function action_edit()
	{	
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('news')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/news/list/');
		}
		
		$upload_dir = $this->get_upload_dir('news');
		Session::instance()->set('upload_dir', $upload_dir);
		$page = View::factory('news/edit')
			->set('item', $items[0])
			->set('session_id', Session::instance()->id())
			->set('upload_dir', $upload_dir);
			
		$this->output($page, 'news');
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['title']       = $this->request->post('title');
		$data['remark']      = $this->request->post('remark');
		$data['content']     = $this->request->post('content');
		$data['show_type']   = intval($this->request->post('show_type'));
		$data['src']         = strval($this->request->post('from'));
		$data['img']         = strval($this->request->post('img'));
		$data['modified_by'] = $this->auth->user_id;
		$data['modified_at'] = date('Y-m-d H:i:s');
		
		$data['status'] = STATUS_NORMAL;
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {				
				DB::update('news')
					->set( $data )
					->where('id', '=', $id)
					->where('agency_id', '=', $this->auth->agency_id)
					->execute();
			} else {
				// add 
				$data['agency_id']   = $this->auth->agency_id;
				$data['created_by']  = $this->auth->user_id;
				$data['created_at']  = date('Y-m-d H:i:s');
				
				DB::insert('news', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/news/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('news')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/news/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_publish()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('news')
				->set( array('status'=>STATUS_ENABLED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/news/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_cancel()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('news')
				->set( array('status'=>STATUS_NORMAL, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/news/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}

} // End News
