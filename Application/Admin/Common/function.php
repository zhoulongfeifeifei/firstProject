<?php

	/**
	*检查菜单显示权限
	*/
	function checkMenuPermission($rel=''){
		//is_director 1超级管理员
		return (in_array($rel,session('employee_permission')) || session('is_director')==1);
	}
	/**
	*检查权限
	*/
	function checkPermission($rel=''){
		//is_director 2 部门主管
		return (in_array($rel,session('employee_permission')) || session('is_director'));
	}

	/**
	*递归获取分类信息
	*/
	function getCategoryLists($list,$fid=0,$level=0,$html='&nbsp&nbsp&nbsp&nbsp'){
		static $result = array();
		foreach($list as $v){
			if($v['fid'] == $fid){
				$v['sort'] = $level;
				$v['html'] = str_repeat($html,$level);
				$result[] = $v;
				getCategoryLists($list,$v['id'],$level+1);
			} 
		}
		return $result;
	}

?>