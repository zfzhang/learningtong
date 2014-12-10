<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'code.php';

class Auth_User {
	public $status;
	public $user_id;
	public $student_id;
	public $wx_openid;
	public $agency_id;
	public $username;
	public $realname;
	public $school_id;
	public $grade_id;
	public $class_id;
}

class Pagenav {
	public $page;
	public $size;
	public $total_items;
	public $total_pages;
}

class Controller_Base extends Controller {
	
	protected $need_auth = false;
	protected $agency;
	protected $auth;
	protected $ajax_result = array('ret' => 0, 'msg' => 'success');
	
	public function before() 
	{
		$this->auth = new Auth_User;
		
		$this->auth->status      = intval( Session::instance()->get('status') );
		$this->auth->user_id     = intval( Session::instance()->get('user_id') );
		$this->auth->student_id  = intval( Session::instance()->get('student_id') );
		$this->auth->wx_openid   = strval( Session::instance()->get('wx_openid') );
		//$this->auth->agency_id   = intval( Session::instance()->get('agency_id') );
		$this->auth->username    = strval( Session::instance()->get('username') );
		$this->auth->realname    = strval( Session::instance()->get('realname') );
		$this->auth->school_id   = intval( Session::instance()->get('school_id') );
		$this->auth->grade_id    = strval( Session::instance()->get('grade_id') );
		
		$uuid1 = Arr::get($_GET, 'uuid', '');
		$uuid2 = Session::instance()->get('uuid');
		
		$this->init_agency();
		if ( $this->request->action() != 'wx_login' and empty($this->auth->wx_openid) ) {
			$need_auth = false;
			
			// 切换公众号需要重新认证
			if ( $uuid1 and $uuid2 and $uuid1 != $uuid2 ) {
				$need_auth = true;
			}
			
			// 访问需要权限的页面也需要认证
			$c = $this->request->controller();
			if ( $c == 'Student' or $c == 'Feedback' or $c == 'Comment' or $c == 'Task' or $c == 'Report' ) {
				$need_auth = true;
			}
			
			if ( $need_auth ) {
				Session::instance()->set('callback_url', '/'.$this->request->controller().'/'.$this->request->action().'/');
				$this->wx_auth();
				return;
			}
			
		}
		
		$this->pagenav = new Pagenav;
		$this->pagenav->page = intval($this->request->query('page'));
		$this->pagenav->size = intval($this->request->query('size'));
				
		$this->pagenav->page   = ($this->pagenav->page < 1)  ? 1  : $this->pagenav->page;
		$this->pagenav->size   = ($this->pagenav->size < 1 ) ? 10 : $this->pagenav->size;
		$this->pagenav->offset = ($this->pagenav->page - 1) * $this->pagenav->size;
		
		//$this->auth->student_id = 5;
		if ( empty($this->auth->student_id) and $this->request->controller() != 'Guest' and !$this->refresh_student_infor() ) {
			//Log::instance()->add(Log::DEBUG, 'deny');
			switch ( $this->request->controller() ) {
				case 'Feedback':
				case 'Comment':
				case 'Task':
				case 'Report': 
				case 'Student':
					if ( $this->auth->status != GUEST_STATUS_ENABLED ) {
						HTTP::redirect('/guest/deny/');
					} else {
						HTTP::redirect('/guest/valid/');
					}
				default:return;
			}
		}
	}
	
