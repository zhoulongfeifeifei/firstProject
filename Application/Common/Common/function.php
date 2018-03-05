<?php

/*
随机字符床
*/
function createNonceStr($length = 16) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for ($i = 0; $i < $length; $i++) {
		$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
}

function replaceEmoji($str=''){
	$emoji = C('EMOJI_CODE');
	$emoji_url = C('EMOJI_URL');
	foreach($emoji as $k=>$v){
		if(strstr($str, $v)){
			$url = '<img src="'.$emoji_url.$k.'.gif" width="20px" height="20px" />';
			$str = str_replace($v, $url, $str);
		}
	}
	return $str;
}
//curl 获取文件数据
function curlFile($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_NOBODY, 0);//只取body头
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//curl_exec执行成功后返回执行的结果；不设置的话，curl_exec执行成功则返回true
	$output = curl_exec($ch);
	$headerSize = curl_getinfo($ch,CURLINFO_HEADER_SIZE); 
	$header = substr($output, 0, $headerSize);
	$patt = '/filename=\"(.+)\"/';
	preg_match($patt, $header, $res);
	$file_name = $res[1];
	curl_close($ch);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_NOBODY, 0);//只取body头
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//curl_exec执行成功后返回执行的结果；不设置的话，curl_exec执行成功则返回true
	$output = curl_exec($ch);
	curl_close($ch);
	return array('content'=>$output,'filename'=>$file_name);
}

/**
* 保存图片
* @param $src_file  图片地址
* @param $filename  图片保存路径文件夹名
*/
function dealUploadImg($src_file='',$filename='system'){
	if(!$src_file){
		return ;
	}
	$file=dirname(APPPATH).$src_file;
	$ext = '';
	$base_name = '';
	if($img_info = @getimagesize($file)){
		$ext = $img_info['mime'];
		$ext = explode('/',$ext);
		$ext = $ext[1];
	}
	$basename=pathinfo($file);
	if($basename){
		$base_name = $basename['dirname'].'/'.$basename['filename'];
	}
	if(file_exists($file)){
		//replace text
		$toFile=str_replace('tmps', $filename, $file);
		$toFileDir=pathinfo($toFile);
		if(!file_exists($toFileDir['dirname'])){
			mkdir($toFileDir['dirname'],0777,true);
		}
		$toFile = dirname($toFile).'/'.$toFileDir['filename'].'.'.$ext;
		rename($file, $toFile);
		$patt = '/'.preg_replace('/\//','\/', dirname(APPPATH)).'/';
		$back_file = trim(preg_replace($patt,' ', $toFile));
		$base_name = $toFileDir['dirname'].'/'.$toFileDir['filename'];
	}
	$base_name = str_replace('./','/',$base_name);
	return array('img'=>$base_name,'ext'=>$ext);
}

function moveMaterial($src_file = '',$pathinfo=''){
	$file=dirname(APPPATH).$src_file;
	$basename=pathinfo($file);
	$toFile ='';
	if(file_exists($file)){
		//replace text
		$toFile=str_replace('tmps', $pathinfo, $file);
		$toFileDir=pathinfo($toFile);
		if(!file_exists($toFileDir['dirname'])){
			mkdir($toFileDir['dirname'],0777,true);
		}
		$toFile = dirname($toFile).'/'.$toFileDir['basename'];
		rename($file, $toFile);
	}
	return $toFile;
}

function deleteThumbImg($imgs_size=array(),$basename='',$ext=''){
	if(empty($imgs_size) || empty($basename)){
		return false;
	}
	foreach($imgs_size as $size){
		$file_name = $basename.'.'.$ext;
		if(file_exists($file_name)){
			@unlink($file_name);
		}
		$file_name = $basename.'_'.$size[0].'x'.$size[1].'.'.$ext;
		if(file_exists($file_name)){
			@unlink($file_name);
		}
		$file_name = $basename.'_'.$size[0].'x'.$size[1].'_3g.'.$ext;
		if(file_exists($file_name)){
			@unlink($file_name);
		}
	}
}

