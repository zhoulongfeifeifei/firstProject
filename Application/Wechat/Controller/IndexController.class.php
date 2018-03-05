<?php
namespace Wechat\Controller;
use Think\Controller;
class IndexController extends WechatController {

	public function __construct(){
		parent::__construct();	
	}

	/**
	*接收微信返回信息
	*/
	public function index(){
		$echoStr = I('get.echostr','');
		//valid signature , option
		//验证
		if($this->check_signature() && $echoStr){
			echo $echoStr;
			exit;
		}else{
			//接收消息
			$this->response_msg();
		}
	}

	/**
	* 接收微信消息回复对应消息
	*/
	private function response_msg(){
		$postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
		if(!$postStr){
			$postStr = file_get_contents("php://input");
		}
		$data = xmlToArray($postStr);
		$MsgType = strtolower($data['MsgType']);
		$event = strtolower($data['Event']);

		//保存接收消息
		$MsgType != 'event' ? $this->receive_msg($data) : '';
		$this->logger("R \n".$postStr);
		$receiveType = -1;
		switch($MsgType){
			//事件消息
			case 'event':
				switch($event){
					case 'subscribe':
						//添加用户
						$this->add_users($data);
						$receiveType = 1;
						break;
					case 'unsubscribe':
						$this->update_users($data);
						break;
					case 'click':
						$this->menu_click($data);
						break;
					case 'scan'://二维码扫描 （已关注过）

						break;
					default:
						break;
				}
				break;
			//文本消息
			case 'text':
				//回复消息
				$receiveType = 0;
				break;
			case 'image':
				$receiveType = 2;
				break;
			case 'voice':
				$receiveType = 3;
				break;
			case 'video':
				$receiveType = 4;
				break;
			case 'shortvideo':
				$receiveType = 5;
				break;
			case 'location':
				$receiveType = 6;
				break;
			case 'link':
				$receiveType = 7;
				break;
		}
		if($receiveType  >-1){
			//被动回复。数据库配置
			$this->response_dbinfo($data,$receiveType);
		}
	}


	/**
	* 添加用户 用户注册
	* @param $data  微信返回数据
	*/

	protected function add_users($data){
		$access_token = $this->get_access_token();
		$openid = $data['FromUserName'];
		$api = C('USER_INFO_API');
		$param = array(
			'access_token'=>$access_token,
			'openid'=>$openid,
			'lang'=>'zh_CN',
		);
		$res = json_decode(httpRequired($api,createLinkstring($param)),true);
		if($res['openid']){
			$Model = M('wechat_users');
			$ckuser = $Model->where(array('openid'=>$res['openid']))->find();
			$res['tagid_list'] = serialize($res['tagid_list']);
			//识别二维码中的参数
			$EventKey = explode('_', $data['EventKey']);
			$res['recommend_id'] = !empty($EventKey[1]) ? $EventKey[1] : 0;
			if(empty($ckuser)){
				$users_id = $Model->add($res);
			}else{
				unset($res['subscribe_time']);
				$users_id = $ckuser['id'];
				$Model->where(array('id'=>$users_id))->save($res);
			}
			//生成二维码
			$this->create_qrcode($openid,$users_id);
		}
	}

	/**
	* 更新用户信息
	*/

	private function update_users($data){
		$Model = M('wechat_users');
		$update = array('subscribe'=>0,'unsubscribe_time'=>time());
		$Model->where(array('openid'=>$data['FromUserName']))->save($update);
	}

	/**
	*接收消息 保存
	* @param $data  微信返回数据
	*/
	private function receive_msg($data = array()){
		$MsgType = strtolower($data['MsgType']);
		$insertData = array();
		$insertData['type'] = 0;
		$insertData['from'] =$data['FromUserName'];
		$insertData['to'] =$data['ToUserName'];
		$insertData['create_time'] =$data['CreateTime'];

		//更新用户未读消息数
		$where = array('openid'=>$data['FromUserName']);
		M('wechat_users')->where($where)->setInc('no_read_msg',1);
		switch($MsgType){
			case 'text':
				$insertData['type'] =1;
				$insertData['content'] =$data['Content'];
				$insertData['MsgId'] =$data['MsgId'];
				break;
			case 'image':
				$insertData['type'] =2;
				$insertData['content'] = $data['PicUrl'];
				$insertData['MediaId'] = $data['MediaId'];
				$insertData['MsgId'] = $data['MsgId'];
				$insertData['create_time'] = $data['CreateTime'];
				//保存图片到本地
				$save_path = $data['FromUserName'].'/image';
				$insertData['MediaLoc'] = $this->get_temp_material( $data['MediaId'],$save_path);
				break;
			case 'voice':
				$insertData['type'] =3;
				$insertData['content'] = $data['Recognition'] ? $data['Recognition'] : '';
				$insertData['MediaId'] = $data['MediaId'];
				$insertData['MsgId'] = $data['MsgId'];
				$insertData['otherInfo'] = $data['Format'];
				$insertData['create_time'] = $data['CreateTime'];
				//保存到本地
				$save_path = $data['FromUserName'].'/voice';
				$insertData['MediaLoc'] = $this->get_temp_material( $data['MediaId'],$save_path);
				break;
			case 'video':
				$insertData['type'] =4;
				$insertData['MediaId'] = $data['MediaId'];
				$insertData['MsgId'] = $data['MsgId'];
				$insertData['otherInfo'] = $data['ThumbMediaId'];
				$insertData['create_time'] = $data['CreateTime'];
				//保存到本地
				$save_path = $data['FromUserName'].'/video';
				$insertData['MediaLoc'] = $this->get_temp_material( $data['MediaId'],$save_path);
				break;
			case 'shortvideo':
				$insertData['type'] =5;
				$insertData['MediaId'] = $data['MediaId'];
				$insertData['MsgId'] = $data['MsgId'];
				$insertData['otherInfo'] = $data['ThumbMediaId'];
				$insertData['create_time'] = $data['CreateTime'];
				//保存到本地
				$save_path = $data['FromUserName'].'/shortvideo';
				$insertData['MediaLoc'] = $this->get_temp_material( $data['MediaId'],$save_path);
				break;
			case 'location':
				$insertData['type'] =6;
				$insertData['content'] = $data['Label'];
				$insertData['MsgId'] = $data['MsgId'];
				$insertData['otherInfo'] = $data['Location_X'].'_'.$data['Location_Y'].'_'.$data['Scale'];
				$insertData['create_time'] = $data['CreateTime'];
				break;
			case 'link':
				$insertData['type'] =7;
				$insertData['content'] =$data['Url'];
				$insertData['MsgId'] =$data['MsgId'];
				$insertData['otherInfo'] = serialize(array('Title'=>$data['Title'],'Description'=>$data['Description']));
				break;
			default :
				break;
		}
		if($insertData['type']>0){
			M('wechat_message')->add($insertData);
		}
	}
}
