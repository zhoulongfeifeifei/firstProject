<?php
namespace Admin\Controller;
use Think\Controller;
class WechatMaterialController extends WechatBaseController {

	public function __construct(){
		parent::__construct();
	}

	/**
	*关键词回复设置
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('material')){
			return ;
		}
		$wechat_material_model = D('wechat_material');
		$name = I('post.name','','trim');
		$type = I('post.type',0,'intval');
		$condition = array();
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}
		if($type>0){
			$condition['type'] = $type;
		}
		$total_rows = $wechat_material_model->get_material_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$result = $wechat_material_model->get_material_list($condition,$offset,$per_page);

		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$result);
		$this->display();
	}

	/**
	* 获取素材列表
	*/

	public function get_material(){
		$type = I('get.type',0,'intval');
		$perNums = I('get.pernum',5,'intval');
		$page = I('get.page',1,'intval');
		$name = I('post.name','','trim');
		$result = array('status'=>0,'search'=>$name);

		$wechat_material_model = D('wechat_material');
		$offset = ($page - 1 ) * $perNums;
		$condition = array('status'=>1);
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}
		if($type>0){
			$condition['type'] = $type;
		}

		$total_rows = $wechat_material_model->get_material_count($condition);
		$res = $wechat_material_model->get_material_list($condition,$offset,$perNums);
		$newArr = array();
		$cnt=0;
		foreach($res as $k=>$v){
			$tmp = $v;
			$patt = '/http:\/\//';
			$tmp['contenturl'] = preg_match($patt,$v['contenturl']) ? $v['contenturl'] : C('BASE_URL').trim($v['contenturl'],'.');
			$tmp['title'] = mb_substr($v['title'], 0,10,'utf-8').'...';
			if($v['end_time']>0 && $v['mediaid']){
				if($v['end_time']<time()){
					$cnt++;
					continue;
				}
			}
			$newArr[] = $tmp;
		}
		$result['lists'] = $newArr;
		if($newArr){
			$result['last_page'] = ($total_rows-$cnt-($page*$perNums)) >=0 ? false : true;
			$result['status'] = 1;
			$result['search'] = $name;
			$result['type'] = $type;
		}
		die(json_encode($result));
	}

	/**
	*添加素材
	*/
	public function add_material(){
		//检查权限
		if(!checkPermission('add_material')){
			return ;
		}
		$wechat_model = D('wechat_material');
		if($_POST){
			$type = I('post.type',0,'intval');
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			$title = I('post.title','','trim');
			$description = I('post.description','','trim');
			$contenturl = I('post.contenturl','','trim');
			$url = I('post.url','','trim');
			$content = I('post.content','','trim');
			$media = I('post.media','');
			$data = array();

			if(!$name){
				$error = '名称不能为空！';
			}else if(!$type){
				$error = '请选择类型';
			}
			switch($type){
				case 1:
					if(!$content){
						$error = '请输入文本内容！';
					}
					break;
				case 2://处理图片
				case 3://语音
					if(!$media){
						$error = '请上传文件！';
					}
					break;
				case 4://视频
					if(!$media){
						$error = '请上传文件！';
					}else if(!$title){
						$error = '请填写标题！';
					}
					break;
				case 5:
					if(!$title){
						$error = '请填写标题！';
					}else if(!$description){
						$error = '请输入描述！';
					}else if(!$contenturl){
						$error = '请填写音乐链接！';
					}else if(!$url){
						$error = '请填写高质量链接！';
					}
					break;
				case 6:
					if(!$title){
						$error = '请填写标题！';
					}else if(!$description){
						$error = '请输入描述！';
					}else if(!$contenturl){
						$error = '请填写图片链接！';
					}else if(!$url){
						$error = '请填写文章链接！';
					}
					break;
			}

			$data['status'] = $status;
			$ckname = $wechat_model->get_material_info(array('name'=>$name));
			if($ckname){
				$error = '名称已经存在';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['type'] = $type;
				$data['name'] = $name;
				switch($type){
					case 1:
						$data['content'] = $content;
						break;
					case 2://处理图片
						$media = dealUploadImg($media,'images');
						$data['contenturl'] = '.'.$media['img'].'.'.$media['ext'];
						break;
					case 3://语音
						$data['contenturl']  = moveMaterial($media,'voice');
						break;
					case 4://视频
						$data['title'] = $title;
						$data['contenturl']  = moveMaterial($media,'video');
						$data['description'] = $description;
						break;
					case 5:
					case 6:
						$data['title'] = $title;
						$data['description'] = $description;
						$data['contenturl'] = $contenturl;
						$data['url'] = $url;
						break;
				}
				$data['status'] = $status;
				$data['create_time'] = time();
				if(! $insertId = $wechat_model->add_material($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$msg = '添加成功！';
					//上传微信素材
					if($status){
						$msg = $this->upload_wechat_material($type,$data,$insertId);
					}
					$r['statusCode'] = 200;
					$r['message'] = $msg;
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'material';
				}
				
			}
			die(json_encode($r));

		}else{
			$this->display();
		}
	}

	/**
	* 上传meida到微信
	*/
	private function upload_wechat_material($type,$data,$id=0){
		$msg = '添加成功';
		$where = array('id'=>$id);
		$typeCode='';
		switch($type){
			case 1:
				break;
			case 2://处理图片
				$typeCode = 'image';
				break;
			case 3:
				$typeCode = 'voice';
				break;
			case 4:
				$typeCode ='video';
				break;
		}
		if($typeCode){
			$res = $this->add_temp_material($data['contenturl'],$typeCode);
			if($res['media_id']){
				$data = array();
				$wechat_model = D('wechat_material');
				$data['MediaId'] = $res['media_id'];
				$data['start_time'] = $res['created_at'];
				$data['end_time'] = $res['created_at']+(24*3600*3);
				$wechat_model->update_material($where,$data);
			}else{
				$wechat_error = C('WECHAT_CODE')[$res['errcode']] ? C('WECHAT_CODE')[$res['errcode']] : $res['errmsg'];
				$msg='添加本地成功，微信服务器失败！错误原因：'.$wechat_error;
			}
		}
		return $msg;
	}

	/**
	*修改素材
	*/
	public function edit_material(){
		//检查权限
		if(!checkPermission('edit_material')){
			return ;
		}
		$id = I('get.id',0,'intval');
		$wechat_model = D('wechat_material');
		$info = $wechat_model->get_material_info(array('id'=>$id));
		if($_POST){
			$type = I('post.type',0,'intval');
			$name = I('post.name','','trim');
			$status = I('post.status',0,'intval');
			$title = I('post.title','','trim');
			$description = I('post.description','','trim');
			$contenturl = I('post.contenturl','','trim');
			$url = I('post.url','','trim');
			$content = I('post.content','','trim');
			$media = I('post.media','');
			$data = array();

			if(!$name){
				$error = '名称不能为空！';
			}else if(!$type){
				$error = '请选择类型';
			}
			switch($type){
				case 1:
					if(!$content){
						$error = '请输入文本内容！';
					}
					break;
				case 2://处理图片
				case 3://语音
					if(!$media){
						$error = '请上传文件！';
					}
					break;
				case 4://视频
					if(!$media){
						$error = '请上传文件！';
					}
					if(!$title){
						$error = '请填写标题！';
					}
					break;
				case 5:
					if(!$title){
						$error = '请填写标题！';
					}else if(!$description){
						$error = '请输入描述！';
					}else if(!$contenturl){
						$error = '请填写音乐链接！';
					}else if(!$url){
						$error = '请填写高质量链接！';
					}
					break;
				case 6:
					if(!$title){
						$error = '请填写标题！';
					}else if(!$description){
						$error = '请输入描述！';
					}else if(!$contenturl){
						$error = '请填写图片链接！';
					}else if(!$url){
						$error = '请填写文章链接！';
					}
					break;
			}

			$data['status'] = $status;
			$ckname = $wechat_model->get_material_info(array('name'=>$name,'id'=>array('neq',$id)));
			if($ckname){
				$error = '名称已经存在';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['type'] = $type;
				$data['name'] = $name;
				switch($type){
					case 1:
						$data['content'] = $content;
						break;
					case 2://处理图片
						$media = $this->deal_upload_img(trim($media,'.'),'images');
						$data['contenturl'] = '.'.$media['img'].'.'.$media['ext'];
						break;
					case 3://语音
						$data['contenturl']  = (trim($media,'.') == trim($info['contenturl'],'.')) ? $info['contenturl'] : moveMaterial($media,'voice');
						break;
					case 4://视频
						$data['title'] = $title;
						$data['description'] = $description;
						$data['contenturl']  = (trim($media,'.') == trim($info['contenturl'],'.')) ? $info['contenturl'] : moveMaterial($media,'video');
						break;
					case 5:
					case 6:
						$data['title'] = $title;
						$data['description'] = $description;
						$data['contenturl'] = $contenturl;
						$data['url'] = $url;
						break;
				}
				$data['status'] = $status;
				$data['update_time'] = time();
				$where = array('id'=>$id);
				if(! $wechat_model->update_material($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$msg = '修改成功！';
					if($status){
						//上传微信素材
						$msg = $this->upload_wechat_material($type,$data,$id);
					}
					$r['statusCode'] = 200;
					$r['message'] = $msg;
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'material';
				}
				
			}
			die(json_encode($r));

		}else{
			$this->assign('info',$info);
			$this->display();
		}
	}

	public function del_material(){
		//检查权限
		if(!checkPermission('del_material')){
			return ;
		}
		$wechat_model = D('wechat_material');
		$id = I('get.id',-1,'intval');
		$info = $wechat_model->get_material_info(array('id'=>$id));
		$content = $info['contenturl'];
		if(!$wechat_model->delete_material(array('id'=>$id))){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			@unlink($content);
			$msg = '删除成功';
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'material';
		}
		die(json_encode($r));
	}

}