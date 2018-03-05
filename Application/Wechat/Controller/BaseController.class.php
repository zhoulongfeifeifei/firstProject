<?php
namespace Wechat\Controller;
use Think\Controller;
class BaseController extends Controller {

	public function __construct(){
		parent::__construct();	
	}

	/**
	* 检查是否是微信服务器发送消息
	*/
	protected function check_signature(){
		// you must define TOKEN by yourself
		$token = C('TOKEN');
		if (!$token) {
			throw new Exception('TOKEN is not defined!');
		}
		
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
				
		$tmpArr = array($token, $timestamp, $nonce);
		// use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	/**
	* 获取access_token
	*/
	protected function get_access_token(){
		$access_file = file_get_contents('./access_token.txt');
		$info = unserialize($access_file);
		if($info && $info['time']>time()){
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
	*日志记录
	* @param $log_content 日记内容
	*/
	protected function logger($log_content){
	  
		$max_size = 200000;   //声明日志的最大尺寸

		$log_filename = "./log.xml";  //日志名称

		//如果文件存在并且大于了规定的最大尺寸就删除了
		if(file_exists($log_filename) && (abs(filesize($log_filename)) > $max_size)){
			unlink($log_filename);
		}

		//写入日志，内容前加上时间， 后面加上换行， 以追加的方式写入
		file_put_contents($log_filename, date('H:i:s')." ".$log_content."\n", FILE_APPEND);
		
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
				return trim($filename,'.');
			}
		}
		return false;
	}
}
