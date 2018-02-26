<?php
App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator','Session');
    public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('index','fblogin','twitterlogin','home','vendor_change_password','change_password','active_account','signin','forgot_password','login','admin_index','admin_middle_list','admin_captcha','admin_login','admin_fotgot_password','activation','post_ad','dashboard','search','mapframe','mapframe1','autoLogin','autosignup','autosignuplogin','gpluslogin','thankyou','emailExists','appsignup','appsignin','appforgotpass','applogout','get_user_details','edit_photoservice','edit_profileservice','edit_shopservice','viewservice','app_update_email','verification_code','app_password_updated','registration', 'contactus');
   }
/**
 * index method
 *
 * @return void
 */
	
   
   public function index(){        	
          $title_for_layout='Home';
        
          $this->loadModel('Category');
          $this->loadModel('Banner');
          $this->loadModel('Advertise');
          $this->loadModel('Shop');
          $this->loadModel('City');
           

          $allcategory = $this->Category->find("all",array('conditions'=>array('is_active'=> 1, 'type' => 'D')));
          $popular_category = $this->Category->find("all",array('conditions'=>array('is_active'=> 1, 'is_popular' => 1)));
          $video = $this->Banner->find("first",array('conditions'=>array('is_active'=> 1)));

          $advertise = $this->Advertise->find("first",array('conditions'=>array('status'=> 1)));

          $shops = $this->Shop->find("all",array('conditions'=>array('Shop.is_active'=> 1), 'fields'=>array('Shop.id', 'Shop.name')));

          
       	  $this->set(compact('allcategory', 'popular_category', 'video', 'advertise', 'shops'));
                
    }
   
	public function admin_index() {  
			$userid = $this->Session->read('Auth.User.id');

    	if(isset($userid) && $userid!=''){
    	   //$this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
    	   return $this->redirect(array('action' => 'dashboard','controller'=>'users'));
    	}
      $title_for_layout='Admin Login';
      $this->User->recursive = 0;
      $this->set('users', $this->Paginator->paginate());
      $this->set(compact('title_for_layout'));
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
	   if (!$this->User->exists($id)) {
	      throw new NotFoundException(__('Invalid user'));
	   }
	   $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	   $this->set('user', $this->User->find('first', $options));
	}
        public function viewservice() {
           $data=array() ;
           $id=$_REQUEST['user_id']; 
	   if (!$this->User->exists($id)) {
	   $data['Ack']=0;   
	   }
           $SITE_URL=  Configure::read('SITE_URL');
	   $uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
	   $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	   $user= $this->User->find('first', $options);
           $data['Ack']=1;
           if(!empty($user['User']['profile_image']))
           {
              $user['User']['profile_image']=$SITE_URL.'user_images/'.$user['User']['profile_image']; 
           }
            else 
            {
              $user['User']['profile_image']=''; 
            }
           if($user['User']['gender']=='M')
           {
              $user['User']['gender']='Male'; 
           }
           else 
           {
              $user['User']['gender']='Female'; 
           }
           $data['UserDetails']=$user['User'];
           echo json_encode($data);
           exit;
           
           
	}
        

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	
        
        public function forgot_password()
        {		
	  $userid = $this->Session->read('Auth.User.id');
          $utype = $this->Session->read('Auth.User.type');
	  if(isset($userid) && $userid!='' && $utype=='C'){
		return $this->redirect(array('action' => 'dashboard'));
	  }elseif(isset($userid) && $userid!='' && $utype=='V'){
              return $this->redirect(array('action' => 'vendor_dashboard'));
          }
	  if ($this->request->is(array('post'))) 
	  {
	     if($this->request->data['User']['forgotemail']=='')
	     {
	         $this->Session->setFlash(__('Please enter your email.', 'default', array('class' => 'error')));
	         return $this->redirect($this->request->referer());
	     }
	     else
	     {
		if(!filter_var($this->request->data['User']['forgotemail'], FILTER_VALIDATE_EMAIL))
	        {
	          $this->Session->setFlash(__('Please enter valid email.', 'default', array('class' => 'error')));
	          return $this->redirect($this->request->referer());
	        }
	        else
	        {
		  $options = array('conditions' => array('User.email' => $this->request->data['User']['forgotemail']));
		  $user = $this->User->find('first', $options); 
		  if($user)
		  {
		     $password = $this->User->get_fpassword();
                     $this->request->data['User']['id'] = $user['User']['id'];
		     $this->request->data['User']['password'] = $password;
                     $this->request->data['User']['txt_password']=$password;
		     if ($this->User->save($this->request->data)) 
		     {
			   //$key = Configure::read('CONTACT_EMAIL');
			   $this->loadModel('EmailTemplate');
			   $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>3)));

			   $mail_body =str_replace(array('[EMAIL]','[PASSWORD]'),array($this->request->data['User']['forgotemail'],$password),$EmailTemplate['EmailTemplate']['content']);

			   $this->send_smtpmail($this->request->data['User']['forgotemail'],'nits.santanupatra@gmail.com',$EmailTemplate['EmailTemplate']['subject'],$mail_body);

			   $this->Session->setFlash('A new password has been sent to your mail. Please check mail.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action'=> 'login'));
		     }
		     else 
	             {
		       $this->Session->setFlash("Sorry! some internal error occurred. Please try again later.");
		       return $this->redirect($this->request->referer());
		     }
	          } 
	          else 
	          {
	           $this->Session->setFlash("Sorry! we can not find your email.");
		   return $this->redirect($this->request->referer());
	          }
	        }
	      }
          }
        }
        
        public function contactus(){
            
            $this->loadModel('User');
	  
	  if ($this->request->is(array('post'))) 
	  {
	     
                     $name = $this->request->data['User']['name'];
		     $email = $this->request->data['User']['email'];
                     $phone = $this->request->data['User']['phone'];
                     $message = $this->request->data['User']['message'];
		     
			   //$key = Configure::read('CONTACT_EMAIL');
			   $this->loadModel('EmailTemplate');
			   $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>20)));
                           $this->loadModel('SiteSetting');
                           $contactemail=$this->SiteSetting->find('first',array('conditions'=>array('SiteSetting.id'=>1)));

			   $mail_body =str_replace(array('[NAME]','[EMAIL]','[PHONE]','[MESSAGE]'),array($name,$email,$phone,$message),$EmailTemplate['EmailTemplate']['content']);

			  $res= $this->send_smtpmail($contactemail['SiteSetting']['contact_email'],'nits.santanupatra@gmail.com',$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                           
                           

			   $this->Session->setFlash('Your query successfully send.', 'default', array('class' => 'success'));
                           
			   //return $this->redirect(array('action'=> 'login'));
		     }		    
	           
          } 
            

        

        public function login(){
            
      $userid = $this->Session->read('Auth.User.id');
      $is_admin = $this->Session->read('Auth.User.is_admin');
      $utype = $this->Session->read('Auth.User.type');
      
      $title_for_layout = 'Sign In';
      

      if(isset($userid) && $userid!='' && $is_admin!=1){
         return $this->redirect(array('action' => 'home'));
      }else{
      if ($this->request->is('post')) 
	     {
	        
		        if($this->Auth->login()) 
		        {
			        $is_admin = $this->Session->read('Auth.User.is_admin');
			        $is_active = $this->Session->read('Auth.User.is_active');
                                $utype = $this->Session->read('Auth.User.type');
                                
			        if($is_admin!=1 && $is_active==1 && $utype=='C')
			        {
                                  				
			          return $this->redirect($this->Auth->redirect('dashboard'));
                                  
                                  
			        }else if($is_admin!=1 && $is_active==1 && $utype=='V'){
                                    
                   return $this->redirect($this->Auth->redirect('vendor_dashboard')); 
                }
			        else
			        {
			          $this->Auth->logout();
			          $this->Session->setFlash(__('You are not authorize to access.', 'default', array('class' => 'error')));
			          //return $this->redirect(array('action' => 'index'));
			        }
		        }
		        else
		        {
		           $this->Session->setFlash(__('Invalid Email or Password, Please try again.', 'default', array('class' => 'error')));
		           //return $this->redirect(array('action' => 'index'));
		        }
	        
	      }
      }
      $this->set(compact('title_for_layout'));
  }
        
       
    public function registration(){
        
      $title_for_layout = 'Registration';
	
	    $userid = $this->Session->read('Auth.User.id');
      $checkid = $this->Session->read('Auth.User.is_admin');
	if(isset($userid) && $userid=='' && $checkid!=1)
	{
		return $this->redirect(array('action' => 'dashboard'));
	}
	if ($this->request->is('post')) { 
		$options = array('conditions' => array('User.email'  => $this->request->data['User']['email']));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists)
		{

		 $txtpass = $this->request->data['User']['password'];
                 $con_txtpass = $this->request->data['User']['con_password'];
                 if($txtpass==$con_txtpass){
                      $this->request->data['User']['type']= $this->request->data['User']['type'];                
      	              $this->request->data['User']['first_name']=$this->request->data['User']['first_name'];
                      $this->request->data['User']['last_name']=$this->request->data['User']['last_name'];
                      $this->request->data['User']['email']=$this->request->data['User']['email'];
                      $this->request->data['User']['address']=$this->request->data['User']['address'];
                      $this->request->data['User']['city']=$this->request->data['User']['city'];
                      $this->request->data['User']['state']=$this->request->data['User']['state'];
                      $this->request->data['User']['country']=$this->request->data['User']['country'];
                      $this->request->data['User']['registration_date'] = date('Y-m-d');
                      $this->request->data['User']['is_admin'] = 0;
                      //$this->request->data['User']['is_active'] = 1;
                      $this->request->data['User']['pass_app']=md5($this->request->data['User']['password']);
                      $this->request->data['User']['txt_password']=$this->request->data['User']['password'];
                      $this->request->data['User']['verification_code']='';
                      $this->request->data['User']['password']=$this->request->data['User']['password'];
                      $this->User->create();
		 if ($this->User->save($this->request->data)) 
		  {
                       /*if($this->request->data['User']['type']=='V'){ 
		  	$this->loadModel('Shop');

            $this->request->data['Shop']['user_id'] = $this->User->getInsertID();
            $this->request->data['Shop']['name'] =$this->request->data['User']['first_name'];// $this->request->data['Shop']['company_name'];
            
                $this->Shop->create();
                          $this->Shop->save($this->request->data);
                       }*/



              $options = array('conditions' => array('User.id' => $this->User->getLastInsertId()));
              $lastInsetred = $this->User->find('first', $options);


              $opt= array('conditions' => array('User.is_admin' => 1));
              $lastadmin= $this->User->find('first', $opt);


                $this->loadModel('EmailTemplate');
                $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>2)));
                $siteurl= Configure::read('SITE_URL');

                $LOGINLINK=$siteurl.'users/active_account/'.base64_encode($lastInsetred['User']['id']);
                
                if($lastInsetred['User']['type']=='C'){
                
                $msg_body =str_replace(array('[NAME]','[EMAIL]','[PASSWORD]','[LINK]'),array($lastInsetred['User']['first_name'],$lastInsetred['User']['email'], $txtpass, $LOGINLINK),$EmailTemplate['EmailTemplate']['content']);
                }else{

              $text='admin activate your account soon because permission required';      
            $msg_body =str_replace(array('[NAME]','[EMAIL]','[PASSWORD]','[LINK]'),array($lastInsetred['User']['first_name'],$lastInsetred['User']['email'], $txtpass,$text),$EmailTemplate['EmailTemplate']['content']);
                    
                }
                $subject_mail="Registration";
                
                
                $this->send_smtpmail($lastInsetred['User']['email'], 'nits.santanupatra@gmail.com', $subject_mail, $msg_body);

            $this->Session->setFlash('Registration Successfull. Thank You!', 'default', array('class' => 'success'));
              return $this->redirect(array('action' => 'login'));
            
                 }
		  else 
		  {
			$this->Session->setFlash(__('Registration failed. Please, try again.', 'default', array('class' => 'error')));
		  }
		 
	  }else{
              $this->Session->setFlash(__('Password and confirm password not matched.', 'default', array('class' => 'error')));
          }
                }
	  else {
			$this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
		}  
	  } 
   
  } 
  
  
  public function active_account($code){ //echo "nvbn";exit;

    $userid = base64_decode($code);
//echo $userid;exit;

    $data['User']['id']=$userid;
    $data['User']['is_active']=1;
      if($this->User->save($data)){
        $this->Session->setFlash('Your account hasbeen activated.', 'default', array('class' => 'success'));
        return $this->redirect(array('action' => 'login'));
      }
      else {
        $this->Session->setFlash('Wrong information.', 'default');
        return $this->redirect(array('action' => 'registartion'));
      }


  }
  
  
        
        
        public function verification_code(){
            $this->loadModel('UserLocation');
            $userid = $this->Session->read('Auth.User.id');
            $TempUserId = $this->Session->read('TempUserId');
            if(isset($userid) && $userid!=''){
                return $this->redirect(array('action' => 'dashboard'));
            }
            if(isset($TempUserId) && $TempUserId==''){
                return $this->redirect(array('action' => 'signin'));
            }
            $title_for_layout='Verification Code';
            
            if ($this->request->is(array('post'))){
                
                $options = array('conditions' => array('User.id' => $TempUserId));
                $user = $this->User->find('first', $options); 
                $verification_code=$user['User']['verification_code'];
                $req_verification_code=$this->request->data['User']['verification_code'];
                if($req_verification_code==$verification_code){
                    $this->request->data['User']['email']=$user['User']['email'];
                    $this->request->data['User']['password']=$user['User']['txt_password'];
                    
                    if($this->Auth->login()){
                        $ip = $_SERVER['REMOTE_ADDR']; 
                        $location_query = unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                        $countryCode=isset($location_query['countryCode'])?$location_query['countryCode']:'';
                        if($countryCode!=''){            
                            $data_code['UserLocation']['user_id'] = $TempUserId;
                            $data_code['UserLocation']['ip'] = $ip;
                            $data_code['UserLocation']['country_code'] = $countryCode;
                            $data_code['UserLocation']['cdate'] = gmdate('Y-m-d H:i:s');
                            $this->UserLocation->create();
                            $this->UserLocation->save($data_code);
                        }   
                        
                        $description = 'Logged in User : '.$user['User']['email'];
                        $this->save_activity($TempUserId,$description);
                        $this->Session->delete('TempUserId');
                        $this->Session->setFlash('You have successfully logged in.', 'default', array('class' => 'success'));
                        return $this->redirect($this->Auth->redirect('edit-profile'));
                    }else{
                        $this->Session->setFlash(__('You enter wrong OTP.', 'default', array('class' => 'error')));
                        //return $this->redirect($this->request->referer());
                    }
                }else{
                    $this->Session->setFlash(__('You enter wrong OTP.', 'default', array('class' => 'error')));
                }
            }
            $this->set(compact('title_for_layout'));
        }
        
        public function logout() 
        {
	  $user_id = $this->Session->read('Auth.User.id');
          $utype = $this->Session->read('Auth.User.type');
	  $this->Auth->logout();
	  
	  $description = 'User Logout ';
	  $this->save_activity($user_id,$utype,$description);
	  
	  //$this->Session->setFlash('You have successfully logged out.', 'default', array('class' => 'success'));
	  $this->redirect('/');
        }
        
        
         public function fblogin()
    {
    	$this->autoRender = false;
           
    	$fb_id=$this->User->find("first",array('conditions'=>array('User.facebook_id'=>$this->request->data['User']['facebook_id'])));
    	
    	if(count($fb_id)<1)
    	{
          //$email=$this->request->data('email_address');
    		if(isset($this->request->data['User']['email']))
    	{
             $email=$this->User->find("first",array('conditions'=>array('User.email'=>$this->request->data['User']['email'])));
              if(count($email)<1)
              {
              	$this->User->save($this->request->data);
              	$user=$this->User->find("first",array('conditions'=>array('User.email'=>$this->request->data['User']['email'])));
              	

            //log in the user with facebook credentials
            $this->Auth->login($user['User']);
				//$this->Auth->login() ;
			
				$data['url']= $this->webroot.'users/home';
				//$data['url']= $this->webroot;
				$data['is_active']=1;
              }
              else
              {
                 $data=''; 
              }
          }
          else
          {
          	//pr($this->request->data);exit;
          	//echo "fghfgh";exit;
             $this->User->save($this->request->data);
			
              	$user=$this->User->find("first",array('conditions'=>array('User.facebook_id'=>$this->request->data['User']['facebook_id'])));
				 $this->Auth->login($user['User']) ;
              	//$this->Session->write('userid', $user['User']['id']);
                //$this->Session->write('username', $user['User']['first_name']);
				//$this->Session->write('user_type', $user['User']['user_type']);
				$data['url']=Configure::read('SITE_URL').'users/home';
				//$data['url']=Configure::read('SITE_URL');
				$data['is_active']=1;//$user['User']['status'];
          }
    	}
    	else
    	{
		
            $this->Auth->login($fb_id['User']) ;
			//pr($this->Session->read());exit;
				$data['url']=Configure::read('SITE_URL').'users/home';
				//$data['url']=Configure::read('SITE_URL');
				$data['status']=1;//$user['User']['status'];


    	}

    	echo json_encode($data);
    	
    }
    
    
    function twitterlogin()
	{
	require_once(ROOT . '/app/Vendor'.DS.'twitteroauth.php');
	$this->autoRender = false;
	//Configure::load('Twitter.twitter', 'default', false);	
		$this->consumerKey ='5LGzwxXxmzPYn3wmd6nEmkfWg';// Configure::read('Twitter.consumerKey');
		$this->consumerSecret = 'kYhRXBtQEVbTwoSNpaRYRCGs5YkYBXRXoMQmfJGXNOmCWTBqZv';//Configure::read('Twitter.consumerSecret');
		$this->callback = 'http://111.93.169.90/team6/widding/users/twitterlogin';//Configure::read('Twitter.call_back');
		//echo $this->consumerKey;exit;
		//pr($this->Session->read('token'));
		//pr($_SESSION['token']);
		//pr($this->request);exit;
		//echo"jh";
		//pr($this->Session->read('token'));exit;
	  if(isset($_REQUEST['oauth_token']) && $this->Session->read('token')  !== $_REQUEST['oauth_token']) {
       //echo "token here";exit;
	//If token is old, distroy session and redirect user to index.php
	session_destroy();
	//header('Location: index.php');
	$this->redirect(array("controller" => "users", 
                      "action" => "login"
                      ));
	
}elseif(isset($_REQUEST['oauth_token']) && $this->Session->read('token') == $_REQUEST['oauth_token']) {
       //echo "success";exit;
	//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $_SESSION['token'] , $_SESSION['token_secret']);
        //print_r($connection);exit;
	 $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
         //print_r($access_token);exit;
	if($connection->http_code == '200')
	{
		//Redirect user to twitter
		//$_SESSION['status'] = 'verified';
		//$_SESSION['request_vars'] = $access_token;
		$this->Session->write('status','verified');
		$this->Session->write('request_vars',$access_token);
		//Insert user into the database
		$user_info = $connection->get('account/verify_credentials'); 
		//pr($user_info);exit;
                //echo $user_info->name.'sp';exit;
		$twitter_id=$this->User->find("first",array('conditions'=>array('User.twitter_id'=>$user_info->id)));
		if(count($twitter_id)<1){
		$name = explode(" ",$user_info->name);
		$this->request->data['first_name'] = isset($name[0])?$name[0]:'';
		$this->request->data['last_name'] = isset($name[1])?$name[1]:'';
		$this->request->data['twitter_id'] = $user_info->id;
		$this->request->data['is_active']=1;
		//$this->request->data['created_at']=date("Y-m-d h:i:s");
		//$this->request->data['image']=$user_info->profile_image_url;
		//$this->request->data['cover_image']=$user_info->profile_banner_url;
               // print_r ($this->request->data);exit;
		$this->User->save($this->request->data);
		//$db_user->checkUser('twitter',$user_info->id,$user_info->screen_name,$fname,$lname,$user_info->lang,$access_token['oauth_token'],$access_token['oauth_token_secret'],$user_info->profile_image_url);
		$user=$this->User->find("first",array('conditions'=>array('User.twitter_id'=>$this->request->data['twitter_id'])));
				 $this->Auth->login($user['User']) ;
              	$this->Session->write('userid', $user['User']['id']);
                $this->Session->write('username', $user['User']['first_name']);
				
		//Unset no longer needed request tokens
		unset($_SESSION['token']);
		unset($_SESSION['token_secret']);
		//header('Location: index.php');
		$this->redirect(array("controller" => "users", 
                      "action" => "home"
                      ));
			}
			else
			{
			  $this->Auth->login($twitter_id['User']) ;
              	$this->Session->write('userid', $twitter_id['User']['id']);
                $this->Session->write('username', $twitter_id['User']['first_name']);
				
		//Unset no longer needed request tokens
		unset($_SESSION['token']);
		unset($_SESSION['token_secret']);
		//header('Location: index.php');
		$this->redirect(array("controller" => "users", 
                      "action" => "home"
                      ));
			}
	}else{
	
		die("error, try again later!");
	}
		
}else{
      //echo "an error o";exit;
	if(isset($_GET["denied"]))
	{
		//header('Location: index.php');
		//die();
		echo "denied";exit;
	}

	//Fresh authentication
	$connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
	$request_token = $connection->getRequestToken($this->callback);
	//pr($request_token);exit;
	//Received token info from twitter
	//$_SESSION['token'] 			= $request_token['oauth_token'];
	//$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
	$this->Session->write('token',$request_token['oauth_token']);
	$this->Session->write('token_secret',$request_token['oauth_token_secret']);
	//Any value other than 200 is failure, so continue only if http code is 200
	if($connection->http_code == '200')
	{
		//redirect user to twitter
		//pr($request_token);exit;
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
		//pr($twitter_url);exit;
		//header('Location: ' . $twitter_url); 
		$this->redirect($twitter_url);
	}else{
		die("error connecting to twitter! try again later!");
	}
}
	}
        
        
        public function home() {
          
            $title_for_layout='Home';
	           $userid = $this->Session->read('Auth.User.id');
        
	
         if(!isset($userid) && $userid=='')
            {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller'=>'users','action' => 'login'));
            }
            
            
            $this->loadModel('OrderDetail');  
            //purchase count
            $con = array('conditions' => array('OrderDetail.user_id' => $userid));
            $totpurchase = $this->OrderDetail->find('count', $con); 
            
            //latest purchase
            $conp = array('conditions' => array('OrderDetail.user_id' => $userid),'order'=>array('OrderDetail.id'=>'desc'),'limit'=>3);
            $latestpurchase = $this->OrderDetail->find('all', $conp); 
            
            
            //order count
            $con1 = array('conditions' => array('OrderDetail.owner_id' => $userid));
            $totorder = $this->OrderDetail->find('count', $con1); 
            
            $this->loadModel('Product'); 
            //product count
            $con2 = array('conditions' => array('Product.user_id' => $userid));
            $totproduct = $this->Product->find('count', $con2); 
            
            
            
            
            
            $this->set(compact('title_for_layout','latestpurchase','totpurchase','totorder','totproduct'));
         
            
        }
        
        
        public function vendor_request() {
            $this->loadModel('VendorRequest');
            $title_for_layout='Setting';
	$userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
	
         if(!isset($userid) && $userid=='' && $utype!='C')
            {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller'=>'users','action' => 'login'));
            }
            if($this->request->is(array('post'))){
                $options = array('conditions' => array('VendorRequest.user_id'  => $userid));
		$exists = $this->VendorRequest->find('first', $options);
                if(!$exists){
                $this->request->data['VendorRequest']['user_id']=$userid;
                $this->request->data['VendorRequest']['utype_request']='V';
                $this->request->data['VendorRequest']['status']='pending';
                $this->VendorRequest->create();
		 if ($this->VendorRequest->save($this->request->data)) 
		  {
                   
                  $this->Session->setFlash('Request send Successfully. Thank You!', 'default', array('class' => 'success'));
              
            
                 }
		  else 
		  {
			$this->Session->setFlash(__('Request send failed. Please, try again.', 'default', array('class' => 'error')));
		  }
                }else{
                    
                  $this->Session->setFlash(__('Already send request. Please Wait for admin confirmation.', 'default', array('class' => 'error')));  
                }
                 
            $options = array('conditions' => array('User.is_admin' => 1));
            $adminemail = $this->User->find('first', $options);
            
            $options1 = array('conditions' => array('User.id' => $userid));
            $useremail = $this->User->find('first', $options1);
            $mail=$useremail['User']['email'];
            
            //pr($useremail);
         
                $siteurl= Configure::read('SITE_URL');

                $text="Your request send successfully" ;
                
                $textforadmin ="Request come from $mail";
                  
            $msg_body = $text;
                    
                
                $subject_mail= "Request For Vendor";
                
                
                $this->send_smtpmail($useremail['User']['email'], 'nits.santanupatra@gmail.com', $subject_mail, $msg_body);
            
                
                 $this->send_smtpmail($adminemail['User']['email'], 'nits.santanupatra@gmail.com', $subject_mail, $textforadmin);

        $this->set(compact('title_for_layout'));
         
            }    
        }
        
        
        public function admin_vendor_request_list() {
            $this->loadModel('VendorRequest');
            $userid = $this->Session->read('Auth.User.id');
                
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Vendor Request List';
                $this->paginate = array('order' => array('VendorRequest.id' => 'desc'));
		$this->Middle->recursive = 0;
                $this->Paginator->settings = $this->paginate;
                
		$this->set('vendorrequests', $this->Paginator->paginate('VendorRequest'));
		$this->set(compact('title_for_layout'));
         
                
        }
        
        public function admin_vendor_request_edit($id = null) {
            $this->loadModel('VendorRequest');
            $this->loadModel('User');
	    $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}

	    $this->request->data1=array();
		$title_for_layout = 'Edit vendor request';
		
		
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid Id'));
		}
		if ($this->request->is(array('post', 'put'))) {

                        $this->request->data['User']['type'] = 'V';
                   
			if ($this->User->save($this->request->data)) {
                            
              $this->VendorRequest->updateAll(array('VendorRequest.status' => "'approved'"),array('VendorRequest.user_id'=> $id));
              
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $usermail= $this->User->find('first', $options);
                $siteurl= Configure::read('SITE_URL');

                $text="Your request accepted by admin. Now you can login as a vendor" ;
                $msg_body = $text;
                $subject_mail= "Request Confirmation";
                
                
                $this->send_smtpmail($usermail['User']['email'], 'nits.santanupatra@gmail.com', $subject_mail, $msg_body);
            
        
				$this->Session->setFlash('User upgraded as a vendor.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'vendor_request_list'));
			} else {
				$this->Session->setFlash(__('User not upgraded. Please, try again.'));
			}
		}

                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);

                $this->set(compact('title_for_layout'));

       
    }
        
        
        
        
         public function dashboard() 
      {
        $title_for_layout='Dashboard';
	$userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
	$this->loadModel('User');
	if(isset($userid) && $userid!='' && $utype=='C'){
            
           if($this->request->is(array('post', 'put'))) {
            $options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !='  => $userid));
            $emailexists = $this->User->find('first', $options);
            if(!$emailexists){
                
             $this->request->data['User']['first_name'] = $this->request->data['User']['first_name'];
             $this->request->data['User']['last_name'] = $this->request->data['User']['last_name'];
             $this->request->data['User']['email'] = $this->request->data['User']['email'];
             $this->request->data['User']['mobile_number'] = $this->request->data['User']['mobile_number'];
            
            if ($this->User->save($this->request->data)) {

        
				$this->Session->setFlash('Profile successfully updated.','default', array('class' => 'success'));
				
			} else {
				$this->Session->setFlash(__('Profile could not be updated. Please, try again.'));
			}    
                
                
            }else{
                
              $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
                return $this->redirect($this->request->referer());  
                
            }
          }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
	$this->set(compact('user','title_for_layout'));    
	}
	else
        {
	     $this->Session->setFlash(__('Please login to access dashboard.', 'default', array('class' => 'error')));
	     return $this->redirect(array('action' => 'login'));
	}
	$this->set(compact('title_for_layout'));
      }
        
      
       public function vendor_dashboard() 
      {
          $title_for_layout='Dashboard';
        	$userid = $this->Session->read('Auth.User.id');
          $utype = $this->Session->read('Auth.User.type');
          $this->loadModel('User');
        	if(isset($userid) && $userid!='' && $utype=='V'){
                    
             if($this->request->is(array('post', 'put'))) {
              $options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !='  => $userid));
              $emailexists = $this->User->find('first', $options);
              if(!$emailexists){
                        
            $this->request->data['User']['first_name'] = $this->request->data['User']['first_name'];
            $this->request->data['User']['last_name'] = $this->request->data['User']['last_name'];
            $this->request->data['User']['email'] = $this->request->data['User']['email'];
            $this->request->data['User']['mobile_number'] = $this->request->data['User']['mobile_number'];
            $this->request->data['User']['company_name'] = $this->request->data['User']['company_name'];
            $this->request->data['User']['dba'] = $this->request->data['User']['dba'];
            $this->request->data['User']['ein'] = $this->request->data['User']['ein'];
                    
            if ($this->User->save($this->request->data)) {
        				$this->Session->setFlash('Profile successfully updated.','default', array('class' => 'success'));
        				
        			} else {
        				$this->Session->setFlash(__('Profile could not be updated. Please, try again.'));
        			}    
                        
                        
              }else{
                  
                $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
                  return $this->redirect($this->request->referer());  
                  
              }
                    
                    
                   }
                    
                    
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
        	$user=$this->User->find('first', $options);
        	$this->set(compact('user','title_for_layout'));    
        	}
        	else
                {
        	     $this->Session->setFlash(__('Please login to access dashboard.', 'default', array('class' => 'error')));
        	     return $this->redirect(array('action' => 'login'));
        	}
        	$this->set(compact('title_for_layout'));
      }
      

          public function vendor_change_password(){ 

            $title_for_layout='Change Password';
            $userid = $this->Session->read('Auth.User.id');
            $utype = $this->Session->read('Auth.User.type');
            if((!isset($userid) && $userid=='') || $utype!='V')
            {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('action' => 'login'));
            }
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $user=$this->User->find('first', $options);
            if ($this->request->is(array('post', 'put'))){
            	//print_r($this->request->data);exit;
               $prev_pass=$user['User']['password'];
               $new_pass=$this->request->data['User']['new_password'];
               $od = AuthComponent::password($this->request->data['User']['current_password']);
    // if($od != $this->field('password'))
                 if($prev_pass != $od){
                     $this->Session->setFlash('Invalid current password.', 'default', array('class' => 'error'));
                     return $this->redirect(array('action' => 'vendor_change_password'));
                 }else{
                    if($this->request->data['User']['new_password'] == $this->request->data['User']['con_password']){
                        $user_data_auth['User']['id']=$userid;
                        $user_data_auth['User']['password']=$new_pass;
                        if($this->User->save($user_data_auth)){
                            $this->Session->setFlash('Password updated successfully.', 'default', array('class' => 'success'));
                            //return $this->redirect(array('action' => 'changepassword_success'));
                        }
                    }else {
                            $this->Session->setFlash('Password Does not matched.', 'default', array('class' => 'error'));
                            //return $this->redirect(array('action' => 'change_password'));
                    }
               }
            }
            $this->set(compact('user','title_for_layout'));
        }
      
        public function change_password(){ 

            $title_for_layout='Change Password';
            $userid = $this->Session->read('Auth.User.id');
            $utype=$this->Session->read('Auth.User.type');
            if((!isset($userid) && $userid=='') || $utype!='C')
            { 
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('action' => 'login'));
            }
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $user=$this->User->find('first', $options);
            if ($this->request->is(array('post', 'put'))){
            	//print_r($this->request->data);exit;
               $prev_pass=$user['User']['password'];
               $new_pass=$this->request->data['User']['new_password'];
               $od = AuthComponent::password($this->request->data['User']['current_password']);
    // if($od != $this->field('password'))
                 if($prev_pass != $od){
                     $this->Session->setFlash('Invalid current password.', 'default', array('class' => 'error'));
                     return $this->redirect(array('action' => 'change_password'));
                 }else{
                    if($this->request->data['User']['new_password'] == $this->request->data['User']['con_password']){
                        $user_data_auth['User']['id']=$userid;
                        $user_data_auth['User']['password']=$new_pass;
                        if($this->User->save($user_data_auth)){
                            $this->Session->setFlash('Password updated successfully.', 'default', array('class' => 'success'));
                            //return $this->redirect(array('action' => 'changepassword_success'));
                        }
                    }else {
                            $this->Session->setFlash('Password Does not matched.', 'default', array('class' => 'error'));
                            //return $this->redirect(array('action' => 'change_password'));
                    }
               }
            }
            $this->set(compact('user','title_for_layout'));
        }
      
      public function edit_profile($type=null) {
	$title_for_layout='Edit Profile';
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid==''){
	   $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	   return $this->redirect(array('action' => 'signin'));
	}
        $uploadFolderImg = "user_documents";
        $uploadPath = WWW_ROOT . $uploadFolderImg;
	if($this->request->is(array('post', 'put'))) {
            $options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !='  => $userid));
            $emailexists = $this->User->find('first', $options);		
            if(!$emailexists){
                $this->request->data['User']['id']=$userid;
                $UserRed=0;
                if(isset($this->request->data['User']['identity_proof']) && $this->request->data['User']['identity_proof']['name']!=''){
                    $path = $this->request->data['User']['identity_proof']['name'];
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    if($ext){
                        $extensionValid = array('jpg','jpeg','png','gif');
                        if(in_array($ext,$extensionValid)){
                            $imageName = rand().'_'.(strtolower(trim($this->request->data['User']['identity_proof']['name'])));
                            $full_image_path = $uploadPath . '/' . $imageName;
                            move_uploaded_file($this->request->data['User']['identity_proof']['tmp_name'],$full_image_path);
                            $this->request->data['User']['identity_proof'] = $imageName;
                            $identity_proof_img=$this->request->data['User']['hid_identity_proof'];
                            if($identity_proof_img!='' && file_exists($uploadPath . '/' . $identity_proof_img)){
                                unlink($uploadPath. '/' .$identity_proof_img);
                            }
                            $UserRed=1;
                        }
                    }
                }elseif(isset($this->request->data['User']['hid_identity_proof']) &&  $this->request->data['User']['hid_identity_proof']!=''){
                    $this->request->data['User']['identity_proof'] = $this->request->data['User']['hid_identity_proof'];
                    $UserRed=1;
                }
                
                if(isset($this->request->data['User']['bill_proof']) && $this->request->data['User']['bill_proof']['name']!=''){
                    $path = $this->request->data['User']['bill_proof']['name'];
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    if($ext){
                        $extensionValid = array('jpg','jpeg','png','gif');
                        if(in_array($ext,$extensionValid)){
                            $BillimageName = rand().'_'.(strtolower(trim($this->request->data['User']['bill_proof']['name'])));
                            $full_image_path = $uploadPath . '/' . $BillimageName;
                            move_uploaded_file($this->request->data['User']['bill_proof']['tmp_name'],$full_image_path);
                            $this->request->data['User']['bill_proof'] = $BillimageName;
                            $bill_proof_img=$this->request->data['User']['hid_bill_proof'];
                            if($bill_proof_img!='' && file_exists($uploadPath . '/' . $bill_proof_img)){
                                unlink($uploadPath. '/' .$bill_proof_img);
                            }
                            $UserRed=1;
                        }
                    }
                }elseif(isset($this->request->data['User']['hid_bill_proof']) &&  $this->request->data['User']['hid_bill_proof']!=''){
                    $this->request->data['User']['bill_proof'] = $this->request->data['User']['hid_bill_proof'];
                    $UserRed=1;
                }
               
                if ($this->User->save($this->request->data)) {
		    
		    $updatedUser=$this->User->find('first', array('conditions' => array('User.id'=> $userid)));
		    //if($updatedUser['User']['fax_country_code']!='' && $updatedUser['User']['fax_area_code']!='' && $updatedUser['User']['fax_number']!=''){
			$arr = array();
			$arr['User']['id'] = $userid;
			$arr['User']['is_all_complt'] = 1;
			$this->User->save($arr);
		    //}
                    $this->Session->setFlash('You profile details has been saved.', 'default', array('class' => 'success'));
		    $this->User->id = $userid;
		    $us_de = $this->User->read();
		    if($us_de['User']['is_all_complt']==1){
			    return $this->redirect('/');
			}
			else{
			    if($UserRed==1){
				return $this->redirect('/');
			    }else{
				return $this->redirect($this->request->referer());
			    }
			}
                    
                }else{
                    $this->Session->setFlash('You profile details could not save. Please try later.', 'default', array('class' => 'error'));
                    return $this->redirect($this->request->referer());
                }
            }else{
                $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
                return $this->redirect($this->request->referer());
            }
	}
        
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
	$this->set(compact('user','title_for_layout'));
    }
        
        
        public function post_ad()
        {
	  $title_for_layout='Post Ad';
	  $userid = $this->Session->read('Auth.User.id');
	  if(isset($userid) && $userid!=''){
	     return $this->redirect(array('action' => 'dashboard'));
	  }
	  else
	  {
	     $this->Session->setFlash(__('Please login to post ad.', 'default', array('class' => 'error')));
	     return $this->redirect(array('action' => 'signin'));
	  }
	  $this->set(compact('title_for_layout'));
	}
	
	
        function admin_captcha()	
        {
	    $this->autoRender = false;
	    $this->layout='ajax';
	    if(!isset($this->Captcha))	
	    { 
	        $this->Captcha = $this->Components->load('Captcha', array(
		        'width' => 150,
		        'height' => 50,
		        'theme' => 'default', 
	        )); 
	    }
	    $this->Captcha->create();
        }
	
        public function admin_login() 
        {	 	
	     $title_for_layout = 'Admin Login';
	     $this->set(compact('title_for_layout'));
	     if(!isset($this->Captcha))	
	     {   
	        $this->Captcha = $this->Components->load('Captcha');
	     }	
	     //$this->User->setCaptcha($this->Captcha->getVerCode());
	     if ($this->request->is('post')) 
	     {
	        
		        if($this->Auth->login()) 
		        {
			        $is_admin = $this->Session->read('Auth.User.is_admin');
			        $is_active = $this->Session->read('Auth.User.is_active');
			        if($is_admin==1 && $is_active==1)
			        {
			          $this->Session->setFlash('You have successfully logged in.', 'default', array('class' => 'success'));				
			          return $this->redirect($this->Auth->redirect('dashboard'));
			        }
			        else
			        {
			          $this->Auth->logout();
			          $this->Session->setFlash(__('You are not authorize to access.', 'default', array('class' => 'error')));
			          return $this->redirect(array('action' => 'index'));
			        }
		        }
		        else
		        {
		           $this->Session->setFlash(__('Invalid Email or Password, Please try again.', 'default', array('class' => 'error')));
		           return $this->redirect(array('action' => 'index'));
		        }
	        
	      }	
       }
       
       public function admin_dashboard() 
       {
    	    $title_for_layout = 'Dashboard';
    	    $this->set(compact('title_for_layout'));
    	    $user_id = $this->Session->read('Auth.User.id');
    	    if(!isset($user_id) && $user_id=='')
    	    {
    		    $this->redirect('/admin');
    	    }
       }
	
       public function admin_logout() 
       {
            $this->redirect($this->Auth->logout());
       }
       
       public function admin_fotgot_password() 
       {
	 $title_for_layout = 'Forgot Password';
	 $this->set(compact('title_for_layout'));
	 
	 if ($this->request->is(array('post', 'put')))
	 {
	        $options = array('conditions' => array('User.email' => $this->request->data['User']['email'],'User.is_admin' => 1));             $user = $this->User->find('first', $options); 
		if($user)
		{
			$password = $this->User->get_fpassword();
			$this->request->data['User']['id'] = $user['User']['id'];
			$this->request->data['User']['password'] = $password;
			if ($this->User->save($this->request->data)) 
			{
			   $key = Configure::read('CONTACT_EMAIL');
			   $this->loadModel('EmailTemplate');
			   $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>1)));
			   $mail_body =str_replace(array('[EMAIL]','[PASSWORD]'),array($this->request->data['User']['email'],$password),$EmailTemplate['EmailTemplate']['content']);
			   $this->send_mail($key,$this->request->data['User']['email'],$EmailTemplate['EmailTemplate']['subject'],$mail_body);
			   $this->Session->setFlash('A new password has been sent to your mail. Please check mail.', 'default', array('class' => 'success'));
			}
		        else 
			{
			    $this->Session->setFlash("Sorry! some internal error occured.Please try again later.");
			}
		} 
		else 
		{
		   $this->Session->setFlash("Invalid email or You are not authorize to access.");
		}
	 }
       }
       
       public function activation($id = null) 
       {
	 if($id){
	  $id=base64_decode($id);
	  $options = array('conditions' => array('User.id' => $id));
	  $user = $this->User->find('first', $options);
	  if($user)
	  {
		if($user['User']['is_active']!=1)
		{
		 $this->request->data['User']['is_active'] = 1;
		 $this->request->data['User']['id'] = $id;
		 if ($this->User->save($this->request->data)) 
		 {
			$this->Session->setFlash('Your account has been activated.', 'default', array('class' => 'success'));
			return $this->redirect(array('controller'=>'users','action' => 'index'));
		 } 
		 else 
		 {
			$this->Session->setFlash(__('Sorry! some internal error occured.Please try again later.'));
			return $this->redirect(array('action' => 'index'));
		 }
		}
		else
		{
		   $this->Session->setFlash(__('Account already activated.'));
		   return $this->redirect(array('action' => 'index'));
		}
	  }
	  else
	  {
              $this->Session->setFlash(__('Sorry! The user not exists.'));
	      return $this->redirect(array('action' => 'index'));
	  }
        }
      }
      
     
      
    
      
      function  edit_profileservice()
      {
	$userid = $_REQUEST['user_id'];
	$data=array();
	if($_REQUEST) 
	{
          $this->request->data['User']['email']=  isset($_REQUEST['email'])?$_REQUEST['email']:'';  
	  $options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !='  => $userid));
	  $emailexists = $this->User->find('first', $options);		
	  if(!$emailexists)
	  {
                  $this->request->data['User']['id']=$userid;	
                  $this->request->data['User']['first_name']=$_REQUEST['first_name'];		  
                  $this->request->data['User']['last_name']=$_REQUEST['last_name'];		  
                  $this->request->data['User']['nick_name']=$_REQUEST['nick_name'];		  
                  $this->request->data['User']['gender']=$_REQUEST['gender'];		  
                  $this->request->data['User']['email']=$_REQUEST['email'];		  
                  $this->request->data['User']['alternate_email']=$_REQUEST['alternate_email'];		  
                  $this->request->data['User']['address']=$_REQUEST['address'];		  
                  $this->request->data['User']['city']=$_REQUEST['city'];		  
                  $this->request->data['User']['state']=$_REQUEST['state'];		  
                  $this->request->data['User']['country']=$_REQUEST['country'];		  
                  $this->request->data['User']['zip_code']=$_REQUEST['zip_code'];		  
                  $this->request->data['User']['telephone_country_code']=$_REQUEST['telephone_country_code'];		  
                  $this->request->data['User']['telephone_number']=$_REQUEST['telephone_number'];
                  $this->request->data['User']['telephone_area_code']=$_REQUEST['telephone_area_code'];
                  $this->request->data['User']['fax_country_code']=$_REQUEST['fax_country_code'];		  
                  $this->request->data['User']['fax_area_code']=$_REQUEST['fax_area_code'];		  
                  $this->request->data['User']['fax_number']=$_REQUEST['fax_number'];	
                  $this->request->data['User']['mobile_number']=$_REQUEST['mobile_number'];		  
                  $this->request->data['User']['job_title']=$_REQUEST['job_title'];
                  $this->request->data['User']['shop_address']=$_REQUEST['shop_address'];		  
                  $this->request->data['User']['shop_city']=$_REQUEST['shop_city'];		  
                  $this->request->data['User']['shop_country']=$_REQUEST['shop_country'];		  
                  $this->request->data['User']['shop_zip_code']=$_REQUEST['shop_zip_code'];		  
                  $this->request->data['User']['shop_vat']=$_REQUEST['shop_vat'];		  
                  $this->request->data['User']['shop_company_reg_no']=$_REQUEST['shop_company_reg_no'];	
		  if ($this->User->save($this->request->data)) 
		  {
		    $data['Ack']=1;
                    $data=array('Ack'=>1,'message'=>'profile updated successfully');
		  }
		  else
		  {
                    $data['Ack']=0;

		  }
	  }
	  else
	  {
	      $data=array('Ack'=>0,'error'=>'Duplicate Email Address');
	  }
	}
	echo json_encode($data);exit;
      }
      
      function  edit_shopservice()
      {
	$userid = $_REQUEST['user_id'];
	$data=array();
	if($_REQUEST) 
	{
          
                  $this->request->data['User']['id']=$userid;	
                  $this->request->data['User']['shop_address']=$_REQUEST['shop_address'];		  
                  $this->request->data['User']['shop_city']=$_REQUEST['shop_city'];		  
                  $this->request->data['User']['shop_country']=$_REQUEST['shop_country'];		  
                  $this->request->data['User']['shop_zip_code']=$_REQUEST['shop_zip_code'];		  
                  $this->request->data['User']['shop_vat']=$_REQUEST['shop_vat'];		  
                  $this->request->data['User']['shop_company_reg_no']=$_REQUEST['shop_company_reg_no'];		  
                  
		  if ($this->User->save($this->request->data)) 
		  {
		    $data['Ack']=1;
		  }
		  else
		  {
                    $data['Ack']=0;

		  }
	  }
	echo json_encode($data);exit;
	}
      
      
      public function edit_photo() 
	{
		$title_for_layout='Edit Photo';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
			return $this->redirect(array('action' => 'signin'));
		}
		if($this->request->is(array('post', 'put'))) 
		{
			#pr($this->request->data);
			#exit;
			if(isset($this->request->data['User']['profile_image']) && $this->request->data['User']['profile_image']['name']!='')
			{
				$path = $this->request->data['User']['profile_image']['name'];
				$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				if($ext)
				{
					$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext,$extensionValid))
					{
						$imageName = rand().'_'.(strtolower(trim($this->request->data['User']['profile_image']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['User']['profile_image']['tmp_name'],$full_image_path);
						$this->request->data['User']['profile_image'] = $imageName;
						$this->request->data['User']['id']=$userid;		  
						if ($this->User->save($this->request->data)) 
						{
							$this->Session->setFlash('You profile image has been saved.', 'default', array('class' => 'success'));
							//return $this->redirect($this->request->referer());
                                                        return $this->redirect('/users/edit-profile');
						}
						else
						{
							$this->Session->setFlash('You profile image could not save. Please try later.', 'default', array('class' => 'error'));
							return $this->redirect($this->request->referer());
						}
					} 
					else
					{
						$this->Session->setFlash(__('Invalid image type.'));
						return $this->redirect(array('action' => 'edit_photo'));
					}
				}
			
			}
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
		$user=$this->User->find('first', $options);
		$this->set(compact('user','title_for_layout'));
	}
        
        public function edit_photoservice() 
	{
		$userid = $_REQUEST['user_id'];
		
		if($_REQUEST) 
		{
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name']!='')
    {
            $path = $_FILES['profile_image']['name'];
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if($ext)
            {
                    $uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
                    $extensionValid = array('jpg','jpeg','png','gif');
                    if(in_array($ext,$extensionValid))
                    {
                            $imageName = rand().'_'.(strtolower(trim($_FILES['profile_image']['name'])));
                            $full_image_path = $uploadPath . '/' . $imageName;
                            move_uploaded_file($_FILES['profile_image']['tmp_name'],$full_image_path);
                            $this->request->data['User']['profile_image'] = $imageName;
                            $this->request->data['User']['id']=$userid;		  
                            if ($this->User->save($this->request->data)) 
                            {
                                $data['Ack']=1;
                                $data['message']=array('type'=>'success','message'=>'Photo upload successfully');
                            }
                            else
                            {
                                    $data['Ack']=0;
                                    $data['message']=array('type'=>'error','message'=>'Photo upload failure');
                            }
                            }
                    } 
                    else
                    {
                            $data['Ack']=0;
                            $data['message']=array('type'=>'error','message'=>'Invalid image type');
                    }
                    }
            }
			
            echo json_encode($data);exit;
	}
        
        public function security() {
            $title_for_layout='Settings';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	        return $this->redirect(array('action' => 'signin'));
            }
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $user=$this->User->find('first', $options);
            if ($this->request->is(array('post', 'put'))) 
            {	
               $prev_pass=$user['User']['password'];
               $curr_pass=$this->request->data['User']['current_password'];
               $new_pass=$this->request->data['User']['new_password'];

               $PasswordHasher = new SimplePasswordHasher();
               $curr_pass_hash=$PasswordHasher->hash($curr_pass);
               if($prev_pass != $curr_pass_hash)
               {
                    $this->Session->setFlash('Invalid current password.', 'default');
                    //return $this->redirect(array('action' => 'security'));
               }
               else
               {
                    $user_data_auth['User']['id']=$userid;
                    $user_data_auth['User']['password']=$new_pass;
                    $user_data_auth['User']['txt_password']=$new_pass;
                    if($this->User->save($user_data_auth))
                    {
                        $this->Session->setFlash('Password updated successfully.', 'default', array('class' => 'success'));
                        //return $this->redirect(array('action' => 'security'));
                    }         
               }
            } 
	    #pr($user);
            $this->set(compact('user','title_for_layout'));
      }


      public function update_email() 
      {
            $title_for_layout='Security';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	        return $this->redirect(array('action' => 'signin'));
            }
            if ($this->request->is(array('post', 'put'))) 
            {
		$options = array('conditions' => array('User.email' => $this->request->data['User']['new_email']));
		$emailExists=$this->User->find('first', $options);
		if(!$emailExists){
			$new_email = $this->request->data['User']['new_email'];
			$re_enter_email = $this->request->data['User']['re_enter_email'];
			if($new_email != $re_enter_email)
			{
				$this->Session->setFlash('Email address mismatch.', 'default');
				return $this->redirect(array('action' => 'security'));
			}
			else
			{
				$user_data_auth['User']['id']=$userid;
				$user_data_auth['User']['email']=$new_email;
				if($this->User->save($user_data_auth))
				{
					$this->Session->setFlash('Email updated successfully.', 'default', array('class' => 'success'));
					return $this->redirect(array('action' => 'security'));
				}         
			}
		} else {
			$this->Session->setFlash('Email address already exists. Please chosse another.', 'default');
			return $this->redirect(array('action' => 'security'));
		}
            }  else {
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
		$this->request->data = $this->User->find('first', $options);
	    }
            $this->set(compact('user','title_for_layout'));
      }
      
      public function upload_profile_pic()
      {
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	App::import('Helper', 'Resize');
	$resize = new ResizeHelper();
	
	$uploadFolder = "user_images";
	$uploadPath = WWW_ROOT . $uploadFolder;
   
	foreach ($_FILES["file"]["error"] as $key => $error){
	  if ($error == UPLOAD_ERR_OK)
	  {
		  $time=time();
		  $random_num=rand(00,99);
		  $name = $time.$random_num.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
		  $newimageName = time().'_'.rand().'_'.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
		  
		  if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $uploadPath.'/'.$name))
		  {
			 $full_image_path = $uploadPath . '/' . $name;
			 $full_image_path_new = $uploadPath . '/' . $newimageName;

			 $info = getimagesize($full_image_path);
			 if ($info['mime'] == 'image/jpeg')
			 {
			   $imagen = imagecreatefromjpeg($full_image_path);
			 }
			 elseif ($info['mime'] == 'image/gif')
			 {
			   $imagen = imagecreatefromgif($full_image_path);
			 }
			 elseif ($info['mime'] == 'image/png')
			 {
			   $imagen = imagecreatefrompng($full_image_path);
			 }
			 elseif ($info['mime'] == 'image/jpg')
			 {
			  $imagen = imagecreatefromjpeg($full_image_path);
			 }

			 imagejpeg($imagen, $full_image_path_new, 75);

			 unlink($full_image_path);

		         $resize->versions_store =WWW_ROOT.'user_images'.DS; 
		         $resize->versions_public =WWW_ROOT.'user_images'.DS;
		         $destination_width="250";
		         $destination_height ="250";
		         $resize->wrap($newimageName, $destination_width, $destination_height);
			 
			 $this->request->data['User']['id']=$userid;
			 $this->request->data['User']['profile_image'] = $newimageName;
			 if($this->User->save($this->request->data)) 
			 {
			   echo "1";
			 }
		  }
		  else
		  {
			echo "0";
			exit;
		  }
	  }
	}
	exit;
      }

      public function admin_list() 
      {
        $title_for_layout = 'Admin List';
	$this->set(compact('title_for_layout'));
        $userid = $this->Session->read('Auth.User.id');
        if(!isset($userid) && $userid=='')
        {
	   $this->redirect('/admin');
        }
        $this->paginate = array(
        'limit' =>25,
        'order' => array(
            'User.id' => 'desc'
         ), 
        );
        $this->Paginator->settings = $this->paginate;
        $this->User->recursive = 1;
        $this->set('users', $this->Paginator->paginate('User',array('User.is_admin'=>1)));
      }

      public function admin_view($id = null) 
      {
	$title_for_layout = 'Admin View';
	$this->set(compact('title_for_layout'));
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists($id)) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	$this->set('user', $this->User->find('first', $options));
     }

     public function admin_add() 
     {
	$title_for_layout = 'Admin Add';
	$this->set(compact('title_for_layout'));
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if ($this->request->is('post')) { 
		$options = array('conditions' => array('User.email'  => $this->request->data['User']['email']));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists)
		{
		  if(isset($this->request->data['User']['profile_image']) && $this->request->data['User']['profile_image']['name']!='')
		  {
		        $path = $this->request->data['User']['profile_image']['name'];
                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
			if($ext)
			{
				$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
				$extensionValid = array('jpg','jpeg','png','gif');
				if(in_array($ext,$extensionValid))
				{
					$imageName = rand().'_'.(strtolower(trim($this->request->data['User']['profile_image']['name'])));
					$full_image_path = $uploadPath . '/' . $imageName;
					move_uploaded_file($this->request->data['User']['profile_image']['tmp_name'],$full_image_path);
					$this->request->data['User']['profile_image'] = $imageName;
				} 
				else
				{
					$this->Session->setFlash(__('Invalid image type.'));
					return $this->redirect(array('action' => 'add'));
				 }
			 }

		 }
		 else
		 {
			 $this->request->data['User']['profile_image']='';
		 }
		 $this->request->data['User']['registration_date'] = date('Y-m-d');
		 $this->request->data['User']['is_admin'] = 1;
		 $this->request->data['User']['password']=$this->request->data['User']['password'];
		 $this->User->create();
		 if ($this->User->save($this->request->data)) 
		  {
			$this->Session->setFlash('The admin has been saved.', 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'list'));
		  } 
		  else 
		  {
			$this->Session->setFlash(__('The admin could not be saved. Please, try again.'));
		  }
	     }
	     else 
	     {
	       $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
             }  
	}
    }

    public function admin_delete($id = null) 
    {
	$this->User->id = $id;
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists()) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	if ($this->User->delete($id)) 
	{
		$this->Session->setFlash('The admin has been deleted.', 'default', array('class' => 'success'));
	} else 
	{
		$this->Session->setFlash(__('The admin could not be deleted. Please, try again.'));
	}
	return $this->redirect(array('action' => 'list'));
   }	

   public function admin_edit($id = null) 
   {	
        $title_for_layout = 'Admin Edit';
	$this->set(compact('title_for_layout'));
        $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists($id)) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	if ($this->request->is(array('post', 'put'))) {	
		$options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !=' => $id));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists)
		{
		  if(isset($this->request->data['User']['profile_image']) && $this->request->data['User']['profile_image']['name']!='')
		  {
		        $path = $this->request->data['User']['profile_image']['name'];
                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
			if($ext)
			{
				$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
				$extensionValid = array('jpg','jpeg','png','gif');
				if(in_array($ext,$extensionValid)){
					$imageName = rand().'_'.(strtolower(trim($this->request->data['User']['profile_image']['name'])));
					$full_image_path = $uploadPath . '/' . $imageName;
					move_uploaded_file($this->request->data['User']['profile_image']['tmp_name'],$full_image_path);
					$this->request->data['User']['profile_image'] = $imageName;
				} 
				else
				{
					$this->Session->setFlash(__('Invalid image type.'));
					return $this->redirect(array('action' => 'edit',$id));
				}
			 }
		  }
		  else 
		  {
			 $this->request->data['User']['profile_image'] = $this->request->data['User']['hid_img'];
		  }

		  if(isset($this->request->data['User']['password']) && $this->request->data['User']['password']!='')
		  {
			$this->request->data['User']['password'] = $this->request->data['User']['password'];
	                $prev_pass='';
		  } else {
			$this->request->data['User']['password'] = '';
			$prev_pass=$this->request->data['User']['hid_pw'];
		  }

		  if($this->User->save($this->request->data)) 
		  {
			if($prev_pass!='')
			{
			   $this->User->query('Update widding.users as user set user.password="'.$prev_pass.'" where user.id='.$id.'');
			}
			$this->Session->setFlash('Admin details has been saved.', 'default', array('class' => 'success'));
			//return $this->redirect(array('controller' => 'users','action' => 'admin_edit',$id));
		  } 
		  else 
		  {
			$this->Session->setFlash(__('Admin details could not be saved. Please, try again.'));
		  }
		}
		else 
		{
			$this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
			//return $this->redirect(array('action' => 'edit',$id));
		}
	 
	} 
	else 
	{
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->request->data = $this->User->find('first', $options);
	}	
     }
     
     
     
    //spandan 18.10.2017
     
     public function admin_middle_add() 
     {
            
            
		$title_for_layout = 'Add Middle Section';
                $this->loadModel('Middle');
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
            
            if ($this->request->is('post')) {
    
   
      if(!empty($this->request->data['Middle']['image']['name'])){
      $pathpart=pathinfo($this->request->data['Middle']['image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
     
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "middle_image/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Middle']['image']['tmp_name'],$full_flg_path);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
       return $this->redirect(array('action' => 'add'));
      }
     }
     else{
      $filename='';
     }
      $this->request->data['Middle']['image'] = $filename;
      $this->request->data['Middle']['title'] = $this->request->data['Middle']['title'];
      $this->request->data['Middle']['description'] = $this->request->data['Middle']['description'];
      
      $this->Middle->create();

     if ($this->Middle->save($this->request->data)) {

      $this->Session->setFlash('Middle section has been saved.','default', array('class' => 'success'));
      return $this->redirect(array('action' => 'middle_list'));
     } else {
      $this->Session->setFlash(__('Middle section could not be saved. Please, try again.', 'default', array('class' => 'error')));
     }

     
   }
            
       }
       
       
       public function admin_middle_list() {
                $this->loadModel('Middle');
                $userid = $this->Session->read('Auth.User.id');
                
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Middle Section List';
                $this->paginate = array(
			'order' => array(
				'Middle.id' => 'desc'
			)
		);
		$this->Middle->recursive = 0;
                $this->Paginator->settings = $this->paginate;
                
		$this->set('middles', $this->Paginator->paginate('Middle'));
		$this->set(compact('title_for_layout'));
	}
        
        
        public function admin_middle_edit($id = null) {
            $this->loadModel('Middle');
	    $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}

	    $this->request->data1=array();
		$title_for_layout = 'Edit Middle Section';
		$this->set(compact('title_for_layout'));
		
		if (!$this->Middle->exists($id)) {
			throw new NotFoundException(__('Invalid Ad'));
		}
		if ($this->request->is(array('post', 'put'))) {

        if(!empty($this->request->data['Middle']['image']['name'])){
        $pathpart=pathinfo($this->request->data['Middle']['image']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "middle_image/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Middle']['image']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
         return $this->redirect(array('action' => 'edit'));
        }
       }
       else{
        $filename=$this->request->data['Middle']['logos'];
       }
        $this->request->data['Middle']['image'] = $filename;
        $this->request->data['Middle']['title'] = $this->request->data['Middle']['title'];
        $this->request->data['Middle']['description'] = $this->request->data['Middle']['description'];
        
        

			if ($this->Middle->save($this->request->data)) {

        
				$this->Session->setFlash('Middle Section has been saved.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'middle_list'));
			} else {
				$this->Session->setFlash(__('Middle Section could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('Middle.' . $this->Middle->primaryKey => $id));
			$this->request->data = $this->Middle->find('first', $options);

      
	}    
       
    }
    
    public function admin_middle_delete($id = null) {
        $this->loadModel('Middle');
	   $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->Middle->id = $id;
	   if (!$this->Middle->exists()) {
	      throw new NotFoundException(__('Invalid section.'));
	   }
	   if ($this->Middle->delete($id)) {
		$this->Session->setFlash('Middle section has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('Middle section could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'middle_list'));
	}
    //end
     

     public function admin_user_list() 
     {
	$title_for_layout = 'User List';
	$this->set(compact('title_for_layout'));
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	$this->paginate = array(
	'limit' =>25,
	'order' => array(
	'User.id' => 'desc'
	 ), 
	);
	$this->Paginator->settings = $this->paginate;
	$this->User->recursive = 1;
	$this->set('users', $this->Paginator->paginate('User',array('User.is_admin !='=>1,'User.type' => 'C','User.is_active'=> 1)));
    }

    public function admin_user_view($id = null) 
    {  
	$title_for_layout = 'User View';
	$this->set(compact('title_for_layout'));
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists($id)) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	$this->set('user', $this->User->find('first', $options));
    }

    public function admin_user_add() 
    {
        $title_for_layout = 'User Add';
	$this->set(compact('title_for_layout'));
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if ($this->request->is('post')) { 
		$options = array('conditions' => array('User.email'  => $this->request->data['User']['email']));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists)
		{
		  if(isset($this->request->data['User']['profile_image']) && $this->request->data['User']['profile_image']['name']!='')
		  {
		        $path = $this->request->data['User']['profile_image']['name'];
                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
			if($ext)
			{
				$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
				$extensionValid = array('jpg','jpeg','png','gif');
				if(in_array($ext,$extensionValid))
				{
					$imageName = rand().'_'.(strtolower(trim($this->request->data['User']['profile_image']['name'])));
					$full_image_path = $uploadPath . '/' . $imageName;
					move_uploaded_file($this->request->data['User']['profile_image']['tmp_name'],$full_image_path);
					$this->request->data['User']['profile_image'] = $imageName;
				} 
				else
				{
					$this->Session->setFlash(__('Invalid image type.'));
					return $this->redirect(array('action' => 'user_add'));
				 }
			 }

		 }
		 else
		 {
			 $this->request->data['User']['profile_image']='';
		 }
		 $this->request->data['User']['registration_date'] = date('Y-m-d');
		 $this->request->data['User']['is_admin'] = 0;
		 $this->request->data['User']['is_active'] = 1;
		 $this->request->data['User']['password']=$this->request->data['User']['password'];
		 $this->User->create();
		 if ($this->User->save($this->request->data)) 
		  {
			$this->Session->setFlash('The user has been saved', 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'user_list'));
		  } 
		  else 
		  {
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
		  }
		 
	  }
	  else {
			$this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
		}  
	  }
         // $this->loadModel('Percentage');
        //$percentage_value = $this->Percentage->find('list',array());
         //$this->set(compact('percentage_value'));
     }

     public function admin_user_delete($id = null) 
     {
	$this->User->id = $id;
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists()) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	if ($this->User->delete($id)) 
	{
                
		$this->Session->setFlash('The user has been deleted.', 'default', array('class' => 'success'));
	} else 
	{
		$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
	}
	return $this->redirect(array('action' => 'user_list'));
    }	

    public function admin_user_edit($id = null) 
    {	
        $title_for_layout = 'User Edit';
	$this->set(compact('title_for_layout'));
        $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/admin');
	}
	if (!$this->User->exists($id)) 
	{
		throw new NotFoundException(__('Invalid user.'));
	}
	if ($this->request->is(array('post', 'put'))) {	
	 
		$options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !=' => $id));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists)
		{
		  if(isset($this->request->data['User']['profile_image']) && $this->request->data['User']['profile_image']['name']!='')
		  {
		        $path = $this->request->data['User']['profile_image']['name'];
                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
			if($ext)
			{
				$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
				$extensionValid = array('jpg','jpeg','png','gif');
				if(in_array($ext[1],$extensionValid)){
					$imageName = rand().'_'.(strtolower(trim($this->request->data['User']['profile_image']['name'])));
					$full_image_path = $uploadPath . '/' . $imageName;
					move_uploaded_file($this->request->data['User']['profile_image']['tmp_name'],$full_image_path);
					$this->request->data['User']['profile_image'] = $imageName;
				} 
				else
				{
					$this->Session->setFlash(__('Invalid image type.'));
					return $this->redirect(array('action' => 'user_edit',$id));
				 }
			 }
		  }
		  else 
		  {
			 $this->request->data['User']['profile_image'] = $this->request->data['User']['hid_img'];
		  }

		  if(isset($this->request->data['User']['password']) && $this->request->data['User']['password']!='')
		  {
			$this->request->data['User']['password'] = $this->request->data['User']['password'];
	                $prev_pass='';
		  } else {
			$this->request->data['User']['password'] = '';
			$prev_pass=$this->request->data['User']['hid_pw'];
		  }

		  if($this->User->save($this->request->data)) 
		  {
			if($prev_pass!='')
			{
				$this->User->query('Update widding.users as user set user.password="'.$prev_pass.'" where user.id='.$id.'');
			}
			$this->Session->setFlash('User details has been saved', 'default', array('class' => 'success'));
			return $this->redirect(array('controller' => 'users','action' => 'admin_user_edit',$id));
		  } 
		  else 
		  {
			$this->Session->setFlash(__('User details could not be saved. Please, try again.'));
		  }
		}
		else 
		{
			$this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
			return $this->redirect(array('action' => 'user_edit',$id));
		}
	 
	} 
	else 
	{
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->request->data = $this->User->find('first', $options);
	}
        //$this->loadModel('Percentage');
        //$percentage_value = $this->Percentage->find('list',array());
        // $this->set(compact('percentage_value'));
    }
    
 public function getmakername($mid=null)
 {
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $mid));
    $usr=$this->User->find('first', $options);
	$usrnme=$usr['User']['first_name'].' '.$usr['User']['last_name'];
	return $usrnme;
 }
 public function getmakerimage($mid=null)
 {
  $options = array('conditions' => array('User.' . $this->User->primaryKey => $mid));
  $usr=$this->User->find('first', $options);
  $usrimg=$usr['User']['profile_image'];
  return $usrimg;
 }
  public function getuserdetails($mid=null)
 {
  $options = array('conditions' => array('User.' . $this->User->primaryKey => $mid));
  $usr=$this->User->find('first', $options);
  
  return $usr;
 }
 
 public function getinboxid($rid=null,$uid=null)
 {
  
  $this->loadModel('InboxMessage');
  $options = array('conditions' => array('InboxMessage.user_id' => $uid,'InboxMessage.order_id' => $rid));
  $usr=$this->InboxMessage->find('first', $options);
  
  return $usr['InboxMessage']['id'];
 }
 public function getinboxdetails($mid=null)
 {
  
  $this->loadModel('SentMessage');
  $options = array('conditions' => array('SentMessage.inbox_id' => $mid,'SentMessage.is_invoice' => 0),'order'=>'SentMessage.id DESC');
  $usr=$this->SentMessage->find('all', $options);
  
  return $usr;
 }
 public function getinboxdetails1($mid=null)
 {
  
  $this->loadModel('SentMessage');
  $options = array('conditions' => array('SentMessage.inbox_id' => $mid),'order'=>'SentMessage.id DESC');
  $usr=$this->SentMessage->find('all', $options);
  
  return $usr;
 }
 
 
 public function settings() 
 {
	$userid = $this->Session->read('Auth.User.id');
	
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);

	$this->set(compact('user'));
 }

 public function my_articles() 
 {
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);

	$this->set(compact('user'));
 }
 
 
 public function read_notification($inbox_id=null,$noti_id=null){
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$this->loadModel('Notification');
	$noti['Notification']['id']=$noti_id;
	$noti['Notification']['is_read']=1;
	$this->Notification->save($noti);

	$this->loadModel('InboxMessage');
	$inbx['InboxMessage']['id']=$inbox_id;
	$inbx['InboxMessage']['is_read']=1;
	$this->InboxMessage->save($inbx);

	return $this->redirect(array('action' => 'messages',base64_encode($inbox_id)));
 }

 
 
 public function sendreply($inbox_id=null) 
 {
	$userid = $this->Session->read('Auth.User.id');
	$key = Configure::read('CONTACT_EMAIL');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
        $this->loadModel('User');
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
        $user=$this->User->find('first', $options);
        
       
	$this->loadModel('Notification');
	$this->loadModel('SentMessage');
    $this->loadModel('InboxMessage'); 
        
        $options_getinboxid = array('conditions' => array('AND'=>array('InboxMessage.order_id' => $this->request->data['SentMessage']['orderid'],'InboxMessage.user_id' => $this->request->data['SentMessage']['receiver_id'],'InboxMessage.sender' => $this->request->data['SentMessage']['sender_id'])));
        $het_inbox_id=$this->InboxMessage->find('first', $options_getinboxid);
        
        $new_inbox_id=$het_inbox_id['InboxMessage']['id'];
        
        
        if ($this->request->is(array('post'))) 
	    {
                    $thrd['SentMessage']['user_id']=$this->request->data['SentMessage']['receiver_id'];
                    $thrd['SentMessage']['inbox_id']=$inbox_id;
                    $thrd['SentMessage']['sender']=$this->request->data['SentMessage']['sender_id'];
                    $thrd['SentMessage']['message']=$this->request->data['SentMessage']['reply'];
                    $thrd['SentMessage']['date_time']=date('Y-m-d H:i:s');
                    $this->SentMessage->create();
                    $this->SentMessage->save($thrd);
                    
                    
                    $thrd1['SentMessage']['user_id']=$this->request->data['SentMessage']['receiver_id'];
                    $thrd1['SentMessage']['inbox_id']=$new_inbox_id; 
                    $thrd1['SentMessage']['sender']=$this->request->data['SentMessage']['sender_id'];
                    $thrd1['SentMessage']['message']=$this->request->data['SentMessage']['reply'];
                    $thrd1['SentMessage']['date_time']=date('Y-m-d H:i:s');
                    $this->SentMessage->create();
                    $this->SentMessage->save($thrd1);
                    
                    $inbx['InboxMessage']['id']=$new_inbox_id;
					$inbx['InboxMessage']['is_read']=0;
					$this->InboxMessage->save($inbx);
                    
                    $noti['Notification']['user_id']=$this->request->data['SentMessage']['receiver_id'];
                    $noti['Notification']['message']='You have a new Message.';
                    $noti['Notification']['date']=date('Y-m-d H:i:s');
					$noti['Notification']['inbox_id']=$new_inbox_id;
                    $noti['Notification']['is_read']=0;
                    $this->Notification->create();
                    $this->Notification->save($noti);
                        
                    $this->Session->setFlash('Message sent successfully', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'messages',base64_encode($inbox_id)));
        }
 }

