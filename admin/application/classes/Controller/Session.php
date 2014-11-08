<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller_Base {
	
	protected function set_session(&$user)
	{
		$session = Session::instance();
		$session->set('user_id',   $user->get('id'));
		$session->set('role_id',   $user->get('role_id'));
		$session->set('username',  $user->get('username'));
		$session->set('realname',  $user->get('realname'));
		$session->set('nickname',  $user->get('nickname'));
		$session->set('add_t',     $user->get('add_t'));
		$session->set('modify_t',  $user->get('modify_t'));
	}
	
	public function action_index()
	{
		$page = View::factory('login');
		$this->output($page);
	}

	public function action_start()
	{
		$username = $this->request->post('username');
		$password = $this->request->post('password');
		
		if ( !$username or !$password ) {
		}
				
		try {
			$user = DB::select('*')
				->from('admins')
				->where('username', '=', $username)
				->where('password', '=', $password)
				->limit(1)
				->execute();
				
			if ( $user->count() ) {
				$this->set_session($user);
				$this->ajax_result['url'] = URL::base(NULL, TRUE).'agency/list/';
			} else {
				$this->ajax_result['ret'] = ERR_USER_PASS;
				$this->ajax_result['msg'] = 'username or password error!';
			}
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_SELECT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) ); 
	}
	
	public function action_end()
	{
		Session::instance()->destroy();
		HTTP::redirect('/session/index/');
	}

	public function action_pswd()
	{		
		if ( !$this->request->is_ajax() ) {
			$page = View::factory('pswd');
			$this->output($page, 'change_password');
				
			$this->response->body($page);	
			return;
		}
		
		$pswd1 = $this->request->post('pswd1');
		$pswd2 = $this->request->post('pswd2');
		if ( empty($pswd1) or $pswd1 != $pswd2 ) {
			$this->ajax_result['ret'] = ERR_NEW_PASSWORD;
			$this->ajax_result['msg'] = 'new password error!';
			$this->response->body( json_encode($this->ajax_result) );
			return;
		}
		
		try {
			$row = DB::update('admins')
				->set(array('password' => $pswd1))
				->where('id', '=', $this->auth->user_id)
				->execute();
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_UPDATE;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
}
