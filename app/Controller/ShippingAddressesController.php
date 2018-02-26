<?php
App::uses('AppController', 'Controller');
/**
 * ShippingAddresses Controller
 *
 * @property ShippingAddress $ShippingAddress
 * @property PaginatorComponent $Paginator
 */

use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\FundingConstraint;
use PayPal\Types\AP\FundingTypeInfo;
use PayPal\Types\AP\FundingTypeList;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\AP\SenderIdentifier;
use PayPal\Types\AP\ExecutePaymentRequest;
use PayPal\Types\Common\PhoneNumberType;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\PaymentDetailsRequest;

class ShippingAddressesController extends AppController {

/**
 * Components
 *
 * @var array
 */
    
    
public function beforeFilter() {
	    parent::beforeFilter();
	     
	    $this->Auth->allow('purchase_payment','brain_tree_payment','delete','delete_billing_address');
	}    
    
	public $components = array('Session','Paginator');
	var $uses = array('ShippingAddress','Country','User','SiteSetting');

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $this->ShippingAddress->recursive = 0;
            $this->set('shippingAddresses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            if (!$this->ShippingAddress->exists($id)) {
                throw new NotFoundException(__('Invalid shipping address'));
            }
            $options = array('conditions' => array('ShippingAddress.' . $this->ShippingAddress->primaryKey => $id));
            $this->set('shippingAddress', $this->ShippingAddress->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                    $this->redirect('/');
            }
            $options = array('conditions' => array('ShippingAddress.user_id'  => $userid));
            $userbillingaddressisThere = $this->ShippingAddress->find('all', $options);
            #pr($userbillingaddressisThere);
            
