<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/leave_detail.css"/>
<body>
   	<div class="main">
		<!-- 请假头部 -->
		<div class="leave_header">
		<!--
			<ul>
				<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait'></li>
				<li class="head_name">
					<p>罗小超</p>
					<a href="#">等待我审批</a>
				</li>
			</ul>
			-->
		</div>
		<ul class="leave_list">
		<!--
			<li>所在机构：<span>星洲琴行(德胜店)</span></li>
			<li>请假类型：<span>事假</span></li>	
			<li>开始时间：<span>2016-12-05</span></li>
			<li>结束时间：<span>2016-12-06</span></li>
			<li>请假天数：<span>1</span></li>
			<li>请假是由：<span>外出</span></li>
		-->
		</ul>
		<!-- 中间过程 -->
		<div class="content">
		<!--
			<div class="content_left">
				<img src="/Static/images/home/Sp_complete.png" alt="" class="complete_img">
			</div>
			<div class="content_right">
				<ul>
					<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait1'></li>
					<li class="content_head_name">
						<p>罗小超</p>
						<a href="#">等待我审批</a>
					</li>
					<li class="content_time">2016.12.05 13:42</li>
				</ul>
			</div>	
			<div class="load_on"></div>
-->
			<!-- 审批中 -->
<!--
			<div class="content_left">
				<img src="/Static/images/home/Sp_wait.png" alt="" class="complete_img">
			</div>
			<div class="content_right">
				<ul>
					<li><img src="/Static/images/home/Id_head_default.png" alt="" class='head_portrait1'></li>
					<li class="content_head_name">
						<p>罗小益</p>
						<a href="#">审批中<span class="sign_in_access">(情况属实)</span></a>
					</li>
					<li class="content_time">2016.12.05 13:42</li>
				</ul>
			</div>	
			-->
		</div>
	
		<!-- 底部按钮 -->
		<div class="btn">
			<span id='btn-agree' type="1">同意</span>
			<span id='btn-reject' type="2">拒绝</span>
			<span id='btn-repeal' type="3">撤销</span>
		</div>
	</div>	
	<div class="access">
		<img src="/Static/images/home/Sp_adopt.png" alt="">
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/leave_detail.js"></script>
<block name="include"><include file="Common:footer" /></block>