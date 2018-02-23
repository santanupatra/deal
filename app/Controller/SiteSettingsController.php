<?php
App::uses('AppController', 'Controller');
/**
 * SiteSettings Controller
 *
 * @property SiteSetting $SiteSetting
 * @property PaginatorComponent $Paginator
 */
class SiteSettingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SiteSetting->recursive = 0;
		$this->set('siteSettings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SiteSetting->exists($id)) {
			throw new NotFoundException(__('Invalid site setting'));
		}
		$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
		$this->set('siteSetting', $this->SiteSetting->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SiteSetting->create();
			if ($this->SiteSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The site setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site setting could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SiteSetting->exists($id)) {
			throw new NotFoundException(__('Invalid site setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SiteSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The site setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
			$this->request->data = $this->SiteSetting->find('first', $options);
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
		$this->SiteSetting->id = $id;
		if (!$this->SiteSetting->exists()) {
			throw new NotFoundException(__('Invalid site setting'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SiteSetting->delete()) {
			$this->Session->setFlash(__('The site setting has been deleted.'));
		} else {
			$this->Session->setFlash(__('The site setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

        public function admin_edit($id = null) {
                $title_for_layout = 'Site Setting';
	        $this->set(compact('title_for_layout'));
	        $userid = $this->Session->read('Auth.User.id');
                if(!isset($userid) && $userid=='')
                {
	           $this->redirect('/admin');
                }
		if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			if ($this->SiteSetting->save($this->request->data)) {
                $this->Session->setFlash('The site setting has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The site setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
			$this->request->data = $this->SiteSetting->find('first', $options);
		}
	}
	
	public function admin_sociallink($id = null) {
	        $title_for_layout = 'Social Link';
	        $this->set(compact('title_for_layout'));
	        $userid = $this->Session->read('Auth.User.id');
                if(!isset($userid) && $userid=='')
                {
	           $this->redirect('/admin');
                }
		if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			if ($this->SiteSetting->save($this->request->data)) {
                $this->Session->setFlash('The site social link has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The site social link could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
			$this->request->data = $this->SiteSetting->find('first', $options);
		}
	}
	
	public function admin_sitelogo($id = null) {
	        $title_for_layout = 'Manage Logo';
	        $this->set(compact('title_for_layout'));
	        $userid = $this->Session->read('Auth.User.id');
                if(!isset($userid) && $userid=='')
                {
	           $this->redirect('/admin');
                }
		if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if(isset($this->request->data['SiteSetting']['site_logo']) && $this->request->data['SiteSetting']['site_logo']['name']!=''){
			        $path = $this->request->data['SiteSetting']['site_logo']['name'];
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');
					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext,$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['SiteSetting']['site_logo']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['SiteSetting']['site_logo']['tmp_name'],$full_image_path);
						$this->request->data['SiteSetting']['site_logo'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type.'));
						return $this->redirect(array('action' => 'edit',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['SiteSetting']['site_logo'] = $this->request->data['SiteSetting']['hidsite_logo'];
			 }
			 
			 if(isset($this->request->data['SiteSetting']['banner_image']) && $this->request->data['SiteSetting']['banner_image']['name']!=''){
			        $path = $this->request->data['SiteSetting']['banner_image']['name'];
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				if($ext){
					$uploadPath= 'banner_image';

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext,$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['SiteSetting']['banner_image']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['SiteSetting']['banner_image']['tmp_name'],$full_image_path);
						$this->request->data['SiteSetting']['banner_image'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Banner Image Type.'));
						return $this->redirect(array('action' => 'edit',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['SiteSetting']['banner_image'] = $this->request->data['SiteSetting']['hidbanner_image'];
			 }
			 
			if ($this->SiteSetting->save($this->request->data)) {
                                $this->Session->setFlash('The site logo and banner image has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The site logo and banner image could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
			$this->request->data = $this->SiteSetting->find('first', $options);
		}
	}



}
