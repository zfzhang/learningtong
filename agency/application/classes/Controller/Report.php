<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Report extends Controller_Base {
	
	public function action_list()
	{
		$realname = strval($this->request->query('realname'));
		
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		
		try {		
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->join('entities', 'LEFT')
				->on('students.entity_id', '=', 'entities.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id',  '=', 'grades.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.status', '>', STATUS_DELETED);
			$queyrItems  = DB::select('reports.id','reports.status','reports.modified_at','students.realname',array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->join('entities', 'LEFT')
				->on('students.entity_id', '=', 'entities.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id',  '=', 'grades.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.status',    '>', STATUS_DELETED);
			
			if ( $realname ) {
				$queryCount->where('students.realname', 'like', '%'.$realname.'%');
				$queyrItems->where('students.realname', 'like', '%'.$realname.'%');
			}
			if ( $entity ) {
				$queryCount->where('students.entity_id', '=', $entity);
				$queyrItems->where('students.entity_id', '=', $entity);
			}
			if ( $school ) {
				$queryCount->where('students.school_id', '=', $school);
				$queyrItems->where('students.school_id', '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('students.grade_id', '=', $grade);
				$queyrItems->where('students.grade_id', '=', $grade);
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
					$queyrItems->where('students.id', 'in', $students);
				} else {
					$queryCount->where('students.id', '=', 0);
					$queyrItems->where('students.id', '=', 0);
				}
			}
			
			$cnt   = $queryCount->execute();
			$total = $cnt->count() ? $cnt[0]['COUNT(0)'] : 0;
			
			$items = $queyrItems->order_by('reports.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('report/list')
				->set('items',   $items)
				->set('entities', $this->entities())
				->set('schools',  $this->schools())
				->set('grades',   $this->grades())
				->set('courses',  $this->courses())
				->set('student_classes', $this->get_student_courses($items));
			$page->html_pagenav_content = View::factory('pagenav')
				->set('total', $total)
				->set('page',  $this->pagenav->page)
				->set('size',  $this->pagenav->size);
			$this->output($page, 'report');
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_add()
	{
		$page = View::factory('report/add')
			->set('schools', $this->schools())
			->set('grades',  $this->grades())
			->set('courses', $this->courses());
			
		$this->output($page, 'report');
	}
	
	public function action_edit()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('*')
			->from('reports')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $id)
			->execute()
			->as_array();
		if ( empty($items) ) {
			HTTP::redirect('/report/list/');
		}
		
		$students = DB::select('id', 'realname')
			->from('students')
			->where('agency_id', '=', $this->auth->agency_id)
			->where('id', '=', $items[0]['student_id'])
			->execute()
			->as_array();
		if ( empty($students) ) {
			HTTP::redirect('/report/list/');
		}
		
		$page = View::factory('report/edit')
			->set('item',     $items[0])
			->set('student',  $students[0])
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('courses',  $this->courses());
			
		$this->output($page, 'report');
	}
	
	public function action_save()
	{
		$data = array();
		$data['student_id']  = intval($this->request->post('student_id'));
		$data['begin_str']   = Arr::get($_POST, 'begin_str', '');
		$data['end_str']     = Arr::get($_POST, 'end_str', '');
		$data['content']     = Arr::get($_POST, 'content', '');
		$data['modified_at'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->auth->user_id;
		
		$data['status'] = STATUS_NORMAL;
		
		$id = intval($this->request->post('id'));
		try {
			if ( $id ) {
				DB::update('reports')
					->set($data)
					->where('agency_id', '=', $this->auth->agency_id)
					->where('id', '=', $id)
					->execute();
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->auth->user_id;
				$data['agency_id']  = $this->auth->agency_id;
			
				DB::insert('reports', array_keys($data))
					->values($data)
					->execute();
			}
			
			HTTP::redirect('/report/list/');
			
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}		
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
				
		try {
			$rows = DB::update('reports')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/report/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_publish()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('reports')
				->set( array('status'=>STATUS_ENABLED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/report/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_cancel()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('reports')
				->set( array('status'=>STATUS_NORMAL, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/report/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
