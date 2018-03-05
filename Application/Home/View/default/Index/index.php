<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<!-- <link rel="stylesheet" type="text/css" href="/Static/css/home/base.css" /> -->
<link rel="stylesheet" type="text/css" href="/Static/css/home/index.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/>
	<body>
		<div class="swiper-container banner">
		  <div class="swiper-wrapper banner-img"> 
			 
		   
		  </div> 
		  <div class="swiper-pagination" id="banner-anniu"></div>
		</div>  
		<div class="main">
			<div id="main-left">
				<span id="main-shijian">
				</span>
				<span id="main-day"></span>
			</div>
			<div class="main-xian"></div>
			<div id="main-center">
				<a href="<?php echo C('base_url').'/Users/wait_approval'?>" >
					<span id="main-num">0</span>
					<span id="main-shenpi" class="shenpi">待审批</span>
				</a> 
			</div>
			<div class="main-xian"></div>
			<div id="main-right">
				<a href="<?php echo C('base_url').'/Users/month_report'?>" >
					<img src="/Static/images/home/Home_report.png" alt="" class="main-yuebao">
					<span class="yuebao">月报</span>
				</a>
			</div>
		</div>
		<div class="kongbai"></div>
		<div>
			<div class="maint">
				<ul class="maint-list">
				</ul>
		</div>
	</body>
<!-- <script type="text/javascript" src="/Static/js/home/index.js"></script>
<script src="/Static/js/common/swiper2.js" type="text/javascript"></script>
<script src="/Static/js/common/swiper.animate1.0.2.min.js" type="text/javascript"></script> -->
<script type="text/javascript" src="/Static/js/home/index.js"></script>
<script type="text/javascript" src="/Static/js/common/zepto.js"></script>
 <script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
 <script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script>
<block name="include"><include file="Common:footer" /></block>