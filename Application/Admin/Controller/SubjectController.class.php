<?php
namespace Admin\Controller;
use Think\Controller;
class SubjectController extends BaseController {
	
	protected $SubjectModel ;
	public function __construct(){
		parent::__construct();
		$this->SubjectModel = D('Subject');
	}
	
	/**
	* 分类列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('subject_lists')){
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
		$total_rows = $this->SubjectModel->get_subject_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $this->SubjectModel->get_subject_lists($condition,$offset,$numPerPage,$order);
		
		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加分类
	*/
	public function add_subject(){
		//add_subject
		if(!checkPermission('add_subject')){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			if(!$name){
				$error = '请输入名称！';
			}
			$where = array(
				'name'=>$name,
			);
			$ckname = $this->SubjectModel->get_subject_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$this->SubjectModel->add_subject($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'subject_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->display();
		}
	}

	/**
	*修改分类
	*/
	public function edit_subject(){
		//检查权限
		if(!checkPermission('edit_subject')){
			return ;
		}
		$id = I('get.id',0,'intval');
		//获取分类信息
		$info = $this->SubjectModel->get_subject_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			if(!$name){
				$error = '请输入名称！';
			}
			$where = array(
				'id'=>array('neq',$id),
				'name'=>$name,
			);
			$ckname = $this->SubjectModel->get_subject_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = "id=$id";
				if(!$this->SubjectModel->update_subject($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'subject_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			
			$this->assign('info',$info);
			$this->display();
		}
	}

	/**
	*删除项目
	*/
	public function del_subject(){
		//检查权限
		if(!checkPermission('del_subject')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = array('id'=>$Id);
		$info = $this->SubjectModel->get_subject_info(array('id'=>$id));

		if(!$info){
			$error = '数据错误！';
		}

		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$this->SubjectModel->delete_subject($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'subject_lists';
		}
		die(json_encode($r));
	}

}