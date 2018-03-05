<?php
namespace Api\Controller;
use Think\Controller;
class BaseController extends Controller {

	public function __construct(){
		parent::__construct();	
	}

	/**
	*检查是否认证
	*/
	public function check_authentification(){
		$openid = I('param.openid','','trim');
		//检查是否认证
		$UsersModel = D('users');
		$condition = array(
			'is_checked'=>1,
			'openid'=>$openid,
		);
		$info = $UsersModel->get_users_info($condition);
		if(!$info || !$openid){
			$result['status'] = -1;
			$result['msg'] = '账号未认证！';
			$WechatUsers = M('wechatUsers')->where(array('openid'=>$openid))->find();
			$result['avatar'] = !empty($WechatUsers) ? $WechatUsers['headimgurl'] : '';
			$this->return_json($result);
		}
		return $info;
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
	* 返回数据
	*/

	protected function return_json($result){
		$callbackfunc = I('param.Callback','','trim');
		if($callbackfunc){
			die($callbackfunc.'('.json_encode($result).')');
		}else{
			//处理跨域 
			header("Access-Control-Allow-Origin:*");
			die(json_encode($result));
		}
	}
}
