<!--导入头信息-->
<block name="include"><include file="Common:header" /></block>
<link rel="stylesheet" type="text/css" href="/Static/css/home/addteacher.css" />
<body>
	<div class="teacherinfirmation">
		<ul class="teacherinfirmation-list">
			<li class="teacherinfirmation-li1">机构：星洲琴行(德胜店)</li>
			<li><label for="">教师姓名：<input type="text" placeholder="请输入姓名"></label></li>
			<li><label for="">性别：
				<img src="/Static/images/home/Pk_woman_default.png" alt="">
				<img src="/Static/images/home/Pk_man_click.png" alt="">
			 </li>
			<li><label for="">手机号码：<input type="text" placeholder="请输入手机号(必填)"></label></li>
			<li><label for=""><input type="text" placeholder="请输入手机号(选填)"></label></li>
			<li class="teacherinfirmation-li2"><label for="">课程：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<input type="text" placeholder="架子鼓"></label>
			</li>
			<li class="teacherinfirmation-li3">入职时间：
				<img src="/Static/images/home/Pk_date.png" id="workdate">
			</li>
		</ul>
		<div class="information-btn">
			<div class="information-btn1" style="background: #ff3846">取消</div>
			<div class="information-btn1" style="background: #55c5d5">确定</div>
		</div>
	</div>
	<div class="zezhao"></div>
	  <div class="courselist">
		<div class="courselist-top">
			课程列表
		</div>
		<ul class="courselist-list">
			<li class="courselist-li">
			  <div class="aaa"> 
				<span class="coursename">打击乐</span>
				<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
			<li class="courselist-li">
				<div class="coursename-select"> 
					<span class="coursename">弹拨乐</span>
					<img src="/Static/images/home/Pk_pulldown.png" alt="" class="jiantou">
			  </div>
			  <ul class="coursestyle">
					<li>
						<span>吉他</span>
						<img src="/Static/images/home/Id_selected.png">
					</li>
					<li>
						<span>电贝斯</span>
						<img src="/Static/images/home/Id_default.png">
					</li>
					<li>
						<span>电吉他</span>
						<img src="/Static/images/home/Id_default.png">
					</li>
					<li>
						<span>尤克里里</span>
						<img src="/Static/images/home/Id_selected.png">
					</li>
			  </ul>
			</li>
			<li class="courselist-li">
				<div class="aaa"> 
					<span class="coursename">西洋乐</span>
					<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
			<li class="courselist-li">
				<div class="aaa"> 
					<span class="coursename">民乐</span>
					<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
			<li class="courselist-li">
				<div class="aaa"> 
					<span class="coursename">声乐</span>
					<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
			<li class="courselist-li">
				<div class="aaa"> 
					<span class="coursename">西洋管乐</span>
					<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
			<li class="courselist-li">
				<div class="aaa"> 
					<span class="coursename">钢琴/电子琴</span>
					<img src="/Static/images/home/Kb_forward.png" alt="" class="jiantou">
			  </div>
			</li>
		</ul>
	  </div>	
</body>
<script type="text/javascript" src="/Static/js/home/addteacher.js"></script>
<block name="include"><include file="Common:footer" /></block>