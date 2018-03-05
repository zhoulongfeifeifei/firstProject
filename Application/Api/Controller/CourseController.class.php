<?php
namespace Api\Controller;
use Think\Controller;
class CourseController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}


	/**
	*获取课表
	*/
	public function get_course_lists(){
		$result = array('status'=>0,'msg'=>'数据错误！',);
		$ag_id = I('post.ag_id',0,'intval');
		$teacher_id = I('post.teacher_id',0,'intval');
		$student_id = I('post.student_id',0,'intval');
		$select_time = I('post.select_time',0,'intval');

		//获取默认信息
		$res = $this->get_default_data();
		if(!empty($res['agency_lists'])){
			$result['status'] =1;
			switch($res['user_type']){
				case 1: 
					$ag_id = $ag_id ? $ag_id : $res['ag_id'];
					$teacher_id = $teacher_id ? $teacher_id : $res['teacher_id'];
					$student_id = $res['student_id'];
					break;
				case 2:
				case 4;
				default:
					$ag_id = $ag_id ? $ag_id : $res['ag_id'];
					$teacher_id = $teacher_id ? $teacher_id : $res['teacher_id'];
					$student_id = $student_id ? $student_id : $res['student_id'];
					break;
				case 3:
					$ag_id = $ag_id ? $ag_id : $res['ag_id'];
					$student_id = $student_id ? $student_id : $res['student_id'];
					$teacher_id = $res['teacher_id'];
					break;
			}
		}
	
		$timeArr = array();
		$course_lists = array();
		for($i=0;$i<17;$i++){
			$arr[]=array();
		}

		$course_lists[]=$arr;
		$course_lists[]=$arr;
		$timeArr = array(
			'08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','17:00','18:00','19:00','20:00','21:00','22:00'
		);
		if($ag_id && $teacher_id){

			//获取老师对应课程
			$TimetableModel = D('timetable');
			$condition = array('ag_id'=>$ag_id,'teacher_id'=>$teacher_id,);
			$teacher_timetable = $TimetableModel->get_timetable_info($condition);
			$course_id = !empty($teacher_timetable) ? $teacher_timetable['course_id'] : 0;

			//获取课程id
			$CourseModel = D('course');
			$course = $CourseModel->get_course_info(array('id'=>$course_id));
			$course_id = !empty($course) ? $course['fid'] : 0;

			if($course_id>0){
				
				//获取机构信息
				$AgencyModel = D('agency');
				$agency = $AgencyModel->get_agency_info(array('id'=>$ag_id));
				$open_time = $agency['start_time']/3600;
				$close_time = $agency['end_time']/3600;
				$all_time = $close_time-$open_time;

				//获取时间范围
				$AgencyCourseModel = D('agencyCourse');
				$agency_course = $AgencyCourseModel->get_agency_course_info(array('ag_id'=>$ag_id,'course_id'=>$course_id));
				$per_time = $agency_course['course_time'] + $agency_course['rest_time'];

				$cnt = intval(($all_time*60)/$per_time);

				$agency_start_time = $agency['start_time'];
				$agency_end_time = $agency['end_time'];
				$course_time = $per_time*60;

				$today = strtotime(date('Y-m-d 00:00:00',time()));

				if($cnt>1){
					$timeArr = array();
					for($i=0;$i<$cnt;$i++){
						$time = $i*$course_time+$agency_start_time+$today;
						$timeArr[]= date('H:i',$time);
					}

					//选择时间
					$select_time = $select_time ? strtotime(date('Y-m-d',strtotime($select_time))) : strtotime(date('Y-m-d'));

					$condition = array(
						'ag_id'=>$ag_id,
						'teacher_id'=>$teacher_id,
						'start_time'=>array('gt',$select_time),
						'end_time'=>array('lt',$select_time+24*3600),
						'status'=>1,
					);
					if($student_id){
						$condition['student_id'] = $student_id;
					}
					
					$timetable = $TimetableModel->get_timetable_lists_info($condition);
			
					$course_lists = array();
					$tmp1 = array();
					$tmp2 = array();
					foreach($timeArr as $k=>$t){
						$no = $k+1;
						if(!empty($timetable)){
							foreach($timetable as $value){
								$room_no = explode('-', $value['room_no']);
								
								if($room_no[1]==$no && $value['start_time']<$select_time+24*3600){
									//获取此时段基本信息
									$where = array(
										'start_time'=>$value['start_time'],
										'course_id'=>$value['course_id'],
										'teacher_id'=>$value['teacher_id'],
										'status'=>1,
									);
									$detail = $TimetableModel->get_timetable_lists($where);
									$tempArr = array(
										'ag_id'=>$value['ag_id'],
										'teacher_id'=>$value['teacher_id'],
										'course_id'=>$value['course_id'],
										'teacher_name'=>$value['teacher_name'],
										'agency_name'=>$value['agency_name'],
										'course_name'=>$value['course_name'],
										'room_no'=>$value['room_no'],
										'detail'=>$detail,
									);
									$tmp1[] = $tempArr;
								}else{
									$tmp1[] = array();
								}
								if($room_no[1]==$no && $value['start_time']<$select_time+2*24*3600 && $value['start_time']> $select_time+24*3600){
									//获取此时段基本信息
									$where = array(
										'start_time'=>$value['start_time'],
										'course_id'=>$value['course_id'],
										'teacher_id'=>$value['teacher_id'],
										'status'=>1,
									);
									$detail = $TimetableModel->get_timetable_lists($where);
									$tempArr = array(
										'ag_id'=>$value['ag_id'],
										'teacher_id'=>$value['teacher_id'],
										'course_id'=>$value['course_id'],
										'teacher_name'=>$value['teacher_name'],
										'agency_name'=>$value['agency_name'],
										'course_name'=>$value['course_name'],
										'room_no'=>$value['room_no'],
										'detail'=>$detail,
									);
									$tmp2[] = $tempArr;
								}else{
									$tmp2[] = array();
								}
							}
						}else{
							$tmp1[] = array();
							$tmp2[] = array();
						}
					}

					$course_lists[] = $tmp1;	
					$course_lists[]= $tmp2;
				}
			}
		}
		$weekArr = array('周一','周二','周三','周四','周五','周六','周日');
		$week = $weekArr[date('N',$select_time)-1];
		$week2 = $weekArr[date('N',$select_time+24*3600)-1];
		$result['time_line'] = $timeArr;
		$result['select_time'] = array(
			$week.'  '.date('m/d',$select_time),
			$week2.'  '.date('m/d',$select_time+24*3600),
		);
		$result['course_lists'] = $course_lists;
		$result['relate_data'] = $res['agency_lists'];
		die(json_encode($result));

	}

	/**
	*获取默认信息     课表
	*/

	public function get_default_data(){
		$user_info = $this->check_authentification();

		//默认列表
		$agency_lists = array();
		$teacher_lists = array();
		$student_lists = array();
		$student_id = 0;
		$teacher_id = 0;
		$ag_id = 0;

		$AgencyUsersModel = D('agencyUsers');
		$AgencyModel = D('agency');
		$UsersModel = D('users');
		$TimetableModel = D('timetable');

		$agArr = $AgencyUsersModel->get_agency_users_lists(array('user_id'=>$user_info['id'],'status'=>1));
		
		$agids = array();
		foreach($agArr as $v){
			$agids[]=$v['ag_id'];
		}
		$agids = implode(',', $agids);
		//获取用户下的机构信息
		$field = 'id,name';
		$agency_lists = $AgencyModel->get_agency_lists(array('id'=>array('in',$agids),'status'=>1),$field);
		$ag_id = !empty($agency_lists[0]) ? $agency_lists[0]['id'] : 0;

		$teacherArr = array();
		$studentArr = array();
		switch($user_info['type']){
			case 1://学生
				$student_id = $user_info['id'];

				foreach($agency_lists as &$value){
					$where = array(
						'ag_id'=>$value['id'],
						'student_id'=>$student_id,
						'status'=>1,
					);
					$group = 'teacher_id';
					$order = 'student_id  DESC';
					$timetable = $TimetableModel->get_timetable_lists_info($where,0,100,$group,$order);
				
					foreach($timetable as $k=>$v){
						if($k==0){
							$teacher_id = $v['teacher_id'];
						}
						//获取老师信息
						$field = 'id,name';
						$teacher_info = $UsersModel->get_users_info(array('id'=>$v['teacher_id'],'status'=>1),$field);
						$teacherArr[] = $teacher_info;
					}
					$studentArr[] =array(
						'id'=>$user_info['id'],
						'name'=>$user_info['name'],
					);
					$value['teacher_lists'] = $teacherArr;
					$value['student_lists'] = $studentArr;
				}
				break;
			case 2:
			case 4:
				$result = $this->get_agency_all_users($agency_lists);
				$agency_lists = $result['agency_lists'];
				$teacher_id = $agency_lists['teacher_id'];
				$student_id = $agency_lists['student_id'];
				break;
			case 3:
				$teacher_id = $user_info['id'];

				foreach($agency_lists as &$value){
					//获取课表中老师信息
					$where = array(
						'ag_id'=>$value['id'],
						'teacher_id'=>$teacher_id,
						'status'=>1,
					);
					$group = 'student_id';
					$timetable = $TimetableModel->get_timetable_lists_info($where,0,100,$group);
					foreach($timetable as $k=>$v){
						if($k==0){
							$student_id = $v['student_id'];
						}
						//获取老师信息
						$field = 'id,name';
						$student_info = $UsersModel->get_users_info(array('id'=>$v['user_id'],'status'=>1),$field);
						$studentArr[] = $student_info;
					}
					$teacherArr[] = array(
						'id'=>$user_info['id'],
						'name'=>$user_info['name'],
					);
					$value['teacher_lists'] = $teacherArr;
					$value['student_lists'] = $studentArr;
				}
				break;
			default:
				break;
		}
		return array('agency_lists'=>$agency_lists,'user_type'=>$user_info['type'],'ag_id'=>$ag_id,'teacher_id'=>$teacher_id,'student_id'=>$student_id);
	}


	/**
	*获取机构下所有用户信息
	*/

	public function get_agency_all_users($agency_lists){
		$AgencyUsersModel = D('agencyUsers');
		$UsersModel = D('users');
		$teacher_id = 0;
		$student_id = 0;
		//获取用户下的老师信息
		foreach($agency_lists as &$value){
			$agUsers = $AgencyUsersModel->get_agency_users_lists(array('ag_id'=>$value['id'],'status'=>1));
			$userArr = array();
			foreach($agUsers as $n){
				$userArr[] = $n['user_id'];
			}
			$userids = implode(',', $userArr);
			//获取用户信息
			$where = array(
				'id'=>array('in',$userids),
				'status'=>1,
			);
			$users_lists = $UsersModel->get_users_lists($where);
			$teacherArr = array();
			$studentArr = array();
			foreach($users_lists as $u){
				if($u['type']==3){
					$teacherArr[] = $u;
				}else if($u['type']==1){
					$studentArr[]= $u;
				}
			}
			$teacher_id = !empty($teacherArr[0]) ? $teacherArr[0]['id'] : 0;
			$student_id = !empty($studentArr[0]) ? $studentArr[0]['id'] : 0;
			$value['teacher_lists'] = $teacherArr;
			$value['student_lists'] = $studentArr;
		}
		$result = array(
			'teacher_id'=>$teacher_id,
			'student_id'=>$student_id,
			'agency_lists'=>$agency_lists,
		);
		return $result;
	}

	/**
	*获取机构课程列表
	*/
	public function get_agency_course(){
		$arr = array(2,4);
		$ag_id = I('post.ag_id',0,'intval');
		$result = array('status'=>0,'msg'=>'系统错误！');
		//检查认证
		$user_info = $this->check_authentification();
		if(!in_array($user_info['type'],$arr)){
			$result['status'] =2;
			$result['msg'] = '无权限操作！';
		}else{
			$AgencyModel = D('agency');
			$CourseModel = D('course');
			$agency = $AgencyModel->get_agency_info(array('id'=>$ag_id));
			if($agency){
				$course_lists = array();
				$AgencyCourseModel = D('agencyCourse');
				$condition = array(
					'ag_id'=>$ag_id,
					'status'=>1,
				);
				$agency_course = $AgencyCourseModel->get_agency_course_lists($condition);
				
				foreach($agency_course as $value){
					$info = $CourseModel->get_course_info(array('id'=>$value['course_id']));
					$course = $CourseModel->get_course_lists(array('fid'=>$value['course_id'],'status'=>1));
					$info['child'] = $course;
					$course_lists[] = $info;
				}
				$result['status'] =1;
				$result['course_lists'] = $course_lists;
			}
		}
		die(json_encode($result));
	}
}
