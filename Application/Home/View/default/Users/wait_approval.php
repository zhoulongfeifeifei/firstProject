<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/wait_approval.css"/>
<body>
	<!-- 头部 -->
	<div class="main">
		 <ul class="approval_list">
		 	<li class="wait_approval add_style" type="0" is_load="0">待审批的<span id="wait_num"></span></li>
		 	<li class="access_approval" type="1" is_load="0">已审批的<span id="has_approval"></span></li>
		 	<input type="hidden" value="<?php echo I('get.type',0,'intval');?>" id="web_type"/>
		 </ul>
		 <div class="search">
		 	<input type="search" results placeholder="搜索标题" id="search">
		 </div>
		 
		 <!-- 主题 -->
		 <div class="non-wait content" id='wait_content'>
		 	<!-- 等待审批列表 -->
		 	<div class="wait_on_list"> 
			 	<!-- <div class="wait_on">
					<ul>
						<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait'></li>
						<li class="wait_on_infor">
							<p>罗小超的请假</p>
							<a href="javascript:;">待审批</a>
						</li>
						<li class="wait_on_time">周一 14:22</li>
					</ul>
				</div> -->
			</div>
		 </div>
		 <div class="non-wait content" id="other_content">

		 	<!-- 我已审批的 -->
			<div class="access_list">
			<!--
				<div class="wait_on">
					<ul>
						<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait'></li>
						<li class="wait_on_infor">
							<p>罗小益的请假</p>
							<span class="wait_on_over">审批完成<em>(同意)</em></span>
						</li>
						<li class="wait_on_time">周一 14:22</li>
					</ul>
				</div>
				<div class="wait_on">
					<ul>
						<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait'></li>
						<li class="wait_on_infor">
							<p>罗小益的请假</p>
							<span class="wait_on_over">审批完成<em>(拒绝)</em></span>
						</li>
						<li class="wait_on_time">周一 14:22</li>
					</ul>
				</div>
			-->
			</div>
		</div>
		 
		 	 
		 
		 
	 </div>
	 	
	 
</body>
<script type="text/javascript" src="/Static/js/home/wait_approval.js"></script>
<block name="include"><include file="Common:footer" /></block>