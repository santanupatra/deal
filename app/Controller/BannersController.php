<?php

App::uses('AppController', 'Controller');

/**

 * Shops Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class BannersController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('Banner','User');

	/*public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('details', 'getSubcategorydetails','product_list','feedback','contact_details','shop_related_product_count','get_shop_status');
	   }*/

	
        
        

	public function admin_list() {		
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Banner List';
                $this->paginate = array(
			'order' => array(
				'Banner.id' => 'desc'
			)
		);
		$this->Banner->recursive = 0;
                $this->Paginator->settings = $this->paginate;
		$this->set('banners', $this->Paginator->paginate());
		$this->set(compact('title_for_layout'));
	}

        public function admin_add() {
            
            
		$title_for_layout = 'Add Banner';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
            
            if ($this->request->is('post')) {
    
   
      if(!empty($this->request->data['Banner']['image']['name'])){
      $pathpart=pathinfo($this->request->data['Banner']['image']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
     
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "banner_image/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Banner']['image']['tmp_name'],$full_flg_path);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
       return $this->redirect(array('action' => 'add'));
      }
     }
     else{
      $filename='';
     }
      $this->request->data['Banner']['image'] = $filename;
      $this->request->data['Banner']['title'] = $this->request->data['Banner']['title'];
      
      $this->Banner->create();

     if ($this->Banner->save($this->request->data)) {

      $this->Session->setFlash('Banner has been saved.','default', array('class' => 'success'));
      return $this->redirect(array('action' => 'list'));
     } else {
      $this->Session->setFlash(__('Banner could not be saved. Please, try again.', 'default', array('class' => 'error')));
     }

     
   }
            
       }
       
       
   public function admin_edit($id = null) {
	    $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}

	    $this->request->data1=array();
		$title_for_layout = 'Edit Banner';
		$this->set(compact('title_for_layout'));
		
		if (!$this->Banner->exists($id)) {
			throw new NotFoundException(__('Invalid Ad'));
		}
		if ($this->request->is(array('post', 'put'))) {

        if(!empty($this->request->data['Banner']['image']['name'])){
        $pathpart=pathinfo($this->request->data['Banner']['image']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "banner_image/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Banner']['image']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
         return $this->redirect(array('action' => 'edit'));
        }
       }
       else{
        $filename=$this->request->data['Banner']['logos'];
       }
        $this->request->data['Banner']['image'] = $filename;
        $this->request->data['Banner']['title'] = $this->request->data['Banner']['title'];
        
        

			if ($this->Banner->save($this->request->data)) {

        
				$this->Session->setFlash('The banner has been saved.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'list'));
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('Banner.' . $this->Banner->primaryKey => $id));
			$this->request->data = $this->Banner->find('first', $options);

      
     
     
	}    
       
    }   


	


	/*public function admin_view($id = null) 
	{
		$title_for_layout = 'Shop View';
		$this->set(compact('title_for_layout'));
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if (!$this->Shop->exists($id)) 
		{
			throw new NotFoundException(__('Invalid shop.'));
		}
		$options = array('conditions' => array('Shop.' . $this->Shop->primaryKey => $id));
		$this->set('shop', $this->Shop->find('first', $options));
	}*/
	
        public function admin_delete($id = null) {
	   $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->Banner->id = $id;
	   if (!$this->Banner->exists()) {
	      throw new NotFoundException(__('Invalid banner.'));
	   }
	   if ($this->Banner->delete($id)) {
		$this->Session->setFlash('The banner has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('The banner could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'list'));
	}
	
	


}

