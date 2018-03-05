<?php
namespace Admin\Controller;
use Think\Controller;
class AdvertController extends BaseController {
	
	protected $AdvertModel ;
	public function __construct(){
		parent::__construct();
		$this->AdvertModel = D('Advert');
	}
	
	/**
	* 广告位列表
	* @param $rel  广告位标识
	* @param  $type  广告为标识类型id
	*/
	public function index(){
		$rel = I('get.rel','','trim');
		$type = I('get.type',0,'intval');
		//检查权限
		if(!checkMenuPermission($rel) || $type==0){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$condition['name'] = array('like','%'.$name.'%');
		$condition['type'] = $type;

		$total_rows = $this->AdvertModel->get_advert_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		
		$lists = $this->AdvertModel->get_advert_lists($condition,$offset,$numPerPage);
		
		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加广告
	* @param $rel  广告位标识
	* @param  $type  广告为标识类型id
	*/
	public function add_advert(){
		$rel = I('get.rel','','trim');
		$type = I('get.type',0,'intval');
		//检查权限
		if(!checkPermission('add_'.$rel) || $type==0){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
			$sort = I('post.sort',0,'intval');
			$img = I('post.img','','trim');
			$desc = I('post.desc','','trim');
			$status = I('post.status',0,'intval');
			$skip_type = I('post.skip_type',0,'intval');
			$skip_content = I('post.skip_content','','trim');
			if($skip_type==0 || !$skip_content){
				$error = '请选择广告类型以及广告类型内容';
			}
			
			if(!$img){
				$error = '请上传图片';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				//图片处理
				$img_res = $this->deal_upload_img($img,'advert');
				$data = array(
					'name'=>$name,
					'type'=>$type,
					'sort'=>$sort,
					'img'=>!empty($img_res['img']) ? $img_res['img']: '',
					'ext'=>!empty($img_res['ext']) ? $img_res['ext'] : '',
					'skip_type'=>$skip_type,
					'desc'=>$desc,
					'skip_content'=>$skip_content,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$this->AdvertModel->add_advert($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					@thumbImg(C('advert_'.$rel),'.'.trim($data['img'],'.').'.'.$data['ext']);
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = $rel;
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
	public function edit_advert(){
		$rel = I('get.rel','','trim');
		$type = I('get.type',0,'intval');
		//检查权限
		if(!checkPermission('edit_'.$rel) || $type==0){
			return ;
		}
		$id = I('get.id',0,'intval');
		//获取分类信息
		$info = $this->AdvertModel->get_advert_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$sort = I('post.sort',0,'intval');
			$img = I('post.img','','trim');
			$desc = I('post.desc','','trim');
			$status = I('post.status',0,'intval');
			$skip_type = I('post.skip_type',0,'intval');
			$skip_content = I('post.skip_content','','trim');
			if($skip_type==0 || !$skip_content){
				$error = '请选择广告类型以及广告类型内容';
			}

			//图片处理
			if(!$img){
				$error = '请上传图片';
			}else if($img==1){
				$img_res = array('img'=>$info['img'],'ext'=>$info['ext']);
			}else{
				//处理图片
				$img_res = $this->deal_upload_img($img,'advert',$info);
			}
			
			if(!$img){
				$error = '请上传图片';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'type'=>$type,
					'sort'=>$sort,
					'img'=>!empty($img_res['img']) ? $img_res['img']: '',
					'ext'=>!empty($img_res['ext']) ? $img_res['ext'] : '',
					'skip_type'=>$skip_type,
					'desc'=>$desc,
					'skip_content'=>$skip_content,
					'create_time'=>time(),
					'status'=>$status,
				);
				$where = "id=$id";
				if(!$this->AdvertModel->update_advert($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					if($img!=1){
						@thumbImg(C('advert_'.$rel),'.'.trim($data['img'],'.').'.'.$data['ext']);
						$srcname = '.'.$info['img'];
						$srcext = $info['ext'];
						@deleteThumbImg(C('advert_'.$rel),$srcname,$srcext);
					}
					$r['statusCode'] = 200;
					$r['message'] = '修改成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = $rel;
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
	public function del_advert(){
		$rel = I('get.rel','','trim');
		$type = I('get.type',0,'intval');
		//检查权限
		if(!checkPermission('del_'.$rel) || $type==0){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = array('id'=>$id,'type'=>$type);
		$info = $this->AdvertModel->get_advert_info($id);
		if(empty($info)){
			$error = '数据错误！';
		}

		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$this->AdvertModel->delete_advert($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			//删除图片
			$srcname = '.'.$info['img'];
			$srcext = $info['ext'];
			@deleteThumbImg(C('advert_'.$rel),$srcname,$srcext);
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = $rel;
		}
		die(json_encode($r));
	}



}