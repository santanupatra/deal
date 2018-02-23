<?php
App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class MessagesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','RequestHandler','Paginator');
        public $uses = array('Message', 'Friend', 'User');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('chat_list','latestMessage_footer','chat_message','insert_message_api','latestMessage_api');
	}
	public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Sport.id' => 'desc'
        )
    );
	
	
	public function index($id=''){
		$userid = $this->Session->read('Auth.User.id');		
		if(!isset($userid) && $userid==''){
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
		if(isset($this->request->data['search']))
		{
		$ser=$this->request->data['search'];
		  $all_friends=$this->Friend->query("select U.id, U.first_name, U.last_name, U.image, U.is_loged from users as U, friends as F where  (U.first_name LIKE '%".$ser."%' and F.from_id =".$userid." and F.to_id = U.id and F.is_delete=0) or (U.first_name LIKE '%".$ser."%' and F.to_id =".$userid." and F.from_id = U.id and F.is_delete=0) order by U.first_name"); 
		}
		else
		{
		$all_friends=$this->Friend->query("select U.id, U.first_name, U.last_name, U.image, U.is_loged from users as U, friends as F where (F.from_id =".$userid." and F.to_id = U.id and F.is_delete=0) or (F.to_id =".$userid." and F.from_id = U.id and F.is_delete=0) order by U.first_name"); 
		}
		if($id!='')
		{
		  $friend_id = $id;
		}
		else
		{
		  $friend_id = $all_friends[0]['U']['id'];
		}
		
		$friend_name = $all_friends[0]['U']['first_name'].' '.$all_friends[0]['U']['last_name'];
		$last_message_id = "";
		
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, U.image, M.id,M.date_time, M.message, TIMESTAMPDIFF(SECOND, `date_time`, 'NOW()') as time from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) order by M.id desc limit 0,20");
		
		$message = "";
		$all_messages = array_reverse($all_messages);
		//pr($all_messages);exit;
		$this->Message->updateAll(
			array('Message.is_read' => "'Y'"), 
			array('Message.to_id' => $userid)
		); 
		
		if(isset($all_messages)){
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$friend_id = $all_message['U']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) {
					$message .= '<li class="right clearfix"><span class="chat-img pull-right">
								<img src="'.$this->webroot.'/user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
								$message.='</small>
										<strong class="pull-right primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong>
									</div>
									<p>'.$all_message['M']['message'].'</p>
								</div>
								</li>';		
				}
				else
				{
					$message .= '<li class="left clearfix"><span class="chat-img pull-left">
									<img src="'.$this->webroot.'/user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
									<div class="chat-body clearfix">
										<div class="header">
											<strong class="primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong> <small class="pull-right text-muted">
												<span class="glyphicon glyphicon-time"></span>'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
								$message.='</small>
										</div>
										<p>'.$all_message['M']['message'].'</p>
									</div>
								</li>';
				}
			
			endforeach;
		}
		
		$this->set(compact('all_friends', 'message', 'friend_name', 'last_message_id','friend_id'));
	}
	
	public function insert_message(){
			 $userid = $this->Session->read('Auth.User.id');
			 $this->autoRender = false;
			 
			 $friend_id = $_REQUEST['friend_id'];
			 $message_text = $_REQUEST['message_text'];
			 
			 $this->request->data['Message']['from_id'] = $userid;
			 $this->request->data['Message']['to_id'] = $friend_id;
			 $this->request->data['Message']['message'] = $message_text;
			 $this->request->data['Message']['date_time'] = date('Y-m-d H:i:s');
			 
			 $user_details = $this->User->find('first', array('conditions' => array('User.id'  => $userid), 'fields' => array('User.first_name', 'User.last_name', 'User.image')));
			
			 $this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$last_message_id = $this->Message->getInsertID();
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($this->request->data['Message']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				$message = '<li class="right clearfix"><span class="chat-img pull-right">
						<img src="'.$this->webroot.'user_image/thumb/'.$user_details['User']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($this->request->data['Message']['date_time']));
                  }
								$message.='</small>
								<strong class="pull-right primary-font">'.$user_details['User']['first_name'].' '.$user_details['User']['last_name'].'</strong>
							</div>
							<p>'.$message_text.'</p>
						</div>
						</li>';	
			}
			echo $last_message_id."||".$message;
		
	}
	public function insert_message_footer(){
			 $userid = $this->Session->read('Auth.User.id');
			 $this->autoRender = false;
			 
			 $friend_id = $_REQUEST['friend_id'];
			 $message_text = $_REQUEST['message_text'];
			 
			 $this->request->data['Message']['from_id'] = $userid;
			 $this->request->data['Message']['to_id'] = $friend_id;
			 $this->request->data['Message']['message'] = $message_text;
			 $this->request->data['Message']['date_time'] = date('Y-m-d H:i:s');
			 
			 $user_details = $this->User->find('first', array('conditions' => array('User.id'  => $userid), 'fields' => array('User.first_name', 'User.last_name')));
			
			 $this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$last_message_id = $this->Message->getInsertID();
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($this->request->data['Message']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				$message = '<div class="msg_a">'.$message_text.'</div>';	
			}
			echo $last_message_id."||".$message;
		
	}
	
	public function user_message() {
		$userid = $this->Session->read('Auth.User.id');
		$friend_id = $_REQUEST['friend_id'];	
		$this->autoRender = false;
		
		$user_details = $this->User->find('first', array('conditions' => array('User.id'  => $friend_id), 'fields' => array('User.first_name', 'User.last_name')));
		$friend_name = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
		
		$this->Message->updateAll(
			array('Message.is_read' => "'Y'"), 
			array('Message.to_id' => $userid)
		); 
			 
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, U.image, M.id, M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) order by M.id desc limit 0,20");
		$message = "";
		
		if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) {
					$message .= '<li class="right clearfix"><span class="chat-img pull-right">
								<img src="'.$this->webroot.'user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>';
										if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
										 $message.='</small>
										<strong class="pull-right primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong>
									</div>
									<p>'.$all_message['M']['message'].'</p>
								</div>
								</li>';		
				}
				else
				{
					$message .= '<li class="left clearfix"><span class="chat-img pull-left">
									<img src="'.$this->webroot.'user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
									<div class="chat-body clearfix">
										<div class="header">
											<strong class="primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong> <small class="pull-right text-muted">
												<span class="glyphicon glyphicon-time"></span>'; 
												if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
												$message.='</small>
										</div>
										<p>'.$all_message['M']['message'].'</p>
									</div>
								</li>';
				}
			
			endforeach;
		}
		else
		{
			$last_message_id = "";
		}
			echo $last_message_id.'||'.$friend_name.'||'.$message;
	}
 public function footer_user_message()
 {
   
		$userid = $this->Session->read('Auth.User.id');
		$friend_id = $_REQUEST['friend_id'];	
		$this->autoRender = false;
		
		$user_details = $this->User->find('first', array('conditions' => array('User.id'  => $friend_id), 'fields' => array('User.first_name', 'User.last_name')));
		$friend_name = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
		
		$this->Message->updateAll(
			array('Message.is_read' => "'Y'"), 
			array('Message.to_id' => $userid)
		); 
			 
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, M.id, M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) order by M.id desc limit 0,20");
		$message = "";
		
		if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) {
					$message .= '<div class="msg_a">'.$all_message['M']['message'].'</div>
									';		
				}
				else
				{
					$message .= '<div class="msg_b">'.$all_message['M']['message'].'</div>';
				}
			
			endforeach;
		}
		else
		{
			$last_message_id = "";
		}
		$message.='<div class="msg_push"></div>';
			echo $last_message_id.'||'.$friend_name.'||'.$message;
	
 }
	public function latestMessage() {
		$userid = $this->Session->read('Auth.User.id');
		 $friend_id = $_REQUEST['friend_id'];
		 $last_message_id = $_REQUEST['last_message_id'];	
		$this->autoRender = false;
		$all_messages=array();
		if($last_message_id !=''){	
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, U.image, M.id,M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) having M.id > ".$last_message_id." order by M.id desc ");
		}
		$message = "";
		//pr($all_messages);exit;
		if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) {
					$message .= '<li class="right clearfix"><span class="chat-img pull-right">
								<img src="'.$this->webroot.'user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>'; 
												if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
												$message.='</small>
										<strong class="pull-right primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong>
									</div>
									<p>'.$all_message['M']['message'].'</p>
								</div>
								</li>';		
				}
				else
				{
					$message .= '<li class="left clearfix"><span class="chat-img pull-left">
									<img src="'.$this->webroot.'user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" />
								</span>
									<div class="chat-body clearfix">
										<div class="header">
											<strong class="primary-font">'.$all_message['U']['first_name'].' '.$all_message['U']['last_name'].'</strong> <small class="pull-right text-muted">
												<span class="glyphicon glyphicon-time"></span>'; 
												if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message.= $mins.'mins ago';
                  }
                  else
                  {
                  $message.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message.= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
                  }
												$message.='</small>
										</div>
										<p>'.$all_message['M']['message'].'</p>
									</div>
								</li>';
				}
			
			endforeach;
		}
		
			echo $last_message_id.'||'.$message;
	}
	public function latestMessage_footer() {
		 $userid = $this->Session->read('Auth.User.id');
		 $friend_id = $_REQUEST['friend_id'];
		 $last_message_id = $_REQUEST['last_message_id'];	
		$this->autoRender = false;
		$all_messages=array();
		if($last_message_id!=''){	
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, M.id,M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) having M.id > ".$last_message_id." order by M.id desc ");
		}
		$message = "";
		//pr($all_messages);
		if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				 if($all_message['U']['id'] == $userid) {
				 $last_message_id = $all_message['M']['id'];
					$message .= '<div class="msg_a">'.$all_message['M']['message'].'</div>';		
				}
				else
				{
					$message .= '<div class="msg_b">'.$all_message['M']['message'].'</div>';
				}
			
			endforeach;
			$message.='<div class="msg_push"></div>';
		}
		
			echo $last_message_id.'||'.$message;
	}
        
        
        public function latestMessage_footer_count() {
		 $userid = $this->Session->read('Auth.User.id');
		 //$friend_id = $_REQUEST['friend_id'];
		 //$last_message_id = $_REQUEST['last_message_id'];	
		$this->autoRender = false;
		//$all_messages=array();
		//if($last_message_id!=''){	
		//$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, M.id,M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = u.id and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = u.id and M.from_id=U.id) having M.id > ".$last_message_id." order by M.id desc ");
                
                $msgcount = $this->Message->find('count',array('conditions' => array('to_id' => $userid,'is_read' => 'N'),'group'=>'from_id'));
                
		//}
		//$message = "";
		//pr($all_messages);
		/*if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				 if($all_message['U']['id'] == $userid) {
				 $last_message_id = $all_message['M']['id'];
					$message .= $msgcount;		
				}
			
			endforeach;
			
		}*/
		
			echo $msgcount;
	}
        
        
        
        
	
	public function all_unreadmessage(){
		$userid = $this->Session->read('Auth.User.id');		
		$this->autoRender = false;
		$all_messages = $this->Message->find("all", array('conditions' => array('Message.to_id' => $userid), 'group'=>array('Message.from_id'),'order'=>array('Message.id'=>'desc'),'limit' => 10));
		$all_messagess = $this->Message->find("all", array('conditions' => array('Message.to_id' => $userid,'Message.is_read'=>'N'), 'group'=>array('Message.from_id'),'order'=>array('Message.id'=>'desc')));
		foreach($all_messagess as $all_messages)
		{
		   $mess['Message']['id']=$all_messages["Message"]["id"];
		$mess['Message']['is_read']='Y';
		$this->Message->save($mess);
		}
		$contents = '';
		foreach($all_messages as $all_message):
		//pr($frienddetail);
		
			$profile_image = ($all_message["User"]["image"] !="")? $this->webroot.'user_image/thumb/'.$all_message["User"]["image"] : 'user_image.png';
			
			$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['Message']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
			$contents .='<li>
							<div class="request-area">
								<div class="media">
								  <div class="media-left">
	
									<a href="'.$this->webroot.'users/user_profile/'.base64_encode($all_message["User"]["id"]).'"><img src="'.$profile_image.'" width="60" height="60"  alt=""/></a>
	
								  </div>
								  <div class="media-body">
									<div class="media-text">
									<a href="'.$this->webroot.'users/user_profile/'.base64_encode($all_message["User"]["id"]).'"><h5 class="media-heading">'.$all_message["User"]["first_name"].' '.$all_message["User"]["last_name"].'</h5></a>
									<p><a href="'.$this->webroot.'messages/index/'.$all_message["User"]["id"].'">'.$all_message["Message"]["message"].'</p></div>
									<div class="media-right" style="color:#909090;"><small>'; 
				if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $contents.= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $contents.= $mins.'mins ago';
                  }
                  else
                  {
                  $contents.= $hurs.'hrs ago';
                  }
                  }
                  else
                  {
                 $contents.= date('M d Y h:i A',strtotime($all_message['Message']['date_time']));
                  }
								$contents.='</small></div>
								  </div>
								  
								</div>
							</div>                       
							</li>';
		
		endforeach;
		echo $contents;
		
	}
