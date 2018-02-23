<?php

App::uses('AppController', 'Controller');

/**

 * Shops Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class AdvertisesController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('Advertise','User');

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
		$title_for_layout = 'Advertise List';
                $this->paginate = array(
			'order' => array(
				'Advertise.id' => 'desc'
			)
		);
		$this->Advertise->recursive = 0;
                $this->Paginator->settings = $this->paginate;
		$this->set('advertises', $this->Paginator->paginate());
		$this->set(compact('title_for_layout'));
	}

        public function admin_add() {
            
            
		$title_for_layout = 'Add Advertise';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
            
            if ($this->request->is('post')) {
    
   
      if(!empty($this->request->data['Advertise']['logo']['name'])){
      $pathpart=pathinfo($this->request->data['Advertise']['logo']['name']);
      $ext=$pathpart['extension'];
      $extensionValid = array('jpg','jpeg','png','gif');
      if(in_array(strtolower($ext),$extensionValid)){
      $uploadFolder = "advertise_logos/";
      $uploadPath = WWW_ROOT . $uploadFolder;
      $filename =uniqid().'.'.$ext;
      $full_flg_path = $uploadPath . '/' . $filename;
      move_uploaded_file($this->request->data['Advertise']['logo']['tmp_name'],$full_flg_path);
      }
      else{
       $this->Session->setFlash(__('Invalid image type.'));
      }
     }
     else{
      $filename='';
     }
      $this->request->data['Advertise']['logo'] = $filename;
      $this->request->data['Advertise']['name'] = $this->request->data['Advertise']['name'];
      $this->request->data['Advertise']['description'] =$this->request->data['Advertise']['description'];
      $this->request->data['Advertise']['link'] = $this->request->data['Advertise']['link'];
      $this->request->data['Advertise']['status'] = 1;
      $this->Advertise->create();

     if ($this->Advertise->save($this->request->data)) {

      $this->Session->setFlash('Advertise has been saved.','default', array('class' => 'success'));
      //return $this->redirect(array('action' => 'list'));
     } else {
      $this->Session->setFlash(__('Advertise could not be saved. Please, try again.', 'default', array('class' => 'error')));
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
		$title_for_layout = 'Edit Advertise';
		$this->set(compact('title_for_layout'));
		
		if (!$this->Advertise->exists($id)) {
			throw new NotFoundException(__('Invalid Ad'));
		}
		if ($this->request->is(array('post', 'put'))) {

        if(!empty($this->request->data['Advertise']['logo']['name'])){
        $pathpart=pathinfo($this->request->data['Advertise']['logo']['name']);
        $ext=$pathpart['extension'];
        $extensionValid = array('jpg','jpeg','png','gif');
        if(in_array(strtolower($ext),$extensionValid)){
        $uploadFolder = "advertise_logos/";
        $uploadPath = WWW_ROOT . $uploadFolder;
        $filename =uniqid().'.'.$ext;
        $full_flg_path = $uploadPath . '/' . $filename;
        move_uploaded_file($this->request->data['Advertise']['logo']['tmp_name'],$full_flg_path);
        }
        else{
         $this->Session->setFlash(__('Invalid image type.'));
        }
       }
       else{
        $filename=$this->request->data['Advertise']['logos'];
       }
        $this->request->data['Advertise']['logo'] = $filename;
        $this->request->data['Advertise']['name'] = $this->request->data['Advertise']['name'];
        $this->request->data['Advertise']['description'] =$this->request->data['Advertise']['description'];
        $this->request->data['Advertise']['link'] = $this->request->data['Advertise']['link'];
        $this->request->data['Advertise']['status'] = 1;
        

			if ($this->Advertise->save($this->request->data)) {

        
				$this->Session->setFlash('The advertise has been saved.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'list'));
			} else {
				$this->Session->setFlash(__('The advertise could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('Advertise.' . $this->Advertise->primaryKey => $id));
			$this->request->data = $this->Advertise->find('first', $options);

      
     
     
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
	   $this->Advertise->id = $id;
	   if (!$this->Advertise->exists()) {
	      throw new NotFoundException(__('Invalid ad.'));
	   }
	   if ($this->Advertise->delete($id)) {
		$this->Session->setFlash('The advertise has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('The advertise could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'list'));
	}
	
	/*public function getcatNames($id = null){
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
	}*/


}