	public function init_agency()
	{
		$uuid = Arr::get($_GET, 'uuid', '');
		if ( empty($uuid) ) {
			$uuid = Session::instance()->get('uuid');
		}
		
		try {
			$this->agency = DB::select('*')
				->from('agencies')
				->where('username', '=', $uuid)
				->limit(1)
				->execute();
			$this->auth->agency_id = $this->agency->get('id');
				
			//Session::instance()->set('agency_id', $this->auth->agency_id);
			Session::instance()->set('uuid', $uuid);
			
			if ( $this->agency->get('theme') ) {
				Session::instance()->set('theme', $this->agency->get('theme'));
			} else {
				Session::instance()->set('theme', 'blue');
			}
			
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function wx_auth() 
	{
		$data = array();
		$data['appid']         = $this->agency->get('wx_appid');
		$data['response_type'] = 'code';
		$data['scope']         = 'snsapi_userinfo';
		$data['state']         = $this->agency->get('id');
		$data['redirect_uri']  = urlencode( URL::base('http', true) . 'base/wx_login/' );
		
		$params = array();
		foreach ($data as $key => $val) {
			$params[] = $key.'='.$val;
		}
		
		$auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . implode('&', $params) .'#wechat_redirect';
		//Log::instance()->add(Log::DEBUG, $auth_url);
		header('Location: '.$auth_url);
		exit;
	}
	
	public function action_wx_login()
	{
		//Log::instance()->add(Log::DEBUG, 'wx_login');
		
		$data = array();
		$data['appid']   = $this->agency->get('wx_appid');
		$data['secret']  = $this->agency->get('wx_secret');
		$data['code']    = $_GET['code'];
		$data['grant_type'] = 'authorization_code';
		
		$params = array();
		foreach ($data as $key => $val) {
			$params[] = $key.'='.$val;
		}
		
		$access_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . implode('&', $params);
		
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $access_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$jsonStr = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		
		//Log::instance()->add(Log::DEBUG, $jsonStr);
		
		$result = json_decode($jsonStr, true);
		if ( isset($result['errcode']) ) {
			//Log::instance()->add(Log::DEBUG, $result['errcode']);
			HTTP::redirect( '/agency/index/?uuid='. Session::instance()->get('uuid') );
			echo 'wx_openid: ',$this->auth->wx_openid,'<br />';
			echo 'openid: ',Session::instance()->get('wx_openid'),'<br />';
			echo '<pre>';
			print_r($_GET);
			echo '</pre>';
			echo $access_url,'<br />';
			echo '<pre>';
			print_r($result);
			echo '</pre>';
			exit;
		}

		$r1 = $this->auto_login( $result['openid'] );
		$r2 = $this->save_wx_userinfo( $result['openid'], $result['access_token'] );
		
		if ( $r1 and $r2 ) {
			$callback_url = Session::instance()->get('callback_url');
			if ( empty($callback_url) ) {
				$callback_url = '/agency/index/';
			}
			HTTP::redirect($callback_url);
		}
	}
	
	public function auto_login( $wx_openid )
	{
		//Log::instance()->add(Log::DEBUG, 'auto_login');
		Session::instance()->set('wx_openid', $wx_openid);
		
		try {
			$user = DB::select('*')
				->from('guests')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('wx_openid', '=', $wx_openid)
				->limit(1)
				->execute();
			if ( $user->count() ) {
				$this->auth->user_id    = $user->get('id');
				$this->auth->status     = $user->get('status');
				$this->auth->student_id = $user->get('student_id');
				$this->auth->wx_openid  = $user->get('wx_openid');
				
				Session::instance()->set('status',     $this->auth->status);
				Session::instance()->set('user_id',    $this->auth->user_id);
				Session::instance()->set('student_id', $this->auth->student_id);
				Session::instance()->set('wx_openid',  $this->auth->wx_openid);
			
				$this->change_login( $user->get('student_id'), false );
				
				//Log::instance()->add(Log::DEBUG, 'user exist');
			} else {
				$data = array();
				$data['agency_id']   = $this->auth->agency_id;
				$data['wx_openid']   = $wx_openid;
				//$data['status']      = GUEST_STATUS_ENABLED;
				$data['created_at']  = date('Y-m-d H:i:s');
				$data['modified_at'] = date('Y-m-d H:i:s');
				DB::insert('guests', array_keys($data))
					->values($data)
					->execute();
			}
			
			return true;
			
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
			return false;
		}
	}
	
	protected function save_wx_userinfo($wx_openid, $access_token)
	{
		try {
			$wx_user = DB::select('*')
				->from('wx_users')
				->where('openid', '=', $wx_openid)
				->limit(1)
				->execute();
			if ( $wx_user->count() ) {
				return true;
			}
			
			
			$access_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $wx_openid . '&lang=zh_CN';
			
			//初始化
			$ch = curl_init();
			//设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $access_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			//执行并获取HTML文档内容
			$jsonStr = curl_exec($ch);
			//释放curl句柄
			curl_close($ch);
			
			$result = json_decode($jsonStr, true);
			if ( isset($result['errcode']) ) {
				echo $access_url,'<br />';
				echo '<pre>';
				print_r($result);
				echo '</pre>';
				exit;
			}
		
			$user = array();
			$user['openid']     = $result['openid'];
			$user['nickname']   = $result['nickname'];
			$user['sex']        = $result['sex'];
			$user['province']   = $result['province'];
			$user['country']    = $result['country'];
			$user['headimgurl'] = $result['headimgurl'];
			$user['privilege']  = implode( ',', $result['privilege'] );
			DB::insert('wx_users', array_keys($user))
				->values($user)
				->execute();
				
			return true;
			
		} catch ( Database_Exception $e ) {
			$this->response->body($e->getMessage());
			return false;
		}
	}
	
	public function change_login($student_id, $check = true)
	{
		if ( $check ) {
			$students = $this->students();
			if ( !isset($students[$student_id]) ) {
				return false;
			}
		}
		
		$user = DB::select('*')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $student_id)
			->limit(1)
			->execute();
		if ( $user->count() == 0 ) {
			return false;
		}
		
		$this->auth->student_id = $user->get('id');
		$this->auth->username   = $user->get('username');
		$this->auth->realname   = $user->get('realname');
		$this->auth->agency_id  = $user->get('agency_id');
		$this->auth->school_id  = $user->get('school_id');
		$this->auth->grade_id   = $user->get('grade_id');
		
		Session::instance()->set('student_id', $this->auth->student_id);
		Session::instance()->set('username',   $this->auth->username);
		Session::instance()->set('realname',   $this->auth->realname);
		Session::instance()->set('agency_id',  $this->auth->agency_id);
		Session::instance()->set('school_id',  $this->auth->school_id);
		Session::instance()->set('grade_id',   $this->auth->grade_id);
		
		return true;
	}
	
	public function refresh_student_infor()
	{
		$user = DB::select('*')
			->from('guests')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $this->auth->user_id)
			->limit(1)
			->execute();
		if ( $user->count() == 0  ) {
			return false;
		}
		
		if ( $user->get('student_id') > 0 ) {
			$this->auth->user_id    = $user->get('id');
			$this->auth->status     = $user->get('status');
			$this->auth->wx_openid  = $user->get('wx_openid');
			Session::instance()->set('user_id',   $this->auth->user_id);
			Session::instance()->set('status',    $this->auth->status);
			Session::instance()->set('wx_openid', $this->auth->wx_openid);
			
			$this->change_login( $user->get('student_id'), false );
			
			return $this->auth->student_id;
			
		} elseif ( $user->get('status') == GUEST_STATUS_ENABLED ) {
			HTTP::redirect('/guest/valid/');
		}
		
		return false;
	}
	
