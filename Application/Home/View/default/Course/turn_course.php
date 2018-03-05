<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<!-- <link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/> -->
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/addteacher.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/ask_leave.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/adjust_course.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/turn_course.css" />
<body>
    <div class="getOut1"></div>
	<div class="getOut">
		<!-- 课程列表 -->
		<div class="courselist">
			<div class="courselist-top">课程列表</div>
			<ul class="courselist-list"></ul>
		</div>
		<!-- 学员列表 -->
		<div class="approver-information">
			<p class="approver-title">学员列表</p>
			<ul class="approver-list"></ul>
			<div class="approver-btn">
			<span class="approver-cancel">取消</span>
			<span class="approver-do">确定</span>
			</div>
			<p class="approver-prompt">请根据实际情况进行选择，支持多选</p>
		</div>	
		<!-- 新老师选择列表 -->
		<div class="teacher-information">
			<p class="approver-title">老师列表</p>
			<ul class="teacher-list"></ul>
			<div class="teacher-btn">
				<span class="teacher-cancel">取消</span>
				<span class="teacher-do">确定</span>
			</div>
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
	<!-- 时间课表弹出框 -->
	<div class="timetable">
		<!--时间轴-->
		<div class="time_line">
			<ul id="time_line_lists">
				<!-- <li class="time_line_first"></li>
				<li>08:00</li>
				<li>09:00</li>
				<li>10:00</li>
				<li>11:00</li>
				<li>12:00</li>
				<li>13:00</li>
				<li>14:00</li>
				<li>15:00</li>
				<li>16:00</li> -->
			</ul>
		</div>
		<!--内容-->
		<div class="detail_table"> 
			<ul id="course_lists">
				<li class="course_content">
					<ul>
						<li class="course_content_first">周一</li>
						<li class="non-bg"></li>
						<li class="non-bg"></li>
						<li class="has-bg"></li>
						<li class="non-bg"></li>
						<li class="has-bg"></li>
						<li class="non-bg"></li>
						<li class="non-bg"></li>
						<li  class="has-bg"></li>
					</ul>
				</li>
				<li class="course_content">
					<ul>
						<li class="course_content_first">周二</li>
						<li></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li class="has-bg"></li>
						<li></li>
					</ul>
				</li>	 
				<li class="course_content">
					<ul>
						<li class="course_content_first">周三</li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>	
				</li>
				<li class="course_content">
					<ul>
						<li class="course_content_first">周四</li>
						<li></li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</li>
				<li class="course_content">
					<ul>
						<li class="course_content_first">周五</li>
						<li></li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</li>
				<li class="course_content">
					<ul>
						<li class="course_content_first">周六</li>
						<li></li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</li>
				<li class="course_content">
					<ul>
						<li class="course_content_first">周日</li>
						<li></li>
						<li></li>
						<li></li>
						<li class="has-bg"></li>
						<li class="has-bg"></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="ask_leave">
		<ul class="ask-leave-list">
			<li class="addStyle1" id="ag_id"></li>
			<li class="addStyle1" id='before_teacher'></li>
			<li>
				新老师：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<input type="text" placeholder="请输入新老师姓名" id="teacher_id" readonly>
				</label>
			</li>
			<li class="addStyle1" id='course-subject'><label for="">课程：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<input type="text" placeholder="钢琴" id="select_course_name" readonly></label>
			</li>
			<li>
				原班级：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<input type="text" placeholder="钢琴2-1" value="" readonly id="course_room">
				</label>
			</li>
			 <li id='preLi' class="addStyle1">
		 		<div class="preTime">
		 			原上课时间：
		 			<img src="/Static/images/home/Kb_forward.png" alt="">
		 			<input type="text" placeholder="周一" value="" id='before_time' readonly>
		 		</div>
		 		<div id="clock">
		 			<img src="/Static/images/home/Pk_time.png" alt=""> 
		 		</div> 
			 </li>
			 <li id='preLi'>
		 		<div class="preTime">
		 			开课时间：
		 			<span id="startTime"><span id="week_name"></span><span id="first_time"></span></span>
		 		</div>
		 		<div id="clock">
		 			<img src="/Static/images/home/Pk_date.png" id='select_time'> 
		 		</div> 
			 </li>
			<li id="student-list" class="addStyle1">
				<div class="student">
		 			学员：
		 			<img src="/Static/images/home/Kb_forward.png" alt="">
		 			<input type="text" id='PrintName' placeholder="请输入学员姓名" readonly>
		 		</div>
		 		<div id="only-hour"><p class="only">剩</p>9课时
		 		</div> 
				<ul id="studentName"></ul>
			</li>
		</ul>
		<div class="turn-course-btn">
			<span id="turn_course_cancel">取消</span>
			<span id="turn_course_do">完成转课</span>
		</div>
	</div>
	<div id="select_student" style="display: none;"></div>
	<div id="select_teacher" style="display: none;"></div>
</body>
<!-- <script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script> -->
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/turn_course.js"></script>
<block name="include"><include file="Common:footer" /></block>