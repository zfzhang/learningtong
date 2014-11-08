<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Base {
	
	protected $data = array();
	
	public function action_infor()
	{
		$adult = intval($this->request->query('adult'));
		
		try {
			$items = DB::select('*')
				->from('students')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id',        '=', $this->auth->student_id)
				->limit(1)
				->execute()
				->as_array();
			
			if ( empty($items) ) {
				$items = array();
				$v = array();
				$v['agency_id'] = $this->auth->agency_id;
				$v['realname']  = '';
				$v['sex']       = 0;
				$v['signup_by'] = 0;
				$v['agency_id'] = 0;
				$v['entity_id'] = 0;
				$v['school_id'] = 0;
				$v['grade_id']  = 0;
				$v['wx_openid'] = '';
				$v['birthday']  = '';
				$v['mobile']    = '';
				$v['email']     = '';
				$v['QQ']        = '';
				$v['father_name']   = '';
				$v['father_mobile'] = '';
				$v['mother_name']   = '';
				$v['mother_mobile'] = '';
				$v['province']      = 0;
				$v['city']          = 0;
				$v['area']          = 0;
				$v['addr']          = '';
				$items[] = $v;
			} elseif (!$adult) {
				$adult = ($items[0]['signup_by'] == REGISTER_ROLE_ADULT) ? 1 : 0;
			}
			
			$viewname = $adult ? 'student/adult_infor' : 'student/infor';
			$page = View::factory($viewname)
				->set('item',     $items[0])
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('students', $this->students())
				->set('self',     $this->auth->student_id);
				
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_save()
	{
		if ( empty($this->auth->wx_openid) ) {
			HTTP::redirect('/agency/index/');
		}
		
		$data = array();
		//$data['wx_openid'] = $this->auth->wx_openid;
		//$data['realname']  = strval($this->request->post('realname'));
		//$data['sex']       = intval($this->request->post('sex'));
		//$data['signup_by'] = intval($this->request->post('signup_by'));
		$data['entity_id'] = intval($this->request->post('entity_id'));
		$data['school_id'] = intval($this->request->post('school_id'));
		$data['grade_id']  = intval($this->request->post('grade_id'));
		$data['birthday']  = strval($this->request->post('birthday'));
		$data['mobile']    = strval($this->request->post('mobile'));
		//$data['father_name']   = strval($this->request->post('father_name'));
		//$data['father_mobile'] = strval($this->request->post('father_mobile'));
		//$data['mother_name']   = strval($this->request->post('mother_name'));
		//$data['mother_mobile'] = strval($this->request->post('mother_mobile'));
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		$data['addr']      = strval($this->request->post('addr'));
		$data['email']     = strval($this->request->post('email'));
		$data['QQ']        = strval($this->request->post('QQ'));
		
		try {
			DB::update('students')
				->set($data)
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $this->auth->student_id)
				->execute();

			HTTP::redirect('/student/infor/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_change()
	{
		$id  = intval($this->request->query('id'));
		$uri = Arr::get($_GET, 'uri', '/student/infor/');
		
		$this->change_login($id);
		
		HTTP::redirect($uri);
	}
	
	public function action_add()
	{
		$page = View::factory('student/add');
		$this->output($page);
	}
	
	public function action_bind()
	{
		$code = strval($this->request->post('code'));
		if ( empty($code) ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '请输入验证码';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$item = DB::select('*')
			->from('student_valid')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('code',  '=', $code)
			->limit(1)
			->execute();
		if ( $item->count() == 0 ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '验证码不存在';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$student_id = $item->get('student_id');
		if ( $student_id == 0 ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '验证码无效，请联系机构重发';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		try {
			$data = array();
			$data['wx_openid']  = $this->auth->wx_openid;
			$data['student_id'] = $student_id;
			DB::insert('wx_students', array_keys($data))
				->values($data)
				->execute();
			$this->auth->student_id = $student_id;
			Session::instance()->set('student_id', $student_id);
		}  catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
}
