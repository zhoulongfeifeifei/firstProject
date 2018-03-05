<?php
	
	$redis = New Redis();
	$redis->connect('localhost',6379);
	if($redis->exists('index_web_html')){
	
		echo "key存在"."\n";
	}else{
		echo "key不存在"."\n";
	}

	print_r($redis->get('index_web_html'));
?>
