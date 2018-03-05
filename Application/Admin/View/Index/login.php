<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理系统</title>
<link href="/Static/plugins/Jui/themes/css/login.css" rel="stylesheet" type="text/css" />
<script src="/Static/plugins/jquery-1.8.3.min.js"></script>
</head>

<body id="login">
	<div>
		<div id="login_content">
			<form>
			<div class="loginForm">
				<p id="login-title">管理系统登录</p>
				<ul>
					<li>
						<label>帐号：</label>
						<input type="text" id="account" name="account" size="22" minlength="5" maxlength="30" class="login_input" />
					</li>
					<li>
						<label>密码：</label>
						<input type="password" id="password" name="password" minlength="6" maxlength="24" size="22" class="login_input" />
					</li>
				</ul>
				<div class="login_bar">
					<input value="登录" type="button" id="submit" />
				</div>
			</div>
			</form>
		</div>
	</div>
	<script>

		$(function(){
			$('#submit').bind('click',function(){
				var account=$('#account').val();
				var password=$('#password').val();
				//validate
				if(!account){
					alert('请输入用户名');
					return;
				}
				if(!password){
					alert('请输入密码');
					return;
				}
				$.ajax({
					type: "POST",
					url: '/admin/Index/login',
					data: $("form").serialize(),
					dataType: "json",
					success: function(data){
						if(data.status){
							location.href=data.success_url;
							return;
						}else{
							alert(data.msg);
						}
					}
				});
			});

			$('#account').bind('keyup', function(event) {
				if (event.keyCode == "13") {
					$('#submit').click();
				}
			});
			$('#password').bind('keyup', function(event) {
				if (event.keyCode == "13") {
					$('#submit').click();
				}
			});
		})
	</script>
</body>
</html>