<html>
<script src="/Static/plugins/Jui/js/jquery-1.7.2.js" type="text/javascript"></script>
<style>
	ul{
		width:500px;
		margin:0 auto;
	}
	li{
		margin:10px;
	}
	.left{
		width:50%;
		float:left;
	}
	.right{
		width:50%;
		float:left;
	}
	.center{
		width:80%;
		margin:0 auto;
	}
	.ul_2{
		width:90%;
		margin:0 auto;
	}
</style>
<div class="center">
<h2>接口更新过慢。开奖后5分钟左右更新(需要时时更新请联系管理员)</h2>
<h4>每期注数在40～60多不等      开奖号码：<?php echo $ssc[0]['no'].'期：<font color="red" size="5">'.$ssc[0]['number'].'</font>';?></h4>
</div>
<div class="">
	<ul class="ul_2">
		<?php foreach($ssc as $k=>$value){ if(!$value['hs_yc']){continue;}?>
			<?php if($k==0){?>
			<li><h2>后三直选：</h2></li>
			<li>
				<label>
				<?php 

					$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
					echo $value['date'].'：'.($next_no);
				?>期&nbsp&nbsp&nbsp&nbsp <?php echo count(explode(' ', $value['hs_yc'])).'注';?>
				</label><br/><br/>
				<label><?php echo $value['hs_yc'];?></label><br/>
			</li>
			<?php }else{?>
				<li>
					<label>
					<?php 
						$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
						echo $value['date'].'：'.($next_no);
					?>期
					</label>
					<label>&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo count(explode(' ', $value['hs_yc'])).'注';?>&nbsp&nbsp&nbsp开：<?php echo $ssc[$k-1]['number'];?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
					<label><?php if($value['hs_true']==1){echo "&nbsp&nbsp&nbsp<font color='red'>中</font>&nbsp&nbsp&nbsp&nbsp&nbsp利润：".($value['get_money']-count(explode(' ', $value['hs_yc']))*0.02);}else{ echo "&nbsp&nbsp不中&nbsp&nbsp&nbsp利润：-".count(explode(' ', $value['hs_yc']))*0.02;}?></label>
				</li>
			<?php }?>
		<?php }?>
	</ul>
</div>
<div class="left">
	<ul>
		<?php foreach($ssc as $k=>$value){?>
			<?php if($k==0){?>
			<li><h2>后二一期计划</h2></li>
			<li>
				<label>
				<?php 

					$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
					echo $value['date'].'：'.($next_no);
				?>期&nbsp&nbsp&nbsp&nbsp <?php echo $value['yc_cnt'].'注';?>
				</label><br/><br/>
				<label><?php echo $value['he_yc'];?></label><br/>
				<label>细化版：</label><br/>
				<label><?php echo $value['he_yc_short'];?></label>
				<br/><br/>
			</li>
			<?php }else{?>
				<li>
					<label>
					<?php 
						$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
						echo $value['date'].'：'.($next_no);
					?>期
					</label>
					<label>&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value['yc_cnt'].'注';?>&nbsp&nbsp&nbsp</label>
					<label><?php if($value['he_true']==1){echo "&nbsp&nbsp&nbsp<font color='red'>中</font>&nbsp&nbsp&nbsp&nbsp&nbsp利润：".($value['get_money']-$value['pay_money']);}else{ echo "&nbsp&nbsp不中&nbsp&nbsp&nbsp利润：-".$value['pay_money'];}?></label>
				</li>
			<?php }?>
		<?php }?>
	</ul>
