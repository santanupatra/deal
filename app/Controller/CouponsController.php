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

            $this->Auth->allow('coupon_list');

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
            $coupons=$this->Paginator->paginate('Coupon');
            $this->loadModel('OfflineOrder');
            $this->loadModel('Order');
            
             foreach($coupons as $dt){
                 
               $soptions = array('conditions' => array('OfflineOrder.coupon_id'=> $dt['Coupon']['id']));
               $storesold = $this->OfflineOrder->find('count', $soptions);
               $ooptions = array('conditions' => array('Order.coupon_id'=> $dt['Coupon']['id']));
               $onlinesold = $this->Order->find('count', $ooptions);
                    
                    $allcoupon[] =array('storesold'=>$storesold,'onlinesold'=>$onlinesold,'coupon'=>$dt);
                    
                }
                    
            $this->Coupon->recursive = 0;
            $this->set('coupons', $allcoupon);
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
            
            $this->loadModel('Category');
            $categories = $this->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type' => 'C')));
            
            
       $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
        
        $this->set(compact('users','categories','cities'));
            
            
            
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
        
            
             $this->loadModel('Category');
            $categories = $this->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type' => 'C')));
            
            $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
            
            
        $this->set(compact('users','categories','cities'));
            
           
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
            $date=date('Y-m_d');
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
            $this->loadModel('User');
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $user = $this->User->find('first', $options);
            
            if ($this->request->is('post','put')) {
                
                if($user['User']['total_coupon']< 1){
                    
                  $this->Session->setFlash(__('You can not upload new coupon. Please subscribe our package.'));
                  
                }else{
                
                    $this->request->data['Coupon']['user_id']=$userid;
                    $this->request->data['Coupon']['post_date']=gmdate('Y-m-d');
                    //$this->request->data['Coupon']['type']=2;
                    $this->request->data['Coupon']['is_active']=1;
                    $this->Coupon->create();
                    if ($this->Coupon->save($this->request->data)) {
                        
                        
                $this->request->data['User']['id']=  $userid; 
                $this->request->data['User']['total_coupon']= $user['User']['total_coupon'] -1;
                $this->User->save($this->request->data); 
                        
                        
                        $this->Session->setFlash(__('The Coupon has been saved.', 'default', array('class' => 'success')));
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The Coupon could not be saved. Please, try again.', 'default', array('class' => 'error')));
                    }
                
            }
            }
            
             $this->loadModel('Shop'); 
            $shops = $this->Shop->find('all', array('conditions' => array('Shop.is_active' => 1, 'Shop.user_id'=> $userid)));
            $this->loadModel('Category');
            $categories = $this->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type' => 'C')));
            
            $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
            
            
            
            $this->set(compact('title_for_layout','user','shops','categories','cities'));
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
            
            $this->loadModel('Shop');
            $shops = $this->Shop->find('all', array('conditions' => array('Shop.is_active' => 1, 'Shop.user_id'=> $userid)));
            $this->loadModel('Category');
            $categories = $this->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type' => 'C')));
            
            $this->loadModel('City');
            $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
       
            $this->set(compact('title_for_layout','categories','shops','cities'));
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

    public function coupon_list($type= null, $id=null){
            $this->loadModel('Coupon');
            $this->loadModel('Category');
            $this->loadModel('Shop');
            $this->loadModel('City');
           // $id = base64_decode($id);
            $url= "http://111.93.169.90/team6/deal/";
            $condition = array();
            if($type =='c' && isset($id) && $id != ""){
               $cid = base64_decode($id);
              $condition[] = array('category_id' => $cid);
            }
            elseif($type =='s' && isset($id) && $id != ""){
              $sid = base64_decode($id);
              $condition[] = array('shop_id' => $sid);
            }elseif($type =='l' && isset($id) && $id != ""){
              $lid = base64_decode($id);
              $condition[] = array('city_id' => $lid);
            }

            if(isset($this->request->data['Coupon']['category_id']) && $this->request->data['Coupon']['category_id'] !=""){
              $condition[] = array('category_id' => $this->request->data['Coupon']['category_id']);
              $cid = $this->request->data['Coupon']['category_id'];
            }

            if(isset($this->request->data['Coupon']['shop_id']) && $this->request->data['Coupon']['shop_id'] !=""){
              $condition[] = array('shop_id' => $this->request->data['Coupon']['shop_id']);
              $sid = $this->request->data['Coupon']['shop_id'];
            }
            
            if(isset($this->request->data['Coupon']['city_id']) && $this->request->data['Coupon']['city_id'] !=""){
              $condition[] = array('city_id' => $this->request->data['Coupon']['city_id']);
              $lid = $this->request->data['Coupon']['city_id'];
            }
            
            $title_for_layout = 'Coupon List';
            if(isset($cid) && $cid != ""){
              $category = $this->Category->find('first', array('conditions' => array('id' => $cid)));
              $Folder = "category_images/";
              $Path = $url . $Folder;
              $image=$Path.$category['Category']['image'];
              $name = $category['Category']['name'];
              
            }
            if(isset($sid) && $sid != ""){
              $shop = $this->Shop->find('first', array('conditions' => array('Shop.id' => $sid)));
              $Folder = "shop_images/";
              $Path = $url . $Folder;
              $image=$Path.$shop['Shop']['logo'];
              $name = $shop['Shop']['name'];              
            }
            if(isset($lid) && $lid != ""){
              $city = $this->City->find('first', array('conditions' => array('City.id' => $lid)));
              $image="";
              $name = $city['City']['name'];              
            }
            $data = date('Y-m-d');
            $condition[] = array('Coupon.to_date >=' => $data, 'Coupon.is_active' => 1);

            //$category = $this->Category->find('first', array('conditions' => array('id' => $id)));

            
            $this->paginate = array(
            'limit' =>25,
            'conditions' => $condition,
            'order' => array(
                    'Coupon.id' => 'desc'
                ) 
            );
            $this->Paginator->settings = $this->paginate;

            //$this->Coupon->recursive = 0;
            $this->set('coupons', $this->Paginator->paginate());


            $allcategory = $this->Category->find("all",array('conditions'=>array('is_active'=> 1)));  
            $shops = $this->Shop->find("all",array('conditions'=>array('Shop.is_active'=> 1), 'fields'=>array('Shop.id', 'Shop.name')));

            $this->set(compact('category', 'allcategory', 'shops','name','image'));

    }
    
    
    
     public function redeem($id) {
            $title_for_layout='Redeem Coupon';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/');
            }
            $this->loadModel('User');
            $this->loadModel('Coupon');
            $this->loadModel('OfflineOrder');
            $id = base64_decode($id);
            $user = $this->User->find("first",array('conditions'=>array('User.id'=> $userid)));
            $options = array('conditions' => array('Coupon.id' => $id));
            $coupon_details = $this->Coupon->find('first', $options);
            
            if ($this->request->is(array('post', 'put'))) {
                
                
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet); // edited


            for ($i = 0; $i < 6; $i++) {
                $couponcode .= $codeAlphabet[random_int(0, $max - 1)];
            }

            $options = array('conditions' => array('OfflineOrder.coupon_code' => $couponcode));
            $code_ex = $this->OfflineOrder->find('all', $options);

            if (count($code_ex) > 0) {

                $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
                $codeAlphabet.= "0123456789";
                $max = strlen($codeAlphabet); // edited


                for ($i = 0; $i < 6; $i++) {
                    $couponcode .= $codeAlphabet[random_int(0, $max - 1)];
                }
            } else {

                
                $this->request->data['OfflineOrder']['coupon_code'] = $couponcode;
                $this->request->data['OfflineOrder']['book_name']=$this->request->data['OfflineOrder']['first_name']." ".$this->request->data['OfflineOrder']['last_name'];
                $this->request->data['OfflineOrder']['book_date'] = date('Y-m-d H:i:s');
                $cname=$this->request->data['OfflineOrder']['first_name']." ".$this->request->data['OfflineOrder']['last_name'];
                $cphone=$this->request->data['OfflineOrder']['book_phone'];
                $email=$this->request->data['OfflineOrder']['book_email'];
                $this->OfflineOrder->create();
               
                if ($this->OfflineOrder->save($this->request->data)) {
                  
                //qr code
                require_once 'phpqrcode/qrlib.php';
                $PNG_TEMP_DIR = Configure::read('QRB_IMAGE'); 
                $PNG_WEB_DIR = Configure::read('HTP_QRB_IMAGE'); 
                if (!file_exists($PNG_TEMP_DIR))
                    mkdir($PNG_TEMP_DIR);

                $filename = $PNG_TEMP_DIR . '/' . 'test.png';

                $errorCorrectionLevel = 'L';
                
                $matrixPointSize = 6;
               
                if (isset($couponcode)) {

                    //it's very important!
                    if (trim($couponcode) == '')
                        die('data cannot be empty! <a href="?">back</a>');

                    // user data
                    $filename = $PNG_WEB_DIR . '/' .'test'.md5($couponcode).'.png';
                    $img='test'.md5($couponcode).'.png';
                    QRcode::png($couponcode, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                } else {

                     QRcode::png('No Code Found :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                }


                $this->loadModel('EmailTemplate');
                $EmailTemplate = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' => 22)));
                $this->loadModel('User');
                
                $options = array('conditions' => array('Coupon.id' => $this->request->data['OfflineOrder']['coupon_id']));
                $coupon_detail = $this->Coupon->find('first', $options);
                
                
                $couponname = $coupon_detail['Coupon']['name'];
                $price = $coupon_detail['Coupon']['amount'];
                $exdate = $coupon_detail['Coupon']['to_date'];
                $offer = $coupon_detail['Coupon']['offer'].'% Discount';
                $seller = $coupon_detail['User']['first_name'].' '.$tempid['User']['last_name'];
                $shop = $coupon_detail['Shop']['name'];
                $image = "<img src='http://111.93.169.90/team6/deal/htp_qr_images/$img'>";
                $mail_body = str_replace(array('[NAME]', '[PRICE]', '[EXDATE]', '[CODE]','[CODETEXT]','[OFFER]','[SELLER]','[SHOP]','[CNAME]','[CMAIL]','[CPHONE]'), array($couponname, $price, $exdate, $image,$couponcode,$offer,$seller,$shop,$cname,$email,$cphone,), $EmailTemplate['EmailTemplate']['content']);

                $this->send_smtpmail($email, 'nits.santanupatra@gmail.com', 'Coupon code', $mail_body);
            
               return $this->redirect(array('action' => 'success'));
                    
                } else {
                    $this->Session->setFlash(__('Booking could not be saved. Please, try again.'));
                }
            }
            }
            
            
            $this->set(compact('title_for_layout','user','coupon_details'));
	}
    
    public function success(){
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }
    }
    
    
}
