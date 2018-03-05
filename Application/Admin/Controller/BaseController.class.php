<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {

	public function __construct(){
		parent::__construct();
		if(!session('employee_id')){
			exit('<script type="text/javascript">location.href="/admin/Index/login";</script>');
		}
	}

	/**
	*图片处理
	*@param $img  图片地址
	* @param $filename  存储文件夹名
	* @param $data  如果删除  删除数据对应数据   img 图片地址名  ext 图片后缀
	*/
	protected function deal_upload_img($img='',$filename='',$data=array()){
		$size_info = C($filename);
		$img_res = array();
		if($img){
			$img_res = dealUploadImg($img,$filename,$size_info);
			if(!empty($size_info) && !empty($img_res)){
				$img_file = dirname(APPPATH).$img_res['img'].'.'.$img_res['ext'];
				thumbImg($size_info,$img_file);
			}
		}
		if(!empty($data)){
			@deleteThumbImg($size_info,(dirname(APPPATH).$data['img']),$data['ext']);
		}
		return $img_res;
	}

}