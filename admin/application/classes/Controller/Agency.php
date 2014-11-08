<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Agency extends Controller_Base {
	
	public function action_list()
	{
		$expr = DB::expr('COUNT(0)');
		$count = DB::select($expr)
			->from('agencies')
			->execute();
		
		$items = DB::select('*')
			->from('agencies')
			->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
			
		$page = View::factory('agency/list')
			->set('agency_types', $this->agency_types())
			->set('pay_types',    $this->pay_types())
			->set('client_types', $this->client_types())
			->set('service_days', $this->service_days())
			->set('items', $items);
		$page->html_pagenav_content = View::factory('pagenav')
			->set('total', $count->get('COUNT(0)'))
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size);
		$this->output($page, 'agencies');
	}
	
	public function action_add()
	{
		$page = View::factory('agency/add')
			->set('agency_types', $this->agency_types())
			->set('pay_types',    $this->pay_types())
			->set('client_types', $this->client_types())
			->set('service_days', $this->service_days());
		$this->output($page, 'add_agency');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('agencies')
			->where('id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		
		if ( count($items) == 0 ) {
			HTTP::redirect('/agency/list/');
		}
	
		$page = View::factory('agency/edit')
			->set('item',         $items[0])
			->set('agency_types', $this->agency_types())
			->set('pay_types',    $this->pay_types())
			->set('client_types', $this->client_types())
			->set('service_days', $this->service_days());
		$this->output($page, 'agencies');			
	}
	
	public function action_save()
	{
		$data = array();
		
		$data['realname']   = $this->request->post('realname');
		$data['viewname']   = $this->request->post('viewname');
		$data['username']   = $this->request->post('username');
		$data['weixin']     = $this->request->post('weixin');
		$data['weixin_id']  = $this->request->post('weixin_id');
		$data['wx_appid']   = $this->request->post('wx_appid');
		$data['wx_secret']  = $this->request->post('wx_secret');
		$data['remark']     = $this->request->post('remark');
		$data['addr']       = $this->request->post('addr');
		$data['mobile']     = $this->request->post('mobile');
		$data['contact']    = $this->request->post('contact');
		$data['email']      = $this->request->post('email');
		$data['remark']     = $this->request->post('remark');
		$data['care_num']   = intval($this->request->post('care_number'));
		$data['entity_num'] = intval($this->request->post('entity_num'));
		$data['student_num'] = intval($this->request->post('student_num'));
		$data['sms_tpl_id'] = intval($this->request->post('sms_tpl_id'));
		$data['status']     = intval($this->request->post('status'));
		$data['agency_type_id'] = intval($this->request->post('agency_type_id'));
		$data['client_type_id'] = intval($this->request->post('client_type_id'));
		$data['pay_type_id']    = intval($this->request->post('pay_type_id'));
		$data['service_days']   = intval($this->request->post('service_days'));
		$data['province']   = intval($this->request->post('province'));
		$data['city']       = intval($this->request->post('city'));
		$data['area']       = intval($this->request->post('area'));
		
		$data['modified_at']  = date('Y-m-d H:i:s');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				$items = DB::select('id')
					->from('agencies')
					->where('username',  '=', $data['username'])
					->where('id', '<>', $id)
					->limit(1)
					->execute();
				if ( $items->count() ) {
					HTTP::redirect('/agency/edit/?id='.$id);
				}
				DB::update('agencies')
					->set($data)
					->where('id', '=', $id)
					->execute();
			} else {
				$items = DB::select('id')
					->from('agencies')
					->where('username',  '=', $data['username'])
					->limit(1)
					->execute();
				if ( $items->count() ) {
					HTTP::redirect('/agency/add/');
				}
				
				if ( isset($_POST['created_at']) ) {
					$data['created_at']  = Arr::get($_POST, 'created_at');
				} else {
					$data['created_at']  = date('Y-m-d H:i:s');
				}
				list($id, $rows) = DB::insert('agencies', array_keys($data))
					->values($data)
					->execute();
			
				$user = array();
				$user['agency_id']  = $id;
				$user['username']   = 'admin';
				$user['password']   = md5($data['mobile']);
				$user['email']      = $data['email'];
				$user['weixin']     = $data['weixin_id'];
				$user['nickname']   = $data['realname'];
				$user['created_at'] = date('Y-m-d H:i:s');
				$user['role_id']    = AGENCY_ADMIN;
				
				DB::insert('users', array_keys($user))
					->values($user)
					->execute();
			}
			
			HTTP::redirect('/agency/list/');
			
		} catch (Database_Exception $e) {
			$this->ajax_result['ret'] = ERR_DB_INSERT;
			$this->ajax_result['msg'] = $e->getMessage();
		}
		
		$this->response->body( json_encode($this->ajax_result) );
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		try {
			DB::update('agencies')
				->set(array('status' => STATUS_DELETED, 'modified_at' => NULL))
				->where('id','=', $id)
				->execute();
			HTTP::redirect('/agency/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_disable()
	{
		$id = intval($this->request->query('id'));
		try {
			DB::update('agencies')
				->set(array('status' => STATUS_DISABLED, 'modified_at' => NULL))
				->where('id','=', $id)
				->execute();
			HTTP::redirect('/agency/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_enable()
	{
		$id = intval($this->request->query('id'));
		try {
			DB::update('agencies')
				->set(array('status' => STATUS_ENABLED, 'modified_at' => NULL))
				->where('id','=', $id)
				->execute();
			HTTP::redirect('/agency/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
}
