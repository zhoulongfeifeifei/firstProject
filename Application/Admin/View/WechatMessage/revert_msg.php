<style type="text/css">
	.send_btn{
		width:60px;
		height:111px;
		font-size:30px;
		float:left;
	}
	.send_btn input{
		margin-top: 80px;
		margin-left:5px;
		width:55px;
		height:30px;
		border:1px solid #1CAF9A;
		background: #1CAF9A;
		border-radius: 5px;
		color:#fff;
	}

	.send_content{
		float:left;
		padding:5px;
		font-size:14px;
		width:88%;
		height:100px;
		border:1px solid #ccc;
		background:#fff;
		overflow: auto;
	}
	.emojiBar{
		width:418px;
		height:185px;
		border:1px solid #EDEDED;
		position: fixed;
	}
	.emojiBar li{
		float:left;
		list-style-type: none;
		border:1px solid #EDEDED;
	}
	.emojiBar img{
		width:24px;
		height:24px;
	}
	#msg_lists{
		width:100%;
		height:290px;
		overflow: auto;
	}
	#msg_lists li{
		width:100%;
	}
	.msg_time{
		width:100%;
		height:18px;
	}
	.msg_time div{
		width:70px;
		height:18px;
		text-align: center;
		line-height: 18px;
		color:#bbb;
		background:#EDEDED;
		border-radius: 5px;
	}
	.msg_info{
		width:80%;
		margin-bottom:10px;
	}
	.headerimg{
		width:30px;
		height:30px;
		padding:5px;
	}
	.msg_content{	
		width:90%;
		margin:5px;
	}
	.floatLeft{
		float:left;
	}
	.floatLeft p{
		line-height: 20px;
		font-size: 14px;
		text-align: left;
	}
	.floatRight{
		float:right;
	}
	.floatRight p{
		line-height: 20px;
		font-size: 14px;
		text-align: right;
	}
	#material{
		width:510px;
		border:1px solid #ccc;
		background:#EBEFF4;
		position: fixed;
	}
	#material li{
		width:80px;
		float:left;
		margin:5px;
		list-style-type: none;
	}
	#material li img{
		width:80px;
		height:80px;
	}
	#material li video{
		width:80px;
		height:80px;
	}
	#material li audio{
		width:80px;
		height:60px;
	}
	#searchMaterial{
		width:50px;
		height:25px;
		margin-left:10px;
		background:#1CAF9A;
		border:1px solid #1CAF9A;
		color:#fff;
		border-radius: 5px;
	}

	#sendMaterial{
		width:80px;
		height:25px;
		margin-left:10px;
		background:#1CAF9A;
		border:1px solid #1CAF9A;
		color:#fff;
		border-radius: 5px;
	}
	.topage{
		width:12px;
		height:70px;
		float:left;
		font-size:20px;
		color:#999;
		padding-top:40px;
		margin-left:10px;
		background:#dddddd;
		border:1px solid #dddddd;
	}
	#nonepage{
		width:12px;
		height:70px;
		float:left;
		font-size:20px;
		color:#999;
		padding-top:40px;
		margin-left:10px;
	}
	.img_text{
		height:18px;
		line-height: 18px;
		overflow: hidden;
	}
	.revert_news{
		width:220px;
		float:right;
	}
	.revert_news li{
		list-style-type: none;
	}
	.revert_news li p{
		line-height: 32px;
		font-size: 14px;
		width:220px;
		text-align: left;
		height:32px;
		overflow: hidden;
		background:rgba(0,0,0,0.7);
		color:#fff;
	}
	.news_li span{
		height:50px;
		line-height: 25px;
		width:170px;
		float:left;
		font-size: 14px;
		overflow: hidden;
	}
	.news_li img{
		float:right;
	}
	.news_info{
		font-size:12px;
		color:#aaa;
		line-height: 20px;
	}
