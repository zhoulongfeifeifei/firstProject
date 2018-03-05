<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	public function index(){
		$this->display();
	}
	public function identification(){
		$this->display();
	}

	

}
