<?php
App::uses('AppController', 'Controller');
/**
 * OrderDetails Controller
 *
 * @property OrderDetail $OrderDetail
 * @property PaginatorComponent $Paginator
 */
class OrderDetailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','RequestHandler','Paginator'); 
	var $uses = array('OrderDetail','Order','Shop','Country','User','Category','Attribute','AttributeItem','UserPaymentDetail','UserBillingAddress','UserCreditCard','Product','ListAttribute','ListAttributeItem','ListTag','ListMaterial','ListDispatch','ListImage','ListFile','ShopSetting','ShopFollowing','ShippingAddress','SiteSetting');

/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		$id = base64_decode($id);
		//$username = $this->Session->read('username');
		$userid = $this->Session->read('Auth.User.id');
		$countryname = '';
		if(!isset($userid)){
			$this->redirect('/');
		}
		$title_for_layout = 'Order Details';
		$order_by = array();
		$shipping = array();
		$this->OrderDetail->recursive = 2;
		$orderdetails = $this->Paginator->paginate('OrderDetail', array('OrderDetail.id' => $id));
		#pr($orderdetails);
		if($orderdetails){
			$options1 = array('conditions' => array('User.id' => $orderdetails[0]['Order']['user_id']));
			$order_by = $this->User->find('first', $options1);
			#pr($order_by);
			if($order_by){
				$this->ShippingAddress->recursive = -1;
				$options2 = array('conditions' => array('ShippingAddress.user_id' => $order_by['User']['id']));
				$shipping = $this->ShippingAddress->find('first', $options2);
				#pr($shipping);
			}
		}
		$options = array('conditions' => array('User.id' => $userid));
		$user = $this->User->find('first', $options);
		if($user){
			if(isset($user['User']['country']) && $user['User']['country']!=0){
				$countryname = $this->Country->find('first',array('conditions' => array('Country.id'=>$user['User']['country']),'fields' => array('Country.printable_name')));
				$countryname = $countryname['Country']['printable_name'];
			}
		}
		$this->set(compact('orderdetails','title_for_layout','user','countryname','order_by','shipping'));
	}

	public function admin_index($order_id = null) {
		$this->OrderDetail->recursive = 0;
		$orderdetails = $this->Paginator->paginate('OrderDetail', array('OrderDetail.order_id' => $order_id));
		#pr($orderdetails);
		$this->set(compact('orderdetails'));
	}

	public function purchasedetails($order_id = null) {
		$order_id = base64_decode($order_id);
		//$username = $this->Session->read('username');
		$userid = $this->Session->read('Auth.User.id');
		$countryname = '';
		if(!isset($userid)){
			$this->redirect('/');
		}
		$title_for_layout = 'Purchase Details';
		$this->OrderDetail->recursive = 2;
		$orderdetails = $this->Paginator->paginate('OrderDetail', array('OrderDetail.order_id' => $order_id));
		#pr($orderdetails);
		//$options = array('conditions' => array('User.id' => $userid));
		//$user = $this->User->find('first', $options);
		$this->set(compact('orderdetails','title_for_layout','user','countryname'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
		$this->set('orderdetail', $this->OrderDetail->find('first', $options));
	}



	public function editstatus($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			#pr($this->request->data);
			#exit;
			if($this->request->data['OrderDetail']['order_status']=='D'){
				$this->request->data['OrderDetail']['delivery_date'] = date('Y-m-d');
			}
			$this->request->data['OrderDetail']['id'] = $id;
			if ($this->OrderDetail->save($this->request->data)) {
				
				if($this->request->data['OrderDetail']['order_status']=='D'){
				/*******/
					$contact_email = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1), 'fields' => array('SiteSetting.contact_email')));
					if($contact_email){
						$adminEmail = $contact_email['SiteSetting']['contact_email'];
					} else {
						$adminEmail = 'admin@twop.com';
					}

					$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
					$orderdetail = $this->OrderDetail->find('first', $options);
					#pr($orderdetail);
					#exit;
					$options = array('conditions' => array('User.id' => $orderdetail['Order']['user_id']));
					$orderBy = $this->User->find('first', $options);
					$options = array('conditions' => array('Product.id' => $orderdetail['OrderDetail']['product_id']));
					$listItem = $this->Product->find('first', $options);

					#$link = 'http://192.232.197.138/shopfit/order_details/index/'.base64_encode($orderId);
					$msg_body = 'Hi '.$orderBy['User']['first_name'].'<br/><br/>Your ordered product '.$listItem['Product']['name'].' has been Shipped. Please contact TWOP at '.$adminEmail.' in case of not receiving your product. Hope you liked the TWOP experience.<br/><br/>Thanks,<br/>TWOP';

					App::uses('CakeEmail', 'Network/Email');

					$Email = new CakeEmail();
					
					/* pass user input to function */
					$Email->emailFormat('both');
					$Email->from(array($adminEmail => 'TWOP'));
					$Email->to($orderBy['User']['email']);
					$Email->subject('TWOP Items Shipped From Shop');
					$Email->send($msg_body);
					/*******/
				}
				$this->Session->setFlash(__('The order status has been saved.'));
				return $this->redirect(array('action' => 'index',base64_encode($id)));
			} else {
				$this->Session->setFlash(__('The order status could not be saved. Please, try again.'));
			}
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
		$this->OrderDetail->id = $id;
		if (!$this->OrderDetail->exists()) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OrderDetail->delete()) {
			$this->Session->setFlash(__('The order detail has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order detail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function getCountryname($id = null){
		$countryname = '';
		if($id!=''){
			$countryName = $this->Country->find('first', array('conditions' => array('Country.id' => $id), 'fields' => array('Country.name')));
			if($countryName){
				$countryname = $countryName['Country']['name'];
			}
		}
		return $countryname;
	}
}
