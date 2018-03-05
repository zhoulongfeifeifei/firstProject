<html>
<style type="text/css">
	
	.center{
		width:50%;
		margin:100px auto;
	}
</style>
	<?php if($is_true==1){?>
		<h2>恭喜！token设置成功您可以访问<a href="/api/index/ssc_plan">时时数据前往～</a>获取实时更新数据了</h2>
	<?php }?>
	<form class="center" action="/api/index/set_ssc_token" method="post">
		<h4><a href="http://trial.apius.cn/">免费获取token</a></h4>
		设置token：
		<input  type="text" name="token" size="20"  placeholder="请输入token" style="<?php echo $is_true==0? 'border:2px solid red' : '';?>"/>
		<input type="submit" value="提交"/>
	</form>

</html>