<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/addteacher.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/ask_leave.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/continue_course.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<body>
	<div class="getOut">
	  <div class="approver-information">
		<p class="approver-title">学员列表</p>
		<ul class="approver-list">
			<!-- <li class="approve-li-style">罗小超<img src="/Static/images/home/Id_selected.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li class="approve-li-style">罗小超<img src="/Static/images/home/Id_selected.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li> -->
		</ul>
		<div class="approver-btn">
			<span class="approver-cancel">取消</span>
			<span class="approver-do">确定</span>
		</div>
		<p class="approver-prompt">请根据实际情况进行选择，支持多选</p>
	  </div> 
	 <!--  日历 -->	
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
	<div class="teacherinfirmation">
		<ul class="teacherinfirmation-list">
			<li class="teacherinfirmation-li1" id="agency_name">
			</li>
			<li class="teacherinfirmation-li2">学员：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				 <input type="text" id='student_name' placeholder="" readonly="">
			</li>
			<li>
				<label for="">课时：
					<input type="text" placeholder="请输入课时(必填)" id="course_hour">
				</label>
			</li>
			<li class="teacherinfirmation-li3">
				开课时间：
				<img src="/Static/images/home/Pk_date.png" id="workdateImg">
				<span id="startTime"><span id="first_time"></span></span>
			</li>
			<li class="teacherinfirmation-li1" id="teacher_name">
			</li> 
		</ul>
		<div class="information-btn">
			<div class="information-btn1" style="background: #ff3846" id="closeBtn">取消</div>
			<div class="information-btn1" style="background: #55c5d5" id="sureBtn">确定</div>
		</div>
	</div>
	<div id="select_student" style="display: none;"></div>
</body>
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/continue_course.js"></script>
<block name="include"><include file="Common:footer" /></block>