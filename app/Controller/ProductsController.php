<?php

App::uses('AppController', 'Controller');

/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 */
class ProductsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    var $currency_value = array('USD', 'INR');
    public $components = array('Paginator','Imagethumb');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('currency_value', $this->currency_value);

        $this->Auth->allow('ajax_add_to_cart','fetch_size' ,'filter_search', 'ajax_add_to_wishlist', 'product_details', 'search_result', 'search', 'search_option', 'appinventorylist', 'index', 'app_product_list', 'product_list', 'appProductDetails', 'category_related_product', 'subcategory_related_product', 'prodoct_related_rating', 'shop_related_rating', 'shop_related_positive_rating', 'get_product_img', 'get_product_main_image', 'getwishlistcount', 'getcatprd_cnt', 'admin_color_list', 'admin_color_add','admin_fetchshop','details');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        //$this->loadModel('ProductImage');
        $title_for_layout = 'Product List';
        $this->loadModel('User');

        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if ((!isset($userid) && $userid == '') || $utype != 'V') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }



        $this->paginate = array('conditions' => array('Product.user_id' => $userid), 'limit' => 10, 'order' => array('Product.id' => 'desc'),
        );
        $this->Paginator->settings = $this->paginate;
        //$this->Product->recursive = 1;
        $this->set('products', $this->Paginator->paginate('Product'));
    }

    public function product_list($cid) {
        $this->loadModel('Category');
        $cid = base64_decode($cid);
        $title_for_layout = 'Product List';

        $category = $this->Category->find('first', array('conditions' => array('id' => $cid)));

        $this->paginate = array('conditions' => array('category_id' => $cid), 'limit' => 10, 'order' => array('Product.id' => 'desc'),
        );
        $this->Paginator->settings = $this->paginate;
        //$this->Product->recursive = 1;
        $this->set('products', $this->Paginator->paginate('Product'));
        $this->set(compact('category'));
    }

    public function details($id){

         $this->loadModel('Category');
         $id = base64_decode($id);
         $details = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
         $this->set(compact('details'));
    }

    public function admin_index() {
        $this->Product->recursive = 0;
        $this->set('products', $this->Paginator->paginate());
    }

    public function getwishlistcount($product_id = null, $user_id = null) {
        $this->loadModel('Wishlist');
        $wishlist_count = 0;
        $options = array('conditions' => array('Wishlist.product_id' => $product_id, 'Wishlist.user_id' => $user_id));
        $wishlist = $this->Wishlist->find('first', $options);
        if (!empty($wishlist)) {
            $wishlist_count = 1;
        }
        return $wishlist_count;
    }

    public function admin_color_list() {

        $this->loadModel('Color');
        $this->set('colors', $this->Paginator->paginate('Color'));
    }

    public function getcatprd_cnt($cat_id = null, $type = null) {
        $this->autoRender = false;
        $prd_count = 0;
        if ($type == 1) {
            $options = array('conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0, 'Product.category_id' => $cat_id));
        } elseif ($type == 2) {
            $options = array('conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0, 'Product.sub_category_id' => $cat_id));
        } else {
            $options = array('conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0, 'Product.category_id' => $cat_id));
        }

        $prd_count = $this->Product->find('count', $options);
        return $prd_count;
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null, $cid = null) {
        $id = base64_decode($id);
        if (!$this->Product->exists($id)) {
            $this->Session->setFlash(__('Invalid product.'));
            return $this->redirect('products/list/');
        }
        $userid = $this->Session->read('Auth.User.id');
        $this->loadModel('Category');
        $this->loadModel('Wishlist');
        $this->loadModel('Shop');
        $wishlist_count = 0;
        $wishlist = array();
        if (!empty($userid)) {
            $options = array('conditions' => array('Wishlist.product_id' => $id, 'Wishlist.user_id' => $userid));
            $wishlist = $this->Wishlist->find('first', $options);
            $wishlist_count = count($wishlist);
            if (!empty($wishlist)) {
                $wishlist_count = 1;
            }
        }
        //pr($wishlist);
        //echo $wishlist_count;
        $this->Product->recursive = 1;
        $userid = $this->Session->read('Auth.User.id');

        $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
        $product = $this->Product->find('first', $options);

        $options = array('conditions' => array('Category.id' => $product['Product']['sub_category_id']));
        $subcat = $this->Category->find('first', $options);

        $options = array('conditions' => array('Shop.id' => $product['Product']['shop_id']));
        $shop = $this->Shop->find('first', $options);
        //pr($shop);

        $title_for_layout = $product['Product']['name'];

        $options = array('conditions' => array('Product.id !=' => $id, 'Product.status' => 'A', 'Product.is_deleted' => 0, 'Product.shop_id !=' => $product['Product']['shop_id']), 'order' => 'Product.views DESC', 'limit' => '8');
        $popular_products = $this->Product->find('all', $options);

        $options = array('conditions' => array('Product.id !=' => $id, 'Product.status' => 'A', 'Product.is_deleted' => 0, 'Product.shop_id' => $product['Product']['shop_id']), 'order' => 'Product.last_view_date DESC');
        $same_products = $this->Product->find('all', $options);

        $options = array('conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0), 'limit' => '6');
        $releated_products = $this->Product->find('all', $options);


        if ($cid != '') {
            $options = array('conditions' => array('Category.id' => $cid));
            $categorypro = $this->Category->find('first', $options);
            //echo '<pre>';print_r($category);
            if (!empty($categorypro)) {
                if (empty($categorypro['ParentCategory']['id']))
                    $conditions['AND']['Product.category_id = '] = $categorypro['Category']['id'];
                else
                    $conditions['AND']['Product.sub_category_id = '] = $categorypro['Category']['id'];
            }
        }
        $this->set(compact('title_for_layout', 'product', 'shop', 'categorypro', 'categories', 'popular_products', 'same_products', 'releated_products', 'userid', 'wishlist_count', 'wishlist'));
    }

    public function admin_view($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
        $this->set('product', $this->Product->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->loadModel('User');
        
        $title_for_layout = 'Add Deal';
        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');

        if ((!isset($userid) && $userid == '') || $utype != 'V') {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
            $user = $this->User->find('first', $options);

            if ($this->request->is('post')) {

              $this->Product->create();
              $this->request->data['Product']['created_at'] = gmdate('Y-m-d H:i:s');

              $this->request->data['Product']['status'] = $this->request->data['Product']['status'];
               
       if(!empty($this->request->data['Product']['product_image']['name'])){
      $pathpart=pathinfo($this->request->data['Product']['product_image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "product_images/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Product']['product_image']['tmp_name'],$full_flg_path);
      $this->Imagethumb->generateThumb(WWW_ROOT .'product_images/', WWW_ROOT."product_images/thumbs/",$thumb_img_width='350', $filename);
      
      //echo WWW_ROOT;exit;
      }
      
      else{
       $this->Session->setFlash(__('Invalid image type.'));
      }
     }
     else{
      $filename='';
     }
        $this->request->data['Product']['product_image']= $filename;
                
       // print_r($this->request->data);exit;      
                if ($this->Product->save($this->request->data)) {

                    $this->Session->setFlash('The Deal has been saved.', 'default', array('class' => 'success'));
                    //return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Deal could not be saved. Please, try again.'));
                }
            }

            $categories = $this->Product->Category->find('all',array('conditions'=>array('Category.is_active'=>1, 'Category.type'=> 'D')));
            
            $this->loadModel('Shop'); 
            $shops = $this->Shop->find('all', array('conditions' => array('Shop.is_active' => 1, 'Shop.user_id'=> $userid)));

            $status = array('A' => 'Active', 'P' => 'Pending', 'I' => 'Inactive');
            
            
        $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
            
           
            $this->set(compact('user', 'categories',  'status', 'title_for_layout','shops','cities'));
        }
    }

    public function admin_color_add() {


        $title_for_layout = 'Add Color';
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/admin');
        }

        if ($this->request->is('post')) {

            $this->loadModel('Color');
            $this->request->data['Color']['color_name'] = $this->request->data['Color']['color_name'];


            $this->Color->create();

            if ($this->Color->save($this->request->data)) {

                $this->Session->setFlash('Color has been saved.', 'default', array('class' => 'success'));
                return $this->redirect(array('action' => 'color_list'));
            } else {
                $this->Session->setFlash(__('Color could not be saved. Please, try again.', 'default', array('class' => 'error')));
            }
        }
    }

    public function admin_add() {


        //$userid = $this->request->data['Product']['user_id'];
        //$this->loadModel('ProductVariation');
        if ($this->request->is('post')) {
            if (isset($this->request->data['Product']['user_id']) && !empty($this->request->data['Product']['user_id'])) {
                $this->Product->create();

                $this->request->data['Product']['created_at'] = gmdate('Y-m-d H:i:s');
                
               
                
                if(!empty($this->request->data['Product']['product_image']['name'])){
      $pathpart=pathinfo($this->request->data['Product']['product_image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "product_images/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Product']['product_image']['tmp_name'],$full_flg_path);
      $this->Imagethumb->generateThumb(WWW_ROOT .'product_images/', WWW_ROOT."product_images/thumbs/",$thumb_img_width='350', $filename);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
      }
     }
     else{
      $filename='';
     }
        $this->request->data['Product']['product_image']= $filename;       
                
                
                if ($this->Product->save($this->request->data)) {
                    
                    

                    $user_id = $this->request->data['Product']['user_id'];
                    $description = 'Added a new product ' . $this->request->data['Product']['name'];
                    $this->save_activity($user_id, $description);

                    $this->Session->setFlash('The product has been saved.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
                }
            } else {
                $this->Session->setFlash(__('Please choose User name from auto suggest.'));
            }
        }
        $users = $this->Product->User->find('all', array('conditions' => array('User.is_active' => 1, 'User.is_admin !=' => 1,'User.type'=>'V')));
        $categories = $this->Product->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type'=>'D')));
        
       
       $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
       
       //pr($cities);
       
        $status = array('A' => 'Active', 'P' => 'Pending', 'I' => 'Inactive');

       

        $this->set(compact('users', 'categories', 'status','cities'));
    }
    
    
    function admin_fetchshop() {
        $this->loadModel('Shop');
        $seller_id= $_REQUEST['seller_id'];
        
        $shops = $this->Shop->find('all', array('conditions' => array('Shop.is_active' => 1, 'Shop.user_id'=> $seller_id)));

       
        if (!empty($shops)) {
            $data = array('Ack' => 1, 'data' => $shops);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }
    
    
    
    

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        $this->loadModel('User');
       
        $title_for_layout = 'Edit Deal';
        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if ((!isset($userid) && $userid == '') || $utype != 'V') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('action' => 'login'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
        $user = $this->User->find('first', $options);


        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['Product']['user_id']) && !empty($this->request->data['Product']['user_id'])) {
                
               
                if ($this->Product->save($this->request->data)) {


                    $this->Session->setFlash('The Deal has been updated.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'edit/' . $id));
                } else {
                    $this->Session->setFlash(__('The Deal could not be updated. Please, try again.'));
                    return $this->redirect(array('action' => 'edit/' . $id));
                }
            } else {
                $this->Session->setFlash(__('Please choose User name from auto suggest.'));
                return $this->redirect(array('action' => 'edit/' . $id));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }

        
        $categories = $this->Product->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type' => 'D')));
        
         $this->loadModel('Shop'); 
         $shops = $this->Shop->find('all', array('conditions' => array('Shop.is_active' => 1, 'Shop.user_id'=> $userid)));
         
        $status = array('A' => 'Active', 'P' => 'Pending', 'I' => 'Inactive');
        
        
        $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
        
        
        
        $this->set(compact('user', 'categories', 'status','shops','cities'));
    }

    public function edit_product($id = null) {
        $this->loadModel('ShippingDay');
        $this->loadModel('User');
        $this->loadModel('ProductImage');
        $this->loadModel('ProductVariation');
        $title_for_layout = 'Edit product';
        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if ((!isset($userid) && $userid == '') || $utype != 'C') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('action' => 'login'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
        $user = $this->User->find('first', $options);


        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            //if($this->request->data['Product']['sale_on'] == 'Y'){
            //$this->request->data['Product']['sales_price']=($this->request->data['Product']['price_lot']-($this->request->data['Product']['price_lot']*$this->request->data['Product']['discount'])/100);
            //}
            $this->request->data['Product']['shipping_time'] = implode(',', $this->request->data['Product']['shipping_time']);
            if ($this->Product->save($this->request->data)) {

                $variation = $this->request->data['ProductVariation']['color_id'];
                $price = $this->request->data['ProductVariation']['price'];
                $size = $this->request->data['ProductVariation']['size'];
                $vid = $this->request->data['ProductVariation']['id'];
                if (!empty($variation) && !empty($price) && empty($size)) {
                    for ($i = 0; $i < count($variation); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $id;
                        $this->request->data['ProductVariation']['color_id'] = $variation[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->request->data['ProductVariation']['id'] = $vid[$i];
                        $this->ProductVariation->save($this->request->data);
                    }
                }else if (!empty($size) && !empty($price) && empty($variation)) {
                    for ($i = 0; $i < count($size); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $id;
                        $this->request->data['ProductVariation']['size'] = $size[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->request->data['ProductVariation']['id'] = $vid[$i];
                        $this->ProductVariation->save($this->request->data);
                    }
                }else {
                    for ($i = 0; $i < count($size); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $id;
                        $this->request->data['ProductVariation']['color_id'] = $variation[$i];
                        $this->request->data['ProductVariation']['size'] = $size[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->request->data['ProductVariation']['id'] = $vid[$i];
                        $this->ProductVariation->save($this->request->data);
                    }
                }

                if ($this->request->data['Product']['product_image_name'] != '') {
                    $file_image_name = (explode(",", $this->request->data['Product']['product_image_name']));
                    //print_r($file_image_name);exit;
                    foreach ($file_image_name as $img) {
                        $this->request->data['ProductImage']['product_id'] = $id;
                        $this->request->data['ProductImage']['name'] = $img;
                        $this->ProductImage->create();
                        if ($this->ProductImage->save($this->request->data)) {
                            // $last_id = $this->ProductImage->getInsertID();
                            //$file = array('filename' => $filename, 'last_id' => $last_id);
                        }
                    }
                }


                $this->Session->setFlash('The product has been updated.', 'default', array('class' => 'success'));
                return $this->redirect(array('action' => 'edit_product/' . $id));
            } else {
                $this->Session->setFlash(__('The product could not be updated. Please, try again.'));
                return $this->redirect(array('action' => 'edit_product/' . $id));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }

        //$users = $this->Product->User->find('list',array('fields'=>array('User.id','User.first_name'), 'conditions'=>array('User.is_active'=>1, 'User.is_admin !='=>1)));
        $categories = $this->Product->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.parent_id' => 0)));
        if ($this->request->data['Product']['category_id'] != '') {
            $sub_categories = $this->Product->Category->find('list', array('conditions' => array('Category.is_active' => 1, 'Category.parent_id' => $this->request->data['Product']['category_id'])));
        } else {
            $sub_categories = '';
        }


        $this->ProductImage->recursive = 0;
        $all_image = $this->ProductImage->find('all', array('conditions' => array('ProductImage.product_id' => $id), 'order' => array('is_order' => 'asc')));
        $this->loadModel('ProductVariation');
        $colorprice = $this->ProductVariation->find('all', array('conditions' => array('ProductVariation.product_id' => $id)));
        $ships = $this->ShippingDay->find('all', array('conditions' => array('user_id' => $userid)));
        $this->loadModel('Color');
        $colors = $this->Color->find('all');

        $this->set(compact('user', 'all_image', 'colors', 'categories', 'status', 'sub_categories', 'ships', 'colorprice'));
    }

    public function admin_edit($id = null) {

        
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['Product']['user_id']) && !empty($this->request->data['Product']['user_id'])) {
                

                if(!empty($this->request->data['Product']['product_image']['name'])){
        $pathpart=pathinfo($this->request->data['Product']['product_image']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "product_images/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Product']['product_image']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
        }
       }
       else{
        $filename=$this->request->data['Product']['hid_img'];
       }

       $this->request->data['Product']['product_image']=$filename;
       if($this->request->data['Product']['shop_id']==""){
       $this->request->data['Product']['shop_id'] = $this->request->data['Product']['hid_shop_id'];
       }
                if ($this->Product->save($this->request->data)) {
                    
                   


                    $this->Session->setFlash('The product has been saved.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
                    return $this->redirect(array('action' => 'edit/' . $id));
                }
            } else {
                $this->Session->setFlash(__('Please choose User name from auto suggest.'));
                return $this->redirect(array('action' => 'edit/' . $id));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }

        $users = $this->Product->User->find('all', array('conditions' => array('User.is_active' => 1, 'User.is_admin !=' => 1,'User.type'=>'V')));
        $categories = $this->Product->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.type'=>'D')));
        
        
        $status = array('A' => 'Active', 'P' => 'Pending', 'I' => 'Inactive');


        

        $puserid = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
       
        $this->loadModel('City');
       $cities = $this->City->find('all', array('conditions' => array('City.is_active' => 1)));
        
        
        
        $this->set(compact('users', 'categories', 'status','cities'));
    }

    public function admin_color_edit($id = null) {
        $this->loadModel('Color');
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/admin');
        }

        $this->request->data1 = array();
        $title_for_layout = 'Edit Color';
        $this->set(compact('title_for_layout'));

        if (!$this->Color->exists($id)) {
            throw new NotFoundException(__('Invalid Color'));
        }
        if ($this->request->is(array('post', 'put'))) {

            $this->loadModel('Color');

            $this->request->data['Color']['color_name'] = $this->request->data['Color']['color_name'];


            if ($this->Color->save($this->request->data)) {


                $this->Session->setFlash('The color has been saved.', 'default', array('class' => 'success'));
                //return $this->redirect(array('action' => 'list'));
            } else {
                $this->Session->setFlash(__('The color could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Color.' . $this->Color->primaryKey => $id));
            $this->request->data = $this->Color->find('first', $options);
        }
    }

    public function admin_delete_color($id = null) {

        $this->loadModel('Color');
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/admin');
        }
        $this->Color->id = $id;
        if (!$this->Color->exists()) {
            throw new NotFoundException(__('Invalid Color'));
        }
        if ($this->Color->delete($id)) {
            $this->Session->setFlash('The Color has been deleted.', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('The Color could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'admin_color_list'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        //$this->request->allowMethod('post', 'delete');
        if ($this->Product->delete($id)) {
            $this->Session->setFlash(__('The product has been deleted.'));
        } else {
            $this->Session->setFlash(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function delete_product($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        //$this->request->allowMethod('post', 'delete');
        if ($this->Product->delete($id)) {
            $this->Session->setFlash(__('The product has been deleted.'));
        } else {
            $this->Session->setFlash(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'list_product'));
    }

    public function admin_delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        #$this->request->allowMethod('post', 'delete');
        if ($this->Product->delete($id)) {
            $this->Session->setFlash('The product has been deleted.', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function delete_image() {
        $this->autoRender = false;
        $this->loadModel('ProductImage');
        if ($this->ProductImage->delete($_REQUEST['id'])) {
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function delete_variation() {

        $this->autoRender = false;
        $this->loadModel('ProductVariation');
        $id = $_REQUEST['id'];
        
        if ($this->ProductVariation->delete($_REQUEST['id'])) {
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function admin_delete_image() {
        $this->autoRender = false;
        $this->loadModel('ProductImage');
        if ($this->ProductImage->delete($_REQUEST['id'])) {
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }
    
    public function admin_delete_variation() {

        $this->autoRender = false;
        $this->loadModel('ProductVariation');
        $id = $_REQUEST['id'];
        
        if ($this->ProductVariation->delete($_REQUEST['id'])) {
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }
    
    

    public function upload_photo_add($product_id = null) {

        $this->autoRender = false;
        $this->layout = false;
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files']['name'])) {

            $no_files = count($_FILES["files"]['name']);

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "product_images/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {
                        //echo $product_id;exit;
                        $this->request->data['ProductImage']['product_id'] = $product_id;
                        $this->request->data['ProductImage']['name'] = $filename;
                        //echo $filename,exit;
                        //$this->admin_resize($full_flg_path, $filename,$ext);
                        if ($file == '') {
                            $filen = $filename;
                        } else {
                            $filen = $filen . ',' . $filename;
                        }
                        $file = array('filename' => $filename, 'last_id' => $i + 1);
                    }
                    $file_details[] = $file;
                }
            }
            $data = array('Ack' => 1, 'data' => $file_details, 'image_name' => $filen);
        } else {

            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function admin_upload_photo_add($product_id = null) {

        $this->autoRender = false;
        $this->layout = false;
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files']['name'])) {

            $no_files = count($_FILES["files"]['name']);

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "product_images/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {
                        //echo $product_id;exit;
                        $this->request->data['ProductImage']['product_id'] = $product_id;
                        $this->request->data['ProductImage']['name'] = $filename;
                        //echo $filename,exit;
                        //$this->admin_resize($full_flg_path, $filename,$ext);
                        if ($file == '') {
                            $filen = $filename;
                        } else {
                            $filen = $filen . ',' . $filename;
                        }
                        $file = array('filename' => $filename, 'last_id' => $i + 1);
                    }
                    $file_details[] = $file;
                }
            }
            $data = array('Ack' => 1, 'data' => $file_details, 'image_name' => $filen);
        } else {

            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function order_image() {
        $this->autoRender = false;
        $this->loadModel('ProductImage');
        $i = 1;
        //echo $i;exit;
        foreach ($_REQUEST['ids'] as $id) {
            $data['ProductImage']['is_order'] = $i;
            $data['ProductImage']['id'] = $id;
            $this->ProductImage->save($data);
            $i++;
        }
        echo json_encode(array('Ack' => 1));
        die;
    }

    public function admin_uploadimage($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        $this->loadModel('ProductImage');
        $this->ProductImage->recursive = 0;
        $this->set('productimages', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
    }

    public function uploadimage($id = null) {

        $userid = $this->Session->read('Auth.User.id');

        if ((!isset($userid) && $userid == '')) {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'User', 'action' => 'login'));
        }
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        $this->loadModel('ProductImage');
        $this->ProductImage->recursive = 0;
        $this->set('productimages', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
    }

    public function vendor_uploadimage($id = null) {

        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');

        if ((!isset($userid) && $userid == '') || $utype != 'V') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'User', 'action' => 'login'));
        }
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        $this->loadModel('ProductImage');
        $this->ProductImage->recursive = 0;
        $this->set('productimages', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
    }

    public function admin_imagedelete($id = null, $pro_id = null) {
        $this->loadModel('ProductImage');
        $this->ProductImage->id = $id;
        if (!$this->ProductImage->exists()) {
            throw new NotFoundException(__('Invalid product image'));
        }
        #$this->request->allowMethod('post', 'delete');
        if ($this->ProductImage->delete($id)) {
            $this->Session->setFlash('The product image has been deleted.', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('The product image could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'uploadimage', $pro_id));
    }

    public function imagedelete($id = null, $pro_id = null) {
        $this->loadModel('ProductImage');
        $this->ProductImage->id = $id;
        if (!$this->ProductImage->exists()) {
            throw new NotFoundException(__('Invalid product image'));
        }
        #$this->request->allowMethod('post', 'delete');
        if ($this->ProductImage->delete($id)) {
            $this->Session->setFlash('The product image has been deleted.', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('The product image could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'uploadimage', $pro_id));
    }

    public function getSubcat($parent_id = null) {
        $data = '';
        if ($parent_id != '') {
            $categories = $this->Product->Category->find('list', array('conditions' => array('Category.is_active' => 1, 'Category.parent_id' => $parent_id)));
            if ($categories) {
                $data = '<select name="data[Product][sub_category_id]" id="ProductSubCategoryId"><option value="">Select</option>';
                foreach ($categories as $k => $v) {
                    $data.='<option value="' . $k . '">' . $v . '</option>';
                }
                $data.='</select>';
            }
        }
        echo $data;
        exit;
    }

    public function getSubcatname($cat_id = null) {
        $data = '';
        if ($cat_id != '') {
            $category = $this->Product->Category->find('first', array('conditions' => array('Category.id' => $cat_id)));
            if ($category) {
                $data = $category['Category']['name'];
            } else {
                $data = '';
            }
        }
        return $data;
        exit;
    }

    public function admin_uploadProduct($id = null) {
        $this->autoRender = false;
        $imagename = $_FILES['file']['name'];
        $uploadPath = Configure::read('PRODUCT_IMAGE_UPLOAD_PATH');
        $v = $imagename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath . '/' . $imagename);
        $this->loadModel('ProductImage');
        $productupdate['ProductImage']['product_id'] = $id;
        $productupdate['ProductImage']['name'] = $imagename;
        $this->ProductImage->save($productupdate);
        $this->ProductImage->recursive = 0;
        $this->set('productimages', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
    }

    public function uploadProduct($id = null) {
        $this->autoRender = false;
        $imagename = $_FILES['file']['name'];
        $uploadPath = Configure::read('PRODUCT_IMAGE_UPLOAD_PATH');
        $v = $imagename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath . '/' . $imagename);
        $this->loadModel('ProductImage');
        $productupdate['ProductImage']['product_id'] = $id;
        $productupdate['ProductImage']['name'] = $imagename;
        $this->ProductImage->save($productupdate);
        $this->ProductImage->recursive = 0;
        $this->set('productimages', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
    }

    public function add_product() {
        $this->loadModel('User');
        $this->loadModel('ShippingDay');
        $this->loadModel('ProductImage');
        $this->loadModel('Color');
        $this->loadModel('ProductVariation');
        $title_for_layout = 'Add product';
        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if ((!isset($userid) && $userid == '') || $utype != 'C') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'User', 'action' => 'login'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
        $user = $this->User->find('first', $options);

        if ($this->request->is('post')) {


            //if(isset($this->request->data['Product']['user_id']) && !empty($this->request->data['Product']['user_id']))
            //{
            $options = array('conditions' => array('Product.user_id' => $userid));
            $total = $this->Product->find('count', $options);
            //echo $total;         
            if ($total < 10) {
                $this->Product->create();
                $this->request->data['Product']['created_at'] = gmdate('Y-m-d H:i:s');
                $this->request->data['Product']['shipping_time'] = implode(',', $this->request->data['Product']['shipping_time']);
                //if($this->request->data['Product']['sale_on'] == 'Y'){
                // $this->request->data['Product']['sales_price']=($this->request->data['Product']['price_lot']-($this->request->data['Product']['price_lot']*$this->request->data['Product']['discount'])/100);
                //}
                //$this->request->data['Product']['size'] = implode(',',$this->request->data['Product']['size']);
                //$this->request->data['Product']['colour'] = $this->request->data['Product']['colour'];

                $this->request->data['Product']['status'] = $this->request->data['Product']['status'];
                if ($this->Product->save($this->request->data)) {

                    //for variation insert
                    $variation = $this->request->data['ProductVariation']['color_id'];
                    $size = $this->request->data['ProductVariation']['size'];
                    $price = $this->request->data['ProductVariation']['price'];

                    if(!empty($variation) && empty($size)){
                    for ($i = 0; $i < count($variation); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductVariation']['color_id'] = $variation[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->ProductVariation->create();
                        $this->ProductVariation->save($this->request->data);
                    }
                    }
                    
                    else if(empty($variation) && !empty($size)){
                    for ($i = 0; $i < count($size); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductVariation']['size'] = $size[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->ProductVariation->create();
                        $this->ProductVariation->save($this->request->data);
                    }
                    }else{
                        
                      for ($i = 0; $i < count($size); $i++) {

                        $this->request->data['ProductVariation']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductVariation']['color_id'] = $variation[$i];
                        $this->request->data['ProductVariation']['size'] = $size[$i];
                        $this->request->data['ProductVariation']['price'] = $price[$i];
                        $this->ProductVariation->create();
                        $this->ProductVariation->save($this->request->data);
                    }  
                        
                    }
                    
                    //variation insert end
                    

                    $file_image_name = (explode(",", $this->request->data['Product']['product_image_name']));
                    //print_r($file_image_name);exit;
                    foreach ($file_image_name as $img) {
                        $this->request->data['ProductImage']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductImage']['name'] = $img;
                        $this->ProductImage->create();
                        if ($this->ProductImage->save($this->request->data)) {
                            // $last_id = $this->ProductImage->getInsertID();
                            //$file = array('filename' => $filename, 'last_id' => $last_id);
                        }
                    }

                    $user_id = $this->request->data['Product']['user_id'];
                    $description = 'Added a new product ' . $this->request->data['Product']['name'];
                    $this->save_activity($user_id, $description);

                    $this->Session->setFlash('The product has been saved.', 'default', array('class' => 'success'));
                    //return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
                }
            } else {
                $this->Session->setFlash(__('You can not upload more than 10 products.'));
            }
            //}
        }

        $categories = $this->Product->Category->find('all', array('conditions' => array('Category.is_active' => 1, 'Category.parent_id' => 0)));

        $ships = $this->ShippingDay->find('all', array('conditions' => array('user_id' => $userid)));
        $colors = $this->Color->find('all');

        $status = array('A' => 'Active', 'P' => 'Pending', 'I' => 'Inactive');

        $this->set(compact('user', 'status', 'colors', 'categories', 'ships', 'is_featured', 'unit_type', 'sale_on', 'status', 'shipping_time', 'processing_time', 'title_for_layout'));
    }

    public function pay_product() {
        //$id = base64_decode($id);
        $userid = $this->Session->read('Auth.User.id');
        $prods = $this->Product->find('all', array('conditions' => array('Product.user_id' => $userid, 'Product.status' => 'P', 'Product.is_deleted' => 0)));
        if (empty($prods)) {
            $this->Session->setFlash('Sorry no product found as pending to do the payment.', 'default', array('class' => 'cake-error'));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        }
        $this->loadModel('SiteSetting');
        $sitesettings = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1)));
        $this->set(compact('prods', 'sitesettings'));
    }

    public function pay_multiproduct() {
        $this->loadModel('SiteSetting');
        $this->loadModel('ManageInventory');
        $userid = $this->Session->read('Auth.User.id');
        $sitesettings = $this->SiteSetting->find('first', array('conditions' => array('SiteSetting.id' => 1)));
        if ($this->request->is('post')) {
            //pr($this->request->data);exit;
            if (isset($this->request->data['QuantitySubmit']) && $this->request->data['QuantitySubmit'] != '') {
                $QuantitySubmit = $this->request->data['QuantitySubmit'];
                $previous_quantity = $this->request->data['previous_quantity'][$QuantitySubmit];
                $current_quantity = $this->request->data['quantity'][$QuantitySubmit];
                $price_lot = $this->request->data['price_lot'][$QuantitySubmit];
                $cal_quantity = ($current_quantity - $previous_quantity);
                if ($cal_quantity < 0) {
                    $inventory_data['ManageInventory']['type'] = '-';
                    $inventory_data['ManageInventory']['comment'] = 'Seller removed stock.';
                } elseif ($cal_quantity > 0) {
                    $inventory_data['ManageInventory']['type'] = '+';
                    $inventory_data['ManageInventory']['comment'] = 'Seller added stock.';
                }
                $product_details = $this->Product->find('first', array('conditions' => array('Product.id' => $QuantitySubmit)));
                if ($cal_quantity != 0) {
                    $inventory_data['ManageInventory']['product_id'] = $QuantitySubmit;
                    $inventory_data['ManageInventory']['quantity'] = $cal_quantity;
                    $inventory_data['ManageInventory']['price'] = $price_lot;
                    $inventory_data['ManageInventory']['user_id'] = $userid;
                    $inventory_data['ManageInventory']['create_date'] = gmdate('Y-m-d H:i:s');
                    //if($cal_quantity!=0){
                    $this->ManageInventory->create();
                    $this->ManageInventory->save($inventory_data);

                    $prd_data['Product']['id'] = $QuantitySubmit;
                    $prd_data['Product']['quantity'] = $current_quantity;
                    $prd_data['Product']['price_lot'] = $price_lot;
                    if (!empty($product_details)) {
                        //if($product_details['Product']['sale_on'] == 'Y'){
                        $prd_data['Product']['sales_price'] = ($prd_data['Product']['price_lot'] - ($prd_data['Product']['price_lot'] * $product_details['Product']['discount']) / 100);
                        //}
                    }
                    $this->Product->save($prd_data);
                    //}
                    $this->Session->setFlash('You have successully update the inventory.', 'default', array('class' => 'success'));
                } else {
                    $prd_data['Product']['id'] = $QuantitySubmit;
                    //$prd_data['Product']['quantity'] = $current_quantity;
                    $prd_data['Product']['price_lot'] = $price_lot;
                    if (!empty($product_details)) {
                        //if($product_details['Product']['sale_on'] == 'Y'){
                        $prd_data['Product']['sales_price'] = ($prd_data['Product']['price_lot'] - ($prd_data['Product']['price_lot'] * $product_details['Product']['discount']) / 100);
                        //}
                    }
                    $this->Product->save($prd_data);
                    $this->Session->setFlash('You have successully update the inventory Price.', 'default', array('class' => 'success'));
                }
                return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
            } else {
                $cntprd = count($this->request->data['Product']['id']);
                if ($cntprd > 0) {
                    $prods = $this->Product->find('all', array('conditions' => array('Product.id' => $this->request->data['Product']['id'], 'Product.status' => 'P', 'Product.is_deleted' => 0)));
                    if (empty($prods)) {
                        $this->Session->setFlash('Sorry no product found as pending to do the payment.', 'default', array('class' => 'cake-error'));
                        return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
                    }
                } else {
                    $this->Session->setFlash('Please select product to Pay.', 'default', array('class' => 'cake-error'));
                    return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
                }
            }
        } else {
            $this->Session->setFlash('Please select product to Pay.', 'default', array('class' => 'cake-error'));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        }
        $this->set(compact('prods', 'sitesettings'));
    }

    public function success() {
        //pr($_REQUEST);exit;
        $this->loadModel('Shop');
        $this->loadModel('User');
        $this->loadModel('Product');
        $userid = $this->Session->read('Auth.User.id');

        if ($_REQUEST['txn_id']) {
            $custom = explode('|', $_REQUEST['custom']);
            $cntpr = count($custom);
            for ($i = 0; $i < $cntpr; $i++) {
                $arr['Product']['id'] = base64_decode($custom[$i]);
                $arr['Product']['status'] = 'A';
                $arr['Product']['paid_on'] = gmdate('Y-m-d h:i:s');
                $time = strtotime(date('Y-m-d'));
                $this->Product->save($arr);
            }
            $this->loadModel('Payment');
            $arr1 = array();

            $arr1['Payment']['userid'] = $userid;
            $arr1['Payment']['amount'] = $_REQUEST['mc_gross'];
            $arr1['Payment']['datetime'] = gmdate('Y-m-d H:i:s');
            $arr1['Payment']['status'] = $_REQUEST['payment_status'];
            $arr1['Payment']['transaction_id'] = $_REQUEST['txn_id'];
            $arr1['Payment']['quantity'] = $cntpr;
            $arr1['Payment']['for'] = 'for product post';
            $arr1['Payment']['type'] = 1;
            $this->Payment->create();
            $this->Payment->save($arr1);

            $this->Session->setFlash('You have successfully paid for the product to post it to the site.', 'default', array('class' => 'success'));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        } else {
            $this->Session->setFlash('Sorry payment was not successful. Please try again', 'default', array('class' => 'cake-error'));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        }
    }

    public function failure() {
        $this->Session->setFlash('Sorry payment was not successful. Please try again', 'default', array('class' => 'error'));
        return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
    }

    public function featured_product($prd_id = null) {
        $title_for_layout = 'Featured Product';
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->Session->setFlash(__('Please login to featured product.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'signin'));
        }
        if (!isset($prd_id) && $prd_id == '') {
            $this->Session->setFlash(__('Invalid product id.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        }
        $id = base64_decode($prd_id);
        $options = array('conditions' => array('Product.id' => $id));
        $prd_exists = $this->Product->find('first', $options);
        if (count($prd_exists) == 0) {
            $this->Session->setFlash(__('Invalid product id.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
        }
        $this->set(compact('title_for_layout', 'prd_id', 'prd_exists', 'userid'));
    }

    public function featured_product_success() {

        $status = 'Completed';
        $date = gmdate('Y-m-d H:i:s');
        $this->loadModel('FeaturedProduct');
        $this->loadModel('Payment');
        $this->loadModel('SiteSetting');
        $arr = array();

        $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
        $sitesetting = $this->SiteSetting->find('first', $options_set);
        $custom_data = $_REQUEST['custom'];
        if ($custom_data != '') {
            $custom_data_exp = explode('|', $custom_data);
            $userid = $custom_data_exp[1];
            $prd_id = base64_decode($custom_data_exp[0]);
            $arr['Product']['id'] = $prd_id;
            $arr['Product']['is_featured'] = 'Y';
            if ($this->Product->save($arr)) {

                $options_prd = array('conditions' => array('FeaturedProduct.cdate' => gmdate('Y-m-d'), 'FeaturedProduct.prd_id' => $prd_id, 'FeaturedProduct.user_id' => $userid));
                $prd_exist = $this->FeaturedProduct->find('first', $options_prd);

                $options_prd_det = array('conditions' => array('Product.id' => $prd_id));
                $prd_details = $this->Product->find('first', $options_prd_det);
                if (empty($prd_exist)) {
                    $feature_shop_free_days = $sitesetting['SiteSetting']['feature_product_paid_days'];
                    $end_date = gmdate('Y-m-d H:i:s', strtotime("+" . $feature_shop_free_days . " days"));

                    $data_shop['FeaturedProduct']['user_id'] = $userid;
                    $data_shop['FeaturedProduct']['shop_id'] = $prd_details['Product']['shop_id'];
                    $data_shop['FeaturedProduct']['prd_id'] = $prd_id;
                    $data_shop['FeaturedProduct']['type'] = 2;
                    $data_shop['FeaturedProduct']['start_date'] = gmdate('Y-m-d H:i:s');
                    $data_shop['FeaturedProduct']['end_date'] = $end_date;
                    $data_shop['FeaturedProduct']['cdate'] = gmdate('Y-m-d');
                    $data_shop['FeaturedProduct']['status'] = 1;
                    $data_shop['FeaturedProduct']['transcation_id'] = isset($_REQUEST['payer_id']) ? $_REQUEST['payer_id'] : '';
                    $this->FeaturedProduct->create();
                    $this->FeaturedProduct->save($data_shop);

                    $arr1['Payment']['userid'] = $userid;
                    $arr1['Payment']['amount'] = $sitesetting['SiteSetting']['feature_product_paid_fee'];
                    $arr1['Payment']['datetime'] = $date;
                    $arr1['Payment']['status'] = $status;
                    $arr1['Payment']['transaction_id'] = isset($_REQUEST['payer_id']) ? $_REQUEST['payer_id'] : '';
                    $arr1['Payment']['for'] = 'for featured product';
                    $arr1['Payment']['type'] = 1;
                    $this->Payment->create();
                    $this->Payment->save($arr1);
                }
            }
            $this->Session->setFlash('You have successfully featured your product.', 'default', array('class' => 'success'));
        }
        return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
    }

    public function my_inventory_list() {
        $userid = $this->Session->read('Auth.User.id');
        $title_for_layout = 'Manage Inventory';
        $conditions = array();
        if (($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])) {

            $filter_url['controller'] = $this->request->params['controller'];
            $filter_url['action'] = $this->request->params['action'];
            $filter_url['page'] = 1;
            // pr($this->data['Filter']);exit;
            foreach ($this->data['Filter'] as $name => $value) {
                if ($value) {
                    $filter_url[$name] = urlencode(str_replace(' ', '-', trim($value)));
                }
            }
            //exit;
            return $this->redirect($filter_url);
        } else {
            foreach ($this->params['named'] as $param_name => $value) {

                if (!in_array($param_name, array('sort', 'direction', 'limit', 'page'))) {

                    if ($param_name == 'search') {
                        //$conditions['Product.name LIKE']='%'.$value.'%';
                        $conditions['OR']['Product.name LIKE'] = '%' . $value . '%';
                        $conditions['OR']['Product.sku LIKE'] = '%' . $value . '%';
                        $conditions['OR']['Product.unit_type LIKE'] = '%' . $value . '%';
                        $conditions['OR']['Product.price_lot LIKE'] = '%' . $value . '%';
                    }
                }
            }
        }
        //$inventoryList = $this->Product->find('all',array('conditions'=>array('Product.user_id'=>$userid)));
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 25,
            'order' => array(
                'Product.id' => 'desc'
            ),
        );
        $this->Paginator->settings = $this->paginate;
        //pr($this->paginate());exit;
        $this->set('inventoryList', $this->Paginator->paginate('Product', array('Product.user_id' => $userid, 'Product.is_deleted' => 0)));
        $this->set(compact('title_for_layout'));
    }

    public function upload_inventory_image() {
        $this->loadModel('ProductImage');

        if ($this->request->is(array('post', 'put'))) {
            $pro_id = $this->request->data['Product']['product_id'];
            $proImage = $this->ProductImage->find('all', array('conditions' => array('ProductImage.product_id' => $pro_id, 'ProductImage.status' => 1)));
            if (isset($this->request->data['Product']['image']) && $this->request->data['Product']['image']['name'] != '') {
                $ext = explode('.', $this->request->data['Product']['image']['name']);
                $status = $this->request->data['Product']['status'];
                if (count($proImage) < 4) {
                    if ($status != '' && $status == 1) {
                        $update_status = 1;
                    } else {
                        $update_status = 0;
                    }
                } else {
                    $update_status = 0;
                }

                if ($ext) {
                    $i = date('Y_md_his');
                    $uploadFolderbanner = "product_images";
                    $uploadPath = WWW_ROOT . $uploadFolderbanner;
                    $extensionValid = array('JPG', 'JPEG', 'jpg', 'jpeg', 'png', 'gif');
                    if (in_array($ext[1], $extensionValid)) {
                        $imageName = $i . "_" . strtolower(trim($this->request->data['Product']['image']['name']));
                        $full_image_path = $uploadPath . '/' . $imageName;
                        move_uploaded_file($this->request->data['Product']['image']['tmp_name'], $full_image_path);
                        $this->request->data['ProductImage']['name'] = $imageName;
                        $this->request->data['ProductImage']['product_id'] = $pro_id;
                        $this->request->data['ProductImage']['status'] = $update_status;
                        $this->ProductImage->create();
                        $this->ProductImage->save($this->request->data);
                    }
                } else {
                    $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                }
            }
            $this->Session->setFlash('The product image has been Saved.', 'default', array('class' => 'success'));
            return $this->redirect(array('action' => 'inventory_image', base64_encode($pro_id)));
        }
    }

    public function inventory_image($id = null) {
        $id = base64_decode($id);
        $this->loadModel('ProductImage');
        $this->Product->recursive = 2;
        $this->paginate = array(
            'limit' => 25,
            'order' => array(
                'ProductImage.id' => 'desc'
            ),
        );
        $this->Paginator->settings = $this->paginate;
        $this->set('products', $this->Paginator->paginate('ProductImage', array('ProductImage.product_id' => $id)));
        /* $products = $this->ProductImage->find('all',array('conditions'=>array('ProductImage.product_id'=>$id)));
          $this->set(compact('products')); */
    }

    public function imgdelete($id = null) {
        $this->loadModel('ProductImage');
        $id = base64_decode($id);
        $this->ProductImage->id = $id;
        $pro = $this->ProductImage->read();
        if (!$this->ProductImage->exists()) {
            throw new NotFoundException(__('Invalid product image'));
        }

        $uploadFolderbanner = "product_images";
        $uploadPath = WWW_ROOT . $uploadFolderbanner;
        $proImage = $this->ProductImage->find('first', array('fields' => array('id', 'name'), 'conditions' => array('ProductImage.id' => $id)));
        $Prd_img = $proImage['ProductImage']['name'];
        #$this->request->allowMethod('post', 'delete');
        if ($this->ProductImage->delete($id)) {
            if ($Prd_img != '' && file_exists($uploadPath . '/' . $Prd_img)) {
                unlink($uploadPath . '/' . $Prd_img);
            }
            $this->Session->setFlash('The product image has been deleted.', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('The product image could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'inventory_image', base64_encode($pro['ProductImage']['product_id'])));
    }

    public function change_image_status($id = null, $status = null) {
        $this->loadModel('ProductImage');
        $id = base64_decode($id);
        $this->ProductImage->id = $id;
        $pro = $this->ProductImage->read();
        if (!$this->ProductImage->exists()) {
            throw new NotFoundException(__('Invalid product image'));
        }

        $proImage = $this->ProductImage->find('all', array('conditions' => array('ProductImage.product_id' => $pro['ProductImage']['product_id'], 'ProductImage.status' => 1)));
        if (count($proImage) < 4 && ($status == 0 || $status == 1)) {
            $data_save['ProductImage']['id'] = $id;
            $data_save['ProductImage']['status'] = $status;
            if ($this->ProductImage->save($data_save)) {
                $this->Session->setFlash('The product image status has been saved.', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('The product image status could not be saved. Please, try again.'));
            }
        } else if (count($proImage) >= 4 && $status == 0) {
            $data_save['ProductImage']['id'] = $id;
            $data_save['ProductImage']['status'] = $status;
            if ($this->ProductImage->save($data_save)) {
                $this->Session->setFlash('The product image status has been saved.', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('The product image status could not be saved. Please, try again.'));
            }
        } else {
            $this->Session->setFlash(__('Please inactive one product image to active this image.'));
        }
        return $this->redirect(array('action' => 'inventory_image', base64_encode($pro['ProductImage']['product_id'])));
    }

    //http://107.170.152.166/twop/products/appinventorylist

    public function appinventorylist() {
        $this->loadModel('ProductImage');
        $this->autoRender = false;
        $data = array();
        $image = array();
        //$this->Product->recursive=1;
        $inventoryList = $this->Product->find('all', array('fields' => array('id', 'name', 'price_lot'), 'conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0)));
        // $proImage = $this->ProductImage->find('first',array('fields'=>array('id','name'),'conditions'=>array('ProductImage.product_id'=>$inventoryList['Product']['id'],'order'=>array('ProductImage.id DESC'))));
        // pr($inventoryList['ProductImage']);exit;
        //echo '<pre>';
        #pr($inventoryList);
        /* if(!empty($inventoryList[0]['ProductImage'])){
          $image =  $inventoryList[0]['ProductImage'][0]['name'];
          }


          $data['Ack'] = 1;
          $data['msg'] = 'success';
          $data['productDetails'] =$inventoryList;
          $data['productDetails']['image'] = $image;
          exit; */
        if ($inventoryList) {
            foreach ($inventoryList as $k) {
                if (!empty($k['ProductImage'][0])) {
                    $image = $k['ProductImage'][0]['name'];
                } else {
                    $image = 'default.png';
                }
                #pr($k);
                $res['id'] = $k['Product']['id'];
                $res['name'] = $k['Product']['name'];
                $res['price_lot'] = $k['Product']['price_lot'];
                $res['image'] = 'http://107.170.152.166/twop/product_images/' . $image;
                $data['productDetails'][] = $res;
            }
            $data['Ack'] = 1;
            $data['msg'] = 'success';
        }

        $result = json_encode($data);
        return $result;
    }

    public function autoComplete($name = null) {
        $this->loadModel('User');

        $this->autoRender = false;
        //$this->layout = 'ajax';
        // $query = $_GET['term'];
        $areas = $this->User->find('all', array('conditions' => array('User.name LIKE' => $name . '%', 'User.is_active' => '1')));
        //$areas = $this->User->query('select * from users as User where User.name LIKE %"'.$name.'"% OR User.company_name LIKE %"'.$name.'" AND User.is_active = 1');
        //echo 'select * from users as User where User.name LIKE %"'. $name .'"% OR User.company_name LIKE %"'. $name .'" AND User.is_active = 1';exit;
        /*
          ,array('OR'=>array('User.name LIKE' =>  $name . '%','User.company_nmae LIKE' =>  $name . '%'))
          $areas = $this->User->find('all', array(
          'conditions' => array('User.is_active' =>'1', array('OR'=>array('User.first_name LIKE' =>  $name . '%','User.last_name LIKE' =>  $name . '%')) ),
          'fields' => array('first_name','last_name', 'id'))); */
        $i = 0;
        if (!empty($areas)) {
            foreach ($areas as $area) {
                $response[$i]['id'] = $area['User']['id'];
                $response[$i]['label'] = $area['User']['first_name'] . ' ' . $area['User']['last_name'] . ' ' . $area['User']['company_name'];
                $response[$i]['value'] = $area['User']['first_name'] . ' ' . $area['User']['last_name'];
                $i++;
            }
        } else {
            $response[$i]['id'] = '';
            $response[$i]['label'] = 'No User Found';
            $response[$i]['value'] = 'No User Found';
        }
        echo json_encode($response);
        exit;
    }

    public function cart() {
        $this->loadModel('TempCart');
        $this->loadModel('ShippingDay');
        $title_for_layout = 'Shopping Cart';
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/');
        }
        $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
        $cart = $this->TempCart->find('all', $options_cart);

        //pr($cart);


        $this->set(compact('cart', 'title_for_layout'));
    }

    public function empty_cart() {
        $this->loadModel('TempCart');
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/');
        }
        $this->TempCart->deleteAll(array('TempCart.user_id' => $userid), false);
        $this->redirect(array('controller' => 'products', 'action' => 'cart'));
    }

    public function add_to_cart($id = null) {

        //echo "dfgdf";exit;

        $this->loadModel('TempCart');
        //$this->loadModel('TempCart');
        //$productsInCart = array();
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid Product'));
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/');
        }

        $this->Product->recursive = 1;
        $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
        $product = $this->Product->find('first', $options);
        $Current_woner_id = $product['Product']['user_id'];
        $previous_prd_qty = $product['Product']['quantity'];

        $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
        $productsInCart = $this->TempCart->find('all', $options_cart);

        if ($this->request->is('post')) {
            $product_woner_id = '';
            //$productsInCart = $this->Session->read('Cart');
            $Prd_quantity = $this->request->data['TempCart']['quantity'];
            $alreadyIn = false;
            $woner_check = false;
            if (count($productsInCart) > 0) {
                foreach ($productsInCart as $productInCart) {
                    $product_woner_id = $productInCart['TempCart']['product_woner_id'];
                    if ($productInCart['TempCart']['prd_id'] == $id) {
                        $alreadyIn = true;
                    }
                }
            }

            /* if($product_woner_id!='' && $product_woner_id!=$Current_woner_id){
              $woner_check = true;
              } */

            if ($Prd_quantity > $previous_prd_qty) {
                $this->Session->setFlash(__('You must enter quantity less than available pieces.'));
                $this->redirect(array('controller' => 'products', 'action' => 'view', base64_encode($id)));
            } elseif (!$alreadyIn && !$woner_check && $userid != $Current_woner_id) {
                $this->TempCart->create();
                $this->request->data['TempCart']['user_id'] = $userid;
                $this->request->data['TempCart']['pay_amt'] = $this->request->data['TempCart']['price'];
                $this->request->data['TempCart']['cdate'] = gmdate('Y-m-d H:i:s');
                if ($this->TempCart->save($this->request->data)) {
                    $this->Session->setFlash('Product added to cart.', 'default', array('class' => 'success'));
                    $this->redirect(array('controller' => 'products', 'action' => 'cart'));
                } else {
                    $this->Session->setFlash(__('The product could not be saved into the cart. Please, try again.'));
                    $this->redirect(array('controller' => 'products', 'action' => 'view', base64_encode($id)));
                }
                /* $this->Session->write('Cart.' . $amount, $this->request->data);				
                  if ($this->Session->check('Cart')) {
                  $cart = $this->Session->read('Cart');
                  }
                  $this->Session->write('Counter', $amount + 1); */
                //$this->Session->setFlash(__('Product added to cart'));
            } elseif ($woner_check == true) {
                $this->Session->setFlash(__('You cannot add different store woner product.'));
                $this->redirect(array('controller' => 'products', 'action' => 'view', base64_encode($id)));
            } elseif ($userid == $Current_woner_id) {
                $this->Session->setFlash(__('You cannot add your own product.'));
                $this->redirect(array('controller' => 'products', 'action' => 'view', base64_encode($id)));
            } else {
                $this->Session->setFlash(__('Product already in cart'));
                $this->redirect(array('controller' => 'products', 'action' => 'view', base64_encode($id)));
            }
        }
    }

    public function ajax_add_to_cart($id = null) {
        $this->autoRender = false;
        $this->layout = false;
        $this->loadModel('TempCart');
        $id = base64_decode($id);

        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            $Msg = 'Invalid Product';
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $Msg = 'Error:Please Login First.';
        } else {
            $this->Product->recursive = 1;
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $product = $this->Product->find('first', $options);
            //print_r($product);exit;
            $Current_woner_id = $product['Product']['user_id'];
            $previous_prd_qty = $product['Product']['quantity'];

            $options_cart = array('conditions' => array('TempCart.user_id' => $userid));
            $productsInCart = $this->TempCart->find('all', $options_cart);

            if ($this->request->is('post')) {
                $product_woner_id = '';
                $Prd_quantity = $this->request->data['TempCart']['quantity'];
                $alreadyIn = false;
                $woner_check = false;
                if (count($productsInCart) > 0) {
                    foreach ($productsInCart as $productInCart) {
                        $product_woner_id = $productInCart['TempCart']['product_woner_id'];
                        if ($productInCart['TempCart']['prd_id'] == $id) {
                            $alreadyIn = true;
                        }
                    }
                }

                /* if($product_woner_id!='' && $product_woner_id!=$Current_woner_id){
                  $woner_check = true;
                  } */

                if ($Prd_quantity > $previous_prd_qty) {
                    $Msg = 'You must enter quantity less than available pieces.';
                } elseif (!$alreadyIn && !$woner_check && $userid != $Current_woner_id) {

                    $this->TempCart->create();
                    $this->request->data['TempCart']['prd_id'] = $id;
                    $this->request->data['TempCart']['user_id'] = $userid;

                   /* if ($this->request->data['TempCart']['price_lot'] == 0) {
                        $pprice = explode('_', $this->request->data['TempCart']['price']);
                        $this->request->data['TempCart']['p_color'] = $pprice[0];
                        $this->request->data['TempCart']['pay_amt'] = $pprice[1];
                        $this->request->data['TempCart']['price'] = $pprice[1];
                    }
                    
                    else {
                        $this->request->data['TempCart']['pay_amt'] = $this->request->data['TempCart']['price_lot'];
                        $this->request->data['TempCart']['price'] = $this->request->data['TempCart']['price_lot'];
                    }*/
                    
                    
                    //spandan 24/11
                    if ($this->request->data['TempCart']['price_lot'] != 0) {
                    $this->request->data['TempCart']['pay_amt'] = $this->request->data['TempCart']['price_lot'];
                    $this->request->data['TempCart']['price'] = $this->request->data['TempCart']['price_lot'];
                    
                    }elseif ($this->request->data['TempCart']['price']!='') {
                        
                        $pprice = explode('_', $this->request->data['TempCart']['price']);
                        $this->request->data['TempCart']['p_color'] = $pprice[0];
                        $this->request->data['TempCart']['pay_amt'] = $pprice[1];
                        $this->request->data['TempCart']['price'] = $pprice[1];  
                        
                    }elseif ($this->request->data['TempCart']['size_price']!=''){
                        
                        $sprice = explode('_', $this->request->data['TempCart']['size_price']);
                        $this->request->data['TempCart']['p_size'] = $sprice[0];
                        $this->request->data['TempCart']['pay_amt'] = $sprice[1];
                        $this->request->data['TempCart']['price'] = $sprice[1]; 
                    }elseif ($this->request->data['TempCart']['color_with_size']!=''){
                       
                        $this->request->data['TempCart']['p_color'] = $this->request->data['TempCart']['color_with_size'];
                        $swprice = explode('_', $this->request->data['TempCart']['size_with_price']);
                        $this->request->data['TempCart']['p_size'] = $swprice[0];
                        $this->request->data['TempCart']['pay_amt'] = $swprice[1];
                        $this->request->data['TempCart']['price'] = $swprice[1]; 
                    }
                    
                    
                    //end 24/11
                    
                    $this->request->data['TempCart']['cdate'] = gmdate('Y-m-d H:i:s');
                    //print_r($this->request->data);exit;
                    if ($this->TempCart->save($this->request->data)) {
                        $Msg = 'Success:Product added to cart.';
                    } else {
                        $Msg = 'Error:The product could not be saved into the cart. Please, try again.';
                    }
                    echo $Msg;
                    exit;
                } elseif ($woner_check == true) {
                    $Msg = 'Error:You cannot add different store woner product.';
                } elseif ($userid == $Current_woner_id) {
                    $Msg = 'Error:You cannot add your own product.';
                } else {
                    $Msg = 'Error:Product already in cart.';
                }
            }
        }
        return $Msg;
    }

    public function edit_quantity() {
        $this->loadModel('TempCart');
        if ($this->request->is(array('post', 'put'))) {
            $cart_prd_id = $this->request->data['cart_prd_id'];
            $options = array('conditions' => array('Product.id' => $cart_prd_id));
            $product = $this->Product->find('first', $options);
            //$Current_woner_id=$product['Product']['user_id'];
            $previous_prd_qty = $product['Product']['quantity'];
            $give_prd_quantity = $this->request->data['TempCart']['quantity'];
            if ($give_prd_quantity > $previous_prd_qty) {
                $this->Session->setFlash(__('Product quantity could not be saved.Product quantity could not be available.Please, try again.'));
            } else {
                if ($this->TempCart->save($this->request->data)) {
                    $this->Session->setFlash('Product quantity updated successfully.', 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash(__('Product quantity could not be saved. Please, try again.'));
                }
            }
        }
        $this->redirect(array('controller' => 'products', 'action' => 'cart'));
    }

    public function delete_cart($id = null) {
        $this->loadModel('TempCart');
        $this->TempCart->id = $id;
        if (!$this->TempCart->exists()) {
            throw new NotFoundException(__('Invalid Request'));
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/');
        }

        if ($this->TempCart->delete()) {
            $this->Session->setFlash('Product has been deleted', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('Product could not be deleted. Please, try again.'));
        }

        return $this->redirect(array('action' => 'cart'));
    }

    public function get_product_details($id = null) {
        $options = array('conditions' => array('Product.id' => $id));
        return $product = $this->Product->find('first', $options);
    }

    // http://107.170.152.166/twop/products/app_product_list/page:1
    public function app_product_list() {
        $this->autoRender = false;
        $data = array();
        /* $userID=isset($_REQUEST['userID'])?$_REQUEST['userID']:'';
          $type=isset($_REQUEST['type'])?$_REQUEST['type']:'';
          $sort_by=isset($_REQUEST['sort_by'])?$_REQUEST['sort_by']:'id';
          $direction=isset($_REQUEST['direction'])?$_REQUEST['direction']:'desc'; */
        $params_named = $this->params['named'];
        if (count($params_named) > 0) {
            $page = isset($params_named['page']) ? $params_named['page'] : '0';
        } else {
            $page = 0;
        }

        /* $TodayDate=date('Y-m-d');
          if (isset($_REQUEST['search']) && $_REQUEST['search']=='errand_search' ) {
          //$TaskStatus='';
          $Keywords=isset($_REQUEST['Keywords'])?$_REQUEST['Keywords']:'';
          //$TaskStatus=isset($_REQUEST['TaskStatus'])?$_REQUEST['TaskStatus']:'';
          $EndDate=isset($_REQUEST['EndDate'])?$_REQUEST['EndDate']:'';
          $Price_Max=isset($_REQUEST['Price_Max'])?$_REQUEST['Price_Max']:'';
          $Price_Min=isset($_REQUEST['Price_Min'])?$_REQUEST['Price_Min']:'';
          $task_location=isset($_REQUEST['task_location'])?$_REQUEST['task_location']:'';
          $Category=isset($_REQUEST['Category'])?$_REQUEST['Category']:'';
          $WorkType=isset($_REQUEST['WorkType'])?$_REQUEST['WorkType']:'';

          $QueryStr="(Task.user_id=".$userID.")".$TaskStatus;
          if($Keywords!=''){
          $QueryStr.=" AND (Task.title LIKE '%".$Keywords."%')";
          }

          if($EndDate!=''){
          $QueryStr.=" AND (Task.due_date = '".$EndDate."')";
          }
          if($Price_Max!='' and $Price_Min!='' ){
          $QueryStr.=" AND (Task.total_rate >= '".$Price_Min."' and Task.total_rate<='".$Price_Max."')";
          }
          if($Category!=''){
          $QueryStr.=" AND Task.category_id='".$Category."'";
          }
          if($task_location!=''){
          $QueryStr.=" AND Task.task_location='".$task_location."'";
          }
          if($WorkType!=''){
          $QueryStr.=" AND (Task.completed = '".$WorkType."')";
          }

          $options = array('conditions' => array($QueryStr), 'order' => array('Task.'.$sort_by => $direction), 'limit' => 10);
          }else{
          $options = array('conditions' => array('Task.user_id' => $userID, 'Task.task_status' => $TaskStatusType, 'Task.status' => $TaskActiveStatus), 'order' => array('Task.'.$sort_by => $direction), 'limit' => 10);
          } */

        $options = array('conditions' => array('Product.status' => 'A', 'Product.is_deleted' => 0));

        $TaskListCnt = $this->Product->find('count', $options);
        //$TaskList=$this->Task->find('all', $options);

        if ($TaskListCnt < 1) {
            $data['Ack'] = 0;
            $data['msg'] = 'No Product found';
        } elseif ($TaskListCnt >= $page * 10 || $TaskListCnt > ($page - 1) * 10) {
            //}elseif($TaskListCnt>=$page*10){
            $this->Paginator->settings = $options;
            $TaskList = $this->Paginator->paginate('Product');
            foreach ($TaskList as $val) {
                $uploadImgPath = WWW_ROOT . 'product_images';

                if (!empty($val['ProductImage'])) {
                    $imageName = $val['ProductImage'][0]['name'];
                    if (file_exists($uploadImgPath . '/' . $imageName) && $imageName != '') {
                        $Product_img = $this->webroot . 'product_images/' . $imageName;
                    } else {
                        $Product_img = $this->webroot . 'product_images/default.png';
                    }
                } else {
                    $Product_img = $this->webroot . 'product_images/default.png';
                }

                $post_detail['id'] = $val['Product']['id'];
                $post_detail['product_img'] = $Product_img;
                $post_detail['name'] = $val['Product']['name'];
                $post_detail['price'] = $val['Product']['price_lot'];
                $post_detail['keywords'] = $val['Product']['keywords'];

                $post_detail['discount_price'] = $val['Product']['discount'];
                $post_detail['item_description'] = $val['Product']['item_description'];
                $post_detail['rating'] = 4;
                $post_detail['rating_count'] = 100;
                $post_detail['order_count'] = 52;
                //$post_detail['task_status_name']=$TaskStatus;
                $data['ProductList'][] = $post_detail;
            }
            //$data['TotTaskList'] = $TaskListCnt;
            $data['Ack'] = 1;
        } else {
            $data['Ack'] = 0;
            $data['msg'] = 'Error';
        }
        $result = json_encode($data);
        return $result;
    }

    // http://107.170.152.166/twop/products/appProductDetails?PrdID=4
    public function appProductDetails() {
        $this->autoRender = false;
        $data = array();
        $userID = isset($_REQUEST['userID']) ? $_REQUEST['userID'] : '';
        $PrdID = isset($_REQUEST['PrdID']) ? $_REQUEST['PrdID'] : '';
        if (!$this->Product->exists($PrdID)) {
            $data['Ack'] = 0;
            $data['msg'] = 'Invalid product id';
        } else {
            $this->loadModel('Category');
            $this->loadModel('Shop');
            $this->Product->recursive = 1;

            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $PrdID));
            $product = $this->Product->find('first', $options);

            $options = array('conditions' => array('Category.id' => $product['Product']['sub_category_id']));
            $subcat = $this->Category->find('first', $options);

            $options = array('conditions' => array('Shop.id' => $product['Product']['shop_id']));
            $shop = $this->Shop->find('first', $options);
            if (empty($product)) {
                $data['Ack'] = 0;
                $data['msg'] = 'No product found';
            } else {
                $uploadImgPath = WWW_ROOT . 'product_images';
                $prd_sub_img_arr = array();
                if (!empty($product['ProductImage'])) {
                    $imageName = $product['ProductImage'][0]['name'];
                    if (file_exists($uploadImgPath . '/' . $imageName) && $imageName != '') {
                        $Product_img = $this->webroot . 'product_images/' . $imageName;
                    } else {
                        $Product_img = $this->webroot . 'product_images/default.png';
                    }
                    foreach ($product['ProductImage'] as $proimage) {
                        $sub_imageName = $proimage['name'];
                        if (file_exists($uploadImgPath . '/' . $sub_imageName) && $sub_imageName != '') {
                            $imageSmall = $this->webroot . 'product_images/' . $sub_imageName;
                            array_push($prd_sub_img_arr, $imageSmall);
                        }
                    }
                } else {
                    $Product_img = $this->webroot . 'product_images/default.png';
                }

                $data['ProuctDetails'][] = $product;
                $data['ProuctRating'] = 4;
                $data['SubCatName'] = $subcat['Category']['name'];
                $data['PrdImgName'] = $Product_img;
                $data['PrdSubImgList'] = $prd_sub_img_arr;
                $data['Ack'] = 1;
            }
        }

        $result = json_encode($data);
        return $result;
    }

    /*     * ********************Suman Code****************************************** */

    public function manage_inventory() {
        $this->Session->setFlash('Sorry payment was not successful. Please try again', 'default', array('class' => 'error'));
        return $this->redirect(array('controller' => 'products', 'action' => 'my_inventory_list'));
    }

    /*     * ********************End Suman Code****************************************** */

    ///////////////////////////////added by anup///////////////////    
    public function prodoct_related_rating($product_id = null) {
        $this->loadModel('Rating');
        $product_rating = $this->Rating->find("all", array('conditions' => array('Rating.product_id' => $product_id), 'fields' => array('sum(Rating.rating) as total_rating', 'sum(Rating.rate_this) as accurate', 'sum(Rating.product_description) as product_description', 'sum(Rating.seller_communication) as satisfaction', 'sum(Rating.ship_item) as ship_item', 'count(Rating.id) as total_count')));
        return $product_rating;
    }

    public function prodoct_related_feedback($product_id = null) {
        $this->loadModel('Rating');
        $product_feedback = $this->Rating->find("all", array('conditions' => array('Rating.product_id' => $product_id)));
        return $product_feedback;
    }

    /*     * *******************kundu ******************************* */

    public function add_wishlists($id = null) {
        $this->loadModel('Wishlist');
        $this->loadModel('Shop');
        $id = base64_decode($id);
        if (!$this->Product->exists($id)) {
            $this->Session->setFlash(__('Invalid product.'));
            return $this->redirect('/products/list/');
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && empty($userid)) {
            $this->Session->setFlash(__('Please login to add to watchlist.'));
            return $this->redirect('/users/login/');
        }

        $options = array('conditions' => array('Wishlist.user_id' => $userid, 'Wishlist.product_id' => $id));
        $wishlist = $this->Wishlist->find('first', $options);

        if (empty($wishlist)) {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $product = $this->Product->find('first', $options);
            //echo'<pre>';pr($product);exit;
            $wish['Wishlist']['user_id'] = $userid;
            $wish['Wishlist']['product_id'] = $product['Product']['id'];
            $wish['Wishlist']['shop_id'] = $product['Product']['shop_id'];
            $wish['Wishlist']['category_id'] = $product['Product']['category_id'];
            $wish['Wishlist']['sub_category_id'] = $product['Product']['sub_category_id'];
            $wish['Wishlist']['price'] = $product['Product']['price_lot'];
            $wish['Wishlist']['date'] = date('Y-m-d');
            $this->Wishlist->create();
            if ($this->Wishlist->save($wish)) {
                $this->Session->setFlash('Product has been added to watchlist.', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('Product not added to watchlist. Please, try again.'));
            }
        } else {
            $this->Session->setFlash(__('Product already added to watchlist.'));
        }
        return $this->redirect('/users/wishlist');
    }

    public function ajax_whishlist() {
        $this->loadModel('Wishlist');
        $this->loadModel('Shop');
        $id = $this->request->data['id'];
        $type = $this->request->data['type'];
        $id = base64_decode($id);
        if (!$this->Product->exists($id)) {
            //$this->Session->setFlash(__('Invalid product.'));
            //return $this->redirect('/products/list/');
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && empty($userid)) {
            //$this->Session->setFlash(__('Please login to add to watchlist.'));
            //return $this->redirect('/users/login/');
        }
        $options = array('conditions' => array('Wishlist.user_id' => $userid, 'Wishlist.product_id' => $id));
        $wishlist = $this->Wishlist->find('first', $options);
        if ($type == 1) {


            if (empty($wishlist)) {
                $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
                $product = $this->Product->find('first', $options);
                //echo'<pre>';pr($product);exit;
                $wish['Wishlist']['user_id'] = $userid;
                $wish['Wishlist']['product_id'] = $product['Product']['id'];
                $wish['Wishlist']['shop_id'] = $product['Product']['shop_id'];
                $wish['Wishlist']['category_id'] = $product['Product']['category_id'];
                $wish['Wishlist']['sub_category_id'] = $product['Product']['sub_category_id'];
                $wish['Wishlist']['price'] = $product['Product']['price_lot'];
                $wish['Wishlist']['date'] = date('Y-m-d');
                $this->Wishlist->create();
                if ($this->Wishlist->save($wish)) {
                    // $this->Session->setFlash('Product has been added to watchlist.', 'default', array('class' => 'success'));
                    echo 'success';
                } else {
                    echo 'failure';
                    //$this->Session->setFlash(__('Product not added to watchlist. Please, try again.'));
                }
            } else {
                //$this->Session->setFlash(__('Product already added to watchlist.'));
                echo 'failure';
            }
            //return $this->redirect('/users/wishlist');
        } else {
            if (!empty($wishlist)) {
                $this->Wishlist->id = $wishlist['Wishlist']['id'];
                if ($this->Wishlist->delete($wishlist['Wishlist']['id'])) {
                    echo 'success';
                } else {
                    echo 'failure';
                }
            }
        }
        exit;
    }

    public function ajax_add_to_wishlist($id = null) {
        $this->autoRender = false;
        $this->layout = false;
        $this->loadModel('Wishlist');
        $this->loadModel('TempCart');
        $id = base64_decode($id);

        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            $Msg = 'Invalid Product';
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $Msg = 'Error:Please Login First.';
        } else {
            $this->Product->recursive = 1;
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $product = $this->Product->find('first', $options);
            //print_r($product);exit;
            $Current_woner_id = $product['Product']['user_id'];
            $previous_prd_qty = $product['Product']['quantity'];

            $options_cart = array('conditions' => array('Wishlist.user_id' => $userid));
            $productsInCart = $this->Wishlist->find('all', $options_cart);

            if ($this->request->is('post')) {
                $product_woner_id = '';
                $Prd_quantity = $this->request->data['TempCart']['quantity'];
                $alreadyIn = false;
                $woner_check = false;
                if (count($productsInCart) > 0) {
                    foreach ($productsInCart as $productInCart) {
                        //$product_woner_id=$productInCart['TempCart']['product_woner_id'];
                        if ($productInCart['Wishlist']['product_id'] == $id) {
                            $alreadyIn = true;
                        }
                    }
                }


                if ($Prd_quantity > $previous_prd_qty) {
                    $Msg = 'You must enter quantity less than available pieces.';
                } elseif (!$alreadyIn && !$woner_check && $userid != $Current_woner_id) {

                    $this->Wishlist->create();
                    $this->request->data['Wishlist']['product_id'] = $id;
                    $this->request->data['Wishlist']['user_id'] = $userid;
                    
                   /* if ($this->request->data['TempCart']['price_lot'] == 0) {
                        $pprice = explode('_', $this->request->data['TempCart']['price']);
                        
                        $this->request->data['Wishlist']['price'] = $pprice[1];
                    }else{
                    
                    $this->request->data['Wishlist']['price'] = $this->request->data['TempCart']['pric_lot'];
                    }*/
                    
                    
                    //spandan 24/11
                    if ($this->request->data['TempCart']['price_lot'] != 0) {
                    
                    $this->request->data['Wishlist']['price'] = $this->request->data['TempCart']['price_lot'];
                    
                    }elseif ($this->request->data['TempCart']['price']!='') {
                        
                        $pprice = explode('_', $this->request->data['TempCart']['price']);
                        
                        $this->request->data['Wishlist']['price'] = $pprice[1];  
                        
                    }elseif ($this->request->data['TempCart']['size_price']!=''){
                        
                        $sprice = explode('_', $this->request->data['TempCart']['size_price']);
                        
                        $this->request->data['Wishlist']['price'] = $sprice[1]; 
                        
                    }elseif ($this->request->data['TempCart']['color_with_size']!=''){
                       
                        $this->request->data['TempCart']['p_color'] = $this->request->data['TempCart']['color_with_size'];
                        $swprice = explode('_', $this->request->data['TempCart']['size_with_price']);
                        
                        $this->request->data['Wishlist']['price'] = $swprice[1]; 
                    }
                    
                    
                    //end 24/11
                    
                    $this->request->data['Wishlist']['date'] = gmdate('Y-m-d');
                    //print_r($this->request->data);exit;
                    if ($this->Wishlist->save($this->request->data)) {
                        $Msg = 'Success:Product added to wishlist.';
                    } else {
                        $Msg = 'Error:The product could not be saved into the wishlist. Please, try again.';
                    }
                    echo $Msg;
                    exit;
                } elseif ($woner_check == true) {
                    $Msg = 'Error:You cannot add different store woner product.';
                } elseif ($userid == $Current_woner_id) {
                    $Msg = 'Error:You cannot add your own product.';
                } else {
                    $Msg = 'Error:Product already in wishlist.';
                }
            }
        }
        return $Msg;
    }

    /* public function remove_wishlist($id=null){
      $this->loadModel('Wishlist');
      $this->loadModel('Shop');
      $id = base64_decode($id);
      if (!$this->Wishlist->exists($id)) {
      $this->Session->setFlash(__('Invalid request.'));
      return $this->redirect('/users/wishlist/');
      }
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && empty($userid))
      {
      $this->Session->setFlash(__('Please login to add to watchlist.'));
      return $this->redirect('/users/login/');
      }
      $options = array('conditions' => array('Wishlist.id'=> $id));
      $wishlist = $this->Wishlist->find('first', $options);
      if($wishlist['Wishlist']['user_id'] == $userid)
      {
      $this->Wishlist->id = $id;
      if ($this->Wishlist->delete($id)) {
      $this->Session->setFlash('Product successfully removed from watchlist.', 'default', array('class' => 'success'));
      }else{
      $this->Session->setFlash(__('Sorry could not remove the product from watchlist.'));
      }
      }else{
      $this->Session->setFlash(__('Sorry you donot have permission.'));
      }
      return $this->redirect('/users/wishlist');
      } */

    public function shop_related_rating($shop_id = null) {
        $this->loadModel('Rating');
        $product_rating = $this->Rating->find("all", array('conditions' => array('Rating.shop_id' => $shop_id), 'fields' => array('sum(Rating.rating) as total_rating', 'sum(Rating.rate_this) as accurate', 'sum(Rating.product_description) as product_description', 'sum(Rating.seller_communication) as satisfaction', 'sum(Rating.ship_item) as ship_item', 'count(Rating.id) as total_count')));
        return $product_rating;
    }

    public function shop_related_positive_rating($shop_id = null) {
        $this->loadModel('Rating');
        $shop_rating = $this->Rating->find("count", array('conditions' => array('Rating.shop_id' => $shop_id, 'Rating.rating >=' => 3)));
        $total_shop_rating_count = $this->Rating->find("count", array('conditions' => array('Rating.shop_id' => $shop_id)));
        $rating = array($shop_rating, $total_shop_rating_count);
        return $rating;
    }

    public function homesearch() {

        $this->loadModel('Category');
        if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Filter']) && !empty($this->request->data['Filter'])) {
            if (!empty($this->request->data['Filter']['keyword'])) {
                $filter_url['controller'] = 'products';
                $filter_url['action'] = 'search_list';

                if (!empty($this->request->data['Filter']['keyword'])) {
                    $filter_url['keyword'] = urlencode($this->request->data['Filter']['keyword']);
                }
                return $this->redirect($filter_url);
            } else {
                return $this->redirect('products/search_list');
            }
        } else {
            return $this->redirect('/');
        }
        exit;
    }

    public function search_result() {

        if ($this->request->is('post')) {

            $condition = array();
            if (isset($this->request->data['Products']['keyword']) && $this->request->data['Products']['keyword'] != "" && !empty($this->request->data['Products']['keyword'])) {

                $condition['or'][] = array('Product.name LIKE' => "%" . $this->request->data['Products']['keyword'] . "%", 'Product.quantity >' => 0);
                $condition['or'][] = array('Product.product_code LIKE' => "%" . $this->request->data['Products']['keyword'] . "%", 'Product.quantity >' => 0);
                $condition['or'][] = array('Product.item_description LIKE' => "%" . $this->request->data['Products']['keyword'] . "%", 'Product.quantity >' => 0);
                $condition['or'][] = array('Category.name LIKE' => "%" . $this->request->data['Products']['keyword'] . "%", 'Product.quantity >' => 0);



                $condition['Product.status'] = 'A';
            }
            $keyword = $this->request->data['Products']['keyword'];

            $options = array('conditions' => $condition, 'limit' => 50);
            $this->Paginator->settings = $options;
            $list_all = $this->Paginator->paginate('Product');

            //pr($list_all);
            $this->set('list_all', $this->Paginator->paginate('Product'));
            $this->set(compact('keyword'));
        }
    }

    public function filter_search() {
        
        $this->loadModel('Product');
        $this->loadModel('ProductVariation');
         $this->loadModel('ProductImage');
        $this->layout = false;
        $keyword = $_REQUEST['keyword'];
        $price = $_REQUEST['price'];
        $mcat = $_REQUEST['cat'];

        $condition = array();
        if ($keyword != "") {

            $condition['or'][] = array('Product.name LIKE' => "%" . $keyword . "%");

            $condition['or'][] = array('Category.name LIKE' => "%" . $keyword . "%");

            $condition['or'][] = array('Product.product_code LIKE' => "%" . $keyword . "%");

            $condition['or'][] = array('Product.item_description LIKE' => "%" . $keyword . "%");
        }

        if (isset($mcat) && $mcat != "") {
            $condition['Product.category_id'] = $mcat;
        }

        if (isset($price) && $price != "") {
            $pricearray = explode('-', $price);
            $condition[]['Product.price_lot BETWEEN ? and ?'] = $pricearray;
            //$condition['or'][]['ProductVariation.price BETWEEN ? and ?'][] = $pricearray;
        }
        $condition['Product.quantity >'] = 0;
        $condition['Product.status'] = 'A';
         //print_r($condition);
        //$this->Product->recursive = 2;
        $products = $this->Product->find('all', array('conditions' => $condition));
        
        //$this->set(compact('products'));
    }

    public function search_option($id) {

        $this->loadModel('Category');

        $subcategorys = $this->Category->find('all', array('conditions' => array('Category.parent_id' => $id)));
        //print_r($subcategory);exit;
        if (count($subcategorys) > 0) {
            //print_r($subcategory);exit;
            $this->set(compact('subcategorys'));
        } else {
            return $this->redirect('/products/search/c_' . $id);
        }
    }

    public function search($id) {

        $id_string = explode("_", $id);
        //print_r($id_string);exit;
        $ser_id = $id_string[1];
        //echo $ser_id;exit;
        $this->loadModel('Category');
        if ($this->request->is('post')) {
            
        } else {
            if ($id_string[1] == 'sc') {
                $products = $this->Product->find('all', array('conditions' => array('Product.sub_category_id' => $ser_id, 'Product.quantity >' => 0, 'Product.status' => 'A')));
            } else {
                $products = $this->Product->find('all', array('conditions' => array('Product.category_id' => $ser_id, 'Product.quantity >' => 0, 'Product.status' => 'A')));
            }
        }
        //print_r($products);exit;
        $this->set(compact('products', 'id_string'));
    }

    public function product_details($product_id) {
        $this->loadModel('ShippingDay');
        $this->loadModel('ProductImage');
        $this->loadModel('Message');
        $this->loadModel('OrderDetail');
        $this->loadModel('User');
        $this->loadModel('Rating');
        $this->loadModel('ProductVariation');
        $user_id = $this->Session->read('Auth.User.id');
        if (isset($user_id) && $user_id != '') {
            $product_details = $this->Product->find('first', array('conditions' => array('Product.id' => $product_id)));
            //pr($product_details['Product']['shipping_time']);
            $ship_array = explode(',', $product_details['Product']['shipping_time']);

            $shippingdetails = $this->ShippingDay->find('all', array('conditions' => array('ShippingDay.id' => $ship_array)));

            // pr($shippingdetails);
            $catid = $product_details['Product']['category_id'];
            $related_products = $this->Product->find('all', array('conditions' => array('Product.category_id' => $catid, 'Product.id !=' => $product_id, 'Product.quantity >' => 0, 'Product.status' => 'A'), 'limit' => 4, 'order' => array('Product.id' => 'desc')));
            //pr($product_details);
            $this->ProductImage->recursive = -1;
            $product_images = $this->ProductImage->find('all', array('conditions' => array('product_id' => $product_id)));

            //for product variation

            $product_variation = $this->ProductVariation->find('all', array('conditions' => array('product_id' => $product_id),'group'=>'color_id'));
             
             $product_variation_size = $this->ProductVariation->find('all', array('conditions' => array('product_id' => $product_id)));

            //for rating review

            $ratingreview = $this->Rating->find('all', array('conditions' => array('Rating.product_id' => $product_id)));

            $avgrating = $this->Rating->find('all', array('conditions' => array('Rating.product_id' => $product_id), 'fields' => array('AVG(Rating.rating) as avg_rating'), 'group' => 'product_id'));


            $productsold = $this->OrderDetail->find('all', array('conditions' => array('OrderDetail.product_id' => $product_id), 'fields' => array('sum(OrderDetail.quantity) as total_sold'), 'group' => 'product_id'));
            // pr($avgrating);

            $this->set(compact('product_details', 'avgrating', 'productsold', 'shippingdetails', 'ratingreview', 'product_images', 'product_variation','product_variation_size', 'related_products', 'product_id', 'user_id'));
        } else {
            $product_details = $this->Product->find('first', array('conditions' => array('Product.id' => $product_id)));
            //pr($product_details);

            $ship_array = explode(',', $product_details['Product']['shipping_time']);

            $shippingdetails = $this->ShippingDay->find('all', array('conditions' => array('ShippingDay.id' => $ship_array)));

            $catid = $product_details['Product']['category_id'];
            $related_products = $this->Product->find('all', array('conditions' => array('Product.category_id' => $catid, 'Product.id !=' => $product_id, 'Product.quantity >' => 0, 'Product.status' => 'A'), 'limit' => 4, 'order' => array('Product.id' => 'desc')));
            //pr($related_products);
            $this->ProductImage->recursive = -1;
            $product_images = $this->ProductImage->find('all', array('conditions' => array('product_id' => $product_id)));

            //for product variation

            $product_variation = $this->ProductVariation->find('all', array('conditions' => array('product_id' => $product_id),'group'=>'color_id'));
            
             $product_variation_size = $this->ProductVariation->find('all', array('conditions' => array('product_id' => $product_id)));

            $ratingreview = $this->Rating->find('all', array('conditions' => array('Rating.product_id' => $product_id)));


            $avgrating = $this->Rating->find('all', array('conditions' => array('Rating.product_id' => $product_id), 'fields' => array('avg(Rating.rating) as avg_rating'), 'group' => 'product_id'));

            $productsold = $this->OrderDetail->find('all', array('conditions' => array('OrderDetail.product_id' => $product_id), 'fields' => array('sum(OrderDetail.quantity) as total_sold'), 'group' => 'product_id'));
            //pr($productsold);

            $this->set(compact('product_details', 'avgrating', 'productsold', 'shippingdetails', 'ratingreview', 'product_images', 'product_variation','product_variation_size', 'related_products', 'product_id', 'user_id'));
        }
    }

    /*     * *******************kundu ******************************* */
    /*     * **********************Anup ***************************** */

    public function category_related_product($category_id = null, $shop_id = null) {
        $product_count = $this->Product->find("count", array('conditions' => array('Product.category_id' => $category_id, 'Product.status' => 'A', 'Product.shop_id' => $shop_id, 'Product.is_deleted' => 0)));
        return $product_count;
    }

    public function get_product_img($prd_id = null) {
        $this->loadModel('ProductImage');
        $product_img = $this->ProductImage->find("all", array('conditions' => array('ProductImage.product_id' => $prd_id, 'ProductImage.status' => 1)));
        return $product_img;
    }

    public function get_product_main_image($id = null) {
        $this->loadModel('ProductImage');
        $options = array('conditions' => array('ProductImage.product_id' => $id, 'ProductImage.is_feature' => 1));
        $order_details = $this->ProductImage->find('all', $options);
        if (count($order_details) > 0) {
            $result_data = $order_details;
        } else {
            $options_img = array('conditions' => array('ProductImage.product_id' => $id));
            $result_data = $this->ProductImage->find('all', $options_img);
        }
        return $result_data;
    }

    public function subcategory_related_product($sub_category_id = null, $shop_id = null) {
        $product_count = $this->Product->find("count", array('conditions' => array('Product.sub_category_id' => $sub_category_id, 'Product.status' => 'A', 'Product.shop_id' => $shop_id, 'Product.is_deleted' => 0)));
        return $product_count;
    }

    public function get_product_feature_status($prd_id = null) {
        $this->loadModel('FeaturedProduct');
        $now_date = gmdate('Y-m-d H:i:s');
        $product_count = $this->FeaturedProduct->find("count", array('conditions' => array('FeaturedProduct.end_date >=' => $now_date, 'FeaturedProduct.prd_id' => $prd_id), 'order' => array('FeaturedProduct.id' => 'desc')));
        return $product_count;
    }

    public function set_main_images() {
        $this->autoRender = false;
        $this->loadModel('ProductImage');
        $imgPID = $this->request->data['imgPID'];
        $imgPIDExp = explode('#', $imgPID);
        $imgID = isset($imgPIDExp[0]) ? $imgPIDExp[0] : '';
        $imgPrdID = isset($imgPIDExp[1]) ? $imgPIDExp[1] : '';
        if ($imgID != '' && $imgPrdID != '') {
            $img_list = $this->ProductImage->find('all', array('conditions' => array('ProductImage.product_id' => $imgPrdID)));
            if (count($img_list) > 0) {
                foreach ($img_list as $val) {
                    $data_save['ProductImage']['id'] = $val['ProductImage']['id'];
                    $data_save['ProductImage']['is_feature'] = 0;
                    $this->ProductImage->save($data_save);
                }
            }

            $data_update['ProductImage']['id'] = $imgID;
            $data_update['ProductImage']['is_feature'] = 1;
            if ($this->ProductImage->save($data_update)) {
                $Ack = 1;
                $this->Session->setFlash('You have successfully set the product main image.', 'default', array('class' => 'success'));
            } else {
                $Ack = 0;
                $this->Session->setFlash(__('The product image status could not be saved. Please, try again.'));
            }
        } else {
            $this->Session->setFlash(__('The product image id could not be null. Please, try again.'));
            $Ack = 0;
        }
        return $Ack;
    }

    function exporttocsv() {
        $userid = $this->Session->read('Auth.User.id');
        //$this->set('headers',$this->Product->find('all',array('fields'=>'Product.name','Product.product_code'))); 
        $this->set('values', $this->Product->find('all', array('conditions' => array('Product.user_id' => $userid))));
    }

    function admin_exporttocsv() {

        //$this->set('headers',$this->Product->find('all',array('fields'=>'Product.name','Product.product_code'))); 
        $this->set('values', $this->Product->find('all'));
    }

    public function downloadSamplefile() {
        $this->viewClass = 'Media';
        // Download app/webroot/files/example.csv
        $params = array(
            'id' => 'product.csv',
            'name' => 'productsample',
            'extension' => 'csv',
            'download' => true,
            'path' => APP . 'webroot' . DS . 'product_csv' . DS  // file path
        );
        $this->set($params);
    }

    public function admin_downloadSamplefile() {
        $this->viewClass = 'Media';
        // Download app/webroot/files/example.csv
        $params = array(
            'id' => 'product.csv',
            'name' => 'productsample',
            'extension' => 'csv',
            'download' => true,
            'path' => APP . 'webroot' . DS . 'product_csv' . DS  // file path
        );
        $this->set($params);
    }

    public function multiple_product() {
        $this->loadModel('ProductImage');

        $this->autoRender = false;
        //   $userid = $this->Session->read('userid');
        // if(!isset($userid) && $userid==''){
        //   return $this->redirect(array('action' => 'login'));
        // }
        $userid = $this->Session->read('Auth.User.id');
        if ($this->request->is('post')) {
            //print_r($_FILES);exit;
            //print_r($_FILES['csv_file']['name']);exit;
            if (!empty($_FILES['csv_file']['name'])) {
                $pathpart = pathinfo($_FILES['csv_file']['name']);
                $ext = $pathpart['extension'];
                //echo $ext;exit;
                $extensionValid = array('csv', 'xls');
                if (in_array(strtolower($ext), $extensionValid)) {
                    $uploadFolder = "product_csv/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    move_uploaded_file($_FILES['csv_file']['tmp_name'], $full_flg_path);
                } else {
                    $this->Session->setFlash(__('Invalid file type.'));
                }
            } else {
                $filename = '';
            }



            if (($handle = fopen($full_flg_path, "r")) !== FALSE) {
                fgetcsv($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    //print_r($data);exit;

                    $num = count($data);
                    for ($c = 0; $c < $num; $c++) {
                        $col[$c] = $data[$c];

                        // pr($col[$c]);
                    }

                    $this->request->data['Product']['name'] = $data[0];
                    $this->request->data['Product']['user_id'] = $userid;
                    $this->request->data['Product']['product_code'] = $data[1];
                    $this->request->data['Product']['quantity'] = $data[2];
                    $this->request->data['Product']['category_id'] = $data[3];
                    $this->request->data['Product']['price_lot'] = $data[4];
                    $this->request->data['Product']['currency'] = $data[5];
                    $this->request->data['Product']['item_description'] = $data[6];
                    $this->request->data['Product']['size'] = $data[8];
                    $this->request->data['Product']['shipping_time'] = $data[9];



                    $img = file_get_contents($data[7]);
                    $uploadFolder = "product_images/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.jpg';
                    $full_flg_path = $uploadPath . '/' . $filename;
                    file_put_contents($full_flg_path, $img);



                    $this->Product->create();
                    $this->request->data['Product']['created_at'] = gmdate('Y-m-d H:i:s');
                    //print_r($this->request->data);
                    //if($this->request->data['Product']['sale_on'] == 'Y'){
                    //$this->request->data['Product']['sales_price']=($this->request->data['Product']['price_lot']-($this->request->data['Product']['price_lot']*$this->request->data['Product']['discount'])/100);
                    //}
                    if ($this->Product->save($this->request->data)) {
                        //echo 'ok';exit;
                        $this->request->data['ProductImage']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductImage']['name'] = $filename;

                        $this->ProductImage->create();
                        $this->ProductImage->save($this->request->data);

                        //print_r($this->request->data) ;     
                        //echo "save";
                    } else {
                        //echo "not save";
                    }
                }
                fclose($handle);
                //exit;
            }

            return $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_csv_add() {
        $this->loadModel('User');
        $this->loadModel('ProductImage');
        //   $userid = $this->Session->read('userid');
        // if(!isset($userid) && $userid==''){
        //   return $this->redirect(array('action' => 'login'));
        // }

        if ($this->request->is('post')) {
            //$userid = $this->request->data[][];
            //print_r($this->request->data['Product']['csv_file']);exit;
            //print_r($_FILES['csv_file']['name']);exit;
            if (!empty($this->request->data['Product']['csv_file']['name'])) {
                $pathpart = pathinfo($this->request->data['Product']['csv_file']['name']);
                $ext = $pathpart['extension'];
                //echo $ext;exit;
                $extensionValid = array('csv', 'xls');
                if (in_array(strtolower($ext), $extensionValid)) {
                    $uploadFolder = "product_csv/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    move_uploaded_file($this->request->data['Product']['csv_file']['tmp_name'], $full_flg_path);
                } else {
                    $this->Session->setFlash(__('Invalid file type.'));
                }
            } else {
                $filename = '';
            }

            if (($handle = fopen($full_flg_path, "r")) !== FALSE) {
                fgetcsv($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    //print_r($data);exit;

                    $num = count($data);
                    for ($c = 0; $c < $num; $c++) {
                        $col[$c] = $data[$c];
                        //pr($col[$c]);
                    }

                    $this->request->data['Product']['name'] = $data[0];
                    //$this->request->data['Product']['user_id'] = $userid;
                    $this->request->data['Product']['product_code'] = $data[1];
                    $this->request->data['Product']['quantity'] = $data[2];
                    $this->request->data['Product']['category_id'] = $data[3];
                    $this->request->data['Product']['price_lot'] = $data[4];
                    $this->request->data['Product']['currency'] = $data[5];
                    $this->request->data['Product']['item_description'] = $data[6];
                    $this->request->data['Product']['size'] = $data[8];
                    $this->request->data['Product']['shipping_time'] = $data[9];


                    $img = file_get_contents($data[7]);
                    $uploadFolder = "product_images/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.jpg';
                    $full_flg_path = $uploadPath . '/' . $filename;
                    file_put_contents($full_flg_path, $img);


                    $this->Product->create();
                    $this->request->data['Product']['created_at'] = gmdate('Y-m-d H:i:s');
                    //print_r($this->request->data);
                    //if($this->request->data['Product']['sale_on'] == 'Y'){
                    //$this->request->data['Product']['sales_price']=($this->request->data['Product']['price_lot']-($this->request->data['Product']['price_lot']*$this->request->data['Product']['discount'])/100);
                    //}

                    if ($this->Product->save($this->request->data)) {
                        //echo 'ok';exit;
                        $this->request->data['ProductImage']['product_id'] = $this->Product->getInsertID();
                        $this->request->data['ProductImage']['name'] = $filename;

                        $this->ProductImage->create();
                        $this->ProductImage->save($this->request->data);

                        //print_r($this->request->data) ;     
                        //echo "save";
                    } else {
                        //echo "not save";
                    }
                }
                fclose($handle);
                //exit;
            }
            //pr($existsemail);
            // exit;
            //echo $exemail=implode("   ,   ",$existsemail);
            //exit;
            //return($existsemail);
            //$this->set(compact('existsemail'));
            return $this->redirect(array('action' => 'admin_index'));
            //echo "hfgh";
        }


        $vendors = $this->User->find('all', array('conditions' => array('User.type' => 'V', 'User.is_active' => 1)));
//pr($vendors);exit;
        $this->set(compact('vendors'));
    }

    function admin_fetch_ship() {
        $this->loadModel('ShippingDay');
        $uid = $_REQUEST['id'];

        //echo $uid;exit;

        $ships = $this->ShippingDay->find('all', array('conditions' => array('user_id' => $uid)));

        //print_r($ships);exit;
        if (!empty($ships)) {
            $data = array('Ack' => 1, 'data' => $ships);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    function fetch_size() {
        $this->loadModel('ProductVariation');
        $cid= $_REQUEST['cid'];
        $pid= $_REQUEST['pid'];
        //echo $cid;exit;
        $size = $this->ProductVariation->find('all',array('conditions' => array('ProductVariation.color_id' => $cid,'ProductVariation.product_id'=>$pid)));

       
        if (!empty($size)) {
            $data = array('Ack' => 1, 'data' => $size);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function order_list() {

        $title_for_layout = 'My Order';
        $this->loadModel('User');
        $this->loadModel('Order');

        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if (isset($userid) && $userid != '') {
            
            $con = array('conditions' => array('Order.coupon_owner_id' => $userid), 'order' => array('Order.id' => 'desc'));
            $orders = $this->Order->find('all', $con);

           // pr($orders);
            $this->set(compact('title_for_layout', 'orders'));
        } else {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function view_order_details($id = NULl) {

        $title_for_layout = 'Order Details';
        $this->loadModel('User');
        
        $userid = $this->Session->read('Auth.User.id');
        //$utype = $this->Session->read('Auth.User.type');
        if (isset($userid) && $userid != '') {
            $this->loadModel('Order');
            //$this->OrderDetail->recursive = 2;
            $con = array('conditions' => array('Order.id' => $id));
            $order_details = $this->Order->find('first', $con);


            $this->set(compact('title_for_layout', 'order_details'));
        } else {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function purchase_history() {

        $title_for_layout = 'Purchase History';
        $this->loadModel('User');

        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if (isset($userid) && $userid != '') {
            $this->loadModel('Order');
            //$this->OrderDetail->recursive = 2;
            $con = array('conditions' => array('Order.user_id' => $userid), 'order' => array('Order.id' => 'desc'));
            $orders = $this->Order->find('all', $con);


            $this->set(compact('title_for_layout', 'orders'));
        } else {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function view_purchase_details($id = NULL) {

        $title_for_layout = 'Purchase Details';
        $this->loadModel('User');
        
        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if (isset($userid) && $userid != '') {
            $this->loadModel('Order');
            //$this->OrderDetail->recursive = 2;
            $con = array('conditions' => array('Order.id' => $id));
            $purchase_details = $this->Order->find('first', $con);


            $this->set(compact('title_for_layout', 'rating_details', 'purchase_details'));
        } else {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function wish_list() {

        $title_for_layout = 'Wish List';
        $this->loadModel('User');


        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if (isset($userid) && $userid != '') {
            $this->loadModel('Wishlist');
            $this->Wishlist->recursive = 2;
            $con = array('conditions' => array('Wishlist.user_id' => $userid), 'order' => array('Wishlist.id' => 'desc'));
            $orders = $this->Wishlist->find('all', $con);


            $this->set(compact('title_for_layout', 'orders'));
        } else {

            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function remove_wishlist($id = null) {
        $this->loadModel('Wishlist');
        $this->Wishlist->id = $id;
        if (!$this->Wishlist->exists()) {
            throw new NotFoundException(__('Invalid Request'));
        }
        $userid = $this->Session->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $this->redirect('/');
        }

        if ($this->Wishlist->delete()) {
            $this->Session->setFlash('Product has been removed', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('Product could not be removed. Please, try again.'));
        }

        return $this->redirect(array('action' => 'wish_list'));
    }

}
