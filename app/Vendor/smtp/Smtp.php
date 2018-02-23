<?php
require_once("class/class.phpmailer.php");
abstract class Smtp {}
  public function send_mail($MailTo, $MailSubject, $MailHtmlMessage){
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
    $MailFrom='info@natit.us';
    $MailFromName='Baybarter';
    $MailToName='';
    $YourEamilPassword="Natit2016"; //Your email password from which email you send.

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
      if(is_array($MailAttachment))
      for($i=0;$i<count($MailAttachment);$i++)
           {
    	   if(file_exists($MailAttachment[$i]))
    	      {
    		    $mail->AddAttachment($MailAttachment[$i]); 
    		  
    		  }
    	   
    	   }   
      
       try {
        if ( !$mail->Send() ) {
          $error = "Unable to send to: " . $to . "<br />";
          throw new phpmailerAppException($error);
        } else {
          echo 'Message has been sent <br /><br />';
        }
      }
      catch (phpmailerAppException $e) {
        $errorMsg[] = $e->errorMessage();
      }

    }
  }





?>


