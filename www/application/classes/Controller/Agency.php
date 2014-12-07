<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller {
	
	public function action_index()
	{
		$news = DB::select('id','title','remark','img','modified_at')
			->from('news')
			->where('agency_id', '=', 1)
			->where('status', '=', 1)
			->order_by('modified_at', 'DESC')
			->offset(0)
			->limit(4)
			->execute()
			->as_array();
		/*
		$articles = DB::select('articles.id','articles.title','articles.remark','articles.modified_at')
			->from('articles')
			->where('articles.agency_id', '=', 1)
			->where('articles.status', '=', 1)
			->order_by('articles.modified_at', 'DESC')
			->offset(0)
			->limit(4)
			->execute();
		*/
		$page = View::factory('agency/index')
			->set('news', $news)
			//->set('articles', $articles)
			->render();
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
		$page = intval($this->request->query('page'));
		$size = intval($this->request->query('size'));
		if ( $page < 0 ) $page = 1;
		if ( $size < 0 ) $size = 10;
		$offset = ($page - 1) * $size; 
		
		$news = DB::select('id','title','remark','img','modified_at')
			->from('news')
			->where('agency_id', '=', 1)
			->where('status', '=', 1)
			->order_by('modified_at', 'DESC')
			->offset($offset)
			->limit($size)
			->execute()
			->as_array();
			
		$page = View::factory('agency/view')
			->set('news', $news)
			->render();
		$this->response->body($page);
	}
	
	public function action_detail() 
	{
		$id = intval($this->request->query('id'));
		
		$news = DB::select('*')
			->from('news')
			->where('agency_id', '=', 1)
			->where('status', '=', 1)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($news) ) {
			HTTP::redirect('/agency/view');
		}
		
		$page = View::factory('agency/detail')
			->set('v', $news[0])
			->render();
		$this->response->body($page);
	}
	
}
