<?php
namespace Home\Controller;
use Think\Controller;
class UsersController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	public function index(){
		//$this->display();
	}

	//老师列表
	public function teacher_lists(){
		$this->display();
	}

	//添加老师
	public function add_teacher(){
		$this->display();
	}
	//点名
	public function roll_call(){
		$this->display();
	}

	//请假
	public function askLeave(){
		$this->display();
	}
	//科目请假
	public function single_leave(){
		$this->display();
	}
	//调课
	public function adjust_course(){
		$this->display();
	}
	//签到
	public function sign_in(){
		$this->display();
	}
	//月报
	public function month_report(){
		$this->display();
	}
	//待审批
	public function wait_approval(){
		$this->display();
	}
	//请假详情
	public function leave_detail(){
		$this->display();
	}
}
