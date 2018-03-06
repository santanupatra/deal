<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */

use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\FundingConstraint;
use PayPal\Types\AP\FundingTypeInfo;
use PayPal\Types\AP\FundingTypeList;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\AP\RefundRequest;  
use PayPal\Types\AP\SenderIdentifier;
use PayPal\Types\AP\ExecutePaymentRequest;
use PayPal\Types\Common\PhoneNumberType;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\PaymentDetailsRequest;

class OrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','RequestHandler','Paginator');
	var $uses = array('Order','OrderDetail','Shop','Country','User','Category','Attribute','AttributeItem','UserPaymentDetail','UserBillingAddress','UserCreditCard','Product','ListAttribute','ListAttributeItem','ListTag','ListMaterial','ListDispatch','ListImage','ListFile','ShopSetting','ShopFollowing','SiteSetting','PartnershipDetail','date_different','BuyerFeedback');

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $this->loadModel('OrderDetail');
            $this->loadModel('ExtendProcessingTime');
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Sales Track List';
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='Extend Processing Time'){
                    $SITE_URL = Configure::read('SITE_URL');
                    
                    $OrderDetailsID=$this->request->data['OrderDetailsID'];
                    $TimeBy=$this->request->data['TimeBy'];
                    $ord_det_id=  base64_decode($OrderDetailsID);
                    $orderdetails = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_det_id)));
                    $buyer_order_id=$orderdetails['OrderDetail']['order_id'];
                    $Received_user_id=$orderdetails['OrderDetail']['user_id'];
                    $Product_name=$orderdetails['Product']['name'];
                    $Buyer_name=$orderdetails['Buyer']['first_name'];
                    $Buyer_email=$orderdetails['Buyer']['email'];
                    $seller_name=$orderdetails['User']['first_name'].' '.$orderdetails['User']['last_name'];
                    $seller_email=$orderdetails['User']['email'];
                            
                    $Processing_data['ExtendProcessingTime']['order_details_id'] = $ord_det_id;
                    $Processing_data['ExtendProcessingTime']['order_id'] = $buyer_order_id;
                    $Processing_data['ExtendProcessingTime']['seller_id'] = $userid;
                    $Processing_data['ExtendProcessingTime']['no_of_day'] = $TimeBy;
                    $Processing_data['ExtendProcessingTime']['request_date'] = gmdate('Y-m-d H:i:s');
                    
                    $this->ExtendProcessingTime->create();			 
                    $this->ExtendProcessingTime->save($Processing_data);
                    
                    $ord_det_data['OrderDetail']['id'] = $ord_det_id;
                    $ord_det_data['OrderDetail']['extend_processing_time'] = 1;
                    $this->OrderDetail->save($ord_det_data);
                    
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$buyer_order_id, 'Comment.comment_type'=>0)));          
                    $NewOrderId=($Ord_sl_no+$buyer_order_id);
                    $link=$SITE_URL.'orders/order_details/'.  base64_encode($buyer_order_id);
                    $comment_data['Comment']['user_id'] = $userid;
                    $comment_data['Comment']['to_user_id'] = $Received_user_id;
                    $comment_data['Comment']['is_notification'] = 1;
                    $comment_data['Comment']['order_id'] = $buyer_order_id;
                    $comment_data['Comment']['order_details_id'] = $ord_det_id;
                    $comment_data['Comment']['thread_id'] = isset($thread_data['Comment']['thread_id'])?$thread_data['Comment']['thread_id']:0;
                    $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $comment_data['Comment']['subject'] = 'Seller Extend Processing Time for Order ID '.$NewOrderId;
                    //$comment_data['Comment']['comments'] = 'Seller extend the processing time of your order for delivery confirmation at the right time.<br > Product Name: '.$Product_name;
                    $comment_data['Comment']['comments'] = 'Seller extend the processing time '.$TimeBy.' days of your order for delivery confirmation at the right time.<br > Product Name: '.$Product_name.'<br > Order Details Link: <a href="'.$link.'"> Click here</a><br > Extend Processing time: '.$TimeBy.' days';
                    $comment_data['Comment']['comment_type'] = 8;
                    $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($comment_data);
                    
                    $key = Configure::read('CONTACT_EMAIL');
                    $this->loadModel('EmailTemplate');
                    
                    $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>11)));
                    //$link=$this->request->data['TrackDetail']['web_address'];
                    
                    $mail_body =str_replace(array('[NAME]','[PRODUCTNAME]','[SELLERNAME]','[EMAIL]','[DAYS]','[LINK]'),array($Buyer_name,$Product_name,$seller_name,$seller_email,$TimeBy,$link),$EmailTemplate['EmailTemplate']['content']);
                    $this->send_mail($key,$Buyer_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                    
                    $options = array('conditions' => array('OrderDetail.owner_id' => $userid), 'order' => array('OrderDetail.id' => 'desc'));
                    $this->Session->setFlash(__('You have successfully submited the request.'));
                }elseif($form_type=='Search Form'){
                    
                    $order_no=$this->request->data['order_no'];
                    $product_name=$this->request->data['product_name'];
                    $QueryStr="(OrderDetail.owner_id='".$userid."')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                    }
                    if($product_name!=''){
                        $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                    }
                    $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
                }
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.owner_id' => $userid), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
               
            $this->set(compact('orders','title_for_layout','order_no','product_name'));
	}
        
        public function buyer_extend_processing_time($order_details_id = null, $type = null){
            $this->loadModel('OrderDetail');
            $this->loadModel('ExtendProcessingTime');
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $ord_det_id=  base64_decode($order_details_id);
            $request_type=  base64_decode($type);
            if($ord_det_id!='' && $request_type==1){
                $GetProcessing_data = $this->ExtendProcessingTime->find('first',array('conditions' => array('ExtendProcessingTime.order_details_id'=>$ord_det_id), 'order' => array('ExtendProcessingTime.id' => 'desc')));
                $orderdetails = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_det_id)));
                $buyer_order_id=$orderdetails['OrderDetail']['order_id'];
                $Received_user_id=$orderdetails['OrderDetail']['owner_id'];
                $pre_delivery_date=$orderdetails['OrderDetail']['delivery_date'];
                $Product_name=$orderdetails['Product']['name'];
                
                $Buyer_name=$orderdetails['Buyer']['first_name'].' '.$orderdetails['Buyer']['last_name'];;
                $Buyer_email=$orderdetails['Buyer']['email'];
                $seller_name=$orderdetails['User']['first_name'];
                $seller_email=$orderdetails['User']['email'];
                    
                $user_full_name=isset($orderdetails['Buyer']['first_name'])?$orderdetails['Buyer']['first_name'].' '.$orderdetails['Buyer']['last_name']:'';
                //$Product_name=$orderdetails['OrderDetail']['name'];
                $no_of_day=$GetProcessing_data['ExtendProcessingTime']['no_of_day'];  
                if($no_of_day>0){
                    $delivery_date=gmdate('Y-m-d H:i:s', strtotime($pre_delivery_date." +".$no_of_day." days"));
                    //exit();
                    $ord_det_data['OrderDetail']['delivery_date'] = $delivery_date;
                }

                $Processing_data['ExtendProcessingTime']['id'] = $GetProcessing_data['ExtendProcessingTime']['id'];        
                $Processing_data['ExtendProcessingTime']['buyer_id'] = $userid;
                $Processing_data['ExtendProcessingTime']['type'] = 1;
                $Processing_data['ExtendProcessingTime']['pre_delivery_date'] = $pre_delivery_date;
                $Processing_data['ExtendProcessingTime']['buyer_responce_date'] = gmdate('Y-m-d H:i:s');
                $this->ExtendProcessingTime->save($Processing_data);

                $ord_det_data['OrderDetail']['id'] = $ord_det_id;
                $ord_det_data['OrderDetail']['buyer_responce_processing_time'] = 1;
                $this->OrderDetail->save($ord_det_data);

                $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$buyer_order_id, 'Comment.comment_type'=>0)));          
                $NewOrderId=($Ord_sl_no+$buyer_order_id);

                $comment_data['Comment']['user_id'] = $userid;
                $comment_data['Comment']['to_user_id'] = $Received_user_id;
                $comment_data['Comment']['is_notification'] = 1;
                $comment_data['Comment']['order_id'] = $buyer_order_id;
                $comment_data['Comment']['order_details_id'] = $ord_det_id;
                $comment_data['Comment']['thread_id'] = isset($thread_data['Comment']['thread_id'])?$thread_data['Comment']['thread_id']:0;
                $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                $comment_data['Comment']['subject'] = $user_full_name.' has accepted your extend processing time for Order ID '.$NewOrderId;
                $comment_data['Comment']['comments'] = $user_full_name.'has accepted your extend processing time on his order product name "'.$Product_name.'" and order ID: '.$NewOrderId;
                $comment_data['Comment']['comment_type'] = 8;
                $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                $this->Comment->create();			 
                $this->Comment->save($comment_data);
                
                $key = Configure::read('CONTACT_EMAIL');
                $SITE_URL = Configure::read('SITE_URL');
                $this->loadModel('EmailTemplate');

                $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>7)));
                //$link=$this->request->data['TrackDetail']['web_address'];

                $mail_body =str_replace(array('[NAME]','[BUYERNAME]','[PRODUCTNAME]','[ORDERID]'),array($seller_name,$Buyer_name,$Product_name,$NewOrderId),$EmailTemplate['EmailTemplate']['content']);
                $this->send_mail($key,$seller_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);

                $this->Session->setFlash(__('You have successfully accepted the request.'));
            }elseif($ord_det_id!='' && $request_type==2){
                $GetProcessing_data = $this->ExtendProcessingTime->find('first',array('conditions' => array('ExtendProcessingTime.order_details_id'=>$ord_det_id), 'order' => array('ExtendProcessingTime.id' => 'desc')));
                $orderdetails = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_det_id)));
                $buyer_order_id=$orderdetails['OrderDetail']['order_id'];
                $Received_user_id=$orderdetails['OrderDetail']['owner_id'];
                $pre_delivery_date=$orderdetails['OrderDetail']['delivery_date'];
                $Product_name=$orderdetails['Product']['name'];
                $user_full_name=isset($orderdetails['Buyer']['first_name'])?$orderdetails['Buyer']['first_name'].' '.$orderdetails['Buyer']['last_name']:'';
                $Buyer_email=$orderdetails['Buyer']['email'];
                $seller_name=$orderdetails['User']['first_name'];
                $seller_email=$orderdetails['User']['email'];
                
                $Processing_data['ExtendProcessingTime']['id'] = $GetProcessing_data['ExtendProcessingTime']['id'];        
                $Processing_data['ExtendProcessingTime']['buyer_id'] = $userid;
                $Processing_data['ExtendProcessingTime']['type'] = 2;
                $Processing_data['ExtendProcessingTime']['pre_delivery_date'] = $pre_delivery_date;
                $Processing_data['ExtendProcessingTime']['buyer_responce_date'] = gmdate('Y-m-d H:i:s');
                $this->ExtendProcessingTime->save($Processing_data);

                $ord_det_data['OrderDetail']['id'] = $ord_det_id;
                $ord_det_data['OrderDetail']['buyer_responce_processing_time'] = 2;
                $this->OrderDetail->save($ord_det_data);

                $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$buyer_order_id, 'Comment.comment_type'=>0)));          
                $NewOrderId=($Ord_sl_no+$buyer_order_id);

                $comment_data['Comment']['user_id'] = $userid;
                $comment_data['Comment']['to_user_id'] = $Received_user_id;
                $comment_data['Comment']['is_notification'] = 1;
                $comment_data['Comment']['order_id'] = $buyer_order_id;
                $comment_data['Comment']['order_details_id'] = $ord_det_id;
                $comment_data['Comment']['thread_id'] = isset($thread_data['Comment']['thread_id'])?$thread_data['Comment']['thread_id']:0;
                $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                $comment_data['Comment']['subject'] = $user_full_name.' has rejected your extend processing time for Order ID '.$NewOrderId;
                $comment_data['Comment']['comments'] = $user_full_name.'has rejected your extend processing time on his order product name "'.$Product_name.'" and order ID: '.$NewOrderId;
                $comment_data['Comment']['comment_type'] = 8;
                $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                $this->Comment->create();			 
                $this->Comment->save($comment_data);
                
                $key = Configure::read('CONTACT_EMAIL');
                $SITE_URL = Configure::read('SITE_URL');
                $this->loadModel('EmailTemplate');

                $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>8)));
                //$link=$this->request->data['TrackDetail']['web_address'];

                $mail_body =str_replace(array('[NAME]','[BUYERNAME]','[PRODUCTNAME]','[ORDERID]'),array($seller_name,$user_full_name,$Product_name,$NewOrderId),$EmailTemplate['EmailTemplate']['content']);
                if($seller_email!=''){
                    $this->send_mail($key,$seller_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                }
                $this->Session->setFlash(__('You have successfully rejected the request.'));
            }
            //return $this->redirect(array('action' => 'awaiting_shipment'));
            return $this->redirect($this->request->referer());
        }
        
        public function order_details($id=null) {
            $this->loadModel('OrderDetail');
            $this->loadModel('Comment');
            //$this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Order Details';
            $ord_id=  base64_decode($id);
            if($id==''){
                $this->redirect('/');
            }
            //$this->Order->recursive = 0;
            $orderdetails = $this->OrderDetail->find('all',array('conditions' => array('OrderDetail.order_id'=>$ord_id),'order' => array('OrderDetail.id' => 'desc')));
            if(count($orderdetails)==0){
                $this->redirect('/');
            }
            $order_data = $this->Order->find('first',array('conditions' => array('Order.id'=>$ord_id)));
            
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='message'){
                    $buyer_user_id=$order_data['Order']['user_id'];
                    $store_woner_id=$order_data['Order']['store_woner_id'];
                    if($userid==$buyer_user_id){
                        $Give_user_id=$userid;
                        $Received_user_id=$store_woner_id;
                    }elseif($userid==$store_woner_id){
                        $Give_user_id=$userid;
                        $Received_user_id=$buyer_user_id;
                    }else{
                        $Give_user_id=$userid;
                        $Received_user_id=0;
                    }
                    if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!=''){			$ext = explode('.',$this->request->data['Comment']['file_name']['name']);
			if($ext){
                            $uploadFolderbanner = "message_img";
                            $uploadPath = WWW_ROOT . $uploadFolderbanner;
                            $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                            if(in_array($ext[1],$extensionValid)){
                                $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Comment']['file_name']['name']));
                                $full_image_path = $uploadPath . '/' . $imageName;
                                move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);

                                $this->request->data['Comment']['file_name'] = $imageName;
                            } 
                        } else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                            return $this->redirect(array('action' => 'dispute_details',$id));
                        }
                    }else{
                        $this->request->data['Comment']['file_name'] = '';
                    }
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$ord_id, 'Comment.comment_type'=>0)));          
                    $NewOrderId=($Ord_sl_no+$ord_id);
                    $this->request->data['Comment']['user_id'] = $Give_user_id;
                    $this->request->data['Comment']['to_user_id'] = $Received_user_id;
                    $this->request->data['Comment']['is_notification'] = 0;
                    $this->request->data['Comment']['order_id'] = $ord_id;
                    $this->request->data['Comment']['order_details_id'] = 0;
                    $this->request->data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $this->request->data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $this->request->data['Comment']['subject'] = 'Re: Order ID '.$NewOrderId;
                    $this->request->data['Comment']['comment_type'] = 2;
                    $this->request->data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the message.'));
                }
            }
            $this->set(compact('orderdetails','title_for_layout'));
	}
        
        /*public function order_feedback($id=null) {
            $this->loadModel('OrderDetail');
            $this->loadModel('Rating');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Order Feedback';
            $ord_details_id=  base64_decode($id);
            if($id==''){
                $this->redirect('/');
            }
            //$this->Order->recursive = 0;
            $order = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_details_id),'order' => array('OrderDetail.id' => 'desc')));
            if(count($order)==0){
                $this->redirect('/');
            }
            
            if ($this->request->is(array('post', 'put'))) {
                $rating_user = $this->Rating->find('first',array('conditions' => array('Rating.user_id'=>$userid, 'Rating.product_id'=>$order['OrderDetail']['product_id'], 'Rating.order_details_id'=> $order['OrderDetail']['id'])));
                if(count($rating_user)>0){
                    $this->Session->setFlash(__('You have already submited the feedback for this purchase.'));
                }elseif($userid==$order['OrderDetail']['owner_id']){
                    $this->Session->setFlash(__('You can not give the feedback for this purchase.'));
                }else{
                    $this->request->data['Rating']['product_id'] = $order['OrderDetail']['product_id'];
                    $this->request->data['Rating']['shop_id'] = $order['OrderDetail']['shop_id'];
                    $this->request->data['Rating']['order_details_id'] = $order['OrderDetail']['id'];
                    $this->request->data['Rating']['order_id'] = $order['OrderDetail']['order_id'];
                    $this->request->data['Rating']['rated_to'] = $order['OrderDetail']['owner_id'];
                    $this->request->data['Rating']['user_id'] = $userid;
                    $this->request->data['Rating']['date_time'] = gmdate('Y-m-d H:i:s');
                    $this->Rating->create();			 
                    $this->Rating->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the feedback for this purchase.'));
                }
            }
            $this->set(compact('order','title_for_layout'));
	}*/
        
        public function order_feedback($id=null) {
            $this->loadModel('OrderDetail');
            $this->loadModel('Rating');
            $this->loadModel('Product');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Order Feedback';
            $ord_details_id=  base64_decode($id);
            if($id==''){
                $this->redirect('/');
            }
            //$this->Order->recursive = 0;
            $order = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_details_id),'order' => array('OrderDetail.id' => 'desc')));
            if(count($order)==0){
                $this->redirect('/');
            }
           
            if ($this->request->is(array('post', 'put'))) {
                $rating_user = $this->Rating->find('first',array('conditions' => array('Rating.user_id'=>$userid, 'Rating.product_id'=>$order['OrderDetail']['product_id'], 'Rating.order_details_id'=> $order['OrderDetail']['id'])));
                if(count($rating_user)>0){
                    $this->Session->setFlash(__('You have already submited the feedback for this purchase.'));
                }elseif($userid==$order['OrderDetail']['owner_id']){
                    $this->Session->setFlash(__('You can not give the feedback for this purchase.'));
                }else{
                    $this->request->data['Rating']['product_id'] = $order['OrderDetail']['product_id'];
                    $this->request->data['Rating']['shop_id'] = $order['OrderDetail']['shop_id'];
                    $this->request->data['Rating']['order_details_id'] = $order['OrderDetail']['id'];
                    $this->request->data['Rating']['order_id'] = $order['OrderDetail']['order_id'];
                    $this->request->data['Rating']['rated_to'] = $order['OrderDetail']['owner_id'];
                    $this->request->data['Rating']['user_id'] = $userid;
                    $this->request->data['Rating']['date_time'] = gmdate('Y-m-d H:i:s');
                    $this->Rating->create();             
                    $this->Rating->save($this->request->data);
                    //$avg_rating = $this->request->data['Rating']['rating'];
                    $product_detail = $this->Product->find('first',array('conditions' => array('Product.id'=>$order['OrderDetail']['product_id']),'recursive' => -1));
                    $product_rating=$this->Rating->find("all",array('conditions'=>array('Rating.product_id'=>$order['OrderDetail']['product_id']),'fields'=>array('sum(Rating.rating) as total_rating','count(Rating.id) as total_count')));   
                    //pr($product_rating);
                    //exit;
                    if(!empty($product_rating[0][0]['total_rating']))
                        $total_rating = $product_rating[0][0]['total_rating'];
                    else
                        $total_rating=0;
                   
                    $total_rating_count = $product_rating[0][0]['total_count'];
                    if($total_rating_count != 0){
                        $total_rating= $total_rating/$total_rating_count;
                    }
                    //echo $total_rating_count;
                    $avg_rating = $total_rating;
                    //echo $avg_rating;
                    //exit;
                    $rating_count = $product_detail['Product']['rate_count']+1;
                    $product_data=array();
                    $product_data['Product']['id'] = $order['OrderDetail']['product_id'];
                    $product_data['Product']['total_rate'] = $avg_rating;
                    $product_data['Product']['rate_count'] = $rating_count;
                    
                    $this->Product->save($product_data);
                    $this->Session->setFlash(__('You have successfully submited the feedback for this purchase.'));
                    
                    $this->redirect(array('controller'=>'shops','action' => 'buyer_feedback'));
                }
            }
            $this->set(compact('order','title_for_layout'));
        }
        
         public function add_to_buyer_feedback($oid=null) {
           
            $userid = $this->Session->read('Auth.User.id');
	   
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Buyer Feedback';
	    $ord_details_id = base64_decode($oid);
            $order = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_details_id)));
	    $pro_id = $order['OrderDetail']['product_id'];
	    $shop_id = $order['OrderDetail']['shop_id'];
	    $buyerid = $order['OrderDetail']['user_id'];
            if(!isset($pro_id) && $pro_id==''){
               return $this->redirect($this->request->referer());
            }
	   // exit;
            //$this->Order->recursive = 0;
            //$order = $this->BuyerFeedback->find('first',array('conditions' => array('BuyerFeedback.order_id'=>$ord_details_id, 'BuyerFeedback.to_user'=>$buyerid)));
            if(count($order)==0){
                return $this->redirect($this->request->referer());
            }
           
	    
            if ($this->request->is(array('post', 'put'))) {
		//pr($this->request->data);exit;
                $rating_user = $this->BuyerFeedback->find('first',array('conditions' => array('BuyerFeedback.order_id'=>$ord_details_id, 'BuyerFeedback.to_user'=>$buyerid)));
                if(count($rating_user)>0){
                    $this->Session->setFlash(__('You have already submited the feedback for this product.'));
                }
		else{
                    $this->request->data['BuyerFeedback']['proid'] = $pro_id;
                    $this->request->data['BuyerFeedback']['shopid'] = $shop_id;
                    $this->request->data['BuyerFeedback']['order_id'] = $ord_details_id;
                    $this->request->data['BuyerFeedback']['to_user'] = $buyerid;
                    $this->request->data['BuyerFeedback']['from_user'] = $userid;
                    $this->request->data['BuyerFeedback']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->BuyerFeedback->create();             
                    if($this->BuyerFeedback->save($this->request->data)){
			$this->Session->setFlash(__('You have successfully submited the feedback for this product.', 'default', array('class' => 'success')));
			return $this->redirect(array('controller'=>'orders','action'=>'/'));
		    }
                    //$avg_rating = $this->request->data['Rating']['rating'];
                    /*$product_detail = $this->Product->find('first',array('conditions' => array('Product.id'=>$order['OrderDetail']['product_id']),'recursive' => -1));
                    $product_rating=$this->Rating->find("all",array('conditions'=>array('Rating.product_id'=>$order['OrderDetail']['product_id']),'fields'=>array('sum(Rating.rating) as total_rating','count(Rating.id) as total_count')));   
                    //pr($product_rating);
                    //exit;
                    if(!empty($product_rating[0][0]['total_rating']))
                        $total_rating = $product_rating[0][0]['total_rating'];
                    else
                        $total_rating=0;
                   
                    $total_rating_count = $product_rating[0][0]['total_count'];
                    if($total_rating_count != 0){
                        $total_rating= $total_rating/$total_rating_count;
                    }
                    //echo $total_rating_count;
                    $avg_rating = $total_rating;
                    //echo $avg_rating;
                    //exit;
                    $rating_count = $product_detail['Product']['rate_count']+1;
                    $product_data=array();
                    $product_data['Product']['id'] = $order['OrderDetail']['product_id'];
                    $product_data['Product']['total_rate'] = $avg_rating;
                    $product_data['Product']['rate_count'] = $rating_count;
                    //pr($product_data);
                    //xit;
                    $this->Product->save($product_data);
                    $this->Session->setFlash(__('You have successfully submited the feedback for this purchase.'));*/
                }
            } 
	    
	    
            $this->set(compact('order','title_for_layout'));
        }

        public function get_feed($orderid=null, $userid=null){
	    $this->autoRender = false;
            $rating_user = $this->BuyerFeedback->find('all',array('conditions' => array('BuyerFeedback.order_id'=>$orderid, 'BuyerFeedback.to_user'=>$userid)));
            return $GetProcessing_data = count($rating_user);
	}
    
        public function add_tracking() {
            $this->loadModel('TrackDetail');
            $this->loadModel('OrderDetail');
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if ($this->request->is(array('post', 'put'))) {
                $Order_details_id=$this->request->data['TrackDetail']['order_details_id'];
                $this->TrackDetail->create();
                $this->request->data['TrackDetail']['cdate']= gmdate('Y-m-d H:i:s');
                if ($this->TrackDetail->save($this->request->data)) {
                    $data_ord['OrderDetail']['id']=$Order_details_id;
                    $data_ord['OrderDetail']['seller_accept_shipment']=1;
                    $data_ord['OrderDetail']['order_status']='S';
                    $this->OrderDetail->save($data_ord);
                    
                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$Order_details_id)));
                    //pr($user_data);
                    //exit();
                    $to_user_name=$user_data['Buyer']['first_name'];
                    $to_email=$user_data['Buyer']['email'];
                    $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                    
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                    
                    //Insert Inbox Message 
                    $comment_data['Comment']['user_id'] = $userid;
                    $comment_data['Comment']['to_user_id'] = $user_data['Buyer']['id'];
                    $comment_data['Comment']['comment_type'] = 3;
                    $comment_data['Comment']['is_notification'] = 1;
                    $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                    $comment_data['Comment']['order_details_id'] = $Order_details_id;
                    $comment_data['Comment']['thread_id'] = isset($thread_data['Comment']['thread_id'])?$thread_data['Comment']['thread_id']:0;
                    $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $comment_data['Comment']['subject'] = 'Add Tracking Details. Order ID: '.$NewOrderId;
                    $comment_data['Comment']['comments'] = 'Seller add tracking details. The Order ID is '.$NewOrderId.'.';
                    $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                   
                    $this->Comment->create();			 
                    $this->Comment->save($comment_data);
                    
                    $key = Configure::read('CONTACT_EMAIL');
                    $SITE_URL = Configure::read('SITE_URL');
                    $this->loadModel('EmailTemplate');
                    
                    $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>4)));
                    $tracking_no=$this->request->data['TrackDetail']['tracking_no'];
                    $link=$this->request->data['TrackDetail']['web_address'];
                    
                    $mail_body =str_replace(array('[NAME]','[LINK]','[TRACKINGNO]'),array($to_user_name,$link,$tracking_no),$EmailTemplate['EmailTemplate']['content']);
                    $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                }
                $this->Session->setFlash(__('Successfully add tracking details.'));
            }
            return $this->redirect(array('action' => 'index'));
        }
        
        public function open_dispute() {
            $this->loadModel('Comment');
            $this->loadModel('Dispute');
            $this->loadModel('OrderDetail');
            $this->loadModel('DisputeMessage');
            $this->loadModel('DisputeImage');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $Count_error_file=0;
            if ($this->request->is(array('post', 'put'))) {
                $Order_details_id=$this->request->data['Dispute']['order_details_id'];
                $this->Dispute->create();
                $this->request->data['Dispute']['cdate']= gmdate('Y-m-d H:i:s');
                if ($this->Dispute->save($this->request->data)) {
                    $dispute_id=$this->Dispute->getLastInsertId();
                    $data_ord['OrderDetail']['id']=$Order_details_id;
                    //$data_ord['OrderDetail']['seller_accept_shipment']=1;
                    $data_ord['OrderDetail']['order_status']='DP';
                    $this->OrderDetail->save($data_ord);
                    
                    //insert dispute images
                    
                    $dispute_file_arr=$this->request->data['dispute_file'];
                    /////////////////////////////////////////////////////////
                    if(count($dispute_file_arr)>0 && !empty($dispute_file_arr)){
                        $extensionValid_image = array('jpg','jpeg','png','gif');
                        for($i=0; $i<count($dispute_file_arr); $i++){
                            $dispute_file_name=$this->request->data['dispute_file'][$i]['name'];
                            if(isset($dispute_file_name) && $dispute_file_name!=''){
                                $ext = explode('.',$dispute_file_name);
                                if($ext){
                                    $FileExt=end($ext);
                                    if(in_array(strtolower($FileExt),$extensionValid_image)){
                                        
                                        $uploadPaidFolder = "dispute_images";
                                        $uploadPaidPath = WWW_ROOT . $uploadPaidFolder;
                                        //$PaidFileNewName = preg_replace("/[^a-z0-9_\s-]/", "", $paid_file_name);
                                        $ImgFileNewName = preg_replace("/[\s-]+/", "", $dispute_file_name);  
                                        $ImgFileNewName = preg_replace("/[\s_]/", '_', $ImgFileNewName); 

                                        $imageDisputeName = $dispute_id.'_'.rand(100,99999999).'_'.(strtolower(trim($ImgFileNewName)));
                                        $full_paid_image_path = $uploadPaidPath . '/' . $imageDisputeName;
                                        move_uploaded_file($this->request->data['dispute_file'][$i]['tmp_name'],$full_paid_image_path);					
                                        $ListFile_data['DisputeImage']['dispute_id'] = $dispute_id;
                                        $ListFile_data['DisputeImage']['image_name'] = isset($imageDisputeName)?$imageDisputeName:'';
                                        $ListFile_data['DisputeImage']['cdate'] = gmdate('Y-m-d H:i:s');
                                        $this->DisputeImage->create();
                                        $this->DisputeImage->save($ListFile_data);
                                    }else{
                                        $Count_error_file++;
                                    }
                                }
                            }else{
                                $Count_error_file++;
                            }
                        }
                    }
                    ////////////////////////////////////////////////////////
                    $dispute_data=$this->Dispute->find('first',array('conditions'=>array('Dispute.id'=>$dispute_id)));
                    
                    $dispute_arr_data['DisputeMessage']['user_id']=$userid;
                    $dispute_arr_data['DisputeMessage']['dispute_id']=$dispute_id;
                    $dispute_arr_data['DisputeMessage']['reason']=$dispute_data['Dispute']['dispute_details'];
                    $dispute_arr_data['DisputeMessage']['received_goods']=$dispute_data['Dispute']['receive_order'];
                    $dispute_arr_data['DisputeMessage']['refund_request']=$dispute_data['Dispute']['refund_request'];
                    $dispute_arr_data['DisputeMessage']['return_goods']='No';
                    $dispute_arr_data['DisputeMessage']['refund_amount']=$dispute_data['Dispute']['payment_received'];
                    $dispute_arr_data['DisputeMessage']['action']='Open Dispute';
                    $dispute_arr_data['DisputeMessage']['user_type']=1;
                    $dispute_arr_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                    $this->DisputeMessage->create();
                    $this->DisputeMessage->save($dispute_arr_data);
                    
                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$Order_details_id)));
                    $buyer_user_name=$user_data['Buyer']['first_name'].' '.$user_data['Buyer']['last_name'];
                    $buyer_email=$user_data['Buyer']['email'];
                    $to_user_name=$user_data['User']['first_name'];
                    $to_email=$user_data['User']['email'];
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                    
                    $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                    //Insert Inbox Message 
                    $comment_data['Comment']['user_id'] = $userid;
                    $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['owner_id'];
                    $comment_data['Comment']['comment_type'] = 6;
                    $comment_data['Comment']['is_notification'] = 1;
                    $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                    $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                    $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $comment_data['Comment']['subject'] = 'Buyer open dispute for '.$dispute_data['Dispute']['select_reason'].'. Order ID: '.$NewOrderId;
                    $comment_data['Comment']['comments'] = $dispute_data['Dispute']['dispute_details'].' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'];
                    $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                   
                    $this->Comment->create();			 
                    $this->Comment->save($comment_data);
                    
                    $key = Configure::read('CONTACT_EMAIL');
                    $SITE_URL = Configure::read('SITE_URL');
                    $this->loadModel('EmailTemplate');
                    
                    $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>5)));
                    $product_name=$user_data['Product']['name'];
                    $link=$SITE_URL.'orders/seller_disputes';
                    
                    $mail_body =str_replace(array('[NAME]','[LINK]','[PRODUCTNAME]','[USERNAME]','[BUYEREMAIL]'),array($to_user_name,$link,$product_name,$buyer_user_name,$buyer_email),$EmailTemplate['EmailTemplate']['content']);
                    $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                }
                if($Count_error_file>0){
                    $this->Session->setFlash(__('You have successfully dispute the product. But '.$Count_error_file.' files could not be saved for wrong extension file.'));
                }else{
                    $this->Session->setFlash(__('You have successfully dispute the product.'));
                }
                return $this->redirect(array('action' => 'buyer_disputes'));
            }else{
                return $this->redirect(array('action' => 'awaiting_delivery'));
            }
            
        }
        
        public function download_file($dispute_id = null) {
            $this->autoRender=false;
            $this->loadModel('DisputeImage');
            $uploadPath = WWW_ROOT . 'dispute_images';
            //$Order_details_id=$this->request->data['Dispute']['order_details_id'];
            //$uploadPath = 'http://104.131.83.218/team2/hmong/list_paid_files';
            $disputeID=  base64_decode($dispute_id);
            $file_details = $this->DisputeImage->find('first', array('conditions' =>array('DisputeImage.dispute_id' => $disputeID)));
            if(count($file_details)>0){
                /*$file_pid=$file_details['Listing']['pid'];
                $list_file_id=$file_details['Listing']['list_file_id'];
                if($file_pid==0){*/
                    // album download
                    $files = array();
                    $paid_file_details = $this->DisputeImage->find('all', array('conditions' =>array('DisputeImage.dispute_id' => $disputeID)));
                    foreach($paid_file_details as $val){
                        $paid_file_name=$val['DisputeImage']['image_name'];
                        if($paid_file_name!='' && file_exists($uploadPath . '/' . $paid_file_name)){ 
                            $file_name_path=$uploadPath . '/' . $paid_file_name;
                            //array_push($files,$file_name_path);
                            array_push($files,$paid_file_name);
                        }
                    }
                    // Force the download
                    if(!empty($files) && count($files)>0){
                        $archive = time().'_download.zip';
                        $zip = new ZipArchive;
                        $zip->open($archive, ZipArchive::CREATE);

                        foreach ($files as $file) {
                            $zip->addFile($uploadPath.'/'.$file, $file);
                        }
                        $zip->close();
                        header('Content-Type: application/zip');
                        header('Content-disposition: attachment; filename='.$archive);
                        header('Content-Length: '.filesize($archive));
                        readfile($archive);
                        unlink($archive);
                    }
                    exit();
                /*}elseif($file_pid!=0 && $list_file_id!=0){
                    // single file download
                    $paid_file_details = $this->ListFile->find('first', array('conditions' =>array('ListFile.id' => $list_file_id)));
                    $paid_file_name=$paid_file_details['ListFile']['paid_file_name'];
                    if($paid_file_name!='' && file_exists($uploadPath . '/' . $paid_file_name)){ 
                        $file_name_path=$uploadPath . '/' . $paid_file_name;
                        // Force the download
                        //header('Content-Disposition: attachment; filename="'. basename($file_name_path).'"');
                        header("Content-Disposition: attachment; filename=". basename($file_name_path));
                        header("Content-Length: " . filesize($file_name_path));
                        header("Content-Type: application/octet-stream;");
                        readfile($file_name_path);
                        exit();
                    }
                }*/
            }
        }
        
        public function all_order() {
            $this->loadModel('TempCart');
            $this->loadModel('OrderDetail');
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'All Orders';
            //$this->Order->recursive = 0;
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(Order.user_id='".$userid."')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Shop.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.user_id' => $userid), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
                
            $options = array('conditions' => array('User.id' => $userid));
            $user = $this->User->find('first', $options);
            
            /*if($user){
                if(isset($user['User']['country']) && $user['User']['country']!=0){
                    $countryname = $this->Country->find('first',array('conditions' => array('Country.id'=>$user['User']['country']),'fields' => array('Country.printable_name')));
                    $countryname = $countryname['Country']['printable_name'];
                }
            }*/
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function buyer_received_order($details_id=null) {
            $this->loadModel('OrderDetail');
            $this->loadModel('Comment');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            
            if($details_id!=''){
                $booking_id = base64_decode($details_id);
                $data_ord['OrderDetail']['id']=$booking_id;
                $data_ord['OrderDetail']['order_status']='F';
                $data_ord['OrderDetail']['order_received_date']=gmdate('Y-m-d H:i:s');
                $this->OrderDetail->save($data_ord);
                
                $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$booking_id)));
                $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                
                //Insert Inbox Message 
                $comment_data['Comment']['user_id'] = $userid;
                $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['owner_id'];
                $comment_data['Comment']['comment_type'] = 7;
                $comment_data['Comment']['is_notification'] = 1;
                $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                $comment_data['Comment']['order_details_id'] = $booking_id;
                $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                $comment_data['Comment']['subject'] = 'Buyer received the order. Order ID: '.$NewOrderId;
                $comment_data['Comment']['comments'] = 'Buyer received the order properly. <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'];
                $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                $this->Comment->create();			 
                $this->Comment->save($comment_data);
                
                $this->Session->setFlash(__('You have successfully received the order.'));
                return $this->redirect(array('controller' => 'orders', 'action' => 'awaiting_delivery'));
            }else{
                return $this->redirect(array('controller' => 'orders', 'action' => 'awaiting_delivery'));
            }
        }
        
        public function awaiting_payment() {
            $this->loadModel('TempCart');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Awaiting Payments';
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(TempCart.user_id='".$userid."')";
                if($order_no!=''){
                    //$new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (TempCart.id = '".$order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (TempCart.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('TempCart.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('TempCart.user_id' => $userid), 'order' => array('TempCart.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $Awa_payment_list=$this->Paginator->paginate('TempCart');
             
            $this->set(compact('Awa_payment_list','title_for_layout','user','order_no','product_name'));
	}
        
        public function awaiting_shipment() {
            $this->loadModel('Comment');
            $this->loadModel('OrderDetail');
            $this->loadModel('CancelOrder');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Awaiting Shipment';
            $this->Order->recursive = 0;
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='CancelOrder'){
                    $order_details_id=$this->request->data['order_details_id'];
                    $select_reason=$this->request->data['select_reason'];
                    $details=$this->request->data['details'];
                    
                    if($order_details_id!=''){
                        $dispute_data['CancelOrder']['user_id']=$userid;
                        $dispute_data['CancelOrder']['order_details_id']=$order_details_id;
                        $dispute_data['CancelOrder']['select_reason']=$select_reason;
                        $dispute_data['CancelOrder']['description']=$details;
                        $dispute_data['CancelOrder']['cdate']=gmdate('Y-m-d H:i:s');
                        $this->CancelOrder->create();
                        $this->CancelOrder->save($dispute_data);
                        $cancelOrderId = $this->CancelOrder->getLastInsertId();
                        
                        $data_ord['OrderDetail']['id']=$order_details_id;
                        $data_ord['OrderDetail']['user_type']=2;
                        $data_ord['OrderDetail']['cancel_user_id']=$userid;
                        $data_ord['OrderDetail']['order_status']='C';
                        $data_ord['OrderDetail']['cancel_id']=$cancelOrderId;
                        $this->OrderDetail->save($data_ord);
                        
                        $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                        //$seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                        //$seller_email=$user_data['User']['email'];
                        $to_user_name=$user_data['User']['first_name'];
                        $to_email=$user_data['User']['email'];
                        
                        $user_name=$user_data['Buyer']['first_name'].' '.$user_data['Buyer']['last_name'];
                        $user_email=$user_data['Buyer']['email'];
                        $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));

                        $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                        //Insert Inbox Message 
                        $comment_data['Comment']['user_id'] = $userid;
                        $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['owner_id'];
                        $comment_data['Comment']['comment_type'] = 5;
                        $comment_data['Comment']['is_notification'] = 1;
                        $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                        $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                        $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                        $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                        $comment_data['Comment']['subject'] = 'Product cancelled by buyer for '.$select_reason.'. Order ID: '.$NewOrderId;
                        $comment_data['Comment']['comments'] = $details.' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'];
                        $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                        $this->Comment->create();			 
                        $this->Comment->save($comment_data);
                        
                        $key = Configure::read('CONTACT_EMAIL');
                        $SITE_URL = Configure::read('SITE_URL');
                        $this->loadModel('EmailTemplate');

                        $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>17)));
                        $cancelproduct_name=$user_data['Product']['name'];
                        $link=$SITE_URL.'orders/seller_awaiting_shipment';

                        $mail_body =str_replace(array('[NAME]','[LINK]','[BUYERNAME]','[EMAIL]','[PRODUCTNAME]','[ORDERID]'),array($to_user_name,$link,$user_name,$user_email,$cancelproduct_name,$NewOrderId),$EmailTemplate['EmailTemplate']['content']);
                        $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                        $this->Session->setFlash(__('You have successfully cancel the product.'));
                    }
                    return $this->redirect(array('controller' => 'orders', 'action' => 'awaiting_shipment'));
                }elseif($form_type=='SearchForm') {
                    $Ord_sl_no= Configure::read('ORDER_SL_NO');
                    $order_no=$this->request->data['order_no'];
                    $product_name=$this->request->data['product_name'];
                    //$QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status ='U' or OrderDetail.order_status ='C')";
                    $QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status ='U')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                    }
                    if($product_name!=''){
                        $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                    }

                    $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
                }
                
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                //$options = array('conditions' => array('OrderDetail.user_id' => $userid,'OR' => array(array('OrderDetail.order_status' => 'U'), array('OrderDetail.order_status' => 'C'))), 'order' => array('OrderDetail.id' => 'desc'));
                $options = array('conditions' => array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'U'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
              
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function awaiting_delivery() {
            $this->loadModel('OrderDetail');
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Awaiting Delivery';
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status ='S')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'S'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
              
            /*if($user){
                if(isset($user['User']['country']) && $user['User']['country']!=0){
                    $countryname = $this->Country->find('first',array('conditions' => array('Country.id'=>$user['User']['country']),'fields' => array('Country.printable_name')));
                    $countryname = $countryname['Country']['printable_name'];
                }
            }*/
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function buyer_disputes() {
            $this->loadModel('OrderDetail');
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Disputes';
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status ='DP')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'DP'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
             
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function seller_awaiting_shipment() {
            $this->loadModel('OrderDetail');
            $this->loadModel('ExtendProcessingTime');
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $SITE_URL = Configure::read('SITE_URL');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Awaiting Shipment';
            $this->Order->recursive = 0;
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='Extend Processing Time'){
                    
                    $OrderDetailsID=$this->request->data['OrderDetailsID'];
                    $TimeBy=$this->request->data['TimeBy'];
                    $ord_det_id=  base64_decode($OrderDetailsID);
                    $orderdetails = $this->OrderDetail->find('first',array('conditions' => array('OrderDetail.id'=>$ord_det_id)));
                    $buyer_order_id=$orderdetails['OrderDetail']['order_id'];
                    $Received_user_id=$orderdetails['OrderDetail']['user_id'];
                    $Product_name=$orderdetails['Product']['name'];
                    $Buyer_name=$orderdetails['Buyer']['first_name'];
                    $Buyer_email=$orderdetails['Buyer']['email'];
                    $seller_name=$orderdetails['User']['first_name'].' '.$orderdetails['User']['last_name'];
                    $seller_email=$orderdetails['User']['email'];
                    
                    $Processing_data['ExtendProcessingTime']['order_details_id'] = $ord_det_id;
                    $Processing_data['ExtendProcessingTime']['order_id'] = $buyer_order_id;
                    $Processing_data['ExtendProcessingTime']['seller_id'] = $userid;
                    $Processing_data['ExtendProcessingTime']['no_of_day'] = $TimeBy;
                    $Processing_data['ExtendProcessingTime']['request_date'] = gmdate('Y-m-d H:i:s');
                    
                    $this->ExtendProcessingTime->create();			 
                    $this->ExtendProcessingTime->save($Processing_data);
                    
                    $ord_det_data['OrderDetail']['id'] = $ord_det_id;
                    $ord_det_data['OrderDetail']['extend_processing_time'] = 1;
                    $this->OrderDetail->save($ord_det_data);
                    
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$buyer_order_id, 'Comment.comment_type'=>0)));          
                    $NewOrderId=($Ord_sl_no+$buyer_order_id);
                    $link=$SITE_URL.'orders/order_details/'.  base64_encode($buyer_order_id);
                    $comment_data['Comment']['user_id'] = $userid;
                    $comment_data['Comment']['to_user_id'] = $Received_user_id;
                    $comment_data['Comment']['is_notification'] = 1;
                    $comment_data['Comment']['order_id'] = $buyer_order_id;
                    $comment_data['Comment']['order_details_id'] = $ord_det_id;
                    $comment_data['Comment']['thread_id'] = isset($thread_data['Comment']['thread_id'])?$thread_data['Comment']['thread_id']:0;
                    $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $comment_data['Comment']['subject'] = 'Seller Extend Processing Time for Order ID '.$NewOrderId;
                    $comment_data['Comment']['comments'] = 'Seller extend the processing time '.$TimeBy.' days of your order for delivery confirmation at the right time.<br > Product Name: '.$Product_name.'<br > Order Details Link: <a href="'.$link.'"> Click here</a><br > Extend Processing time: '.$TimeBy.' days';
                    $comment_data['Comment']['comment_type'] = 8;
                    $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($comment_data);
                    
                    $key = Configure::read('CONTACT_EMAIL');
                    $this->loadModel('EmailTemplate');
                    
                    $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>11)));
                    //$link=$this->request->data['TrackDetail']['web_address'];
                    $mail_body =str_replace(array('[NAME]','[PRODUCTNAME]','[SELLERNAME]','[EMAIL]','[DAYS]','[LINK]'),array($Buyer_name,$Product_name,$seller_name,$seller_email,$TimeBy,$link),$EmailTemplate['EmailTemplate']['content']);
                    $this->send_mail($key,$Buyer_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                    
                    $options = array('conditions' => array('OR' => array(array('OrderDetail.order_status' => 'U'), array('OrderDetail.order_status' => 'S')),'OrderDetail.owner_id' => $userid), 'order' => array('OrderDetail.id' => 'desc'));
                    $this->Session->setFlash(__('You have successfully submited the request.'));
                }elseif($form_type=='Search Form'){
                    $order_no=$this->request->data['order_no'];
                    $product_name=$this->request->data['product_name'];
                    $QueryStr="(OrderDetail.owner_id='".$userid."') AND (OrderDetail.order_status ='U' OR OrderDetail.order_status ='S')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                    }
                    if($product_name!=''){
                        $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                    }

                    $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
                }
                
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OR' => array(array('OrderDetail.order_status' => 'U'), array('OrderDetail.order_status' => 'S')),'OrderDetail.owner_id' => $userid), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
               
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function accept_cancel_order() {
            $this->loadModel('OrderDetail');
            $this->loadModel('CancelOrder');
            $this->loadModel('Comment');
            $this->loadModel('Product');
            $this->loadModel('ManageInventory');
            $this->loadModel('SiteSetting');
            $this->loadModel('Payment');
            
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if ($this->request->is(array('post'))) {
                $order_details_id=$this->request->data['order_details_id'];
                $select_reason=$this->request->data['select_reason'];
                $details=$this->request->data['details'];
                $form_type=$this->request->data['form_type'];
                if($order_details_id!='' && $form_type=='AcceptOrder'){
                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                    $OrderPay_key=$user_data['Order']['pay_key'];
                    $seller_business_email=$user_data['User']['paypal_business_email'];
                    $new_dispute_amt=$user_data['OrderDetail']['amount'];
                    $paykey=isset($OrderPay_key)?$OrderPay_key:'';
                    if($paykey!=''){
                        $options_site_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                        $sitesetting = $this->SiteSetting->find('first', $options_site_set);

                        $admin_paypal_email=$sitesetting['SiteSetting']['paypal_email'];
                        $admin_percentage=$sitesetting['SiteSetting']['admin_percentage'];
                        $PayPalFeesPercentage=Configure::read('PayPalFeesPercentage');
                        $PayPalFeesStatic=Configure::read('PayPalFeesStatic');
                        $PayPalFeesPer=(($new_dispute_amt*$PayPalFeesPercentage)/100);
                        $PayPalTotFees=($PayPalFeesPer+$PayPalFeesStatic);

                        $admin_amount=(($new_dispute_amt*$admin_percentage)/100);
                        //$cal_new_dispute_amt=($new_dispute_amt-$PayPalTotFees);
                        //$seller_tot_amount=($new_dispute_amt-$admin_amount-$PayPalTotFees);
                        $cal_new_dispute_amt=$new_dispute_amt;
                        $seller_tot_amount=($new_dispute_amt-$admin_amount);
            
                        require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
                        $refundRequest = new RefundRequest(new RequestEnvelope("en_US"));
                        $refundRequest->currencyCode = 'USD';
                        $refundRequest->payKey = $paykey;
                        
                        $receiver = array();
                        $receiver[0] = new Receiver();
                        $receiver[0]->email = $admin_paypal_email;
                        //$receiver[0]->email = 'payments@errandchampion.com';
                        //$receiver[0]->email = 'nits.arpita@gmail.com';
                        //$receiver[0]->amount = floor($cal_new_dispute_amt);
                        $receiver[0]->amount = round($cal_new_dispute_amt, 2);
                        //$receiver[0]->amount = 0;
                        $receiver[0]->primary = "true";
                        $receiver[0]->paymentType = "SERVICE";
                        
                        /*$receiver[0] = new Receiver();
                        $receiver[0]->email = $seller_business_email;
                        $receiver[0]->amount = floor($new_dispute_amt);
                        $receiver[0]->primary = "false";
                        $receiver[0]->paymentType = "SERVICE";*/
                        
                        $receiver[1] = new Receiver();
                        $receiver[1]->email = $seller_business_email;
                        $receiver[1]->amount = round($seller_tot_amount, 2);
                        $receiver[1]->primary = "false";
                        $receiver[1]->paymentType = "SERVICE";

                        /*$receiver[1] = new Receiver();
                        $receiver[1]->email = $seller_business_email;
                        $receiver[1]->amount = floor($seller_tot_amount);
                        $receiver[1]->primary = "false";
                        $receiver[1]->paymentType = "SERVICE";*/
                        $receiverList = new ReceiverList($receiver);
                        $refundRequest->receiverList = $receiverList;
                        
                        $PayPalService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
                        $PayPalResult = $PayPalService->Refund($refundRequest);
                        $PayPalAck = $PayPalResult->responseEnvelope->ack;
                        $EncryptedTransactionID=$PayPalResult->responseEnvelope->correlationId;
                        //pr($PayPalResult);
                        //exit();
                        if($PayPalAck=='Success'){
                            $dispute_data['CancelOrder']['user_id']=$userid;
                            $dispute_data['CancelOrder']['order_details_id']=$order_details_id;
                            $dispute_data['CancelOrder']['select_reason']=$select_reason;
                            $dispute_data['CancelOrder']['description']=$details;
                            $dispute_data['CancelOrder']['seller_responce']=1;
                            $dispute_data['CancelOrder']['cancel_transcation_id']=$EncryptedTransactionID;
                            $dispute_data['CancelOrder']['cdate']=gmdate('Y-m-d H:i:s');
                            $this->CancelOrder->create();
                            $this->CancelOrder->save($dispute_data);
                            $cancelOrderId = $this->CancelOrder->getLastInsertId();

                            $data_ord['OrderDetail']['id']=$order_details_id;
                            $data_ord['OrderDetail']['user_type']=2;
                            $data_ord['OrderDetail']['cancel_user_id']=$userid;
                            $data_ord['OrderDetail']['order_status']='C';
                            $data_ord['OrderDetail']['cancel_id']=$cancelOrderId;
                            $this->OrderDetail->save($data_ord);

                            $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                            $seller_email=$user_data['User']['email'];
                            $to_user_name=$user_data['Buyer']['first_name'];
                            $to_email=$user_data['Buyer']['email'];

                            //manage inventory form stock
                            $data_prd['Product']['id'] = $user_data['OrderDetail']['product_id'];
                            $data_prd['Product']['quantity'] = ($user_data['Product']['quantity']+$user_data['OrderDetail']['quantity']);
                            $this->Product->save($data_prd);

                            //Insert inventory stock into table
                            $inventory_data['ManageInventory']['product_id'] = $user_data['OrderDetail']['product_id'];
                            $inventory_data['ManageInventory']['order_id'] = $user_data['OrderDetail']['order_id'];
                            $inventory_data['ManageInventory']['order_details_id'] = $order_details_id;
                            $inventory_data['ManageInventory']['quantity'] = $user_data['OrderDetail']['quantity'];
                            $inventory_data['ManageInventory']['price'] = $user_data['OrderDetail']['price'];
                            $inventory_data['ManageInventory']['type'] = '+';
                            $inventory_data['ManageInventory']['comment'] = 'Seller accept cancelled order by buyer';
                            $inventory_data['ManageInventory']['user_id'] = $userid;
                            $inventory_data['ManageInventory']['create_date'] = gmdate('Y-m-d H:i:s');
                            $this->ManageInventory->create();
                            $this->ManageInventory->save($inventory_data);

                            $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                            $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                            //Insert Inbox Message 
                            $comment_data['Comment']['user_id'] = $userid;
                            $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['user_id'];
                            $comment_data['Comment']['comment_type'] = 5;
                            $comment_data['Comment']['is_notification'] = 1;
                            $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                            $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                            $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                            $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                            $comment_data['Comment']['subject'] = 'Seller accept cancelled order request by buyer. Order ID: '.$NewOrderId;
                            $comment_data['Comment']['comments'] = 'Seller accept cancelled order request by buyer. <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'].'<br /> Refund Amount : $'.$cal_new_dispute_amt;
                            $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                            $this->Comment->create();			 
                            $this->Comment->save($comment_data);

                            $payment_arr['Payment']['userid']= $userid;
                            $payment_arr['Payment']['amount']= $cal_new_dispute_amt;
                            $payment_arr['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                            $payment_arr['Payment']['transaction_id']= $EncryptedTransactionID;
                            $payment_arr['Payment']['for']= "debit for accept cancelled order request by buyer";
                            $payment_arr['Payment']['status']= "Completed";
                            $payment_arr['Payment']['type'] = 1;
                            $this->Payment->create();
                            $this->Payment->save($payment_arr);
                    
                            $payment_arr1['Payment']['userid']= $user_data['OrderDetail']['user_id'];
                            $payment_arr1['Payment']['amount']= $cal_new_dispute_amt;
                            $payment_arr1['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                            $payment_arr1['Payment']['transaction_id']= $EncryptedTransactionID;
                            $payment_arr1['Payment']['for']= "credit for cancelled order";
                            $payment_arr1['Payment']['status']= "Completed";
                            $payment_arr1['Payment']['type'] = 2;
                            $this->Payment->create();
                            $this->Payment->save($payment_arr1);
                            
                            //$user_name=$user_data['Buyer']['first_name'].' '.$user_data['Buyer']['last_name'];
                            //$user_email=$user_data['Buyer']['email'];

                            $key = Configure::read('CONTACT_EMAIL');
                            $SITE_URL = Configure::read('SITE_URL');
                            $this->loadModel('EmailTemplate');

                            $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>16)));
                            $cancelproduct_name=$user_data['Product']['name'];
                            $link=$SITE_URL.'orders/awaiting_shipment';

                            $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]','[PRODUCTNAME]','[AMOUNT]'),array($to_user_name,$link,$seller_user_name,$seller_email,$cancelproduct_name,$cal_new_dispute_amt),$EmailTemplate['EmailTemplate']['content']);
                            $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                            $this->Session->setFlash(__('You have successfully accept the cancel order.'));
                        }else{
                            $this->Session->setFlash(__('The payment could not be refund due to internal error.'));
                        }
                    }else{
                        $this->Session->setFlash(__('The payment could not be refund due to internal error.'));
                    }
                }elseif($order_details_id!='' && $form_type=='RejectOrder'){
                    $dispute_data['CancelOrder']['user_id']=$userid;
                    $dispute_data['CancelOrder']['order_details_id']=$order_details_id;
                    $dispute_data['CancelOrder']['select_reason']=$select_reason;
                    $dispute_data['CancelOrder']['description']=$details;
                    $dispute_data['CancelOrder']['seller_responce']=2;
                    $dispute_data['CancelOrder']['cdate']=gmdate('Y-m-d H:i:s');
                    $this->CancelOrder->create();
                    $this->CancelOrder->save($dispute_data);
                    $cancelOrderId = $this->CancelOrder->getLastInsertId();

                    $data_ord['OrderDetail']['id']=$order_details_id;
                    $data_ord['OrderDetail']['user_type']=2;
                    $data_ord['OrderDetail']['cancel_user_id']=$userid;
                    //$data_ord['OrderDetail']['order_status']='S';
                    $data_ord['OrderDetail']['order_status']='U';
                    //$data_ord['OrderDetail']['order_status']='C';
                    $data_ord['OrderDetail']['cancel_id']=$cancelOrderId;
                    $this->OrderDetail->save($data_ord);

                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                    $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                    $seller_email=$user_data['User']['email'];
                    $to_user_name=$user_data['Buyer']['first_name'];
                    $to_email=$user_data['Buyer']['email'];
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                    
                    $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                    //Insert Inbox Message 
                    $comment_data['Comment']['user_id'] = $userid;
                    $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['user_id'];
                    $comment_data['Comment']['comment_type'] = 5;
                    $comment_data['Comment']['is_notification'] = 1;
                    $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                    $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                    $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $comment_data['Comment']['subject'] = 'Seller reject cancelled order request by buyer. Order ID: '.$NewOrderId;
                    $comment_data['Comment']['comments'] = 'Seller reject cancelled order request by buyer. <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'];
                    $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($comment_data);

                    //$user_name=$user_data['Buyer']['first_name'].' '.$user_data['Buyer']['last_name'];
                    //$user_email=$user_data['Buyer']['email'];

                    $key = Configure::read('CONTACT_EMAIL');
                    $SITE_URL = Configure::read('SITE_URL');
                    $this->loadModel('EmailTemplate');

                    $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>18)));
                    $cancelproduct_name=$user_data['Product']['name'];
                    $link=$SITE_URL.'orders/awaiting_delivery';

                    $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]','[PRODUCTNAME]','[ORDERID]'),array($to_user_name,$link,$seller_user_name,$seller_email,$cancelproduct_name,$NewOrderId),$EmailTemplate['EmailTemplate']['content']);
                    $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                    $this->Session->setFlash(__('You have successfully reject the cancel order.'));
                }
                return $this->redirect(array('controller' => 'orders', 'action' => 'seller_awaiting_shipment'));
            }else{
                return $this->redirect(array('controller' => 'orders', 'action' => 'seller_awaiting_shipment'));
            }
        }
        
        public function seller_cancel_order() {
            $this->loadModel('OrderDetail');
            $this->loadModel('CancelOrder');
            $this->loadModel('ManageInventory');
            $this->loadModel('Product');
            $this->loadModel('Comment');
            $this->loadModel('SiteSetting');
            $this->loadModel('Payment');
            
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if ($this->request->is(array('post'))) {
                $order_details_id=$this->request->data['order_details_id'];
                $select_reason=$this->request->data['select_reason'];
                $details=$this->request->data['details'];
                if($order_details_id!=''){
                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                    $OrderPay_key=$user_data['Order']['pay_key'];
                    $seller_business_email=$user_data['User']['paypal_business_email'];
                    $new_dispute_amt=$user_data['OrderDetail']['amount'];
                    $paykey=isset($OrderPay_key)?$OrderPay_key:'';
                    //print_r($user_data);
                    if($paykey!=''){
                        $options_site_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                        $sitesetting = $this->SiteSetting->find('first', $options_site_set);
                        $admin_paypal_email=$sitesetting['SiteSetting']['paypal_email'];
                        $admin_percentage=$sitesetting['SiteSetting']['admin_percentage'];
                        $PayPalFeesPercentage=Configure::read('PayPalFeesPercentage');
                        $PayPalFeesStatic=Configure::read('PayPalFeesStatic');
                        $PayPalFeesPer=(($new_dispute_amt*$PayPalFeesPercentage)/100);
                        $PayPalTotFees=($PayPalFeesPer+$PayPalFeesStatic);
                        
                        $admin_amount=(($new_dispute_amt*$admin_percentage)/100);
                        $cal_new_dispute_amt=$new_dispute_amt;
                        $seller_tot_amount=($new_dispute_amt-$admin_amount);
                        
                        require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
                        $refundRequest = new RefundRequest(new RequestEnvelope("en_US"));
                        $refundRequest->currencyCode = 'USD';
                        $refundRequest->payKey = $paykey;
                        
                        $receiver = array();
                        $receiver[0] = new Receiver();
                        $receiver[0]->email = $admin_paypal_email;
                        //$receiver[0]->email = 'payments@errandchampion.com';
                        //$receiver[0]->email = 'nits.arpita@gmail.com';
                        $receiver[0]->amount = round($cal_new_dispute_amt, 2);
                        $receiver[0]->primary = "true";
                        $receiver[0]->paymentType = "SERVICE";

                        $receiver[1] = new Receiver();
                        $receiver[1]->email = $seller_business_email;
                        $receiver[1]->amount = round($seller_tot_amount, 2);
                        $receiver[1]->primary = "false";
                        $receiver[1]->paymentType = "SERVICE";
            
                        $receiverList = new ReceiverList($receiver);
                        $refundRequest->receiverList = $receiverList;
                        
                        $PayPalService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
                        $PayPalResult = $PayPalService->Refund($refundRequest);
                        $PayPalAck = $PayPalResult->responseEnvelope->ack;
                        $EncryptedTransactionID=$PayPalResult->responseEnvelope->correlationId;
                        if($PayPalAck=='Success'){
                            $dispute_data['CancelOrder']['user_id']=$userid;
                            $dispute_data['CancelOrder']['order_details_id']=$order_details_id;
                            $dispute_data['CancelOrder']['select_reason']=$select_reason;
                            $dispute_data['CancelOrder']['description']=$details;
                            $dispute_data['CancelOrder']['seller_responce']=3;
                            $dispute_data['CancelOrder']['cancel_transcation_id']=$EncryptedTransactionID;
                            $dispute_data['CancelOrder']['cdate']=gmdate('Y-m-d H:i:s');
                            $this->CancelOrder->create();
                            $this->CancelOrder->save($dispute_data);
                            $cancelOrderId = $this->CancelOrder->getLastInsertId();

                            $data_ord['OrderDetail']['id']=$order_details_id;
                            $data_ord['OrderDetail']['user_type']=2;
                            $data_ord['OrderDetail']['cancel_user_id']=$userid;
                            $data_ord['OrderDetail']['order_status']='C';
                            $data_ord['OrderDetail']['cancel_id']=$cancelOrderId;
                            $this->OrderDetail->save($data_ord);

                            //delete inventory form stock
                            $data_prd['Product']['id'] = $user_data['OrderDetail']['product_id'];
                            $data_prd['Product']['quantity'] = ($user_data['Product']['quantity']+$user_data['OrderDetail']['quantity']);
                            $this->Product->save($data_prd);

                            //Insert inventory stock into table
                            $inventory_data['ManageInventory']['product_id'] = $user_data['OrderDetail']['product_id'];
                            $inventory_data['ManageInventory']['order_id'] = $user_data['OrderDetail']['order_id'];
                            $inventory_data['ManageInventory']['order_details_id'] = $order_details_id;
                            $inventory_data['ManageInventory']['quantity'] = $user_data['OrderDetail']['quantity'];
                            $inventory_data['ManageInventory']['price'] = $user_data['OrderDetail']['price'];
                            $inventory_data['ManageInventory']['type'] = '-';
                            $inventory_data['ManageInventory']['comment'] = 'Product cancelled by seller';
                            $inventory_data['ManageInventory']['user_id'] = $userid;
                            $inventory_data['ManageInventory']['create_date'] = gmdate('Y-m-d H:i:s');
                            $this->ManageInventory->create();
                            $this->ManageInventory->save($inventory_data);

                            $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                            $seller_email=$user_data['User']['email'];
                            $to_user_name=$user_data['Buyer']['first_name'];
                            $to_email=$user_data['Buyer']['email'];
                            $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));

                            $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                            //Insert Inbox Message 
                            $comment_data['Comment']['user_id'] = $userid;
                            $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['user_id'];
                            $comment_data['Comment']['comment_type'] = 4;
                            $comment_data['Comment']['is_notification'] = 1;
                            $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                            $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                            $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                            $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                            $comment_data['Comment']['subject'] = 'Product cancelled by seller for '.$select_reason.'. Order ID: '.$NewOrderId;
                            $comment_data['Comment']['comments'] = $details.' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'].'<br /> Refund Amount : $'.$cal_new_dispute_amt;
                            $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                            $this->Comment->create();			 
                            $this->Comment->save($comment_data);

                            $payment_arr['Payment']['userid']= $userid;
                            $payment_arr['Payment']['amount']= $cal_new_dispute_amt;
                            $payment_arr['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                            $payment_arr['Payment']['transaction_id']= $EncryptedTransactionID;
                            $payment_arr['Payment']['for']= "debited for cancelled order";
                            $payment_arr['Payment']['status']= "Completed";
                            $payment_arr['Payment']['type'] = 1;
                            $this->Payment->create();
                            $this->Payment->save($payment_arr);
                            
                            $payment_arr1['Payment']['userid']= $user_data['OrderDetail']['user_id'];
                            $payment_arr1['Payment']['amount']= $cal_new_dispute_amt;
                            $payment_arr1['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                            $payment_arr1['Payment']['transaction_id']= $EncryptedTransactionID;
                            $payment_arr1['Payment']['for']= "credited amount for ".$select_reason." cancelled by seller";
                            $payment_arr1['Payment']['status']= "Completed";
                            $payment_arr1['Payment']['type'] = 2;
                            $this->Payment->create();
                            $this->Payment->save($payment_arr1);
                            
                            $key = Configure::read('CONTACT_EMAIL');
                            $SITE_URL = Configure::read('SITE_URL');
                            $this->loadModel('EmailTemplate');

                            $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>15)));
                            $cancelproduct_name=$user_data['Product']['name'];
                            $link=$SITE_URL.'orders/awaiting_shipment';

                            $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]','[PRODUCTNAME]','[AMOUNT]'),array($to_user_name,$link,$seller_user_name,$seller_email,$cancelproduct_name,$cal_new_dispute_amt),$EmailTemplate['EmailTemplate']['content']);
                            $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                            $this->Session->setFlash(__('You have successfully cancel the order.'));
                            //echo 'S';
                        }else{
                            $this->Session->setFlash(__('The payment could not be refund due to internal error.'));//echo 'E';
                        }
                    }else{
                        $this->Session->setFlash(__('The payment could not be refund due to internal error.'));
                    }
                    //$this->Session->setFlash(__('You have successfully cancel the order.'));
                    //exit();
                }  
                //pr($PayPalResult);
                //exit();
                return $this->redirect(array('controller' => 'orders', 'action' => 'seller_awaiting_shipment'));
            }else{
                return $this->redirect(array('controller' => 'orders', 'action' => 'seller_awaiting_shipment'));
            }
        }
        
        public function cancel_dispute_order($cancel_id=null) {
            $this->loadModel('OrderDetail');
            //$this->loadModel('CancelOrder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            
            if($cancel_id!=''){
                $booking_id = base64_decode($cancel_id);
                $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$booking_id)));
                $order_received_date=$user_data['OrderDetail']['order_received_date'];
                      
                $data_ord['OrderDetail']['id']=$booking_id;
                if($order_received_date=='0000-00-00 00:00:00'){
                    $data_ord['OrderDetail']['order_status']='S';
                }else{
                    $data_ord['OrderDetail']['order_status']='F';
                }
                //$data_ord['OrderDetail']['user_type']=2;
                //$data_ord['OrderDetail']['cancel_user_id']=$userid;
                //$data_ord['OrderDetail']['order_status']='S';
                $this->OrderDetail->save($data_ord);
                $this->Session->setFlash(__('You have successfully cancel the dispute.'));
                return $this->redirect(array('controller' => 'orders', 'action' => 'awaiting_delivery'));
            }else{
                return $this->redirect(array('controller' => 'orders', 'action' => 'buyer_disputes'));
            }
        }
        
        public function buyer_accept_dipute($ord_det_id=null,$dispute_id=null) {
            $this->loadModel('Dispute');
            $this->loadModel('Comment');
            $this->loadModel('OrderDetail');
            $this->loadModel('DisputeMessage');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $ord_details_id=  base64_decode($ord_det_id);
            $ord_dispute_id=  base64_decode($dispute_id);
            
            if ($ord_details_id!='') {
                $dispute_data['DisputeMessage']['user_id']=$userid;
                $dispute_data['DisputeMessage']['dispute_id']=$ord_dispute_id;
                $dispute_data['DisputeMessage']['reason']='';
                $dispute_data['DisputeMessage']['received_goods']='No';
                $dispute_data['DisputeMessage']['refund_request']='';
                $dispute_data['DisputeMessage']['return_goods']='No';
                $dispute_data['DisputeMessage']['refund_amount']='0.00';
                $dispute_data['DisputeMessage']['action']='Buyer accept the dispute rejected by seller.';
                $dispute_data['DisputeMessage']['user_type']=2;
                $dispute_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                $this->DisputeMessage->create();
                $this->DisputeMessage->save($dispute_data);
                
                $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$ord_details_id)));
                $order_received_date=$user_data['OrderDetail']['order_received_date'];
                $data_ord['OrderDetail']['id']=$ord_details_id;
                //$data_ord['OrderDetail']['user_type']=2;
                //$data_ord['OrderDetail']['cancel_user_id']=$userid;
                $data_ord['OrderDetail']['buyer_accept_dispute']=1;
                if($order_received_date=='0000-00-00 00:00:00'){
                    $data_ord['OrderDetail']['order_status']='S';
                }else{
                    $data_ord['OrderDetail']['order_status']='F';
                }
                $this->OrderDetail->save($data_ord);
                
                $data_dispute['Dispute']['id']=$ord_dispute_id;
                $data_dispute['Dispute']['is_close']=1;
                $this->Dispute->save($data_dispute);
                
                
                $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                
                //Insert Inbox Message 
                $comment_data['Comment']['user_id'] = $userid;
                $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['owner_id'];
                $comment_data['Comment']['comment_type'] = 6;
                $comment_data['Comment']['is_notification'] = 1;
                $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                $comment_data['Comment']['subject'] = 'Buyer accepted the dispute rejected by you. Order ID: '.$NewOrderId;
                $comment_data['Comment']['comments'] = 'Buyer have accepted the dispute rejected by you for the order ID: '.$NewOrderId.', Product Name :'.$user_data['Product']['name'];
                $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                $this->Comment->create();			 
                $this->Comment->save($comment_data);
                    
                $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                //$seller_email=$user_data['User']['email'];
                $to_user_name=$user_data['User']['first_name'];
                $to_email=$user_data['User']['email'];

                $user_name=$user_data['Buyer']['first_name'].' '.$user_data['Buyer']['last_name'];
                $user_email=$user_data['Buyer']['email'];

                $key = Configure::read('CONTACT_EMAIL');
                $SITE_URL = Configure::read('SITE_URL');
                $this->loadModel('EmailTemplate');

                $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>13)));
                $cancelproduct_name=$user_data['Product']['name'];
                $link=$SITE_URL.'orders/awaiting_shipment';

                $mail_body =str_replace(array('[NAME]','[USERNAME]','[EMAIL]','[PRODUCTNAME]','[ORDERID]'),array($to_user_name,$user_name,$user_email,$cancelproduct_name,$NewOrderId),$EmailTemplate['EmailTemplate']['content']);
                $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                $this->Session->setFlash(__('You have successfully accept the seller responce.'));
                return $this->redirect(array('controller' => 'orders', 'action' => 'buyer_dispute_details',$ord_det_id));
            }else{
                return $this->redirect(array('controller' => 'orders', 'action' => 'buyer_disputes'));
            }
        }
        
        public function seller_completed() {
            $this->loadModel('OrderDetail');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Completed';
            //$this->Order->recursive = 0;
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.owner_id='".$userid."') AND (OrderDetail.order_status ='F')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.owner_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
               
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function seller_disputes() {
            $this->loadModel('OrderDetail');
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Disputes List';
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.owner_id='".$userid."') AND (OrderDetail.order_status ='DP')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('OrderDetail.owner_id' => $userid,'OrderDetail.order_status' => 'DP'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
             
            $this->set(compact('orders','title_for_layout','user','order_no','product_name'));
	}
        
        public function dispute_details($id=null) {
            $this->loadModel('DisputeMessage');
            $this->loadModel('OrderDetail');
            $this->loadModel('Dispute');
            $this->loadModel('Comment');
            $this->loadModel('ManageInventory');
            $this->loadModel('Product');
            $this->loadModel('SiteSetting');
            $this->loadModel('Payment');
            
            $title_for_layout = 'Disputes Details';
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                return $this->redirect(array('controller' => 'orders', 'action' => 'seller_disputes'));
            }
            $order_id= base64_decode($id);
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='AcceptDispute'){
                    $dispute_id=$this->request->data['dispute_id'];
                    $full_amount=$this->request->data['full_amount'];
                    $refund_amount=$this->request->data['refund_amount'];
                    $partial_amount=$this->request->data['partial_amount'];
                    $details=$this->request->data['details'];
                    $order_details_id=$this->request->data['order_details_id'];
                    $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                    $OrderPay_key=$user_data['Order']['pay_key'];
                    $seller_business_email=$user_data['User']['paypal_business_email'];
                    
                    $paykey=isset($OrderPay_key)?$OrderPay_key:'';
                    
                    $options_site_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                    $sitesetting = $this->SiteSetting->find('first', $options_site_set);
                    $admin_paypal_email=$sitesetting['SiteSetting']['paypal_email'];
                    $admin_percentage=$sitesetting['SiteSetting']['admin_percentage'];
                    $PayPalFeesPercentage=Configure::read('PayPalFeesPercentage');
                    $PayPalFeesStatic=Configure::read('PayPalFeesStatic');
                    
                    $admin_amount=0;    
                    if($paykey!=''){
                        if($refund_amount=='Full Refund'){
                            $new_dispute_amt=$full_amount;
                            $admin_amount=(($new_dispute_amt*$admin_percentage)/100);
                        }else{
                            $new_dispute_amt=$partial_amount;
                        }
                        $PayPalFeesPer=(($new_dispute_amt*$PayPalFeesPercentage)/100);
                        $PayPalTotFees=($PayPalFeesPer+$PayPalFeesStatic);
                        //$cal_new_dispute_amt=($new_dispute_amt-$PayPalTotFees);
                        //$seller_tot_amount=($new_dispute_amt-$admin_amount-$PayPalTotFees);
                        $cal_new_dispute_amt=$new_dispute_amt;
                        $seller_tot_amount=($new_dispute_amt-$admin_amount);
            
                        require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
                        $refundRequest = new RefundRequest(new RequestEnvelope("en_US"));
                        $refundRequest->currencyCode = 'USD';
                        $refundRequest->payKey = $paykey;
                        
                        
                        $receiver = array();
                        $receiver[0] = new Receiver();
                        $receiver[0]->email = $admin_paypal_email;
                        //$receiver[0]->email = 'payments@errandchampion.com';
                        //$receiver[0]->email = 'nits.arpita@gmail.com';
                        $receiver[0]->amount = round($cal_new_dispute_amt, 2);
                        $receiver[0]->primary = "true";
                        $receiver[0]->paymentType = "SERVICE";

                        $receiver[1] = new Receiver();
                        $receiver[1]->email = $seller_business_email;
                        $receiver[1]->amount = round($seller_tot_amount, 2);
                        $receiver[1]->primary = "false";
                        $receiver[1]->paymentType = "SERVICE";
            
                        $receiverList = new ReceiverList($receiver);
                        $refundRequest->receiverList = $receiverList;
                        
                        $PayPalService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
                        $PayPalResult = $PayPalService->Refund($refundRequest);
                        $PayPalAck = $PayPalResult->responseEnvelope->ack;
                        $EncryptedTransactionID=$PayPalResult->responseEnvelope->correlationId;
                        
                        if($PayPalAck=='Success'){
                            if($dispute_id!=''){
                                
                                $dispute_data['DisputeMessage']['user_id']=$userid;
                                $dispute_data['DisputeMessage']['dispute_id']=$dispute_id;
                                $dispute_data['DisputeMessage']['reason']=$details;
                                $dispute_data['DisputeMessage']['received_goods']='No';
                                $dispute_data['DisputeMessage']['refund_request']=$refund_amount;
                                $dispute_data['DisputeMessage']['return_goods']='No';
                                $dispute_data['DisputeMessage']['refund_amount']=$new_dispute_amt;
                                $dispute_data['DisputeMessage']['action']='Seller accept dispute';
                                $dispute_data['DisputeMessage']['user_type']=2;
                                $dispute_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                                $this->DisputeMessage->create();
                                $this->DisputeMessage->save($dispute_data);

                                $data_ord['Dispute']['id']=$dispute_id;
                                $data_ord['Dispute']['seller_response']=1;
                                $data_ord['Dispute']['seller_dispute_action']=1;
                                $data_ord['Dispute']['is_close']=1;
                                $data_ord['Dispute']['cancel_transcation_id']=$EncryptedTransactionID;
                                $this->Dispute->save($data_ord);

                                $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                                $seller_email=$user_data['User']['email'];
                                //$to_user_name=$user_data['User']['first_name'];
                                //$to_email=$user_data['User']['email'];
                                $to_user_name=$user_data['Buyer']['first_name'];
                                $to_email=$user_data['Buyer']['email'];

                                //Manage Inventory List
                                $inventory_data['ManageInventory']['order_id'] = $user_data['OrderDetail']['order_id'];
                                $inventory_data['ManageInventory']['order_details_id'] = $user_data['OrderDetail']['id'];
                                $inventory_data['ManageInventory']['type'] = '+';
                                $inventory_data['ManageInventory']['comment'] = 'Seller accept dispute.';
                                $inventory_data['ManageInventory']['product_id'] = $user_data['OrderDetail']['product_id'];
                                $inventory_data['ManageInventory']['quantity'] = $user_data['OrderDetail']['quantity'];
                                $inventory_data['ManageInventory']['price'] = $user_data['OrderDetail']['price'];
                                $inventory_data['ManageInventory']['user_id'] = $userid;
                                $inventory_data['ManageInventory']['create_date'] = gmdate('Y-m-d H:i:s');
                                $this->ManageInventory->create();
                                $this->ManageInventory->save($inventory_data);

                                //Update Product Inventory
                                $data_prd['Product']['id'] = $user_data['OrderDetail']['product_id'];
                                $data_prd['Product']['quantity'] = ($user_data['Product']['quantity']+$user_data['OrderDetail']['quantity']);
                                $this->Product->save($data_prd);
                                $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));

                                $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                                //Insert Inbox Message 
                                $comment_data['Comment']['user_id'] = $userid;
                                $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['user_id'];
                                $comment_data['Comment']['comment_type'] = 6;
                                $comment_data['Comment']['is_notification'] = 1;
                                $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                                $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                                $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                                $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                                $comment_data['Comment']['subject'] = 'Seller Accept dispute. Order ID: '.$NewOrderId;
                                $comment_data['Comment']['comments'] = $details.' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'].'.<br /> Refund Amount: $'.$cal_new_dispute_amt;
                                $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                                $this->Comment->create();			 
                                $this->Comment->save($comment_data);

                                $payment_arr['Payment']['userid']= $userid;
                                $payment_arr['Payment']['amount']= $cal_new_dispute_amt;
                                $payment_arr['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                                $payment_arr['Payment']['transaction_id']= $EncryptedTransactionID;
                                $payment_arr['Payment']['for']= "debited for accept dispute";
                                $payment_arr['Payment']['status']= "Completed";
                                $payment_arr['Payment']['type'] = 1;
                                $this->Payment->create();
                                $this->Payment->save($payment_arr);

                                $payment_arr1['Payment']['userid']= $user_data['OrderDetail']['user_id'];
                                $payment_arr1['Payment']['amount']= $cal_new_dispute_amt;
                                $payment_arr1['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                                $payment_arr1['Payment']['transaction_id']= $EncryptedTransactionID;
                                $payment_arr1['Payment']['for']= "credited for seller accept dispute";
                                $payment_arr1['Payment']['status']= "Completed";
                                $payment_arr1['Payment']['type'] = 2;
                                $this->Payment->create();
                                $this->Payment->save($payment_arr1);
                            
                                $key = Configure::read('CONTACT_EMAIL');
                                $SITE_URL = Configure::read('SITE_URL');
                                $this->loadModel('EmailTemplate');

                                $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>6)));
                                $product_name=$user_data['Product']['name'];
                                $link=$SITE_URL.'orders/buyer_disputes';

                                $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]','[AMOUNT]'),array($to_user_name,$link,$seller_user_name,$seller_email,$cal_new_dispute_amt),$EmailTemplate['EmailTemplate']['content']);
                                $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                                $this->Session->setFlash(__('You have successfully accept the dispute.'));
                            }
                            //pr($PayPalResult);
                            //exit();
                        }else{
                            $this->Session->setFlash(__('The payment could not be refund due to internal error.'));
                        }
                    }else{
                        $this->Session->setFlash(__('The payment could not be refund due to internal error.'));
                    }
                }elseif($form_type=='RejectDispute'){
                    $dispute_id=$this->request->data['dispute_id'];
                    $details=$this->request->data['reject_details'];
                    $order_details_id=$this->request->data['order_details_id'];
                    if($dispute_id!=''){
                        
                        $dispute_data['DisputeMessage']['user_id']=$userid;
                        $dispute_data['DisputeMessage']['dispute_id']=$dispute_id;
                        $dispute_data['DisputeMessage']['reason']=$details;
                        $dispute_data['DisputeMessage']['received_goods']='No';
                        $dispute_data['DisputeMessage']['refund_request']='';
                        $dispute_data['DisputeMessage']['return_goods']='No';
                        $dispute_data['DisputeMessage']['refund_amount']='';
                        $dispute_data['DisputeMessage']['action']='Seller reject dispute';
                        $dispute_data['DisputeMessage']['user_type']=2;
                        $dispute_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                        $this->DisputeMessage->create();
                        $this->DisputeMessage->save($dispute_data);
                        
                        $data_ord['Dispute']['id']=$dispute_id;
                        $data_ord['Dispute']['seller_response']=1;
                        $data_ord['Dispute']['seller_dispute_action']=2;
                        $this->Dispute->save($data_ord);
                        
                        $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                        $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                        $seller_email=$user_data['User']['email'];
                        //$to_user_name=$user_data['User']['first_name'];
                        //$to_email=$user_data['User']['email'];
                        $to_user_name=$user_data['Buyer']['first_name'];
                        $to_email=$user_data['Buyer']['email'];
                        $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$user_data['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                        
                        $NewOrderId=$Ord_sl_no+$user_data['OrderDetail']['order_id'];
                        //Insert Inbox Message 
                        $comment_data['Comment']['user_id'] = $userid;
                        $comment_data['Comment']['to_user_id'] = $user_data['OrderDetail']['user_id'];
                        $comment_data['Comment']['comment_type'] = 6;
                        $comment_data['Comment']['is_notification'] = 1;
                        $comment_data['Comment']['order_id'] = $user_data['OrderDetail']['order_id'];
                        $comment_data['Comment']['order_details_id'] = $user_data['OrderDetail']['id'];
                        $comment_data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                        $comment_data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                        $comment_data['Comment']['subject'] = 'Seller Reject dispute. Order ID: '.$NewOrderId;
                        $comment_data['Comment']['comments'] = $details.' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$user_data['Product']['name'];
                        $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                        $this->Comment->create();			 
                        $this->Comment->save($comment_data);

                        $key = Configure::read('CONTACT_EMAIL');
                        $SITE_URL = Configure::read('SITE_URL');
                        $this->loadModel('EmailTemplate');

                        $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>12)));
                        $product_name=$user_data['Product']['name'];
                        $link=$SITE_URL.'orders/buyer_disputes';

                        $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]'),array($to_user_name,$link,$seller_user_name,$seller_email),$EmailTemplate['EmailTemplate']['content']);
                        $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                        $this->Session->setFlash(__('You have successfully reject the dispute.'));
                    }
                }elseif($form_type=='message'){
                    
                    if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!=''){			$ext = explode('.',$this->request->data['Comment']['file_name']['name']);
			if($ext){
                            $uploadFolderbanner = "message_img";
                            $uploadPath = WWW_ROOT . $uploadFolderbanner;
                            $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                            if(in_array($ext[1],$extensionValid)){
                                $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Comment']['file_name']['name']));
                                $full_image_path = $uploadPath . '/' . $imageName;
                                move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);

                                $this->request->data['Comment']['file_name'] = $imageName;
                            } 
                        } else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                            return $this->redirect(array('action' => 'dispute_details',$id));
                        }
                    }else{
                        $this->request->data['Comment']['file_name'] = '';
                    }
                    $options_comment = array('conditions' => array('OrderDetail.id' => $order_id));
                    $order_details_comment = $this->OrderDetail->find('first', $options_comment);
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$order_details_comment['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                    $NewOrderId=($Ord_sl_no+$order_details_comment['OrderDetail']['order_id']);
            
                    $this->request->data['Comment']['user_id'] = $userid;
                    $this->request->data['Comment']['to_user_id'] = $order_details_comment['OrderDetail']['user_id'];
                    $this->request->data['Comment']['is_notification'] = 0;
                    $this->request->data['Comment']['order_id'] = $order_details_comment['OrderDetail']['order_id'];
                    $this->request->data['Comment']['order_details_id'] = $order_id;
                    $this->request->data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $this->request->data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $this->request->data['Comment']['subject'] = 'Re: to dispute for Order ID '.$NewOrderId;
                    $this->request->data['Comment']['comment_type'] = 1;
                    $this->request->data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the message.'));
                }
            }
            
            $options = array('conditions' => array('OrderDetail.id' => $order_id));
            $order_details = $this->OrderDetail->find('first', $options);
            
            $this->set(compact('order_details','title_for_layout'));
        }
        
        public function buyer_dispute_details($id=null) {
            $this->loadModel('DisputeMessage');
            $this->loadModel('OrderDetail');
            $this->loadModel('Dispute');
            $this->loadModel('Comment');
            $title_for_layout = 'Disputes Details';
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                return $this->redirect(array('controller' => 'orders', 'action' => 'buyer_disputes'));
            }
            $order_id= base64_decode($id);
            if ($this->request->is(array('post', 'put'))) {
                $form_type=$this->request->data['form_type'];
                if($form_type=='AcceptDispute'){
                    /*$dispute_id=$this->request->data['dispute_id'];
                    $full_amount=$this->request->data['full_amount'];
                    $refund_amount=$this->request->data['refund_amount'];
                    $partial_amount=$this->request->data['partial_amount'];
                    $details=$this->request->data['details'];
                    $order_details_id=$this->request->data['order_details_id'];
                    if($dispute_id!=''){
                        if($refund_amount=='Full Refund'){
                            $new_dispute_amt=$full_amount;
                        }else{
                            $new_dispute_amt=$partial_amount;
                        }
                        
                        $dispute_data['DisputeMessage']['user_id']=$userid;
                        $dispute_data['DisputeMessage']['dispute_id']=$dispute_id;
                        $dispute_data['DisputeMessage']['reason']=$details;
                        $dispute_data['DisputeMessage']['received_goods']='No';
                        $dispute_data['DisputeMessage']['refund_request']=$refund_amount;
                        $dispute_data['DisputeMessage']['return_goods']='No';
                        $dispute_data['DisputeMessage']['refund_amount']=$new_dispute_amt;
                        $dispute_data['DisputeMessage']['action']='Seller accept dispute';
                        $dispute_data['DisputeMessage']['user_type']=2;
                        $dispute_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                        $this->DisputeMessage->create();
                        $this->DisputeMessage->save($dispute_data);
                        
                        $data_ord['Dispute']['id']=$dispute_id;
                        $data_ord['Dispute']['seller_response']=1;
                        $data_ord['Dispute']['seller_dispute_action']=1;
                        $this->Dispute->save($data_ord);
                        
                        $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                        $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                        $seller_email=$user_data['User']['email'];
                        //$to_user_name=$user_data['User']['first_name'];
                        //$to_email=$user_data['User']['email'];
                        $to_user_name=$user_data['Buyer']['first_name'];
                        $to_email=$user_data['Buyer']['email'];

                        $key = Configure::read('CONTACT_EMAIL');
                        $SITE_URL = Configure::read('SITE_URL');
                        $this->loadModel('EmailTemplate');

                        $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>6)));
                        $product_name=$user_data['Product']['name'];
                        $link=$SITE_URL.'orders/buyer_disputes';

                        $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]'),array($to_user_name,$link,$seller_user_name,$seller_email),$EmailTemplate['EmailTemplate']['content']);
                        $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                        $this->Session->setFlash(__('You have successfully accept the dispute.'));
                    }*/
                }elseif($form_type=='RejectDispute'){
                    /*$dispute_id=$this->request->data['dispute_id'];
                    $details=$this->request->data['reject_details'];
                    $order_details_id=$this->request->data['order_details_id'];
                    if($dispute_id!=''){
                        
                        $dispute_data['DisputeMessage']['user_id']=$userid;
                        $dispute_data['DisputeMessage']['dispute_id']=$dispute_id;
                        $dispute_data['DisputeMessage']['reason']=$details;
                        $dispute_data['DisputeMessage']['received_goods']='No';
                        $dispute_data['DisputeMessage']['refund_request']='';
                        $dispute_data['DisputeMessage']['return_goods']='No';
                        $dispute_data['DisputeMessage']['refund_amount']='';
                        $dispute_data['DisputeMessage']['action']='Seller reject dispute';
                        $dispute_data['DisputeMessage']['user_type']=2;
                        $dispute_data['DisputeMessage']['cdate']=gmdate('Y-m-d H:i:s');
                        $this->DisputeMessage->create();
                        $this->DisputeMessage->save($dispute_data);
                        
                        $data_ord['Dispute']['id']=$dispute_id;
                        $data_ord['Dispute']['seller_response']=1;
                        $data_ord['Dispute']['seller_dispute_action']=2;
                        $this->Dispute->save($data_ord);
                        
                        $user_data=$this->OrderDetail->find('first',array('conditions'=>array('OrderDetail.id'=>$order_details_id)));
                        $seller_user_name=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
                        $seller_email=$user_data['User']['email'];
                        //$to_user_name=$user_data['User']['first_name'];
                        //$to_email=$user_data['User']['email'];
                        $to_user_name=$user_data['Buyer']['first_name'];
                        $to_email=$user_data['Buyer']['email'];

                        $key = Configure::read('CONTACT_EMAIL');
                        $SITE_URL = Configure::read('SITE_URL');
                        $this->loadModel('EmailTemplate');

                        $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>7)));
                        $product_name=$user_data['Product']['name'];
                        $link=$SITE_URL.'orders/buyer_disputes';

                        $mail_body =str_replace(array('[NAME]','[LINK]','[SELLERNAME]','[EMAIL]'),array($to_user_name,$link,$seller_user_name,$seller_email),$EmailTemplate['EmailTemplate']['content']);
                        $this->send_mail($key,$to_email,$EmailTemplate['EmailTemplate']['subject'],$mail_body);
                        $this->Session->setFlash(__('You have successfully reject the dispute.'));
                    }*/
                }elseif($form_type=='message'){
                    
                    if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!=''){			$ext = explode('.',$this->request->data['Comment']['file_name']['name']);
			if($ext){
                            $uploadFolderbanner = "message_img";
                            $uploadPath = WWW_ROOT . $uploadFolderbanner;
                            $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                            if(in_array($ext[1],$extensionValid)){
                                $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Comment']['file_name']['name']));
                                $full_image_path = $uploadPath . '/' . $imageName;
                                move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);

                                $this->request->data['Comment']['file_name'] = $imageName;
                            } 
                        } else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                            return $this->redirect(array('action' => 'dispute_details',$id));
                        }
                    }else{
                        $this->request->data['Comment']['file_name'] = '';
                    }
                    
                    $options_comment = array('conditions' => array('OrderDetail.id' => $order_id));
                    $order_details_comment = $this->OrderDetail->find('first', $options_comment);
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.order_id'=>$order_details_comment['OrderDetail']['order_id'], 'Comment.comment_type'=>0)));
                    $NewOrderId=($Ord_sl_no+$order_details_comment['OrderDetail']['order_id']);
            
                    $this->request->data['Comment']['user_id'] = $userid;
                    $this->request->data['Comment']['to_user_id'] = $order_details_comment['OrderDetail']['owner_id'];
                    $this->request->data['Comment']['is_notification'] = 0;
                    $this->request->data['Comment']['order_id'] = $order_details_comment['OrderDetail']['order_id'];
                    $this->request->data['Comment']['order_details_id'] = $order_id;
                    $this->request->data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $this->request->data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $this->request->data['Comment']['subject'] = 'Re: to dispute for Order ID '.$NewOrderId;
                    $this->request->data['Comment']['comment_type'] = 1;
                    $this->request->data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the message.'));
                }
            }
            
            $options = array('conditions' => array('OrderDetail.id' => $order_id));
            $order_details = $this->OrderDetail->find('first', $options);
            
            $this->set(compact('order_details','title_for_layout'));
        }
        
        public function get_seller_details($id=null) {
            $this->loadModel('OrderDetail');
            //$this->loadModel('Shop');
            $options = array('conditions' => array('OrderDetail.order_id' => $id));
            return $order_details = $this->OrderDetail->find('first', $options);
        }
        
        public function get_dispute_message($ord_det_id=null) {
            $this->loadModel('Comment');
            $options = array('conditions' => array('Comment.comment_type' => 1, 'Comment.order_details_id' => $ord_det_id), 'order' => array('Comment.id' => 'asc'));
            return $order_details = $this->Comment->find('all', $options);
        }
        
        public function get_order_message($ord_id=null) {
            $this->loadModel('Comment');
            $options = array('conditions' => array('Comment.comment_type' => 2, 'Comment.order_id' => $ord_id), 'order' => array('Comment.id' => 'asc'));
            return $order_details = $this->Comment->find('all', $options);
        }
        
        public function check_rating_given($prd_id=null, $ord_det_id=null) {
            $this->loadModel('Rating');
            $userid = $this->Session->read('Auth.User.id');
            return $rating_user = $this->Rating->find('first',array('conditions' => array('Rating.user_id'=>$userid, 'Rating.product_id'=>$prd_id, 'Rating.order_details_id'=>$ord_det_id)));      
        }
        
        public function get_dispute_history($id=null) {
            $this->loadModel('DisputeMessage');
            $options = array('conditions' => array('DisputeMessage.dispute_id' => $id), 'order' => array('DisputeMessage.id' => 'desc'));
            return $order_details = $this->DisputeMessage->find('all', $options);
        }
        
        public function get_dispute_images($id=null) {
            $this->loadModel('DisputeImage');
            $options = array('conditions' => array('DisputeImage.dispute_id' => $id), 'order' => array('DisputeImage.id' => 'desc'));
            return $order_details = $this->DisputeImage->find('all', $options);
        }
        
        public function get_product_image($id=null) {
            $this->loadModel('Product');
            $options = array('conditions' => array('Product.id' => $id));
            $order_details = $this->Product->find('first', $options);
            if(count($order_details)>0){
                $result_data=$order_details;
            }else{
                $options_img = array('conditions' => array('Product.id' => $id));
                $result_data = $this->Product->find('first', $options_img);
            }
            return $result_data;
        }
        
        public function get_shop_details($id=null) {
            $this->loadModel('Shop');
            $options = array('conditions' => array('Shop.id' => $id));
            return $order_details = $this->Shop->find('first', $options);
        }
        
        public function get_return_amount($id=null) {
            $this->loadModel('DisputeMessage');
            $options = array('conditions' => array('DisputeMessage.dispute_id' => $id, 'DisputeMessage.user_type' => 2, 'DisputeMessage.action' => 'Seller accept dispute'));
            return $order_details = $this->DisputeMessage->find('first', $options);
        }
        
        public function get_cancel_details($id=null) {
            $this->loadModel('CancelOrder');
            $options = array('conditions' => array('CancelOrder.id' => $id));
            return $order_details = $this->CancelOrder->find('first', $options);
        }
        
        public function get_dispute_details($id=null) {
            $this->loadModel('Dispute');
            $options = array('conditions' => array('Dispute.order_details_id' => $id), 'order' => array('Dispute.id' => 'desc'));
            return $order_details = $this->Dispute->find('first', $options);
        }
        
        public function delete_cart($del_id = null) {
            $this->loadModel('TempCart');
            $id=  base64_decode($del_id);
            $this->TempCart->id = $id;
            if (!$this->TempCart->exists()) {
                    throw new NotFoundException(__('Invalid Request'));
            }
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
		$this->redirect('/');
            }
            
            if ($this->TempCart->delete()) {
                $this->Session->setFlash('Product has been deleted', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Product could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'awaiting_payment'));
        }
        
	public function purchased() {
            //$username = $this->Session->read('username');
            $userid = $this->Session->read('Auth.User.id');
            $countryname = '';
            
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Purchase History';
            $this->Order->recursive = 0;
            $orders = $this->Paginator->paginate('Order', array('Order.user_id' => $userid));
            #pr($orders);
            $options = array('conditions' => array('User.id' => $userid));
            $user = $this->User->find('first', $options);
            if($user){
                if(isset($user['User']['country']) && $user['User']['country']!=0){
                    $countryname = $this->Country->find('first',array('conditions' => array('Country.id'=>$user['User']['country']),'fields' => array('Country.printable_name')));
                    $countryname = $countryname['Country']['printable_name'];
                }
            }
            $this->set(compact('orders','title_for_layout','user','countryname'));
	}
        
        public function purchased_history() {
            $this->loadModel('OrderDetail');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Purchase History';
            //$this->OrderDetail->recursive = 0;
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status='F')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                $options = array('conditions' => array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
            }
            //$orders = $this->Paginator->paginate('OrderDetail', array('OrderDetail.user_id' => $userid,'OrderDetail.order_status' => 'F'));          
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
            $this->set(compact('orders','title_for_layout','product_name','order_no'));
	}
        
        public function seller_mail() {
            $this->loadModel('Comment');
            $this->loadModel('MailFolder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Mail History';
            $order_no='';
            $order_name='';
            /*if($type==null){
                $type='inbox';
            }else{
                $type=$type;
            }*/
            //$this->OrderDetail->recursive = 0;
            /*if ($this->request->is(array('post', 'put'))) {
                
            }else{
                $options = array('conditions' => array('Comment.user_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
            }*/
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        //$senderId = $inbxGet['Comment']['sender_id'];
                        //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_mail'));
                }elseif($this->request->data['messageType']=='MoveToFolder'){
                    $folderID=$this->request->data['folderID'];
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_foler_id']=$folderID;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully moved into the folder.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_mail'));
                }elseif($this->request->data['messageType']=='Flag'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_is_flag']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully flag.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_mail'));
                }elseif($this->request->data['messageType']=='Unflag'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_is_flag']=0;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully unflag.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_mail'));
                }elseif($this->request->data['messageType']=='InboxSearch'){
                    $Ord_sl_no= Configure::read('ORDER_SL_NO');
                    $order_no=$this->request->data['order_no'];
                    $user_name=$this->request->data['user_name'];
                    $QueryStr="(Comment.to_user_id='".$userid."') AND (Comment.seller_is_delete='0')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (Comment.order_id = '".$new_order_no."')";
                    }
                    if($user_name!=''){
                        $QueryStr.=" AND (User.first_name LIKE '%".$user_name."%' OR User.last_name LIKE '%".$user_name."%')";
                    }
                    $options = array('conditions' => array($QueryStr),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                    $order_name=$user_name;
                }else{
                    $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                }
            }else{
                $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            }
            
            $allmsg = $this->Comment->find('all',$options);
            $commnet_id =array();
            foreach($allmsg as $msg){
                foreach($msg as $msgs){
                    $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                }
            }	
                        
            //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.comment_type !=' => array(1,2)), 'order' => array('Comment.id' => 'desc'));
            $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $Inbox_options;
            $messages_list=$this->Paginator->paginate('Comment');
            
            $options_folder = array('conditions' => array('MailFolder.user_id' => $userid,'MailFolder.status' => 1), 'order' => array('MailFolder.folder_name' => 'asc'));
            $mail_folder = $this->MailFolder->find('all',$options_folder);
            
            $this->set(compact('messages_list','title_for_layout','order_no','order_name','mail_folder'));
	}
        
        public function seller_sent() {
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Message Sent';
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $msg['Comment']['seller_is_delete']=1;
                        $msg['Comment']['id']=$v;
                        $this->Comment->save($msg);
                    }
                    $this->Session->setFlash(__('The message has been deleted.'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }
            }
            
            $options_sent = array('conditions' => array('Comment.user_id' => $userid,'Comment.is_notification' => 0,'Comment.seller_is_delete' => 0), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $options_sent;
            $sent_list=$this->Paginator->paginate('Comment');
            $this->set(compact('sent_list','title_for_layout'));
	}
        
        public function seller_folder($folder_type=null) {
            $this->loadModel('Comment');
            $this->loadModel('MailFolder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Folder History';
            $order_no='';
            $order_name='';
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_folder'));
                }elseif($this->request->data['messageType']=='FolderDelete'){
                    foreach($this->request->data['del_folder_id'] as $k=>$v){
                        $options = array('conditions'=>array('Comment.seller_foler_id' =>$v));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['seller_foler_id']=0;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                        $this->MailFolder->id = $v;
                        $this->MailFolder->delete();
                    }
                    $this->Session->setFlash('The folder has been successfully deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_folder'));
                }elseif($this->request->data['messageType']=='MoveToFolder'){
                    $folderID=$this->request->data['folderID'];
                    $del_msg=isset($this->request->data['del_msg'])?$this->request->data['del_msg']:array();
                    $del_folder_id=isset($this->request->data['del_folder_id'])?$this->request->data['del_folder_id']:array();
                    if(count($del_msg)>0){
                        foreach($this->request->data['del_msg'] as $k=>$v){
                            $options = array('conditions' => array('Comment.id'=>$v));
                            $inbxGet = $this->Comment->find('first',$options);
                            $pJobId = $inbxGet['Comment']['thread_id'];
                            $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                            $seeChangeMsg = $this->Comment->find('all',$options);
                            if(!empty($seeChangeMsg)){
                                foreach($seeChangeMsg as $chngMsg){
                                    $msg['Comment']['seller_foler_id']=$folderID;
                                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                    $this->Comment->save($msg);
                                }
                            }
                        }
                    }elseif(count($del_folder_id)>0){
                        foreach($this->request->data['del_folder_id'] as $k=>$v){
                            $options = array('conditions'=>array('Comment.seller_foler_id' =>$v));
                            $seeChangeMsg = $this->Comment->find('all',$options);
                            if(!empty($seeChangeMsg)){
                                foreach($seeChangeMsg as $chngMsg){
                                    $msg['Comment']['seller_foler_id']=$folderID;
                                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                    $this->Comment->save($msg);
                                }
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully moved into the folder.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'seller_folder'));
                }elseif($this->request->data['messageType']=='InboxSearch'){
                    $Ord_sl_no= Configure::read('ORDER_SL_NO');
                    $order_no=$this->request->data['order_no'];
                    $user_name=$this->request->data['user_name'];
                    $QueryStr="(Comment.to_user_id='".$userid."') AND (Comment.seller_is_delete='0')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (Comment.order_id = '".$new_order_no."')";
                    }
                    if($user_name!=''){
                        $QueryStr.=" AND (User.first_name LIKE '%".$user_name."%' OR User.last_name LIKE '%".$user_name."%')";
                    }
                    $options = array('conditions' => array($QueryStr),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                    $order_name=$user_name;
                }else{
                    $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                }
            }else{
                $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            }
            
            
            $allmsg = $this->Comment->find('all',$options);
            $commnet_id =array();
            foreach($allmsg as $msg){
                foreach($msg as $msgs){
                    $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                }
            }	
                        
            //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.comment_type !=' => array(1,2)), 'order' => array('Comment.id' => 'desc'));
            
            if($folder_type!=''){
                $folder_id=  base64_decode($folder_type);
                //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                $allmsg = $this->Comment->find('all',$options);
                $commnet_id =array();
                foreach($allmsg as $msg){
                    foreach($msg as $msgs){
                        $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                    }
                }	

                $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.seller_foler_id' => $folder_id), 'order' => array('Comment.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('Comment');
                
            }else{
                $Inbox_options = array('conditions' => array('MailFolder.user_id' => $userid), 'order' => array('MailFolder.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('MailFolder');
            }
            
            $options_folder = array('conditions' => array('MailFolder.user_id' => $userid,'MailFolder.status' => 1), 'order' => array('MailFolder.folder_name' => 'asc'));
            $mail_folder = $this->MailFolder->find('all',$options_folder);
            $this->set(compact('messages_list','title_for_layout','order_name','order_no','mail_folder','folder_type'));
	}
        
        public function seller_report() {
            $this->loadModel('Product');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Seller Report';
            if ($this->request->is(array('post', 'put'))) {
                
                $from_date=$this->request->data['from_date'];
                $to_date=$this->request->data['to_date'];
                $stars=$this->request->data['stars'];
                $QueryStr="(Product.user_id = '".$userid."')";
                /*if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                if($product_sku!=''){
                    $QueryStr.=" AND (Product.sku LIKE '%".$product_sku."%')";
                }*/
                if($from_date!='' && $to_date==''){
                    $QueryStr.=" AND (Product.created_at >= '".$from_date."')";
                }
                if($from_date=='' && $to_date!=''){
                    $QueryStr.=" AND (Product.created_at <= '".$to_date."')";
                }
                if($from_date!='' && $to_date!=''){
                    $QueryStr.=" AND (Product.created_at BETWEEN '".$from_date."' AND '".$to_date."')";
                }
                if($stars!=''){
                    $QueryStr.=" AND (Product.total_rate = '".$stars."')";
                }
                $options_sent = array('conditions' => array($QueryStr), 'order' => array('Product.sold_quantity' => 'desc'));
                
            }else{
                $options_sent = array('conditions' => array('Product.user_id' => $userid), 'order' => array('Product.sold_quantity' => 'desc'));
                $from_date='';
                $to_date='';
                $stars='';
            }
            $this->Paginator->settings = $options_sent;
            $prd_list=$this->Paginator->paginate('Product');
            $this->set(compact('prd_list','title_for_layout','from_date','to_date','stars'));
	}
        
        public function buyer_message($type=null) {
            $this->loadModel('Comment');
            $this->loadModel('MailFolder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Message History';
            $order_no='';
            $order_name='';
            /*if($type==null){
                $type='inbox';
            }else{
                $type=$type;
            }*/
            //$this->OrderDetail->recursive = 0;
            /*if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['product_name'];
                $QueryStr="(OrderDetail.user_id='".$userid."') AND (OrderDetail.order_status='F')";
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (OrderDetail.order_id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Product.name LIKE '%".$product_name."%')";
                }
                $options = array('conditions' => array($QueryStr), 'order' => array('OrderDetail.id' => 'desc'));
            }else{
                $options = array('conditions' => array('Comment.user_id' => $userid,'OrderDetail.order_status' => 'F'), 'order' => array('OrderDetail.id' => 'desc'));
            }*/
            //$options = array('conditions' => array('Comment.to_user_id' => $userid, 'Comment.is_notification' => 1),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        //$senderId = $inbxGet['Comment']['sender_id'];
                        //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }elseif($this->request->data['messageType']=='MoveToFolder'){
                    $folderID=$this->request->data['folderID'];
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['folder_id']=$folderID;
                                //$msg['Comment']['buyer_is_flag']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully moved into the folder.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }elseif($this->request->data['messageType']=='Flag'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_flag']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully flag.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }elseif($this->request->data['messageType']=='Unflag'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_flag']=0;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully unflag.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }elseif($this->request->data['messageType']=='InboxSearch'){
                    $Ord_sl_no= Configure::read('ORDER_SL_NO');
                    $order_no=$this->request->data['order_no'];
                    $user_name=$this->request->data['user_name'];
                    $QueryStr="(Comment.to_user_id='".$userid."') AND (Comment.buyer_is_delete='0')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (Comment.order_id = '".$new_order_no."')";
                    }
                    if($user_name!=''){
                        $QueryStr.=" AND (User.first_name LIKE '%".$user_name."%' OR User.last_name LIKE '%".$user_name."%')";
                    }
                    $options = array('conditions' => array($QueryStr),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                    $order_name=$user_name;
                }else{
                    $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                }
            }else{
                //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.seller_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            }
            
            $allmsg = $this->Comment->find('all',$options);
            $commnet_id =array();
            foreach($allmsg as $msg){
                foreach($msg as $msgs){
                    $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                }
            }	
                        
            //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.comment_type !=' => array(1,2)), 'order' => array('Comment.id' => 'desc'));
            $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $Inbox_options;
            $messages_list=$this->Paginator->paginate('Comment');
            $options_folder = array('conditions' => array('MailFolder.user_id' => $userid,'MailFolder.status' => 1), 'order' => array('MailFolder.folder_name' => 'asc'));
            $mail_folder = $this->MailFolder->find('all',$options_folder);
            /*$options_sent = array('conditions' => array('Comment.user_id' => $userid,'Comment.is_notification' => 0), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $options_sent;
            $sent_list=$this->Paginator->paginate('Comment');*/
            
            $this->set(compact('messages_list','title_for_layout','mail_folder','order_no','order_name'));
	}
        
        public function buyer_sent() {
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Message Sent';
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $msg['Comment']['buyer_is_delete']=1;
                        $msg['Comment']['id']=$v;
                        $this->Comment->save($msg);
                    }
                    $this->Session->setFlash(__('The message has been deleted.'));
                    return $this->redirect(array('action' => 'buyer_message'));
                }
            }
            
            $options_sent = array('conditions' => array('Comment.user_id' => $userid,'Comment.is_notification' => 0,'Comment.buyer_is_delete' => 0), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $options_sent;
            $sent_list=$this->Paginator->paginate('Comment');
            $this->set(compact('sent_list','title_for_layout'));
	}
        
        /*public function buyer_folder() {
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Folder History';
            
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        //$senderId = $inbxGet['Comment']['sender_id'];
                        //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash(__('The message has been deleted.'));
                    return $this->redirect(array('action' => 'buyer_folder'));
                }
            }
            
            $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            $allmsg = $this->Comment->find('all',$options);
            $commnet_id =array();
            foreach($allmsg as $msg){
                foreach($msg as $msgs){
                    $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                }
            }	
                        
            //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.comment_type !=' => array(1,2)), 'order' => array('Comment.id' => 'desc'));
            $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.buyer_is_flag' => 1), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $Inbox_options;
            $messages_list=$this->Paginator->paginate('Comment');
            
            $this->set(compact('messages_list','title_for_layout'));
	}*/
        
        /*public function buyer_folder($folder_type=null) {
            $this->loadModel('Comment');
            $this->loadModel('MailFolder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Folder History';
            
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        //$senderId = $inbxGet['Comment']['sender_id'];
                        //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash(__('The message has been deleted.'));
                    return $this->redirect(array('action' => 'buyer_folder'));
                }
            }
            if($folder_type!=''){
                $folder_id=  base64_decode($folder_type);
                $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                $allmsg = $this->Comment->find('all',$options);
                $commnet_id =array();
                foreach($allmsg as $msg){
                    foreach($msg as $msgs){
                        $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                    }
                }	

                $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.folder_id' => $folder_id), 'order' => array('Comment.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('Comment');
            }else{
                $Inbox_options = array('conditions' => array('MailFolder.user_id' => $userid), 'order' => array('MailFolder.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('MailFolder');
            }
            
            $this->set(compact('messages_list','title_for_layout','folder_type'));
	}*/
        public function buyer_folder($folder_type=null) {
            $this->loadModel('Comment');
            $this->loadModel('MailFolder');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            $title_for_layout = 'Folder History';
            $order_no='';
            $order_name='';
            
            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['messageType']=='InboxDelete'){
                    foreach($this->request->data['del_msg'] as $k=>$v){
                        $options = array('conditions' => array('Comment.id'=>$v));
                        $inbxGet = $this->Comment->find('first',$options);
                        $pJobId = $inbxGet['Comment']['thread_id'];
                        //$senderId = $inbxGet['Comment']['sender_id'];
                        //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
                        $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['buyer_is_delete']=1;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_folder'));
                }elseif($this->request->data['messageType']=='FolderDelete'){
                    foreach($this->request->data['del_folder_id'] as $k=>$v){
                        $options = array('conditions'=>array('Comment.folder_id' =>$v));
                        $seeChangeMsg = $this->Comment->find('all',$options);
                        if(!empty($seeChangeMsg)){
                            foreach($seeChangeMsg as $chngMsg){
                                $msg['Comment']['folder_id']=0;
                                $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                $this->Comment->save($msg);
                            }
                        }
                        $this->MailFolder->id = $v;
                        $this->MailFolder->delete();
                    }
                    $this->Session->setFlash('The folder has been successfully deleted.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_folder'));
                }elseif($this->request->data['messageType']=='MoveToFolder'){
                    $folderID=$this->request->data['folderID'];
                    $del_msg=isset($this->request->data['del_msg'])?$this->request->data['del_msg']:array();
                    $del_folder_id=isset($this->request->data['del_folder_id'])?$this->request->data['del_folder_id']:array();
                    if(count($del_msg)>0){
                        foreach($this->request->data['del_msg'] as $k=>$v){
                            $options = array('conditions' => array('Comment.id'=>$v));
                            $inbxGet = $this->Comment->find('first',$options);
                            $pJobId = $inbxGet['Comment']['thread_id'];
                            $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
                            $seeChangeMsg = $this->Comment->find('all',$options);
                            if(!empty($seeChangeMsg)){
                                foreach($seeChangeMsg as $chngMsg){
                                    $msg['Comment']['folder_id']=$folderID;
                                    //$msg['Comment']['buyer_is_flag']=1;
                                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                    $this->Comment->save($msg);
                                }
                            }
                        }
                    }elseif(count($del_folder_id)>0){
                        foreach($this->request->data['del_folder_id'] as $k=>$v){
                            $options = array('conditions'=>array('Comment.folder_id' =>$v));
                            $seeChangeMsg = $this->Comment->find('all',$options);
                            if(!empty($seeChangeMsg)){
                                foreach($seeChangeMsg as $chngMsg){
                                    $msg['Comment']['folder_id']=$folderID;
                                    //$msg['Comment']['buyer_is_flag']=1;
                                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                                    $this->Comment->save($msg);
                                }
                            }
                        }
                    }
                    $this->Session->setFlash('The message has been successfully moved into the folder.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'buyer_folder'));
                }elseif($this->request->data['messageType']=='InboxSearch'){
                    $Ord_sl_no= Configure::read('ORDER_SL_NO');
                    $order_no=$this->request->data['order_no'];
                    $user_name=$this->request->data['user_name'];
                    $QueryStr="(Comment.to_user_id='".$userid."') AND (Comment.buyer_is_delete='0')";
                    if($order_no!=''){
                        $new_order_no=$order_no-$Ord_sl_no;
                        $QueryStr.=" AND (Comment.order_id = '".$new_order_no."')";
                    }
                    if($user_name!=''){
                        $QueryStr.=" AND (User.first_name LIKE '%".$user_name."%' OR User.last_name LIKE '%".$user_name."%')";
                    }
                    $options = array('conditions' => array($QueryStr),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                    $order_name=$user_name;
                }else{
                    $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                }
            }else{
                $options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
            }
            if($folder_type!=''){
                $folder_id=  base64_decode($folder_type);
                //$options = array('conditions' => array('Comment.to_user_id' => $userid,'Comment.buyer_is_delete' => 0),'group' => array('Comment.thread_id'),'fields' => array('MAX(Comment.id)'));
                $allmsg = $this->Comment->find('all',$options);
                $commnet_id =array();
                foreach($allmsg as $msg){
                    foreach($msg as $msgs){
                        $commnet_id[]= $msgs['MAX(`Comment`.`id`)'];
                    }
                }	

                $Inbox_options = array('conditions' => array('Comment.id' => $commnet_id, 'Comment.folder_id' => $folder_id), 'order' => array('Comment.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('Comment');
            }else{
                $Inbox_options = array('conditions' => array('MailFolder.user_id' => $userid), 'order' => array('MailFolder.id' => 'desc'));
                $this->Paginator->settings = $Inbox_options;
                $messages_list=$this->Paginator->paginate('MailFolder');
            }
            $options_folder = array('conditions' => array('MailFolder.user_id' => $userid,'MailFolder.status' => 1), 'order' => array('MailFolder.folder_name' => 'asc'));
            $mail_folder = $this->MailFolder->find('all',$options_folder);
            $this->set(compact('messages_list','title_for_layout','folder_type','order_no','order_name','mail_folder'));
	}
        
        public function seller_flag($id = null,$type=null) {
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                $this->redirect('/orders/seller_mail');
            }
            $msg_id = base64_decode($id);
            $type=base64_decode($type);
            $options = array('conditions' => array('Comment.id'=>$msg_id));
            $inbxGet = $this->Comment->find('first',$options);
            $pJobId = $inbxGet['Comment']['thread_id'];
            
            $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
            $seeChangeMsg = $this->Comment->find('all',$options);
            if(!empty($seeChangeMsg)){
                if($type==1){
                    $update_flag=0;
                }else{
                    $update_flag=1;
                }
                foreach($seeChangeMsg as $chngMsg){
                    $msg['Comment']['seller_is_flag']=$update_flag;
                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                    $this->Comment->save($msg);
                }
            }
            $this->Session->setFlash('Message flag successfully updated.', 'default', array('class' => 'success'));
            return $this->redirect(array('action' => 'seller_mail'));
        }
        
        public function buyer_flag($id = null,$type=null) {
            $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                $this->redirect('/orders/buyer_message');
            }
            $msg_id = base64_decode($id);
            $type=base64_decode($type);
            $options = array('conditions' => array('Comment.id'=>$msg_id));
            $inbxGet = $this->Comment->find('first',$options);
            $pJobId = $inbxGet['Comment']['thread_id'];
            //$senderId = $inbxGet['Comment']['sender_id'];
            //$options = array('conditions'=>array('Comment.thread_id' =>$pJobId,'OR'=>array('InboxMessage.sender_id' => $senderId,'InboxMessage.user_id' => $senderId)));
            $options = array('conditions'=>array('Comment.thread_id' =>$pJobId));
            $seeChangeMsg = $this->Comment->find('all',$options);
            if(!empty($seeChangeMsg)){
                if($type==1){
                    $update_flag=0;
                }else{
                    $update_flag=1;
                }
                foreach($seeChangeMsg as $chngMsg){
                    $msg['Comment']['buyer_is_flag']=$update_flag;
                    $msg['Comment']['id']=$chngMsg['Comment']['id'];
                    $this->Comment->save($msg);
                }
            }
            
            $this->Session->setFlash(__('Message flag successfully.'));
            return $this->redirect(array('action' => 'buyer_message'));
        }
        
        public function message_conversations($id = null) {
	    $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                $this->redirect('/orders/buyer_message');
            }
            $title_for_layout = 'Message Conversation';
            $msg_thread_id = base64_decode($id);
            if ($this->request->is('post')){
                $frm_type=$this->request->data['frm_type'];
                if($frm_type=='ReplyFrm'){
                    $comment_id=$this->request->data['comment_id'];
                    $comment_pid = base64_decode($comment_id);
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.id'=>$comment_pid)));
                    if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!=''){			$ext = explode('.',$this->request->data['Comment']['file_name']['name']);
                        if($ext){
                            $uploadFolderbanner = "message_img";
                            $uploadPath = WWW_ROOT . $uploadFolderbanner;
                            $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                            if(in_array($ext[1],$extensionValid)){
                                $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Comment']['file_name']['name']));
                                $full_image_path = $uploadPath . '/' . $imageName;
                                move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);

                                $this->request->data['Comment']['file_name'] = $imageName;
                            } 
                        } else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                            return $this->redirect(array('action' => 'message_conversations',$id));
                        }
                    }else{
                        $this->request->data['Comment']['file_name'] = '';
                    }
                    $Comment_subject=$thread_data['Comment']['subject'];
                    if($Comment_subject!=''){
                        $str_pos = strpos($Comment_subject, 'Re:');
                        if ($str_pos === false) {
                            $msg_Subject='Re: '.$Comment_subject;
                        }else{
                            $msg_Subject=$Comment_subject;
                        }
                    }else{
                        $msg_Subject='';
                    }
                    
                    $this->request->data['Comment']['user_id'] = $userid;
                    $this->request->data['Comment']['to_user_id'] = $thread_data['Comment']['user_id'];
                    $this->request->data['Comment']['is_notification'] = 0;
                    $this->request->data['Comment']['order_id'] = $thread_data['Comment']['order_id'];
                    $this->request->data['Comment']['order_details_id'] = $thread_data['Comment']['order_details_id'];
                    $this->request->data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $this->request->data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $this->request->data['Comment']['subject'] = $msg_Subject;
                    $this->request->data['Comment']['comment_type'] = $thread_data['Comment']['comment_type'];
                    $this->request->data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the message.'));
                    return $this->redirect(array('action' => 'message_conversations',$id));
                }
            }
            $options_con = array('conditions' => array('Comment.thread_id' => $msg_thread_id), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $options_con;
            $conversation_list=$this->Paginator->paginate('Comment');
            foreach($conversation_list as $val_com){
                $c_data['Comment']['id']=$val_com['Comment']['id'];
                $c_data['Comment']['is_read']=1;
                $this->Comment->save($c_data);
            }
            $this->set(compact('title_for_layout','conversation_list'));
	}
        
        public function seller_message_conversations($id = null) {
	    $this->loadModel('Comment');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            if(!isset($id)){
                $this->redirect('/orders/buyer_message');
            }
            $title_for_layout = 'Message Conversation';
            $msg_thread_id = base64_decode($id);
            if ($this->request->is('post')){
                $frm_type=$this->request->data['frm_type'];
                if($frm_type=='ReplyFrm'){
                    $comment_id=$this->request->data['comment_id'];
                    $comment_pid = base64_decode($comment_id);
                    $thread_data=$this->Comment->find('first',array('conditions'=>array('Comment.id'=>$comment_pid)));
                    if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!=''){			$ext = explode('.',$this->request->data['Comment']['file_name']['name']);
                        if($ext){
                            $uploadFolderbanner = "message_img";
                            $uploadPath = WWW_ROOT . $uploadFolderbanner;
                            $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                            if(in_array($ext[1],$extensionValid)){
                                $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Comment']['file_name']['name']));
                                $full_image_path = $uploadPath . '/' . $imageName;
                                move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);

                                $this->request->data['Comment']['file_name'] = $imageName;
                            } 
                        } else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                            return $this->redirect(array('action' => 'seller_message_conversations',$id));
                        }
                    }else{
                        $this->request->data['Comment']['file_name'] = '';
                    }
                    $Comment_subject=$thread_data['Comment']['subject'];
                    if($Comment_subject!=''){
                        $str_pos = strpos($Comment_subject, 'Re:');
                        if ($str_pos === false) {
                            $msg_Subject='Re: '.$Comment_subject;
                        }else{
                            $msg_Subject=$Comment_subject;
                        }
                    }else{
                        $msg_Subject='';
                    }
                    
                    $this->request->data['Comment']['user_id'] = $userid;
                    $this->request->data['Comment']['to_user_id'] = $thread_data['Comment']['user_id'];
                    $this->request->data['Comment']['is_notification'] = 0;
                    $this->request->data['Comment']['order_id'] = $thread_data['Comment']['order_id'];
                    $this->request->data['Comment']['order_details_id'] = $thread_data['Comment']['order_details_id'];
                    $this->request->data['Comment']['thread_id'] = $thread_data['Comment']['thread_id'];
                    $this->request->data['Comment']['folder_id']=isset($thread_data['Comment']['folder_id'])?$thread_data['Comment']['folder_id']:0;
                    $this->request->data['Comment']['subject'] = $msg_Subject;
                    $this->request->data['Comment']['comment_type'] = $thread_data['Comment']['comment_type'];
                    $this->request->data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');
                    $this->Comment->create();			 
                    $this->Comment->save($this->request->data);
                    $this->Session->setFlash(__('You have successfully submited the message.'));
                    return $this->redirect(array('action' => 'seller_message_conversations',$id));
                }
            }
            $options_con = array('conditions' => array('Comment.thread_id' => $msg_thread_id), 'order' => array('Comment.id' => 'desc'));
            $this->Paginator->settings = $options_con;
            $conversation_list=$this->Paginator->paginate('Comment');
            
	    foreach($conversation_list as $val_com){
                $c_data['Comment']['id']=$val_com['Comment']['id'];
                $c_data['Comment']['seller_is_read']=1;
                $this->Comment->save($c_data);
            }
	    
            $this->set(compact('title_for_layout','conversation_list'));
	}
        
	public function admin_index() {
            $this->Order->recursive = 0;
            $orders = $this->Paginator->paginate();
            #pr($orders);
            $this->set(compact('orders'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$this->set('order', $this->Order->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Order->create();
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
			$this->request->data = $this->Order->find('first', $options);
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Order->delete()) {
			$this->Session->setFlash(__('The order has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function getUsername($id = null){
		$username = '';
		if($id!=''){
			$userName = $this->User->find('first', array('conditions' => array('User.id' => $id), 'fields' => array('User.first_name','User.last_name')));
			if($userName){
				$username = $userName['User']['first_name'].' '.$userName['User']['last_name'];
			}
		}
		return $username;
	}
        
        public function get_tracking_details($id = null){
            $this->loadModel('TrackDetail');
            $details= $this->TrackDetail->find('first', array('conditions' => array('TrackDetail.order_details_id' => $id)));
            return $details;
	}
        
        public function get_order_details_for_cancel($id = null){
            $this->autoRender = false;
            $this->loadModel('OrderDetail');
            $this->loadModel('CancelOrder');
            $id=$this->request->data['order_detalis_id'];
            $details_type=$this->request->data['details_type'];
            //$ord_id=  base64_decode($id);
            $ord_id=  $id;
            $Data_str='';
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $order = $this->OrderDetail->find('first', array('conditions' => array('OrderDetail.id' => $ord_id)));
            
	    if(count($order)>0){
                $cancel_order = $this->CancelOrder->find('first', array('conditions' => array('CancelOrder.id' => $order['OrderDetail']['cancel_id'])));
                if(count($cancel_order)>0){
                    $cancel_description=$cancel_order['CancelOrder']['description'];
                }
                $cancel_description_text=isset($cancel_description)?$cancel_description:'';
                $order_date=date('dS M, Y',strtotime($order['Order']['order_date']));
                $order_id=$order['Order']['id'];
                $shipping_address=$order['Order']['shipping_address'];
                //$pay_price=$order['OrderDetail']['price'];
                $sl_no=$Ord_sl_no+$order_id;
                $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                $product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
                $package_weight=isset($order['Product']['package_weight'])?$order['Product']['package_weight']:'';
                $package_size1=isset($order['Product']['package_size1'])?$order['Product']['package_size1']:'';
                $package_size2=isset($order['Product']['package_size2'])?$order['Product']['package_size2']:'';
                $package_size3=isset($order['Product']['package_size3'])?$order['Product']['package_size3']:'';
                if($shipping_address!=''){
                    $shipping_address_str=explode('#',$shipping_address);
                }  
                $ContactName=isset($shipping_address_str[0])?$shipping_address_str[0]:'';
                $street=isset($shipping_address_str[1])?$shipping_address_str[1]:'';
                $apartment=isset($shipping_address_str[2])?$shipping_address_str[2]:'';
                $city=isset($shipping_address_str[3])?$shipping_address_str[3]:'';
                $state=isset($shipping_address_str[4])?$shipping_address_str[4]:'';
                $zip_code=isset($shipping_address_str[5])?$shipping_address_str[5]:'';
                $phn_no=isset($shipping_address_str[6])?$shipping_address_str[6]:'';
                $Country_name=isset($shipping_address_str[7])?$shipping_address_str[7]:'';
                //$ContactName=isset($shipping_address_str[8])?$shipping_address_str[8]:'';
                
                $Data_str.='<div class="row">
                    <div class="col-sm-6">
                        <p><span style="font-weight: bolder;">Order ID:</span> '.$sl_no.'</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span style="font-weight: bolder;">Order date:</span> '.$order_date.'</p> 
                    </div>
                    <div class="col-sm-12">
                        <a href="Javascript: void(0);">Free Shipping</a>
                        <p>'.$product_name.'</p> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Shipment Address</h3>
                        <p>Contact Name: '.$ContactName.'</p>
                        <p>Address: '.$apartment.', '.$street.', '.$city.', '.$state.', '.$Country_name.'</p>
                        <p>Zip Code: '.$zip_code.'</p>
                        <p>Mobile: '.$phn_no.'</p>
                    </div>
                    <div class="col-sm-6">
                        <p>Package Weight:</p>
                        <p><input type="text" value="'.$package_weight.'" name="data[TrackDetail][package_weight]" required="required" style="width: 100px;"><span class="text_border">KG</span></p>
                        <p>&nbsp;</p>
                        <p>Package Size:</p>
                        <p><input type="text" style="width: 70px;" placeholder="Height" required="required" value="'.$package_size1.'" name="data[TrackDetail][package_size1]"> <input type="text" style="width: 70px;" placeholder="Width" required="required" value="'.$package_size2.'" name="data[TrackDetail][package_size2]"> <input type="text" style="width: 70px;" placeholder="Length" required="required" value="'.$package_size3.'" name="data[TrackDetail][package_size3]"> <span class="text_border">CM</span></p>
                    </div>
                </div>';
                if($details_type=='cancel_order'){
                    $Data_str.='<div class="row">
                    <div class="form-group">
                        <label for="TrackingNo" class="col-sm-5 control-label">Buyer\'s Cancellation Reason:</label>
                        <div class="col-sm-6">
                            <p style="color: #c73e14;">'.$cancel_description_text.'</p>
                        </div>
                    </div>
                </div>';
                }
                $Data_str.='<div class="row"><div class="col-sm-12" style="border-bottom: 2px dotted #ebebeb;"> &nbsp; </div></div>
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>';
            }
            echo $Data_str;
	}
        
        public function get_order_IDdetails($id = null){
            return $order = $this->Order->find('first', array('conditions' => array('Order.id' => $id)));
        }
        
        public function get_order_details($id = null){
            $this->autoRender = false;
            $this->loadModel('OrderDetail');
            $id=$this->request->data['order_detalis_id'];
            $ord_id=  base64_decode($id);
            $Data_str='';
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $order = $this->OrderDetail->find('first', array('conditions' => array('OrderDetail.id' => $ord_id)));
	    if(count($order)>0){
                $order_date=date('dS M, Y',strtotime($order['Order']['order_date']));
                $order_id=$order['Order']['id'];
                $shipping_address=$order['Order']['shipping_address'];
                //$pay_price=$order['OrderDetail']['price'];
                $sl_no=$Ord_sl_no+$order_id;
                $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                $product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
                $package_weight=isset($order['Product']['package_weight'])?$order['Product']['package_weight']:'';
                $package_size1=isset($order['Product']['package_size1'])?$order['Product']['package_size1']:'';
                $package_size2=isset($order['Product']['package_size2'])?$order['Product']['package_size2']:'';
                $package_size3=isset($order['Product']['package_size3'])?$order['Product']['package_size3']:'';
                if($shipping_address!=''){
                    $shipping_address_str=explode('#',$shipping_address);
                }  
                $ContactName=isset($shipping_address_str[0])?$shipping_address_str[0]:'';
                $street=isset($shipping_address_str[1])?$shipping_address_str[1]:'';
                $apartment=isset($shipping_address_str[2])?$shipping_address_str[2]:'';
                $city=isset($shipping_address_str[3])?$shipping_address_str[3]:'';
                $state=isset($shipping_address_str[4])?$shipping_address_str[4]:'';
                $zip_code=isset($shipping_address_str[5])?$shipping_address_str[5]:'';
                $phn_no=isset($shipping_address_str[6])?$shipping_address_str[6]:'';
                $Country_name=isset($shipping_address_str[7])?$shipping_address_str[7]:'';
                //$ContactName=isset($shipping_address_str[8])?$shipping_address_str[8]:'';
                
                $Data_str.='<input type="hidden" name="data[TrackDetail][order_details_id]" value="'.$ord_id.'"><div class="row">
                    <div class="col-sm-6">
                        <p><span style="font-weight: bolder;">Order ID:</span> '.$sl_no.'</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span style="font-weight: bolder;">Order date:</span> '.$order_date.'</p> 
                    </div>
                    <div class="col-sm-12">
                        <a href="Javascript: void(0);">Free Shipping</a>
                        <p>'.$product_name.'</p> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Shipment Address</h3>
                        <p>Contact Name: '.$ContactName.'</p>
                        <p>Address: '.$apartment.', '.$street.', '.$city.', '.$state.', '.$Country_name.'</p>
                        <p>Zip Code: '.$zip_code.'</p>
                        <p>Mobile: '.$phn_no.'</p>
                    </div>
                    <div class="col-sm-6">
                        <p>Package Weight:</p>
                        <p><input type="text" value="'.$package_weight.'" name="data[TrackDetail][package_weight]" required="required" style="width: 100px;"><span class="text_border">KG</span></p>
                        <p>&nbsp;</p>
                        <p>Package Size:</p>
                        <p><input type="text" style="width: 70px;" placeholder="Height" required="required" value="'.$package_size1.'" name="data[TrackDetail][package_size1]"> <input type="text" style="width: 70px;" placeholder="Width" required="required" value="'.$package_size2.'" name="data[TrackDetail][package_size2]"> <input type="text" style="width: 70px;" placeholder="Length" required="required" value="'.$package_size3.'" name="data[TrackDetail][package_size3]"> <span class="text_border">CM</span></p>
                    </div>
                </div>
                <div class="row"><div class="col-sm-12" style="border-bottom: 2px dotted #ebebeb;"> &nbsp; </div></div>
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                <div class="row">
                    <div class="form-group">
                        <label for="TrackingNo" class="col-sm-4 control-label">Add Tracking No: <span class="required_cls">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="TrackingNo" name="data[TrackDetail][tracking_no]" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="WebAddress" class="col-sm-4 control-label">Tracking Link: <span class="required_cls">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="WebAddress" placeholder="www.track.com" name="data[TrackDetail][web_address]" required="required">
                        </div>
                    </div>
                </div>';
            }
            echo $Data_str;
	}
        
	public function confirm($temp_id=null){
            $userid = $this->Session->read('Auth.User.id');
            //pr($_REQUEST);
            //exit();
            if(!isset($userid)){
                return $this->redirect('/');
            }
            $this->loadModel('TempCart');
            $this->loadModel('CouponUse');
            $this->loadModel('Coupon');
            $this->loadModel('ShippingAddress');
            $this->loadModel('Product');
            $this->loadModel('ManageInventory');
            $this->loadModel('User');
            $this->loadModel('Comment');
            $this->loadModel('SiteSetting');
            $this->loadModel('Payment');
            
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            $shipping_time= Configure::read('SHIPPING_TIME');
            $processing_time= Configure::read('PROCESSING_TIME');
            $temp_cart_id=  base64_decode($temp_id);
            $TotalOrderAmt=0;
            $options_cart = array('conditions' => array('TempCart.id' => $temp_cart_id));
            $cart = $this->TempCart->find('first', $options_cart);
            if(count($cart)>0){
                $TempCartPay_key=$cart['TempCart']['pay_key'];
            }else{
                $this->Session->setFlash('The order has been placed successfully.', 'default', array('class' => 'success'));
                return $this->redirect(array('controller' => 'orders', 'action' => 'all_order'));
            }
            $paykey=isset($TempCartPay_key)?$TempCartPay_key:'';
            $pay_key_exist=$this->Order->find('first',array('conditions'=>array('Order.pay_key'=>$paykey)));
            
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
            //require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'Common'.DS.'Constants.php');
            $requestEnvelope = new RequestEnvelope("en_US");
            $paymentDetailsReq = new PaymentDetailsRequest($requestEnvelope);
            $paymentDetailsReq->payKey = $paykey;
            $service_payment = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            $response = $service_payment->PaymentDetails($paymentDetailsReq);
            $ack = $response->responseEnvelope->ack;
            //pr($response);
            //exit();
            if($ack=='Success' && empty($pay_key_exist)){
                if ($this->Session->check('paypal_custom')) {
                    $paypal_custom = $this->Session->read('paypal_custom');
                    $this->Session->delete('paypal_custom');
                }
                $TransactionID=$response->paymentInfoList->paymentInfo[0]->transactionId;
                $PayTotAmt=$response->paymentInfoList->paymentInfo[0]->receiver->amount;
                $BuyerTotAmt=$response->paymentInfoList->paymentInfo[1]->receiver->amount;
                $order_msg='';
                if ($this->Session->check('user_msg')) {
                    $order_msg = $this->Session->read('user_msg');
                    $this->Session->delete('user_msg');
                }
                $options = array('conditions' => array('User.id' => $userid));
                $orderBy = $this->User->find('first', $options);
                
                $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                $sitesetting = $this->SiteSetting->find('first', $options_set);

                $admin_percentage=$sitesetting['SiteSetting']['admin_percentage'];
                $PayPalFeesPercentage=Configure::read('PayPalFeesPercentage');
                $PayPalFeesStatic=Configure::read('PayPalFeesStatic');
                
                $custom = $paypal_custom;
                $TempCartIdArr=array();
                if($custom!=''){ 
                    $exp_custom = explode('###',$custom);
                    if($exp_custom[0]!=''){
                        $store_exp = explode('@@@@',$exp_custom[0]);
                        if($store_exp){
                            foreach($store_exp as $store_val){
                                if($store_val!=''){
                                    $ExpStrIdStr = explode('_',$store_val);
                                    if(!empty($ExpStrIdStr)){
                                        $getTempCartId=$ExpStrIdStr[0];
                                        array_push($TempCartIdArr,$getTempCartId);
                                        $options_cart = array('conditions' => array('TempCart.id' => $getTempCartId));
                                        $get_cart_data = $this->TempCart->find('first', $options_cart);
                                        //$get_shop_id=$get_cart_data['TempCart']['shop_id'];
                                        //$get_product_woner_id= $get_cart_data['TempCart']['product_woner_id'];
                                        //$get_paypal_fee= $get_cart_data['TempCart']['paypal_fee'];
                                        //$get_admin_percentage= $get_cart_data['TempCart']['admin_percentage'];
                                    }
                                }
                            }
                        }
                    }
                }
                
                $shipping_address='';
                $options_spAdd = array('conditions' => array('ShippingAddress.user_id' => $userid,'ShippingAddress.is_primary' => 1));
                $get_shipping_address = $this->ShippingAddress->find('first', $options_spAdd);
                if(count($get_shipping_address)>0){
                    $Shp_name=$get_shipping_address['ShippingAddress']['full_name'];
                    $Shp_street=$get_shipping_address['ShippingAddress']['street'];
                    $Shp_apartment=$get_shipping_address['ShippingAddress']['apartment'];
                    $Shp_city=$get_shipping_address['ShippingAddress']['city'];
                    $Shp_state=$get_shipping_address['ShippingAddress']['state'];
                    $Shp_zip_code=$get_shipping_address['ShippingAddress']['zip_code'];
                    $Shp_phn_no=$get_shipping_address['ShippingAddress']['phn_no'];
                    $Shp_country=$get_shipping_address['ShippingAddress']['country'];
                    if($Shp_country==1){
                        $Country_name='Canada';
                    }else{
                        $Country_name='USA';
                    }
                    $shipping_address.=$Shp_name.'# '.$Shp_street.'# '.$Shp_apartment.'# '.$Shp_city.'# '.$Shp_state.'# '.$Shp_zip_code.'# '.$Shp_phn_no.'# '.$Country_name;
                }
                if(count($TempCartIdArr)>0){
                    $options_grp = array('fields' => array('SUM(TempCart.price * TempCart.quantity) AS total','TempCart.*'),'conditions' => array('TempCart.id' => $TempCartIdArr),'group' => 'TempCart.shop_id');
                    $TempCData = $this->TempCart->find('all', $options_grp);
                    
                    foreach($TempCData as $CartTVal){
                        $TotalAmtPerOrder=$CartTVal[0]['total'];
                        $TotalOrderAmt+=$TotalAmtPerOrder;
                        $admin_amount=(($TotalAmtPerOrder*$admin_percentage)/100);
                        $seller_amt=($TotalAmtPerOrder-$admin_amount);
                        $PayPalFeesPer=(($seller_amt*$PayPalFeesPercentage)/100);
                        $PayPalTotFees=($PayPalFeesPer+$PayPalFeesStatic);
                        $get_shop_id=$CartTVal['TempCart']['shop_id'];
                        $get_product_woner_id=$CartTVal['TempCart']['product_woner_id'];
                        
                        $this->request->data['Order']['user_id'] = $userid;
                        $this->request->data['Order']['total_amount'] = isset($TotalAmtPerOrder)?$TotalAmtPerOrder:'';
                        //$this->request->data['Order']['total_amount'] = $PayTotAmt;
                        $this->request->data['Order']['buyer_amount'] = $seller_amt;
                        $this->request->data['Order']['admin_amount'] = $admin_amount;
                        $this->request->data['Order']['paypal_fee'] = $PayPalTotFees;
                        $this->request->data['Order']['order_date'] = date('Y-m-d');
                        $this->request->data['Order']['transaction_id'] = $TransactionID;
                        $this->request->data['Order']['payment_date'] = date('Y-m-d');
                        $this->request->data['Order']['notes'] = $order_msg;
                        $this->request->data['Order']['pay_key'] = $paykey;
                        $this->request->data['Order']['store_id'] = isset($get_shop_id)?$get_shop_id:'';
                        $this->request->data['Order']['store_woner_id'] = isset($get_product_woner_id)?$get_product_woner_id:'';
                        $this->request->data['Order']['shipping_address'] = $shipping_address;
                        
                        $this->Order->create();
                        if ($this->Order->save($this->request->data)) {
                            $orderId = $this->Order->getLastInsertId();
                            $NewOrderId=($Ord_sl_no+$orderId);
                            //$custom = $_POST['custom'];
                            $options_plist = array('conditions' => array('TempCart.id' => $TempCartIdArr,'TempCart.shop_id' => $get_shop_id));
                            $lists = $this->TempCart->find('all', $options_plist);
                            if(count($lists)>0){
                                foreach($lists as $Temp_cart_det){
                                    $tempCartId=$Temp_cart_det['TempCart']['id'];
                                    if($Temp_cart_det['TempCart']['prd_id']!=''){
                                        $options_prd = array('conditions' => array('Product.id' => $Temp_cart_det['TempCart']['prd_id']));
                                        $listing = $this->Product->find('first', $options_prd);
                                        $previous_prd_qty=$listing['Product']['quantity'];
                                        $prd_shipping_time=$listing['Product']['shipping_time'];
                                        $prd_processing_time=$listing['Product']['processing_time'];
                                        $prd_sold_quantity=$listing['Product']['sold_quantity'];
                                        //$delivery_date=gmdate('Y-m-d H:i:s');
                                        $Add_no_of_days=0;
                                        if($prd_shipping_time!=''){
                                            $add_shipping_time=isset($shipping_time[$prd_shipping_time])?$shipping_time[$prd_shipping_time]:0;
                                            $Add_no_of_days+=$add_shipping_time;
                                        }
                                        if($prd_processing_time!=''){
                                            $add_processing_time=isset($processing_time[$prd_processing_time])?$processing_time[$prd_processing_time]:0;
                                            $Add_no_of_days+=$add_processing_time;
                                        }

                                        $delivery_date=gmdate('Y-m-d H:i:s', strtotime("+".$Add_no_of_days." days"));

                                        $coupon_id=$Temp_cart_det['TempCart']['coupon_id'];
                                        $data['OrderDetail']['user_id'] = $userid;
                                        $data['OrderDetail']['order_id'] = $orderId;
                                        $data['OrderDetail']['product_id'] = $Temp_cart_det['TempCart']['prd_id'];
                                        $data['OrderDetail']['shop_id'] = $Temp_cart_det['TempCart']['shop_id'];
                                        $data['OrderDetail']['owner_id'] = $Temp_cart_det['TempCart']['product_woner_id'];
                                        $data['OrderDetail']['price'] = $Temp_cart_det['TempCart']['price'];
                                        $data['OrderDetail']['quantity'] = $Temp_cart_det['TempCart']['quantity'];
                                        $data['OrderDetail']['shipping_cost'] = 0;
                                        //$data['OrderDetail']['amount'] = ($listId[1]*$listing['Product']['price_lot']);
                                        $data['OrderDetail']['amount'] = ($Temp_cart_det['TempCart']['price']*$Temp_cart_det['TempCart']['quantity']);
                                        //$data['OrderDetail']['amount'] = $Temp_cart_det['TempCart']['pay_amt'];
                                        $data['OrderDetail']['order_status'] = 'U';
                                        $data['OrderDetail']['coupon_id'] = $coupon_id;
                                        $data['OrderDetail']['delivery_date'] = $delivery_date;

                                        $this->OrderDetail->create();
                                        $this->OrderDetail->save($data);
                                        $orderdetailId = $this->OrderDetail->getLastInsertId();
                                        $CouponPercentageStr='';
                                        if($coupon_id!=''){
                                            $ExpCouponID =  explode(',', $coupon_id);
                                            if(count($ExpCouponID)>0){
                                                foreach($ExpCouponID as $valCid){
                                                    if($valCid!=''){
                                                        $data_coupon['CouponUse']['user_id'] = $userid;
                                                        $data_coupon['CouponUse']['coupon_id'] = $valCid;
                                                        $data_coupon['CouponUse']['use_date'] = gmdate('Y-m-d');
                                                        $data_coupon['CouponUse']['prd_id'] = $Temp_cart_det['TempCart']['prd_id'];
                                                        $data_coupon['CouponUse']['order_id'] = $orderdetailId;
                                                        $this->CouponUse->create();
                                                        $this->CouponUse->save($data_coupon);
                                                        $options_per = array('conditions' => array('Coupon.id' => $valCid));
                                                        $coupon_per = $this->Coupon->find('first', $options_per);
                                                        $CouponPercentageStr.=$coupon_per['Coupon']['amount'].', ';
                                                    }
                                                }
                                            }
                                        }
                                        $data_per['OrderDetail']['id'] = $orderdetailId;
                                        $data_per['OrderDetail']['coupon_percentage'] = $CouponPercentageStr;
                                        $this->OrderDetail->save($data_per);

                                        //delete inventory form stock
                                        $TempCart_quantity=$Temp_cart_det['TempCart']['quantity'];
                                        $data_prd['Product']['id'] = $Temp_cart_det['TempCart']['prd_id'];
                                        $data_prd['Product']['quantity'] = ($previous_prd_qty-$TempCart_quantity);
                                        $data_prd['Product']['sold_quantity'] = ($prd_sold_quantity+$TempCart_quantity);
                                        $this->Product->save($data_prd);

                                        //Insert inventory stock into table
                                        $inventory_data['ManageInventory']['product_id'] = $Temp_cart_det['TempCart']['prd_id'];
                                        $inventory_data['ManageInventory']['order_id'] = $orderId;
                                        $inventory_data['ManageInventory']['order_details_id'] = $orderdetailId;
                                        $inventory_data['ManageInventory']['quantity'] = $TempCart_quantity;
                                        $inventory_data['ManageInventory']['price'] = $Temp_cart_det['TempCart']['price'];
                                        $inventory_data['ManageInventory']['type'] = '-';
                                        $inventory_data['ManageInventory']['comment'] = 'Product purchase by '.$orderBy['User']['first_name'].' '.$orderBy['User']['last_name'];
                                        $inventory_data['ManageInventory']['user_id'] = $userid;
                                        $inventory_data['ManageInventory']['create_date'] = gmdate('Y-m-d H:i:s');
                                        $this->ManageInventory->create();
                                        $this->ManageInventory->save($inventory_data);

                                        // delete temp cart data
                                        $this->TempCart->id = $tempCartId;
                                        $this->TempCart->delete($tempCartId);

                                        /*******/
                                        $contact_email = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1), 'fields' => array('SiteSetting.contact_email')));
                                        if($contact_email){
                                            $adminEmail = $contact_email['SiteSetting']['contact_email'];
                                        } else {
                                            $adminEmail = 'admin@twop.com';
                                        }

                                        $options = array('conditions' => array('User.id' => $listing['Product']['user_id']));
                                        $shopOwner = $this->User->find('first', $options);
                                        #pr($lastInsetred);
                                        $link = Configure::read('SITE_URL').'order_details/index/'.base64_encode($orderdetailId);
                                        $msg_body = 'Hi '.$listing['User']['first_name'].'<br/><br/>You have received a new Order. The Order ID is '.$NewOrderId.'. Please Login to your dashborad and click on the link below to view the Order details.<br/><a href="'.$link.'">Click Here</a> <br/><br/>Thanks,<br/>TWOP';

                                        App::uses('CakeEmail', 'Network/Email');

                                        $Email = new CakeEmail();

                                        /* pass user input to function */
                                        $Email->emailFormat('both');
                                        $Email->from(array($adminEmail => 'TWOP'));
                                        $Email->to($listing['User']['email']);
                                        $Email->subject('TWOP New Order Received');
                                        $Email->send($msg_body);
                                        /*******/

                                    }
                                }

                                /***Email TO Admin****/
                                //$link = Configure::read('SITE_URL').'admin/order_details/index/'.$orderId;
                                $msg_body = 'Hi Admin,<br/><br/>TWOP has received a new Order. The Order ID is '.$NewOrderId.'. Please Login to admin panel.<br/>  <br/><br/>Thanks,<br/>TWOP';
                                App::uses('CakeEmail', 'Network/Email');
                                $Email = new CakeEmail();
                                /* pass user input to function */
                                $Email->emailFormat('both');
                                $Email->from(array($orderBy['User']['email'] => 'TWOP'));
                                $Email->to($adminEmail);
                                $Email->subject('TWOP New Order Received');
                                $Email->send($msg_body);
                                /***Email TO Admin****/

                                /***Email TO User****/
                                $msg_body1 = 'Hi '.$orderBy['User']['first_name'].',<br/><br/>Your Order has been successfully placed. You will receive email once your Order is shipped.<br/><br/>Thanks,<br/>TWOP';
                                App::uses('CakeEmail', 'Network/Email');
                                $Email = new CakeEmail();
                                /* pass user input to function */
                                $Email->emailFormat('both');
                                $Email->from(array($adminEmail => 'TWOP'));
                                $Email->to($orderBy['User']['email']);
                                $Email->subject('TWOP Order Placed');
                                $Email->send($msg_body1);
                                /***Email TO User****/
                            }

                            //Insert Inbox Message 
                            $comment_data['Comment']['user_id'] = $userid;
                            $comment_data['Comment']['to_user_id'] = $get_product_woner_id;
                            $comment_data['Comment']['comment_type'] = 0;
                            $comment_data['Comment']['is_notification'] = 1;
                            $comment_data['Comment']['order_id'] = $orderId;
                            $comment_data['Comment']['order_details_id'] = 0;
                            $comment_data['Comment']['subject'] = 'New Order Placed. Order ID: '.$NewOrderId;
                            $comment_data['Comment']['comments'] = 'You have received a new Order. The Order ID is '.$NewOrderId.'.';
                            $comment_data['Comment']['cdate'] = gmdate('Y-m-d H:i:s');

                            $this->Comment->create();			 
                            $this->Comment->save($comment_data);
                            $Comment_id=$this->Comment->getLastInsertId();
                            if($Comment_id!=''){
                                $CommentUpdata['Comment']['id']=$Comment_id;
                                $CommentUpdata['Comment']['thread_id']=$Comment_id;
                                $this->Comment->save($CommentUpdata);
                            }
                            //$this->Session->setFlash('The order has been placed successfully.', 'default', array('class' => 'success'));
                        } /*else {
                            $this->Session->setFlash(__('The order could not be placed. Please, try again.'));
                            return $this->redirect(array('controller' => 'users', 'action' => 'index'));
                        }*/
                        $payment_arr1['Payment']['userid']= $get_product_woner_id;
                        $payment_arr1['Payment']['amount']= $seller_amt;
                        $payment_arr1['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                        $payment_arr1['Payment']['transaction_id']= $TransactionID;
                        $payment_arr1['Payment']['for']= "credited amount for new order";
                        $payment_arr1['Payment']['status']= "Completed";
                        $payment_arr1['Payment']['type'] = 1;
                        $this->Payment->create();
                        $this->Payment->save($payment_arr1);
                    }
                    
                    $arr1 = array();
                    $arr1['Payment']['userid']= $userid;
                    $arr1['Payment']['amount']= $TotalOrderAmt;
                    $arr1['Payment']['datetime']= gmdate('Y-m-d H:i:s');
                    $arr1['Payment']['transaction_id']= $TransactionID;
                    $arr1['Payment']['for']= "debited for product purchase";
                    $arr1['Payment']['status']= "Completed";
                    $arr1['Payment']['type'] = 2;
                    $this->Payment->create();
                    $this->Payment->save($arr1);
                    ///////// Send Email
                    $this->Session->setFlash('The order has been placed successfully.', 'default', array('class' => 'success'));
                    return $this->redirect(array('controller' => 'orders', 'action' => 'all_order'));
                }
            } else {
                $this->Session->setFlash(__('The order could not be placed. Please, try again.'));
                //echo '3 Pay key Not found';
                //exit();
                return $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
	}
        
        public function billing_report() {
            $title_for_layout = 'Billing Report';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Payment');
            if ($this->request->is(array('post', 'put'))) {
                $from_date=$this->request->data['from_date'];
                $to_date=$this->request->data['to_date'];
                $QueryStr="(Payment.userid = '".$userid."' AND Payment.type = '1')";
                if($from_date!='' && $to_date==''){
                    $QueryStr.=" AND (Payment.datetime >= '".$from_date."')";
                }
                if($from_date=='' && $to_date!=''){
                    $QueryStr.=" AND (Payment.datetime <= '".$to_date."')";
                }
                if($from_date!='' && $to_date!=''){
                    $QueryStr.=" AND (Payment.datetime BETWEEN '".$from_date."' AND '".$to_date."')";
                }
                
                $options_bill = array('conditions' => array($QueryStr), 'order' => array('Payment.datetime' => 'desc'));
                
            }else{
                $options_bill = array('conditions' => array('Payment.userid' => $userid, 'Payment.type' => 1), 'order' => array('Payment.datetime' => 'desc'));
                $from_date='';
                $to_date='';
            }
            
            $this->Paginator->settings = $options_bill;
            $billing_list=$this->Paginator->paginate('Payment');
            $this->set(compact('title_for_layout','billing_list','from_date','to_date'));
	}

        public function buyer_billing_report() {
            $title_for_layout = 'Billing Report';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Payment');
            if ($this->request->is(array('post', 'put'))) {
                $from_date=$this->request->data['from_date'];
                $to_date=$this->request->data['to_date'];
                $QueryStr="(Payment.userid = '".$userid."' AND Payment.type = '2')";
                if($from_date!='' && $to_date==''){
                    $QueryStr.=" AND (Payment.datetime >= '".$from_date."')";
                }
                if($from_date=='' && $to_date!=''){
                    $QueryStr.=" AND (Payment.datetime <= '".$to_date."')";
                }
                if($from_date!='' && $to_date!=''){
                    $QueryStr.=" AND (Payment.datetime BETWEEN '".$from_date."' AND '".$to_date."')";
                }
                
                $options_bill = array('conditions' => array($QueryStr), 'order' => array('Payment.datetime' => 'desc'));
                
            }else{
                $options_bill = array('conditions' => array('Payment.userid' => $userid, 'Payment.type' => 2), 'order' => array('Payment.datetime' => 'desc'));
                $from_date='';
                $to_date='';
            }
            
            $this->Paginator->settings = $options_bill;
            $billing_list=$this->Paginator->paginate('Payment');
            $this->set(compact('title_for_layout','billing_list','from_date','to_date'));
	}
        
        public function test_confirm($temp_id=null){
            $this->autoRender = false;
            $userid = $this->Session->read('Auth.User.id');
            $paykey=$this->Session->read('user_msg_pay_key');
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
            //require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'Common'.DS.'Constants.php');
            $requestEnvelope = new RequestEnvelope("en_US");
            $paymentDetailsReq = new PaymentDetailsRequest($requestEnvelope);
            $paymentDetailsReq->payKey = $paykey;
            $service_payment = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            $response = $service_payment->PaymentDetails($paymentDetailsReq);
            $ack = $response->responseEnvelope->ack;
            pr($response);
            exit();
        }
        
        public function test_seller_cancel_order() {
            $this->autoRender = false;
            $paykey=$this->Session->read('user_msg_pay_key');
            if($paykey!=''){
                require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
                $refundRequest = new RefundRequest(new RequestEnvelope("en_US"));
                $refundRequest->currencyCode = 'USD';
                $refundRequest->payKey = $paykey;

                $receiver = array();
                $receiver[0] = new Receiver();
                $receiver[0]->email = 'nits.suman_twop@gmail.com';
                $receiver[0]->amount = floor(7);
                $receiver[0]->primary = "true";
                $receiver[0]->paymentType = "SERVICE";

                $receiver[1] = new Receiver();
                $receiver[1]->email = 'nits.twop_seller@gmail.com';
                //$receiver[1]->email = 'nits.sumansamanta-facilitator@gmail.com';
                $receiver[1]->amount = floor(5);
                $receiver[1]->primary = "false";
                $receiver[1]->paymentType = "SERVICE";

                $receiverList = new ReceiverList($receiver);
                $refundRequest->receiverList = $receiverList;

                $PayPalService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
                $PayPalResult = $PayPalService->Refund($refundRequest);
                $PayPalAck = $PayPalResult->responseEnvelope->ack;
                $EncryptedTransactionID=$PayPalResult->responseEnvelope->correlationId;
                pr($PayPalResult);
                exit();
            }
        }
        
	public function cancel(){
            $this->Session->setFlash(__('The order could not be placed. Please, try again.'));
            return $this->redirect(array('controller' => 'users', 'action' => 'index'));
	}

        public function coupon_details($coupon_id=null,$price=null) {
            $this->loadModel('Coupon');
            
            $data=array();
            $options_coupon = array('conditions' => array('Coupon.id' => $coupon_id));
            $coupon = $this->Coupon->find('first', $options_coupon);
            $Total_deuct=0;
            if(count($coupon)>0){
                $coupon_code=$coupon['Coupon']['coupon_code'];
                $amount=$coupon['Coupon']['amount'];
                if($amount>0){
                    $CalPrice=($price*$amount)/100;
                    $Total_deuct+=$CalPrice;
                }
                $data['deduct_amt']=$Total_deuct;
                $data['coupon_name']=$coupon_code;
            }
            return $data;
        }
        
	public function admin_paynow($order_id = null){
		$this->Order->id = $order_id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$settings = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1)));
		#pr($settings);
		$Item=array();
		$MPItems=array();
		$i=0;
		$has_partner=false;
		$this->Order->recursive = -1;
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $order_id));
		$order = $this->Order->find('first', $options);
		if($order){
			$this->User->recursive = -1;
			$options = array('conditions' => array('User.id' => $order['Order']['user_id']), 'fields' => array('User.referrer_id'));
			$referrer = $this->User->find('first', $options);
			if($referrer){
				#pr($referrer);
				#$this->User->recursive = -1;
				$options = array('conditions' => array('User.id' => $referrer['User']['referrer_id'],'User.is_active' => 1,'User.is_partner' => 1), 'fields' => array('User.id','User.is_partner','User.is_active','User.partnership_start_date','User.partnership_end_date'));
				$partnersDetails = $this->User->find('first', $options);
				#pr($partnersDetails);
				if($partnersDetails){
					if($partnersDetails['User']['partnership_end_date']>=$order['Order']['payment_date']){
						$has_partner = true;						
					}
				}
			}

			$partner_commission = 0.00;
			$this->OrderDetail->recursive = -1;
			$options = array('conditions' => array('OrderDetail.order_id' => $order_id));
			$orderDetails = $this->OrderDetail->find('all', $options);
			#pr($orderDetails);
			if($orderDetails){
				foreach($orderDetails as $data)
				{
					$this->UserPaymentDetail->recursive = -1;
					$options = array('conditions' => array('UserPaymentDetail.user_id' => $data['OrderDetail']['owner_id']));
					$userPaymentdetail = $this->UserPaymentDetail->find('first', $options);
					if($userPaymentdetail){						
						if($has_partner==true){
							$admin_commission=((($data['OrderDetail']['amount'])*($settings['SiteSetting']['admin_percentage']))/100);
							$price_paid=($data['OrderDetail']['amount']-$admin_commission);
							
							$partner_commission=$partner_commission + ((($data['OrderDetail']['amount'])*($settings['SiteSetting']['partner_percentage']))/100);

						} else {							
							$admin_commission=((($data['OrderDetail']['amount'])*($settings['SiteSetting']['admin_percentage']))/100);
							$price_paid=($data['OrderDetail']['amount']-$admin_commission);
						}
						$Item[$i] = array(
									'l_email' => $userPaymentdetail['UserPaymentDetail']['paypal_email'], 							
									'l_receiverid' => '', 						
									'l_amt' => $price_paid, 			
									'l_uniqueid' => $userPaymentdetail['UserPaymentDetail']['user_id'], 						
									'l_note' => 'ShopOwner_'.$order_id 								
							);
						$i++;
					}
				}
			}
			if($has_partner==true){
				$this->UserPaymentDetail->recursive = -1;
				$options = array('conditions' => array('UserPaymentDetail.user_id' => $partnersDetails['User']['id']));
				$partnerPaymentdetail = $this->UserPaymentDetail->find('first', $options);
				if($partnerPaymentdetail){
					#pr($partnerPaymentdetail);
					$count = count($Item);
					$Item[$count] = array(
								'l_email' => $partnerPaymentdetail['UserPaymentDetail']['paypal_email'], 							
								'l_receiverid' => '', 						
								'l_amt' => $partner_commission, 			
								'l_uniqueid' => $partnerPaymentdetail['UserPaymentDetail']['user_id'], 						
								'l_note' => 'Partner_'.$order_id 								
						);
				}
			}
			#pr($Item);
			$MPItems = $Item;
		}
		#pr($order);
		$this->set(compact('settings','order','orderDetails','MPItems'));
	}

	public function admin_payments($payments = null){
		$PayPalResult = base64_decode($payments);
		$PayPalResult = unserialize($PayPalResult);
		#pr($PayPalResult);
		$contact_email = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1), 'fields' => array('SiteSetting.contact_email')));
		if($contact_email){
			$adminEmail = $contact_email['SiteSetting']['contact_email'];
		} else {
			$adminEmail = 'admin@twop.com';
		}
		if($PayPalResult){
			if($PayPalResult['ACK']=='Success'){
				$i=0;
				for($i=0;$i<15;$i++){
					if(isset($PayPalResult['REQUESTDATA']['L_EMAIL'.$i])){
						$order = explode('_',$PayPalResult['REQUESTDATA']['L_NOTE'.$i]);
						if($order){
							$orderId = $order[1];
							$note = $order[0];
						} else{
							$orderId = 0;
							$note = '';
						}
						$options = array('conditions' => array('User.id' => $PayPalResult['REQUESTDATA']['L_UNIQUEID'.$i]));
						$userDetails = $this->User->find('first', $options);
						if($userDetails){
							$this->request->data['PartnershipDetail']['user_id'] = $PayPalResult['REQUESTDATA']['L_UNIQUEID'.$i];
							$this->request->data['PartnershipDetail']['order_id'] = $orderId;
							$this->request->data['PartnershipDetail']['amount_received'] = $PayPalResult['REQUESTDATA']['L_AMT'.$i];
							$this->request->data['PartnershipDetail']['payment_type'] = $note;
							$this->PartnershipDetail->create();
							$this->PartnershipDetail->save($this->request->data);
							if($note=='ShopOwner'){
								$msg_body = 'Hi '.$userDetails['User']['first_name'].'<br/><br/>You just received a payment from TWOP of amount $'.$PayPalResult['REQUESTDATA']['L_AMT'.$i].' for <strong>Order Id '.$orderId.'<strong> as the Shop Owner.<br/><br/>Thanks,<br/>TWOP';
							} else {
								$msg_body = 'Hi '.$userDetails['User']['first_name'].'<br/><br/>You just received a payment from TWOP of amount $'.$PayPalResult['REQUESTDATA']['L_AMT'.$i].' for <strong>Order Id '.$orderId.'<strong> as the Partner.<br/><br/>Thanks,<br/>TWOP';
							}
							App::uses('CakeEmail', 'Network/Email');
							$Email = new CakeEmail();
							$Email->emailFormat('both');
							$Email->from(array($adminEmail => 'TWOP'));
							$Email->to($PayPalResult['REQUESTDATA']['L_EMAIL'.$i]);
							$Email->subject('TWOP Payments Received');
							$Email->send($msg_body);
							
							$this->request->data['Order']['id'] = $orderId;
							$this->request->data['Order']['admin_paid'] = 1;
							$this->Order->save($this->request->data);
						}
					}
				}

				$this->Session->setFlash(__('Payment was done successfully.'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('Sorry the payment was not successfully. Please, try again.'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'index'));
			}
		}
		exit;
	}
        
        public function admin_order_list($type=null){
            $this->loadModel('Order');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/admin');
            }
            $title_for_layout = 'Order History';
            $QueryStr="(Order.user_id !='0')";
            
           
            
            if ($this->request->is(array('post', 'put'))) {
                $Ord_sl_no= Configure::read('ORDER_SL_NO');
                $order_no=$this->request->data['order_no'];
                $product_name=$this->request->data['coupon_name'];
                $product_sku=$this->request->data['coupon_code'];
                
                if($order_no!=''){
                    $new_order_no=$order_no-$Ord_sl_no;
                    $QueryStr.=" AND (Order.id = '".$new_order_no."')";
                }
                if($product_name!=''){
                    $QueryStr.=" AND (Coupon.name LIKE '%".$product_name."%')";
                }
                if($product_sku!=''){
                    $QueryStr.=" AND (Order.coupon_code LIKE '%".$product_sku."%')";
                }
                
                
                $options = array('conditions' => array($QueryStr), 'order' => array('Order.id' => 'desc'));
            }else{
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array($QueryStr), 'order' => array('Order.id' => 'desc'));
                $order_no='';
                $product_name='';
                $product_sku='';
                
            }
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('Order');
            $this->set(compact('orders','title_for_layout','order_no','product_name','product_sku'));
	}
        
        public function admin_order_details($id=null) {
            
            $this->loadModel('Order');
            
            
            $userid = $this->Session->read('Auth.User.id');
            $Ord_sl_no= Configure::read('ORDER_SL_NO');
            if(!isset($userid)){
                $this->redirect('/admin');
            }
            $title_for_layout = 'Order Details';
            $ord_id=  base64_decode($id);
            if($ord_id==''){
                return $this->redirect(array('action' => 'admin_order_list'));
            }
            
            $orderdetail = $this->Order->find('first',array('conditions' => array('Order.id'=>$ord_id),'order' => array('Order.id' => 'desc')));
            if(count($orderdetail)==0){
                return $this->redirect(array('action' => 'admin_order_list'));
            }
            //$order_data = $this->Order->find('first',array('conditions' => array('Order.id'=>$ord_id)));
            $this->set(compact('orderdetail','title_for_layout'));
	}
        
        public function date_different($date1 = null, $date2 = null){
            //$date1 = "2008-11-01 22:45:00"; 
            //$date2 = "2009-12-04 13:44:01"; 
            //$diff = abs(strtotime($date2) - strtotime($date1)); 
            $diff = abs($date2 - $date1); 
            $years   = floor($diff / (365*60*60*24)); 
            $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
            $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
            $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
            //return $date_str = $days." Days, ".$hours." hours, ".$minuts." minuts, ".$seconds." seconds";
            return $date_str = $days." Days ";
            ///printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
        }
        
        public function date_different_day($date1 = null, $date2 = null){
            //$date1 = "2008-11-01 22:45:00";
            //$date2 = "2009-12-04 13:44:01";
            //$diff = abs(strtotime($date2) - strtotime($date1));
           // echo $date1;
           //exit;
            $diff = abs($date2 - $date1);
            $years   = floor($diff / (365*60*60*24));
            $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
            $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
            //return $date_str = $days." Days, ".$hours." hours, ".$minuts." minuts, ".$seconds." seconds";
            //printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
            $total_days = '';
            if($years != 0){
                $total_days .=$years." Years, ";
            }
            if($months != 0){
                $total_days .=$months." Months, ";
            }
            if($days != 0){
                $total_days .=$days." Days, ";
            }
            //return $date_str = $years." Years, ".$months." Months";
            return rtrim($total_days,', ');

        }
        
        public function extend_processing_time_data($ord_det_id = null){
            $this->loadModel('ExtendProcessingTime');
            return $GetProcessing_data = $this->ExtendProcessingTime->find('first',array('conditions' => array('ExtendProcessingTime.order_details_id'=>$ord_det_id), 'order' => array('ExtendProcessingTime.id' => 'desc')));
        }
        
        public function save_folder_name(){
            $this->autoRender = false;
            $this->loadModel('MailFolder');
            $text_folder_name=trim($this->request->data['text_folder_name']);
            $userid = $this->Session->read('Auth.User.id');
            if($userid!=''){
                $check_folder_name = $this->MailFolder->find('first', array('conditions' => array('MailFolder.user_id' => $userid, 'MailFolder.folder_name' => $text_folder_name)));
                if(count($check_folder_name)>0){
                    $Data_str='0| Folder name already exist.';
                }else{
                    if($text_folder_name!=''){
                        $comment_data['MailFolder']['user_id'] = $userid;
                        $comment_data['MailFolder']['folder_name'] = $text_folder_name;
                        $comment_data['MailFolder']['status'] = 1;
                        $comment_data['MailFolder']['cdate'] = gmdate('Y-m-d H:i:s');
                        $this->MailFolder->create();			 
                        $this->MailFolder->save($comment_data);
                        $MailFolderId=$this->MailFolder->getInsertID();
                        $Data_str='1|'.$MailFolderId;
                    }else{
                        $Data_str='0| Please enter folder name.';
                    }
                }
            }else{
                $Data_str='0| Please login first.';
            }
            echo $Data_str;
	}
        
        public function get_folder_details($folder_id = null){
            $this->autoRender = false;
            $this->loadModel('MailFolder');
            return $GetProcessing_data = $this->MailFolder->find('first',array('conditions' => array('MailFolder.id'=>$folder_id)));
        }
        
        
	public function create_pdf(){
            $this->autoRender = false;
           $userid = $this->Session->read('Auth.User.id');
           // $this->loadModel('Booking');
            $title_for_layout = 'Print PDF';
            if (!$userid) {
		$this->Session->setFlash(__('Please Login to print '));
                $this->redirect('/');
            }
          
            if($this->request->is('post'))
	    {
	   
            $invoice_html=$this->request->data['pdfhtml'];
         
                require_once(ROOT . '/app/Vendor' . DS  . 'savepdf'.DS.'dompdf_config.inc.php');
                $CompareStrHtml=isset($invoice_html)?$invoice_html:'';
                if ($CompareStrHtml!='') {
                    $PostHtml = stripslashes($CompareStrHtml);
                    $dompdf = new DOMPDF();
                    $dompdf->load_html($PostHtml);
                    //$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
                    $dompdf->render();
                    $dompdf->stream("billing.pdf", array("Attachment" => false));
                    //$dompdf->stream("billing_report.pdf");
                    exit(0);
                }
                //$this->Session->setFlash(__('You have successfully send request for release payment.'));
              //  $this->set(compact('userid','title_for_layout','book','invoice_html'));
           // }
	    /*else{
                $this->Session->setFlash('The invalid booking.', 'default', array('class' => 'error'));
                return $this->redirect(array('controller' => 'users', 'action' => 'bookingmade'));
            }*/
	    }
	}
}
