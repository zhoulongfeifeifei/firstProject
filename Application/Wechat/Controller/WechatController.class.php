<?php
namespace Wechat\Controller;
use Think\Controller;
class WechatController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	/**
	* 根据收到消息类型回复数据库消息
	* @param $data 微信返回数据
	* @param $receice_type  接收消息类型 0 文本 1 关注 2 图片 等
	*/

	protected function response_dbinfo($data,$receive_type=0){
		$condition = array(
			'receive_type'=>$receive_type,
			'status'=>1,
		);
		$res = M('wechat_message_revert')->where($condition)->find();
		if($res){
			$ckres = true;
			//关键词回复
			if($receive_type==0){
				$ckres = $this->ckeck_keywords($data,$res);
			}
			if($ckres){
				//图文的时候取出多个
				if($res['revert_type']==6){
					$idsArr = explode(',', $res['material_id']);
					$material_info = array();
					foreach($idsArr as $k=>$v){
						if($k>=7){
							continue;
						}
						$where = array('id'=>$v,'status'=>1);
						$material = M('wechat_material')->where($where)->limit(7)->find();
						if($material){
							$material_info[]=$material;
						}
					}
				}else{
					$where = array('id'=>$res['material_id'],'status'=>1);
					$material_info  = M('wechat_material')->where($where)->find();
				}
				if($material_info){
					//调用数据库配置回复消息
					$this->response_msg_byinfo($res['revert_type'],$material_info,$data);
				}
			}
		}
	}

	/**
	* 根据数据库设置回复消息
	* @param $revert_type  回复消息类型    图文时候数组是多维数组
	* @param  $info  数据库配置
	* @param $data   微信返回信息
	*/

	protected function response_msg_byinfo($revert_type,$info,$data){
		switch($revert_type){
			case 1://文本
				$this->response_text($data,$info['content']);
				break;
			case 2://图片
				if($info['mediaid']){
					//临时素材并且过期
					if($info['end_time']>0 && $info['end_time']<time()){
						break;
					}
					$imgarr = array('MediaId'=>$info['mediaid']);
					$this->response_image($data,$imgarr);
				}
				break;
			case 3://语音
				if($info['mediaid']){
					//临时素材并且过期
					if($info['end_time']>0 && $info['end_time']<time()){
						break;
					}
					$voicearr = array('MediaId'=>$info['mediaid']);
					$this->response_voice($data,$voicearr);
				}
				break;
			case 4://视频
				if($info['mediaid']){
					//临时素材并且过期
					if($info['end_time']>0 && $info['end_time']<time()){
						break;
					}
					$videoarr = array(
						'MediaId'=>$info['mediaid'],
						'Title'=>$info['title'],
						'Description'=>$info['description']
					);
					$this->response_video($data,$videoarr);
				}
				break;
			case 5://音乐
				$musicarr = array(
					'MusicUrl'=>$info['contenturl'],
					'Title'=>$info['title'],
					'Description'=>$info['description'],
					'HQMusicUrl'=>$info['url'],
				);
				$this->response_music($data,$musicarr);
				break;
			case 6:
				//图文处理
			 	$content = array();
				foreach($info as $k=>$v){
					$arr = array();
					$arr['Title'] = $v['title'];
					$arr['Description'] = $v['description'];
					$arr['PicUrl'] = $v['contenturl'];
					$arr['Url'] = $v['url'];
					$content[]=$arr;
				}
				$this->response_link($data,$content);
				break;
		}
	}


	/**
	* 匹配关键词回复
	* @param $data 微信返回信息
	* @param $info 数据库信息
	*/
	protected function ckeck_keywords($data,$info){
		$condition = array(
			'id'=>array('in',$info['keywords_id']),
			'status'=>1,
		);
		$keywordsArr = M('wechat_keywords')->field('words')->where($condition)->select();
		$revertContent = false;
		foreach($keywordsArr as $k=>$v){
			if(strstr($data['Content'], $v['words'])){
				$revertContent = true;
				break;
			}
		}
		return $revertContent;
	}

	/**
	*返回文本信息
	*/
	protected function response_text($data,$content){
		$msg = array(
			'ToUserName'=>$data['FromUserName'],
			'FromUserName'=>$data['ToUserName'],
			'CreateTime'=>time(),
			'MsgType'=>'text',
			'Content'=>$content,
		);
		$xml = arrayToXml($msg);
		echo $xml;
	}

	/**
	*  回复图片
	* @param $data  微信返回数据
	* @param $content 回复内容
	*/
	protected function response_image($data,$imageArray){
		$itemTpl = "<Image>
			<MediaId><![CDATA[%s]]></MediaId>
			</Image>";

		$item_str = sprintf($itemTpl, $imageArray['MediaId']);

		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			$item_str
			</xml>";

		$result = sprintf($xmlTpl, $data['FromUserName'], $data['ToUserName'], time());
		echo $result;
	}

	//回复语音消息
	protected function response_voice($data, $voiceArray){
		$itemTpl = "<Voice>
			<MediaId><![CDATA[%s]]></MediaId>
			</Voice>";

		$item_str = sprintf($itemTpl, $voiceArray['MediaId']);

		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[voice]]></MsgType>
			$item_str
			</xml>";

		$result = sprintf($xmlTpl, $data['FromUserName'], $data['ToUserName'], time());
		echo  $result;
	}

	//回复视频消息
	protected function response_video($data, $videoArray){
		$itemTpl = "<Video>
			<MediaId><![CDATA[%s]]></MediaId>
			<Title><![CDATA[%s]]></Title>
			<Description><![CDATA[%s]]></Description>
			</Video>";

		$item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['Title'], $videoArray['Description']);

		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[video]]></MsgType>
			$item_str
			</xml>";

		$result = sprintf($xmlTpl, $data['FromUserName'], $data['ToUserName'], time());
		echo $result;
	}

	//回复音乐消息
	protected function response_music($data, $musicArray){
		$itemTpl = "<Music>
			<Title><![CDATA[%s]]></Title>
			<Description><![CDATA[%s]]></Description>
			<MusicUrl><![CDATA[%s]]></MusicUrl>
			<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
			</Music>";

		$item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[music]]></MsgType>
			$item_str
			</xml>";

		$result = sprintf($xmlTpl, $data['FromUserName'], $data['ToUserName'], time());
		echo $result;
	}
	/**
	* 回复图文
	* @param $data  微信返回数据
	* @param $content 回复内容
	*/
	public function response_link($data,$content){
		$itemTpl = "<item>
			<Title><![CDATA[%s]]></Title>
			<Description><![CDATA[%s]]></Description>
			<PicUrl><![CDATA[%s]]></PicUrl>
			<Url><![CDATA[%s]]></Url>
			</item>";
		$item_str = "";
		foreach ($content as $item){
			$item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
		}
		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[news]]></MsgType>
			<ArticleCount>%s</ArticleCount>
			<Articles>
			$item_str</Articles>
			</xml>";

		$result = sprintf($xmlTpl, $data['FromUserName'], $data['ToUserName'], time(), count($content));
		echo $result;
	}

	/**
	* 点击菜单处理事件
	*/

	protected function menu_click($data){
		$EventKey = $data['EventKey'];
		if($EventKey=='nowtime'){
			$content = '现在是北京时间：'.date('Y-m-d H:i:s',time());
			$this->response_text($data,$content);
		}else{
			$content = '正在研发中，敬请期待～';
			$this->response_text($data,$content);
		}
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
