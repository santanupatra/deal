<?php
class AdminhelpHelper extends AppHelper
{
	public function get_total_user() {
			App::import('Model', 'User');
			$this->User= new User();
			$test  = array();
			$test = $this->User->find('count',array('conditions' => array('User.is_admin' => 1)));
			return $test;
    }
	public function get_total_normal_user() {
			App::import('Model', 'User');
			$this->User= new User();
			$test  = array();
			$test = $this->User->find('count',array('conditions' => array('User.is_admin' => 0,'User.type' => 'C','User.is_active'=> 1)));
			return $test;
    }
	
     public function get_total_normal_vendor() {
			App::import('Model', 'User');
			$this->User= new User();
			$test  = array();
			$test = $this->User->find('count',array('conditions' => array('User.is_admin' => 0,'User.type' => 'V','User.is_active'=> 1)));
			return $test;
    }
    
}
?>