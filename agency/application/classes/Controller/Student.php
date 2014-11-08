<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Base {
	
	public function action_list()
	{
		$this->comm_list();
	}
	
	public function action_select()
	{
		$this->comm_list(1);
	}
	
	public function comm_list( $pop = 0 )
	{
		$signup   = $this->request->query('signup');
		$entity   = $this->request->query('entity');
		$school   = $this->request->query('school');
		$grade    = $this->request->query('grade');
		$class    = $this->request->query('class');
		$realname = $this->request->query('realname');
		$sex      = $this->request->query('sex');
		$mobile   = $this->request->query('mobile');
		$father_name   = $this->request->query('father_name');
		$father_mobile = $this->request->query('father_mobile');
		$mother_name   = $this->request->query('mother_name');
		$mother_mobile = $this->request->query('mother_mobile');
		
		$expr = DB::expr('COUNT(0)');
		$queryCount = DB::select($expr)
			->from('students')
			->where('students.agency_id', '=', $this->auth->agency_id);
		
		
		$queryItems = DB::select('students.*',array('schools.name', 'school'),array('grades.name','grade'))
			->from('students')
			->where('students.agency_id', '=', $this->auth->agency_id)
			->join('schools', 'LEFT')
			->on('students.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('students.grade_id', '=', 'grades.id');
			
		if ( $signup == 'adult' ) {
			$queryItems->where('students.signup_by',  '=', 3);
			$queryCount->where('students.signup_by',  '=', 3);
		} else {
			$queryItems->where('students.signup_by',  '<', 3);
			$queryCount->where('students.signup_by',  '<', 3);
		}
				
		if ( $entity ) {
			$queryItems->where('students.entity_id',  '=', $entity);
			$queryCount->where('students.entity_id',  '=', $entity);
		}
		
		if ( $school ) {
			$queryItems->where('students.school_id',  '=', $school);
			$queryCount->where('students.school_id', '=', $school);
		}
		if ( $grade ) {
			$queryItems->where('students.grade_id',  '=', $grade);
			$queryCount->where('students.grade_id', '=', $grade);
		}
		if ( $class ) {
			$items = DB::select('student_id')
				->from('students_courses')
				->where('course_id', '=', $class)
				->execute()
				->as_array();
			$students = array();
			foreach ($items as $v) {
				$students[] = $v['student_id'];
			}
			if ( $students ) {
				$queryCount->where('students.id', 'in', $students);
				$queryItems->where('students.id', 'in', $students);
			} else {
				$queryCount->where('students.id', '=', 0);
				$queryItems->where('students.id', '=', 0);
			}
		}
		if ( $realname ) {
			$queryItems->where('students.realname', 'like', '%'.$realname.'%');
			$queryCount->where('students.realname', 'like', '%'.$realname.'%');
		}
		if ( $sex != '' ) {
			$queryItems->where('students.sex', '=', $sex);
			$queryCount->where('students.sex', '=', $sex);
		}
		if ( $mobile ) {
			$queryItems->where('students.mobile', '=', $mobile);
			$queryCount->where('students.mobile', '=', $mobile);
		}
		if ( $father_name ) {
			$queryItems->where('students.father_name', 'like', '%'.$father_name.'%');
			$queryCount->where('students.father_name', 'like', '%'.$father_name.'%');
		}
		if ( $father_mobile ) {
			$queryItems->where('students.father_mobile', '=', $father_mobile);
			$queryCount->where('students.father_mobile', '=', $father_mobile);
		}
		if ( $mother_name ) {
			$queryItems->where('students.mother_name', 'like', '%'.$mother_name.'%');
			$queryCount->where('students.mother_name', 'like', '%'.$mother_name.'%');
		}
		if ( $mother_mobile ) {
			$queryItems->where('students.mother_mobile', '=', $mother_mobile);
			$queryCount->where('students.mother_mobile', '=', $mother_mobile);
		}
		
		
		$cnt = $queryCount->execute();
		$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
		
		$items = $queryItems->order_by('students.id', 'DESC')
			->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
		
		$viewname = $pop ? 'student/list_for_select' : 'student/list';
		$page = View::factory($viewname)
			->set('items',    $items)
			->set('signup',   $signup)
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses())
			->set('student_classes', $this->get_student_courses($items));
		$page->html_pagenav_content = View::factory('pagenav')
			->set('total', $total)
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size);
		$this->output($page, 'student');	
	}
	
	public function action_add()
	{
		$adult = Arr::get($_GET, 'adult', 0);
		
		$viewname = $adult ? 'student/add_adult' : 'student/add';
		$page = View::factory($viewname)
			->set('entities', $this->entities())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses());			
		$this->output($page, 'student');		
	}
	
	public function action_edit()
	{		
		$id = intval($this->request->query('id'));
			
		$result = DB::select('course_id')
			->from('students_courses')
			->where('student_id', '=', $id)
			->execute()
			->as_array();
		$data_courses = array();
		foreach ( $result as $v ) {
			$data_courses[$v['course_id']] = 1;
		}
		
		$items = DB::select('*')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/student/list/');
		}
		
		$code = DB::select('*')
			->from('student_valid')
			->where('student_id', '=', $id)
			->limit(1)
			->execute();
		
		$viewname = 'student/edit';
		if ( $items[0]['signup_by'] == 3 ) {
			$viewname .= '_adult';
		}
		
		$page = View::factory($viewname)
			->set('item',    $items[0])
			->set('code',    $code->get('code'))
			->set('schools', $this->schools())
			->set('grades',  $this->grades())
			->set('courses', $this->courses())
			->set('student_courses', $data_courses)
			->set('entities', $this->entities());
			
		$this->output($page, 'student');
	}
	
	public function action_save()
	{
		$id  = intval($this->request->post('id'));
		$new = $id ? false : true;
		
		if ( $new ) {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('students')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status', '>', STATUS_DELETED)
				->execute();
			$queryLimit = DB::select('student_num')
				->from('agencies')
				->where('id', '=', $this->auth->agency_id)
				->execute();
			if ( $queryCount->get('COUNT(0)') >= $queryLimit->get('student_num') ) {
				$page = View::factory('student/limit');
				$this->output($page);
				return;
			}
		}
	
		$data = array();
		
		$data['sex']       = intval($this->request->post('sex'));
		$data['realname']  = $this->request->post('realname');
		$data['mobile']    = $this->request->post('mobile');
		$data['birthday']  = $this->request->post('birthday');
		$data['province']  = intval($this->request->post('province'));
		$data['city']      = intval($this->request->post('city'));
		$data['area']      = intval($this->request->post('area'));
		$data['addr']      = $this->request->post('addr');
		$data['remark']    = $this->request->post('remark');
		$data['signup_by'] = intval($this->request->post('signup_by'));
		
		$data['father_name']    = strval($this->request->post('father_name'));
		$data['father_mobile']  = strval($this->request->post('father_mobile'));
		$data['mother_name']    = strval($this->request->post('mother_name'));
		$data['mother_mobile']  = strval($this->request->post('mother_mobile'));
		
		$data['entity_id']      = intval($this->request->post('entity_id'));
		$data['school_id']      = intval($this->request->post('school_id'));
		$data['grade_id']       = intval($this->request->post('grade_id'));

		$data['email'] = strval($this->request->post('email'));
		$data['QQ']    = strval($this->request->post('QQ'));
		
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$courses = $this->request->post('course');
		
		try {
			DB::delete('students_courses')
				->where('student_id', '=', $id)
				->execute();
				
			if ( $id ) {
				$rows = DB::update('students')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
				list($id, $rows) = DB::insert('students', array_keys($data))
					->values($data)
					->execute();
			}
					
			$student_courses = array(
				'student_id'  => $id,
				'course_id'   => 0
			);
			
			if ( $courses ) {
				$insert = DB::insert('students_courses', array_keys($student_courses));
				foreach ($courses as $course_id) {
					if ( empty($course_id) ) continue;
					$student_courses['course_id'] = $course_id;
					$insert->values($student_courses);
				}
				$insert->execute();
			}
			
			if ( !$new ) {
				HTTP::redirect('/student/list/');
			} else {
				HTTP::redirect('/student/notify/?id='.$id);
			}
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_search()
	{
		$student_id = intval( $this->request->post('student_id') );
		$entity_id  = intval( $this->request->post('entity') );
		$school_id  = intval( $this->request->post('school') );
		$grade_id   = intval( $this->request->post('grade') );
		$class_id   = intval( $this->request->post('class') );
		$realname   = $this->request->post('realname');
		
		try {
			$query = DB::select('students.id', 'students.realname', 'students.birthday')
				->from('students')
				->where('students.agency_id', '=', $this->auth->agency_id);
			if ( $student_id ) {
				$query->where('students.id', '=', $student_id);
			}
			if ( $entity_id ) {
				$query->where('students.entity_id', '=', $entity_id);
			}
			if ( $school_id ) {
				$query->where('students.school_id', '=', $school_id);
			}
			if ( $grade_id ) {
				$query->where('students.grade_id', '=', $grade_id);
			}
			if ( $class_id ) {
				$query->join('students_courses')
					->on('students_id', '=', 'students_courses.student_id')
					->where('students_courses.id', '=', $class_id);
			}
			if ( $realname ) {
				$query->where('students.realname', '=', $realname);
			}
			$students = $query->execute()->as_array();
			$this->response->body( json_encode($students) );
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
		
	public function action_del()
	{
		$id = intval($this->request->query('id'));
				
		try {
			DB::update('students')
				->set( array('status'=>STATUS_DELETED, 'modify_t'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/students/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_notify() 
	{
		$id = intval($this->request->query('id'));
		$students = DB::select('*')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( empty($students) ) {
			HTTP::redirect('/student/list/');
		}
		
		$code = '';
		$items = DB::select('*')
			->from('student_valid')
			->where('student_id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) ) {
			$code = $items[0]['code'];
		} else {
		
			do {
				$code  = $this->generate_rand(6);
				$items = DB::select('id')
					->from('student_valid')
					->where('agency_id', '=', $this->auth->agency_id)
					->where('code', '=', $code)
					->limit(1)
					->execute();
			} while ( $items->count() );
		
			$data = array();
			$data['agency_id']  = $this->auth->agency_id;
			$data['student_id'] = $id;
			$data['code']       = $code;
			$data['created_at'] = date('Y-m-d H:i:s');
			//$data['expired_at'] = date('Y-m-d H:i:s');
			
			try {
				DB::insert('student_valid', array_keys($data))
					->values($data)
					->execute();
			} catch (Database_Exception $e) {
				$this->response->body( $e->getMessage() );
				return;
			}
		}
		
		$page = View::factory('student/notify')
			->set('item', $students[0])
			->set('code', $code)
			->set('agency', $this->auth->agency_name);
		$this->output($page, 'student');
	}
	
	public function action_sms() 
	{
		$id = intval($this->request->post('id'));
		$items = DB::select('code')
			->from('student_valid')
			->where('student_id', '=', $id)
			->limit(1)
			->execute();
		if ( $items->count() == 0 ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '验证码不存在';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		$code = $items->get('code');
		
		$phones = strval($this->request->post('phones'));
		$phones = explode(',', $phones);
		if ( empty($phones) ) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = '请选择手机号码';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		require_once APPPATH.'../vendor/CCPRestSmsSDK.php';

		//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid   = 'aaf98f89486445e601486d44059b026d';
		
		//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken = 'c905e240d89d48f1ab045dac840539f1';
		
		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId = '8a48b55148fe48600149035485450266';
		
		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP = 'app.cloopen.com';
		
		//请求端口，生产环境和沙盒环境一致
		$serverPort = '8883';
		
		//REST版本号，在官网文档REST介绍中获得。
		$softVersion = '2013-12-26';
		
		$rows = DB::select('sms_tpl_id')
			->from('agencies')
			->where('id', '=', $this->auth->agency_id)
			->limit(1)
			->execute();
		//短信模板ID
		$tempId = $rows->count() ? $rows->get('sms_tpl_id') : 1;//5379;
		
		$rest = new REST($serverIP,$serverPort,$softVersion);
		$rest->setAccount($accountSid, $accountToken);
		$rest->setAppId($appId);
		
		foreach ($phones as $to) {
			if ( empty($to) ) {
				continue;
			}
			
			// 发送模板短信
			//$result = $rest->sendTemplateSMS($to, array($this->auth->agency_name, $code), $tempId);
			$result = $rest->sendTemplateSMS($to, array($code), $tempId);
			if( $result == NULL ) {
				$this->ajax_result['ret'] = ERR_DB_SELECT;
				$this->ajax_result['msg'] = '发送短信失败';
				$this->response->body( json_encode($this->ajax_result) );
				return;
			}
			
			if( $result->statusCode != 0 ) {
				//TODO 添加错误处理逻辑
				$this->ajax_result['ret'] = $result->statusCode;
				$this->ajax_result['msg'] = $result->statusMsg;
				$this->response->body( json_encode($this->ajax_result) );
				return;
			}
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function generate_rand( $l )
	{ 
		$rand = '';
		$c = "0123456789"; 
		srand((double)microtime()*1000000); 
		for( $i=0; $i<$l; $i++ ) { 
			$rand .= $c[rand()%strlen($c)]; 
		} 
		return $rand; 
	} 
}
