<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends BaseController {
	
	protected $CategoryModel ;
	protected $ids;
	public function __construct(){
		parent::__construct();
		$this->CategoryModel = D('Category');
	}
	
	/**
	* 分类列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('category_lists')){
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
		$total_rows = $this->CategoryModel->get_category_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'sort DESC';
		$lists = $this->CategoryModel->get_category_lists($condition,$offset,$numPerPage,$order);
		foreach($lists as &$item){
			if($item['fid']==0){
				$item['fname'] = '一级分类';
			}else{
				$info = $this->CategoryModel->get_category_info($item['fid']);
				$item['fname'] = $info['name'];
			}
		}
		$this->assign('result',$lists);

		//分类筛选
		$lists = $this->CategoryModel->get_category_lists('1=1',0,500);
		$lists = getCategoryLists($lists);
		$this->assign('lists',$lists);
		$this->display();
	}

	/**
	*添加分类
	*/
	public function add_category(){
		//检查权限
		if(!checkPermission('add_category')){
			return ;
		}
		if($_POST){
			$fid = I('post.fid',0,'intval');
			$name = I('post.name','','trim');
			$sort = I('post.sort',0,'intval');
			$img = I('post.img','','trim');
			$status = I('post.status',0,'intval');
			
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'fid'=>$fid,
					'name'=>$name,
					'sort'=>$sort,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$this->CategoryModel->add_category($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'category_lists';
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
	public function edit_category(){
		//检查权限
		if(!checkPermission('edit_category')){
			return ;
		}
		$id = I('get.id',0,'intval');
		//获取分类信息
		$info = $this->CategoryModel->get_category_info(array('id'=>$id));
		if($_POST && $info){
			$name = I('post.name','','trim');
			$sort = I('post.sort',0,'intval');
			$status = I('post.status',0,'intval');

			if(!$name){
				$error = '请输入名称！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'sort'=>$sort,
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = array('id'=>$id);
				if(!$this->CategoryModel->update_category($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'category_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$fcate = $this->CategoryModel->get_category_info(array('id'=>$info['fid']));
			$this->assign('fcate',$fcate);
			$this->assign('info',$info);
			$this->display();
		}
	}

	/**
	*删除项目
	*/
	public function del_category(){
		//检查权限
		if(!checkPermission('del_category')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition =array('id'=>$id);
		$info = $this->CategoryModel->get_category_info(array('id'=>$id));
		$ckres = $this->CategoryModel->get_category_info(array('fid'=>$id));

		if($ckres){
			$error = '此分类下存在项目或者分类！不能删除！';
		}
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$this->CategoryModel->delete_category($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'category_lists';
		}
		die(json_encode($r));
	}


}