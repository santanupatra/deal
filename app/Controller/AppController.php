<?php
ini_set('max_execution_time', 300);
require(APP . 'Vendor' . DS . 'smtp/class/class.phpmailer.php');
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Auth' => array(
		'authenticate' => array
		   (
			   'Form' => array
			   (
				 'fields' => array('username' => 'email', 'password' => 'password')
			   )
		   ),
            'loginRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'logout'
            )
        )
    );
    public function beforeFilter() {
	$adminRoute = Configure::read('Routing.prefixes');
	if (isset($this->params['prefix']) && in_array($this->params['prefix'], $adminRoute)) {
	    $this->layout = 'admin_default';
	} else {
	    $this->layout = 'default';
	}
    }
    public function beforeRender() {

        $this->loadModel('User'); 
        $this->loadModel('Content');
        $this->loadModel('SiteSetting');
        $this->loadModel('Category');
        $this->loadModel('Shop');

        $SITE_URL = Configure::read('SITE_URL');

        $userid = $this->Session->read('Auth.User.id');

        if(isset($userid) && $userid!=''){

            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $userdetails=$this->User->find('first', $options);

           
          
            $this->loadModel('User');
            
            $this->set(compact('userdetails'));
            
        }
 
        $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
        $sitesetting = $this->SiteSetting->find('first', $options);

        $options = array('conditions' => array('Category.parent_id' => 0,'Category.is_active'=>1, 'Category.type' => 'D'),'order' => array('Category.ordering' => 'asc'));
        $dealcategory = $this->Category->find('all', $options);

        $options1 = array('conditions' => array('Category.parent_id' => 0,'Category.is_active'=>1, 'Category.type' => 'C'),'order' => array('Category.ordering' => 'asc'));
        $couponcategory = $this->Category->find('all', $options1);
       
        $allshops = $this->Shop->find("all",array('conditions'=>array('Shop.is_active'=> 1), 'fields'=>array('Shop.id', 'Shop.name')));
      
      //end
        $this->set(compact('sitesetting','SITE_URL','userid','dealcategory','couponcategory', 'allshops'));
		
      
    }
    

    public function checkShopIsActive($shop_id=null){
    		$shop_id = base64_decode($shop_id);
    		$userid = $this->Session->read('Auth.User.id');
    		$this->loadModel('Shop');
    		$shopIOwn = $this->Shop->find('first', array('conditions' => array('Shop.user_id' => $userid)));
    		if(isset($shopIOwn) && !empty($shopIOwn) && $shopIOwn['Shop']['is_active']==1 && strtotime($shopIOwn['Shop']['last_date'])>strtotime(date('Y-m-d'))){
    			return 1;	
    		}else{
    			return 0;
    		}
    }
    
  //   public function send_mail($from=null,$to=null,$subject=null,$body=null)
  //   {
	 // $Email = new CakeEmail();
	 // $Email->emailFormat('both');
	 // $Email->from($from);
	 // $Email->to($to);
	 // $Email->subject($subject);
	 // $Email->send($body);
  //   }




 public function php_mail($to, $from, $subject, $message) {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            //$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            //$headers .= 'To: '.$to_name.' <'.$to.'>' . "\r\n";
            $headers .= 'From: '.$from . "\r\n";
            mail($to, $subject, $message, $headers);
        }

 function send_smtpmail($MailTo, $from,$MailSubject, $MailHtmlMessage , $MailAttachment =null){
           $mail = new PHPMailer();
            
            /* =======================Configuration by You======================================= */
            /*$MailTo='infoskysol@gmail.com';     // email id to whome you want to send
            $MailToName='';
            $MailFrom='noreply@smshut.com';    //  Your email password
            $MailFromName='';
            $YourEamilPassword="infosms123";   //Your email password from which email you send.
            $MailSubject='Message are send through smpt';  // Message title
            $MailHtmlMessage='Name: '.$_POST['fullname']."<br>";  // Message Body
            $MailHtmlMessage.='Phone: '.$_POST['phone']."<br>";
            $MailHtmlMessage.='Email: '.$_POST['email']."<br>";
            $MailHtmlMessage.='Comment: '.$_POST['comment']."<br>";*/

            $IsMailType='SMTP';   
            $MailFrom='mail@natitsolved.com';
            $MailFromName='Deal & Coupon';
            $MailToName='';
            $YourEamilPassword="Natit@2017"; //Your email password from which email you send.

            // If you use SMTP. Please configure the bellow settings.

              $SmtpHost             = "smtp.gmail.com"; // sets the SMTP server
              $SmtpDebug            = 0;                     // enables SMTP debug information (for testing)
              $SmtpAuthentication   = true;                  // enable SMTP authentication
              $SmtpPort             = 587;                    // set the SMTP port for the GMAIL server
              $SmtpUsername       = $MailFrom; // SMTP account username
              $SmtpPassword       = $YourEamilPassword;        // SMTP account password
            //

            if ( $IsMailType == "SMTP" ) {
                $mail->IsSMTP();  // telling the class to use SMTP
                $mail->SMTPDebug  = $SmtpDebug;
                $mail->SMTPAuth   =  $SmtpAuthentication;     // enable SMTP authentication
                $mail->Port       = $SmtpPort;             // set the SMTP port
                $mail->Host       = $SmtpHost;           // SMTP server
                $mail->Username   =  $SmtpUsername; // SMTP account username
                $mail->Password   = $SmtpPassword; // SMTP account password
              } elseif ( $IsMailType == "mail" ) {
                $mail->IsMail();      // telling the class to use PHP's Mail()
              } elseif ( $IsMailType == "sendmail" ) {
                $mail->IsSendmail();  // telling the class to use Sendmail
              } elseif ( $IsMailType == "qmail" ) {
                $mail->IsQmail();     // telling the class to use Qmail
              }

              if ( $MailFromName != '' ) {
                $mail->AddReplyTo($MailFrom,$MailFromName);
                $mail->From       = $MailFrom;
                $mail->FromName   = $MailFromName;
              } else {
                $mail->AddReplyTo($MailFrom);
                $mail->From       = $MailFrom;
                $mail->FromName   = $MailFrom;
              }

              if ( $MailToName != '' ) {
                $mail->AddAddress($MailTo,$MailToName);
              } else {
                $mail->AddAddress($MailTo);
              }

              $mail->SMTPSecure = 'tls';
              $mail->Subject  = $MailSubject;

              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
              $mail->MsgHTML($MailHtmlMessage);
             // $mail->AddAttachment($MailAttachment);  
              
               try {
                if ( !$mail->Send() ) {
                  $error = "Unable to send to: " . $to . "<br />";
                  throw new phpmailerAppException($error);
                } else {
                  //echo 'Message has been sent <br /><br />';
                }
              }
              catch (phpmailerAppException $e) {
                $errorMsg[] = $e->errorMessage();
              }

            }
    function createSlug($string, $ext=''){     
        $replace = '-';         
        $string = strtolower($string);     

        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);     
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);     

        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);     

        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);     

        //limit the slug size     
        $string = substr($string, 0, 200);     

        //slug is generated     
        return ($ext) ? $string.$ext : $string; 
    }
    
    public function save_activity($user_id=null,$description=null){
        $this->loadModel('Activity');
        $this->Activity->create();
        $this->request->data['Activity']['user_id'] = $user_id;
        $this->request->data['Activity']['description'] = $description;
        $this->request->data['Activity']['created_at'] = date('Y-m-d H:i:s');
        $this->Activity->save($this->request->data);
    }
}