/**
*图片处理
* @param $imgs_size  多个数组  array(x,y,t)  x 宽  y高  t 类型  －－－0缩放  1 裁剪
*@param  $imgs  图片地址
*/
function thumbImg($imgs_size=array(),$imgs=''){
	if(!$imgs || empty($imgs_size) || !file_exists($imgs) ){
		return false;
	}

	$new_file_path=dirname($imgs);
	$path_info = @pathinfo($imgs);
	$new_file_path = $new_file_path.'/'.$path_info['filename'];
	$img_info = @getimagesize($imgs);

	$ext = $img_info['mime'];
	$ext = explode('/',$ext);
	$ext = $ext[1];
	$func = 'imagecreatefrom'.$ext;
	$src_img = $func($imgs);
	$s_w = imagesx($src_img);
	$s_h = imagesy($src_img);
	$savefunc = 'image'.$ext;
	foreach($imgs_size as $size){
		$type = $size[2];
		$dst_w = $size[0];
		$dst_h = $size[1];
		$filename = '_'.$dst_w.'x'.$dst_h.'.'.$ext;
		$low_name = '_'.$dst_w.'x'.$dst_h.'_3g.'.$ext;
		$pass_low_name = '_'.$dst_w.'x'.$dst_h.'_3g.jpg';

		if(file_exists($new_file_path.$filename) && file_exists($new_file_path.$low_name)){
			continue;
		}
		$c_w=0;
		$c_h =0;
		$p_s_x = 0;//开始位置
		$p_s_y = 0;
		$p_d_x=0;//目标位置
		$p_d_y=0;
		$code = 0 ;//等比缩放留白
		if($type==0){
			if($dst_h==0 && $dst_w){
				if($s_w<$dst_w){
					$c_w=$s_w;
					$c_h=$s_h;
					$dst_w=$s_w;
					$dst_h=$s_h;
				}else{
					//按照w等比缩放
					$p = $dst_w/$s_w;
					$c_w = $dst_w;
					$c_h = intval($s_h*$p);
					$dst_h=$c_h;
				}
			}else if($dst_w==0 && $dst_h){
				$p = $dst_h/$s_h;
				$c_h = $dst_h;
				$c_w = intval($s_w*$p);
				$dst_w=$c_w;
			}else if($dst_w && $dst_h){
				$w_ratio = 0 ;
				$h_ratio = 0;
				
				$w_ratio = $dst_w/$s_w;
				$h_ratio = $dst_h/$s_h;
			
				$ratio = min($w_ratio,$h_ratio);
				if($w_ratio ==0 && $h_ratio !=0){
					$ratio = $h_ratio;
				}
				if($w_ratio !=0 && $h_ratio ==0){
					$ratio = $w_ratio;
				}

				$c_w = intval($s_w*$ratio);
				$c_h = intval($s_h*$ratio);
				if($c_w<$dst_w){
					$p_d_x = intval(($dst_w-$c_w)/2);
				}
				if($c_h<$dst_h){
					$p_d_y = intval(($dst_h-$c_h)/2);
				}
				$code =1;
			}
			if($c_w && $c_h){
				if($code==1){
					$pass_img = imagecreatetruecolor($c_w,$c_h);
					$new_img = imagecreatetruecolor($dst_w,$dst_h);
					$white = ImageColorAllocate($new_img,255,255,255);
					imagefill($pass_img,0,0,$white);
					imagefill($new_img,0,0,$white);
					imagecopyresampled($pass_img,$src_img,0,0,0,0,$c_w,$c_h,$s_w,$s_h);
					imagecopy($new_img,$pass_img,$p_d_x,$p_d_y,$p_s_x,$p_s_y,$c_w,$c_h);
					
				}else{
					$new_img = imagecreatetruecolor($c_w,$c_h);
					$white = ImageColorAllocate($new_img,255,255,255);
					imagefill($new_img,0,0,$white);
					imagecopyresampled($new_img,$src_img,$p_d_x,$p_d_y,$p_s_x,$p_s_y,$dst_w,$dst_h,$s_w,$s_h);
				}
				$savefunc($new_img,$new_file_path.$filename);
				if($ext!='jpeg'){
					imagejpeg($new_img,$new_file_path.$pass_low_name,20);
					@rename($new_file_path.$pass_low_name,$new_file_path.$low_name);
				}else{
					$savefunc($new_img,$new_file_path.$low_name,30);
				}
			}
		}else if($type==1){
			$w_ratio = 0 ;
			$h_ratio = 0;
			
			$w_ratio = $dst_w/$s_w;
			$h_ratio = $dst_h/$s_h;
		
			$ratio = max($w_ratio,$h_ratio);
			if($w_ratio ==0 && $h_ratio !=0){
				$ratio = $h_ratio;
			}
			if($w_ratio !=0 && $h_ratio ==0){
				$ratio = $w_ratio;
			}

			$c_w = intval($s_w*$ratio);
			$c_h = intval($s_h*$ratio);
			if($c_w>$dst_w){
				$p_d_x = intval(($c_w-$dst_w)/2);
			}
			if($c_h>$dst_h){
				$p_d_y = intval(($c_h-$dst_h)/2);
			}
		
			$pass_img = imagecreatetruecolor($c_w,$c_h);
			$new_img = imagecreatetruecolor($dst_w,$dst_h);
			$white = ImageColorAllocate($new_img,255,255,255);
			imagefill($pass_img,0,0,$white);
			imagefill($new_img,0,0,$white);
			imagecopyresampled($pass_img,$src_img,0,0,0,0,$c_w,$c_h,$s_w,$s_h);

			imagecopy($new_img,$pass_img,$p_s_x,$p_s_y,$p_d_x,$p_d_y,$c_w,$c_h);
			$savefunc($new_img,$new_file_path.$filename);
			if($ext!='jpeg'){
				imagejpeg($new_img,$new_file_path.$pass_low_name,20);
				@rename($new_file_path.$pass_low_name,$new_file_path.$low_name);
			}else{
				$savefunc($new_img,$new_file_path.$low_name,30);
			}
		}
	}
}

