<?php
App::uses('AppController', 'Controller');
/**
 * Requests Controller
 *
 * @property Request $Request
 * @property PaginatorComponent $Paginator
 */
class RequestsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses=array('Request','User','Notification','InboxMessage');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Request->recursive = 0;
		$this->set('requests', $this->Paginator->paginate());
	}
   public function admin_index() {
		$this->paginate = array(
		'limit' =>25,
		'order' => array(
				'Request.id' => 'desc'
		 ), 
		);
		$this->Paginator->settings = $this->paginate;
		$this->Request->recursive = 2;
		$this->set('requests', $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Request->exists($id)) {
			throw new NotFoundException(__('Invalid request'));
		}
		$options = array('conditions' => array('Request.' . $this->Request->primaryKey => $id));
		$this->set('request', $this->Request->find('first', $options));
	}
   
	public function admin_view($id = null) {
		if (!$this->Request->exists($id)) {
			throw new NotFoundException(__('Invalid request'));
		}
		$this->Request->recursive = 2;
		$options = array('conditions' => array('Request.' . $this->Request->primaryKey => $id));
		$this->set('request', $this->Request->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Request->create();
			if ($this->Request->save($this->request->data)) {
				$this->Session->setFlash(__('The request has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.'));
			}
		}
		$users = $this->Request->User->find('list');
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
		if (!$this->Request->exists($id)) {
			throw new NotFoundException(__('Invalid request'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Request->save($this->request->data)) {
				$this->Session->setFlash(__('The request has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Request.' . $this->Request->primaryKey => $id));
			$this->request->data = $this->Request->find('first', $options);
		}
		$users = $this->Request->User->find('list');
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
		$this->Request->id = $id;
		if (!$this->Request->exists()) {
			throw new NotFoundException(__('Invalid request'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Request->delete()) {
			$this->Session->setFlash(__('The request has been deleted.'));
		} else {
			$this->Session->setFlash(__('The request could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/********
	** After payment saves transaction Id
	*********/
	public function save_transaction()
	{
		$payerid = $this->Session->read('Auth.User.id');
		$myarray=array();
		if($this->request->is(array('post', 'put')))
		{
			
			$data['Request']['id']=$this->request->data['request_id'];
			$data['Request']['payment_amount']=$this->request->data['amount'];
			$data['Request']['payment_date']=date('Y-m-d H:i:s');
			$data['Request']['transactionId']=$this->request->data['transaction_id'];
			$data['Request']['billing_firstname']=$this->request->data['billing_first_name'];
			$data['Request']['billing_lastname']=$this->request->data['billing_last_name'];
			$data['Request']['billing_streetaddress']=$this->request->data['billing_street_add'];
			$data['Request']['billing_city']=$this->request->data['billing_city'];
			$data['Request']['billing_state']=$this->request->data['billing_state'];
			$data['Request']['billing_postcode']=$this->request->data['billing_post_code'];
			$data['Request']['is_paid']=1;
			if ($this->Request->save($data)) {
                
				$this->loadModel('Token');
				$usr['Token']['user_id']=$payerid;
				$usr['Token']['token']=$this->request->data['braintree_token'];
				$this->Token->create();
				$this->Token->save($usr);
				
				$options = array('conditions' => array('Request.' . $this->Request->primaryKey => $data['Request']['id']));
				$request=$this->Request->find('first', $options);
               	
				$this->loadModel('Transaction');
                $tran['Transaction']['request_id']=$data['Request']['id'];
			    $tran['Transaction']['from']=$payerid;
			    $tran['Transaction']['to']=$request['Request']['maker'];
				$tran['Transaction']['amount']=$data['Request']['payment_amount'];
			    $tran['Transaction']['transaction_id']=$data['Request']['transactionId'];
			    $tran['Transaction']['date']=date('Y-m-d');
				$tran['Transaction']['status']=1;
				$this->Transaction->create();
				$this->Transaction->save($tran);

				$maker_details=$this->User->find('first',array('conditions' => array('User.' . $this->User->primaryKey => $request['Request']['user_id'])));

				$inbox_details=$this->InboxMessage->find('first',array('conditions' => array('InboxMessage.user_id'=> $request['Request']['maker'],'InboxMessage.order_id'=> $this->request->data['request_id'])));

				$notification['Notification']['inbox_id']=$inbox_details['InboxMessage']['id'];
				$notification['Notification']['user_id']=$request['Request']['maker'];
				$notification['Notification']['message']=$maker_details['User']['first_name'].' '.$maker_details['User']['last_name'].' has paid you.';
				$notification['Notification']['date']=date('Y-m-d h:i:s');
				$this->Notification->save($notification);
				$myarray=array('status' => 'success');
				echo json_encode($myarray);
				exit;
			}
			else
			{
				$myarray=array('status' => 'error');
				echo json_encode($myarray);
				exit;
			}
		}
		$myarray=array('status' => 'error');
		echo json_encode($myarray);
		exit;
	}

	public function save_transaction_exist()
	{
		$payerid = $this->Session->read('Auth.User.id');
		$myarray=array();
		if($this->request->is(array('post', 'put')))
		{
			
			$data['Request']['id']=$this->request->data['request_id'];
			$data['Request']['payment_amount']=$this->request->data['amount'];
			$data['Request']['payment_date']=date('Y-m-d H:i:s');
			$data['Request']['transactionId']=$this->request->data['transaction_id'];
			$data['Request']['is_paid']=1;
			if ($this->Request->save($data)) {
                				
				$options = array('conditions' => array('Request.' . $this->Request->primaryKey => $data['Request']['id']));
				$request=$this->Request->find('first', $options);
               	
				$this->loadModel('Transaction');
                $tran['Transaction']['request_id']=$data['Request']['id'];
			    $tran['Transaction']['from']=$payerid;
			    $tran['Transaction']['to']=$request['Request']['maker'];
				$tran['Transaction']['amount']=$data['Request']['payment_amount'];
			    $tran['Transaction']['transaction_id']=$data['Request']['transactionId'];
			    $tran['Transaction']['date']=date('Y-m-d');
				$tran['Transaction']['status']=1;
				$this->Transaction->create();
				$this->Transaction->save($tran);

				$maker_details=$this->User->find('first',array('conditions' => array('User.' . $this->User->primaryKey => $request['Request']['user_id'])));

				$inbox_details=$this->InboxMessage->find('first',array('conditions' => array('InboxMessage.user_id'=> $request['Request']['maker'],'InboxMessage.order_id'=> $this->request->data['request_id'])));

				$notification['Notification']['inbox_id']=$inbox_details['InboxMessage']['id'];
				$notification['Notification']['user_id']=$request['Request']['maker'];
				$notification['Notification']['message']=$maker_details['User']['first_name'].' '.$maker_details['User']['last_name'].' has paid you.';
				$notification['Notification']['date']=date('Y-m-d h:i:s');
				$this->Notification->save($notification);
				$myarray=array('status' => 'success');
				echo json_encode($myarray);
				exit;
			}
			else
			{
				$myarray=array('status' => 'error');
				echo json_encode($myarray);
				exit;
			}
		}
		$myarray=array('status' => 'error');
		echo json_encode($myarray);
		exit;
	}

}
