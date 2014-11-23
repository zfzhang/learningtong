<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'code.php';

class Auth_User {
	public $user_id;
	public $username;
	public $nickname;
	public $realname;
	public $role_id;
	public $agency_id;
	public $agency_name;
}

class Pagenav {
	public $page;
	public $size;
	public $total_items;
	public $total_pages;
}

class Controller_Base extends Controller {
	
	protected $auth;
	protected $ajax_result;
		
	public function before() 
	{
		$this->auth = new Auth_User;
		
		$this->auth->user_id     = intval( Session::instance()->get('user_id') );
		$this->auth->username    = strval( Session::instance()->get('username') );
		$this->auth->nickname    = strval( Session::instance()->get('nickname') );
		$this->auth->realname    = strval( Session::instance()->get('realname') );
		$this->auth->role_id     = intval( Session::instance()->get('role_id') );
		$this->auth->agency_id   = intval( Session::instance()->get('agency_id') );
		$this->auth->agency_name = strval( Session::instance()->get('agency_name') );
		
		$this->ajax_result = array('ret' => 0, 'msg' => 'success');
		
		$this->pagenav = new Pagenav;
		$this->pagenav->page = intval($this->request->query('page'));
		$this->pagenav->size = intval($this->request->query('size'));
				
		$this->pagenav->page   = ($this->pagenav->page < 1)  ? 1  : $this->pagenav->page;
		$this->pagenav->size   = ($this->pagenav->size < 1 ) ? 10 : $this->pagenav->size;
		$this->pagenav->offset = ($this->pagenav->page - 1) * $this->pagenav->size;

		if ( $this->auth->role_id == AGENCY_ADMIN or $this->request->controller() == 'Session' ) {
			return true;
		}
		
		if ( $this->check_user_permission() ) {
			return true;
		}

		if ( $this->request->is_ajax() ) {
			$this->ajax_result['ret'] = ERR_NOT_LOGIN;
			$this->ajax_result['msg'] = 'need login';
			echo json_encode($this->ajax_result);
			exit;
		} else {
			// redirect
			if ( $this->auth->user_id == 0 ) {
				HTTP::redirect('/session/index/');
			} else {
				HTTP::redirect('/user/deny/');
			}
		}
	}
	
	public function check_user_permission()
	{
		$ctl = $this->request->controller();
		$act = $this->request->action();
		$key = strtolower($ctl.'.'.$act);
		
		$actions = include_once(APPPATH.'config/action.php');
		
		if ( empty($this->auth->user_id) ) {
			return false;
		}
		
		if ( isset($actions[$key]) and $actions[$key]['login'] === false ) {
			return true;
		}
		
		$rights = DB::select('content')
			->from('user_rights')
			->where('user_id', '=', $this->auth->user_id)
			->limit(1)
			->execute();
		if ( $rights->count() == 0 ) {
			return false;
		}
		
		$allow = explode(',', $rights->get('content'));
		if ( !in_array($key, $allow) ) {
			return false;
		}
		
		return true;
	}
	
	public function generate_left_menu()
	{		
		$query = DB::select('name')
			->from('agency_users_groups')
			->where('user_id', '=', $this->auth->user_id)
			->execute()
			->as_array();
		$this->allowed_menu_items = array();
		foreach ( $query as $rs ) {
			$this->allowed_menu_items[$rs] = 1;
		}
	}
	
	public function output(&$page, $menu = '')
	{		
		$page->html_head_content = View::factory('head')
			->set('agency_name', $this->auth->agency_name)
			->set('username', $this->auth->username);
		$page->html_left_content = View::factory('left')
			->set('active', $menu);
		if ( isset($page->html_pagenav_content) ) {
			$base_url = URL::base(NULL, TRUE).$this->request->controller().'/'.$this->request->action().'/';
			$page->html_pagenav_content->set('base_url', $base_url);
		}
		
		$upload_url = URL::base().'upload.php?sid=' . Session::instance()->id();
		Session::instance()->set('base_url', URL::base('http', false));
		$xheditor = "xheditor {tools:'full',width:'640',height:'400',forcePtag:false,upBtnText:'上传',upImgUrl:'$upload_url'}";
		if ( $this->request->controller() == 'Footer' ) {
			$xheditor = "xheditor {tools:'full',width:'640',height:'400',forcePtag:false,upBtnText:'上传',upImgUrl:'$upload_url'}";
		}
		$page->set('xheditor_config', $xheditor);
		$page->set('list_offset',  ($this->pagenav->page - 1) * $this->pagenav->size);
		$page->render();
		$this->response->body($page);
	}
	
	public function entities() 
	{
		$entities = array();
		$entities[] = array('id' => 0, 'name' => '');
		
		$items = DB::select('id', 'name')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
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
			->where('agency_id', '=', $this->auth->agency_id)
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
			->where('agency_id', '=', $this->auth->agency_id)
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
			->where('agency_id', '=', $this->auth->agency_id)
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
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$courses[$v['id']] = $v;
		}
		
		return $courses;
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
	
	public function get_guest_courses(&$items)
	{
		$guest_classes  = array();
		$guests_classes = array();
		$guests = array();
		foreach ($items as $v) {
			$guests[] = $v['id'];
		}
		
		if ( $guests ) {
			$guests_classes = DB::select('guests.id',array('classes.name', 'class'), array('courses.name', 'course'))
				->from('guests')
				->join('guests_courses')
				->on('guests.id', '=', 'guests_courses.guest_id')
				->join('courses')
				->on('guests_courses.course_id', '=', 'courses.id')
				->join('classes')
				->on('courses.class_id', '=', 'classes.id')
				->where('guests.id', 'in', $guests)
				->execute()
				->as_array();
		}
		
		foreach ($guests_classes as $v) {
			if ( !isset($guest_classes[$v['id']]) ) {
				$guest_classes[$v['id']] = array();
			}
			$guest_classes[$v['id']][] = $v['class'] . '-' . $v['course'];
		}
		
		return $guest_classes;
	}
	
	public function get_upload_dir ($module) 
	{
		@mkdir(DOCROOT.'files');
		@chmod(DOCROOT.'files', 0777);
		
		@mkdir(DOCROOT.'files/'.$module);
		@chmod(DOCROOT.'files/'.$module, 0777);
		
		@mkdir(DOCROOT.'files/'.$module.'/'.$this->auth->agency_id);
		@chmod(DOCROOT.'files/'.$module.'/'.$this->auth->agency_id, 0777);
		
		return '/files/'.$module.'/'.$this->auth->agency_id;
	}
}
