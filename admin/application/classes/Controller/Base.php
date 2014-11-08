<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'code.php';

class Auth_User {
	public $user_id;
	public $username;
	public $realname;
	public $nickname;
}

class Pagenav {
	public $page;
	public $size;
	public $total_items;
	public $total_pages;
}

class Controller_Base extends Controller {
	
	protected $auth;
	
	public function before() 
	{
		$this->auth = new Auth_User;
		
		$this->auth->user_id  = intval( Session::instance()->get('user_id') );
		$this->auth->username = strval( Session::instance()->get('username') );
		$this->auth->realname = strval( Session::instance()->get('realname') );
		$this->auth->realname = strval( Session::instance()->get('nickname') );
		
		$this->ajax_result = array('ret' => 0, 'msg' => 'success');
		
		$this->pagenav = new Pagenav;
		$this->pagenav->page = intval($this->request->query('page'));
		$this->pagenav->size = intval($this->request->query('size'));
				
		$this->pagenav->page   = ($this->pagenav->page < 1)  ? 1  : $this->pagenav->page;
		$this->pagenav->size   = ($this->pagenav->size < 1 ) ? 10 : $this->pagenav->size;
		$this->pagenav->offset = ($this->pagenav->page - 1) * $this->pagenav->size;

		if ( $this->auth->user_id or $this->request->controller() == 'Session' ) {
			return true;
		}

		if ( $this->request->is_ajax() ) {
			$this->ajax_result['ret'] = ERR_NOT_LOGIN;
			$this->ajax_result['msg'] = 'need login';
			echo json_encode($this->ajax_result);exit;
		} else {
			if ( $this->auth->user_id == 0 ) {
				HTTP::redirect('/session/index/');
			} else {
				echo 'permission deny';exit;
			}
		}
	}
		
	public function output(&$page, $menu = '')
	{
		$page->html_head_content = View::factory('head')
			->set('username', $this->auth->username);
		$page->html_left_content = View::factory('left')
			->set('active', $menu);
			
		if ( isset($page->html_pagenav_content) ) {
			$base_url = URL::base(NULL, TRUE).$this->request->controller().'/'.$this->request->action().'/';
			$page->html_pagenav_content->set('base_url', $base_url);
		}
		$page->render();
		$this->response->body($page);
	}
	
	public function agencies() 
	{
		$agencies = array();
		$agencies[] = array('id' => 0, 'realname' => '');
		
		$items = DB::select('id', 'realname')
			->from('agencies')
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$agencies[$v['id']] = $v;
		}
		
		return $agencies;
	}
	
	public function entities() 
	{
		$entities = array();
		$entities[] = array('id' => 0, 'name' => '');
		
		$items = DB::select('id', 'name')
			->from('entities')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$entities[$v['id']] = $v;
		}
		
		return $entities;
	}
	
	public function schools()
	{
		$schools = array();
		
		$items = DB::select('id', 'name')
			->from('schools')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$schools[$v['id']] = $v;
		}
		
		return $schools;
	}
	
	public function grades()
	{
		$grades = array();
		
		$items = DB::select('id', 'name')
			->from('grades')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$grades[$v['id']] = $v;
		}
		
		return $grades;
	}
	
	public function classes()
	{
		$classes = array();
		
		$items = DB::select('id', 'name', 'entity_id')
			->from('classes')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$classes[$v['id']] = $v;
		}
		
		return $classes;
	}
	
	public function courses()
	{
		$courses = array();
		
		$items = DB::select('id', 'name', 'class_id')
			->from('courses')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$courses[$v['id']] = $v;
		}
		
		return $courses;
	}
	
	public function agency_types()
	{
		return DB::select('*')
			->from('agency_types')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
	}
	
	public function client_types()
	{
		return DB::select('*')
			->from('client_types')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
	}
	
	public function pay_types()
	{
		return DB::select('*')
			->from('pay_types')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
	}
	
	public function service_days()
	{
		return DB::select('*')
			->from('service_days')
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
	}
	
	public function get_student_courses(&$items)
	{
		$student_classes  = array();
		$students_classes = array();
		$students = array();
		foreach ($items as $v) {
			$students[] = $v['id'];
		}
		
		if ( $students ) {
			$students_classes = DB::select('students.id',array('classes.name', 'class'), array('courses.name', 'course'))
				->from('students')
				->join('students_courses')
				->on('students.id', '=', 'students_courses.student_id')
				->join('courses')
				->on('students_courses.course_id', '=', 'courses.id')
				->join('classes')
				->on('courses.class_id', '=', 'classes.id')
				->where('students.id', 'in', $students)
				->execute()
				->as_array();
		}
		
		foreach ($students_classes as $v) {
			if ( !isset($student_classes[$v['id']]) ) {
				$student_classes[$v['id']] = array();
			}
			$student_classes[$v['id']][] = $v['class'] . '-' . $v['course'];
		}
		
		return $student_classes;
	}
	
}
