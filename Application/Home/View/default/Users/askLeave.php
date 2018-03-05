<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/ask_leave.css" />
<body>
<div class="getOut"> 
	<!-- 机构列表 -->
	<div class="ag-information">
		<p class="ag-title"></p>
		<ul class="ag-list">
		</ul>
		<div class="ag-btn">
			<span class="ag-cancel">取消</span>
			<span class="ag-do">确定</span>
		</div>
		<p class="ag-prompt">请根据实际情况进行选择，支持多选</p>
	</div>
	<!-- 审批人列表 -->
	<div class="approver-information">
		<p class="approver-title"></p>
		<ul class="approver-list">
		</ul>
		<div class="approver-btn">
			<span class="approver-cancel">取消</span>
			<span class="approver-do">确定</span>
		</div>
		<p class="approver-prompt">请根据实际情况进行选择，支持多选</p>
	</div>
	//
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
<div class="ask_leave">
		<ul class="ask-leave-list">
			<li class="addStyle"><span id='user_type'>教师姓名：</span><span id="user_name">罗小超</span></li>
			<li>
				选择机构：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<span id='ag_list'>请选择机构</span>
				</label>
			</li>
			<li class="addStyle">
				请假类型：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<select name="leave_type" id="leave_type"></select>
			</li>
			<li>
				开始时间：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<input type="text" placeholder="请选择(必填)" readonly="" id="leave_start_time">
				</label>
			</li>
			<li>
				<label for="">结束时间：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<input type="text" placeholder="请选择(必填)" readonly="" id="leave_end_time" value="">
				</label>
			 </li>
			<li class="addStyle">
				<label for="">请假天数：
					<input type="text"  placeholder="请选择请假时间(必填)" id="ask_leave-day" readonly value="0">
				</label>
			</li>
			<li class="ask-leave-reason">
				<span>请假事由：</span>
					<textarea name="" id="textarea" cols="30" rows="6" placeholder="请输入请假事由(必填)" ></textarea>
			</li>
			<li class="addStyle approver-li">
				<label for="">审批人：
					<img src="/Static/images/home/Kb_forward.png" alt="">
					<in id="approver">请选择审批人</span>
				</label>
			 </li>
		</ul>
		<div class="ask-leave-do">
			<span id="submit">提交</span>
		</div>
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/ask_leave.js"></script>
<block name="include"><include file="Common:footer" /></block>