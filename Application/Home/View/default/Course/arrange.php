<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/coursearrang.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/>
<style type="text/css">
	#main{
		max-width:750px;
		min-width:320px;
		margin:0 auto;
		position: relative;
	}

	/***头部**/
	.nav{
		width:100%;
		height:0.45rem;
		background:#f3f3f3;
	}
	.nav>ul{
		display: -webkit-box;
		display: -moz-box;
		display: box;
		height:100%;

		-webkit-box-orient: horizontal;   
		-moz-box-orient: horizontal;
		box-orient: horizontal;
		border-bottom:1px solid #d4d4d4;
	}
	.nav>ul>li{
		-webkit-box-flex: 1;
		-moz-box-flex: 1;
		box-flex: 1;
		line-height: 0.45rem;
		text-align:center;

	}
	.nav li:nth-child(3){
		text-align:right;
	}
	#agency_lists,#select_teahcer{
		color: #4fbfcf;
		font-weight: bold;
		font-size:0.15rem;
		border:0px;

		appearance:none;   
		-moz-appearance:none;   
		-webkit-appearance:none;
	}
	.calendar{
		margin:0.10rem 0.20rem 0 0 ;
		width:0.25rem;
		height:0.25rem;
	}
	.upBtn>img{
		width:0.10rem;
		color: #4fbfcf;
		font-weight: bold;
		margin:0.20rem 0 0 0.06rem;
	}

	/**课表*/
	.timetable{
		width:100%;
		height:100%;
		overflow: auto;
		margin-top:0.10rem;
	}
	.time_line{
		width:15%;
		height:100%;
		float:left;
	}
	.time_line>ul{
		display: -webkit-box;
		display: -moz-box;
		display: box;

		-webkit-box-orient: vertical;   
		-moz-box-orient: horizontal;
		box-orient: horizontal;
	}
	.time_line>ul>li{
		-webkit-box-flex: 1;
		-moz-box-flex: 1;
		box-flex: 1;
		text-align: right;
		font-size:0.13rem;
		color:#7d7d7d;
		width:100%;
		height:0.56rem;
	}
	.detail_table{
		width:80%;
		height:100%;
		overflow: hidden;
		float:left;
		border-right:1px solid #c9c9c9;
	}
	.time_day{
		width:50%;
		height:100%;
		float:left;
	}
	.table_line{
		width:100%;
		height:100%;
		display: -webkit-box;
		display: -moz-box;
		display: box;

		-webkit-box-orient: vertical;   
		-moz-box-orient: horizontal;
		box-orient: horizontal;
	}
	.table_line>li{
		-webkit-box-flex: 1;
		-moz-box-flex: 1;
		box-flex: 1;
	}
	.table_line>li>p{
		width:100%;
		margin:0 auto;
		text-align: left;
		font-size:0.13rem;
		line-height: 0.15rem;
		margin-left:0.25rem;
	}
	.default_font>p{
		color:#7d7d7d;
	}
	.select_font>p{
		color:#3f3f3f;
	}
	.h_course{
		height:0.56rem;
		background:#f3f3f3;
		border:1px solid #96e75e;
		margin-right:-1px;
		margin-bottom:-1px;
	}
	.li_selected{
		background:#ecf3fd;
	}
	.no_course{
		height:0.56rem;
		background:#65e2a3;
		border:1px solid #1fa762;
		margin-right:-1px;
		margin-bottom:-1px;
	}
	.line_title{
		background:#4fbfcf;
		color:#fff;
		font-size:0.13rem;
		line-height: 0.40rem;
		text-align: center;
		height:0.40rem;
		pointer-events:none;
	}
	.pointer_none{
		background:#f3f3f3;
		pointer-events:none;
	}
</style>
<body>
	<div id="main">
		<!--头部-->
		<div class="nav">
			<ul>
				<li>
					<select name="angecy_lists" id="agency_lists">
					</select>
					<span class="upBtn"><img src="/Static/images/home/Pk_drop.png" ></span>
				</li>
				<li>
					<span id="select_teahcer" teacher_id="0"></span>
					<span class="upBtn"><img src="/Static/images/home/Pk_drop.png" ></span>
				</li>
				<li>
					<img src="/Static/images/home/Pk_date.png" alt="" class="calendar">
				</li>
			</ul>
		</div>
		<!--课表-->
		<div class="timetable">
			<!--时间轴-->
			<div class="time_line">
				<ul id="time_line_lists">
				</ul>
			</div>
			<!--内容-->
			<div class="detail_table">
				<div id="mySwipe">
					<ul class="swiper-wrapper" id="course_lists">
						
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="getOut"></div>
	<div class="dateChange">
		<ul class="date-list">
			<li class="dateChange-li" silder_index="1">周一</li>
			<li silder_index="1">周二</li>
			<li silder_index="2">周三</li>
			<li silder_index="2">周四</li>
			<li silder_index="3">周五</li>
			<li silder_index="4">周六</li>
			<li silder_index="4">周日</li>
		</ul>
		<div class='date-btn'>
			<span class="date-cancel" id="cancel_calendar">取消</span>
			<span class="date-do" id="sure_calendar">确定</span>
		</div>
	</div>
	<div id="li_students" class="none"></div>
	<!--排课-->
	<div class="courseChange">
		<p>课表变动</p>
		<div class="changeDo">请确定对<span id="box_teahcer"></span>老师的课程需要进行的操作</div>
		<ul class="courseChange-list">
			<li class="hasCourse">有课</li>
			<li class="addCourse">新增</li>
			<li class="selectCourse">转课</li>
			<li class="xuCourse">续课</li>
		</ul>
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/course_arrange.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script>
<script type="text/javascript">
<block name="include"><include file="Common:footer" /></block>