public function thankyou($email=null)
{
    $this->set('email',$email);
}

/********AK*****/
public function emailExists($email = null) {
	$data = '';
	if($email){

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailexists = $this->User->find('first',array('conditions' => array('User.email'=>$email),'fields' => array('User.id')));
		if(!empty($emailexists)){
             $data = 'Email already exists. Please try another.';
		} else {
			$data = '';
		}
		}
		else { $data = 'Invalid Email Id. Please provide a valid one.'; }
	}
	echo $data;
	exit;
}

    public function signup(){
	$userid = $this->Session->read('userid');
	$email = $this->Session->read('email');
	$username = $this->Session->read('username');
	if(isset($userid) && $userid!=''){
		return $this->redirect(array('action' => 'profile',$username));
	}
	$title_for_layout = 'Sign in | Sign up';
		//$this->layout=false;
	if ($this->request->is(array('post', 'put'))) 
	{
	    $key = Configure::read('CONTACT_EMAIL');
	    $SITE_URL = Configure::read('SITE_URL');
	    $email=$this->request->data['User']['email'];
	    $options = array('conditions' => array('User.email'  => $email));
	    $emailexists = $this->User->find('first', $options);
	    if(!$emailexists)
		{
			
			if($this->request->data['User']['password']==$this->request->data['User']['conpassword'])
			{
				$data=$this->request->data;
				$password =$this->request->data['User']['password'];

				//$data['User']['is_active'] = 0;
				$data['User']['is_active'] = 1;
				$data['User']['is_admin'] = 0;
				$data['User']['is_user'] = 1;
				$data['User']['username'] = $this->request->data['User']['first_name'].rand();
				$data['User']['registration_date'] = date('Y-m-d');
				//pr($data);exit;
				$this->User->create();
				if ($this->User->save($data)) 
				{
				 
				 $id=$this->User->getLastInsertId();
				 
				 $this->loadModel('EmailTemplate');

				 $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>2)));
				 $link='<a href="'.$SITE_URL.'users/activation/'.base64_encode($id).'">Click Here</a>';

				 $mail_body =str_replace(array('[LINK]','[PASSWORD]','[EMAIL]'),array($link,$password,$this->request->data['User']['email']),$EmailTemplate['EmailTemplate']['content']);
			
				 $this->send_mail($key,$this->request->data['User']['email'],$EmailTemplate['EmailTemplate']['subject'],$mail_body);
				 
				 $this->Session->setFlash('You have successfully registered. Please check your mail.', 'default', array('class' => 'success'));
				 return $this->redirect($this->request->referer());
				}
			}
			else 
			{
				$this->Session->setFlash(__('Password and Confirm Password Mismatch. Please, try again.', 'default', array('class' => 'error')));
			}
		  }
		  else
		  {
			 $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
			 return $this->redirect($this->request->referer());
		  }
	}	  
    }

