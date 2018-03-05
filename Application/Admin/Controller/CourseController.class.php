<?php
namespace Admin\Controller;
use Think\Controller;
class CourseController extends BaseController {
	
	protected $CourseModel ;
	public function __construct(){
		parent::__construct();
		$this->CourseModel = D('course');
	}
	
	/**
	* 课程列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('course_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$condition['name'] = array('like','%'.$name.'%');
		$cid = I('post.cid',0,'intval');
		if($cid==-1){
			$condition['fid'] = 0;
		}else if($cid>0){
			$condition['fid'] = $cid;
		}
		$total_rows = $this->CourseModel->get_course_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $this->CourseModel->get_course_lists($condition,$offset,$numPerPage,$order);
		
		foreach($lists as &$item){
			if($item['fid']==0){
				$item['fname'] = '一级课程';
			}else{
				$info = $this->CourseModel->get_course_info(array('id'=>$item['fid']));
				$item['fname'] = $info['name'];
			}
		}
		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加分类
	*/
	public function add_course(){
		//add_course
		if(!checkPermission('add_course')){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			$fid = I('post.fid',0,'intval');
			$img = I('post.img','','trim');
			if(!$name){
				$error = '请输入名称！';
			}
			if(!$img && $fid==0){
				$error = '请上传图片！';
			}
			if(!$fid){
				$error = '请选择上级课程！';
			}
			$fid = $fid==-1 ? 0 : $fid;
			$where = array(
				'name'=>$name,
			);
			$ckname = $this->CourseModel->get_course_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'fid'=>$fid,
					'name'=>$name,
					'create_time'=>time(),
					'status'=>$status,
				);
				if($img){
					$imgArr = $this->deal_upload_img(trim($img,'.'),'course');
					$data['img'] = $imgArr['img'].'.'.$imgArr['ext'];
				}

				if(!$this->CourseModel->add_course($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'course_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$lists = $this->CourseModel->get_course_lists('1=1',0,50);
			$lists = getCategoryLists($lists);
			$this->assign('lists',$lists);
			$this->display();
		}
	}

	/**
	*修改分类
	*/
	public function edit_course(){
		//检查权限
		if(!checkPermission('edit_course')){
			return ;
		}
		$id = I('get.id',0,'intval');
		//获取分类信息
		$info = $this->CourseModel->get_course_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			$fid = I('post.fid',0,'intval');
			$img = I('post.img','','trim');
			if(!$name){
				$error = '请输入名称！';
			}

			if(!$img && $fid==0){
				$error = '请上传图片！';
			}
			if(!$fid){
				$error = '请选择上级课程！';
			}
			$fid = $fid==-1 ? 0 : $fid;
			$where = array(
				'id'=>array('neq',$id),
				'name'=>$name,
			);
			$ckname = $this->CourseModel->get_course_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'fid'=>$fid,
					'name'=>$name,
					'update_time'=>time(),
					'status'=>$status,
				);
				if($img){
					$imgArr = $this->deal_upload_img(trim($img,'.'),'course');
					$data['img'] = $imgArr['img'].'.'.$imgArr['ext'];
				}
				$where = "id=$id";
				if(!$this->CourseModel->update_course($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'course_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$lists = $this->CourseModel->get_course_lists('1=1',0,50);
			$lists = getCategoryLists($lists);
			$this->assign('lists',$lists);

			$this->assign('info',$info);
			$this->display();
		}
	}

	/**
	*删除项目
	*/
	public function del_course(){
		//检查权限
		if(!checkPermission('del_course')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = array('id'=>$id);
		$info = $this->CourseModel->get_course_info(array('id'=>$id));

		if(!$info){
			$error = '数据错误！';
		}
		
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$this->CourseModel->delete_course($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			@unlink(dirname(APPPATH).$info['img']);
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'course_lists';
		}
		die(json_encode($r));
	}

	
	/**
	*课表
	*/

	public function timetable_lists(){
		//检查权限
		if(!checkPermission('timetable_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$TimeTableModel = D('timetable');
		$name = I('post.name','','trim');
		$type = I('post.type','','intval');
		
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}
		
		if($type>0){
			$condition['type'] = $type;
		}	

		$total_rows = $TimeTableModel->get_timetable_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $TimeTableModel->get_timetable_lists($condition,$offset,$numPerPage,$order);
		
		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加课时
	*/
	public function add_timetable(){
		//检查权限
		if(!checkPermission('add_timetable')){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
		
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'fid'=>$fid,
					'name'=>$name,
					'create_time'=>time(),
					'status'=>$status,
				);
				

				if(!$this->CourseModel->add_course($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'course_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->display();
		}
	}

	/**
	*获取机构课程
	*/

	public function get_agency_course(){
		$ag_id = I('post.ag_id',0,'intval');
		$AgencyCourseModel = D('agencyCourse');

		$condition = array('ag_id'=>$ag_id,'status'=>1);
		$agency_course = $AgencyCourseModel->get_agency_course_lists($condition);

		$CourseModel = D('course');
		$course_lists = array();
		foreach($agency_course as $value){
			$info = $CourseModel->get_course_info(array('id'=>$value['course_id']));
			if(empty($info)){
				continue;
			}
			$child_course = $CourseModel->get_course_lists(array('fid'=>$value['course_id'],'status'=>1));
			$info['child'] = $child_course;
			$course_lists[] = $info;

		}
		die(json_encode(array('lists'=>$course_lists)));

	}


	/**
	*获取老师课表
	*/
	public function get_teacher_course(){
		$ag_id = I('post.ag_id',0,'intval');
		$teacher_id = I('post.teacher_id',0,'intval');
		$course_id = I('post.course_id',0,'intval');
		$select_time = I('post.select_time',0,'intval');
		$result = array('status'=>0);

		if($ag_id && $teacher_id){
			//获取课程id
			$CourseModel = D('course');
			$course = $CourseModel->get_course_info(array('id'=>$course_id));

			$course_id = !empty($course) ? $course['fid'] : 0;
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
			$arr = array();

			$today = strtotime(date('Y-m-d 00:00:00',time()));

			for($i=0;$i<$cnt;$i++){
				$time = $i*$course_time+$agency_start_time+$today;
				$arr[]= date('H:i',$time);
			}
			$result['time_line'] = $arr;

			//选择时间
			$select_time = $select_time ? strtotime(date('Y-m-d',strtotime($select_time))) : strtotime(date('Y-m-d'));

			$condition = array(
				'ag_id'=>$ag_id,
				'teacher_id'=>$teacher_id,
				'start_time'=>array('gt',$select_time),
				'end_time'=>array('lt',$select_time+24*3600),
				'status'=>1,
			);
			$TimetableModel = D('timetable');
			$timetable = $TimetableModel->get_timetable_lists_info($condition);
			$course_lists = array();
			$tmp1 = array();
			$tmp2 = array();
			foreach($arr as $k=>$t){
				$no = $k+1;
				if(!empty($timetable)){
					foreach($timetable as $value){
						$room_no = explode('-', $value['room_no']);
						
						if($room_no[1]==$no && $value['start_time']<$select_time+24*3600){
							$tmp1[] = $value;
						}else{
							$tmp1[] = array();
						}
						if($room_no[1]==$no && $value['start_time']<$select_time+2*24*3600 && $value['start_time']> $select_time+24*3600){
							$tmp2[] = $value;
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
			$result['select_time'] = array(
				date('Y-m-d',$select_time),
				date('Y-m-d',$select_time+24*3600),
			);
			$result['course_lists'] = $course_lists;

		}
		die(json_encode($result));

	}

}