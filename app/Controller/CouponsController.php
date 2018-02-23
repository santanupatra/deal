<?php
App::uses('AppController', 'Controller');
/**
 * Skills Controller
 *
 * @property Skill $Skill
 * @property PaginatorComponent $Paginator
 */
class CouponsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public function beforeFilter() {
            parent::beforeFilter();
            //$this->Auth->allow('details','sliderframe','sliderframe2');
        }

/**
 * index method
 *
 * @return void
 */

   
	public function admin_index() {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $this->paginate = array(
            'limit' =>25,
            'order' => array(
                            'Coupon.id' => 'desc'
             ), 
            );
            $this->Paginator->settings = $this->paginate;

            $this->Coupon->recursive = 0;
            $this->set('coupons', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Skill->exists($id)) {
			throw new NotFoundException(__('Invalid skill'));
		}
		$options = array('conditions' => array('Skill.' . $this->Skill->primaryKey => $id));
		$this->set('skill', $this->Skill->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
            
            $this->loadModel('User');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            if ($this->request->is('post')) {
                $this->request->data['Coupon']['post_date']=gmdate('Y-m-d'); 
                $this->Coupon->create();
                if ($this->Coupon->save($this->request->data)) {
                    $this->Session->setFlash(__('The Coupon has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Coupon could not be saved. Please, try again.'));
                }
                
            }
            
            $users = $this->User->find('all', array('conditions' => array('User.is_active' => 1, 'User.is_admin !=' => 1,'User.type'=>'V')));
        
        $this->set(compact('users'));
            
            
            
        }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
            $this->loadModel('User');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            if (!$this->Coupon->exists($id)) {
                    throw new NotFoundException(__('Invalid Coupon'));
            }
            
            if ($this->request->is(array('post', 'put'))) {
                
                if($this->request->data['Coupon']['shop_id']==""){
                    
                    $this->request->data['Coupon']['shop_id']=$this->request->data['Coupon']['hid_shop_id'];
                }
                if ($this->Coupon->save($this->request->data)) {
                    $this->Session->setFlash('The Coupon has been saved.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Coupon could not be saved. Please, try again.'));
                }
            } else {
                $options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
                $this->request->data = $this->Coupon->find('first', $options);
            }
            
            $users = $this->User->find('all', array('conditions' => array('User.is_active' => 1, 'User.is_admin !=' => 1,'User.type'=>'V')));
        
        $this->set(compact('users'));
            
           
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $this->Coupon->id = $id;
            if (!$this->Coupon->exists()) {
                throw new NotFoundException(__('Invalid Coupon'));
            }
            //$this->request->allowMethod('post', 'delete');
            if ($this->Coupon->delete()) {
                $this->Session->setFlash(__('The Coupon has been deleted.'));
            } else {
                $this->Session->setFlash(__('The Coupon could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
	}

        public function index() {
            $title_for_layout='Coupon List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $this->paginate = array(
            'limit' =>25,
            'conditions' => array('Coupon.user_id' => $userid),
            'order' => array(
                    'Coupon.id' => 'desc'
                ) 
            );
            $this->Paginator->settings = $this->paginate;

            $this->Coupon->recursive = 0;
            $this->set('coupons', $this->Paginator->paginate());
            $this->set(compact('title_for_layout'));
	}
        
        public function add() {
            $title_for_layout='Add Coupon';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $this->loadModel('Product');
            
            if ($this->request->is('post','put')) {
                $CouponName=trim($this->request->data['Coupon']['coupon_code']);
                $options = array('conditions' => array('Coupon.coupon_code' => $CouponName));
                $CouponExist=$this->Coupon->find('first', $options);
                if(count($CouponExist)>0){
                    $this->Session->setFlash(__('The Coupon code already exist. Please, try another.'));
                }else{
                    $this->request->data['Coupon']['user_id']=$userid;
                    $this->request->data['Coupon']['post_date']=gmdate('Y-m-d');
                    $this->request->data['Coupon']['type']=2;
                    $this->request->data['Coupon']['is_active']=1;
                    $this->Coupon->create();
                    if ($this->Coupon->save($this->request->data)) {
                        $this->Session->setFlash(__('The Coupon has been saved.', 'default', array('class' => 'success')));
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The Coupon could not be saved. Please, try again.', 'default', array('class' => 'error')));
                    }
                }
            }
            $options_prd = array('conditions' => array('Product.user_id' => $userid));
            $PrdList=$this->Product->find('list', $options_prd);
            $this->set(compact('title_for_layout','PrdList'));
        }
        
        public function edit($edit_id = null) {
            $title_for_layout='Edit Coupon';
            $this->loadModel('Product');
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $id=  base64_decode($edit_id);
            if (!$this->Coupon->exists($id)) {
                throw new NotFoundException(__('Invalid Coupon'));
            }
            
            if ($this->request->is(array('post', 'put'))) {
                if ($this->Coupon->save($this->request->data)) {
                    $this->Session->setFlash(__('The Coupon has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Coupon could not be saved. Please, try again.'));
                }
            } else {
                $options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
                $this->request->data = $this->Coupon->find('first', $options);
            }
            $options_prd = array('conditions' => array('Product.user_id' => $userid));
            $PrdList=$this->Product->find('list', $options_prd);
            $this->set(compact('title_for_layout','PrdList'));
	}
        
        public function delete($delid = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $id=  base64_decode($delid);
            $this->Coupon->id = $id;
            if (!$this->Coupon->exists()) {
                throw new NotFoundException(__('Invalid Coupon'));
            }
            //$this->request->allowMethod('post', 'delete');
            if ($this->Coupon->delete()) {
                $this->Session->setFlash(__('The Coupon has been deleted.'));
            } else {
                $this->Session->setFlash(__('The Coupon could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
	}
}
