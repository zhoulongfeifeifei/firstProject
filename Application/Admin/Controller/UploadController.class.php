<?php
namespace Admin\Controller;
use Think\Controller;
class UploadController extends BaseController {

	public function __construct(){
		parent::__construct();
	}

	/*
	图片上传处理
	*/
	public function index(){
		header('Content-Type: text/html; charset=UTF-8');
		//表单文件域name
		$inputName='file';
		$inputName2= 'filedata';
		//上传文件保存路径，结尾不要带/
		$attachDirTmps=dirname(APPPATH).'/Static/data/uploads/material/tmps';
		$fileAccessLinkUrl='/Static/data/uploads/material';
		//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
		//$dirType=1;
		//最大上传大小，默认是20M
		$maxAttachSize=20971520;
		//上传扩展名
		$upExt='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mp4,mid,amr';
		//返回上传参数的格式：1，只返回url，2，返回参数数组
		$msgType=2;
		ini_set('date.timezone','Asia/Shanghai');

		$err = "";
		$msg = "''";
		$yesterday = strtotime(date('Y-m-d',time()))-1;
		$premon = strtotime(date('Y-m',time()))-1;

		$rmdirday = $attachDirTmps.'/'.date('Y',$yesterday).'/'.date('m',$yesterday).'/'.date('d',$yesterday);
		$rmdirmon = $attachDirTmps.'/'.date('Y',$premon).'/'.date('m',$premon);
		if(is_dir($rmdirday)){
			$this->deldir($rmdirday);
		}
		if(is_dir($rmdirmon)){
			$this->deldir($rmdirmon);
		}
		$attachDirTmps=$attachDirTmps.'/'.date('Y').'/'.date('m').'/'.date('d');
		if(is_dir($attachDirTmps)){
			$this->deldir($attachDirTmps);
		}
		$tempPath=$attachDirTmps.'/'.str_replace('.', '', uniqid('',true)).'.tmp';
		$localName='';
		$sign  = 0;
		if(!is_dir($attachDirTmps)){
			@mkdir($attachDirTmps,0777,true);
		}

		if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){
			//HTML5上传
			file_put_contents($tempPath,file_get_contents("php://input"));
			$localName=urldecode($info[2]);
		}else{
			//标准表单式上传
			$upfile=@$_FILES[$inputName];
			$upfile2 = @$_FILES[$inputName2];
			$sign = $upfile2 ? 1 : 0;
			$upfile = $upfile ? $upfile : $upfile2;
			if(!isset($upfile)){
				$err='文件域的name错误';
			}elseif(!empty($upfile['error'])){
				switch($upfile['error']){
					case '1':
						$err = '文件大小超过了php.ini定义的upload_max_filesize值';
						break;
					case '2':
						$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
						break;
					case '3':
						$err = '文件上传不完全';
						break;
					case '4':
						$err = '无文件上传';
						break;
					case '6':
						$err = '缺少临时文件夹';
						break;
					case '7':
						$err = '写文件失败';
						break;
					case '8':
						$err = '上传被其它扩展中断';
						break;
					case '999':
					default:
						$err = '无有效错误代码';
				}
			}elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none'){
				$err = '无文件上传';
			}else{
				move_uploaded_file($upfile['tmp_name'],$tempPath);
				$localName=$upfile['name'];
			}
		}
		if($err==''){
			$fileInfo=pathinfo($localName);
			$extension=$fileInfo['extension'];
			if(preg_match('/^('.str_replace(',','|',$upExt).')$/i',$extension)){
				$bytes=filesize($tempPath);
				if($bytes > $maxAttachSize){
					$err='请不要上传大小超过'.$this->formatBytes($maxAttachSize).'的文件';
				}else{
					/*
					上传文件后还是先存到临时文件夹中
					等提交表单后再移动到正式文件夹中
					*/
					//PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
					$newFilename=str_replace('.', '', uniqid('',true)).'.'.$extension;
					$targetPath = $attachDirTmps.'/'.$newFilename;

					rename($tempPath,$targetPath);
					@chmod($targetPath,0755);
					$targetPath=$this->jsonString($targetPath);

					$targetPath=$fileAccessLinkUrl.'/tmps/'.date('Y').'/'.date('m').'/'.date('d').'/'.$newFilename;
				}
			}else{
				$err='上传文件扩展名必需为：'.$upExt;
			}
			if(file_exists($tempPath)){
				@unlink($tempPath);
			}
		}
		$result = array();
		if(!$err){
			if($sign==1){
				$result['err']="";
				$result['msg']=$targetPath;
			}else{
				$result['statusCode']=200;
				$result['message']='操作成功';
				$result['url']=$targetPath;
			}
		}else{
			if($sign==1){
				$result['err']='上传失败，请稍后重试';
			}else{
				$result['statusCode']=300;
				$result['message']='操作失败'.$this->jsonString($err);
			}
		}
		die(json_encode($result));
	}

	public function deldir($dir) {
		//先删除目录下的文件：
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					if(time()-filectime($fullpath)>1800){
						@unlink($fullpath);	
					}
				} else {
					$this->deldir($fullpath);
				}
			}
		}

		closedir($dh);
		//删除当前文件夹：
		if(@rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
	public function jsonString($str){
		return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
	}

	public function formatBytes($bytes) {
		if($bytes >= 1073741824) {
			$bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
		} elseif($bytes >= 1048576) {
			$bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
		} elseif($bytes >= 1024) {
			$bytes = round($bytes / 1024 * 100) / 100 . 'KB';
		} else {
			$bytes = $bytes . 'Bytes';
		}
		return $bytes;
	}
	
}