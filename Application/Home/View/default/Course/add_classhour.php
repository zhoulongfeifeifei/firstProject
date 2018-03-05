<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/addteacher.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/addclasshour.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<body>
	<div class="getOut"></div>
	<div class="teacherinfirmation">
		<ul class="teacherinfirmation-list">
			<li class="teacherinfirmation-li1"><span id="agency_name">机构：星洲琴行(德胜店)</span><span id="teacher_name">授课老师Jack</span></li>
			<li>
			<label for="">学员：<input id="student_name" type="text" placeholder="请输入姓名"></label>
			</li>
			<li>
			<label for="">课时：<input id="course_hour" type="text" placeholder="请输入课时数(必填)"></label>
			</li>
			<li class="teacherinfirmation-li4"><label for="">年级：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<select name="" id="student_grade">
				</select>
			</li>
			<li>
				<label for="" id="sex">性别：
					<img class="womansex" is_select="0" src="/Static/images/home/Pk_woman_default.png" alt="">
					<img class="mansex"  is_select="1" src="/Static/images/home/Pk_man_click.png" alt="">
				</label>
			 </li>
			<li>
				<label for="">手机号码：
					<input type="text" placeholder="请输入手机号(必填)" id="mobile">
				</label>
			</li>
			<li>
				<label for="">
					<input type="text" placeholder="请输入手机号(选填)" id="tel_phone">
				</label>
			</li>
			<li class="teacherinfirmation-li2"><label for="">课程：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<input type="text" placeholder="请选择" id="select_course_name" readonly></label>
			</li>
			<li class="teacherinfirmation-li3">第一次课：
				<img src="/Static/images/home/Pk_date.png" id="workdate">
				<span id="startTime"><span id="week_name"></span><span id="first_time"></span></span>
			</li>
		</ul>
		<div class="information-btn" id="information-btn" style="    padding: 1.5rem 10% 0 10%;">
			<div class="information-btn1" style="background: #ff3846" id="closeBtn">取消</div>
			<div class="information-btn1" style="background: #55c5d5" id="sureBtn">确定</div>
		</div>
	</div>
	<div class="zezhao"></div>
	<div class="getOut"></div>
	<div class="courselist">
		<div class="courselist-top">
			课程列表
		</div>
		<ul class="courselist-list">
			
		</ul>
	  </div>	
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
</body>
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/add_timetable.js"></script>
<block name="include"><include file="Common:footer" /></block>