/**
* 数组转换成json数据
*/
function arrayToJsonUrlParam($postData){
	return  json_encode($postData,JSON_UNESCAPED_UNICODE);
}


//CURL请求的函数http_request() 
//通过https 中的get 或 post
function httpsRequired($url, $data = null){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if (!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}
/*
array转换xml
*/

function arrayToXml($arr,$code=0){
	$xml='';
	if(!$code){
		$xml = "<xml>";
	}
	foreach ($arr as $key=>$val){		
		if (is_numeric($val)){
			$xml.="<".$key.">".$val."</".$key.">"; 
		}else{
			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
		}
	}
	if(!$code){
		$xml.="</xml>";
	}
	return $xml; 
}

/**
 * 	作用：将xml转为array
 */
function xmlToArray($xml){		
	//将XML转为array        
	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
	return $array_data;
}

/**
 * 	作用：以post方式提交xml到对应的接口url
 */
function postXmlCurl($xml,$url,$second=30){		
	//初始化curl        
	$ch = curl_init();
	//设置超时
	curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	//这里设置代理，如果有的话
	//curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
	//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
	//设置header
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//post提交方式
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	//运行curl
	$data = curl_exec($ch);
	//返回结果
	if($data){
		curl_close($ch);
		return $data;
	}else { 
		$error = curl_errno($ch);
		echo "curl出错，错误码:$error"."<br>"; 
		echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
		return false;
	}
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key.'='.$val.'&';
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
}

/**
 * 发送HTTP请求方法，目前只支持CURL发送请求
 * @param  string $url    请求URL
 * @param  array  $param  GET参数数组
 * @param  array  $data   POST的数据，GET请求时该参数无效
 * @param  string $method 请求方法GET/POST
 * @return array          响应数据
 */
function httpRequired($url, $param, $data = '', $method = 'GET'){
	$opts = array(
		CURLOPT_TIMEOUT        => 30,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => false,
	);

	/* 根据请求类型设置特定参数 */
	$opts[CURLOPT_URL] = $param ? ($url . '?' . $param) : $url;
	
	if(strtoupper($method) == 'POST'){
		$opts[CURLOPT_POST] = 1;
		$opts[CURLOPT_POSTFIELDS] = $data;
		if(is_string($data)){ //发送JSON数据
			$opts[CURLOPT_HTTPHEADER] = array(
				'Content-Type: application/json; charset=utf-8',  
				'Content-Length: ' . strlen($data),
			);
		}
	}

	/* 初始化并执行curl请求 */
	$ch = curl_init();
	curl_setopt_array($ch, $opts);
	$data  = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);

	//发生错误，抛出异常
	if($error) throw new \Exception('请求发生错误：' . $error);

	return  $data;
}

