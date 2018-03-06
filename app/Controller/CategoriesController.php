<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getsubcat');
	   }
        
        public $paginate = array(
        'limit' =>15,
        'order' => array(
            'Categories.order_rank' => 'desc'
        )
    ); 

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->Paginator->paginate());
	}
	
	public function admin_index() {		
            $title_for_layout = 'Category List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            //$this->Category->recursive = 0;
            $this->Paginator->settings = array(
                'limit' =>15,
                'order' => array(
                   'Category.id' => 'asc'
                ),'conditions' => array(
                   'Category.is_active'=> 1
                )
            );
            $this->set('categories', $this->Paginator->paginate('Category'));
            $this->set(compact('title_for_layout'));
	}
        
        
        public function admin_coupon_list() {		
            $title_for_layout = 'Category List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
           //$this->Category->recursive = 0;
            $this->Paginator->settings = array(
                'limit' =>15,
                'order' => array(
                   'Category.id' => 'asc'
                ),
                'conditions' => array(
                   'Category.type'=> 'C'
                )
            );
            
            $this->set('categories', $this->Paginator->paginate('Category'));
            $this->set(compact('title_for_layout'));
	}
        
        
        
        
        public function admin_saveorder() {
            $this->autoRender = false;
            $cat_order=$this->request->data['cat_order'];
            $Sl_cnt=0;
            if(count($cat_order)>0){
                foreach($cat_order as $val){
                    $Sl_cnt++;
                    $data_cat['Category']['id']=$val;
                    $data_cat['Category']['ordering']=$Sl_cnt;
                    $this->Category->save($data_cat);    
		}
            }
	}

	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}

	public function admin_view($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Category View';
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid Category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$category = $this->Category->find('first', $options);
		if($category){
			$options = array('conditions' => array('Category.id' => $category['Category']['parent_id']));
			$categoryname = $this->Category->find('list', $options);
			if($categoryname){
				$categoryname = $categoryname[$category['Category']['parent_id']];
			} else {
				$categoryname = '';
			}
		}
		$this->set(compact('title_for_layout','category','categoryname'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		}
		$parentCategories = $this->Category->ParentCategory->find('list');
		$this->set(compact('parentCategories'));
	}

	public function admin_add() {			
		$title_for_layout = 'Category Add';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if ($this->request->is('post')) {
			$options = array('conditions' => array('Category.name'  => $this->request->data['Category']['name'],'Category.parent_id'=>0));
			$name = $this->Category->find('first', $options);
			if(!$name){
                            
                           if(!empty($this->request->data['Category']['image']['name'])){
      $pathpart=pathinfo($this->request->data['Category']['image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "category_images/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Category']['image']['tmp_name'],$full_flg_path);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
      }
     }
     else{
      $filename='';
     }
     $this->request->data['Category']['image'] = $filename;
                            
                            
				if ($this->Category->save($this->request->data)) {
					$this->Session->setFlash('The category has been saved.', 'default', array('class' => 'success'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}

			} else {
				$this->Session->setFlash(__('The category name already exists. Please, try again.'));
			}
		}
		$this->set(compact('title_for_layout'));
	}

        
        
        
        
        public function admin_coupon_add() {			
		$title_for_layout = 'Category Add';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if ($this->request->is('post')) {
                    
                    
			$options = array('conditions' => array('Category.name'  => $this->request->data['Category']['name'],'Category.parent_id'=>0));
			$name = $this->Category->find('first', $options);
			if(!$name){
                            
                           if(!empty($this->request->data['Category']['image']['name'])){
      $pathpart=pathinfo($this->request->data['Category']['image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "category_images/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Category']['image']['tmp_name'],$full_flg_path);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
      }
     }
     else{
      $filename='';
     }
     $this->request->data['Category']['image'] = $filename;
     
     $this->request->data['Category']['type']= "C";
                            
                            
				if ($this->Category->save($this->request->data)) {
					$this->Session->setFlash('The category has been saved.', 'default', array('class' => 'success'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}

			} else {
				$this->Session->setFlash(__('The category name already exists. Please, try again.'));
			}
		}
		$this->set(compact('title_for_layout'));
	}

	public function admin_addsubcategory($id = null) {	
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$id=$id;
		$title_for_layout = 'Sub Category Add';
		if ($this->request->is('post')) 
		{
			$options = array('conditions' => array('Category.name'=>$this->request->data['Category']['name'],'Category.parent_id'=>$this->request->data['Category']['parent_id']));
			$name=$this->Category->find('first',$options);
			if(!$name){
					if ($this->Category->save($this->request->data)) {
					  $this->Session->setFlash('The sub category has been saved.', 'default', array('class' => 'success'));
					  return $this->redirect(array('action' => 'subcategories',$id));
					} 
					else {
					  $this->Session->setFlash(__('The sub category could not be saved. Please, try again.'));
					}
				} 
               else 
			   {
				$this->Session->setFlash(__('The sub category name already exists. Please, try again.'));
			   }
		}

		$options = array('conditions' => array('Category.id' => $id));
		$categoryname = $this->Category->find('list', $options);
                
		if($categoryname){
			$categoryname = $categoryname[$id];
		} else {
			$categoryname = '';
		}
                                
		$this->set(compact('title_for_layout','categoryname','id'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
		$parentCategories = $this->Category->ParentCategory->find('list');
		$this->set(compact('parentCategories'));
	}

	public function admin_edit($id = null) 
	{
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$redirectid='';
		if (!$this->Category->exists($id)) 
		{
			throw new NotFoundException(__('Invalid category'));
		}

		if ($this->request->is(array('post', 'put')))
		{
			$options = array('conditions' => array('Category.name'  => $this->request->data['Category']['name'], 'Category.parent_id'=>$this->request->data['Category']['parent_id'], 'Category.id <>'=>$id));
            $name = $this->Category->find('first', $options);
                    
			if(!$name)
			{
                            
                            if(!empty($this->request->data['Category']['image']['name'])){
        $pathpart=pathinfo($this->request->data['Category']['image']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "category_images/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Category']['image']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
        }
       }
       else{
        $filename=$this->request->data['Category']['hid_img'];
       }
       $this->request->data['Category']['image'] = $filename;
       
       if($this->request->data['Category']['is_popular']==""){
           
           $this->request->data['Category']['is_popular']=0;
       }
				$options3=array('conditions' => array('Category.'. $this->Category->primaryKey => $id));
				$cat=$this->Category->find('first', $options3);
                if($cat['Category']['parent_id']!=0)
				{
					$redirectid=$cat['Category']['parent_id'];
				}
				else
				{
                    $redirectid='';
				}
				$this->request->data['Category']['id']=$id;
                        
				if ($this->Category->save($this->request->data)) 
				{                    
					$this->Session->setFlash('The category has been saved.', 'default', array('class' => 'success'));
				    if (isset($redirectid) && !empty($redirectid)) {
					  return $this->redirect(array('action' => 'subcategories',$redirectid));
				    }  
				    else {
					 return $this->redirect(array('action' => 'index'));  
				   }
				} 
                else 
				{
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			} 
           else 
			{
				$this->Session->setFlash(__('The category already exists. Please, try again.'));
			}
         } 
			
		$options = array('conditions' => array('Category.'.$this->Category->primaryKey => $id));
		$this->request->data = $this->Category->find('first', $options);

		$this->set(compact('title_for_layout'));
	}
        
        
        
        public function admin_coupon_edit($id = null) 
	{
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$redirectid='';
		if (!$this->Category->exists($id)) 
		{
			throw new NotFoundException(__('Invalid category'));
		}

		if ($this->request->is(array('post', 'put')))
		{
			$options = array('conditions' => array('Category.name'  => $this->request->data['Category']['name'], 'Category.parent_id'=>$this->request->data['Category']['parent_id'], 'Category.id <>'=>$id));
            $name = $this->Category->find('first', $options);
                    
			if(!$name)
			{
                            
                            if(!empty($this->request->data['Category']['image']['name'])){
        $pathpart=pathinfo($this->request->data['Category']['image']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "category_images/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Category']['image']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
        }
       }
       else{
        $filename=$this->request->data['Category']['hid_img'];
       }
       $this->request->data['Category']['image'] = $filename;
				$options3=array('conditions' => array('Category.'. $this->Category->primaryKey => $id));
				$cat=$this->Category->find('first', $options3);
                if($cat['Category']['parent_id']!=0)
				{
					$redirectid=$cat['Category']['parent_id'];
				}
				else
				{
                    $redirectid='';
				}
				$this->request->data['Category']['id']=$id;
                                $this->request->data['Category']['is_popular']=$this->request->data['Category']['is_popular'];
                                if($this->request->data['Category']['is_popular']== ""){
                                $this->request->data['Category']['is_popular']= 0;
                                }
				if ($this->Category->save($this->request->data)) 
				{                    
					$this->Session->setFlash('The category has been saved.', 'default', array('class' => 'success'));
				    if (isset($redirectid) && !empty($redirectid)) {
					  return $this->redirect(array('action' => 'subcategories',$redirectid));
				    }  
				    else {
					 return $this->redirect(array('action' => 'coupon_list'));  
				   }
				} 
                else 
				{
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			} 
           else 
			{
				$this->Session->setFlash(__('The category already exists. Please, try again.'));
			}
         } 
			
		$options = array('conditions' => array('Category.'.$this->Category->primaryKey => $id));
		$this->request->data = $this->Category->find('first', $options);

		$this->set(compact('title_for_layout'));
	}
        
        
        
        
        
        
        

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('The category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		
		$options1 = array('conditions' => array('Category.parent_id' => $id));
		$subcat = $this->Category->find('list', $options1);
		if($subcat){
			foreach($subcat as $k1=>$v1){
				$this->Category->delete($k1);
			}
		}
			
		if ($this->Category->delete($id)) {
			$this->Session->setFlash('The category has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function admin_getsubcat($id = null){
		$this->loadModel('Category');
		$options = array('conditions' => array('Category.parent_id'=>$id,'Category.is_active' => 1 ));
          $categories = $this->Category->find('all', $options);
          return $categories;
	}
	
	public function getsubcat($id = null){
		$this->loadModel('Category');
		$options = array('conditions' => array('Category.parent_id'=>$id,'Category.is_active' => 1 ));
          $categories = $this->Category->find('all', $options);
          return $categories;
	}
}