/*****Ak End******/


    public function get_user_details($uid=null){
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $uid));
	$user=$this->User->find('first', $options);
        return $user;
    }

    public function buyer_dashboard(){
	$title_for_layout='Buyer Dashboard';
        $this->loadModel('Comment');
        $this->loadModel('OrderDetail');
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid==''){
	   $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	   return $this->redirect(array('action' => 'signin'));
	}
        $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
        $allmsg = $this->Comment->find('all',$options);
        $commnet_id =array();
        foreach($allmsg as $msg){
            foreach($msg as $msgs){
                $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
            }
        }	
        $options_finish = array('conditions' => array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
        $finish_count=$this->OrderDetail->find('count', $options_finish);
        $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.is_read' => 0), 'order' => array('Comment.id' => 'desc'));
        $messages_list_count=$this->Comment->find('count', $Inbox_options);
        $this->set(compact('title_for_layout','messages_list_count','finish_count'));
    }
    
    public function seller_dashboard(){
	$title_for_layout='Seller Dashboard';
        $this->loadModel('Comment');
        $this->loadModel('OrderDetail');
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid==''){
	   $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	   return $this->redirect(array('action' => 'signin'));
	}
        $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
        $allmsg = $this->Comment->find('all',$options);
        $commnet_id =array();
        foreach($allmsg as $msg){
            foreach($msg as $msgs){
                $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
            }
        }	
        $options_finish = array('conditions' => array('OrderDetail.owner_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
        $finish_count=$this->OrderDetail->find('count', $options_finish);
        $seller_awaiting_processing = $this->OrderDetail->find('count', array('conditions' => array('OrderDetail.owner_id' => $userid,'OrderDetail.order_status' => 'U')));
        $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.is_read' => 0), 'order' => array('Comment.id' => 'desc'));
        $messages_list_count=$this->Comment->find('count', $Inbox_options);
        $this->set(compact('title_for_layout','messages_list_count','seller_awaiting_processing','finish_count'));
        
    }
    
    public function membership(){
	
	$title_for_layout='Seller Membership';
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
	   $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	   return $this->redirect(array('action' => 'signin'));
	}
	
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
	if($user){
		$this->loadModel('Shop');
		$options = array('conditions' => array('Shop.user_id' => $userid));
		$shop=$this->Shop->find('first', $options);		
	}
	$this->set(compact('user','shop','title_for_layout'));
    }
    public function payment(){
	
    }
    
    public function success(){
	$userid = $this->Session->read('Auth.User.id');
        $this->loadModel('Payment');
        $this->loadModel('SiteSetting');
        $this->loadModel('Shop');
        $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
        $sitesetting = $this->SiteSetting->find('first', $options_set);
        
        $price = $sitesetting['SiteSetting']['shop_price_per_month'];
	$trnsaction = $_REQUEST['subscr_id'];
	$status = 'Completed';
	$date = date('Y-m-d H:i:s');
	$arr = array();	
	$Shop_id=$_REQUEST['custom'];
	$arr['Shop']['id']= $Shop_id;
	$arr['Shop']['is_active']= 1;
	$arr['Shop']['paid_on']= date('Y-m-d h:i:s');
	$time = strtotime(date('Y-m-d'));
	$final = date("Y-m-d H:i:s", strtotime("+1 month", $time));
	$arr['Shop']['last_date']= $final;
	if($this->Shop->save($arr)){
	    $arr1 = array();
	    $arr1['Payment']['userid']= $userid;
	    $arr1['Payment']['amount']= $price;
	    $arr1['Payment']['datetime']= date('Y-m-d h:i:s');
	    $arr1['Payment']['status']= $status;
            $arr1['Payment']['for']= 'for shop membership';
            $arr1['Payment']['transaction_id']= isset($trnsaction)?$trnsaction:'';
            $arr1['Payment']['type'] = 1;
	    $this->Payment->create();
	    $this->Payment->save($arr1);
	}
	$this->Session->setFlash('You have successfully added your shop.', 'default', array('class' => 'success'));
	return $this->redirect(array('controller' => 'shops', 'action' => 'details',  base64_encode($Shop_id)));
	
    }


    //http://107.170.152.166/twop/users/appsignup/nits.ananya15@gmail.com/123456/Ananya/Bera/NITS/9875847858
    
   /* public function appsignup($email=null, $pass=null, $firstname=null, $lastname=null, $company=null, $phone=null){
	$this->autoRender = false;
	$data=array();
	
	if ($email !='' && $pass !='' ) 
	{
	    $key = Configure::read('CONTACT_EMAIL');
	    $SITE_URL = Configure::read('SITE_URL');
	    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$data['Ack'] = 0;
		$data['msg'] = 'Please enter valid email.';
	    }
	    else{
		// $email=$this->request->data['User']['email'];
		 $options = array('conditions' => array('User.email'  => $email));
		 $emailexists = $this->User->find('first', $options);
		 if(!$emailexists)
		 {
		     if($pass==$cpass)
			     {
				 $arr=array();
				     //$password =$this->request->data['User']['password'];
				     //$data['User']['is_active'] = 0;
				     $arr['User']['email'] = $email;
				     $arr['User']['password'] = $pass;
				     $arr['User']['first_name'] = $firstname;
				     $arr['User']['last_name'] = $lastname;
				     $arr['User']['company_name'] = $company;
				     $arr['User']['mobile_number'] = $phone;
				     $arr['User']['type'] = 'C';
				     $arr['User']['is_active'] = 1;
				     $arr['User']['is_admin'] = 0;
				     $arr['User']['is_user'] = 1;
				     $arr['User']['username'] = $firstname.rand();
				     $arr['User']['registration_date'] = date('Y-m-d');
				     //pr($data);exit;
				     $this->User->create();
				     if ($this->User->save($arr)) 
				     {

				      $id=$this->User->getLastInsertId();

				      $this->loadModel('EmailTemplate');

				      $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>2)));
				      $link='<a href="'.$SITE_URL.'users/activation/'.base64_encode($id).'">Click Here</a>';

				      $mail_body =str_replace(array('[LINK]','[PASSWORD]','[EMAIL]'),array($link,$pass,$email),$EmailTemplate['EmailTemplate']['content']);

				      $this->send_mail($key,$email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);


				      //$this->Session->setFlash('You have successfully registered. Please check your mail.', 'default', array('class' => 'success'));
				      //return $this->redirect($this->request->referer());


					 $data['LastID'] = $id;
					 $data['Ack'] = 1;
					 $data['msg'] = 'You have successfully registered. Please check your mail.';
					 $data['UserDetails'] = array(
					 "id" => $id,
					 "first_name" => isset($firstname) ? $firstname : '',
					 "last_name" => isset($lastname) ? $lastname : '',
					 "email" => isset($email) ? $email : '',
					 "phone" => isset($phone) ? $phone : ''

					); 
				     }
			     }
			     else 
			     {
				 $data['Ack'] = 0;
				 $data['msg'] = 'Password and Confirm Password Mismatch. Please, try again.';
				     //$this->Session->setFlash(__('Password and Confirm Password Mismatch. Please, try again.', 'default', array('class' => 'error')));
			     }
		       }
		       else
		       {
			     $data['Ack'] = 0;
			     $data['msg'] = 'Email already exists';
			     // $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
			      //return $this->redirect($this->request->referer());
		       }


		}
        }		  
	else{
	    $data['Ack'] = 0;
	    $data['msg'] = 'Signup error, Provide All Details';
	}
	
	//echo json_encode($data);

	//return json_encode($data);
	$result = json_encode($data);
	return $result;
	
    }*/
    
  //  http://107.170.152.166/twop/users/appsignup?email=nits.ananya15@gmail.com&password=123456&firstname=Ananya&lastname=Bera&companyname=NITS&phone=9875847858&my_latitude=12.987498237&my_longitude=58.565464
    
   public function appsignup(){
	$this->autoRender = false;
	$data=array();
	if (!empty($_REQUEST)){
	    //pr($_REQUEST);exit;
	    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
	    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
	    $firstname = isset($_REQUEST['firstname']) ? $_REQUEST['firstname'] : '';
	    $lastname = isset($_REQUEST['lastname']) ? $_REQUEST['lastname'] : '';
	    $companyname = isset($_REQUEST['companyname']) ? $_REQUEST['companyname'] : '';
	    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
            $my_latitude = isset($_REQUEST['my_latitude']) ? $_REQUEST['my_latitude'] : '';
            $my_longitude = isset($_REQUEST['my_longitude']) ? $_REQUEST['my_longitude'] : '';
            $devicetoken = isset($_REQUEST['devicetoken']) ? $_REQUEST['devicetoken'] : '';
            $name = $firstname.' '.$lastname;
	    if ($email !='' && $password !='' ) 
	    {
		$key = Configure::read('CONTACT_EMAIL');
		$SITE_URL = Configure::read('SITE_URL');
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		    $data['Ack'] = 0;
		    $data['msg'] = 'Please enter valid email.';
		}else{
		    // $email=$this->request->data['User']['email'];
                    $options = array('conditions' => array('User.email'  => $email));
                    $emailexists = $this->User->find('first', $options);
                    if(!$emailexists){
                        $arr=array();
			
                        $arr['User']['email'] = $email;
                        $arr['User']['txt_password'] = $password;
                        $arr['User']['password'] = $password;
                        $arr['User']['first_name'] = $firstname;
                        $arr['User']['last_name'] = $lastname;
                        $arr['User']['company_name'] = $companyname;
                        $arr['User']['mobile_number'] = $phone;
                        $arr['User']['my_latitude'] = $my_latitude;
                        $arr['User']['my_longitude'] = $my_longitude;
                        $arr['User']['devicetoken'] = $devicetoken;
                        $arr['User']['device_type'] = $devicetoken;
                        //$arr['User']['type'] = 'C';
                        $arr['User']['is_active'] = 0;
                        $arr['User']['is_admin'] = 0;
                        //$arr['User']['is_user'] = 1;
                        $arr['User']['username'] = $firstname.rand();
                        $arr['User']['registration_date'] = gmdate('Y-m-d');
                        $this->User->create();
                        if ($this->User->save($arr)){
                            $id=$this->User->getLastInsertId();
                            $this->loadModel('EmailTemplate');
                            $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>2)));
                            $link='<a href="'.$SITE_URL.'users/activation/'.base64_encode($id).'">Click Here</a>';
                            $mail_body =str_replace(array('[NAME]','[LINK]','[PASSWORD]','[EMAIL]'),array($name,$link,$password,$email),$EmailTemplate['EmailTemplate']['content']);
                            $this->send_mail($key,$email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                            $getUserdetails=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));

                            $data['Ack'] = 1;
                            $data['msg'] = 'You have successfully registered. Please check your mail.';
                            $data['UserDetails'] = array(
                                "user_id" => stripslashes($getUserdetails['User']['id']),
                                "first_name" => stripslashes($getUserdetails['User']['first_name']),
                                "last_name" => stripslashes($getUserdetails['User']['last_name']),
                                "company_name" => stripslashes($getUserdetails['User']['company_name']),
                                "email" => stripslashes($getUserdetails['User']['email']),
                                "type" => stripslashes($getUserdetails['User']['type']),
                                "profile_image" => stripslashes($getUserdetails['User']['profile_image']),
                                "mobile_number" => stripslashes($getUserdetails['User']['mobile_number']),
                                "is_active" => 0,
				"registration_date" => stripslashes($getUserdetails['User']['registration_date']),
				"paypal_business_email" => stripslashes($getUserdetails['User']['paypal_business_email']),
                                "bio" => stripslashes($getUserdetails['User']['bio']),
                                "address" => stripslashes($getUserdetails['User']['address']),
                                "gender" => stripslashes($getUserdetails['User']['gender']),
                                "zip_code" => stripslashes($getUserdetails['User']['zip_code']),
				"twitter_url" => stripslashes($getUserdetails['User']['twitter_url']),
				"linkdin_url" => stripslashes($getUserdetails['User']['linkdin_url']),
				"youtube_url" => stripslashes($getUserdetails['User']['youtube_url']),
                                "facebook_url" => stripslashes($getUserdetails['User']['facebook_url']),
                                "nick_name" => stripslashes($getUserdetails['User']['nick_name']),
				"alternate_email" => stripslashes($getUserdetails['User']['alternate_email']),
				"city" => stripslashes($getUserdetails['User']['city']),
				"state" => stripslashes($getUserdetails['User']['state']),
				"country" => stripslashes($getUserdetails['User']['country']),
				"telephone_country_code" => stripslashes($getUserdetails['User']['telephone_country_code']),
				"telephone_area_code" => stripslashes($getUserdetails['User']['telephone_area_code']),
				"telephone_number" => stripslashes($getUserdetails['User']['telephone_number']),
				"fax_country_code" => stripslashes($getUserdetails['User']['fax_country_code']),
				"fax_area_code" => stripslashes($getUserdetails['User']['fax_area_code']),
				"fax_number" => stripslashes($getUserdetails['User']['fax_number']),
				"job_title" => stripslashes($getUserdetails['User']['job_title']),
				"shop_address" => stripslashes($getUserdetails['User']['shop_address']),
				"shop_vat" => stripslashes($getUserdetails['User']['shop_vat']),
				"shop_city" => stripslashes($getUserdetails['User']['shop_city']),
				"shop_company_reg_no" => stripslashes($getUserdetails['User']['shop_company_reg_no']),
				"shop_country" => stripslashes($getUserdetails['User']['shop_country']),
				"shop_zip_code" => stripslashes($getUserdetails['User']['shop_zip_code']),
				"balance" => stripslashes($getUserdetails['User']['balance']),
				"shipping_full_name" => stripslashes($getUserdetails['User']['shipping_full_name']),
				"shipping_address" => stripslashes($getUserdetails['User']['shipping_address']),
				"shipping_city" => stripslashes($getUserdetails['User']['shipping_city']),
				"shipping_state" => stripslashes($getUserdetails['User']['shipping_state']),
				"shipping_country" => stripslashes($getUserdetails['User']['shipping_country']),
				"shipping_zip_code" => stripslashes($getUserdetails['User']['shipping_zip_code']),
				"my_latitude" => stripslashes($getUserdetails['User']['my_latitude']),
                                "my_longitude" => stripslashes($getUserdetails['User']['my_longitude'])
                                ); 
                        }
                    }else{
                        $data['Ack'] = 0;
                        $data['msg'] = 'Email already exists';
                    }
                }
	    }		  
	    else{
		$data['Ack'] = 0;
		$data['msg'] = 'Signup error, Provide All Details';
	    }
	}
	else{
		$data['Ack'] = 0;
		$data['msg'] = 'Signup error, Provide All Details';
	    }
	$result = json_encode($data);
	return $result;	
    }
    
    //http://107.170.152.166/twop/users/appsignin?email=nits.avik@gmail.com&password=6962
    
    public function appsignin(){
	$this->autoRender = false;
	$data=array();
	$userid = $this->Session->read('Auth.User.id');
	$key = Configure::read('CONTACT_EMAIL');
	$SITE_URL = Configure::read('SITE_URL');
	//pr($_REQUEST);exit;
	if (!empty($_REQUEST)){
            $email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
            $pass = isset($_REQUEST['password'])?$_REQUEST['password']:'';
            if($email=='' || $pass==''){
                $data['Ack'] = 0;
                $data['msg'] = 'Login error, Please Enter Your login details';
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $data['Ack'] = 0;
                    $data['msg'] = 'Please enter valid email.';
                }else{
                    $this->request->data['User']['email'] = $email;
                    $this->request->data['User']['password'] = $pass;
                    if($this->Auth->login()) {
                        $is_active = $this->Session->read('Auth.User.is_active');
                        $firstname = $this->Session->read('Auth.User.first_name');
                        $lastname = $this->Session->read('Auth.User.last_name');
                        $phone = $this->Session->read('Auth.User.mobile_number');
                        $company = $this->Session->read('Auth.User.company_name');
                        $email_addr = $this->Session->read('Auth.User.email');
                        
                        if($is_active==1){
                            $user_id = $this->Session->read('Auth.User.id');
                            $description = 'Logged in User : '.$email_addr;
                            $this->save_activity($user_id,$description);
                            $getUserdetails=$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
                            $data['Ack']=1;
                            $data['UserDetails'] = array(
                                
                                "user_id" => stripslashes($getUserdetails['User']['id']),
                                "first_name" => stripslashes($getUserdetails['User']['first_name']),
                                "last_name" => stripslashes($getUserdetails['User']['last_name']),
                                "company_name" => stripslashes($getUserdetails['User']['company_name']),
                                "email" => stripslashes($getUserdetails['User']['email']),
                                "type" => stripslashes($getUserdetails['User']['type']),
                                "profile_image" => stripslashes($getUserdetails['User']['profile_image']),
                                "mobile_number" => stripslashes($getUserdetails['User']['mobile_number']),
                                "is_active" => stripslashes($getUserdetails['User']['is_active']),
				"registration_date" => stripslashes($getUserdetails['User']['registration_date']),
				"paypal_business_email" => stripslashes($getUserdetails['User']['paypal_business_email']),
                                "bio" => stripslashes($getUserdetails['User']['bio']),
                                "address" => stripslashes($getUserdetails['User']['address']),
                                "gender" => stripslashes($getUserdetails['User']['gender']),
                                "zip_code" => stripslashes($getUserdetails['User']['zip_code']),
				"twitter_url" => stripslashes($getUserdetails['User']['twitter_url']),
				"linkdin_url" => stripslashes($getUserdetails['User']['linkdin_url']),
				"youtube_url" => stripslashes($getUserdetails['User']['youtube_url']),
                                "facebook_url" => stripslashes($getUserdetails['User']['facebook_url']),
                                "nick_name" => stripslashes($getUserdetails['User']['nick_name']),
				"alternate_email" => stripslashes($getUserdetails['User']['alternate_email']),
				"city" => stripslashes($getUserdetails['User']['city']),
				"state" => stripslashes($getUserdetails['User']['state']),
				"country" => stripslashes($getUserdetails['User']['country']),
				"telephone_country_code" => stripslashes($getUserdetails['User']['telephone_country_code']),
				"telephone_area_code" => stripslashes($getUserdetails['User']['telephone_area_code']),
				"telephone_number" => stripslashes($getUserdetails['User']['telephone_number']),
				"fax_country_code" => stripslashes($getUserdetails['User']['fax_country_code']),
				"fax_area_code" => stripslashes($getUserdetails['User']['fax_area_code']),
				"fax_number" => stripslashes($getUserdetails['User']['fax_number']),
				"job_title" => stripslashes($getUserdetails['User']['job_title']),
				"shop_address" => stripslashes($getUserdetails['User']['shop_address']),
				"shop_vat" => stripslashes($getUserdetails['User']['shop_vat']),
				"shop_city" => stripslashes($getUserdetails['User']['shop_city']),
				"shop_company_reg_no" => stripslashes($getUserdetails['User']['shop_company_reg_no']),
				"shop_country" => stripslashes($getUserdetails['User']['shop_country']),
				"shop_zip_code" => stripslashes($getUserdetails['User']['shop_zip_code']),
				"balance" => stripslashes($getUserdetails['User']['balance']),
				"shipping_full_name" => stripslashes($getUserdetails['User']['shipping_full_name']),
				"shipping_address" => stripslashes($getUserdetails['User']['shipping_address']),
				"shipping_city" => stripslashes($getUserdetails['User']['shipping_city']),
				"shipping_state" => stripslashes($getUserdetails['User']['shipping_state']),
				"shipping_country" => stripslashes($getUserdetails['User']['shipping_country']),
				"shipping_zip_code" => stripslashes($getUserdetails['User']['shipping_zip_code']),
				"my_latitude" => stripslashes($getUserdetails['User']['my_latitude']),
                                "my_longitude" => stripslashes($getUserdetails['User']['my_longitude'])
                                ); 
                            $data['msg']='You have successfully logged In';
                        }else{
                            $this->Auth->logout();
                            $data['Ack'] = 0;
                            $data['msg'] = 'Inactive user. You need to confirm your mail.';
                        }
                    }else{
                        $data['Ack'] = 0;
                        $data['msg'] = 'Invalid Email or Password, Please try again.';
                    }
                }
            }
        }else{
            $data['Ack'] = 0;
            $data['msg'] = 'Login error, Email or Password is Missing';
        }
	$result = json_encode($data);
	return $result;

    }
     
    
  //  http://107.170.152.166/twop/users/appforgotpass?email=nits.ananya15@gmail.com
    
    public function appforgotpass_OLD(){
	
	$this->autoRender = false;
	$data = array();
	if (!empty($_REQUEST)){
	    $email = $_REQUEST['email'];
	    if($email=='')
	     {
		 $data['Ack'] = 0;
		 $data['msg'] = 'Please enter your email.';
	         //$this->Session->setFlash(__('Please enter your email.', 'default', array('class' => 'error')));
	         //return $this->redirect($this->request->referer());
	     }
	     else
	     {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	        {
		    $data['Ack'] = 0;
		    $data['msg'] = 'Please enter valid email.';
	          //$this->Session->setFlash(__('Please enter valid email.', 'default', array('class' => 'error')));
	          //return $this->redirect($this->request->referer());
	        }
	        else
	        {
		  $options = array('conditions' => array('User.email' => $email));
		  $user = $this->User->find('first', $options); 
		  if($user)
		  {
		     $password = $this->User->get_fpassword();
                     $this->request->data['User']['id'] = $user['User']['id'];
		     $this->request->data['User']['txt_password'] = $password;
		     $this->request->data['User']['password'] = $password;
		     
		     if ($this->User->save($this->request->data)) 
		     {
			   $key = Configure::read('CONTACT_EMAIL');
			   $this->loadModel('EmailTemplate');
			   $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>3)));

			   $mail_body =str_replace(array('[EMAIL]','[PASSWORD]'),array($email,$password),$EmailTemplate['EmailTemplate']['content']);

			   $this->send_mail($key,$email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);

			  $data['Ack'] = 1;
			  $data['msg'] = 'A new password has been sent to your mail. Please check mail.';
		    
			//   $this->Session->setFlash('A new password has been sent to your mail. Please check mail.', 'default', array('class' => 'success'));
			//   return $this->redirect($this->request->referer());
		     }
		     else 
	             {
			$data['Ack'] = 0;
			$data['msg'] = 'Sorry! some internal error occurred. Please try again later.';
		      // $this->Session->setFlash("Sorry! some internal error occurred. Please try again later.");
		       //return $this->redirect($this->request->referer());
		     }
	          } 
	          else 
	          {
		      $data['Ack'] = 0;
		      $data['msg'] = 'Sorry! we can not find your email.';
	           //$this->Session->setFlash("Sorry! we can not find your email.");
		   //return $this->redirect($this->request->referer());
	          }
	        }
	      }
          }
	  else{
	      $data['Ack'] = 0;
	      $data['msg'] = 'Please provide your email address.';
	  }
	$result = json_encode($data);
	return $result;
    }
	
	
	 public function app_update_email(){
	$this->autoRender = false;
	$data=array();
	
	if (!empty($_REQUEST)){

	    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
	    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';


		$options = array('conditions' => array('User.email'  => $email, 'User.id !='  => $user_id));
		$emailexists = $this->User->find('first', $options);
		if(!$emailexists){
		$arr=array();
		
		$arr['User']['email'] = $email;
		$arr['User']['id'] = $user_id;
		
		if ($this->User->save($arr)){		
		$data['Ack'] = 1;
		$data['msg'] = 'Email Updated Successfully';
		
		
		}
		else{
		$data['Ack'] = 0;
		$data['msg'] = 'Email already exists';
		}
		
		}		  
	    else{
		$data['Ack'] = 0;
		$data['msg'] = 'Email Already Exists';
	    }
		
		

	$result = json_encode($data);
	return $result;	
    }
	}
	  


     public function app_password_updated(){
	$this->autoRender = false;
	$data=array();
	if (!empty($_REQUEST)){
	    $old_password = isset($_REQUEST['old_password']) ? $_REQUEST['old_password'] : '';
            $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
	    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
		//$PasswordHasher = new SimplePasswordHasher();
		//$curr_pass_hash=$PasswordHasher->hash($password);
            $options = array('conditions' => array('User.id'  => $user_id));
            $user_details = $this->User->find('first', $options);
            if(count($user_details)>0){
		$arr=array();
		$user_previous_pws=$user_details['User']['txt_password'];
                if($user_previous_pws!=$old_password){
                    $data['Ack'] = 0;
                    $data['msg'] = 'Error! you enter wrong password.';
                }else{
                    $arr['User']['password'] = $password;
                    $arr['User']['txt_password'] = $password;
                    $arr['User']['id'] = $user_id;
                    if ($this->User->save($arr)){		
                        $data['Ack'] = 1;
                        $data['msg'] = 'Password Updated Successfully';
                    }else{
                        $data['Ack'] = 0;
                        $data['msg'] = 'Error!!!';
                    }
                }
	    }else{
		$data['Ack'] = 0;
		$data['msg'] = 'Error!!!';
            }

            $result = json_encode($data);
            return $result;	
        }
    }	 
	
	//  //  http://107.170.152.166/twop/users/appforgotpass?email=nits.avik@gmail.com
	
	public function appforgotpass(){
	$this->autoRender = false;
	$data=array();
	
	if (!empty($_REQUEST)){
	
	$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
	$password=rand(1111,9999);
	
	
	$options = array('conditions' => array('User.email' => $email));
	$user = $this->User->find('first', $options); 
	$user_id=$user['User']['id'];
	if($user_id!=''){
	$user_name=$user['User']['first_name'];
	//$PasswordHasher = new SimplePasswordHasher();
	//$curr_pass_hash=$PasswordHasher->hash($password);
	
	$arr=array();
	
	$arr['User']['password'] = $password;
	$arr['User']['txt_password'] = $password;
	$arr['User']['id'] = $user_id;
	
	if ($this->User->save($arr)){		


		$subject = "widding.com- Your Password Request";
		$TemplateMessage = "Hello " . $user_name . "<br />";
		$TemplateMessage .= "You have asked for your new password. Your Password is below :<br />";
		$TemplateMessage .= "Password :" . $password;
		$TemplateMessage .= "<br /><br />";
		$TemplateMessage .= "Thanks,<br />";
		$TemplateMessage .= "widding.com<br />";
		
		
		
		$header = "From:info@widding.com \r\n";
		// $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";
		
		$retval = mail($email, $subject, $TemplateMessage, $header);
			
	
	$data['Ack'] = 1;
	$data['msg'] = 'Your New Password Sent To Your Email';
	}
	else{
	$data['Ack'] = 0;
	$data['msg'] = 'Error!!!';
	}
	
	}
	else{
	$data['Ack'] = 0;
	$data['msg'] = 'Error!!! Email not found in our Database.';	
	
	}
	
	
	
	$result = json_encode($data);
	return $result;	
	}
	}	 
    
    public function applogout() 
    {
	$this->autoRender = false;
	$data = array();
	  $user_id = $this->Session->read('Auth.User.id');
	  $this->Auth->logout();
	  
	  $description = 'User Logout ';
	  $this->save_activity($user_id,$description);
	  
	  $data['Ack'] = 1;
	  $data['msg'] = 'You have successfully logged out.';
	  
	$result = json_encode($data);
	return $result;
	//  $this->Session->setFlash('You have successfully logged out.', 'default', array('class' => 'success'));
	//  $this->redirect('/');
    }
    
    /******************Kundu*****************/
 public function wishlist(){
        $title_for_layout = 'Favourites Product';
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$this->loadModel('Category');
	$this->loadModel('Wishlist');
	$this->Wishlist->recursive = 2;
	$sub_category_list=array();
        $categorySubSearch='';
	if ($this->request->is(array( 'put','get'))) {
            $categorySearch=$_GET['categorySearch'];
            $categorySubSearch=isset($_GET['categorySubSearch'])?$_GET['categorySubSearch']:'';
            $conditions['AND']['Wishlist.user_id']=$userid;
            $order = 'Wishlist.id desc'; 
            if(isset($_GET['categorySearch']) && !empty($_GET['categorySearch'])){
                $cat = $_GET['categorySearch'];
                $conditions['AND']['Wishlist.category_id'] = $_GET['categorySearch'];
            }
            if($categorySubSearch!=''){
                $conditions['AND']['Wishlist.sub_category_id'] = $categorySubSearch;
            }
            
            if(isset($_GET['sort']) && !empty($_GET['sort'])){
                $sort = $_GET['sort'];
                $order = 'Wishlist.price '.$sort; 
            }
            $this->Paginator->settings=array(
            'conditions'=> $conditions,
            'limit'=>'20',
            'order'=>$order   
            );
            $wishlist_skill =$this->Paginator->paginate('Wishlist');
            if($categorySearch!=''){
                $sub_category_list=$this->Category->find('list', array('conditions' => array('Category.parent_id' => $categorySearch, 'Category.is_active' =>1),'order' => array('Category.name' => 'asc')));
            }
	}else{
            $conditions['AND']['Wishlist.user_id']=$userid;
            $this->Paginator->settings=array(
            'conditions'=> $conditions,
            'limit'=>'20',
            'order'=>'Wishlist.id desc'   
            );
            $wishlist_skill =$this->Paginator->paginate('Wishlist');
	}
        $options = array('conditions' => array('Category.parent_id' => 0, 'Category.is_active' =>1));
        $category=$this->Category->find('list', $options);

        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
	$this->set(compact('user','wishlist_skill','category','cat','sort','sub_category_list','categorySubSearch','title_for_layout'));
}

 public function follow(){
        $title_for_layout = 'Followed Store';
 	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$this->loadModel('Follow');
	$this->Follow->recursive = 2;
 	$conditions['AND']['Follow.user_id']=$userid;
	 	$this->Paginator->settings=array(
		'conditions'=> $conditions,
		'limit'=>'20',
		'order'=>'Follow.id desc'   
		);
		$follow =$this->Paginator->paginate('Follow');
	$this->set(compact('user','follow','title_for_layout'));	
 }
	/******************Kundu*****************/
}
?>