</style>
<div class="pageContent">
	<div  id="msg_lists" >
		<div id="main">
			<?php foreach($message as $key=>$value){?>
				<?php 
					if($value['from_type'] ==1){
						$material_info = D('wechat_material')->get_material_info(array('id'=>$value['content']));
					}

					switch($value['type']){
						case 1:
							$content = replaceEmoji($value['content']);
							break;
						case 2:
							$content = '<img src="'.$value['medialoc'].'" height="120px" />';
							if($value['from_type'] ==1){//图片
								$content = '<img src="'.trim($material_info['contenturl'],'.').'" height="120px" />';
							}
							break;
						case 3:
							$content = '<audio controls="controls" height="40px"><source src="'.trim($value['medialoc'],'.').'" />无法播放</audio>';
							if($value['from_type'] ==1){ //语音
								$content = '<audio controls="controls" height="40px"><source src="'.trim($material_info['contenturl'],'.').'" />无法播放</audio>';
							}
							break;
						 case 4:
						 case 5:
							 $content = '<video src="'.trim($value['medialoc'],'.').'" controls="controls" height="180px">加载失败或者资源错误</video>';
							 if($value['from_type'] ==1){ //视频
							 	$content='<div style="float:right">';
							 	$content.='<div>'.$material_info['title'].'</div>';
							 	$content.='<div class="news_info">'.date('Y-m-d H:i:s',$material_info['create_time']).'</div>';
								$content.= '<video src="'.trim($material_info['contenturl'],'.').'" controls="controls" height="180px">加载失败或者资源错误</video>';
								$content.='<div class="news_info" style="margin:10px 0px;width:240px;">'.$material_info['description'].'</div>';
								$content.='</div>';
							}
							 break;
						 case 6:
							$content = '地理位置：'.$value['content'];
							if($value['from_type'] ==1){ //图文
							 	$material_info = D('wechat_material')->get_material_list(array('id'=>array('in',trim($value['content'],','))));
							 	$content = '<ul class="revert_news">';
							 	$cnt = count($material_info);
							 	if($cnt==1){
							 		$news = $material_info[0];
							 		$content.='<li><div>'.$news['title'].'</div>';
							 		$content.='<div class="news_info">'.date('Y-m-d H:i:s',$news['create_time']).'</div>';
							 		if($news['contenturl']){
							 			$content.='<img src="'.$news['contenturl'].'" width="220px;" height="120px"/>';
							 		}
							 		$content.='<div class="news_info">'.$news['description'].'</div>';

							 		$content.='</li>';
							 	}else{
								 	foreach($material_info as $k=>$v){
								 		if($k==0){
								 			$content.= '<li><a href="'.$v['url'].'" target="_blank"><img src="'.$v['contenturl'].'" width="220px;" height="120px"/><p>'.$v['title'].'</p></a></li>';
								 		}else{
								 			$content.='<li class="news_li"><a href="'.$v['url'].'" target="_blank"><span>'.$v['title'].'</span><img src="'.$v['contenturl'].'" width="40px;" height="40px;"/></a></li>';
								 		}
								 	}
								 }
							 	$content.='</ul>';
							 }
							 break;
						 case 7:
							$otherInfo = unserialize($value['otherinfo']);
							$content = '<a href="'.$value['content'].'" target="_blank"><b>链接：</b>'.$otherInfo['Title'].'</a>';
							break;

					}
					if($value['from']==$info['openid']){
				?>
					<div class="msg_info floatLeft">
						<div class="msg_time"><div class="floatLeft"><?php echo date('m-d H:i',$value['create_time']);?></div></div>
						<img src="<?php echo $info['headimgurl'];?>" class="headerimg floatLeft"/>
						<div class="msg_content floatLeft">
							<p><?php echo $content;?></p>
						</div>
					</div>
					<?php }else{?>
					<div class="msg_info floatRight">
						<div class="msg_time"><div class="floatRight"><?php echo date('m-d H:i',$value['create_time']);?></div></div>
						<img src="#" class="headerimg floatRight"/>
						<div class="msg_content floatRight">
							<p><?php echo $content;?></p>
						</div>
					</div>
				<?php }?>
			<?php }?>	
		</div>
	</div>
	<div class="formBar">
		<ul style="float:left;margin-top:2px;">
			<li>
				<a title="素材" style="color: blue;" id="send_material" type="0" mask="true" class="btnAdd">素材</a>
			</li>
			<li>
				<a title="表情" href="javascript:;" id="emoji_lists" type="0"><img src="https://res.wx.qq.com/mpres/htmledition/images/icon/emotion/0.gif" width="20px;" height="20px"/></a>
			</li>
		</ul>
	</div>
	<div class="emojiBar">
		<ul>
			<li>
				<?php
					for($i=0;$i<105;$i++){
						echo '<li class="emoji_img" img_id="'.$i.'"><img src="https://res.wx.qq.com/mpres/htmledition/images/icon/emotion/'.$i.'.gif" /></li>';
					}
				?>
			</li>
		</ul>
	</div>
	<input type="hidden" name="material_id" id="material_id"/>
	<div class="unit" id="material">
		<label>回复内容(素材)：</label>
		<input type="text" id="searchinput" placeholder="请输入素材名称" size="20" />
		&nbsp&nbsp&nbsp&nbsp
		<select name="materialType" id="materialType">
				<option value="1">文本</option>
				<option value="2">图片</option>
				<option value="3">语音</option>
				<option value="4">视频</option>
				<option value="5">音乐</option>
				<option value="6">图文</option>
			</select>
		<input type="button" value="搜索" id="searchMaterial" />
		&nbsp&nbsp&nbsp&nbsp
		<input type="button" value="确认发送" id="sendMaterial" />
	</div>
	<div>
		<div class="send_content" contentEditable="true"></div>
		<div class="send_btn"><input type="button" value="发送"/></div>
	</div>
	
