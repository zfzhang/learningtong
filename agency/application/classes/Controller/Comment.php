<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Base {
	
	public function action_list()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$realname = strval($this->request->query('realname'));

		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('comments')
				->join('students')
				->on('comments.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('comments.agency_id', '=', $this->auth->agency_id)
				->where('comments.status', '=', STATUS_NORMAL);
			$queryItems  = DB::select('comments.id','comments.student_id','comments.created_at','students.realname',array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('comments')
				->join('students')
				->on('comments.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('comments.agency_id', '=', $this->auth->agency_id)
				->where('comments.status', '=', STATUS_NORMAL);
			
			if ( $school ) {
				$queryCount->where('schools.id', '=', $school);
				$queryItems->where('schools.id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('grades.id', '=', $grade);
				$queryItems->where('grades.id',  '=', $grade);
			}
			if ( $class ) {
				$items = DB::select('student_id')
					->from('students_courses')
					->where('course_id', '=', $class)
					->execute()
					->as_array();
				$students = array();//echo '<pre>';print_r($students);echo '</pre>';exit;
				foreach ($items as $v) {
					$students[] = $v['student_id'];
				}
				if ( $students ) {
					$queryCount->where('comments.student_id', 'in', $students);
					$queryItems->where('comments.student_id', 'in', $students);
				} else {
					$queryCount->where('comments.student_id', '=', 0);
					$queryItems->where('comments.student_id', '=', 0);
				}
			}
			if ( $realname ) {
				$queryCount->where('students.realname', 'like', '%'.$realname.'%');
				$queryItems->where('students.realname', 'like', '%'.$realname.'%');
			}
			
			$count = $queryCount->execute();
			$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
			
			$items = $queryItems->order_by('comments.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('comment/list')
				->set('items',   $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('classes',  $this->classes())
				->set('student_classes', $this->get_student_courses($items));
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'comment' );
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('comment/add');				
		$this->output($page, 'comment');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('comments.*', array('students.realname', 'student'), array('users.realname', 'teacher'))
			->from('comments')
			->join('students')
			->on('comments.student_id', '=', 'students.id')
			->join('users')
			->on('comments.created_by', '=', 'users.id')
			->where('comments.agency_id', '=', $this->auth->agency_id)
			->where('comments.id', '=', $id)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('/comment/list/');
		}
		
		$page = View::factory('comment/edit')
			->set('item', $items[0]);			
		$this->output($page, 'comment');
	}
		
	public function action_save()
	{
		$data = array();
		$data['student_id'] = intval($this->request->post('student_id'));
		$data['content']    = $this->request->post('content');
		
		$data['begin_str']  = $this->request->post('begin_str');
		$data['end_str']    = $this->request->post('end_str');
		
		$data['modified_by'] = $this->auth->user_id;
		$data['modified_at'] = date('Y-m-d H:i:s');
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('comments')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['agency_id']  = $this->auth->agency_id;
				$data['created_by'] = $this->auth->user_id;
				$data['created_at'] = date('Y-m-d H:i:s');
				list($id, $rows) = DB::insert('comments', array_keys($data))
					->values($data)
					->execute();
			}
			HTTP::redirect('/comment/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('comments')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>NULL) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/comment/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
