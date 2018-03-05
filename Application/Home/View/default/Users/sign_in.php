<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/sign_in.css" />
<body>
	 <ul class="sign-in-list">
		<li class="sign-in-li" id="sign_title">
			
		</li>
		<li>当前机构：<span id="sign_agency">无</span></li>
		<li id="sign_studens">无</li>
		<li>当前课程：<span id="sign_course">无</span></li>
	 </ul>
	 <div class="now-time">
		<p><span id="now_time_hour"></span>:<span id="now_time_mins"></span><span class="none" id="now_time_s"></span></p>
		<p id="today_time">2016年11月23日 星期三</p>
	 </div>
	<ul class="sign-in-list2">
		<li>课程时间<span id="course_time">（暂无）</span></li>
		<li class="take-class">
			<div class="take-class-sign" id="sign_div" is_sign="1" timetable_id ="0">
				<span>暂无课程</span>
				<span></span>
			</div>
		</li>
		<li><img src="/Static/images/home/Qd_label.png"> 已进入考勤范围：杭州星洲琴行</li>
	</ul>
	<div class="course-content" id="course_content">
		<span>课程内容：</span>
		<textarea name="" id="textarea" cols="30" rows="5" placeholder="请输入课程内容" ></textarea>
	</div>
	<div class="sign-in-btn">
		<div class="sign-in-warm sign-in-button" id="course_notice">
			<img src="/Static/images/home/Qd_statistics.png">
			<span>提醒点名</span>
		</div>
		<div class="sign-in-count sign-in-button" id="goToData">
			<img src="/Static/images/home/Qd_statistics.png">
			<span>统计</span>
			<span id='count'>1</span>
		</div>
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/sign_in.js"></script>
<block name="include"><include file="Common:footer" /></block>