<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Works extends Controller_Base {
	
	public function action_index() 
	{
		try {
			$images = DB::select('id','img','title')
				->from('works')
				->where('agency_id', '=', $this->auth->agency_id)
				->where('status',    '=', STATUS_ENABLED)
				->where('show_type', '=', STATUS_ENABLED)
				->offset(0)
				->limit(4)
				->order_by('id', 'DESC')
				->execute()
				->as_array();
				
			$items = DB::select('works.*',array('students.realname', 'student'),array('students.id', 'student_id'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->where('works.agency_id', '=', $this->auth->agency_id)
				->where('works.status', '=', STATUS_ENABLED)
				->order_by('works.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$ids = array();
			$students_courses = array();
			foreach ( $items as $v ) {
				$ids[] = $v['student_id'];
			}
			if ( $ids ) {
				$query = DB::select('courses.name', 'students_courses.student_id')
					->from('courses')
					->join('students_courses')
					->on('courses.id', '=', 'students_courses.course_id')
					->where('students_courses.student_id', 'in', $ids)
					->execute()
					->as_array();
				foreach ($query as $v) {
					$students_courses[$v['student_id']] = $v['name'];
				}
			}
			
			
			if ( $this->request->is_ajax() ) {
				echo json_encode($items);exit;
			} else {
				$page = View::factory('works/list')
					->set('items', $items)
					->set('students', $this->students())
					->set('students_courses', $students_courses)
					->set('page',  $this->pagenav->page)
					->set('images', $images);
			}
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
		
		try {
			$items = DB::select('works.*',array('students.realname', 'student'),array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('works')
				->join('students')
				->on('works.student_id', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades',  'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('works.agency_id', '=', $this->auth->agency_id)
				->where('works.id', '=',  $id)
				->limit(1)
				->execute()
				->as_array();
			if ( empty($items) ) {
				HTTP::redirect('works/list');
			}

			DB::update('works')
				->set( array( 'read_count' => $items[0]['read_count']+1 ) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $id)
				->execute();
			
			$page = View::factory('works/detail')
				->set('item', $items[0]);
			$this->output($page);
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
}
