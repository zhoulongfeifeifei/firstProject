<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {

	public function __construct(){
		parent::__construct();	
		if(!session('openid') && $this->is_weixin()){
			$this->get_web_openid();
		}
		$this->get_wechat_sign();
	}

	/**
	* 判断是否是微信打开
	*/
	private function is_weixin(){ 
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}  
		return false;
	}

	/**
	* 获取微信 js-sdk 签名
	*/
	private function get_wechat_sign(){
		$url = $this->get_now_url();
		$noncestr = createNonceStr();
		$timestamp = time();
		$jsapi_ticket = $this->get_wechat_ticket();
		$str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url;
		$sign = sha1($str);

		$this->assign('timestamp',$timestamp);
		$this->assign('noncestr',$noncestr);
		$this->assign('sign',$sign);
		$this->assign('openid',session('openid'));
	}

	/**
	* 获取js－sdk  ticket
	*/
	private function get_wechat_ticket(){
		$wechat_ticket = file_get_contents('./wechat_ticket.txt');
		$info = unserialize($wechat_ticket);
		
		if($info && $info['ticket_time']>time()){
			return $info['ticket'];
		}else{
			$api = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_access_token().'&type=jsapi';
			$res = json_decode(httpRequired($api),true);
			if($res['errcode']==0){
				$res['ticket_time'] = time()+7100;
				file_put_contents('./wechat_ticket.txt', serialize($res));
				return $res['ticket'];
			}
		}
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
	* 获取当前url
	*/
	private function get_now_url() {
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		return $url;
	}

	/**
	* 获取进入页面的openid
	*/
	protected function get_web_openid(){
		$wechat_code = I('get.code','','trim');
		$set_state = I('get.state','','trim');
		if($wechat_code){
			$openid = session('openid');
			if(!$openid){
				$openid = $this->get_web_access_token($wechat_code);
			}
			//加载头部
			return $openid;
		}else{
			$this->wechat_allow();
		}
	}

	/**
	* 获取网页微信信息
	* @param $code  授权返回的code
	*/
	private function get_web_access_token($code=''){
		if(!$code){
			$this->wechat_allow();
		}
		$openid = '';
		$appid = C('APPID');
		$app_secret = C('APP_SECRET');
		$api = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$app_secret.'&code='.$code.'&grant_type=authorization_code ';
		$res = json_decode(httpRequired($api),true);
		if($res['openid']){
			session('openid',$res['openid']);
			$openid =  $res['openid'];
		}
		return $openid;
	}

	/**
	* 微信授权
	*/
	private function wechat_allow($state=''){
		$appid = C('APPID');
		$redirect_uri = urlencode($this->get_now_url());
		$scope = 'snsapi_base';
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=$state#wechat_redirect";
		header('Location: ' . $url);
	}

}