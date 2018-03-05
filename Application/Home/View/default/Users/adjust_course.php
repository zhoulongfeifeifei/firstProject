<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/ask_leave.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/adjust_course.css" />
<body>
	<div class="getOut"> 
	<!-- <div class="approver-information">
		<p class="approver-title">审批人列表</p>
		<ul class="approver-list">
			<li class="approve-li-style">罗小超<img src="/Static/images/home/Id_selected.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li class="approve-li-style">罗小超<img src="/Static/images/home/Id_selected.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
			<li>罗小超<img src="/Static/images/home/Id_default.png" alt=""></li>
		</ul>
		<div class="approver-btn">
			<span class="approver-cancel">取消</span>
			<span class="approver-do">确定</span>
		</div>
		<p class="approver-prompt">请根据实际情况进行选择，支持多选</p>
	</div> -->
</div>	
<div class="ask_leave">
		<ul class="ask-leave-list">
			<li class="addStyle">教师姓名：罗小超</li>
			<li class="addStyle">
				选择机构：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<select name="agency_lists" id="agency_lists">
						<option value="">请选择(必填)</option>
					</select>
				</label>
			</li>
			<li class="addStyle">
				原时间：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<select name="start_time" id="leave_start_time">
						<option value="">请选择(必填)</option>
					</select>
				</label>
			</li>
			<li class="addStyle">
				<label for="">调整时间：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<select name="leave_end_time" id="leave_end_time">
						<option value="">请选择(必填)</option>
					</select>
				</label>
			 </li>
			<li class="addStyle approver-li">
				<label for="">审批人：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<select name="pass_user" id="pass_user">
						<option value="">罗小超</option>
						<option value="">罗小超</option>
						<option value="">罗小超</option>
						<option value="">罗小超</option>
					</select>
				</label>
			 </li>
			<li id="student-list">
				<span>学生：</span>
				<ul id="student-name">
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
					<li>杨小明</li>
				</ul>
			</li>
		</ul>
		<div class="ask-leave-do">
			<span>提交</span>
		</div>
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/adjust_course.js"></script>
<block name="include"><include file="Common:footer" /></block>