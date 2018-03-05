<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	/**
	*首页
	*/
	public function index(){
		$result = array();
		$this->check_authentification();
		$weekArr = array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');

		//获取轮播图
		$AdvertModel = D('advert');
		$result['status'] =1;
		$filed = 'name,desc,img,ext,skip_content';
		$slider_lists = $AdvertModel->get_advert_lists(array('type'=>1,'status'=>1),$filed);
		foreach($slider_lists as &$val){
			$val['img'] = $val['img'].'.'.$val['ext'];
		}

		$result['now_date'] = date('Y年m月d日',time());
		$result['week'] = $weekArr[date('N',time())-1];
		$result['now_time'] = date('H:i',time());
		//导航
		$nav_lists = $AdvertModel->get_advert_lists(array('type'=>2,'status'=>1),$filed);

		foreach($nav_lists as &$value){
			$value['img'] = $value['img'].'.'.$value['ext'];
		}
		$result['slider_lists'] = $slider_lists;
		$result['nav_lists'] = $nav_lists;
		$this->return_json($result);
	}

	/**
	*用户认证
	*/

	public function authentification(){
		$result = array();
		$status = 0;
		$errorMsg = '';
		$name = I('post.name','','trim');
		$mobile = I('post.mobile','','trim');
		$code = I('post.code','','trim');
		$ag_ids = I('post.ag_ids','','trim');
		$openid =  I('post.openid','','trim');
		if(!$openid){
			$errorMsg = '请在微信端操作！';
		}else{
			$UsersModel = D('users');
			$user_info = $UsersModel->get_users_info(array('name'=>$name));
			if(!$user_info){
				$errorMsg = '用户不存在！';
			}else{
				//获取验证码
				$SmsLogModel = D('smsLog');
				$log = $SmsLogModel->get_smslog_info(array('user_id'=>$user_info['id'],'mobile'=>$mobile,'code'=>$code,'type'=>0));
				if(!$log){
					$errorMsg = '验证码错误！';
				}else if($log['create_time']+36000<time()){
					$errorMsg = '验证码已过期！';
				}else{
					//验证机构
					$agArr = explode(',', $ag_ids);
					$AgencyUsersModel = D('agencyUsers');
					$agencyLists = $AgencyUsersModel->get_agency_users_lists(array('user_id'=>$user_info['id'],'status'=>1));
					foreach($agencyLists as $value){
						$nowArr[]=$value['ag_id'];
					}
					foreach($agArr as $v){
						if($v){
							if(!in_array($v,$nowArr)){
								$errorMsg = '您选择的机构不符合！';
							}
						}
					}

					if(!$errorMsg){
						//通过验证
						$upData = array(
							'is_checked'=>1,
							'openid'=>$openid,
							'update_time'=>time(),
						);
						$where = array('id'=>$user_info['id']);
						if($UsersModel->update_users($where,$upData)){
							$status = 1;
							$errorMsg = '认证成功！';
						}
					}
				}
			}
		}
		$result['status'] =$status;
		$result['msg'] = $errorMsg;
		$this->return_json($result);
	}


	/**
	* 获取机构列表
	* @param $name  搜索时候名称 
	* @param $page  当前页码 默认1
	*/

	public function get_agency_lists(){
		$result = array();
		$status = 0;
		$name = I('post.name','','trim');
		//可用
		$condition = array('status'=>1);
		//搜索
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}
		$per_page = C('PER_PAGE');
		$page = I('post.page',1,'intval');
		$offset = ($page - 1 ) * $per_page;

		$AgencyModel = D('agency');
		$field = 'id,name';
		$lists = $AgencyModel->get_agency_lists($condition,$field,$offset,$per_page);
		$result['status'] =1;
		$result['lists'] = $lists;
		$this->return_json($result);
	}


	/**
	*发送验证码
	* @param $mobile 手机号码
	* @param $name 姓名
	*/

	public function send_sms(){
		$result = array();
		$status = 0;
		$name = I('post.name','','trim');
		$mobile = I('post.mobile','','trim');

		$ckmobile = preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|170[0-9]{8}$|14[0-9]{1}[0-9]{8}$/",$mobile);
		if(!$ckmobile){
			$errorMsg = '手机号码格式错误！';
		}else{
			$UsersModel = D('users');
			$user_info = $UsersModel->get_users_info(array('name'=>$name));
			if(!$user_info){
				$errorMsg = '用户不存在！';
			}else{
				$AgencyUsersModel = D('agencyUsers');
				$ckinfo = $AgencyUsersModel->get_agency_users_info(array('user_id'=>$user_info['id']));
				if(!$ckinfo || $ckinfo['mobile'] !=$mobile || $ckinfo['tel_phone'!= $mobile]){
					$errorMsg = '用户信息不匹配！';
				}else{
					//用户是否认证
					if($user_info['is_checked']==1){
						$errorMsg = '该用户已经认证！';
					}else{
						//检查是否发送验证码
						$SmsLogModel = D('smsLog');
						$log = $SmsLogModel->get_smslog_info(array('user_id'=>$user_info['id'],'mobile'=>$mobile,'type'=>0));
						if($log && $log['create_time']>=time()-60){
							$errorMsg = '1分钟内不能重复发送1';
						}else{
							$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
							$sendCode = json_encode(array('code'=>$code));
							$res = aliSmsSend($mobile,C('ALIDAYU_SMS_CODE'),$sendCode);
							if($res){
								$logData = array(
									'user_id'=>$user_info['id'],
									'mobile'=>$mobile,
									'content'=>'身份认证',
									'code'=>$code,
									'create_time'=>time(),
								);
								$SmsLogModel->add_smslog($logData);
								$errorMsg = '发送成功！';
								$status = 1;
							}else{
								$errorMsg = '短信发送失败！';
							}
						}
					}
				}
			}
		}
		$result['status'] = $status;
		$result['msg'] = $errorMsg;
		$this->return_json($result);
	}


	/**
	*接口文档
	*/
	public function accument(){
		if(!C('SHOW_API')){
			return;
		}
		$apis = C('api');
		$this->assign('apis',$apis);
		$this->display();
	}

}
