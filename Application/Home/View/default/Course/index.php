<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/timetable.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<body>
	<div id='main'>
		<!-- 头部 -->
		<div class="nav">
			<ul>
				<li>
					<select name="angecy_lists" id="agency_lists">
						<option value="0">请选择</option>
					</select>
					<span class="upBtn"><img src="/Static/images/home/drop.png" ></span>
				</li>
				<li>
					<select name="teacher_lists" id="teacher_lists">
						<option value="0">请选择</option>
					</select>
					<span class="upBtn"><img src="/Static/images/home/drop.png" ></span>
				</li>
				<li>
					<select name="student_lists" id="student_lists">
						<option value="0">请选择</option>
					</select>
					<span class="upBtn"><img src="/Static/images/home/drop.png" ></span>
				</li>
				<li>
					<img src="/Static/images/home/Kb_date.png" alt="" class="calendar">
				</li>
			</ul>
		</div>
	<!-- 时间列表 -->
	<ul class="timet">
		<li class="timet-li1" id="prev_week"><img src="/Static/images/home/Kb_backoff.png" alt="" class="time-prev" ></li>
		<li class="timet-li2">
			<span class='time-before' id="week_time">2016-11-14~2016-11-20</span></li>
		<li class="timet-li1" id="next_week"><img src="/Static/images/home/Kb_forward.png" alt="" class="time-next" ></li>
	</ul> 
	<!--课表-->
	<div class="course-arrange">
			<input type="hidden" value="0" id="prev_time_stamp"/>
			<input type="hidden" value="0" id="next_time_stamp"/>
			 <div class="detail_table">
			 <!-- 周一 -->
			  <div class="weekend-course">
				<div class="course-date">
					<div class="aaa">周一 11/11</div>
				</div>	
				 <ul class="time-slide">
					<li>14:00 -- 15:00</li>
					<li>16:00 -- 17:00</li>	
					<li>17:00 -- 18:00</li>
				</ul>	
				<!-- 课程信息 -->
				<div class='course_lists'>
					<ul class="course-infor">
						<li class="student-info">
							<span>课程名称：小提琴</span>
							<span>机构：星洲琴行</span>
							<span>学员：Cindy11</span>
						</li><li class="student-info">
							<span>课程名称：小提琴</span>
							<span>机构：星洲琴行</span>
							<span>学员：Cindy22</span>
						</li><li class="student-info">
							<span>课程名称：小提琴</span>
							<span>机构：星洲琴行</span>
							<span>学员：Cindy33</span>
						</li>
					</ul>
					<ul class="course-infor">
						<li class="student-info">
							<span>课程名称：小提琴</span>
							<span>机构：星洲琴行</span>
							<span>学员：Cindy</span>
						</li><li class="student-info student-info-bg"></li> 
					</ul>
					<ul class="course-infor">
						<li class="student-info">
							<span>课程名称：小提琴</span>
							<span>机构：星洲琴行</span>
							<span>学员：Cindy</span>
						</li><li class="student-info student-info-bg"></li>	
					</ul>
				</div>
			</div>
			<!-- 周二 -->
			 <div class="weekend-course">
				<div class="course-date">
					<span>周二 11/12</span>
				</div>	
				 <ul class="time-slide">
					<li>14:00 -- 15:00</li>
					<li>16:00 -- 17:00</li>	
					<li>17:00 -- 18:00</li>
					<li>16:00 -- 17:00</li>	
					<li>17:00 -- 18:00</li>
				</ul>	
				<!-- 课程信息 -->
				<div class='course_lists'>
				 <ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li>	
				 </ul>
				 <ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li>
				</ul>
				<ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li>	
				</ul>
				<ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li>
				 </ul>
				 <ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li> 		
				 </ul>
			  </div>
			</div>
			<!-- 周三 -->
			  <div class="weekend-course">
				<div class="course-date">
					<span>周三 11/13</span>
				</div>	
				 <ul class="time-slide">
					<li>14:00 -- 15:00</li>
					<li>16:00 -- 17:00</li>	
					<li>17:00 -- 18:00</li>
				</ul>	
				<!-- 课程信息 -->
				<div class='course_lists'>
					<ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li></li><li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li>

				</ul>
				<ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li>
				</ul>
				<ul class="course-infor">
					<li class="student-info">
						<span>课程名称：小提琴</span>
						<span>机构：星洲琴行</span>
						<span>学员：Cindy</span>
					</li><li class="student-info student-info-bg"></li>
				</ul>
			  </div>
			</div>
		  </div> 			  	 
		</div>	 
	</div>	 
<div class="getOut">
	<div class="course">
		<p>课程详情</p>
		<ul class="course-list">
			<li>上课时间：<span>14:15-15:00</span></li>
			<li>课程名称:<span>架子鼓</span></li>
			<li>班级名称：<span>架子鼓_赵红雨</span></li>
			<li>开班时间：<span>2016-11-16</span></li>
			<li>已上课时间：<span>1小时</span></li>
			<li>在读学员：<span>赵红雨</span></li>
		</ul>
		<ul class="course-list2">
			<li id="course-li">点名</li>
			<li>请假</li>
			<li>调课</li>
		</ul>
	</div>
	<!-- 日历 -->
	<div class="aboluo-w-700">
	<div class="aboluo-leftdiv">
		<div class="aboluo-tools">
			<div class="aboluo-calendar-select-year"></div>
			<div class="aboluo-calendar-month">
				<a class="aboluo-month-a-perv" href="javascript:;">&lt; </a>
				<a class="aboluo-month-a-next" href="javascript:;"> &gt;</a>
			</div>
			<input type="button" class="aboluo-toToday" value="返回今天" />
		</div>
		<div class="aboluo-rilidiv">
			<table class="aboluo-rilitable" cellspacing="0" cellpadding="0" >
				<thead class="aboluo-rilithead">
					<tr>
						<th>周一</td>
						<th>周二</td>
						<th>周三</td>
						<th>周四</td>
						<th>周五</td>
						<th>周六</td>
						<th>周日</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	 <div class="aboluo-rightdiv">
		<p class="aboluo-xssj"><p>
		<p class="aboluo-currday"></p>
		<p class="aboluo-ssjjr"></p>
		<p class="aboluo-xsmx"></p>
	</div> 
	<div class="aboluo-ok">完成</div>
</div>
</div>
</body>
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/base.js"></script>
<script type="text/javascript" src="/Static/js/home/timetable.js"></script>
<script type="text/javascript" src="/Static/js/common/zepto.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script>
<block name="include"><include file="Common:footer" /></block>