</div>
<div class="right">
	<ul>
		<?php foreach($ssc as $k=>$value){?>
			<?php if($k==0){?>
			<li><h2>后二二期计划</h2></li>
			<li>
				<label>
					<?php 
						$now_no = strlen($value['no']) ==1 ? '00'.$value['no'] : (strlen($value['no'])==2 ? '0'.$value['no'] : $value['no']);
						$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
						$next_2_no = strlen($value['no']+2) ==1 ? '00'.($value['no']+2) : (strlen($value['no']+2)==2 ? '0'.($value['no']+2) : ($value['no']+2));
						if($ssc[$k+1]['he_true_2']==1){
							echo $value['date'].'：'.($next_no).'--'.($next_2_no);
						}else{
							if($ssc[$k+1]['he_true_2']==0){
								if($ssc[$k+2]['he_true_2'] ==2){
									echo $value['date'].'：'.($next_no).'--'.($next_2_no);
								}else{
									if($ssc[$k+1]['he_true']==1){
										echo $value['date'].'：'.($next_no).'--'.($next_2_no);
									}else{
										echo $value['date'].'：'.($now_no).'--'.($next_no);
									}
								}
								
							}
						}
					?>期 &nbsp&nbsp&nbsp&nbsp&nbsp
					<?php 
						if($ssc[$k+1]['he_true_2']==1){
							echo $value['yc_cnt'].'注';
						}else{
							if($ssc[$k+1]['he_true_2']==0){
								if($ssc[$k+2]['he_true_2'] ==2){
									echo $value['yc_cnt'].'注';
								}else{
									if($ssc[$k+1]['he_true']==1){
										echo $value['yc_cnt'].'注';
									}else{
										echo $ssc[$k+1]['yc_cnt'].'注';
									}
								}
								
							}
						}
					?>
				</label><br/><br/>
				<label>
				<?php 
					if($ssc[$k+1]['he_true_2']==1){
							echo $value['he_yc'];
						}else{
							if($ssc[$k+1]['he_true_2']==0){
								if($ssc[$k+2]['he_true_2'] ==2){
									echo $value['he_yc'];
								}else{
									if($ssc[$k+1]['he_true']==1){
										echo $value['he_yc'];
									}else{
										echo $ssc[$k+1]['he_yc'];
									}
								}
								
							}
						}
				?>
				</label><br/>
				<label>细化版：</label><br/>
				<label>
				<?php 
					if($ssc[$k+1]['he_true_2']==1){
							echo $value['he_yc_short'];
						}else{
							if($ssc[$k+1]['he_true_2']==0){
								if($ssc[$k+2]['he_true_2'] ==2){
									echo $value['he_yc_short'];
								}else{
									if($ssc[$k+1]['he_true']==1){
										echo $value['he_yc_short'];
									}else{
										echo $ssc[$k+1]['he_yc_short'];
									}
								}
								
							}
						}
				?>
				</label>
				<br/><br/>
			</li>
			<?php }else{ if($value['he_true_2']==0){continue;}?>
				<li>
					<label>
					<?php 
						$now_no = strlen($value['no']) ==1 ? '00'.$value['no'] : (strlen($value['no'])==2 ? '0'.$value['no'] : $value['no']);
						$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));
						$next_2_no = strlen($value['no']+2) ==1 ? '00'.($value['no']+2) : (strlen($value['no']+2)==2 ? '0'.($value['no']+2) : ($value['no']+2));
						
						if($value['he_true_2']==1){
							if($ssc[$k-1]['he_true_2']==0){
								echo $value['date'].'：'.($next_no).'--'.($next_2_no);
							}else{
								echo $value['date'].'：'.($next_no).'--'.($next_no);
							}
						}else if($value['he_true_2']==2){
							echo $value['date'].'：'.($next_no).'--'.($next_2_no);
						}
					?>期
					</label>
					<label>
						<?php
							echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$value['yc_cnt'].'注&nbsp&nbsp';
							if($value['he_true_2']==1){
								$next_2_no = strlen($value['no']+2) ==1 ? '00'.($value['no']+2) : (strlen($value['no']+2)==2 ? '0'.($value['no']+2) : ($value['no']+2));
								$next_no = strlen($value['no']+1) ==1 ? '00'.($value['no']+1) : (strlen($value['no']+1)==2 ? '0'.($value['no']+1) : ($value['no']+1));

								echo "&nbsp&nbsp&nbsp<font color='red'>中</font>";
								
							}else{
								echo "&nbsp&nbsp&nbsp<font color='green'>不中</font>";
							}
						?>
					</label>
				</li>
			<?php }?>
		<?php }?>
	</ul>
</div>
<div style="clear:both"></div>

</html>
