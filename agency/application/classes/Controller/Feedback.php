<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller_Base {
	
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
				->from('feedbacks')
				->join('students')
				->on('feedbacks.created_by', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('feedbacks.agency_id', '=', $this->auth->agency_id)
				->where('feedbacks.status', '=', STATUS_NORMAL);
			$queyrList  = DB::select('feedbacks.id','feedbacks.created_by','feedbacks.created_at','students.realname',array('schools.name', 'school'),array('grades.name', 'grade'))
				->from('feedbacks')
				->join('students')
				->on('feedbacks.created_by', '=', 'students.id')
				->join('schools', 'LEFT')
				->on('students.school_id', '=', 'schools.id')
				->join('grades', 'LEFT')
				->on('students.grade_id', '=', 'grades.id')
				->where('feedbacks.agency_id', '=', $this->auth->agency_id)
				->where('feedbacks.status', '=', STATUS_NORMAL);
			
			if ( $school ) {
				$queryCount->where('schools.id', '=', $school);
				$queyrList->where('schools.id',  '=', $school);
			}
			if ( $grade ) {
				$queryCount->where('grades.id', '=', $grade);
				$queyrList->where('grades.id',  '=', $grade);
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
					$queryCount->where('feedbacks.created_by', 'in', $students);
					$queryItems->where('feedbacks.created_by', 'in', $students);
				} else {
					$queryCount->where('feedbacks.created_by', '=', 0);
					$queryItems->where('feedbacks.created_by', '=', 0);
				}
			}
			if ( $realname ) {
				$queryCount->where('students.realname', '=', $realname);
				$queyrList->where('students.realname',  '=', $realname);
			}
			
			$count = $queryCount->execute();
			$total = $count->count() ? $count[0]['COUNT(0)'] : 0;
			
			$items = $queyrList->order_by('feedbacks.id', 'DESC')
				->offset($this->pagenav->offset)
				->limit($this->pagenav->size)
				->execute()
				->as_array();
			
			$page = View::factory('feedback/list')
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
			$this->output($page, 'feedback' );
			
		} catch (Database_Exception $e) {
			$this->response->body($e->getMessage());
		}
	}
	
	public function action_reply()
	{
		$id = $this->request->query('id');
					
		$items = DB::select('feedbacks.*', array('students.realname', 'student'), array('students.id', 'student_id'))
			->from('feedbacks')
			->where('feedbacks.agency_id', '=', $this->auth->agency_id)
			->join('students')
			->on('feedbacks.created_by', '=', 'students.id')
			->where('feedbacks.id', '=', $id)
			->execute()
			->as_array();
		if ( !count($items) ) {
			HTTP::redirect('/feedback/list/');
		}
		
		$reply_list = DB::select('feedback_reply.id','feedback_reply.created_at','feedback_reply.content',array('users.realname', 'teacher'),array('students.realname','student'))
			->from('feedback_reply')
			->join('students')
			->on('feedback_reply.student_id', '=', 'students.id')
			->join('users')
			->on('feedback_reply.created_by', '=', 'users.id')
			->where('users.agency_id', '=', $this->auth->agency_id)
			->where('feedback_id', '=', $id)
			->execute()
			->as_array();
		
		$page = View::factory('feedback/reply')
			->set('item', $items[0])
			->set('reply_list', $reply_list);
			
		$this->output($page, 'feedback' );
	}
		
	public function action_save()
	{
		$feedback_id = intval($this->request->post('feedback_id'));
		
		$data = array();
		$data['feedback_id'] = $feedback_id;
		$data['student_id']  = intval($this->request->post('student_id'));
		$data['created_at']  = date('Y-m-d H:i:s');
		$data['created_by']  = $this->auth->user_id;
		$data['content']     = $this->request->post('content');
		
		try {
			DB::insert('feedback_reply', array_keys($data))
				->values($data)
				->execute();
			DB::update('feedbacks')
				->set(array('reply' => 1, 'modified_by' => $this->auth->user_id))
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id', '=', $feedback_id)
				->execute();			
			HTTP::redirect('/feedback/list/');
		} catch ( Database_Exception $e ) {
			$this->response->body( $e->getMessage() );
		}
	}
	
	public function action_del()
	{
		$id = intval($this->request->query('id'));
		
		try {
			DB::update('feedbacks')
				->set( array('status'=>STATUS_DELETED, 'modified_at'=>date('Y-m-d H:i:s')) )
				->where('agency_id', '=', $this->auth->agency_id)
				->where('id','=',$id)
				->execute();
			HTTP::redirect('/feedback/list/');
		} catch (Database_Exception $e) {
			$this->response->body( $e->getMessage() );
		}
	}
	
}
