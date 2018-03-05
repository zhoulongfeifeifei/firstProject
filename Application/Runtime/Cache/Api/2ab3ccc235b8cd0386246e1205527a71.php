<?php if (!defined('THINK_PATH')) exit();?><html>
	<script type="text/javascript" src="/Static/plugins/jquery-1.8.3.min.js"></script>
	<style>
		.main{
			width:1000px;
			margin:0 auto;
		}
		.con_title{
			width:1000px;
			font-size: 18px;
			height:40px;
			line-height: 40px;
			float:left;
			text-align: left;
			margin-top:20px;
			margin-left:-30px;
			border-top: 1px solid #ccc;
		}
		.content{
			width:1000px;
			font-size:16px;
			line-height: 30px;
			padding:0px 50px;
		}
		.content_title{
			border-top: 1px solid #ccc;
			height:30px;
			line-height: 30px;
			font-size:20px;
		}
		.con_t{
			font-size: 18px;
			width:120px;
			float:left;
			text-align: left;
		}
		.con{
			font-size:14px;
			width:800px;
			float:left;
			text-align: left;
			color:#777;
		}
		.li_none{
			list-style-type: none;
		}
		.back_eg{
			background:#333;
		}
		.back_eg li{
			height:18px;
			color:#ccc;
		}
		.code_stype{
			font-size:14px;color:red;
		}
		.up_time{
			font-size: 14px;
			float:right;
		}
		.hide_box{
			font-size:16px;
		}
		.none{
			display:none;
		}
	</style>
	<body>
		<div class="main">
		<?php foreach($apis as $item){?>
			<p class="content_title "><?php echo $item['title'];?></p>
			<div><?php  foreach($item['msg'] as $msg){ $str = ''; $str = '<ul>'; $str.= '<li><font color="red">'.$msg['time'].'</font>&nbsp&nbsp<span class="show_update" code="'.$msg['code'].'">'.($msg['code']==1 ? '展开' : '隐藏').'</span></li>'; $str.='<ul class="notice_msg '.($msg['code']==1 ? 'none' : '').'">'; foreach($msg['content'] as $val){ $str.='<li>'.$val.'</li>'; } $str.='</ul></ul>'; echo $str; } ?></div>
			<?php foreach($item['api_arr'] as $key=>$value){?>
			<div>
				<div>
					<span class="con_title"><?php echo $value['name'];?>&nbsp&nbsp
						<span class="hide_box" code=1>展开</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<span class="up_time">最新更新时间：<?php echo $value['update_time'];?></span>
					</span>
				</div>
				<div class="content none">
					<div>
						<span class="con_t"><b>url：</b></span>
						<span class="con"><?php echo $value['url'];?> &nbsp&nbsp</span>
					</div>
					<div>
						<span class="con_t"><b>方式：</b></span>
						<span class="con"><?php echo $value['type'];?></span>
					</div>
					<div>
						<span class="con_t"><b>参数：</b></span>
						<span class="con">
							<ul>
								<?php foreach($value['params'] as $k=>$v){?>
								<li class="li_none">
									<span><b><?php echo $k;?></b></span>
									&nbsp&nbsp&nbsp&nbsp
									<span>
										<?php if(!is_array($v)){echo $v;}else{foreach($v as $m=>$n){?>
											<li class="li_none">
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												<span><b><?php echo $m;?></b></span>
												&nbsp&nbsp&nbsp&nbsp
												<span><?php echo $n;?></span>
											</li>
										<?php }}?>
									</span> 
								</li>
								<?php }?>
							</ul>
						</span>
					</div>
					<div>
						<span class="con_t"><b>返回：</b></span>
						<span class="con">
							<ul>
								<?php foreach($value['back'] as $k=>$v){?>
									<li class="li_none">
										<span><b><?php echo is_numeric($k) ? '&nbsp' : $k;?></b></span>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<span>
											<?php if(!is_array($v)){echo $v;}else{foreach($v as $m=>$n){?>
												<li class="li_none">
													&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<span><b><?php echo is_numeric($m) ? '&nbsp' : $m;?></b></span>
													&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<span>
														<?php if(!is_array($n)){echo $n;}else{foreach($n as $i=>$j){?>
															<li class="li_none">
																<?php for($s=0;$s<20;$s++){ echo "&nbsp"; }?>
																<span><b><?php echo is_numeric($i) ? '&nbsp' : $i;?></b></span>
																&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																<span>
																	<?php if(!is_array($j)){echo $j;}else{foreach($j as $x=>$y){?>
																		<li class="li_none">
																			<?php for($s=0;$s<30;$s++){ echo "&nbsp"; }?>
																			<span><b><?php echo is_numeric($x) ? '&nbsp' : $x;?></b></span>
																			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
																			<span><?php echo $y;?></span>
																		</li>
																	<?php }}?>
																</span>
															</li>
														<?php }}?>
													</span>
												</li>
											<?php }}?>
										</span> 
									</li>
								<?php }?>
							</ul>
						</span>
					</div>
					<div>
						<span class="con_t"><b>返回实例：</b></span>
						<span class="con">测试url：<p><a href="<?php echo $value['test_url'];?>" target="_blank"> <?php echo $value['test_url'];?></a></p></span>
						<span class="con_t"><b>&nbsp</b></span>
						
						<span class="con_t"><b>&nbsp</b></span>
						<span class="con back_eg">
							<?php if($value['back_eg']){ $back_eg = json_decode($value['back_eg'],true);?>
								<ul>
								<?php echo '{'; foreach($back_eg as $k=>$v){?>
									<li class="li_none">
									&nbsp&nbsp&nbsp&nbsp
										<span class="code_stype">
										<?php if(is_numeric($k)){echo '&nbsp';}else{ echo $k; }?>
										</span>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<span>
											<?php if(!is_array($v)){echo $v;}else{ echo '{'; foreach($v as $m=>$n){?>   
												<li class="li_none">
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<span class="code_stype">
														<?php echo is_numeric($m) ? '&nbsp' : $m;?>
													</span>
													&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<span > 
														<?php if(!is_array($n)){echo $n;}else{ echo '{';foreach($n as $i=>$j){?>
															<li class="li_none">
															<?php for($s=0;$s<30;$s++){ echo "&nbsp"; }?>
																<span class="code_stype">
																	<?php echo is_numeric($i) ? '&nbsp' : $i;?>
																</span>
																&nbsp&nbsp&nbsp&nbsp
																<span>
																	<?php if(!is_array($j)){echo $j;}else{ echo '{';foreach($j as $x=>$y){?>
																		<li class="li_none">
																		<?php for($s=0;$s<50;$s++){ echo "&nbsp"; }?>
																		<span class="code_stype">
																			<?php echo is_numeric($x) ? '&nbsp' : $x;?>
																		</span>
																		&nbsp&nbsp&nbsp&nbsp
																		<span>
																			<?php if(!is_array($y)){echo $y;}else{ echo '{';foreach($y as $a=>$b){?>
																				<li class="li_none">
																					<?php for($s=0;$s<50;$s++){ echo "&nbsp"; }?>
																					<span class="code_stype">
																						<?php echo is_numeric($a) ? '&nbsp' : $a;?>
																					</span>
																					&nbsp&nbsp&nbsp&nbsp
																					<span>
																						<?php if(!is_array($b)){echo $b;}else{ echo '{';foreach($b as $c=>$d){?>
																							<li class="li_none">
																								<?php for($s=0;$s<70;$s++){ echo "&nbsp"; }?>
																								<span class="code_stype">
																									<?php echo is_numeric($c) ? '&nbsp' : $c;?>
																								</span>
																								&nbsp&nbsp&nbsp&nbsp
																								<span>
																									<?php echo $d;?>
																								</span>
																							</li>
																						<?php } if(is_array($b) && !empty($b)){ for($s=0;$s<58;$s++){ echo "&nbsp"; } echo '}<br/>'; } }?>
																					</span>
																				</li>
																			<?php } if(is_array($y) && !empty($y)){ for($s=0;$s<48;$s++){ echo "&nbsp"; } echo '}<br/>'; } }?>
																		</span>
																		</li>
																	<?php } if(is_array($j) && !empty($j)){ for($s=0;$s<38;$s++){ echo "&nbsp"; } echo '}<br/>'; } }?>
																</span>
															</li>
														<?php } if(is_array($n) && !empty($n)){ for($s=0;$s<20;$s++){ echo "&nbsp"; } echo '}<br/>'; } }?>
													</span>
												</li>
											<?php } if(is_array($n) && !empty($n)){ echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".'}'; } }?>
										</span>
									</li>
								<?php }echo '<br/>}';?>
								</ul>
							<?php }echo '}';?>
						</span>
					</div>
					<div>
						<span class="con_t"><b>说明：</b></span>
						<span class="con">
							<ul>
								<?php foreach($value['list'] as $k=>$v){?>
								<li class="li_none">
									<span><b><?php echo $k;?></b></span>
									&nbsp&nbsp&nbsp&nbsp
									<span>
										<?php if(!is_array($v)){echo $v;}else{foreach($v as $m=>$n){?>
											<li class="li_none">
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												<span><b><?php echo $m;?></b></span>
												&nbsp&nbsp&nbsp&nbsp
												<span><?php echo $n;?></span>
											</li>
										<?php }}?>
									</span> 
								</li>
								<?php }?>
							</ul>
						</span>
					</div>
				</div>
			</div>
			<?php }?>
			<?php }?>
		</div>
	</body>
	<script type="text/javascript">

		$('.hide_box').click(function(){
			var code = $(this).attr('code');
			if(code==0){
				$(this).parent().parent().next('.content').hide();
				$(this).attr('code',1);
				$(this).text('展开');
			}else{
				$(this).parent().parent().next('.content').show();
				$(this).attr('code',0);
				$(this).text('隐藏');
			}
		});

		$('.show_update').click(function(){
			var code = $(this).attr('code');
			if(code==0){
				$(this).parent().parent().find('.notice_msg').hide();
				$(this).attr('code',1);
				$(this).text('展开');
			}else{
				$(this).parent().parent().find('.notice_msg').show();
				$(this).attr('code',0);
				$(this).text('隐藏');
			}
		});
	</script>
</html>