<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/month_report.css"/>
<body>
	<div class="month-report">
		<span id='month-hour' class="month-header add_class" type="0" is_load="0">本月课时</span>
		<span id='non-record' class="month-header" type="1" is_load="0">未到记录</span>
		<input type="hidden" value="<?php echo I('get.type',0,'intval');?>" id="web_type"/>
	</div>
	<!-- 本月课时 -->
	<div class="has_course">
		<ul class="wait_header">
			<li>
				<select name="angecy_lists" id="issign_agency_lists">
					<option value="">星洲琴行</option>
				</select>
				<span class="upBtn"><img src="/Static/images/home/Pk_drop.png" ></span>
			</li>
			<li>
				<span id="issign_today">11月/2016</span>
				<span ><img src="/Static/images/home/Pk_date.png" alt="" class="calendar"></span>
			</li>
		</ul>
		<p class="take-hour"><span>上课：<i id="total_period"></i>课时</span><span>本月合计</span></p>
		<div id="issign_lists">

		</div>
	</div>	
	<!-- 未到记录 -->
	<div class="wait_infor">
		<ul class="wait_header">
			<li>
				<select name="angecy_lists" id="nosign_agency_lists">
					<option value="">星洲琴行</option>
				</select>
				<span class="upBtn"><img src="/Static/images/home/Pk_drop.png" ></span>
			</li>
			<li>
				<span id="nosign_today" >11月/2016</span>
				<span ><img src="/Static/images/home/Pk_date.png" alt="" class="calendar"></span>
			</li>
		</ul>
		<div class="infor" id="nosign_lists">

		<!--
			<div class="tail_infor">
				<p>
					<span id='clock'><img src="/Static/images/home/Yb_time.png" alt=""></span>
					<span>2016年11月28日</span>
					<span class='calendar1'><img src="/Static/images/home/Yb_pulldown.png" alt="" class="upDownImg"></span>
				</p>
				<div id="course_content">
					<div class="tail_course">
						<ul class="tail_course_list">
							<li>Andy 星洲琴行 (德胜店)</li>
							<li>课程名称：小提琴</li>
							<li>上课时间：14:30-15:30</li>
						</ul>
						<div class="make_up">
							<span>补卡</span>
						</div>
					</div>
					<div class="tail_course">
						<ul class="tail_course_list">
							<li>Tom 星洲琴行 (德胜店)</li>
							<li>课程名称：钢琴</li>
							<li>上课时间：16:30-17:30</li>
						</ul>
						<div class="make_up">
							<span>补卡</span>
						</div>
					</div>
				</div>
			</div>
			<div class="tail_infor">
				<p>
					<span id='clock'><img src="/Static/images/home/Yb_time.png" alt=""></span>
					<span>2016年11月21日</span>
					<span class='calendar2'><img src="/Static/images/home/Yb_forward.png" alt=""></span>
				</p>
			</div>
			<div class="tail_infor">
				<p>
					<span id='clock'><img src="/Static/images/home/Yb_time.png" alt=""></span>
					<span>2016年11月19日</span>
					<span class='calendar2'><img src="/Static/images/home/Yb_forward.png" alt=""></span>
				</p>
			</div>
			<div class="tail_infor">
				<p>
					<span id='clock'><img src="/Static/images/home/Yb_time.png" alt=""></span>
					<span>2016年11月10日</span>
					<span class='calendar2'><img src="/Static/images/home/Yb_forward.png" alt=""></span>
				</p>
			</div>
			<div class="tail_infor">
				<p>
					<span id='clock'><img src="/Static/images/home/Yb_time.png" alt=""></span>
					<span>2016年11月16日</span>
					<span class='calendar2'><img src="/Static/images/home/Yb_forward.png" alt=""></span>
				</p>
			</div>
		</div>
		-->
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/month_report.js"></script>
<block name="include"><include file="Common:footer" /></block>