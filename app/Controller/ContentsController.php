<?php
App::uses('AppController', 'Controller');
/**
 * Contents Controller
 *
 * @property Content $Content
 * @property PaginatorComponent $Paginator
 */
class ContentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Session');
	public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('index','view');
   }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($pagename = null) {
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		$options = array('conditions' => array('page_name'  => $pagename));
		if (!$this->Content->find('first', $options)) {
			throw new NotFoundException(__('Invalid content'));
		}
		$this->set('content', $this->Content->find('first', $options));

		$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Content->create();
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The content has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'));
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
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The content has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
			$this->request->data = $this->Content->find('first', $options);
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
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Invalid content'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Content->delete()) {
			$this->Session->setFlash(__('The content has been deleted.'));
		} else {
			$this->Session->setFlash(__('The content could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

  public function admin_index() {		

		$title_for_layout = 'Content List';
        $this->paginate = array(
			'order' => array(
				'Content.id' => 'desc'
			)
		);
		$this->Content->recursive = 0;
        $this->Paginator->settings = $this->paginate;
		$this->set('contents', $this->Paginator->paginate());

		$this->set(compact('title_for_layout'));

	}

	public function admin_view($id = null) {			
		$title_for_layout = 'Content View';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid Content'));
		}
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$content = $this->Content->find('first', $options);		
		$this->set(compact('title_for_layout','content'));
	}
   
	public function admin_edit($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
			$this->request->data = $this->Content->find('first', $options);
		}

	}

   public function admin_home_page_content($id = null) {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }
	 if ($this->request->is(array('post', 'put'))) {
			if(isset($this->request->data['Content']['banner_image']) && $this->request->data['Content']['banner_image']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['banner_image']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['banner_image']['name']))));

						$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['banner_image']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['banner_image']['tmp_name'],$full_image_path);

						$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 75);

					    unlink($full_image_path);

						$this->request->data['Content']['banner_image'] = $newimageName;
						 
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_page_content',$id));
					}
				 }
			  }
			 else {
			   $this->request->data['Content']['banner_image'] = $this->request->data['Content']['hidsite_banner'];
			}
             
             $stsetting['SiteSetting']['id']=$id;
			 $stsetting['SiteSetting']['banner_image']=$this->request->data['Content']['banner_image'];
			 $stsetting['SiteSetting']['banner_text']=$this->request->data['Content']['banner_text'];
             $stsetting['SiteSetting']['banner_bottom_text']=$this->request->data['Content']['banner_bottom_text'];
            
			if ($this->SiteSetting->save($stsetting)) {
                $this->Session->setFlash('The home page data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The home page data could not be saved. Please, try again.'));
			}
	 }
	
	   $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	   $sitesetting = $this->SiteSetting->find('first', $options);
       $this->set(compact('sitesetting'));
	 
   }

    public function admin_account_edit($id = null) {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }
	 if ($this->request->is(array('post', 'put'))) {
             $stsetting['SiteSetting']['id']=$id;
			 $stsetting['SiteSetting']['account_header_text']=$this->request->data['Content']['account_header_text'];
			 $stsetting['SiteSetting']['account_footer_text']=$this->request->data['Content']['account_footer_text'];
            
			if ($this->SiteSetting->save($stsetting)) {
                $this->Session->setFlash('The account data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The account data could not be saved. Please, try again.'));
			}
	    }
	   $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	   $sitesetting = $this->SiteSetting->find('first', $options);
       $this->set(compact('sitesetting'));
  }

  public function admin_home_maker_counter($id = null)
  {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }
	 if ($this->request->is(array('post', 'put'))) {
			if(isset($this->request->data['Content']['maker_image']) && $this->request->data['Content']['maker_image']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['maker_image']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['maker_image']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['maker_image']['tmp_name'],$full_image_path);
						$this->request->data['Content']['maker_image'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_maker_counter',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['maker_image'] = $this->request->data['Content']['hidmaker_image'];
			}

          $stsetting['SiteSetting']['id']=$id;
		  $stsetting['SiteSetting']['maker_image']=$this->request->data['Content']['maker_image'];
		  $stsetting['SiteSetting']['maker_count']=$this->request->data['Content']['maker_count'];
		  $stsetting['SiteSetting']['maker_text']=$this->request->data['Content']['maker_text'];
           
		   if ($this->SiteSetting->save($stsetting)) {
                $this->Session->setFlash('The count data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The count data could not be saved. Please, try again.'));
			}
	 }
	
	 $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	 $sitesetting = $this->SiteSetting->find('first', $options);
     $this->set(compact('sitesetting'));
  }

  public function admin_home_photo_grid($id = null) {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }
	  if ($this->request->is(array('post', 'put'))) {
			if(isset($this->request->data['Content']['photo_grid1']) && $this->request->data['Content']['photo_grid1']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid1']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid1']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid1']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid1'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid1'] = $this->request->data['Content']['hidphoto_grid1'];
			}
			if(isset($this->request->data['Content']['photo_grid2']) && $this->request->data['Content']['photo_grid2']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid2']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid2']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid2']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid2'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid2'] = $this->request->data['Content']['hidphoto_grid2'];
			}
			if(isset($this->request->data['Content']['photo_grid3']) && $this->request->data['Content']['photo_grid3']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid3']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid3']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid3']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid3'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid3'] = $this->request->data['Content']['hidphoto_grid3'];
			}
			if(isset($this->request->data['Content']['photo_grid4']) && $this->request->data['Content']['photo_grid4']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid4']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid4']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid4']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid4'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid4'] = $this->request->data['Content']['hidphoto_grid4'];
			}
			if(isset($this->request->data['Content']['photo_grid5']) && $this->request->data['Content']['photo_grid5']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid5']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid5']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid5']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid5'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid5'] = $this->request->data['Content']['hidphoto_grid5'];
			}
			if(isset($this->request->data['Content']['photo_grid6']) && $this->request->data['Content']['photo_grid6']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid6']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid6']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid6']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid6'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid6'] = $this->request->data['Content']['hidphoto_grid6'];
			}
			if(isset($this->request->data['Content']['photo_grid7']) && $this->request->data['Content']['photo_grid7']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['photo_grid7']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['photo_grid7']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['photo_grid7']['tmp_name'],$full_image_path);
						$this->request->data['Content']['photo_grid7'] = $imageName;
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_photo_grid',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['photo_grid7'] = $this->request->data['Content']['hidphoto_grid7'];
			}

              $stsetting['SiteSetting']['id']=$id;
			  $stsetting['SiteSetting']['photo_grid1']=$this->request->data['Content']['photo_grid1'];
			  $stsetting['SiteSetting']['photo_grid2']=$this->request->data['Content']['photo_grid2'];
			  $stsetting['SiteSetting']['photo_grid3']=$this->request->data['Content']['photo_grid3'];
			  $stsetting['SiteSetting']['photo_grid4']=$this->request->data['Content']['photo_grid4'];
			  $stsetting['SiteSetting']['photo_grid5']=$this->request->data['Content']['photo_grid5'];
			  $stsetting['SiteSetting']['photo_grid6']=$this->request->data['Content']['photo_grid6'];
			  $stsetting['SiteSetting']['photo_grid7']=$this->request->data['Content']['photo_grid7'];

			  $stsetting['SiteSetting']['photo_grid_link1']=$this->request->data['Content']['photo_grid_link1'];
			  $stsetting['SiteSetting']['photo_grid_link2']=$this->request->data['Content']['photo_grid_link2'];
			  $stsetting['SiteSetting']['photo_grid_link3']=$this->request->data['Content']['photo_grid_link3'];
			  $stsetting['SiteSetting']['photo_grid_link4']=$this->request->data['Content']['photo_grid_link4'];
			  $stsetting['SiteSetting']['photo_grid_link5']=$this->request->data['Content']['photo_grid_link5'];
			  $stsetting['SiteSetting']['photo_grid_link6']=$this->request->data['Content']['photo_grid_link6'];
			  $stsetting['SiteSetting']['photo_grid_link7']=$this->request->data['Content']['photo_grid_link7'];
            
			if ($this->SiteSetting->save($stsetting)) {
                $this->Session->setFlash('The Grid data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The Grid data could not be saved. Please, try again.'));
			}
	 }
	
	 $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	 $sitesetting = $this->SiteSetting->find('first', $options);
     $this->set(compact('sitesetting'));
  }

   public function admin_how_it_works($id = null) {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }

	 if ($this->request->is(array('post', 'put'))) {

			if(isset($this->request->data['Content']['how_it_works_image1']) && $this->request->data['Content']['how_it_works_image1']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['how_it_works_image1']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['how_it_works_image1']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['how_it_works_image1']['tmp_name'],$full_image_path);
						$this->request->data['Content']['how_it_works_image1'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_how_it_works',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['how_it_works_image1'] = $this->request->data['Content']['hidhow_it_works_image1'];
			}
			if(isset($this->request->data['Content']['how_it_works_image2']) && $this->request->data['Content']['how_it_works_image2']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['how_it_works_image2']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['how_it_works_image2']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['how_it_works_image2']['tmp_name'],$full_image_path);
						$this->request->data['Content']['how_it_works_image2'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_how_it_works',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['how_it_works_image2'] = $this->request->data['Content']['hidhow_it_works_image2'];
			}
			if(isset($this->request->data['Content']['how_it_works_image3']) && $this->request->data['Content']['how_it_works_image3']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['how_it_works_image3']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['how_it_works_image3']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['how_it_works_image3']['tmp_name'],$full_image_path);
						$this->request->data['Content']['how_it_works_image3'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_how_it_works',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['how_it_works_image3'] = $this->request->data['Content']['hidhow_it_works_image3'];
			}
			if(isset($this->request->data['Content']['how_it_works_image4']) && $this->request->data['Content']['how_it_works_image4']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['how_it_works_image4']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['how_it_works_image4']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['how_it_works_image4']['tmp_name'],$full_image_path);
						$this->request->data['Content']['how_it_works_image4'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_how_it_works',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['how_it_works_image4'] = $this->request->data['Content']['hidhow_it_works_image4'];
			}

              $stsetting['SiteSetting']['id']=$id;
			  $stsetting['SiteSetting']['how_it_works_image1']=$this->request->data['Content']['how_it_works_image1'];
			  $stsetting['SiteSetting']['how_it_works_image2']=$this->request->data['Content']['how_it_works_image2'];
			  $stsetting['SiteSetting']['how_it_works_image3']=$this->request->data['Content']['how_it_works_image3'];
			  $stsetting['SiteSetting']['how_it_works_image4']=$this->request->data['Content']['how_it_works_image4'];

			  $stsetting['SiteSetting']['how_it_works_text1']=$this->request->data['Content']['how_it_works_text1'];
			  $stsetting['SiteSetting']['how_it_works_text2']=$this->request->data['Content']['how_it_works_text2'];
			  $stsetting['SiteSetting']['how_it_works_text3']=$this->request->data['Content']['how_it_works_text3'];
			  $stsetting['SiteSetting']['how_it_works_text4']=$this->request->data['Content']['how_it_works_text4'];
            
			if ($this->SiteSetting->save($stsetting)) {
                $this->Session->setFlash('The How It Works data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The How It Works data could not be saved. Please, try again.'));
			}
	 }
	
	 $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	 $sitesetting = $this->SiteSetting->find('first', $options);
     $this->set(compact('sitesetting'));
   }

   public function admin_home_middle($id = null) {
	 $this->loadModel('SiteSetting');
	 if (!$this->SiteSetting->exists($id)) {
		  throw new NotFoundException(__('Invalid Content'));
	 }
	 if ($this->request->is(array('post', 'put'))) {

			if(isset($this->request->data['Content']['home_middle_image1']) && $this->request->data['Content']['home_middle_image1']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['home_middle_image1']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image1']['name']))));
						
						//$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image1']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						move_uploaded_file($this->request->data['Content']['home_middle_image1']['tmp_name'],$full_image_path);
						
						//$full_image_path_new = $uploadPath . '/' . $newimageName;

						/*$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 100);

					    unlink($full_image_path);*/

						$this->request->data['Content']['home_middle_image1'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_middle',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['home_middle_image1'] = $this->request->data['Content']['hidhome_middle_image1'];
			}

			if(isset($this->request->data['Content']['home_middle_image2']) && $this->request->data['Content']['home_middle_image2']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['home_middle_image2']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image2']['name']))));
						
						//$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image2']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						//$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['home_middle_image2']['tmp_name'],$full_image_path);

						/*$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 100);

					    unlink($full_image_path);*/

						$this->request->data['Content']['home_middle_image2'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_middle',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['home_middle_image2'] = $this->request->data['Content']['hidhome_middle_image2'];
			}

			if(isset($this->request->data['Content']['home_middle_image3']) && $this->request->data['Content']['home_middle_image3']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['home_middle_image3']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image3']['name']))));
						
						//$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['home_middle_image3']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						//$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['home_middle_image3']['tmp_name'],$full_image_path);

						/*$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 100);

					    unlink($full_image_path);*/

						$this->request->data['Content']['home_middle_image3'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_home_middle',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['home_middle_image3'] = $this->request->data['Content']['hidhome_middle_image3'];
			}
			
                          $stsetting['SiteSetting']['id']=$id;
			  $stsetting['SiteSetting']['home_middle_image1']=$this->request->data['Content']['home_middle_image1'];
			  $stsetting['SiteSetting']['home_middle_image2']=$this->request->data['Content']['home_middle_image2'];
			  $stsetting['SiteSetting']['home_middle_image3']=$this->request->data['Content']['home_middle_image3'];
			
			  $stsetting['SiteSetting']['home_middle_header1']=$this->request->data['Content']['home_middle_header1'];
			  $stsetting['SiteSetting']['home_middle_header2']=$this->request->data['Content']['home_middle_header2'];
			  $stsetting['SiteSetting']['home_middle_header3']=$this->request->data['Content']['home_middle_header3'];

			  $stsetting['SiteSetting']['home_middle_desc1']=$this->request->data['Content']['home_middle_desc1'];
			  $stsetting['SiteSetting']['home_middle_desc2']=$this->request->data['Content']['home_middle_desc2'];
			  $stsetting['SiteSetting']['home_middle_desc3']=$this->request->data['Content']['home_middle_desc3'];
			 
			if ($this->SiteSetting->save($stsetting)) {
                        $this->Session->setFlash('The Home data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The Home data could not be saved. Please, try again.'));
			}
	 }
     $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	 $sitesetting = $this->SiteSetting->find('first', $options);
     $this->set(compact('sitesetting'));
   }
   
   public function admin_footer_edit($id = null)
   {
	   $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
				$this->redirect('/admin');
		}
		$this->loadModel('SiteSetting');
		if (!$this->SiteSetting->exists($id)) {
				 throw new NotFoundException(__('Invalid Content'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if(isset($this->request->data['Content']['footer_image']) && $this->request->data['Content']['footer_image']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['footer_image']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['footer_image']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['footer_image']['tmp_name'],$full_image_path);
						$this->request->data['Content']['footer_image'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_footer_edit',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['footer_image'] = $this->request->data['Content']['hidfooter_image'];
			}
           
		    $stsetting['SiteSetting']['id']=$id;
			$stsetting['SiteSetting']['footer_image']=$this->request->data['Content']['footer_image'];
			$stsetting['SiteSetting']['footer_head']=$this->request->data['Content']['footer_head'];
			$stsetting['SiteSetting']['footer_button_text']=$this->request->data['Content']['footer_button_text'];
			$stsetting['SiteSetting']['footer_text']=$this->request->data['Content']['footer_text'];
            
			if ($this->SiteSetting->save($stsetting)) {
                        $this->Session->setFlash('The Footer data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The Home data could not be saved. Please, try again.'));
			}

		}

	   $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	   $sitesetting = $this->SiteSetting->find('first', $options);
       $this->set(compact('sitesetting'));
   }

   public function admin_want_to_learn($id = null)
   {
	   $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
				$this->redirect('/admin');
		}
		$this->loadModel('SiteSetting');
		if (!$this->SiteSetting->exists($id)) {
				 throw new NotFoundException(__('Invalid Content'));
		}
        if ($this->request->is(array('post', 'put'))) {

			if(isset($this->request->data['Content']['learn_image1']) && $this->request->data['Content']['learn_image1']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_image1']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image1']['name']))));
						
						$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image1']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['learn_image1']['tmp_name'],$full_image_path);

						$info = getimagesize($full_image_path);
						
						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 75);

					    unlink($full_image_path);

						$this->request->data['Content']['learn_image1'] = $newimageName;
						 
					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_image1'] = $this->request->data['Content']['hidlearn_image1'];
			}

			if(isset($this->request->data['Content']['learn_image2']) && $this->request->data['Content']['learn_image2']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_image2']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image2']['name']))));
						
						$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image2']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['learn_image2']['tmp_name'],$full_image_path);

						$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 75);

					    unlink($full_image_path);

						$this->request->data['Content']['learn_image2'] = $newimageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_image2'] = $this->request->data['Content']['hidlearn_image2'];
			}

			if(isset($this->request->data['Content']['learn_image3']) && $this->request->data['Content']['learn_image3']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_image3']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image3']['name']))));
						
						$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image3']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['learn_image3']['tmp_name'],$full_image_path);

						$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 75);

					    unlink($full_image_path);

						$this->request->data['Content']['learn_image3'] = $newimageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_image3'] = $this->request->data['Content']['hidlearn_image3'];
			}

			if(isset($this->request->data['Content']['learn_image4']) && $this->request->data['Content']['learn_image4']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_image4']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){

						$imageName = rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image4']['name']))));
						
						$newimageName = time().'_'.rand().'_'.(strtolower(trim(preg_replace('/\s+/', '_', $this->request->data['Content']['learn_image4']['name']))));

						$full_image_path = $uploadPath . '/' . $imageName;

						$full_image_path_new = $uploadPath . '/' . $newimageName;

						move_uploaded_file($this->request->data['Content']['learn_image4']['tmp_name'],$full_image_path);

						$info = getimagesize($full_image_path);

						if ($info['mime'] == 'image/jpeg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}
						elseif ($info['mime'] == 'image/gif')
						{
						  $imagen = imagecreatefromgif($full_image_path);
						}
						elseif ($info['mime'] == 'image/png')
						{
						  $imagen = imagecreatefrompng($full_image_path);
						}
						elseif ($info['mime'] == 'image/jpg')
						{
						  $imagen = imagecreatefromjpeg($full_image_path);
						}

						imagejpeg($imagen, $full_image_path_new, 75);

					    unlink($full_image_path);

						$this->request->data['Content']['learn_image4'] = $newimageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_image4'] = $this->request->data['Content']['hidlearn_image4'];
			}

            if(isset($this->request->data['Content']['learn_hover1']) && $this->request->data['Content']['learn_hover1']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_hover1']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['learn_hover1']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['learn_hover1']['tmp_name'],$full_image_path);
						$this->request->data['Content']['learn_hover1'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_hover1'] = $this->request->data['Content']['hidlearn_hover1'];
			}

			if(isset($this->request->data['Content']['learn_hover2']) && $this->request->data['Content']['learn_hover2']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_hover2']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['learn_hover2']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['learn_hover2']['tmp_name'],$full_image_path);
						$this->request->data['Content']['learn_hover2'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_hover2'] = $this->request->data['Content']['hidlearn_hover2'];
			}

			if(isset($this->request->data['Content']['learn_hover3']) && $this->request->data['Content']['learn_hover3']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_hover3']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['learn_hover3']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['learn_hover3']['tmp_name'],$full_image_path);
						$this->request->data['Content']['learn_hover3'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_hover3'] = $this->request->data['Content']['hidlearn_hover3'];
			}

			if(isset($this->request->data['Content']['learn_hover4']) && $this->request->data['Content']['learn_hover4']['name']!=''){
			  $ext = explode('/',$this->request->data['Content']['learn_hover4']['type']);
				if($ext){
					$uploadPath= Configure::read('UPLOAD_USER_LOGO_PATH');

					$extensionValid = array('jpg','jpeg','png','gif');
					if(in_array($ext[1],$extensionValid)){
						$imageName = rand().'_'.(strtolower(trim($this->request->data['Content']['learn_hover4']['name'])));
						$full_image_path = $uploadPath . '/' . $imageName;
						move_uploaded_file($this->request->data['Content']['learn_hover4']['tmp_name'],$full_image_path);
						$this->request->data['Content']['learn_hover4'] = $imageName;
						 

					} else{
						$this->Session->setFlash(__('Invalid Image Type'));
						return $this->redirect(array('action' => 'admin_want_to_learn',$id));
					 }
				 }
			  }
			 else {
			   $this->request->data['Content']['learn_hover4'] = $this->request->data['Content']['hidlearn_hover4'];
			}

            $stsetting['SiteSetting']['id']=$id;

			$stsetting['SiteSetting']['learn_image1']=$this->request->data['Content']['learn_image1'];
			$stsetting['SiteSetting']['learn_image2']=$this->request->data['Content']['learn_image2'];
			$stsetting['SiteSetting']['learn_image3']=$this->request->data['Content']['learn_image3'];
			$stsetting['SiteSetting']['learn_image4']=$this->request->data['Content']['learn_image4'];

			$stsetting['SiteSetting']['learn_hover1']=$this->request->data['Content']['learn_hover1'];
			$stsetting['SiteSetting']['learn_hover2']=$this->request->data['Content']['learn_hover2'];
			$stsetting['SiteSetting']['learn_hover3']=$this->request->data['Content']['learn_hover3'];
			$stsetting['SiteSetting']['learn_hover4']=$this->request->data['Content']['learn_hover4'];
			
			$stsetting['SiteSetting']['learn_text1']=$this->request->data['Content']['learn_text1'];
			$stsetting['SiteSetting']['learn_text2']=$this->request->data['Content']['learn_text2'];
			$stsetting['SiteSetting']['learn_text3']=$this->request->data['Content']['learn_text3'];
			$stsetting['SiteSetting']['learn_text4']=$this->request->data['Content']['learn_text4'];
			 
			if ($this->SiteSetting->save($stsetting)) {
                        $this->Session->setFlash('The Home data has been saved.', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('The Home data could not be saved. Please, try again.'));
			}
	 }
     $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
	 $sitesetting = $this->SiteSetting->find('first', $options);
     $this->set(compact('sitesetting'));

   }

   public function admin_skillavailability($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                    $this->request->data['SiteSetting']['skill_speciality_heading']=$this->request->data['Content']['skill_speciality_heading'];
                    $this->request->data['SiteSetting']['skill_speciality_description']=$this->request->data['Content']['skill_speciality_description'];
                    $this->request->data['SiteSetting']['skill_speciality_field1']=$this->request->data['Content']['skill_speciality_field1'];
                    $this->request->data['SiteSetting']['skill_speciality_field2']=$this->request->data['Content']['skill_speciality_field2'];
                    $this->request->data['SiteSetting']['skill_speciality_field3']=$this->request->data['Content']['skill_speciality_field3'];
                    $this->request->data['SiteSetting']['skill_speciality_field4']=$this->request->data['Content']['skill_speciality_field4'];
                    $this->request->data['SiteSetting']['skill_speciality_field5']=$this->request->data['Content']['skill_speciality_field5'];
                    $this->request->data['SiteSetting']['skill_speciality_field6']=$this->request->data['Content']['skill_speciality_field6'];
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
    
    public function admin_skillstudio($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                    $this->request->data['SiteSetting']['skill_studio_heading']=$this->request->data['Content']['skill_studio_heading'];
                    $this->request->data['SiteSetting']['skill_studio_description']=$this->request->data['Content']['skill_studio_description'];
                    $this->request->data['SiteSetting']['skill_studio_field1']=$this->request->data['Content']['skill_studio_field1'];
                    $this->request->data['SiteSetting']['skill_studio_field2']=$this->request->data['Content']['skill_studio_field2'];
                    $this->request->data['SiteSetting']['skill_studio_field3']=$this->request->data['Content']['skill_studio_field3'];
                    $this->request->data['SiteSetting']['skill_studio_field4']=$this->request->data['Content']['skill_studio_field4'];
                    $this->request->data['SiteSetting']['skill_studio_field5']=$this->request->data['Content']['skill_studio_field5'];
                    $this->request->data['SiteSetting']['skill_studio_field6']=$this->request->data['Content']['skill_studio_field6'];
                    $this->request->data['SiteSetting']['skill_studio_field7']=$this->request->data['Content']['skill_studio_field7'];
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
	
	 public function admin_skillcost($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                    $this->request->data['SiteSetting']['skill_cost_heading']=$this->request->data['Content']['skill_cost_heading'];
                    $this->request->data['SiteSetting']['skill_cost_description']=$this->request->data['Content']['skill_cost_description'];
                    $this->request->data['SiteSetting']['skill_cost_field1']=$this->request->data['Content']['skill_cost_field1'];
                    $this->request->data['SiteSetting']['skill_cost_field2']=$this->request->data['Content']['skill_cost_field2'];
                    $this->request->data['SiteSetting']['skill_cost_field3']=$this->request->data['Content']['skill_cost_field3'];
                    $this->request->data['SiteSetting']['skill_cost_field4']=$this->request->data['Content']['skill_cost_field4'];
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
	
	public function admin_skillavailable($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                    $this->request->data['SiteSetting']['skill_availability_heading']=$this->request->data['Content']['skill_availability_heading'];
                    $this->request->data['SiteSetting']['skill_availability_description']=$this->request->data['Content']['skill_availability_description'];
                    $this->request->data['SiteSetting']['skill_availability_field1']=$this->request->data['Content']['skill_availability_field1'];
                    $this->request->data['SiteSetting']['skill_availability_field2']=$this->request->data['Content']['skill_availability_field2'];
                    $this->request->data['SiteSetting']['skill_availability_field3']=$this->request->data['Content']['skill_availability_field3'];
                    $this->request->data['SiteSetting']['skill_availability_field4']=$this->request->data['Content']['skill_availability_field4'];
					$this->request->data['SiteSetting']['skill_availability_field5']=$this->request->data['Content']['skill_availability_field5'];
					$this->request->data['SiteSetting']['skill_availability_field6']=$this->request->data['Content']['skill_availability_field6'];
					$this->request->data['SiteSetting']['skill_availability_field7']=$this->request->data['Content']['skill_availability_field7'];
					$this->request->data['SiteSetting']['skill_availability_field8']=$this->request->data['Content']['skill_availability_field8'];
					$this->request->data['SiteSetting']['skill_availability_field9']='';
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
	
	public function admin_skillfinal($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                   
                    $this->request->data['SiteSetting']['skill_final_description']=$this->request->data['Content']['skill_final_description'];
					$this->request->data['SiteSetting']['skill_final_payout']=$this->request->data['Content']['skill_final_payout'];
                   
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
    
    public function admin_skillteaser($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;
                   
                    $this->request->data['SiteSetting']['teaser_heading']=$this->request->data['Content']['teaser_heading'];
		    $this->request->data['SiteSetting']['teaser_description']=$this->request->data['Content']['teaser_description'];
                   
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }
    
    public function admin_skillinitiation($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid=='')
            {
                    $this->redirect('/admin');
            }
            $this->loadModel('SiteSetting');
            if (!$this->SiteSetting->exists($id)) {
                     throw new NotFoundException(__('Invalid Content'));
            }
            if ($this->request->is(array('post', 'put'))) {
                    #pr($this->request->data);
                    #exit;
                    $this->request->data['SiteSetting']['id']=$id;                   
                    $this->request->data['SiteSetting']['initiation_heading']=$this->request->data['Content']['initiation_heading'];
		    $this->request->data['SiteSetting']['initiation_field1']=$this->request->data['Content']['initiation_field1'];
		    $this->request->data['SiteSetting']['initiation_field2']=$this->request->data['Content']['initiation_field2'];
                   
                    if ($this->SiteSetting->save($this->request->data)) {
                            $this->Session->setFlash('The content has been saved.', 'default', array('class' => 'success'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
                    }
            } else {
                    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => $id));
                    $this->request->data = $this->SiteSetting->find('first', $options);
            }

    }

}
