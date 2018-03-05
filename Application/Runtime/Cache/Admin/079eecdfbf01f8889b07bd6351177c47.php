<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>管理系统</title>

	<link href="/Static/plugins/Jui/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Static/plugins/Jui/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Static/plugins/Jui/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="/Static/plugins/Jui/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="/Static/plugins/Jui/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lte IE 9]>
<script src="js/speedup.js" type="text/javascript"></script>
<![endif]-->

<script src="/Static/plugins/Jui/js/jquery-1.7.2.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/js/jquery.validate.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/xheditor/xheditor-1.2.1.min.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

<!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
<script type="text/javascript" src="/Static/plugins/Jui/chart/raphael.js"></script>
<script type="text/javascript" src="/Static/plugins/Jui/chart/g.raphael.js"></script>
<script type="text/javascript" src="/Static/plugins/Jui/chart/g.bar.js"></script>
<script type="text/javascript" src="/Static/plugins/Jui/chart/g.line.js"></script>
<script type="text/javascript" src="/Static/plugins/Jui/chart/g.pie.js"></script>
<script type="text/javascript" src="/Static/plugins/Jui/chart/g.dot.js"></script>

<script src="/Static/plugins/Jui/bin/dwz.min.js" type="text/javascript"></script>
<script src="/Static/plugins/Jui/js/dwz.regional.zh.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	DWZ.init("/Static/plugins/Jui/dwz.frag.xml", {
		loginUrl:"<?php echo '/admin/index/login';?>", loginTitle:"登录",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		keys: {statusCode:"statusCode", message:"message"}, //【可选】
		ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/Static/plugins/Jui/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});

function logout(){
	if(confirm("您要退出系统吗？")){
		location.href="<?php echo '/admin/index/loginout';?>";
		return;
	}
}
</script>
</head>

<body scroll="no">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo">标志</a>
				<ul class="nav">
					<li><a href="javascript:void(0);">欢迎</a></li>
					<li><a href="javascript:logout();">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
					<li theme="default"><div class="selected">蓝色</div></li>
					<li theme="green"><div>绿色</div></li>
					<li theme="purple"><div>紫色</div></li>
					<li theme="silver"><div>银色</div></li>
					<li theme="azure"><div>天蓝</div></li>
				</ul>
			</div>

			<!-- navMenu -->
			
		</div>

		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

				<div class="accordion" fillSpace="sidebar">
				<?php foreach(C('menu') as $menu){?>
					<?php if(checkMenuPermission($menu['rel'])){?>
					<div class="accordionHeader">
						<h2><span>Folder</span><?php echo $menu['name'];?></h2>
					</div>
					<div class="accordionContent">
						<ul class="tree treeFolder">
						<?php foreach($menu['lists'] as $value){?>
							<?php if(checkMenuPermission($value['rel'])){?>
								<li><a href="<?php echo $value['href'];?>" target="navTab" rel="<?php echo $value['rel'];?>" ><?php echo $value['name'];?></a></li>
							<?php }?>
						<?php }?>
						</ul>
					</div>	
					<?php }?>
				<?php }?>
				</div>

			</div>
		</div>
		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent">
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div>
					<div class="tabsRight">right</div>
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">我的主页</a></li>
				</ul>
				<div class="navTab-panel tabsPageContent layoutBox">
					<div class="page unitBox">
						<div class="accountInfo">
							<p><span>欢迎使用管理系统</span></p>
						</div>
						<div class="pageFormContent" layoutH="80" style="margin-right:230px">
							


						<div class="divider"></div>
						</div>
						
						<div style="width:230px;position: absolute;top:60px;right:0" layoutH="80">
						</div>
					</div>
					
				</div>
			</div>
		</div>

	</div>
</body>
</html>
<script type="text/javascript">
	//实时监测用户发送消息
	clearInterval(receiveMsg);
	var receiveMsg = setInterval(check_receive_msg,4000); 
	//	clearInterval(func);
	function check_receive_msg(){
		var obj = $('.navTab-tab').find('li[tabid=wechat_users]');
		var is_select = obj.attr('class');
		if(is_select=='selected'){
			//禁止加载
			$.ajaxSettings.global=false; 
			$('#users_search_button').click();
		}else{
			console.log(is_select);
		}
	}
</script>