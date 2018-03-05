<?php
namespace Home\Controller;
use Think\Controller;
class CourseController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	//课表
	public function index(){
		$this->display();
	}
	//课表安排
	public function arrange(){
		$this->display();
	}
	//添加课时
	public function add_classhour(){
		$this->display();
	}
	//转课
	public function turn_course(){
		$this->display();
	}
	//续课
	public function continue_course(){
		$this->display();
	}
}