	public function output(&$page)
	{
		$page->set('agency_appid', $this->agency->get('wx_appid'));
		$page->set('agency_name',  $this->agency->get('realname'));
		$page->set('agency_id',    $this->agency->get('id'));
		$page->set('uuid',         $this->agency->get('username'));
		$page->set('theme',        $this->agency->get('theme'));
		
		$items = DB::select('*')
			->from('footer')
			->where('agency_id', '=', $this->auth->agency_id)
			->execute();
		$content = $items->count() ? $items->get('content') : '';
		
		$page->html_footer_content = View::factory('footer')
			->set('content', $content);
		
		$page->render();
		$this->response->body($page);
	}
	
	public function entities() 
	{
		$entities = array();
		
		$items = DB::select('id', 'name')
			->from('entities')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('status', '=', STATUS_NORMAL)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$entities[$v['id']] = $v;
		}
		
		if ( count($entities) == 0 ) {
			$entities[] = array('id' => 0, 'name' => '总部');
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
	
	public function students()
	{
		$students = array();
		
		$items = DB::select('students.id', 'students.realname')
			->from('wx_students')
			->join('students')
			->on('wx_students.student_id', '=', 'students.id')
			->where('students.agency_id', '=', $this->auth->agency_id)
			->where('wx_students.wx_openid', '=', $this->auth->wx_openid)
			->execute()
			->as_array();
		foreach ( $items as $v ) {
			$students[$v['id']] = $v;
		}
		
		return $students;
	}
}