</div>

<script type="text/javascript">
	var openid = '<?php echo $info["openid"];?>';
	var new_msg_id = '<?php echo $new_msg_id;?>';
	var headerimg = '<?php echo $info["headimgurl"];?>';
	$('#material').hide();
	searchBar();
	sendMaterial();

	$('.send_content').bind('keyup', function(event) {
		if (event.keyCode == "13") {
			$('.send_btn').click();
		}
	});

	$('#'+openid).remove();
	$('.emojiBar').hide();
	var emoji_arr = ["/::)","/::~","/::B","/::|","/:8-)","/::<","/::$","/::X","/::Z","/::'(","/::-|","/::@","/::P","/::D","/::O","/::(","/::+","/:--b","/::Q","/::T","/:,@P","/:,@-D","/::d","/:,@o","/::g","/:|-)","/::!","/::L","/::>","/::,@","/:,@f","/::-S","/:?","/:,@x","/:,@@","/::8","/:,@!","/:!!!","/:xx","/:bye","/:wipe","/:dig","/:handclap","/:&-(","/:B-)","/:<@","/:@>","/::-O","/:>-|","/:P-(","/::'|","/:X-)","/::*","/:@x","/:8*","/:pd","/:<W>","/:beer","/:basketb","/:oo","/:coffee","/:eat","/:pig","/:rose","/:fade","/:showlove","/:heart","/:break","/:cake","/:li","/:bome","/:kn","/:footb","/:ladybug","/:shit","/:moon","/:sun","/:gift","/:hug","/:strong","/:weak","/:share","/:v","/:@)","/:jj","/:@@","/:bad","/:lvu","/:no","/:ok","/:love","/:<L>","/:jump","/:shake","/:<O>","/:circle","/:kotow","/:turn","/:skip","/:oY","/:#-0","/:hiphot","/:kiss","/:<&","/:&>"];
	$('#emoji_lists').click(function(){
		var type = $(this).attr('type');
		if(type==0){
			$('.emojiBar').show();
			$(this).attr('type',1);
		}else{
			$('.emojiBar').hide();
			$(this).attr('type',0);
		}
		document.body.onmousewheel = function(){return false;}
	});
	$('.emojiBar').click(function(){
		$('.emojiBar').hide();
		$('#emoji_lists').attr('type',0);
		document.body.onmousewheel = function(){return true;}
	});
	$('.emoji_img').click(function(){
		var img_id = $(this).attr('img_id');
		var text = $('.send_content').html();
		$('.send_content').text(text+emoji_arr[img_id]);
	});

	$(function(){ 
		$('#msg_lists').scrollTop($('#msg_lists')[0].scrollHeight);
	}); 
		
	$('.maximize').hide();

	//发送消息
	$('.send_btn').click(function(){
		var content = $('.send_content').text();
		content = content.replace(/(^\s*)|(\s*$)/g, ""); 
		if(!content){
			alert('内容不能为空！');
			return;
		}
		$.ajaxSettings.global=false; 
		param = new Object();
		param.content = content;
		param.openid = openid;
		toSendMsg(1,param);
	});

	//发送消息
	function toSendMsg(type,param){
		$.ajax({
			type: "POST",
			url: '/admin/WechatMessage/send_msg?type='+type,
			data: param,
			dataType: "json",
			success: function(data){
				if(data.status){
					var backObj = data.content;
					var contentHtml = '';
					var msg = '<div class="msg_info floatRight">\
							<div class="msg_time"><div class="floatRight">'+data.create_time+'</div></div>\
							<img src="#" class="headerimg floatRight"/>\
							<div class="msg_content floatRight"><p>';
					switch(data.type){
						case 1://文本
							$('.send_content').html('');
							contentHtml = data.content;
							break;
						case 2://图片
							contentHtml = '<img src="'+backObj.contenturl+'" height="120px" />';
							break;
						case 3://语音
							contentHtml = '<audio controls="controls" height="40px"><source src="'+backObj.contenturl+'" />无法播放</audio>';
							break;
						case 4://视频
							var create_time = new Date(parseInt(backObj.create_time) * 1000).toLocaleString().substr(0,17);
							contentHtml='<div style="float:right">';
							contentHtml+='<div>'+backObj.title+'</div>';
							contentHtml+='<div class="news_info">'+create_time+'</div>';
							contentHtml+=  '<video src="'+backObj.contenturl+'" controls="controls" height="180px">加载失败或者资源错误</video>';
							contentHtml+='<div class="news_info" style="margin:10px 0px;width:240px">'+backObj.description+'</div>';
							contentHtml+='</div>';
							break;
						case 5://音乐
							contentHtml = '<span>'+backObj.title+'</span><audio controls="controls" height="40px"><source src="'+backObj.url+'" />无法播放</audio>';
							break;
						case 6://图文
							contentHtml += '<ul class="revert_news">';
							var len = backObj.length;
							if(len==1){
								contentHtml+='<li><div>'+backObj[0].title+'</div>';
								var news_time = new Date(parseInt(backObj[0].create_time) * 1000).toLocaleString().substr(0,17);
								contentHtml+='<div class="news_info">'+news_time+'</div>';
						 		if(backObj[0].contenturl){
						 			contentHtml+='<img src="'+backObj[0].contenturl+'" width="220px;" height="120px"/>';
						 		}
						 		contentHtml+='<div class="news_info">'+backObj[0].description+'</div>';

						 		contentHtml+='</li>';
							}else{
								$(backObj).each(function(i,v){
									if(i==0){
										contentHtml += '<li><a href="'+v.url+'" target="_blank"><img src="'+v.contenturl+'" width="220px;" height="120px"/><p>'+v.title+'</p></li>';
									}else{
										contentHtml+='<li class="news_li"><a href="'+v.url+'" target="_blank"><span>'+v.title+'</span><img src="'+v.contenturl+'" width="40px;" height="40px;"/></a></li>';
									}
								});
							}
							contentHtml += '</ul>';
							break;

					}
					var msgHtml= msg+contentHtml+'</p></div></div>';

					$('#main').append(msgHtml);
					$('#msg_lists').scrollTop($('#msg_lists')[0].scrollHeight);
					new_msg_id = data.msg_id;
					if(param.sendtype ==1){
						$('#material').hide();
						$('#send_material').attr('type',0);
					}
				}else{
					alert(data.msg);
				}
			}
		});
	}

	function get_new_msg(){
		//禁止加载
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/WechatMessage/get_message_byid?msg_id='+new_msg_id,
			data: {openid:openid},
			dataType: "json",
			success: function(data){
				if(data.status){
					$(data.lists).each(function(i,v){
						var msg = '<div class="msg_info floatLeft">\
								<div class="msg_time"><div class="floatLeft">'+v.create_time+'</div></div>\
								<img src="'+headerimg+'" class="headerimg floatLeft"/>\
								<div class="msg_content floatLeft">\
									<p>'+v.content+'</p>\
								</div>\
							</div>';
						$('#main').append(msg);
						$(function(){ 
							$('#msg_lists').scrollTop($('#msg_lists')[0].scrollHeight);
						}); 
						if(v.id){
							new_msg_id = v.id;
						}
					});
				}

			}
		});
	}
	func = setInterval(get_new_msg,2000); 
	$('.close').click(function(){
		clearInterval(func);
	});

	//选择素材
	$('#send_material').click(function(){
		var type = $(this).attr('type');
		if(type==0){
			$('#material').show();
			$(this).attr('type',1);
		}else{
			$('#material').hide();
			$(this).attr('type',0);
		}
		document.body.onmousewheel = function(){return false;}
	});

	$('#material').click(function(){
		$('.material').hide();
		$('#emoji_lists').attr('type',0);
		document.body.onmousewheel = function(){return true;}
	});

	function searchBar(){
		$('#searchMaterial').click(function(){
			var searchval = $('#searchinput').val();
			var type = $('#materialType').val();
			ajax_material(1,searchval,type);
		});
	}


	function ajax_material(page,search,type){
		var html = '<label>回复内容(素材)：</label>';
		var page = parseInt(page);
		//禁止加载
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/WechatMaterial/get_material?type='+type+'&page='+page,
			data: {name:search},
			dataType: "json",
			success: function(data){
				html+='<input type="text" id="searchinput" placeholder="请输入素材名称" size="20" value="'+(data.search ? data.search : '')+'"/>&nbsp&nbsp&nbsp&nbsp';
				html+='&nbsp&nbsp&nbsp&nbsp<select name="materialType" id="materialType">\
	  					<option value="1" '+(data.type==1 ? 'selected' : '')+'>文本</option>\
	  					<option value="2" '+(data.type==2 ? 'selected' : '')+'>图片</option>\
	  					<option value="3" '+(data.type==3 ? 'selected' : '')+'>语音</option>\
	  					<option value="4" '+(data.type==4 ? 'selected' : '')+'>视频</option>\
	  					<option value="5" '+(data.type==5 ? 'selected' : '')+'>音乐</option>\
	  					<option value="6" '+(data.type==6 ? 'selected' : '')+'>图文</option>\
	   				</select>';
				html+='<input type="button" value="搜索" id="searchMaterial" />';
				html+='&nbsp&nbsp&nbsp&nbsp';
				html+='<input type="button" value="确认发送" id="sendMaterial" />';
				if(data.status){
					var node_li = '';
					$(data.lists).each(function(i,v){
						node_li+='<li><input type="checkbox" class="selected_material" value="0"/><input type="hidden" class="chooseval" value="'+v.id+'" />';
						switch(data.type){
							case 1:
								node_li+=''+v.name+'<span class="img_text">'+v.content+'</span></li>';
								break;
							case 2:
								node_li+=''+v.name+'<img src="'+v.contenturl+'" /></li>';
								break;
							case 3:
								node_li+='<span>'+v.name+'</span><audio controls="controls"><source src="'+v.contenturl+'" />无法播放</audio></li>';
								break;
							case 4:
								node_li+='<span>'+v.name+'</span><video src="'+v.contenturl+'" controls="controls" >加载失败或者资源错误</video></li>';
								break;
							case 5:
								node_li+='<span class="img_text" >'+v.title+'</span><audio controls="controls"><source src="'+v.contenturl+'" />无法播放</audio></li>';
								break;
							case 6:
								node_li+='<span class="img_text" >'+v.title+'</span><a href="'+v.url+'" target="_blank"><img src="'+v.contenturl+'"  height="80px"/></a>';
								node_li+=' 排序：<input type="text" size="4" maxlength="4" value="0" name="material_sort['+v.id+']" class="material_sort" /></li>';
								break;
						}
						
					});
					var perpage = '<div id="nonepage">&nbsp</div>';
					var nextpage = '';
					if(page>1){
						perpage = '<div class="topage" page="'+(page-1)+'"><</div>';
					}
					if(!data.last_page){
						nextpage = '<div class="topage" page="'+(page+1)+'">></div>';
					}
					html+='<div class="unit">\
							<label>&nbsp</label>\
							<div>\
								<ul>'+perpage+node_li+nextpage+'</utl>\
							</div>\
						</div>';
					$('#material').html(html);
					searchBar();
					sendMaterial();
					$('.topage').click(function(){
						var searchval = $('#searchinput').val();
						var clickpage = $(this).attr('page');
						var selectType = $('#materialType').val();
						ajax_material(clickpage,searchval,selectType);
					});
					$('.selected_material').click(function(){
						var selectType = $('#materialType').val();
						var selectVal = '';
						var material_html= '';
						if(selectType!=6){
							$('.selected_material').attr('checked',false);
							$(this).attr('checked','checked');
							selectVal = $(this).parent().find('.chooseval').val();
							$('#material_id').val(selectVal);
						}else{
							var cnt = 0;
							$('.selected_material').each(function(i,v){
								var is_sel= $(v).attr('checked');
								if(is_sel){
									cnt++;
									selectVal+= $(v).parent().find('.chooseval').val()+',';
								}
							});
							if(cnt>8){
								alert('图文最多8个！');
							}
							$('#material_id').val(selectVal);
						}
						$('#material_id').attr('materialType',$('#materialType').val());
					});	
				}else{
					html+= '<font color="red">没有素材</font>';
					$('#material').html(html);
					searchBar();
				}
			}
		});
	}

	//发送素材
	function sendMaterial(){
		$('#sendMaterial').click(function(){
			var materialType = $('#material_id').attr('materialType');
			var material_ids = $('#material_id').val();
			if(!material_ids){
				alert('请选择素材！');
				return;
			}
			param = new Object();
			param.openid = openid;
			param.content = material_ids;
			param.sendtype = 1;
			if(materialType==6){
				var sortVal= '';
				$('.selected_material').each(function(i,v){
					var is_sel= $(v).attr('checked');
					var checkval = $(v).parent().find('.chooseval').val();
					if(is_sel){
						sortVal+=checkval+'|'+$(v).parent().find('.material_sort').val()+',';
					}
				});
				param.sort_val = sortVal;
			}
			$.ajaxSettings.global=true; 
			toSendMsg(materialType,param);
		});
	}

</script>