/**
* alidayu  短信发送
*@param $mobile 手机号码
*@param $templateCode 模版ID
* @param  $templateData  模版数据  json数据
*@param $backcode  自定义返回数据
*/
function aliSmsSend($mobile='',$templateCode='SMS_27695091',$templateData='{}',$backcode=''){
	Vendor('alidayu.TopSdk');
	$c = new \TopClient();
	$c->appkey = C('ALIDAYU_APP_KEY');
	$c->secretKey = C('ALIDAYU_APP_SECRET');
	$req = new \AlibabaAliqinFcSmsNumSendRequest();
	$req->setExtend($backcode);
	$req->setSmsType("normal");
	$req->setSmsFreeSignName(C('ALIDAYU_SIGN_NAME'));
	$req->setSmsParam($templateData);
	$req->setRecNum($mobile);
	$req->setSmsTemplateCode($templateCode);
	$resp = $c->execute($req);
	$res = $resp->result->success;
	return $res ? true : false;
}

/**
 * 获取excel文件
 * @param  string $file excel文件路径
 * @return array        excel文件内容数组
 */
function getExcel($file){
	// 判断文件是什么格式
	$type = pathinfo($file); 
	$type = strtolower($type["extension"]);
	
	if( $type =='xlsx' ){
		$type='Excel2007';
	}else{
		$type=$type==='csv' ? $type : 'Excel5';
	}
	ini_set('max_execution_time', '0');
	Vendor('PHPExcel.PHPExcel');
	// 判断使用哪种格式
	$objReader = \PHPExcel_IOFactory::createReader($type);
	$objPHPExcel = $objReader->load($file); 
	$sheet = $objPHPExcel->getSheet(0); 
	// 取得总行数 
	$highestRow = $sheet->getHighestRow();     
	// 取得总列数      
	$highestColumn = $sheet->getHighestColumn(); 
	//循环读取excel文件,读取一条,插入一条
	$data=array();
	//从第一行开始读取数据
	for($j=1;$j<=$highestRow;$j++){
		//从A列读取数据
		for($k='A';$k<=$highestColumn;$k++){
			// 读取单元格
			$data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
		} 
	}  
	return $data;
}

/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
 */
function loadExcel($data,$filename='simple.xls'){
	ini_set('max_execution_time', '0');
	Vendor('PHPExcel.PHPExcel');
	$filename=str_replace('.xls', '', $filename).'.xls';
	$phpexcel = new \PHPExcel();

	$phpexcel->getProperties()
		->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
	$phpexcel->getActiveSheet()->fromArray($data);
	$phpexcel->getActiveSheet()->setTitle('Sheet1');
	$phpexcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$phpexcel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=$filename");
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objwriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
	$objwriter->save('php://output');
	exit;
}

?>