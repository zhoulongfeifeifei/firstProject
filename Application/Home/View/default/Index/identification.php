<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>	
<link rel="stylesheet" href="/Static/css/home/base.css" />
<link rel="stylesheet" href="/Static/css/home/identification.css" />
<body>
	
	<!-- <div class="all-zezhao">
		<h2 class="tishi">提示</h2>
		<div class="zezhao-content">
			<p>意外错误，操作无法完成！请重新输入！请重新输入！</p>
			<div class="zezhao-btn">确定</div>
		</div>
	</div> -->
	<div class="zezhao">
		<div class="tanchu">
	 	<div class="sousuo">
	 		<!-- <img src="/Static/images/home/Id_search_bt.png" alt=""> -->
	 		<input type="search" name="search" results id="search" value="" placeholder="请输入关键词查询" />
	 	</div>
	 	<div class="xuanze">
	 		<ul class="xuanze-list" id="xuanze-list">
	 		</ul>
	 	</div>
	 	<div class="btn-1">
	 		<span id="btn-cancel">取消</span><span id="btn-do">确定</span>
	 	</div>
	 </div>
	</div>
	 <div class="banner">
	 	 <div class="banner-bg">
	 	 	<img src="/Static/images/home/Home_qj.png" alt="" id="banner-img">
	 	 	<span>身份认证</span>
	 	 </div>
	 </div>
	  <div class="form-1"><span>真实姓名</span><input type="text" id="true_name" placeholder="请输入您的真实姓名"></div>
	  <div class="form-1"><span>联系方式</span><input type="text" id="mobile" placeholder=""></div>
	  <div class="form-1"><input type="text" id="sms_code"/><button id="btn-yanzheng">获取验证码</button></div>
	  <div class="form-2">
	   <div class="form-3"><img src="/Static/images/home/Id_mechanism.png" alt=""><span>所在机构</span></div>
	   <div class="form-4">
	   	<div class="qihang" id="qihang">点击选择机构</div>
	   	<ul id="qihang-list">
	   	</ul>
	   	<div class="btn">
	   		<button id="cancel">取消</button>
	   		<button id="doit">确定</button>
	   	</div>
	   </div>
	  </div>
	   <div class="tijiao">
	   		<span id="tijiao-cancel">取消</span>
	   		<span id="tijiao-do">提交</span>
	   </div> 
	  
</body>
<script type="text/javascript" src="/Static/js/home/base.js"></script>
<script type="text/javascript" src="/Static/js/home/identification.js"></script>
<block name="include"><include file="Common:footer" /></block>