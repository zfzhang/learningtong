<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Task extends Controller_Base {

	public function action_index()
	{		
		try {
			$offset = ($this->pagenav->page > 0) ? ($this->pagenav->page - 1) : 0;
			$items = DB::select('tasks.*',array('courses.name', 'class'))
				->from('tasks')
				->join('students_courses', 'LEFT')
				->on('tasks.course_id', '=', 'students_courses.course_id')
				->join('courses', 'LEFT')
				->on('students_courses.course_id', '=', 'courses.id')
				->where('students_courses.student_id', '=', $this->auth->student_id)
				->where('tasks.agency_id', '=', $this->auth->agency_id)
				->where('tasks.grade_id',  '=', $this->auth->grade_id)
				->where('tasks.status',    '=', STATUS_ENABLED)
				->order_by('tasks.id', 'DESC')
				->offset($offset)
				->limit(1)
				->execute();
			
			$items = $items->count() ? $items->as_array() : array(array('id'=>0, 'content'=>'', 'date_str'=>'', 'class'=>''));
			if ( empty($items[0]['content']) ) {
				$items[0]['content'] = '没有作业';
			}
			
			$schools = DB::select('schools.name')
				->from('schools')
				->join('students')
				->on('students.school_id', '=', 'schools.id')
				->where('schools.agency_id', '=', $this->auth->agency_id)
				->where('students.id', '=', $this->auth->student_id)
				->limit(1)
				->execute();
			$grades = DB::select('grades.name')
				->from('grades')
				->join('students')
				->on('students.grade_id', '=', 'grades.id')
				->where('grades.agency_id', '=', $this->auth->agency_id)
				->where('students.id', '=', $this->auth->student_id)
				->limit(1)
				->execute();
			
			$page = View::factory('task/index')
				->set('item', $items[0])
				->set('page', $this->pagenav->page)
				->set('students', $this->students())
				->set('school',   $schools->get('name'))
				->set('grade',    $grades->get('name'))
				->set('self',     $this->auth->student_id);
				
			$this->output($page);
				
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
}
