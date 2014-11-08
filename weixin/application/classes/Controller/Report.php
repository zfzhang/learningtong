<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Report extends Controller_Base {
	
	public function action_index()
	{
		$entity = intval($this->request->query('entity'));
		$school = intval($this->request->query('school'));
		$grade  = intval($this->request->query('grade'));
		$class  = intval($this->request->query('class'));
		$date   = intval($this->request->query('date'));
		
		try {
			$expr = DB::expr('COUNT(0)');
			$queryCount = DB::select($expr)
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.student_id', '=', $this->auth->student_id)
				->where('reports.status', '=', STATUS_ENABLED);
			$queryItems = DB::select('*')
				->from('reports')
				->join('students')
				->on('reports.student_id', '=', 'students.id')
				->where('reports.agency_id', '=', $this->auth->agency_id)
				->where('reports.student_id', '=', $this->auth->student_id)
				->where('reports.status', '=', STATUS_ENABLED);
			
			if ( $school ) {
				$queryCount->where('students.school_id', '=', $school);
				$queryItems->where('students.school_id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('students.grade_id', '=', $grade);
				$queryItems->where('students.grade_id',  '=', $grade);
			}
			if ( $class ) {
				$queryCount->where('students_courses.course_id', '=', $class);
				$queryItems->where('students_courses.course_id',  '=', $class);
			}
			
			$count = $queryCount->execute();
			$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
			
			$items = $queryItems->order_by('reports.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			if ( $this->request->is_ajax() ) {
				echo json_encode($items);exit;
			} else {
				$page = View::factory('report/list')
					->set('items', $items)
					->set('total', $total)
					->set('page',  $this->pagenav->page)
					->set('students', $this->students())
					->set('realname', $this->auth->realname)
					->set('self',     $this->auth->student_id);
				$this->output($page);
			}

		} catch (Database_Exception $e) {
			if ( $this->request->is_ajax() ) {
				echo json_encode(array());exit;
			} else {
				$this->response->body($e->getMessage());
			}
		}
	}
	
}