            if ($this->request->is('post')) {
                $default_add=$this->request->data['ShippingAddress']['is_primary'];
                if(count($userbillingaddressisThere)>0 && $default_add==1){
                    foreach($userbillingaddressisThere as $val){
                        $data_bill['ShippingAddress']['id']=$val['ShippingAddress']['id'];
                        $data_bill['ShippingAddress']['is_primary']=0;
                        $this->ShippingAddress->save($data_bill);
                    }
                }
                $this->request->data['ShippingAddress']['user_id'] = $userid;
                $this->ShippingAddress->create();
                
                if ($this->ShippingAddress->save($this->request->data)) {
                    
                    
                    $this->loadModel('BillingAddress');
                    $this->request->data['BillingAddress']['user_id'] = $userid;
                    $this->request->data['BillingAddress']['full_name'] = $this->request->data['ShippingAddress']['full_name'];
                    $this->request->data['BillingAddress']['street'] = $this->request->data['ShippingAddress']['street'];
                    $this->request->data['BillingAddress']['apartment'] = $this->request->data['ShippingAddress']['apartment'];
                    $this->request->data['BillingAddress']['city'] = $this->request->data['ShippingAddress']['city'];
                    $this->request->data['BillingAddress']['state'] = $this->request->data['ShippingAddress']['state'];
                    $this->request->data['BillingAddress']['zip_code'] = $this->request->data['ShippingAddress']['zip_code'];
                    $this->request->data['BillingAddress']['phn_no'] = $this->request->data['ShippingAddress']['phn_no'];
                    $this->request->data['BillingAddress']['country'] = $this->request->data['ShippingAddress']['country'];
                    $this->request->data['BillingAddress']['is_primary'] = $this->request->data['ShippingAddress']['is_primary'];
                    
                    $this->BillingAddress->create();
                    $this->BillingAddress->save($this->request->data);
                    
                    
                    
                    
                    
                    //$id = $this->ShippingAddress->getLastInsertID();
                    $this->Session->setFlash('The shipping address has been saved.', 'default', array('class' => 'success'));
                    #return $this->redirect(array('action' => 'index'));
                    //return $this->redirect(array('action' => 'edit',$id));
                } else {
                    $this->Session->setFlash(__('The shipping address could not be saved. Please, try again.'));
                }
            }
            //$countries = $this->Country->find('list',array('fields' => array('Country.name')));
            //$this->set(compact('countries'));
            return $this->redirect(array('controller' => 'shipping_addresses', 'action' => 'review'));
	}
        
        
        public function add_billing_address() {
            $this->loadModel('BillingAddress');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                    $this->redirect('/');
            }
            $options = array('conditions' => array('BillingAddress.user_id'  => $userid));
            $userbillingaddressisThere = $this->BillingAddress->find('all', $options);
            #pr($userbillingaddressisThere);
            
            if ($this->request->is('post')) {
                $default_add=$this->request->data['BillingAddress']['is_primary'];
                if(count($userbillingaddressisThere)>0 && $default_add==1){
                    foreach($userbillingaddressisThere as $val){
                        $data_bill['BillingAddress']['id']=$val['BillingAddress']['id'];
                        $data_bill['BillingAddress']['is_primary']=0;
                        $this->BillingAddress->save($data_bill);
                    }
                }
                $this->request->data['BillingAddress']['user_id'] = $userid;
                $this->BillingAddress->create();
                if ($this->BillingAddress->save($this->request->data)) {
                    //$id = $this->ShippingAddress->getLastInsertID();
                    $this->Session->setFlash('The Billing address has been saved.', 'default', array('class' => 'success'));
                    #return $this->redirect(array('action' => 'index'));
                    //return $this->redirect(array('action' => 'edit',$id));
                } else {
                    $this->Session->setFlash(__('The Billing address could not be saved. Please, try again.'));
                }
            }
            //$countries = $this->Country->find('list',array('fields' => array('Country.name')));
            //$this->set(compact('countries'));
            return $this->redirect(array('controller' => 'shipping_addresses', 'action' => 'review'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid)){
			$this->redirect('/');
		}
		if (!$this->ShippingAddress->exists($id)) {
			throw new NotFoundException(__('Invalid shipping address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['ShippingAddress']['id'] = $id;
			if ($this->ShippingAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The shipping address has been saved.'));
				return $this->redirect(array('action' => 'edit',$id));
			} else {
				$this->Session->setFlash(__('The shipping address could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ShippingAddress.' . $this->ShippingAddress->primaryKey => $id));
			$this->request->data = $this->ShippingAddress->find('first', $options);
		}
		$countries = $this->Country->find('list',array('fields' => array('Country.name')));
		if ($this->Session->check('Cart')) {
                    $cart = $this->Session->read('Cart');
                }
		#pr($cart);
		$featured = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1), 'fields' => array('SiteSetting.paypal_email')));
		if($featured){
			$paypal_email = $featured['SiteSetting']['paypal_email'];
		} else {
			$paypal_email = 'nits.arpita@gmail.com';
		}
		$this->set(compact('countries','cart','paypal_email'));
                //return $this->redirect(array('controller' => 'shipping_addresses', 'action' => 'review'));
	}
        
        public function edit_address($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                    $this->redirect('/');
            }

            if ($this->request->is(array('post', 'put'))) {
                //$this->request->data['ShippingAddress']['id'] = $id;
                if ($this->ShippingAddress->save($this->request->data)) {
                    $this->Session->setFlash('The shipping address has been saved.', 'default', array('class' => 'success'));
                    //return $this->redirect(array('action' => 'edit',$id));
                } else {
                    $this->Session->setFlash(__('The shipping address could not be saved. Please, try again.'));
                }
            } 
            return $this->redirect(array('controller' => 'shipping_addresses', 'action' => 'review'));
	}
        
        public function edit_billing_address($id = null) {
            $this->loadmodel('BillingAddress');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                    $this->redirect('/');
            }

            if ($this->request->is(array('post', 'put'))) {
                //$this->request->data['ShippingAddress']['id'] = $id;
                if ($this->BillingAddress->save($this->request->data)) {
                    $this->Session->setFlash('The billing address has been saved.', 'default', array('class' => 'success'));
                    //return $this->redirect(array('action' => 'edit',$id));
                } else {
                    $this->Session->setFlash(__('The billing address could not be saved. Please, try again.'));
                }
            } 
            return $this->redirect(array('controller' => 'shipping_addresses', 'action' => 'review'));
	}
        
        public function paybypaypal(){ 
            $userid = $this->Session->read('Auth.User.id');
            $seller_business_email=$this->request->data['seller_business_email'];
            $paypal_custom=$this->request->data['paypal_custom'];
            $paypal_amount=$this->request->data['paypal_amount'];
            $this->Session->write('paypal_custom', $paypal_custom);
            $this->loadModel('SiteSetting');
            $this->loadModel('User');
            $this->loadModel('TempCart');
            $this->loadModel('Shop');
            $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
            $sitesetting = $this->SiteSetting->find('first', $options);
            
            $admin_paypal_email=$sitesetting['SiteSetting']['paypal_email'];
            $admin_percentage=$sitesetting['SiteSetting']['admin_percentage'];
            $PayPalFeesPercentage=Configure::read('PayPalFeesPercentage');
            $PayPalFeesStatic=Configure::read('PayPalFeesStatic');
            $ShopIdArr=array();
            $receiverArr=array();
            $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
            $cart = $this->TempCart->find('all', $options_cart);
            foreach($cart as $sent_val_cart){
                if($sent_val_cart['TempCart']['id']!=''){
                    $TempCartID=$sent_val_cart['TempCart']['id'];
                    $TempCartShop_id=$sent_val_cart['TempCart']['shop_id'];
                    $TempCartPrdPrice=$sent_val_cart['TempCart']['price'];
                    $TempCartQuantity=$sent_val_cart['TempCart']['quantity'];
                    $CalTotPricePerPrd=($TempCartPrdPrice*$TempCartQuantity);
                    $preShopVal=isset($ShopIdArr[$TempCartShop_id])?$ShopIdArr[$TempCartShop_id]:0;
                    $ShopIdArr[$TempCartShop_id]=$preShopVal+$CalTotPricePerPrd;
                }
            }
            
            // receiver array create
            $totalAdminAmt=0;
            if(count($ShopIdArr)>0){
                foreach($ShopIdArr as $skey => $sval){
                    if($skey!=''){
                        $options_shop = array('conditions' => array('Shop.id' => $skey));
                        $shop_data = $this->Shop->find('first', $options_shop);
                        if(count($shop_data)>0){
                            $paypal_business_email=$shop_data['User']['paypal_business_email'];
                            $admin_amount=(($sval*$admin_percentage)/100);
                            $totalAdminAmt+=$admin_amount;
                            $seller_amt=($sval-$admin_amount);
                            if($paypal_business_email!=''){
                                $receiverArr[]=array('email'=>$paypal_business_email,'amount'=>$seller_amt);
                            }
                        }
                    }
                }
            }
            
            //pr($receiverArr);
            //exit();
            $PayPalFeesPer=(($paypal_amount*$PayPalFeesPercentage)/100);
            $PayPalTotFees=($PayPalFeesPer+$PayPalFeesStatic);
            
            /*$admin_amount=(($paypal_amount*$admin_percentage)/100);
            //$seller_tot_amount=($paypal_amount-$admin_amount-$PayPalTotFees);
            $seller_tot_amount=($paypal_amount-$admin_amount);*/
            
            $siteurl= Configure::read('SITE_URL');
            
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'Common'.DS.'Constants.php');
            
            //App::import('Vendor', 'PayPal', array('file' => 'paypal'.DS.'paypal.class.php'));
            //App::import('Vendor', 'PayPal_Adaptive', array('file' => 'paypal'.DS.'paypal.adaptive.class.php'));
            
            //$paypal_mode=$sitesetting['SiteSetting']['paypal_mode'];
            
            $return_url=$siteurl.'orders/confirm/'.base64_encode($TempCartID);
            
            $receiver = array();
            $receiver[0] = new Receiver();
            $receiver[0]->email = $admin_paypal_email;
            //$receiver[0]->email = 'payments@errandchampion.com';
            //$receiver[0]->email = 'nits.arpita@gmail.com';
            $receiver[0]->amount = $paypal_amount;
            $receiver[0]->primary = "true";
            $receiver[0]->paymentType = "SERVICE";

            if(count($receiverArr)>0){
                $RcvCnt=0;
                foreach($receiverArr as $rval){
                    $RcvCnt++;
                    $receiver[$RcvCnt] = new Receiver();
                    $receiver[$RcvCnt]->email = $rval['email'];
                    $receiver[$RcvCnt]->amount = round($rval['amount'], 2);
                    $receiver[$RcvCnt]->primary = "false";
                    $receiver[$RcvCnt]->paymentType = "SERVICE";
                }
            }
            $receiverList = new ReceiverList($receiver);
            //$payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList, $_POST['returnUrl']);
            $payRequest = new PayRequest();
            $payRequest->receiverList = $receiverList;

            $requestEnvelope = new RequestEnvelope("en_US");
            $payRequest->requestEnvelope = $requestEnvelope; 
            $payRequest->actionType = "PAY";
            $payRequest->feesPayer  = "EACHRECEIVER";
            $payRequest->cancelUrl = $siteurl.'orders/cancel';
            $payRequest->returnUrl = $return_url;
            $payRequest->currencyCode = "USD";
            
            $adaptivePaymentsService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            //$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            $payResponse = $adaptivePaymentsService->Pay($payRequest); 
            
            $PayPalResult=$payResponse->responseEnvelope->ack;
            
            if($PayPalResult=='Success'){
                $Pay_key=$payResponse->payKey;
                foreach($cart as $val_cart){
                    if($val_cart['TempCart']['id']!=''){
                        $data_ord['TempCart']['id']=$val_cart['TempCart']['id'];
                        $data_ord['TempCart']['admin_percentage']=$totalAdminAmt;
                        $data_ord['TempCart']['paypal_fee']=$PayPalTotFees;
                        $data_ord['TempCart']['pay_key']=$Pay_key;
                        $this->TempCart->save($data_ord);
                    }
                }
                $pay_url=PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payResponse->payKey;
                echo 'SUCCESS|'.$pay_url;
            }else{
                $PayPalResultError=$payResponse->error[0]->message;
                echo 'Failure| '.$PayPalResultError;
            }
            exit;
        }
        
        public function test_pay_by_paypal(){ 
            
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'PPBootStrap.php');
            require_once(ROOT . '/app/Vendor' . DS  . 'Paypal_adaptive'.DS.'Common'.DS.'Constants.php');
            $siteurl= Configure::read('SITE_URL');
            $return_url=$siteurl.'orders/test_confirm/'.base64_encode(12);
            
            $receiver = array();
            $receiver[0] = new Receiver();
            $receiver[0]->email = 'nits.suman_twop@gmail.com';
            $receiver[0]->amount = 20;
            $receiver[0]->primary = "true";
            $receiver[0]->paymentType = "SERVICE";

            $receiver[1] = new Receiver();
            $receiver[1]->email = 'nits.twop_seller@gmail.com';
            $receiver[1]->amount = floor(7);
            $receiver[1]->primary = "false";
            $receiver[1]->paymentType = "SERVICE";
            
            $receiver[2] = new Receiver();
            $receiver[2]->email = 'nits.sumansamanta-facilitator@gmail.com';
            $receiver[2]->amount = floor(8);
            $receiver[2]->primary = "false";
            $receiver[2]->paymentType = "SERVICE";
            
            $receiverList = new ReceiverList($receiver);
            //$payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList, $_POST['returnUrl']);
            $payRequest = new PayRequest();
            $payRequest->receiverList = $receiverList;

            $requestEnvelope = new RequestEnvelope("en_US");
            $payRequest->requestEnvelope = $requestEnvelope; 
            $payRequest->actionType = "PAY";
            $payRequest->feesPayer  = "EACHRECEIVER";
            $payRequest->cancelUrl = $siteurl.'orders/cancel';
            $payRequest->returnUrl = $return_url;
            $payRequest->currencyCode = "USD";
            
            $adaptivePaymentsService = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            //$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            $payResponse = $adaptivePaymentsService->Pay($payRequest); 
            
            $PayPalResult=$payResponse->responseEnvelope->ack;
            
            if($PayPalResult=='Success'){
                $Pay_key=$payResponse->payKey;
                $pay_url=PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payResponse->payKey;
                $this->Session->write('user_msg_pay_key', $payResponse->payKey);
                $this->redirect($pay_url);
            }else{
                $PayPalResultError=$payResponse->error[0]->message;
                echo 'Failure| '.$PayPalResultError;
            }
            exit;
        }
        
        public function review() {
            $title_for_layout = 'Review Cart';
            $this->loadModel('TempCart');
            $this->loadModel('BillingAddress');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            /*if (!$this->ShippingAddress->exists($id)) {
                    throw new NotFoundException(__('Invalid shipping address'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    //$this->request->data['ShippingAddress']['id'] = $id;
                    if ($this->ShippingAddress->save($this->request->data)) {
                        $this->Session->setFlash(__('The shipping address has been saved.'));
                        //return $this->redirect(array('action' => 'edit',$id));
                    } else {
                        $this->Session->setFlash(__('The shipping address could not be saved. Please, try again.'));
                    }
            }*/ 
            $options_billing = array('conditions' => array('ShippingAddress.user_id' => $userid,'ShippingAddress.is_primary' => 1));
            $ShippingAdd_data = $this->ShippingAddress->find('first', $options_billing);
            
            
            
            $options_billing1 = array('conditions' => array('BillingAddress.user_id' => $userid,'BillingAddress.is_primary' => 1));
            $BillingAdd_data = $this->BillingAddress->find('first', $options_billing1);

            $countries = $this->Country->find('list',array('fields' => array('Country.name')));
            
            $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
            $cart = $this->TempCart->find('all', $options_cart);
            
            $featured = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1), 'fields' => array('SiteSetting.paypal_email')));
            if($featured){
                $paypal_email = $featured['SiteSetting']['paypal_email'];
            } else {
                $paypal_email = 'nits.arpita@gmail.com';
            }

            $this->set(compact('countries','cart','paypal_email','ShippingAdd_data','BillingAdd_data','title_for_layout','featured'));
	}
        
        public function calculate_discount($coupon_id=null,$price=null,$quantity=null,$cart_id=null) {
            $this->loadModel('Coupon');
            $this->loadModel('TempCart');
            $todayDate=date('Y-m-d');
            $data=array();
            $options_coupon = array('conditions' => array('Coupon.id' => $coupon_id));
            $coupon = $this->Coupon->find('first', $options_coupon);
            $options_cart = array('conditions' => array('TempCart.id' => $cart_id));
            $cart_list = $this->TempCart->find('first', $options_cart);
            $Total_deuct=0;
            if(count($coupon)>0){
                $coupon_code=$coupon['Coupon']['coupon_code'];
                $amount=$coupon['Coupon']['amount'];
                $from_date=$coupon['Coupon']['from_date'];
                $to_date=$coupon['Coupon']['to_date'];
                if($todayDate>$to_date || $todayDate<$from_date){
                    $commaList='';
                    $coupon_id_str=$cart_list['TempCart']['coupon_id'];
                    $ExpCouponID =  explode(',', $coupon_id_str);
                    if(count($ExpCouponID)>0){
                        if(($key = array_search($coupon_id, $ExpCouponID)) !== false) {
                            unset($ExpCouponID[$key]);
                        }
                        if(count($ExpCouponID)>0){
                            $commaList = implode(',', $ExpCouponID);
                        }
                    }
                    
                    $data_cart['TempCart']['id']=$cart_id;
                    $data_cart['TempCart']['coupon_id']=$commaList;
                    //$data_cart['TempCart']['percentage']=$percentage_str;
                    if ($this->TempCart->save($data_cart)) {

                    }
                }else{
                    $CalPrice=(($price*$quantity)*$amount)/100;
                    $Total_deuct+=$CalPrice;
                }
                $data['deduct_amt']=$Total_deuct;
                $data['coupon_name']=$coupon_code;
            }
            return $data;
        }
        
        public function calculate_net_pay($price=null,$cart_id=null) {
            $this->loadModel('TempCart');
            $data_cart['TempCart']['id']=$cart_id;
            $data_cart['TempCart']['pay_amt']=$price;
            //$data_cart['TempCart']['percentage']=$percentage_str;
            if ($this->TempCart->save($data_cart)) {

            }
        }
        
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
//	public function delete($id = null) {
//            $this->loadModel('ShippingAddress');
//		$this->ShippingAddress->id = $id;
//		if (!$this->ShippingAddress->exists()) {
//			throw new NotFoundException(__('Invalid shipping address'));
//		}
//		$this->request->onlyAllow('post');
//		if ($this->ShippingAddress->delete()) {
//			$this->Session->setFlash(__('The shipping address has been deleted.'));
//                        return $this->redirect(array('action' => 'review'));
//		} else {
//			$this->Session->setFlash(__('The shipping address could not be deleted. Please, try again.'));
//                        return $this->redirect(array('action' => 'review'));
//		}
//		
//	}
        
        
         public function delete($id = null) {
            
            $this->ShippingAddress->id = $id;
            if (!$this->ShippingAddress->exists()) {
                    throw new NotFoundException(__('Invalid Request'));
            }
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
		$this->redirect('/');
            }
            
            if ($this->ShippingAddress->delete()) {
                $this->Session->setFlash('shipping address has been deleted', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('shipping address could not be deleted. Please, try again.'));
            }
            
            return $this->redirect(array('action' => 'review'));
        }
        
        public function delete_billing_address($id = null) {
            $this->loadModel('BillingAddress');
            $this->BillingAddress->id = $id;
            if (!$this->BillingAddress->exists()) {
                    throw new NotFoundException(__('Invalid Request'));
            }
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
		$this->redirect('/');
            }
            
            if ($this->BillingAddress->delete()) {
                $this->Session->setFlash('Billing address has been deleted', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Billing address could not be deleted. Please, try again.'));
            }
            
            return $this->redirect(array('action' => 'review'));
        }
        
        
        public function order_message() {
            $ord_msg=$this->request->data['ord_msg'];
            $this->Session->write('user_msg', $ord_msg);
            echo 'success';
            exit();
        }
        
        public function coupon_code_check() {
            $this->loadModel('Coupon');
            $this->loadModel('TempCart');
            $this->loadModel('CouponUse');
            $todayDate=date('Y-m-d');
            $CouponIdArr=array();
            $OtherWonerCoupon=false;
            //$this->Session->delete('CouponId');
            $userid = $this->Session->read('Auth.User.id');
            //$TempCouponIdArr=$this->Session->read('CouponId');
            $CouponCode=trim($this->request->data['CouponCode']);
            $tot_amount=$this->request->data['tot_amount'];
            $options_coupon = array('conditions' => array('Coupon.coupon_code' => $CouponCode));
            $coupon = $this->Coupon->find('first', $options_coupon);
            
            if(count($coupon)>0){
                $coupon_id=$coupon['Coupon']['id'];
                $amount=$coupon['Coupon']['amount'];
                $from_date=$coupon['Coupon']['from_date'];
                $to_date=$coupon['Coupon']['to_date'];
                $is_active=$coupon['Coupon']['is_active'];
                $is_used=$coupon['Coupon']['is_used'];
                $valid=$coupon['Coupon']['valid'];
                $coupon_woner_id=$coupon['Coupon']['user_id'];
                
                //coupon use check to user
                $options_coupon_use = array('conditions' => array('CouponUse.coupon_id' => $coupon_id));
                $coupon_use = $this->CouponUse->find('all', $options_coupon_use);
                if(count($coupon_use)>0){
                    echo 'Coupon code already used.';
                }else{
                    if($is_active==0){
                        echo 'Coupon code not active.';
                    }elseif($is_used==1){
                        echo 'Coupon code already used.';
                    }elseif($todayDate>$to_date || $todayDate<$from_date){
                        echo 'Coupon code is expire.';
                    }/*elseif(in_array($coupon_id, $TempCouponIdArr)) {
                        echo 'You already use this coupon.';
                    }*/else{
                        $alreadyUseCoupon = false;
                        //check user cart list
                        $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
                        $cart_list = $this->TempCart->find('all', $options_cart);
                        $Total_deuct=0;
                        if(count($cart_list)>0){
                            foreach($cart_list as $val){
                                $product_woner_id=$val['TempCart']['product_woner_id'];  
                                $prd_id=$val['TempCart']['prd_id']; 
                                $price=$val['TempCart']['price']; 
                                $quantity=$val['TempCart']['quantity'];
                                $temp_cart_id=$val['TempCart']['id']; 
                                $temp_coupon_id=$val['TempCart']['coupon_id']; 
                                $temp_percentage=$val['TempCart']['percentage']; 
                                $pay_amt=$val['TempCart']['pay_amt']; 
                                // check product user coupon.
                                if($product_woner_id==$coupon_woner_id){
                                    if($valid==1 || $valid==$prd_id){
                                        if($temp_coupon_id!=''){
                                            $str_pos = strpos($temp_coupon_id, $coupon_id);
                                            if ($str_pos === false) {
                                                $alreadyUseCoupon = false;
                                            }else{
                                                $alreadyUseCoupon = true;
                                            }
                                        }else{
                                            $alreadyUseCoupon = false;
                                        }
                                        
                                        if(!$alreadyUseCoupon){
                                            //$CalPrdPrice=($price*$quantity);
                                            $CalPrice=(($price*$quantity)*$amount)/100;
                                            $Total_deuct+=$CalPrice;
                                            
                                            $coupon_id_str=$temp_coupon_id;
                                            $coupon_id_str.=$coupon_id.',';
                                            $percentage_str=$temp_percentage;
                                            $percentage_str.=$amount.',';
                                            
                                            $data_cart['TempCart']['id']=$temp_cart_id;
                                            $data_cart['TempCart']['coupon_id']=$coupon_id_str;
                                            $data_cart['TempCart']['percentage']=$percentage_str;
                                            $data_cart['TempCart']['pay_amt']=($tot_amount-$Total_deuct);
                                            if ($this->TempCart->save($data_cart)) {
                                                
                                            }
                                        }else{
                                            $OtherWonerCoupon=true;
                                        }
                                    }
                                }else{
                                    $OtherWonerCoupon=true;
                                }
                            }
                        }
                        if($OtherWonerCoupon==true){
                            if($alreadyUseCoupon==true){
                                echo 'Coupon code already used.';
                            }else{
                                echo 'You use other coupon code.';
                            }
                            
                        }else{
                            $TotalPayUser=($tot_amount-$Total_deuct);
                            //array_push($CouponIdArr, $coupon_id);
                            //$this->Session->write('CouponId', $CouponIdArr);
                            echo 'success#'.$TotalPayUser.'#'.$Total_deuct;
                        }
                    }
                }
            }else{
                echo 'Invalid coupon code.';
            }
            exit();
        }

        
        
        
        
        //for cash delivery
        public function order_success() {
          $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }   
        }
       //end 
        
     
  
 
     
  
  public function success(){
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }

  }
        
    public function cancel(){
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }
     
  } 
  
  //brain tree payment
  
  public function brain_tree_payment(){
      
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }
      
      
  }
  
  
  
  
  public function creditcardpay() {
      
      
      $userid = $this->Session->read('Auth.User.id');

        $this->autoRender = false;
        $site_url = Router::url('/', true);

        $card_no = $_REQUEST['card_no'];
        
        $exp_month = $_REQUEST['exp_month'];
        
        $exp_year = $_REQUEST['exp_year'];
        
        $fname = $_REQUEST['fname'];
       
        $lname = $_REQUEST['lname'];
        
        $card_type = $_REQUEST['type'];
         
        $payer_id = $userid;
//echo $payer_id;exit;
        $this->loadModel('SiteSetting');
        $paypalid = $this->SiteSetting->find('first');
        
        
        $login = $paypalid['SiteSetting']['braintree_loginid'];
        $password = $paypalid['SiteSetting']['braintree_password'];

        $url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
        $headers = array(
            'Accept: application/json',
            'Accept-Language: en_US'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $result = json_decode($result, TRUE);


        $accessToken = $result['access_token'];


        // The data to send to the API
        $card_details = array(
            'payer_id' => $payer_id,
            'type' => $card_type,
            'number' => str_replace(" ", "", $card_no),
            'expire_month' => $exp_month,
            'expire_year' => $exp_year,
            'first_name' => $fname,
            'last_name' => $lname
        );
        // Setup cURL
        $ch = curl_init('https://api.sandbox.paypal.com/v1/vault/credit-card');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($card_details)
        ));

        // Send the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === FALSE) {
            die(curl_error($ch));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);

      // print_r($responseData['id']);exit();
        
       

        //print_r($this->request->data);
        //exit;
        
        
        
        
        if($responseData['name'] != 'VALIDATION_ERROR'){
            
            
            
            $ack = array('ack' => 1, 'msg' => 'Creadit card save successfully');
                  // echo json_encode($ack);
            $this->loadModel('TempCart');
            $product = $this->TempCart->find('first', array('conditions' => array('TempCart.user_id' => $userid),'group'=>'TempCart.user_id','fields'=>array('sum(TempCart.pay_amt) as totalpay')));
            
           $response = $responseData['id'];
           $payer_id = $userid;
           
         //$login = $paypalid['SiteSetting']['braintree_loginid'];
        //$password = $paypalid['SiteSetting']['braintree_password'];
                            
     $url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
                            
     $headers = array(
                                'Accept: application/json',
                                'Accept-Language: en_US'
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
                            $result = curl_exec($ch);
                            curl_close($ch);
                            // Decode the response
                            $result = json_decode($result, TRUE);
                            $accessToken = $result['access_token'];
                            $payment_details = '{
                                    "intent": "sale",
                                    "payer": {
                                      "payment_method": "credit_card",
                                      "funding_instruments":[
                                            {
                                              "credit_card_token": {
                                                    "credit_card_id": "' . $response . '",
                                                    "payer_id": "' . $payer_id . '"
                                              }
                                            }
                                      ]
                                    },
                                    "transactions":[
                                      {
                                            "amount":{
                                              "total": "' . $product[0]['totalpay'] . '",
                                              "currency": "USD"
                                            },
                                            "description": "This is the payment transaction description."
                                      }
                                    ]
                              }';

                            $ch = curl_init('https://api.sandbox.paypal.com/v1/payments/payment');
                            curl_setopt_array($ch, array(
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_HTTPHEADER => array(
                                    'Authorization: Bearer ' . $accessToken,
                                    'Content-Type: application/json'
                                ),
                                CURLOPT_POSTFIELDS => $payment_details
                            ));

                            // Send the request
                            $response = curl_exec($ch);
                            
                             if ($response === FALSE) {
                                die(curl_error($ch));
                            }

                            // Decode the response
                            $responseData = json_decode($response, TRUE);
                            //print_r($responseData);exit();
                            if ($responseData['state'] == "approved") {
                                
           $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
           $cart = $this->TempCart->find('all', $options_cart);
            
           $this->loadModel('OrderDetail');
           $this->loadModel('Order');
           $this->loadModel('CouponUse');
           $this->loadModel('Product');
            foreach($cart as $tempid){
                //pr($cart);exit;
                
                $this->request->data['Order']['user_id']=$tempid['TempCart']['user_id'];
                $this->request->data['Order']['payment_type']='cash';
                $this->request->data['Order']['total_amount']=$tempid['TempCart']['pay_amt'];
                $this->request->data['Order']['order_date']=$tempid['TempCart']['cdate'];
                $this->request->data['Order']['store_woner_id']=$tempid['TempCart']['product_woner_id'];
                $this->request->data['Order']['payment_type']='CreditCard';
                $this->request->data['Order']['transaction_id']=$responseData['id'];
                $this->Order->create(); 
               if ($this->Order->save($this->request->data)) {
                  
                $this->OrderDetail->create(); 
                $this->request->data['OrderDetail']['order_id']=$this->Order->getInsertID(); 
                $this->request->data['OrderDetail']['user_id']= $tempid['TempCart']['user_id'];
                $this->request->data['OrderDetail']['product_id']= $tempid['TempCart']['prd_id'];
                $this->request->data['OrderDetail']['price']= $tempid['TempCart']['price'];
                $this->request->data['OrderDetail']['shipping_cost']= $tempid['TempCart']['shipping_time'];
                $this->request->data['OrderDetail']['amount']= $tempid['TempCart']['pay_amt'];
                $this->request->data['OrderDetail']['quantity']= $tempid['TempCart']['quantity'];
                $this->request->data['OrderDetail']['owner_id']= $tempid['TempCart']['product_woner_id'];
                $this->request->data['OrderDetail']['p_color']= $tempid['TempCart']['p_color'];
                $this->request->data['OrderDetail']['p_size']= $tempid['TempCart']['p_size'];
                $this->request->data['OrderDetail']['order_received_date']= $tempid['TempCart']['cdate'];
                $this->request->data['OrderDetail']['payment_status']= 'Completed';
                   
                $this->OrderDetail->save($this->request->data);
                
                
                $this->Product->recursive = -1;  
                $pqty=$this->Product->find('first',array('conditions' => array('Product.id' => $tempid['TempCart']['prd_id']))); 
                $this->request->data['Product']['id']= $tempid['TempCart']['prd_id'];
                $this->request->data['Product']['quantity']= ($pqty['Product']['quantity']-$tempid['TempCart']['quantity']);  
                  //pr($this->request->data);exit;
                $this->Product->save($this->request->data); 
                
                
               if($tempid['TempCart']['coupon_id']!=''){   
                $this->CouponUse->create(); 

                $this->request->data['CouponUse']['user_id']=$tempid['TempCart']['user_id'];
                $this->request->data['CouponUse']['coupon_id']=$tempid['TempCart']['coupon_id'];
                $this->request->data['CouponUse']['prd_id']=$tempid['TempCart']['prd_id'];
                $this->request->data['CouponUse']['order_id']=$this->Order->getInsertID();
                $this->request->data['CouponUse']['use_date']=date('Y-m-d');
                $this->CouponUse->save($this->request->data);
               }
               }
               $this->TempCart->delete($tempid['TempCart']['id']);
                
            }
              $this->OrderDetail->save($this->request->data);   
                                
                                
                                
             return $this->redirect(array('action' => 'success/'));    
                                
                    }
             
        }
        else
        {
          $ack = array('ack' => 0, 'msg' => 'Creadit card information is wrong.');
           //echo json_encode($ack); 
          $this->Session->setFlash(__('Payment not successfull. Please, try again.', 'default', array('class' => 'error')));
          return $this->redirect(array('action' => 'brain_tree_payment/'));
        }
    }
   
    
    
    public function admin_payment_management() {
        
        $this->loadModel('OrderDetail');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/admin');
            }
            $title_for_layout = 'Payment History';
            $QueryStr="(OrderDetail.user_id !='0')";
            
            if($type=='cancel'){
                $QueryStr.=" AND (OrderDetail.order_status = 'C')";
            }elseif($type=='dispute'){
                $QueryStr.=" AND (OrderDetail.order_status = 'DP')";
            }elseif($type=='complete'){
                $QueryStr.=" AND (OrderDetail.order_status = 'F')";
            }elseif($type=='delivered'){
                $QueryStr.=" AND (OrderDetail.order_status = 'D')";
            }elseif($type=='shipment'){
                $QueryStr.=" AND (OrderDetail.order_status = 'S')";
            }
            
        
                //$options = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'), 'limit' => 10);
                $options = array('conditions' => array('payment_status'=>'completed'), 'order' => array('OrderDetail.id' => 'desc'));
                $order_no='';
                $product_name='';
                $product_sku='';
                $from_date='';
                $to_date='';
            
            $this->Paginator->settings = $options;
            $orders=$this->Paginator->paginate('OrderDetail');
            $this->set(compact('orders','title_for_layout','order_no','product_name','product_sku','from_date','to_date'));
    }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
        
        
        
        public function shhipping_management_add() {
        
            $title_for_layout = 'Add Shipping Day';
            $this->loadModel('ShippingDay');
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect(array('controller'=>'users','action' => 'login'));
		}
            
            if ($this->request->is('post')) {
    
  $this->request->data['ShippingDay']['user_id'] = $userid;
  $this->request->data['ShippingDay']['ship_day'] = $this->request->data['ShippingDay']['ship_day'];
  $this->request->data['ShippingDay']['ship_name'] = $this->request->data['ShippingDay']['ship_name'];
  $this->request->data['ShippingDay']['ship_charge'] = $this->request->data['ShippingDay']['ship_charge'];
     
     
      $this->ShippingDay->create();

     if ($this->ShippingDay->save($this->request->data)) {

      $this->Session->setFlash('Shipping day has been saved.','default', array('class' => 'success'));
      return $this->redirect(array('action' => 'shhipping_management_list'));
     } else {
      $this->Session->setFlash(__('Shipping day could not be saved. Please, try again.', 'default', array('class' => 'error')));
     }

     
   }
            
       }
       
       public function shhipping_management_list() {
            $this->loadModel('ShippingDay');
                $userid = $this->Session->read('Auth.User.id');
                //echo $userid;
                $admincheck = $this->Session->read('Auth.User.is_admin');
		if((!isset($userid) && $userid=='') || $admincheck==1)
		{
			$this->redirect(array('controller'=>'users','action' => 'login'));
		}
		$title_for_layout = 'Shipping Day List';
               
                $con= array('conditions'=>array('user_id'=>$userid),'order'=>array('id'=>'desc'));      
                $shippinday = $this->ShippingDay->find('all',$con); 
		
		$this->set(compact('shippinday','title_for_layout'));
	}
       
       public function shipping_management_edit($edit_id = null) {
           $this->loadModel('ShippingDay');
	    $userid = $this->Session->read('Auth.User.id');
            $admincheck = $this->Session->read('Auth.User.is_admin');
		if((!isset($userid) && $userid=='') || $admincheck==1)
		{
			$this->redirect(array('controller'=>'users','action' => 'login'));
		}
                
                $id=base64_decode($edit_id);
                $this->request->data1=array();
		$title_for_layout = 'Edit Shipping Day';
		$this->set(compact('title_for_layout'));
		
		if (!$this->ShippingDay->exists($id)) {
			throw new NotFoundException(__('Invalid shipping day'));
		}
		if ($this->request->is(array('post', 'put'))) {

        $this->request->data['ShippingDay']['user_id']=$userid;
        $this->request->data['ShippingDay']['ship_day'] = $this->request->data['ShippingDay']['ship_day'] ;
        $this->request->data['ShippingDay']['ship_name'] = $this->request->data['ShippingDay']['ship_name'];
        

			if ($this->ShippingDay->save($this->request->data)) {

        
				$this->Session->setFlash('Shipping day has been saved.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'shhipping_management_list'));
			} else {
				$this->Session->setFlash(__('Shipping day could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('ShippingDay.' . $this->ShippingDay->primaryKey => $id));
			$this->request->data = $this->ShippingDay->find('first', $options);

	}    
       
    }
       public function shipping_management_delete($edit_id = null) {
	   $userid = $this->Session->read('Auth.User.id');
           $admincheck = $this->Session->read('Auth.User.is_admin');
           $this->loadModel('ShippingDay');
	   if((!isset($userid) && $userid=='') || $admincheck==1)
	   {
		$this->redirect(array('controller'=>'users','action' => 'login'));
	   }
           $id=base64_decode($edit_id);
	   $this->ShippingDay->id = $id;
	   if (!$this->ShippingDay->exists()) {
	      throw new NotFoundException(__('Invalid ad.'));
	   }
	   if ($this->ShippingDay->delete($id)) {
		$this->Session->setFlash('Shipping day has been deleted.', 'default', array('class' => 'success'));
              return $this->redirect(array('action' => 'shhipping_management_list'));  
	   } else {
		$this->Session->setFlash(__('Shipping day could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'shhipping_management_list'));
	}
        
        
        
        
        
        
        
        
        
        public function admin_shhipping_management_list() {
            $this->loadModel('ShippingDay');
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Shipping Day List';
               
                $con= array('order'=>array('ShippingDay.id'=>'desc'));      
      $shippinday = $this->ShippingDay->find('all',$con); 
		
		$this->set(compact('shippinday','title_for_layout'));
	}
        
        public function admin_shhipping_management() {
        
            $title_for_layout = 'Add Shipping Day';
            $this->loadModel('ShippingDay');
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
            
            if ($this->request->is('post')) {
    
   
    $this->request->data['ShippingDay']['ship_day'] = $this->request->data['ShippingDay']['ship_day'];
    $this->request->data['ShippingDay']['ship_name'] = $this->request->data['ShippingDay']['ship_name'];
    $this->request->data['ShippingDay']['ship_charge'] = $this->request->data['ShippingDay']['ship_charge'];
     
     
      $this->ShippingDay->create();

     if ($this->ShippingDay->save($this->request->data)) {

      $this->Session->setFlash('Shipping day has been saved.','default', array('class' => 'success'));
      return $this->redirect(array('action' => 'shhipping_management_list'));
     } else {
      $this->Session->setFlash(__('Shipping day could not be saved. Please, try again.', 'default', array('class' => 'error')));
     }

     
   }
            
       }
       
       public function admin_shipping_management_edit($id = null) {
           $this->loadModel('ShippingDay');
	    $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}

	    $this->request->data1=array();
		$title_for_layout = 'Edit Shipping Day';
		$this->set(compact('title_for_layout'));
		
		if (!$this->ShippingDay->exists($id)) {
			throw new NotFoundException(__('Invalid shipping day'));
		}
		if ($this->request->is(array('post', 'put'))) {

        
        $this->request->data['ShippingDay']['ship_day'] = $this->request->data['ShippingDay']['ship_day'] ;
        $this->request->data['ShippingDay']['ship_name'] = $this->request->data['ShippingDay']['ship_name'];
        

			if ($this->ShippingDay->save($this->request->data)) {

        
				$this->Session->setFlash('Shipping day has been saved.','default', array('class' => 'success'));
				//return $this->redirect(array('action' => 'shipping_management_list'));
			} else {
				$this->Session->setFlash(__('Shipping day could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('ShippingDay.' . $this->ShippingDay->primaryKey => $id));
			$this->request->data = $this->ShippingDay->find('first', $options);

      
     
     
	}    
       
    }
       public function admin_shipping_management_delete($id = null) {
	   $userid = $this->Session->read('Auth.User.id');
           $this->loadModel('ShippingDay');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->ShippingDay->id = $id;
	   if (!$this->ShippingDay->exists()) {
	      throw new NotFoundException(__('Invalid ad.'));
	   }
	   if ($this->ShippingDay->delete($id)) {
		$this->Session->setFlash('Shipping day has been deleted.', 'default', array('class' => 'success'));
              return $this->redirect(array('action' => 'shhipping_management_list'));  
	   } else {
		$this->Session->setFlash(__('Shipping day could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'shhipping_management_list'));
	}
         
        
        
        
}
