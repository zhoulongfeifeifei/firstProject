<?php
	namespace Home\Model;
	use Think\Model;
	class userModel extends Model{

		public function __construct(){
			parent::__construct();
			$this->db(1,C('DB2'));
		}

		public function InsertNewDb(){
			print_r($this->db(1)->table('my_users')->find());
		}
	}
?>