<?php

App::uses('AppController', 'Controller');

/**

 * Shops Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class ShopsController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('Shop','User','Category','Percentage');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('details', 'getSubcategorydetails','product_list','feedback','contact_details','shop_related_product_count','get_shop_status');
	   }

	public function details($shop_name=null, $id = null,$category_id=null) 
	{
		$title_for_layout = 'Shop View';
		$this->set(compact('title_for_layout'));
		$userid = $this->Session->read('Auth.User.id');
                $shop_id = $id;
                $shop_categories=array();
		$id = base64_decode($id);
		if (!$this->Shop->exists($id)) 
		{
			throw new NotFoundException(__('Invalid shop.'));
		}
		$options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $id));
		$shop = $this->Shop->find('first', $options);
		//pr($shop);
		

		if($shop){
			//echo $shop['Shop']['user_id'];
			
			$this->loadModel('Follow');
			$options = array('conditions' => array('Follow.shop_id' => $shop['Shop']['id'], 'Follow.user_id' => $userid));
			$follow = $this->Follow->find('first', $options);
			
			$this->loadModel('Product');
			$options = array('conditions' => array('Product.user_id' => $shop['Shop']['user_id'], 'Product.is_featured' => 'Y', 'Product.status' => 'A', 'Product.is_deleted' => 0), 'limit' => '3');
			$featured_product = $this->Product->find('all', $options);
                        $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                        $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                        //pr($product_related_category);
                        $product_related_subcategory = array_unique($product_related_subcategory); 
                        $conditions['Product.status']='A';
                        $conditions['Product.shop_id']=$id;
                        $conditions['Product.is_deleted']=0;
                        if(isset($category_id) && !empty($category_id)){
                            $conditions['AND']['Product.sub_category_id']=$category_id;
                        }
                        if(($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])){
                            //pr($this->data['Filter']);
                            //pr($this->request->params);exit;
                            $filter_url['controller'] = $this->request->params['controller'];
                            $filter_url['action'] = $this->request->params['action'];
                            if(isset($this->request->params['pass']) && !empty($this->request->params['pass']))
                            {
                                foreach($this->request->params['pass'] as $key=>$val)
                                {
                                        $filter_url[] = $val; 
                                }
                            }
                            $filter_url['page'] = 1;
                            foreach($this->data['Filter'] as $name => $value){
                                if($value){
                                    $filter_url[$name] = urlencode($value);
                                }
                            }	
                            return $this->redirect($filter_url);
                        } else {
                            $limit = 20;
                            foreach($this->params['named'] as $param_name => $value){
                                if(!in_array($param_name, array('page','sort','direction','limit'))){
                                    if($param_name=='keyword')
                                    {
                                        $conditions['OR']['Product.name LIKE'] = urldecode('%'.$value).'%';
                                        //$conditions['OR']['Product.keywords LIKE'] = urldecode('%'.$value).'%';
                                    }
                                    $this->request->data['Filter'][$param_name] = urldecode($value);
                                }
                            }
                        }
                        $this->Paginator->settings=array(
                        'conditions'=> $conditions,
                        'limit'=>20,
                        'order'=>'Product.id desc'   
                        );
                        $all_products=$this->Paginator->paginate('Product');

			if(!empty($product_related_category)){
				//$cat = explode(',',$shop['Shop']['categories']);
				$this->loadModel('Category');
				$options = array('conditions' => array('Category.id' => $product_related_category));
				$shop_categories = $this->Category->find('all', $options);
                                //pr($shop_categories);
			}
		}

		$this->set(compact('shop','featured_product','all_products','shop_categories','follow','product_related_subcategory','shop_id'));
	}
        
        public function contact_details($id = null) 
	{
		$title_for_layout = 'Shop View';
		$this->set(compact('title_for_layout'));
		$userid = $this->Session->read('Auth.User.id');
                $shop_id = $id;
                $shop_categories=array();
		$id = base64_decode($id);
		if (!$this->Shop->exists($id)) 
		{
			throw new NotFoundException(__('Invalid shop.'));
		}
		$options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $id));
		$shop = $this->Shop->find('first', $options);
		//pr($shop);
		

	

		$this->set(compact('shop','shop_id'));
	}
        
        public function product_list($id = null,$type=null,$category_id=null) 
	{
		$title_for_layout = 'Shop View';
		$this->set(compact('title_for_layout'));
		$userid = $this->Session->read('Auth.User.id');
                $shop_id = $id;
                $shop_categories=array();
                $limit = 20;
		$id = base64_decode($id);
		if (!$this->Shop->exists($id)) 
		{
			throw new NotFoundException(__('Invalid shop.'));
		}
		$options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $id));
		$shop = $this->Shop->find('first', $options);
		//pr($shop);
                
                
		

		if($shop){
			//echo $shop['Shop']['user_id'];
			
			$this->loadModel('Follow');
			$options = array('conditions' => array('Follow.shop_id' => $shop['Shop']['id'], 'Follow.user_id' => $userid));
			$follow = $this->Follow->find('first', $options);
			
			$this->loadModel('Product');
			$options = array('conditions' => array('Product.user_id' => $shop['Shop']['user_id'], 'Product.is_featured' => 'Y', 'Product.status' => 'A', 'Product.is_deleted' => 0), 'limit' => '3');
			$featured_product = $this->Product->find('all', $options);
                        $conditions['Product.status']='A';
                        $conditions['Product.shop_id']=$id;
                        $conditions['Product.is_deleted']=0;
                        if($type == "category"){
                            
                            $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                            $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                            //pr($product_related_category);
                            $product_related_subcategory = array_unique($product_related_subcategory);                        
                            if(isset($category_id) && !empty($category_id)){
                                $conditions['AND']['Product.sub_category_id']=$category_id;
                            }
                            $order = array('Product.id'=>'ASC');

                            
                    }elseif($type == "sales"){
                        
                        $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A','Product.sale_on'=>'Y', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                        $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A','Product.sale_on'=>'Y', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                        //pr($product_related_category);
                        $product_related_subcategory = array_unique($product_related_subcategory);                                  $conditions['AND']['Product.sale_on']='Y';
                        if(isset($category_id) && !empty($category_id)){
                            $conditions['AND']['Product.sub_category_id']=$category_id;
                            
                        }
                        $order = array('Product.id'=>'ASC');
                            
                    }elseif($type == "top"){
                        
                        $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                        $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                        //pr($product_related_category);
                        $product_related_subcategory = array_unique($product_related_subcategory);                                  if(isset($category_id) && !empty($category_id)){
                            $conditions['AND']['Product.sub_category_id']=$category_id;
                            
                        }
                        $order = array('Product.sold_quantity'=>'DESC');
                        
                    }elseif($type == "new"){
                        
                        $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                        $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                        //pr($product_related_category);
                        $product_related_subcategory = array_unique($product_related_subcategory);                        
                        if(isset($category_id) && !empty($category_id)){
                            $conditions['AND']['Product.sub_category_id']=$category_id;
                            
                        }  
                        $order = array('Product.id'=>'DESC');
                        
                    }
                    
                    if(($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])){
                            //pr($this->data['Filter']);
                            //pr($this->request->params);exit;
                            $filter_url['controller'] = $this->request->params['controller'];
                            $filter_url['action'] = $this->request->params['action'];
                            if(isset($this->request->params['pass']) && !empty($this->request->params['pass']))
                            {
                                foreach($this->request->params['pass'] as $key=>$val)
                                {
                                        $filter_url[] = $val; 
                                }
                            }
                            $filter_url['page'] = 1;
                            foreach($this->data['Filter'] as $name => $value){
                                if($value){
                                    $filter_url[$name] = urlencode($value);
                                }
                            }	
                            return $this->redirect($filter_url);
                        } else {
                            $limit = 20;
                            foreach($this->params['named'] as $param_name => $value){
                                if(!in_array($param_name, array('page','sort','direction','limit'))){
                                    if($param_name=='keyword')
                                    {
                                        $conditions['OR']['Product.name LIKE'] = '%'.urldecode($value).'%';
                                        //$conditions['OR']['Product.keywords LIKE'] = urldecode('%'.$value).'%';
                                    }
                                    $this->request->data['Filter'][$param_name] = urldecode($value);
                                }
                            }
                        }
                    $this->Paginator->settings=array(
                    'conditions'=> $conditions,
                    'limit'=>$limit,
                    'order'=>$order   
                    );
                    $all_products=$this->Paginator->paginate('Product');

                    if(!empty($product_related_category)){                            
                            $this->loadModel('Category');                                                  
                            $options = array('conditions' => array('Category.id' => $product_related_category));
                            $shop_categories = $this->Category->find('all', $options);
                            //pr($shop_categories);
                    }
		}

		$this->set(compact('shop','featured_product','all_products','shop_categories','follow','product_related_subcategory','shop_id','type'));
	}
        public function feedback($id = null,$type=null){
            $title_for_layout = 'Shop View';
            $this->set(compact('title_for_layout'));
            $userid = $this->Session->read('Auth.User.id');
            $shop_id = $id;
            $shop_categories=array();
            $limit = 20;
            $id = base64_decode($id);
            if (!$this->Shop->exists($id)) 
            {
                    throw new NotFoundException(__('Invalid shop.'));
            }
            $options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $id));
            $shop = $this->Shop->find('first', $options);

            if($shop){
                    //echo $shop['Shop']['user_id'];

                    $this->loadModel('Follow');
                    $this->loadModel('Product');
                    $options = array('conditions' => array('Follow.shop_id' => $shop['Shop']['id'], 'Follow.user_id' => $userid));
                    $follow = $this->Follow->find('first', $options);
                    
                    $product_related_category = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.category_id')));
                    $product_related_subcategory = $this->Product->find('list', array('conditions'=>array('Product.shop_id'=>$id,'Product.status' => 'A', 'Product.is_deleted' => 0),'fields'=>array('Product.sub_category_id')));
                    //pr($product_related_category);
                    $product_related_subcategory = array_unique($product_related_subcategory);

                    
                    $options = array('conditions' => array('Product.user_id' => $shop['Shop']['user_id'], 'Product.is_featured' => 'Y', 'Product.status' => 'A', 'Product.is_deleted' => 0), 'limit' => '3');
                    $featured_product = $this->Product->find('all', $options);
                    $this->loadModel('Rating');
                    $this->Rating->recursive=2;
                    //if($type == 'seller'){
                        $conditions['Rating.shop_id']=$id;  
                        //$order=array();
                        $this->Paginator->settings=array(
                        'conditions'=> $conditions,
                        'limit'=>20,
                        'order'=>'Rating.id desc'   
                        );
                        $feedback=$this->Paginator->paginate('Rating');
                    //}
                    //pr($feedback);

                if(!empty($product_related_category)){                            
                        $this->loadModel('Category');                                                  
                        $options = array('conditions' => array('Category.id' => $product_related_category));
                        $shop_categories = $this->Category->find('all', $options);
                        //pr($shop_categories);
                }
            }

            $this->set(compact('shop','featured_product','all_products','shop_categories','follow','product_related_subcategory','shop_id','feedback'));
        }
        
        public function seller_feedback(){
            $title_for_layout = 'Seller Feedback';
            $this->set(compact('title_for_layout'));
            $userid = $this->Session->read('Auth.User.id');
            $this->loadModel('Follow');
            $this->loadModel('Product');
            if(!isset($userid) && empty($userid)){
                $this->Session->setFlash(__('Please login first!'));
                return $this->redirect('/users/login/');
            }
            $options = array('conditions' => array('Shop.user_id'=> $userid,'Shop.is_active'=>1));
            $shop = $this->Shop->find('first', $options);
            
            if(count($shop)>0){
                $shop_id = $shop['Shop']['id'];
                
                $this->loadModel('Rating');
                $this->Rating->recursive=2;
                
                $conditions['Rating.shop_id']=$shop_id;  
                $this->Paginator->settings=array(
                'conditions'=> $conditions,
                'limit'=>20,
                'order'=>'Rating.id desc'   
                );
                $feedback=$this->Paginator->paginate('Rating');
            }else{
                return $this->redirect('/shops/myshop/');
            }
            
            $this->set(compact('shop','shop_id','feedback'));
        }
        
	public function buyer_feedback(){
            $title_for_layout = 'Buyer Feedback';
            $this->set(compact('title_for_layout'));
            $userid = $this->Session->read('Auth.User.id');
            
            $this->loadModel('BuyerFeedback');
            if(!isset($userid) && empty($userid)){
                $this->Session->setFlash(__('Please login first!'));
                return $this->redirect('/users/login/');
            }
            $options = array('conditions' => array('BuyerFeedback.to_user'=> $userid));
            $feedback = $this->BuyerFeedback->find('all', $options);
            
            /*if(count($shop)>0){
                $shop_id = $shop['Shop']['id'];
                
                $this->loadModel('Rating');
                $this->Rating->recursive=2;
                
                $conditions['Rating.shop_id']=$shop_id;  
                $this->Paginator->settings=array(
                'conditions'=> $conditions,
                'limit'=>20,
                'order'=>'Rating.id desc'   
                );
                $feedback=$this->Paginator->paginate('Rating');
            }else{
                return $this->redirect('/shops/myshop/');
            }*/
            
            $this->set(compact('feedback'));
        }
	
	public function getSubcategorydetails($id = null) {
		$subcat = '';
		if($id!=''){
			$this->loadModel('Category');
			$options = array('conditions' => array('Category.parent_id' => $id, 'Category.is_active' => 1));
			$shopsub_categories = $this->Category->find('all', $options);
			if($shopsub_categories){
				$subcat='<ul>';
					foreach($shopsub_categories as $k){
						$subcat.='<li>'.$k['Category']['name'].' <span>(0) </span></li>';
					}
				$subcat.='</ul>';
			}
		}
		//echo $subcat;
		//exit;
		return $subcat;
	}

        public function contact_mail() {
            if(($this->request->is('post') || $this->request->is('put'))){
                //pr($this->request->data);
                $this->loadModel('Comment');
                $this->loadModel('User');
                //pr($_FILES);
                $to_user_id = $this->request->data['Comment']['to_user_id'];
                $user_detail = $this->User->find('first',array('conditions'=>array('User.id'=>$to_user_id),'recursive'=>-1));
                $to_user_email = $user_detail['User']['email'];
                $from_user_email = $this->Session->read('Auth.User.email');
                $subject = $this->request->data['Comment']['subject'];
                $comment = $this->request->data['Comment']['comments'];
                
                $uploadPath= Configure::read('UPLOAD_MESSAGE_PATH');
                $extensionValid = array('jpg','jpeg','png','gif');
                if(isset($this->request->data['Comment']['file_name']) && $this->request->data['Comment']['file_name']['name']!='')
                {
                    $path = $this->request->data['Comment']['file_name']['name'];
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    if($ext){
                        if(in_array($ext,$extensionValid)){
                            $imageName = rand().'_'.(strtolower(trim($this->request->data['Comment']['file_name']['name'])));
                            $full_image_path = $uploadPath . '/' . $imageName;
                            move_uploaded_file($this->request->data['Comment']['file_name']['tmp_name'],$full_image_path);
                            $this->request->data['Comment']['file_name'] = $imageName;
                        }else{
                            $this->Session->setFlash(__('Contact message could not be send. Please, attach file with jpg, jpeg, png, gif  this format.'));
                            return $this->redirect($this->request->referer());
                        } 
                    }
                } else {
                    $this->request->data['Comment']['file_name'] = '';
                }
                
                $this->request->data['Comment']['comment_type']=9;
                $this->request->data['Comment']['is_notification']=0;
                $this->Comment->create();
                if($this->Comment->save($this->request->data)){
                    //$Path = WWW_ROOT.;

                    $Email = new CakeEmail();
                    $Email->emailFormat('both');
                    $Email->from($from_user_email);
                    $Email->to($to_user_email);
                    $Email->subject($subject);
                    if(!empty($this->request->data['Comment']['file_name'])){
                        $Email->attachments(array($uploadPath.'/'.$imageName)); 
                    }
                    $Email->send($comment);
                    $this->Session->setFlash('Contact message submited successfully.', 'default', array('class' => 'success'));
                }
                return $this->redirect($this->request->referer());
            }
            //exit;
        }
        
        public function myshop() {
            $this->loadModel('FeaturedShop');
            $this->loadModel('SiteSetting');
                $title_for_layout = 'Manage Shop';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    	$this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	        	return $this->redirect(array('action' => 'signin'));
		}
                $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                $sitesetting = $this->SiteSetting->find('first', $options_set);
        
		$options_spAdd = array('conditions' => array('FeaturedShop.user_id' => $userid, 'FeaturedShop.type' => 1));
                $get_free_shop = $this->FeaturedShop->find('first', $options_spAdd);
                
                $options_paidShop = array('conditions' => array('FeaturedShop.user_id' => $userid, 'FeaturedShop.type' => 2), 'order' => array('FeaturedShop.id' => 'desc'));
                $get_paid_shop = $this->FeaturedShop->find('first', $options_paidShop);
		if ($this->request->is(array('post', 'put'))) {

		    $options = array('conditions' => array('Shop.name'  => $this->request->data['Shop']['name'], 'Shop.id !=' => $this->request->data['Shop']['id']));
		    $shopexists = $this->Shop->find('first', $options);
                    if(!$shopexists){
			$uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
			$extensionValid = array('jpg','jpeg','png','gif');

			if(isset($this->request->data['Shop']['logo']) && $this->request->data['Shop']['logo']['name']!='')
			{
				$path = $this->request->data['Shop']['logo']['name'];
				$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				if($ext)
				{
					
					if(in_array($ext,$extensionValid))
					{
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Shop']['logo']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Shop']['logo']['tmp_name'],$full_image_path);
						$this->request->data['Shop']['logo'] = $imageName;
					
					} 
				}
			} else {
				$this->request->data['Shop']['logo'] = $this->request->data['Shop']['hid_logo'];
			}

			if(isset($this->request->data['Shop']['cover_photo']) && $this->request->data['Shop']['cover_photo']['name']!='')
			{
				$path1 = $this->request->data['Shop']['cover_photo']['name'];
				$ext1 = strtolower(pathinfo($path1, PATHINFO_EXTENSION));
				if($ext1)
				{
					if(in_array($ext1,$extensionValid))
					{
						$imageName1 = rand().'_'.(strtolower(trim($this->request->data['Shop']['cover_photo']['name'])));
						$full_image_path1 = $uploadPath . '/' . $imageName1;
						move_uploaded_file($this->request->data['Shop']['cover_photo']['tmp_name'],$full_image_path1);
						$this->request->data['Shop']['cover_photo'] = $imageName1;
					
					}
				}
			} else {
				$this->request->data['Shop']['cover_photo'] = $this->request->data['Shop']['hid_cover_photo'];
			}
			
			if(!empty($this->request->data['Shop']['categories'])){
                            $cntcat = count($this->request->data['Shop']['categories']);
                            $data['subcat_id'] = array();
                            for($i=0;$i<$cntcat;$i++){
                                $category_id = $this->request->data['Shop']['categories'][$i];
                                $optionsCat = array('conditions' => array('Category.parent_id' => $category_id,'Category.is_active' => 1));
                                $category_data = $this->Category->find('all', $optionsCat);
                                if(count($category_data)>0){
                                    foreach($category_data as $catVal){
                                        if (!in_array($catVal['Category']['id'], $data['subcat_id'])) {
                                            $data['subcat_id'][] = $catVal['Category']['id'];
                                        }
                                    }
                                }
                            }
                            $this->request->data['Shop']['categories'] = implode(',',$this->request->data['Shop']['categories']);
                            $this->request->data['Shop']['sub_categories'] = implode(',',$data['subcat_id']);
                            //$this->request->data['Shop']['sub_categories'] = implode(',',$this->request->data['Shop']['sub_categories']);
			} else {
                            $this->request->data['Shop']['sub_categories'] = '';
                        }
			$slug = $this->createSlug($this->request->data['Shop']['name']);
                        $this->request->data['Shop']['slug'] = $slug;
                        
			if($this->request->data['Shop']['id']==''){
                            $this->request->data['Shop']['user_id'] = $userid;
                            $this->request->data['Shop']['is_active'] = 0;
                            $this->request->data['Shop']['created_at'] = date('Y-m-d H:i:s');
                            $this->Shop->create();
			}
                        if ($this->Shop->save($this->request->data)){
                            $lastinsertId = $this->Shop->getLastInsertId();

                            $userShop['User']['id'] = $userid;
                            $userShop['User']['paypal_business_email'] = $this->request->data['User']['paypal_business_email'];
                            $this->User->save($userShop);
                            if(isset($lastinsertId) && $lastinsertId!=''){
                                return $this->redirect(array('controller' => 'users', 'action' => 'payment', $lastinsertId));
                            } else {
                                $options = array('conditions' => array('Shop.id' => $this->request->data['Shop']['id']));
                                $shop = $this->Shop->find('first', $options);
                                if($shop['Shop']['is_active']==0){
                                    return $this->redirect(array('controller' => 'users', 'action' => 'payment', $shop['Shop']['id']));
                                }else{
                                    $Shop_id=$this->request->data['Shop']['id'];
                                    $is_featured=isset($this->request->data['Shop']['is_featured'])?$this->request->data['Shop']['is_featured']:'';
                                    if($is_featured==1){
                                        if(count($get_free_shop)==0){
                                            $feature_shop_free_days=$sitesetting['SiteSetting']['feature_shop_free_days'];
                                            $end_date=gmdate('Y-m-d H:i:s', strtotime("+".$feature_shop_free_days." days"));
                                            $data_shop['FeaturedShop']['user_id'] = $userid;
                                            $data_shop['FeaturedShop']['shop_id'] = $Shop_id;
                                            $data_shop['FeaturedShop']['type'] = 1;
                                            $data_shop['FeaturedShop']['start_date'] = gmdate('Y-m-d H:i:s');
                                            $data_shop['FeaturedShop']['end_date'] = $end_date;
                                            $data_shop['FeaturedShop']['cdate'] = gmdate('Y-m-d');
                                            $data_shop['FeaturedShop']['status'] = 1;
                                            $data_shop['FeaturedShop']['transcation_id'] = '';	
                                            $this->FeaturedShop->create();
                                            $this->FeaturedShop->save($data_shop);
                                           
                                            $this->Session->setFlash(__('You have successfully featured your shop.', 'default', array('class' => 'success')));
                                        }else{
                                            return $this->redirect(array('action' => 'featured_shop',  base64_encode($Shop_id)));
                                        }
                                    }
                                    return $this->redirect(array('action' => 'details', $slug, base64_encode($Shop_id)));
                                }
                                $this->Session->setFlash('The shop updated successfully.', 'default', array('class' => 'success'));
                            }
			}
	            }else{
                        $this->Session->setFlash(__('Shop already exists. Please, try another.', 'default', array('class' => 'error')));
                        return $this->redirect(array('action' => 'myshop'));
		    }
	        }else{
                    $options = array('conditions' => array('Shop.user_id' => $userid));
                    $shopCreated = $this->Shop->find('first', $options);
                    #pr($shopCreated);
                    if($shopCreated){
                        $options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $shopCreated['Shop']['id']));
                        $this->request->data = $this->Shop->find('first', $options);
                        if($this->request->data['Shop']['categories']!=''){
                            //$this->request->data['Shop']['categories'] = explode(',',$this->request->data['Shop']['categories']);
                        } 
                    } else {
                        $this->request->data['Shop']['categories'] = array();
                        $this->request->data['Shop']['logo'] = '';
                        $this->request->data['Shop']['hid_logo'] = '';
                        $this->request->data['Shop']['cover_photo'] = '';
                        $this->request->data['Shop']['hid_cover_photo'] = '';
                    }
		}
                
		$optioncategory = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id' => 0), 'fields' => array('Category.id','Category.name'));
                $categories = $this->Category->find('all',$optioncategory);
		$is_active = array('0'=>'No','1'=>'Yes');
	        $this->set(compact('title_for_layout','categories','is_active','get_free_shop','get_paid_shop'));
	}
        
        public function closed_shop() {
            $this->loadModel('CloseShop');
            $title_for_layout = 'Manage Shop';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
                return $this->redirect(array('action' => 'signin'));
            }
                
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['CloseShop']['user_id'] = $userid;
                $this->request->data['CloseShop']['cdate'] = gmdate('Y-m-d H:i:s');
                $this->request->data['CloseShop']['status'] = 1;
                $this->CloseShop->create();
                if ($this->CloseShop->save($this->request->data)){
                    $userShop['Shop']['id'] = $this->request->data['CloseShop']['shop_id'];
                    $userShop['Shop']['is_close'] = 1;
                    $this->Shop->save($userShop);
                }
                $this->Session->setFlash('Shop data updated successfully.', 'default', array('class' => 'success'));    
                //$this->Session->setFlash(__('Shop data updated successfully.', 'default', array('class' => 'success')));
                return $this->redirect(array('action' => 'myshop'));
            }
        }
        
        public function open_for_holiday($shop_id=null) {
            $this->loadModel('CloseShop');
            $title_for_layout = 'Manage Shop';
            if($shop_id==''){
                return $this->redirect(array('action' => 'myshop'));
            }
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
                return $this->redirect(array('action' => 'signin'));
            }
            $sid = base64_decode($shop_id);
            
            $option_shop = array('conditions' => array('CloseShop.shop_id'  =>$sid), 'fields' => array('CloseShop.id'));
            $shop_clglist = $this->CloseShop->find('all',$option_shop);
            
            $userShop['Shop']['id'] = $sid;
            $userShop['Shop']['is_close'] = 0;
            if ($this->Shop->save($userShop)){
                if(count($shop_clglist)>0){
                    foreach($shop_clglist as $val){
                        $closeshopId=$val['CloseShop']['id'];
                        $ClsShop['CloseShop']['id'] = $closeshopId;
                        $ClsShop['CloseShop']['status'] = 0;
                        $this->CloseShop->save($ClsShop);
                    }
                }
            }
            $this->Session->setFlash('Shop data updated successfully.', 'default', array('class' => 'success'));    
            return $this->redirect(array('action' => 'myshop'));
        }
        
        public function get_shop_status($shop_id=null){        
            $this->loadModel('CloseShop');
            $today_date=gmdate('Y-m-d');
            $shop_det=$this->CloseShop->find("first",array('conditions'=>array('CloseShop.shop_id'=>$shop_id,'CloseShop.status' => 1, 'CloseShop.from_date <=' => $today_date, 'CloseShop.to_date >=' => $today_date), 'order'=>array('CloseShop.id'=>'desc')));
            return $shop_det;
        }
        
        public function get_shop_status_check($shop_id=null){        
            $this->loadModel('CloseShop');
            $shop_det=$this->CloseShop->find("first",array('conditions'=>array('CloseShop.shop_id'=>$shop_id,'CloseShop.status' => 1), 'order'=>array('CloseShop.id'=>'desc')));
            return $shop_det;
        }
	/*public function myshop() {
            $this->loadModel('FeaturedShop');
            $this->loadModel('SiteSetting');
                $title_for_layout = 'Manage Shop';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    	$this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
	        	return $this->redirect(array('action' => 'signin'));
		}
                $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
                $sitesetting = $this->SiteSetting->find('first', $options_set);
        
		$options_spAdd = array('conditions' => array('FeaturedShop.user_id' => $userid, 'FeaturedShop.type' => 1));
                $get_free_shop = $this->FeaturedShop->find('first', $options_spAdd);
                
                $options_paidShop = array('conditions' => array('FeaturedShop.user_id' => $userid, 'FeaturedShop.type' => 2), 'order' => array('FeaturedShop.id' => 'desc'));
                $get_paid_shop = $this->FeaturedShop->find('first', $options_paidShop);
		if ($this->request->is(array('post', 'put'))) {

		    $options = array('conditions' => array('Shop.name'  => $this->request->data['Shop']['name'], 'Shop.id !=' => $this->request->data['Shop']['id']));
		    $shopexists = $this->Shop->find('first', $options);
                    if(!$shopexists){
			$uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
			$extensionValid = array('jpg','jpeg','png','gif');

			if(isset($this->request->data['Shop']['logo']) && $this->request->data['Shop']['logo']['name']!='')
			{
				$path = $this->request->data['Shop']['logo']['name'];
				$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				if($ext)
				{
					
					if(in_array($ext,$extensionValid))
					{
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Shop']['logo']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Shop']['logo']['tmp_name'],$full_image_path);
						$this->request->data['Shop']['logo'] = $imageName;
					
					} 
				}
			} else {
				$this->request->data['Shop']['logo'] = $this->request->data['Shop']['hid_logo'];
			}

			if(isset($this->request->data['Shop']['cover_photo']) && $this->request->data['Shop']['cover_photo']['name']!='')
			{
				$path1 = $this->request->data['Shop']['cover_photo']['name'];
				$ext1 = strtolower(pathinfo($path1, PATHINFO_EXTENSION));
				if($ext1)
				{
					if(in_array($ext1,$extensionValid))
					{
						$imageName1 = rand().'_'.(strtolower(trim($this->request->data['Shop']['cover_photo']['name'])));
						$full_image_path1 = $uploadPath . '/' . $imageName1;
						move_uploaded_file($this->request->data['Shop']['cover_photo']['tmp_name'],$full_image_path1);
						$this->request->data['Shop']['cover_photo'] = $imageName1;
					
					}
				}
			} else {
				$this->request->data['Shop']['cover_photo'] = $this->request->data['Shop']['hid_cover_photo'];
			}
			
			
			if(!empty($this->request->data['Shop']['sub_categories'])){
                            $cntcat = count($this->request->data['Shop']['sub_categories']);
                            $data['pcat_id'] = array();
                            for($i=0;$i<$cntcat;$i++)
                            {
                                $category_id = $this->request->data['Shop']['sub_categories'][$i];
                                $optionsCat = array('conditions' => array('Category.id' => $category_id));
                                $category_data = $this->Category->find('first', $optionsCat);
                                if (!in_array($category_data['Category']['parent_id'], $data['pcat_id'])) {
                                        $data['pcat_id'][] = $category_data['Category']['parent_id'];
                                    }
                            }
                            $this->request->data['Shop']['categories'] = implode(',',$data['pcat_id']);
                            $this->request->data['Shop']['sub_categories'] = implode(',',$this->request->data['Shop']['sub_categories']);
				
			} else {
				$this->request->data['Shop']['sub_categories'] = '';
			}
			if($this->request->data['Shop']['id']==''){
				$this->request->data['Shop']['user_id'] = $userid;
				$this->request->data['Shop']['is_active'] = 0;
				$this->request->data['Shop']['created_at'] = date('Y-m-d H:i:s');
				$this->Shop->create();
			}
                        if ($this->Shop->save($this->request->data)){
                            $lastinsertId = $this->Shop->getLastInsertId();

                            $userShop['User']['id'] = $userid;
                            $userShop['User']['paypal_business_email'] = $this->request->data['User']['paypal_business_email'];
                            $this->User->save($userShop);
                            if(isset($lastinsertId) && $lastinsertId!=''){
                                return $this->redirect(array('controller' => 'users', 'action' => 'payment', $lastinsertId));
                            } else {
                                $options = array('conditions' => array('Shop.id' => $this->request->data['Shop']['id']));
                                $shop = $this->Shop->find('first', $options);
                                if($shop['Shop']['is_active']==0){
                                    return $this->redirect(array('controller' => 'users', 'action' => 'payment', $shop['Shop']['id']));
                                }else{
                                    $Shop_id=$this->request->data['Shop']['id'];
                                    $is_featured=isset($this->request->data['Shop']['is_featured'])?$this->request->data['Shop']['is_featured']:'';
                                    if($is_featured==1){
                                        if(count($get_free_shop)==0){
                                            $feature_shop_free_days=$sitesetting['SiteSetting']['feature_shop_free_days'];
                                            $end_date=gmdate('Y-m-d H:i:s', strtotime("+".$feature_shop_free_days." days"));
                                            $data_shop['FeaturedShop']['user_id'] = $userid;
                                            $data_shop['FeaturedShop']['shop_id'] = $Shop_id;
                                            $data_shop['FeaturedShop']['type'] = 1;
                                            $data_shop['FeaturedShop']['start_date'] = gmdate('Y-m-d H:i:s');
                                            $data_shop['FeaturedShop']['end_date'] = $end_date;
                                            $data_shop['FeaturedShop']['cdate'] = gmdate('Y-m-d');
                                            $data_shop['FeaturedShop']['status'] = 1;
                                            $data_shop['FeaturedShop']['transcation_id'] = '';	
                                            $this->FeaturedShop->create();
                                            $this->FeaturedShop->save($data_shop);
                                           
                                            $this->Session->setFlash(__('You have successfully featured your shop.', 'default', array('class' => 'success')));
                                        }else{
                                            return $this->redirect(array('action' => 'featured_shop',  base64_encode($Shop_id)));
                                        }
                                    }
                                    return $this->redirect(array('action' => 'details',  base64_encode($Shop_id)));
                                }
                                $this->Session->setFlash('The shop updated successfully.', 'default', array('class' => 'success'));
                            }
			}
	            }else{
			 $this->Session->setFlash(__('Shop already exists. Please, try another.', 'default', array('class' => 'error')));
                         return $this->redirect(array('action' => 'myshop'));
		    }
	        }else{
                    $options = array('conditions' => array('Shop.user_id' => $userid));
                    $shopCreated = $this->Shop->find('first', $options);
                    #pr($shopCreated);
                    if($shopCreated){
                            $options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $shopCreated['Shop']['id']));
                            $this->request->data = $this->Shop->find('first', $options);
                            if($this->request->data['Shop']['categories']!=''){
                                $this->request->data['Shop']['categories'] = explode(',',$this->request->data['Shop']['categories']);
                            } 
                    } else {
                            $this->request->data['Shop']['categories'] = array();
                            $this->request->data['Shop']['logo'] = '';
                            $this->request->data['Shop']['hid_logo'] = '';
                            $this->request->data['Shop']['cover_photo'] = '';
                            $this->request->data['Shop']['hid_cover_photo'] = '';
                    }
		}
                
		$optioncategory = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id' => 0), 'fields' => array('Category.id','Category.name'));
                $categories = $this->Category->find('all',$optioncategory);
		$is_active = array('0'=>'No','1'=>'Yes');
	        $this->set(compact('title_for_layout','categories','is_active','get_free_shop','get_paid_shop'));
	}*/
        
        public function featured_shop($shop_id=null){
            $title_for_layout = 'Featured Shop';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->Session->setFlash(__('Please login to featured shop.', 'default', array('class' => 'error')));
                return $this->redirect(array('controller' => 'users', 'action' => 'signin'));
            }
            if(!isset($shop_id) && $shop_id==''){
                $this->Session->setFlash(__('Invalid shop id.', 'default', array('class' => 'error')));
                return $this->redirect(array('controller' => 'shops', 'action' => 'myshop'));
            }
            $id=  base64_decode($shop_id);
            $options = array('conditions' => array('Shop.id' => $id));
            $shopexists = $this->Shop->find('first', $options);
            if(count($shopexists)==0){
                $this->Session->setFlash(__('Invalid shop id.', 'default', array('class' => 'error')));
                return $this->redirect(array('controller' => 'shops', 'action' => 'myshop'));
            }
            $this->set(compact('title_for_layout','shop_id','shopexists','userid'));
        }
        
        public function featured_shop_success(){
            
            $status = 'Completed';
            $date = gmdate('Y-m-d H:i:s');
            $this->loadModel('FeaturedShop');
            $this->loadModel('Payment');
            $this->loadModel('SiteSetting');
            $arr = array();
            
            $options_set = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
            $sitesetting = $this->SiteSetting->find('first', $options_set);
            $custom_data=$_REQUEST['custom'];
            if($custom_data!=''){
                $custom_data_exp=explode('|', $custom_data);
                $userid=$custom_data_exp[1];
                $Shop_id=base64_decode($custom_data_exp[0]);
                $arr['Shop']['id']= $Shop_id;
                $arr['Shop']['is_featured']= 1;
                if($this->Shop->save($arr)){
                    
                    $options_shop = array('conditions' => array('FeaturedShop.cdate' => gmdate('Y-m-d'), 'FeaturedShop.shop_id' => $Shop_id, 'FeaturedShop.user_id' => $userid));
                    $shop_exist = $this->FeaturedShop->find('first', $options_shop);
                    if(empty($shop_exist)){
                        $feature_shop_free_days=$sitesetting['SiteSetting']['feature_shop_paid_days'];
                        $end_date=gmdate('Y-m-d H:i:s', strtotime("+".$feature_shop_free_days." days"));
                        $data_shop['FeaturedShop']['user_id'] = $userid;
                        $data_shop['FeaturedShop']['shop_id'] = $Shop_id;
                        $data_shop['FeaturedShop']['type'] = 2;
                        $data_shop['FeaturedShop']['start_date'] = gmdate('Y-m-d H:i:s');
                        $data_shop['FeaturedShop']['end_date'] = $end_date;
                        $data_shop['FeaturedShop']['cdate'] = gmdate('Y-m-d');
                        $data_shop['FeaturedShop']['status'] = 1;
                        $data_shop['FeaturedShop']['transcation_id'] = isset($_REQUEST['payer_id'])?$_REQUEST['payer_id']:'';	
                        $this->FeaturedShop->create();
                        $this->FeaturedShop->save($data_shop);

                        $arr1['Payment']['userid']= $userid;
                        $arr1['Payment']['amount']= $sitesetting['SiteSetting']['feature_shop_paid_fee'];;
                        $arr1['Payment']['datetime']= $date;
                        $arr1['Payment']['status']= $status;
                        $arr1['Payment']['transaction_id']= isset($_REQUEST['payer_id'])?$_REQUEST['payer_id']:'';
                        $arr1['Payment']['for']= 'for featured shop';
                        $arr1['Payment']['type'] = 1;
                        $this->Payment->create();
                        $this->Payment->save($arr1);
                    }
                }
                $this->Session->setFlash('You have successfully featured your shop.', 'default', array('class' => 'success'));
            }
            return $this->redirect(array('controller' => 'shops', 'action' => 'myshop'));
        }

	public function admin_list() {	
            
                 $this->loadModel('User');
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Shop List';
                $this->paginate = array(
			'order' => array(
				'User.id' => 'desc'
			),'conditions'=>array('User.type'=>'V','User.is_active'=>1)
		);
		$this->User->recursive = -1;
                
                $this->Paginator->settings = $this->paginate;
		$this->set('shops', $this->Paginator->paginate('User'));
		$this->set(compact('title_for_layout'));
	}

        public function admin_add() {
            $this->loadModel('User');
		$title_for_layout = 'Add Vendor';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
		if ($this->request->is(array('post', 'put'))) {


                $options = array('conditions' => array('User.email'  => $this->request->data['User']['email']));
        $emailexists = $this->User->find('first', $options);
        if(!$emailexists)
        {
          
         
         $this->request->data['User']['registration_date'] = date('Y-m-d');
         $this->request->data['User']['is_admin'] = 0;
         $this->request->data['User']['password']=$this->request->data['User']['password'];
         $this->request->data['User']['first_name']=$this->request->data['User']['first_name'];
         $this->request->data['User']['last_name']=$this->request->data['User']['last_name'];
         $this->request->data['User']['email']=$this->request->data['User']['email'];
         
         $this->request->data['User']['company_name']=$this->request->data['User']['company_name'];
         $this->request->data['User']['mobile_number']=$this->request->data['User']['mobile_number'];
         $this->request->data['User']['dba']=$this->request->data['User']['dba'];
         $this->request->data['User']['ein']=$this->request->data['User']['ein'];
         
         $this->request->data['User']['type']='V';
         $this->request->data['User']['percentage_id']=$this->request->data['User']['percentage_id'];;

         $this->User->create();
         if ($this->User->save($this->request->data)) 
          {
            $this->Session->setFlash('The Vendor added successfully.', 'default', array('class' => 'success'));
            
           return $this->redirect(array('action' => 'list'));
          }else 
          {
            $this->Session->setFlash(__('The Vendor could not be saved. Please, try again.'));
          }
         }
         else 
         {
           $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
             }

			
	        }
                
               
                $percentage_value = $this->Percentage->find('list',array());
		$is_active = array('0'=>'No','1'=>'Yes');
	        $this->set(compact('users','title_for_layout','is_active','percentage_value'));
	}


	public function admin_edit($id = null) {
                $title_for_layout = 'Edit Vendor';
                $this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
		if ($this->request->is(array('post', 'put'))) 
		{
		    

             $options = array('conditions' => array('User.email'  => $this->request->data['User']['email'],'User.id !='=>$this->request->data['User']['id']));
        $emailexists = $this->User->find('first', $options);
        if(!$emailexists)
        {
          
         
        // print_r($this->request->data);exit;
         $this->request->data['User']['first_name']=$this->request->data['User']['first_name'];
         $this->request->data['User']['last_name']=$this->request->data['User']['last_name'];
         $this->request->data['User']['email']=$this->request->data['User']['email'];
         
         $this->request->data['User']['company_name']=$this->request->data['User']['company_name'];
         $this->request->data['User']['mobile_number']=$this->request->data['User']['mobile_number'];
         
         $this->request->data['User']['dba'] = $this->request->data['User']['dba'];
         $this->request->data['User']['ein'] = $this->request->data['User']['ein'];
         $this->request->data['User']['type']='V';
         $this->request->data['User']['id'] = $this->request->data['User']['id'];
         $this->request->data['User']['is_active'] = $this->request->data['User']['is_active'];
         $this->request->data['User']['percentage_id'] = $this->request->data['User']['percentage_id'];
         
         if ($this->User->save($this->request->data)) 
          {
            
           $this->Session->setFlash('The Vendor successfully updated.','default', array('class' => 'success'));
            
           
          } 
          else 
          {
            $this->Session->setFlash(__('The Vendor could not be saved. Please, try again.'));
          }
         }
         else 
         {
           $this->Session->setFlash(__('Email already exists. Please, try another.', 'default', array('class' => 'error')));
             }
	
	        }
		else 
		{
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			
         $this->request->data['User']['password']=$this->request->data['User']['password'];
         $this->request->data['User']['first_name']=$this->request->data['User']['first_name'];
         $this->request->data['User']['last_name']=$this->request->data['User']['last_name'];
         $this->request->data['User']['email']=$this->request->data['User']['email'];
       
         $this->request->data['User']['company_name']=$this->request->data['User']['company_name'];
         $this->request->data['User']['mobile_number']=$this->request->data['User']['mobile_number'];
         $this->request->data['User']['dba']=$this->request->data['User']['dba'];
         $this->request->data['User']['ein']=$this->request->data['User']['ein'];
		}
                $optionuser = array('conditions' => array('User.is_active'  => 1,'User.is_admin' => 0), 'fields' => array('User.id','User.name'));
                $users = $this->User->find('list',$optionuser);
               
                 $percentage_value = $this->Percentage->find('list',array());
		$is_active = array('0'=>'No','1'=>'Yes');
	        $this->set(compact('users','title_for_layout','is_active','percentage_value'));
	}


	public function admin_view($id = null) 
	{
		$title_for_layout = 'Vendor View';
		$this->set(compact('title_for_layout'));
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if (!$this->User->exists($id)) 
		{
			throw new NotFoundException(__('Invalid Vendor.'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('shop', $this->User->find('first', $options));
	}
	
        public function admin_delete($id = null) {
	   $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->User->id = $id;
	   if (!$this->User->exists()) {
	      throw new NotFoundException(__('Invalid Vendor.'));
	   }
	   if ($this->User->delete($id)) {
		$this->Session->setFlash('The Vendor has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('The Vendor could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'list'));
	}
	
	public function getcatNames($id = null){
		$name = '';
		if($id!=''){
			$cat = explode(',',$id);
			if(!empty($cat)){
				foreach($cat as $data){
					$options = array('conditions' => array('Category.id' => $data));
					$category= $this->Category->find('first', $options);	
					$name.= $category['Category']['name'].', ';
				}	
			}
		}
		return rtrim($name,', ');
	}

/***********Kundu***************/
	public function add_follow($id = null){
        	$this->loadModel('Follow');
        	$this->loadModel('Shop');
        	$id = base64_decode($id);
		if (!$this->Shop->exists($id)) {
                    $this->Session->setFlash(__('Invalid shop.'));
                    return $this->redirect('/products/list/');
		}
                $options = array('conditions' => array('Shop.id'  => $id));
                $shop_data = $this->Shop->find('first', $options);
                $slug=$shop_data['Shop']['slug'];    
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && empty($userid))
		{
			$this->Session->setFlash(__('Please login to follow.'));
			return $this->redirect('/users/login/');
		}
		
		$options = array('conditions' => array('Follow.user_id'=> $userid, 'Follow.shop_id'=> $id));
		$wishlist = $this->Follow->find('first', $options);
		
		if(empty($wishlist))
		{
		   	$wish['Follow']['user_id'] = $userid;
			$wish['Follow']['shop_id'] = $id;
			$wish['Follow']['date'] = date('Y-m-d H:i:s');
			$this->Follow->create();
			if($this->Follow->save($wish))
			{
		          $this->Session->setFlash('Congratulation! You are now following the shop.', 'default', array('class' => 'success'));
		     }
			else 
			{
		          $this->Session->setFlash(__('Sorry! Please, try again.'));
		          return $this->redirect('/shops/details/'.$slug.'/'.base64_encode($id));
		     }
          }else{
          	$this->Session->setFlash(__('You are already following the shop.'));
          }
          return $this->redirect('/shops/details/'.$slug.'/'.base64_encode($id));
        }
        
        public function un_follow($id=null){
        	$this->loadModel('Follow');
        	$this->loadModel('Shop');
        	$id = base64_decode($id);
		if (!$this->Follow->exists($id)) {
			$this->Session->setFlash(__('Invalid request.'));
			return $this->redirect('/users/follow/');
		}
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && empty($userid))
		{
			$this->Session->setFlash(__('Please login to unfollow.'));
			return $this->redirect('/users/login/');
		}
		$options = array('conditions' => array('Follow.id'=> $id));
		$follow = $this->Follow->find('first', $options);
		if($follow['Follow']['user_id'] == $userid)
		{
			$this->Follow->id = $id;
			if ($this->Follow->delete($id)) {
				$this->Session->setFlash('You have successfully unfollowed the store.', 'default', array('class' => 'success'));
			}else{
				$this->Session->setFlash(__('Sorry could not unfollowed the store.'));
			}
		}else{
			$this->Session->setFlash(__('Sorry you donot have permission.'));
		}
		return $this->redirect('/users/follow');
        }
/***********Kundu***************/
        /****************anup**********************/
        public function shop_related_product_count($shop_id=null)
        {        
            $this->loadModel('Product');
             $product_count=$this->Product->find("count",array('conditions'=>array('Product.shop_id'=>$shop_id,'Product.status' => 'A', 'Product.is_deleted' => 0)));
             return $product_count;
        }
}