// chat api/////
public function chat_list($userid='')
{
      $this->autoRender = false;
		$all_friends=$this->Friend->query("select U.id, U.first_name, U.last_name, U.image, U.is_loged from users as U, friends as F where (F.from_id =".$userid." and F.to_id = U.id and F.is_delete=0) or (F.to_id =".$userid." and F.from_id = U.id and F.is_delete=0) order by U.first_name"); 
		if(count($all_friends)>0)
		{
		foreach($all_friends as $key=>$allfrnd)
		{
		  $friend[$key]['id'] = $allfrnd['U']['id'];
		  $friend[$key]['name'] = $allfrnd['U']['first_name'].' '.$allfrnd['U']['last_name'];
		  $friend[$key]['image'] = (($allfrnd['U']['image'] != "")? Configure::read('SITE_URL').'/user_image/thumb/'.$allfrnd['U']['image'] : Configure::read('SITE_URL').'/user_image/thumb/user_image.png');
		   $friend[$key]['is_loged'] = $allfrnd['U']['is_loged'];
		}
		$data = array('Ack'=>1,'friends'=>$friend);	
		}
	   else
	   {
	     $data = array('Ack'=>0,'message'=>'No friends available');
	   }
	echo json_encode($data); 
	
}
public function chat_message($userid)
{ 
     $message='';
     $this->autoRender = false;
    $friend_id = $this->request->data('friend_id');
	$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, U.image, M.id,M.date_time, M.message, TIMESTAMPDIFF(SECOND, `date_time`, 'NOW()') as time from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) order by M.id desc limit 0,20");
		
		$all_messages = array_reverse($all_messages);
		//pr($all_messages);exit;
		$this->Message->updateAll(
			array('Message.is_read' => "'Y'"), 
			array('Message.to_id' => $userid)
		); 
		//pr($all_messages);exit;
		if(isset($all_messages)){
			foreach($all_messages as $key=>$all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) 
				{
					
					if($hurs <=24 && $hurs >= 0)
					 {
					 if($mins ==0)
					 {
					  $message_time= $diff_time.'sec ago';
					 }
					elseif($hurs == 0)
					 {
					 $message_time= $mins.'mins ago';
					  }
					  else
					  {
					  $message_time= $hurs.'hrs ago';
					  }
					  }
					  else
					{
					 $message_time= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
					  }
					  $message[$key]['name'] = $all_message['U']['first_name'].' '.$all_message['U']['last_name'];
					  $message[$key]['message']  = $all_message['M']['message'];
					  $message[$key]['message_time'] =  $message_time;	
					  $message[$key]['message_by'] = 1;
					   $message[$key]['image'] = (($all_message['U']['image'] != "")? Configure::read('SITE_URL').'/user_image/thumb/'.$all_message['U']['image'] : Configure::read('SITE_URL').'/user_image/thumb/user_image.png');
				}
				else
				{
					if($hurs <=24 && $hurs >= 0)
					 {
					 if($mins ==0)
					 {
					  $message_time= $diff_time.'sec ago';
					 }
					elseif($hurs == 0)
					 {
					 $message_time= $mins.'mins ago';
					  }
					  else
					  {
					  $message_time= $hurs.'hrs ago';
					  }
					  }
					  else
					{
					 $message_time= date('M d Y h:i A',strtotime($all_message['M']['date_time']));
					  }
					  $message[$key]['name'] = $all_message['U']['first_name'].' '.$all_message['U']['last_name'];
					  $message[$key]['message']  = $all_message['M']['message'];
					  $message[$key]['message_time'] =  $message_time;	
					  $message[$key]['message_by'] = 2;
					   $message[$key]['image'] = (($all_message['U']['image'] != "")? Configure::read('SITE_URL').'/user_image/thumb/'.$all_message['U']['image'] : Configure::read('SITE_URL').'/user_image/thumb/user_image.png');
				  }
			$message['last_id'] = $all_message['M']['id'];
			endforeach;
			$data = array('Ack'=>1,'chat_message'=>$message,'friend_id'=>$friend_id);	
		}
		else
		{
		 $data = array('Ack'=>0,'message'=>'No friends available');
		}
		
		echo json_encode($data);
}
public function insert_message_api($userid){
			 $this->autoRender = false;
			// echo $userid;exit;
			 $friend_id = $this->request->data('friend_id');
			 $message_text = $this->request->data('message_text');
			 
			 $this->request->data['Message']['from_id'] = $userid;
			 $this->request->data['Message']['to_id'] = $friend_id;
			 $this->request->data['Message']['message'] = $message_text;
			 $this->request->data['Message']['date_time'] = date('Y-m-d H:i:s');
			 
			 $user_details = $this->User->find('first', array('conditions' => array('User.id'  => $userid), 'fields' => array('User.first_name', 'User.last_name', 'User.image')));
			
			 $this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$last_message_id = $this->Message->getInsertID();
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($this->request->data['Message']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				$message = '<div class="sender-1  chat_row" >
						<div class="avatar-image"><img src="'.Configure::read('SITE_URL').'user_image/thumb/'.$user_details['User']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" /></div>
						'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message1= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message1.= $mins.'mins ago';
                  }
                  else
                  {
                  $message1.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message1.= date('M d Y h:i A',strtotime($this->request->data['Message']['date_time']));
                  }
								$message.='<div class="msg">'.$message_text.'</div>
						</div>';
						/*$message = '<li class="sender-2" >
		    		<div class="avatar-image"><img ng-src="$this->webroot.'/user_image/thumb/'.$user_details['User']['image']"></div>
		    		<div class="msg">
		    			.'$message_text'.
		    		</div>
		    	</li>';*/
				      /*$message[$key]['name'] = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
					  $message[$key]['message']  =$message_text;
					  //$message[$key]['message_time'] =  $message_time;	
					  $message[$key]['message_by'] = 0;
					   $message[$key]['image'] = (($user_details['User']['image'] != "")? Configure::read('SITE_URL').'/user_image/thumb/'.$user_details['User']['image'] : Configure::read('SITE_URL').'/user_image/thumb/user_image.png');*/
			}
			$data = array('Ack'=>1,'inst_message'=>$message,'last_id'=>$last_message_id);
			echo json_encode($data);
		
	}
		public function latestMessage_api($userid) {
		//$userid = $this->Session->read('Auth.User.id');
		
		 $friend_id =$this->request->data('friend_id');
		$last_message_id = $this->request->data('last_id');	
		$this->autoRender = false;
		$all_messages=array();
		if($last_message_id !=''){	
		$all_messages = $this->Message->query("select U.id, U.first_name, U.last_name, U.image, M.id,M.date_time, M.message from users as U, messages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) having M.id > ".$last_message_id." order by M.id desc ");
		}
		$message = "";
		if(count($all_messages) > 0){
			$all_messages = array_reverse($all_messages);
			foreach($all_messages as $all_message):
				$last_message_id = $all_message['M']['id'];
				$curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['M']['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
				if($all_message['U']['id'] == $userid) {
					$message .= '<div class="sender-1  chat_row" >
						<div class="avatar-image"><img src="'.Configure::read('SITE_URL').'/user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" /></div>
						'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message1= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message1.= $mins.'mins ago';
                  }
                  else
                  {
                  $message1.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message1.= date('M d Y h:i A',strtotime($this->request->data['Message']['date_time']));
                  }
								$message.='<div class="msg">'.$all_message['M']['message'].'</div>
						</div>';;		
				}
				else
				{
					$message .= '<div class="sender-2 chat_row" >
						<div class="avatar-image"><img src="'.Configure::read('SITE_URL').'/user_image/thumb/'.$all_message['U']['image'].'" alt="User Avatar" class="img-circle" style="width: 50px;" /></div>
						'; 
								if($hurs <=24 && $hurs >= 0)
                 {
				 if($mins ==0)
				 {
				  $message1= $diff_time.'sec ago';
				 }
                elseif($hurs == 0)
                 {
                 $message1.= $mins.'mins ago';
                  }
                  else
                  {
                  $message1.= $hurs.'hrs ago';
                  }
                  }
                  else
                {
                 $message1.= date('M d Y h:i A',strtotime($this->request->data['Message']['date_time']));
                  }
								$message.='<div class="msg">'.$all_message['M']['message'].'</div>
						</div>';;		
				}
			
			endforeach;
			$data = array('Ack'=>1,'update_message'=>$message,'last_id'=>$last_message_id);
		}
		else
		{
		  $data = array('Ack'=>0,'message'=>'No message available');
		}
		echo json_encode($data);	
	}
}
?>
