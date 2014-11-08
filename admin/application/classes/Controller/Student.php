<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller_Base {
	
	public function action_list()
	{	
		$agency   = intval($this->request->query('agency'));
		$entity   = intval($this->request->query('entity'));
		$school   = intval($this->request->query('school'));
		$grade    = intval($this->request->query('grade'));
		$class    = intval($this->request->query('class'));
		$sex      = intval($this->request->query('sex'));
		$realname      = Arr::get($_GET, 'realname', '');
		$mobile        = Arr::get($_GET, 'mobile', '');
		$father_name   = Arr::get($_GET, 'father_name', '');
		$father_mobile = Arr::get($_GET, 'father_mobile', '');
		$mother_name   = Arr::get($_GET, 'mother_name', '');
		$mother_mobile = Arr::get($_GET, 'mother_mobile', '');

		$expr = DB::expr('COUNT(0)');
		$queryCount = DB::select($expr)
			->from('students')
			->join('schools', 'LEFT')
			->on('students.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('students.grade_id', '=', 'grades.id');
		
		$queryItems = DB::select('students.*',array('schools.name', 'school'),array('grades.name','grade'))
			->from('students')
			->join('schools', 'LEFT')
			->on('students.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('students.grade_id', '=', 'grades.id');
		
		if ( $agency ) {
			$queryCount->where('students.agency_id', '=', $agency);
			$queryItems->where('students.agency_id', '=', $agency);
		}
		if ( $entity ) {
			$queryItems->where('students.entity_id', '=', $entity);
			$queryCount->where('students.entity_id', '=', $entity);
		}
		if ( $school ) {
			$queryItems->where('students.school_id', '=', $school);
			$queryCount->where('students.school_id', '=', $school);
		}
		if ( $grade ) {
			$queryItems->where('students.grade_id', '=', $grade);
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
			$queryItems->where('students.realname', '=', $realname);
			$queryCount->where('students.realname', '=', $realname);
		}
		if ( $sex ) {
			$queryItems->where('students.sex', '=', $sex);
			$queryCount->where('students.sex', '=', $sex);
		}
		if ( $mobile ) {
			$queryItems->where('students.mobile', '=', $mobile);
			$queryCount->where('students.mobile', '=', $mobile);
		}
		if ( $father_name ) {
			$queryItems->where('students.father_name', '=', $father_name);
			$queryCount->where('students.father_name', '=', $father_name);
		}
		if ( $father_mobile ) {
			$queryItems->where('students.father_mobile', '=', $father_mobile);
			$queryCount->where('students.father_mobile', '=', $father_mobile);
		}
		if ( $mother_name ) {
			$queryItems->where('students.mother_name', '=', $mother_name);
			$queryCount->where('students.mother_name', '=', $mother_name);
		}
		if ( $mother_mobile ) {
			$queryItems->where('students.mother_mobile', '=', $mother_mobile);
			$queryCount->where('students.mother_mobile', '=', $mother_mobile);
		}
		
		$count = $queryCount->execute();			
		$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
		
		$items = $queryItems->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();	
		
		$page = View::factory('student/list')
			->set('items', $items)
			->set('total', $total)
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size)
			->set('agencies', $this->agencies())
			->set('schools',  $this->schools())
			->set('grades',   $this->grades())
			->set('student_classes', $this->get_student_courses($items));
		$page->html_pagenav_content = View::factory('pagenav')
			->set('total', $count->get('COUNT(0)'))
			->set('page',  $this->pagenav->page)
			->set('size',  $this->pagenav->size);
		
		$this->output($page, 'students');
	}
	
	public function action_detail()
	{
		$id = intval($this->request->query('id'));
		
		$items = DB::select('students.*',array('schools.name', 'school'),array('grades.name','grade'))
			->from('students')
			->join('schools', 'LEFT')
			->on('students.school_id', '=', 'schools.id')
			->join('grades', 'LEFT')
			->on('students.grade_id', '=', 'grades.id')
			->where('students.id', '=', $id)
			->limit(1)
			->execute()
			->as_array();
		if ( count($items) == 0 ) {
			HTTP::redirect('/student/list/');
		}
		
		$agencies = DB::select('realname', 'addr')
			->from('agencies')
			->where('id', '=', 'students.agency_id')
			->limit(1)
			->execute();
		$items[0]['agency_name'] = $agencies->get('realname');
		$items[0]['agency_addr'] = $agencies->get('addr');
		
		$student_courses = DB::select(array('classes.name', 'class'), array('courses.name', 'course'))
			->from('students_courses')
			->join('courses')
			->on('students_courses.course_id', '=', 'courses.id')
			->join('classes')
			->on('courses.class_id', '=', 'classes.id')
			->where('students_courses.student_id', '=', $items[0]['id'])
			->execute()
			->as_array();
		$arr = array();
		foreach ($student_courses as $v) {
			$arr[] = $v['class'] . '-' . $v['course'];
		}
		$items[0]['courses'] = implode('<br/>', $arr);
			
		$page = View::factory('student/detail')
			->set('item', $items[0]);
		$this->output($page, 'students');
	}
	
	public function action_search()
	{
		$agency_id = intval( $this->request->post('agency') );
		$entity_id = intval( $this->request->post('entity') );
		$school_id = intval( $this->request->post('school') );
		$grade_id  = intval( $this->request->post('grade') );
		$class_id  = intval( $this->request->post('class') );
		$realname  = Arr::get($_GET, 'realname', '');
		
		$queryItems = DB::select('id', 'realname', 'birthday')
			->from('students')
			->where('agency_id', '=', $this->agency_id);
		if ( $agency_id ) {
			$queryItems->where('agency_id', '=', $agency_id);
		}
		if ( $entity_id ) {
			$queryItems->where('entity_id', '=', $entity_id);
		}
		if ( $school_id ) {
			$queryItems->where('school_id', '=', $school_id);
		}
		if ( $grade_id ) {
			$queryItems->where('grade_id',  '=', $grade_id);
		}
		if ( $class_id ) {
			$queryItems->where('class_id',  '=', $class_id);
		}
		if ( $realname ) {
			$queryItems->where('realname',  '=', $realname);
		}
		
		$items = $queryItems->offset($this->pagenav->offset)
			->limit($this->pagenav->size)
			->execute()
			->as_array();
		$this->response->body( json_encode($items) );
	}
	
}
