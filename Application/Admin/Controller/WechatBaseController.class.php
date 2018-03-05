<?php
namespace Admin\Controller;
use Think\Controller;
class WechatBaseController extends Controller {

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

	/**
	* 获取access_token
	*/
	protected function get_access_token(){
		$access_file = file_get_contents('./access_token.txt');
		$info = unserialize($access_file);
		if($info && $info['token_time']>time()){
			return $info['access_token'];
		}else{
			$appid = C('APPID');
			$app_secret = C('APP_SECRET');
			$param = array(
				'grant_type'=>'client_credential',
				'appid'=>$appid,
				'secret'=>$app_secret,
			);
			$api = C('ACCESS_TOKEN_API');
			$res = json_decode(httpRequired($api,createLinkstring($param)),true);
			$res['token_time'] = time()+7100;
			file_put_contents('./access_token.txt', serialize($res));
			return $res['access_token'];
		}
	}

		/**
	*返回文本信息
	*/
	protected function send_text_msg($toUsers,$fromUsers,$content){
		$msg = array(
			'ToUserName'=>$toUsers,
			'FromUserName'=>$fromUsers,
			'CreateTime'=>time(),
			'MsgType'=>'text',
			'Content'=>$content,
		);
		$xml = arrayToXml($msg);
		echo $xml;
	}

		/**
	 * 上传临时媒体资源
	 * @param string $filename    媒体资源本地路径
	 * @param string $type        媒体资源类型，具体请参考微信开发手册
	 * @param string $description 资源描述，仅资源类型为 video 时有效
	 */
	protected function add_temp_material($filename='', $type='image', $description = ''){
		$api = (C('TEMP_MATERIAL_API') ? C('TEMP_MATERIAL_API') : 'https://api.weixin.qq.com/cgi-bin/media/upload').'?access_token='.$this->get_access_token().'&type='.$type;
		$filepath = realpath($filename);
		if(!$filepath) throw new \Exception('资源路径错误！');
		
		if (class_exists ( '\CURLFile' )) {//关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件  
			$data = array ('media' => new \CURLFile($filepath));  
		}else {
			$data = array('media' => '@'.$filepath);
		} 

		if($type == 'video'){
			if(is_array($description)){
				//保护中文，微信api不支持中文转义的json结构
				array_walk_recursive($description, function(&$value){
					$value = urlencode($value);
				});
				$description = urldecode(json_encode($description));
			}
			$data['description'] = $description;
		}
		$res = json_decode(httpsRequired($api,$data),true);
		return $res;
	}

	/**
	* 获取临时素材
	* @param $media_id  媒体id
	* @param $filename  文件名
	* @param  $path  保存文件夹
	*/

	protected function get_temp_material($media_id='',$path='public'){
		$api = C('GET_TEMP_MATERIAL_API').'?access_token='.$this->get_access_token().'&media_id='.$media_id;
		$output = curlFile($api);
		if($output){
			$filename = $output['filename'];
		}else{
			return false;
		}
		$filename = './Static/data/message/'.$path.'/'.date('Y',time()).'/'.date('m',time()).'/'.date('d',time()).'/'.$filename;
		$toFileDir = pathinfo($filename);
		if(!file_exists($toFileDir['dirname'])){
			mkdir($toFileDir['dirname'],0777,true);
		}
		$local_file = fopen($filename, 'w');
		if (false !== $local_file){//不恒等于（恒等于=== 就是false只能等于false，而不等于0）
			if (false !== fwrite($local_file, $output['content'])) {
				fclose($local_file);
				return $filename;
			}
		}
		return false;
	}

	/**
	* 发送客服消息
	*/
	protected function send_serivce($postData=array()){
		$api = C('SERVICE_SEND_API').'?access_token='.$this->get_access_token();
		if(empty($postData)){
			return false;
		}
		$postData = arrayToJsonUrlParam($postData);
		$res = json_decode(httpRequired($api,'',$postData,'POST'),true);
		return $res;
	}

		/**
	* 生成二维码
	*/
	protected function create_qrcode($openid='',$user_id=0){
		$api = C('QRCODE_API').'?access_token='.$this->get_access_token();
		$postData = array(
			'expire_seconds'=>30*24*3600,
			'action_name'=>'QR_LIMIT_STR_SCENE',
			'action_info'=>array(
				'scene'=>array(
					'scene_str'=>$user_id,
				),
			),
		);
		$postData =arrayToJsonUrlParam($postData);
		$res = json_decode(httpRequired($api,'',$postData,'POST'),true);
		if($res){
			$get_qrcode_api = C('GET_QRCODE_API').'?ticket='.urlencode($res['ticket']);
			$output = curlFile($get_qrcode_api);
			$filename = $openid.'_qrcode.jpg';
			$filename = './Static/data/uploads/qrcode/'.$filename;
			$toFileDir = pathinfo($filename);
			if(!file_exists($toFileDir['dirname'])){
				mkdir($toFileDir['dirname'],0777,true);
			}
			$local_file = fopen($filename, 'w');
			if (false !== $local_file){//不恒等于（恒等于=== 就是false只能等于false，而不等于0）
				if (false !== fwrite($local_file, $output['content'])) {
					fclose($local_file);
					$qrcode_img = trim($filename,'.');
					$updata = array('qrcode_img'=>$qrcode_img,'qrcode_time'=>(time()-100));
					M('wechat_users')->where(array('openid'=>$openid))->save($updata);
				}
			}
			return false;
		}
	}

}