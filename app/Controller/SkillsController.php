<?php
App::uses('AppController', 'Controller');
/**
 * Skills Controller
 *
 * @property Skill $Skill
 * @property PaginatorComponent $Paginator
 */
class SkillsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('details','sliderframe','sliderframe2');
   }

/**
 * index method
 *
 * @return void
 */

   
	public function index() {
		$this->Skill->recursive = 0;
		$this->set('skills', $this->Paginator->paginate());
	}

	public function admin_index() {
		$this->paginate = array(
		'limit' =>25,
		'order' => array(
				'Skill.id' => 'desc'
		 ), 
		);
		$this->Paginator->settings = $this->paginate;

		$this->Skill->recursive = 0;
		$this->set('skills', $this->Paginator->paginate());
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
	public function add() {
		if ($this->request->is('post')) {
			$this->Skill->create();
			if ($this->Skill->save($this->request->data)) {
				$this->Session->setFlash(__('The skill has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill could not be saved. Please, try again.'));
			}
		}
		$users = $this->Skill->User->find('list');
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
		if (!$this->Skill->exists($id)) {
			throw new NotFoundException(__('Invalid skill'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Skill->save($this->request->data)) {
				$this->Session->setFlash(__('The skill has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Skill.' . $this->Skill->primaryKey => $id));
			$this->request->data = $this->Skill->find('first', $options);
		}
		$users = $this->Skill->User->find('list');
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
		$this->Skill->id = $id;
		if (!$this->Skill->exists()) {
			throw new NotFoundException(__('Invalid skill'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Skill->delete()) {
			$this->Session->setFlash(__('The skill has been deleted.'));
		} else {
			$this->Session->setFlash(__('The skill could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

 public function admin_deactivate($skill_id=null)
 {
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$skill['Skill']['id']=$skill_id;
	$skill['Skill']['is_active']=0;
	if ($this->Skill->save($skill))
	{
		$this->Session->setFlash('Offer has been deactivated', 'default', array('class' => 'success'));
		return $this->redirect(array('action' => 'admin_index'));
	}
	else
	{
        $this->Session->setFlash('Offer could not be deactivated');
		return $this->redirect(array('action' => 'admin_index'));
	}
  }
 public function admin_activate($skill_id=null)
 {
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
    $key = Configure::read('CONTACT_EMAIL');

	$option_skill = array('conditions' => array('Skill.id' => $skill_id));
	$selectedskill=$this->Skill->find('first', $option_skill);

	$skill['Skill']['id']=$skill_id;
	$skill['Skill']['is_active']=1;
	if ($this->Skill->save($skill))
	{
	   if($selectedskill['User']['is_profile_complete']==0)
	   {
         $msg='Please login to your account and fill your payout info to let people pay.';
	   }
	   else
		{
          $msg='Please login to your account to see details.';
		}
	   
	   $this->loadModel('EmailTemplate');
	   $EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>8)));

	   $mail_body=str_replace(array('[orderid]','[ordername]','[date]','[message]'),array($skill_id,$selectedskill['Skill']['skill_name'],$selectedskill['Skill']['post_date'],$msg),$EmailTemplate['EmailTemplate']['content']);

	   $this->send_mail($key,$selectedskill['User']['email'],$EmailTemplate['EmailTemplate']['subject'],$mail_body);
		
		$this->Session->setFlash('Offer has been activated', 'default', array('class' => 'success'));
		return $this->redirect(array('action' => 'admin_index'));
	}
	else
	{
        $this->Session->setFlash('Offer could not be activated');
		return $this->redirect(array('action' => 'admin_index'));
	}
  }
 /*public function step1()
 {
	$title_for_layout = 'Your Speciality';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
    $this->loadModel('User');
	if ($this->request->is(array('post'))) 
	{
		#pr($this->request->data);
		#exit;
		$skill['Skill']['user_id']=$userid;
		$skill['Skill']['category_id']=$this->request->data['Skill']['category_id'];
		$skill['Skill']['skill_details']=$this->request->data['Skill']['skill_details'];
		$skill['Skill']['skill_video_url']=$this->request->data['Skill']['skill_video_url'];
		if(isset($this->request->data['Skill']['banner']) && $this->request->data['Skill']['banner']['name']!=''){
			$ext = explode('.',$this->request->data['Skill']['banner']['name']);
			if($ext){
				$uploadFolder = "skill_images";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$extensionValid = array('jpg','jpeg','png','gif');
				if(in_array($ext[1],$extensionValid)){
					$imageName = '_'.(strtolower(trim($this->request->data['Skill']['banner']['name'])));
					$full_image_path = $uploadPath . '/' . $imageName;
					move_uploaded_file($this->request->data['Skill']['banner']['tmp_name'],$full_image_path);
					$skill['Skill']['banner'] = $imageName;
				}
			}
		}
		if(isset($this->request->data['List']['tag']) && !empty($this->request->data['List']['tag']))
		{
			$skill['Skill']['sub_category']='';
			foreach($this->request->data['List']['tag'] as $k=>$v)
			{
			  $skill['Skill']['sub_category'] .= $v.',';
			}
		}
        $skill['Skill']['sub_category']=trim($skill['Skill']['sub_category'],',');

		$this->Skill->create();
		if ($this->Skill->save($skill))
		{
			$skillid=$this->Skill->getLastInsertId();
			$this->loadModel('SkillImage');
			$uploadFolder = "skill_images";
            $uploadPath = WWW_ROOT . $uploadFolder;
            if(isset($this->request->data['List']['pic']) && !empty($this->request->data['List']['pic']))
		    {
			  $skillimages['SkillImage']['image']='';
			  foreach($this->request->data['List']['pic'] as $k=>$v)
			  {
			    $imageName = rand().'_'.(strtolower(trim($_FILES['photos']['name'][$k-1])));
			    $full_image_path = $uploadPath . '/' . $imageName;
			    move_uploaded_file($_FILES['photos']['tmp_name'][$k-1],$full_image_path);
			    $skillimages['SkillImage']['image'] .= $imageName.',';
			  }
			  foreach($this->request->data['List']['description'] as $k=>$v)
			  {
				$skillimages['SkillImage']['description'] .= $v.',';
			  }
			}
			$skillimages['SkillImage']['image']=trim($skillimages['SkillImage']['image'],',');
			$skillimages['SkillImage']['skill_id']=$skillid;
			$skillimages['SkillImage']['description'] = trim($skillimages['SkillImage']['description'],',');
			$this->SkillImage->create();
			if ($this->SkillImage->save($skillimages))
		    {
				$this->Session->setFlash('Speciality added successfully', 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'step2',$skillid));
			}
		}
	}
	
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
       
	$this->loadModel('Category');
	$options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
	$categories = $this->Category->find('all', $options);
    $this->set(compact('title_for_layout','categories'));
  }

 public function edit_step1($skill_id=null)
 {
	$title_for_layout = 'Your Speciality';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	if (!$this->Skill->exists($skill_id)) 
	{
		throw new NotFoundException(__('Invalid skill'));
	}

    $this->loadModel('User');
	$this->loadModel('SkillImage');

	$options = array('conditions' => array('SkillImage.skill_id' => $skill_id));
	$skillimg = $this->SkillImage->find('first', $options);
	$skillimages=explode(',',$skillimg['SkillImage']['image']);

	if ($this->request->is(array('post'))) 
	{
		$skill['Skill']['id']=$skill_id;
		$skill['Skill']['user_id']=$userid;
		$skill['Skill']['category_id']=$this->request->data['Skill']['category_id'];
		$skill['Skill']['skill_details']=$this->request->data['Skill']['skill_details'];
		$skill['Skill']['skill_video_url']=$this->request->data['Skill']['skill_video_url'];

		if(isset($this->request->data['List']['tag']) && !empty($this->request->data['List']['tag']))
		{
			$skill['Skill']['sub_category']='';
			foreach($this->request->data['List']['tag'] as $k=>$v)
			{
			  $skill['Skill']['sub_category'] .= $v.',';
			}
		}
        $skill['Skill']['sub_category']=trim($skill['Skill']['sub_category'],',');

		if ($this->Skill->save($skill))
		{
			
			$uploadFolder = "skill_images";
            $uploadPath = WWW_ROOT . $uploadFolder;
			$skillimagesedit['SkillImage']['image']='';
			if(isset($this->request->data['List']['picedit']) && !empty($this->request->data['List']['picedit']))
		    {
              foreach($this->request->data['List']['picedit'] as $k=>$v)
			  {
                 $skillimagesedit['SkillImage']['image'] .= $v.',';
			  }
			}
			$skillimagescount=count($skillimages);
			$already_exists=($skillimagescount+1);

            if(isset($this->request->data['List']['pic']) && !empty($this->request->data['List']['pic']))
		    {
			  foreach($this->request->data['List']['pic'] as $k=>$v)
			  {
			    $imageName = rand().'_'.(strtolower(trim($_FILES['photos']['name'][$k-$already_exists])));
			    $full_image_path = $uploadPath . '/' . $imageName;
			    move_uploaded_file($_FILES['photos']['tmp_name'][$k-$already_exists],$full_image_path);
			    $skillimagesedit['SkillImage']['image'] .= $imageName.',';
			  }
			}
			$skillimagesedit['SkillImage']['image']=trim($skillimagesedit['SkillImage']['image'],',');
			$skillimagesedit['SkillImage']['id']=$skillimg['SkillImage']['id'];
			if ($this->SkillImage->save($skillimagesedit))
		    {
				$this->Session->setFlash('Speciality added successfully', 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'step2',$skill_id));
			}
		}
	}

	$options = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $options);
	$xtr=explode(',',$skill['Skill']['sub_category']);

	
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
       
	$this->loadModel('Category');
	$options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
	$categories = $this->Category->find('all', $options);
    $this->set(compact('title_for_layout','categories','skill','xtr','skill_id','skillimages'));
  }*/
 public function teaser()
 {
    $title_for_layout = 'Teaser';
    $userid = $this->Session->read('Auth.User.id');
    if(!isset($userid) && $userid=='')
    {
            $this->redirect('/');
    }
    $this->loadModel('User');
    $this->loadmodel('SiteSetting');
    $this->loadModel('Category');
    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
    
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));	

    $this->set(compact('title_for_layout'));
        $this->loadmodel('SiteSetting');
    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
    
    $this->loadModel('User');
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
    
    $options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
    $categories = $this->Category->find('all', $options);

    $this->set(compact('categories'));
  }
  
  public function initiation()
 {
    $title_for_layout = 'Initiation';
    $userid = $this->Session->read('Auth.User.id');
    if(!isset($userid) && $userid=='')
    {
            $this->redirect('/');
    }
    $this->loadModel('Category');
    if ($this->request->is(array('post'))) 
    {
        $skill['Skill']['user_id']=$userid;
        $skill['Skill']['category_id']=$this->request->data['Skill']['category_id'];
        $options = array('conditions' => array('Category.id'  => $this->request->data['Skill']['category_id']));
	$selcat = $this->Category->find('first', $options);
	$skill['Skill']['skill_name']=$selcat['Category']['name'];
        $skill['Skill']['about_specifically'] = $this->request->data['Skill']['about_specifically'];
        $skill['Skill']['post_date']=date('Y-m-d');
        $this->Skill->create();
	if ($this->Skill->save($skill))
	{
            $skillid=$this->Skill->getLastInsertId();
            $this->Session->setFlash('Skill initiated successfully', 'default', array('class' => 'success'));
            return $this->redirect(array('action' => 'edit_step1',$skillid));
        }
    }
    
    $this->loadmodel('SiteSetting');
    $options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
    
    $this->loadModel('User');
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
    
    $options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
    $categories = $this->Category->find('all', $options);

    $this->set(compact('title_for_layout','categories'));
  }


 public function step1()
 {
	$title_for_layout = 'Your Speciality';
        $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
        $this->loadModel('User');
	$this->loadModel('Category');
	$this->loadModel('SkillImage');
	if ($this->request->is(array('post'))) 
	{
		$skill['Skill']['user_id']=$userid;
		$skill['Skill']['category_id']=$this->request->data['Skill']['category_id'];
		$skill['Skill']['skill_details']=$this->request->data['Skill']['skill_details'];
		$skill['Skill']['skill_video_url']=$this->request->data['Skill']['skill_video_url'];
		$imageName ='';

		$options = array('conditions' => array('Category.id'  => $this->request->data['Skill']['category_id']));
	        $selcat = $this->Category->find('first', $options);
		$skill['Skill']['skill_name']=$selcat['Category']['name'];

		
		//$skill['Skill']['banner'] =$this->Session->read('MAINIMAGE');
		$skill['Skill']['banner']='';


		if(isset($this->request->data['List']['tag']) && !empty($this->request->data['List']['tag']))
		{
			$skill['Skill']['sub_category']='';
			foreach($this->request->data['List']['tag'] as $k=>$v)
			{
			  $skill['Skill']['sub_category'] .= $v.',';
			}
		}
                $skill['Skill']['sub_category']=trim($skill['Skill']['sub_category'],',');
                $skill['Skill']['post_date']=date('Y-m-d');
		$this->Skill->create();
		if ($this->Skill->save($skill))
		{
			$descriptn='';
			$skillid=$this->Skill->getLastInsertId();
			
            if(!empty($this->Session->read('SKILLIMG')))
		    {
			  $skillimages['SkillImage']['image']='';
			  foreach($this->Session->read('SKILLIMG') as $k=>$v)
			  {
			    $skillimages['SkillImage']['image'] .= $v.',';
			  }
				
			}

			if(!empty($this->request->data['List']['description']))
			{
				foreach($this->request->data['List']['description'] as $k=>$v)
				{
					if($v!='')
					{
						$descriptn.= $v.',';
					}
					else
					{
						$descriptn.= 'blankspace,';
					}
				}
			}

			$skillimages['SkillImage']['image']=trim($skillimages['SkillImage']['image'],',');
			$skillimages['SkillImage']['skill_id']=$skillid;
			$skillimages['SkillImage']['description'] = trim($descriptn,',');
			#pr($this->request->data);
			#exit;
			$this->SkillImage->create();
			if ($this->SkillImage->save($skillimages))
		    {
				 //$this->Session->delete('MAINIMAGE');
	             $this->Session->delete('SKILLIMG');
	             $this->Session->delete('CNTIMG');

				$this->Session->setFlash('Speciality added successfully', 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'step2',$skillid));
			}
		}
	}
	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
    
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
       
	$options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
	$categories = $this->Category->find('all', $options);

    $this->set(compact('title_for_layout','categories'));
  }

 public function edit_step1($skill_id=null)
 {

	$title_for_layout = 'Your Speciality';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	if (!$this->Skill->exists($skill_id)) 
	{
		throw new NotFoundException(__('Invalid skill'));
	}

        $this->loadModel('User');
	$this->loadModel('SkillImage');
	$this->loadModel('Category');

	$options = array('conditions' => array('SkillImage.skill_id' => $skill_id));
	$skillimg = $this->SkillImage->find('first', $options);
        if($skillimg){
            $skillimages=explode(',',$skillimg['SkillImage']['image']);
            $skilldesc=explode(',',$skillimg['SkillImage']['description']);
        }

	if ($this->request->is(array('post'))) 
	{
		#pr($this->request->data);
		#exit;
		$skill['Skill']['id']=$skill_id;
		$skill['Skill']['user_id']=$userid;
		$skill['Skill']['category_id']=$this->request->data['Skill']['category_id'];
		$skill['Skill']['skill_details']=$this->request->data['Skill']['skill_details'];
		$skill['Skill']['skill_video_url']=$this->request->data['Skill']['skill_video_url'];

		$options = array('conditions' => array('Category.id'  => $this->request->data['Skill']['category_id']));
	    $selcat = $this->Category->find('first', $options);

		$skill['Skill']['skill_name']=$selcat['Category']['name'];

		$imageName ='';

        /*$newssn_img=$this->Session->read('MAINIMAGE');
		if(isset($newssn_img) && $newssn_img!='')
		{
			$skill['Skill']['banner'] =$newssn_img;
		}*/

		
		if(isset($this->request->data['List']['tag']) && !empty($this->request->data['List']['tag']))
		{
			$skill['Skill']['sub_category']='';
			foreach($this->request->data['List']['tag'] as $k=>$v)
			{
			  $skill['Skill']['sub_category'] .= $v.',';
			}
		}
                $skill['Skill']['sub_category']=trim($skill['Skill']['sub_category'],',');

		if ($this->Skill->save($skill))
		{
			$descriptn='';
			$skillimages['SkillImage']['image']='';
			if(!empty($this->request->data['List']['picedit']))
			{
			  foreach($this->request->data['List']['picedit'] as $k=>$v)
			  {
				 $skillimages['SkillImage']['image'] .= $v.',';
			  }
			}
			if(!empty($this->Session->read('SKILLIMG')))
		    {
			  foreach($this->Session->read('SKILLIMG') as $k=>$v)
			  {
			    $skillimages['SkillImage']['image'] .= $v.',';
			  }
				
			}
			if(!empty($this->request->data['List']['descriptionedit']))
			{
				foreach($this->request->data['List']['descriptionedit'] as $k=>$v)
				{
					if($v!='')
					{
						$descriptn.= $v.',';
					}
					else
					{
						$descriptn.= 'blankspace,';
					}
				}
			}

			if(!empty($this->request->data['List']['description']))
			{
				foreach($this->request->data['List']['description'] as $k=>$v)
				{
					if($v!='')
					{
						$descriptn.= $v.',';
					}
					else
					{
						$descriptn.= 'blankspace,';
					}
				}
			}

			$skillimagesedit['SkillImage']['image']=trim($skillimages['SkillImage']['image'],',');
                        if($skillimg){
                            $skillimagesedit['SkillImage']['id']=$skillimg['SkillImage']['id'];
                        } else {
                             $skillimagesedit['SkillImage']['skill_id']=$skill_id;
                        }
			$skillimagesedit['SkillImage']['description'] = trim($descriptn,',');
			if ($this->SkillImage->save($skillimagesedit))
		    {
				//$this->Session->delete('MAINIMAGE');
	             $this->Session->delete('SKILLIMG');
	             $this->Session->delete('CNTIMG');
				$this->Session->setFlash('Speciality added successfully', 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'edit_step1',$skill_id));
			}
		}
	}

	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
        $this->set('sitesetting', $this->SiteSetting->find('first', $options));

	$options = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $options);
        $subSkill = $skill['Skill']['sub_category'];
        if($subSkill!=''){
            $xtr=explode(',',$subSkill);
        }

    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
       
	
	$options = array('conditions' => array('Category.is_active'  => 1,'Category.parent_id'  => 0));
	$categories = $this->Category->find('all', $options);
    $this->set(compact('title_for_layout','categories','skill','xtr','skill_id','skillimages','skilldesc'));
  }

  public function step2($skill_id=null)
  {
	$title_for_layout = 'Studio';
	$xtr=array();
	$skillimages=array();
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$options = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $options);
	if(isset($skill['Skill']['skill_tools']) && $skill['Skill']['skill_tools']!='')
	{
	  $xtr=explode(',',$skill['Skill']['skill_tools']);
	}
	else
	{
       
	}
	if(isset($skill['Skill']['skill_tool_pics']) && $skill['Skill']['skill_tool_pics']!='')
	{
	  $skillimages=explode(',',$skill['Skill']['skill_tool_pics']);
	}
	else
	{

	}

	if ($this->request->is(array('post'))) 
	{
		$skill['Skill']['id']=$skill_id;
		$skill['Skill']['skill_country']=$this->request->data['Skill']['skill_country'];
		$skill['Skill']['skill_street']=$this->request->data['Skill']['skill_street'];
		$skill['Skill']['skill_aptno']=$this->request->data['Skill']['skill_aptno'];
		$skill['Skill']['skill_city']=$this->request->data['Skill']['skill_city'];
		$skill['Skill']['skill_state']=$this->request->data['Skill']['skill_state'];
		$skill['Skill']['skill_zipcode']=$this->request->data['Skill']['skill_zipcode'];
		$skill['Skill']['skill_workshop_address']=$this->request->data['Skill']['skill_workshop_address'];
		$skill['Skill']['skill_workshop_lat']=$this->request->data['Skill']['skill_workshop_lat'];
		$skill['Skill']['skill_workshop_lang']=$this->request->data['Skill']['skill_workshop_lang'];
		$skill['Skill']['studio_details']=$this->request->data['Skill']['studio_details'];
		$skill['Skill']['party_size']=$this->request->data['Skill']['party_size'];

		if(isset($this->request->data['List']['tag']) && !empty($this->request->data['List']['tag']))
		{
			$skill['Skill']['skill_tools']='';
			foreach($this->request->data['List']['tag'] as $k=>$v)
			{
			  $skill['Skill']['skill_tools'] .= $v.',';
			}
		}
        $skill['Skill']['skill_tools']=trim($skill['Skill']['skill_tools'],',');

		$skill['Skill']['skill_tool_pics']='';
        if(!empty($this->request->data['List']['picedit']))
		{
		  foreach($this->request->data['List']['picedit'] as $k=>$v)
		  {
			 $skill['Skill']['skill_tool_pics'] .= $v.',';
		  }
		}

		if(!empty($this->Session->read('TOOLIMG')))
		{
		  foreach($this->Session->read('TOOLIMG') as $k=>$v)
		  {
			$skill['Skill']['skill_tool_pics'] .= $v.',';
		  }
			
		}
		$skill['Skill']['skill_tool_pics']=trim($skill['Skill']['skill_tool_pics'],',');
		
		if ($this->Skill->save($skill))
		{
	         $this->Session->delete('TOOLIMG');
	          $this->Session->delete('CNTIMGT');

			$this->Session->setFlash('Studio details added successfully', 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'step2',$skill_id));
		}
	}
	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
	
	$this->loadModel('User');
	$this->set(compact('title_for_layout','skill_id','skill','xtr','skillimages'));
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
  }

  public function step3($skill_id=null)
  {
	$title_for_layout = 'Price';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
    $options = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $options);
	if ($this->request->is(array('post'))) 
	{
		$skill['Skill']['id']=$skill_id;
		$skill['Skill']['min_price']=$this->request->data['Skill']['min_price'];
		$skill['Skill']['max_price']=$this->request->data['Skill']['max_price'];
		$skill['Skill']['price_details']=$this->request->data['Skill']['price_details'];
		if ($this->Skill->save($skill))
		{
			$this->Session->setFlash('Price details added successfully', 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'step3',$skill_id));
		}
	}
	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));
	
	$this->loadModel('User');
	$this->set(compact('title_for_layout','skill_id','skill'));
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
  }
  public function step4($skill_id=null)
  {
	$title_for_layout = 'Availability';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$this->loadModel('User');
	$this->loadModel('Availability');
    $options = array('conditions' => array('Availability.skill_id' => $skill_id,'Availability.user_id' => $userid));
	$availability = $this->Availability->find('first', $options);
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
    $this->set('user', $user);


	if ($this->request->is(array('post'))) 
	{
		if(!empty($availability))
		{
			 if($user['User']['is_profile_complete']==0){
				 $this->loadModel('Notification');
				 $noti['Notification']['user_id']=$userid;
				 $noti['Notification']['message']='Please fill your payout info.';
				 $noti['Notification']['date']=date('Y-m-d H:i:s');
				 $noti['Notification']['inbox_id']=0;
				 $noti['Notification']['is_read']=0;
				 $this->Notification->create();
				 $this->Notification->save($noti);
			 }

			$this->request->data['Availability']['id'] = $availability['Availability']['id'];
			if(isset($this->request->data['Availability']['any_time_email']) && $this->request->data['Availability']['any_time_email']==1)
			{
              $this->request->data['Availability']['any_time_email']=1;
			}
			else
			{
              $this->request->data['Availability']['any_time_email']=0;
			}
		    if ($this->Availability->save($this->request->data)) 
		    {
				$this->Session->setFlash('Availability details added successfully', 'default', array('class' => 'success'));
			    //return $this->redirect(array('action' => 'final_step',$skill_id));
				return $this->redirect(array('action' => 'step4',$skill_id));
			}
		}
		else
		{
             
			 $this->loadModel('Notification');
			 $noti['Notification']['user_id']=$userid;
			 if($user['User']['is_profile_complete']==0){
			   $noti['Notification']['message']='You have offered your skill successfully.Please fill your payout info.';
             }
			 else
			 {
               $noti['Notification']['message']='You have offered your skill successfully.';
			 }
			 $noti['Notification']['date']=date('Y-m-d H:i:s');
			 $noti['Notification']['inbox_id']=0;
			 $noti['Notification']['is_read']=0;
			 $this->Notification->create();
			 $this->Notification->save($noti);
			 
			 $this->request->data['Availability']['user_id'] = $userid;
			 $this->request->data['Availability']['skill_id'] = $skill_id;
			 if(isset($this->request->data['Availability']['any_time_email']) && $this->request->data['Availability']['any_time_email']==1)
			 {
               $this->request->data['Availability']['any_time_email']=1;
			 }
			 else
			 {
               $this->request->data['Availability']['any_time_email']=0;
			 }
			 $this->Availability->create();
			 if ($this->Availability->save($this->request->data)) 
		     {
				$this->Session->setFlash('Availability details added successfully', 'default', array('class' => 'success'));
			    //return $this->redirect(array('action' => 'final_step',$skill_id));
				return $this->redirect(array('action' => 'details',base64_encode($skill_id)));
			 }
		}
	}

	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));

	$this->set(compact('title_for_layout','skill_id','availability'));
  }
  public function final_step($skill_id=null)
  {
	$title_for_layout = 'Final';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	$this->loadmodel('SiteSetting');
	$options = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
    $this->set('sitesetting', $this->SiteSetting->find('first', $options));

	$this->loadModel('User');
	$this->set(compact('title_for_layout','skill_id'));
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));
  }
 public function details($skill_id=null) 
 {
	$SITE_URL = Configure::read('SITE_URL');
	$title_for_layout = 'Skill Details';
	$skill_id=base64_decode($skill_id);
	$userid = $this->Session->read('Auth.User.id');
	$this->loadModel('Availability');
	$this->loadModel('ProfilePageview');
	$this->loadModel('Request');
	$this->loadModel('Review');
	/*if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}*/
	$option_skill = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $option_skill);
    $skill_specifically=$skill['Skill']['about_specifically'];
    $skill_sub=$skill['Skill']['sub_category'];
	$skill_cat=$skill['Skill']['category_id'];

	$skill_maker_id=$skill['Skill']['user_id'];
	if($userid != $skill_maker_id)
	{
		$profle_view['ProfilePageview']['user_id']=$skill_maker_id;
		$profle_view['ProfilePageview']['date']=date('Y-m-d');
		$this->ProfilePageview->create();
		$this->ProfilePageview->save($profle_view);
	}


	$arrs = 'Skill.id > 0 AND Skill.is_active = 1 AND Skill.id!='.$skill_id.'';
	if(isset($skill_specifically) && $skill_specifically != ''){
		$arrs.=" AND (Skill.about_specifically LIKE '%".$skill_specifically."%')";
	}
	/*if(isset($skill_sub) && $skill_sub != ''){
		$arrs.=" OR (Skill.sub_category LIKE '%".$skill_sub."%')";
	}*/
	$option_skill = array('order' => 'rand()','conditions' => $arrs,'limit'=>'3');
	$recommendskill=$this->Skill->find('all', $option_skill);
	
	//$options = array('order' => 'rand()','conditions' => array('Skill.id !=' => //$skill_id,'Skill.category_id' => $skill_cat,'Skill.is_active' => 1),'limit'=>'3');
	//$recommendskill = $this->Skill->find('all', $options);
    $is_review_exists=0;
	
	$option_req=array('conditions' => array('Request.skill_id' => $skill_id));
	$allrequests=$this->Request->find('all', $option_req);
	foreach($allrequests as $allrequest)
	{
      $options = array('conditions' => array('Review.request_id' => $allrequest['Request']['id'],'Review.reviewer'=>$allrequest['Request']['user_id']));
      $revs=$this->Review->find('all', $options);
	  if(!empty($revs))
	  {
		  $is_review_exists=1;
	  }
	}

	$option_availability = array('conditions' => array('Availability.skill_id' => $skill_id));
	$availability = $this->Availability->find('first', $option_availability);

	$this->loadModel('User');
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);
    
	$options = array('conditions' => array('User.id !='=>$userid));
	$allusers=$this->User->find('all', $options);
	$allusers_arr=array();
    foreach($allusers as $alluser)
	{
       if(!empty($alluser['Skill']))
	   {
         $allusers_arr[]=$alluser['User']['id'];
	   }
	}
	shuffle($allusers_arr);
	
	$options_recom = array('conditions' => array('User.' . $this->User->primaryKey => $allusers_arr['0']));
	$recommend_user=$this->User->find('first', $options_recom);

	$this->loadModel('Wishlist');
	$options = array('conditions' => array('Wishlist.user_id' => $userid,'Wishlist.skill_id' => $skill_id));
	$wishlist_skill=$this->Wishlist->find('first', $options);

	$wishlist_ids=array();
	$options1 = array('conditions' => array('Wishlist.user_id' => $userid));
	$wishlist_skill1=$this->Wishlist->find('all', $options1);
	if(!empty($wishlist_skill1))
	{
	  foreach($wishlist_skill1 as $wishlists1)
	  {
		  $wishlist_ids[]=$wishlists1['Wishlist']['skill_id'];
	  }
	}
	$this->loadModel('SkillImage');
        $skilloptiondetails=array('conditions'=>array('`SkillImage`.`skill_id`'=>$skill_id));
        $imagedescription=$this->SkillImage->find('first',$skilloptiondetails);

	$this->loadModel('SiteSetting');
    $optionsst = array('conditions' => array('SiteSetting.' . $this->SiteSetting->primaryKey => 1));
	$sitesetting=$this->SiteSetting->find('first', $optionsst);

	$this->set(compact('user','skill','availability','title_for_layout','wishlist_skill','recommendskill','recommend_user','sitesetting','SITE_URL','wishlist_ids','allrequests','is_review_exists','imagedescription'));
 }
 public function sliderframe($skill_id=null) 
 {
	$this->layout=false;
	$userid = $this->Session->read('Auth.User.id');
	$this->loadModel('Availability');
	/*if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}*/
	$option_skill = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $option_skill);

	$option_availability = array('conditions' => array('Availability.skill_id' => $skill_id));
	$availability = $this->Availability->find('first', $option_availability);

	$this->loadModel('User');
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);

	$this->set(compact('user','skill','availability'));
 }

 public function sliderframe2($skill_id=null) 
 {
	$this->layout=false;
	$userid = $this->Session->read('Auth.User.id');
	$this->loadModel('Availability');
	/*if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}*/
	$option_skill = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $option_skill);
	#pr($skill);
	$this->loadModel('SkillImage');
        $skilloptiondetails=array('conditions'=>array('`SkillImage`.`skill_id`'=>$skill_id));
        $imagedescription=$this->SkillImage->find('first',$skilloptiondetails);
	$this->set(compact('user','skill','availability','imagedescription'));
 }


 public function getVimeoThumb($id) {
    $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
    $data = json_decode($data);
    return $data[0]->thumbnail_medium;
}

public function make_wishlist_top($skill_id=null)
{
  $userid= $this->Session->read('Auth.User.id');
  $this->loadModel('Wishlist');

  $options = array('conditions' => array('Wishlist.user_id' => $userid,'Wishlist.skill_id' => $skill_id));
  $wishlist_skill=$this->Wishlist->find('first', $options);
  
  $data='';

  if(!empty($wishlist_skill))
  {
	$this->Wishlist->id = $wishlist_skill['Wishlist']['id'];
	if ($this->Wishlist->delete()) {
	 $data.='<a href="javascript:void(0);" onclick="make_favtop('.$skill_id.')"><img src="'.$this->webroot.'img/share1.png" title="Add to wishlist"></a>';
	}
  }
  else
  {
	$fav['Wishlist']['user_id']=$userid;
	$fav['Wishlist']['skill_id']=$skill_id;
	$this->Wishlist->create();
	if ($this->Wishlist->save($fav)) {
	  $data.='<a href="javascript:void(0);" onclick="make_favtop('.$skill_id.')"><img src="'.$this->webroot.'img/share1_black.png" title="Remove from wishlist"></a>';
	}
  }
	echo $data;
    exit;
}

public function make_wishlist($skill_id=null)
{
  $userid= $this->Session->read('Auth.User.id');
  $this->loadModel('Wishlist');

  $options = array('conditions' => array('Wishlist.user_id' => $userid,'Wishlist.skill_id' => $skill_id));
  $wishlist_skill=$this->Wishlist->find('first', $options);
  
  $data='';

  if(!empty($wishlist_skill))
  {
	$this->Wishlist->id = $wishlist_skill['Wishlist']['id'];
	if ($this->Wishlist->delete()) {
	 $data.='<a href="javascript:void(0);" onclick="make_fav('.$skill_id.')"><img src="'.$this->webroot.'img/share1.png" title="Add to wishlist"></a>';
	}
  }
  else
  {
	$fav['Wishlist']['user_id']=$userid;
	$fav['Wishlist']['skill_id']=$skill_id;
	$this->Wishlist->create();
	if ($this->Wishlist->save($fav)) {
	  $data.='<a href="javascript:void(0);" onclick="make_fav('.$skill_id.')"><img src="'.$this->webroot.'img/share1_black.png" title="Remove from wishlist"></a>';
	}
  }
	echo $data;
    exit;
}
public function user_profile($user_id=null)
 {
	$user_id=base64_decode($user_id);
	$title_for_layout = 'User Profile';
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$this->loadModel('User');
	
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $this->set('user', $this->User->find('first', $options));

	$options_profile = array('conditions' => array('User.' . $this->User->primaryKey => $user_id));
    $this->set('profileuser', $this->User->find('first', $options_profile));

	$this->set(compact('title_for_layout','user_id'));
 }
 public function preview($skill_id=null) 
 {
	$title_for_layout = 'Skill Preview';
	$skill_id=base64_decode($skill_id);
	$userid = $this->Session->read('Auth.User.id');
	$this->loadModel('Availability');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$option_skill = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $option_skill);


	$option_availability = array('conditions' => array('Availability.skill_id' => $skill_id));
	$availability = $this->Availability->find('first', $option_availability);

	$this->loadModel('User');
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
	$user=$this->User->find('first', $options);

	$this->set(compact('user','skill','availability','title_for_layout'));
 }

 public function sendcontact($skill_id=null) 
 {
    $userid = $this->Session->read('Auth.User.id');
	$key = Configure::read('CONTACT_EMAIL');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	$options = array('conditions' => array('Skill.id' => $skill_id));
	$skill = $this->Skill->find('first', $options);

    $this->loadModel('User');
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $userid));
    $user=$this->User->find('first', $options);
        
    $maker_id=$skill['Skill']['user_id'];

	$this->loadModel('Request');
	$this->loadModel('Notification');
	$this->loadModel('SentMessage');
	$this->loadModel('InboxMessage');
	
	if ($this->request->is(array('post'))) 
	{
		$skill['Request']['skill_id']=$skill_id;
		$skill['Request']['user_id']=$userid;
		$skill['Request']['maker']=$maker_id;
		$skill['Request']['total_persons']=$this->request->data['Request']['hid_person_no'];
		$skill['Request']['request_comment']=$this->request->data['Request']['comment'];
		$skill['Request']['request_date']=$this->request->data['Request']['date_str'];
		$skill['Request']['request_time']=$this->request->data['Request']['hid_time_span'];
		$skill['Request']['request_time_format']=$this->request->data['Request']['hid_time_am_or_pm'];
		$skill['Request']['sent_date']=date('Y-m-d');
              
		$skill['Request']['image_paths']='';
		if(!empty($this->Session->read('ORDERIMG')))
		{
		  foreach($this->Session->read('ORDERIMG') as $k=>$v)
		  {
			$skill['Request']['image_paths'] .= $v.',';
		  }
			
		}
		$skill['Request']['image_paths']=trim($skill['Request']['image_paths'],',');
		
		if ($this->Request->save($skill))
		{
			$orderid=$this->Request->getLastInsertId();

			$this->loadModel('EmailTemplate');
			$EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>4)));
			$mail_body =str_replace(array('[orderid]','[ordername]','[username]'),array($orderid,$skill['Skill']['skill_name'],$user['User']['first_name']),$EmailTemplate['EmailTemplate']['content']);
			$this->send_mail($key,$skill['User']['email'],$EmailTemplate['EmailTemplate']['subject'],$mail_body);

			$EmailTemplate=$this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.id'=>5)));
			$mail_body =str_replace(array('[orderid]','[ordername]','[username]'),array($orderid,$skill['Skill']['skill_name'],$skill['User']['first_name']),$EmailTemplate['EmailTemplate']['content']);
			$this->send_mail($key,$user['User']['email'],$EmailTemplate['EmailTemplate']['subject'],$mail_body);
						
   
            $inbx['InboxMessage']['user_id']=$maker_id;
			$inbx['InboxMessage']['sender']=$userid;
			$inbx['InboxMessage']['skill_id']=$skill_id;
			$inbx['InboxMessage']['order_id']=$orderid;
			$inbx['InboxMessage']['subject']='New booking request';
			$inbx['InboxMessage']['message']='You have a new booking request.';
			$inbx['InboxMessage']['date_time']=date('Y-m-d H:i:s');
			$this->InboxMessage->create();
			$this->InboxMessage->save($inbx);
			$inbxid=$this->InboxMessage->getLastInsertId();
			
			$thrd['SentMessage']['user_id']=$maker_id;
			$thrd['SentMessage']['inbox_id']=$inbxid;
			$thrd['SentMessage']['sender']=$userid;
			$thrd['SentMessage']['message']='You have a new booking request.';
			$thrd['SentMessage']['date_time']=date('Y-m-d H:i:s');
			$this->SentMessage->create();
			$this->SentMessage->save($thrd);

			$noti['Notification']['user_id']=$maker_id;
			$noti['Notification']['inbox_id']=$inbxid;
			$noti['Notification']['message']='You have a new booking request.';
			$noti['Notification']['date']=date('Y-m-d H:i:s');
			$noti['Notification']['is_read']=0;
			$this->Notification->create();
			$this->Notification->save($noti);

			$inbx1['InboxMessage']['user_id']=$userid;
			$inbx1['InboxMessage']['sender']=$maker_id;
			$inbx1['InboxMessage']['skill_id']=$skill_id;
			$inbx1['InboxMessage']['order_id']=$orderid;
			$inbx1['InboxMessage']['subject']='New booking request';
			$inbx1['InboxMessage']['message']='Your booking request has been sent successfully.';
			$inbx1['InboxMessage']['date_time']=date('Y-m-d H:i:s');
			$this->InboxMessage->create();
			$this->InboxMessage->save($inbx1);
            $inbxid1=$this->InboxMessage->getLastInsertId();

			$thrd1['SentMessage']['user_id']=$userid;
			$thrd1['SentMessage']['inbox_id']=$inbxid1;
			$thrd1['SentMessage']['sender']=$maker_id;
			$thrd1['SentMessage']['message']='Your booking request has been sent successfully.';
			$thrd1['SentMessage']['date_time']=date('Y-m-d H:i:s');
			$this->SentMessage->create();
			$this->SentMessage->save($thrd1);

			
			$this->Session->delete('CNTIMGO');
			$this->Session->delete('ORDERIMG');
			$this->Session->setFlash('Booking request sent successfully', 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'details',base64_encode($skill_id)));
		}
	}
 }

 /*public function img_save_to_file() 
 {
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	$uploadFolder = "skill_images/";
	$imagePath = WWW_ROOT . $uploadFolder;

	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
	$temp = explode(".", $_FILES["img"]["name"]);
	$extension = end($temp);

	if ( in_array($extension, $allowedExts))
	  {
	  if ($_FILES["img"]["error"] > 0)
		{
			 $response = array(
				"status" => 'error',
				"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
			);
			echo "Return Code: " . $_FILES["img"]["error"] . "<br>";
		}
	  else
		{
			
		  $filename = $_FILES["img"]["tmp_name"];
		  list($width, $height) = getimagesize( $filename );
		  $mainfilename=rand().'_'.$userid.'_'.preg_replace('/\s+/', '_', $_FILES["img"]["name"]);

		  $this->Session->write('MAINIMAGE',$mainfilename);
       
		  move_uploaded_file($filename,  $imagePath . $mainfilename);

		  $response = array(
			"status" => 'success',
			"url" => $this->webroot.'skill_images/'.$mainfilename,
			"width" => $width,
			"height" => $height
		  );
		  
		}
	  }
	else
	  {
	   $response = array(
			"status" => 'error',
			"message" => 'something went wrong',
		);
	  }
	  print json_encode($response);
	  exit;
 }

 public function img_crop_to_file() 
 {
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	$imgUrl = $_POST['imgUrl'];
	$imgInitW = $_POST['imgInitW'];
	$imgInitH = $_POST['imgInitH'];
	$imgW = $_POST['imgW'];
	$imgH = $_POST['imgH'];
	$imgY1 = $_POST['imgY1'];
	$imgX1 = $_POST['imgX1'];
	$cropW = $_POST['cropW'];
	$cropH = $_POST['cropH'];

     
	$jpeg_quality = 100;
	
	$uploadFolder = "skill_images/";
	$imagePath = WWW_ROOT . $uploadFolder;

	//$bannerpic=$this->Session->read('MAINIMGNAME');

	$imgUrl = 'http://aktively.com'.$imgUrl;

	$what = getimagesize($imgUrl);
	switch(strtolower($what['mime']))
	{
		case 'image/png':
			$img_r = imagecreatefrompng($imgUrl);
			$source_image = imagecreatefrompng($imgUrl);
			$type = '.png';
			break;
		case 'image/jpeg':
			$img_r = imagecreatefromjpeg($imgUrl);
			$source_image = imagecreatefromjpeg($imgUrl);
			$type = '.jpeg';
			break;
		case 'image/jpg':
			$img_r = imagecreatefromjpeg($imgUrl);
			$source_image = imagecreatefromjpeg($imgUrl);
			$type = '.jpg';
			break;
		case 'image/gif':
			$img_r = imagecreatefromgif($imgUrl);
			$source_image = imagecreatefromgif($imgUrl);
			$type = '.gif';
			break;
		default: die('image type not supported');
	}
	$new_name = rand().'_'."small".$type;

	$this->Session->write('MAINIMAGE',$new_name);

	$output_filename=$imagePath.$new_name;
		
		$resizedImage = imagecreatetruecolor($imgW, $imgH);
		imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, 
					$imgH, $imgInitW, $imgInitH);	
		
		
		$dest_image = imagecreatetruecolor($cropW, $cropH);
		imagecopyresampled($dest_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, 
					$cropH, $cropW, $cropH);	


		imagejpeg($dest_image, $output_filename, $jpeg_quality);
		
		$response = array(
				"status" => 'success',
				"url" => $this->webroot.'skill_images/'.$new_name,
			  );
		 print json_encode($response);
	  exit;
 }*/
 
 public function img_crop_to_file($skill_id=null) 
 {
	$userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	$data = $_POST['coverphoto']['cropped'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	define('UPLOAD_DIR', 'skill_images/');
    
	$save_img_name=uniqid() . '_bnr_.png';

	$file = UPLOAD_DIR . $save_img_name;
	$success = file_put_contents($file, $data);

	if($success)
	{
	  $skill['Skill']['id']=$skill_id;
	  $skill['Skill']['banner']=$save_img_name;
	  if ($this->Skill->save($skill))
	  {
        $this->Session->setFlash('Banner image has been changed successfully', 'default', array('class' => 'success'));
	  }
	  else
	  {
        $this->Session->setFlash('Banner image could not be changed', 'default');
	  }
	}
	else
	{
		$this->Session->setFlash('Banner image could not be changed', 'default');
	}
	return $this->redirect(array('action' => 'details',base64_encode($skill_id)));
 }

 public function my_target_url()
 {
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	App::import('Helper', 'Resize');
	$resize = new ResizeHelper();
	
	$uploadFolder = "skill_images";
	$uploadPath = WWW_ROOT . $uploadFolder;

    $cnt = $this->Session->read('CNTIMG');
	if(isset($cnt) && $cnt!='')
	{
       $cnt=$cnt;
	}
	else
	{
      $cnt=1;
	}

	foreach ($_FILES["file"]["error"] as $key => $error){
		if ($error == UPLOAD_ERR_OK){
		$time=time(); 
		$random_num=rand(00,99);
		
		$name = $time.$random_num.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
		$newimageName = time().'_'.rand().'_'.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];

		if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $uploadPath.'/'.$name))
		{
		  $full_image_path = $uploadPath . '/' . $name;
		  $full_image_path_new = $uploadPath . '/' . $newimageName;
		
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

		// resize image as thumb

		$resize->versions_store =WWW_ROOT.'skill_images'.DS; 
		$resize->versions_public =WWW_ROOT.'skill_images'.DS;
		$destination_width="300";
		$destination_height ="300";
		$resize->wrap($newimageName, $destination_width, $destination_height);

		  $this->Session->write('SKILLIMG.'.$cnt, $newimageName);
		  
		  $resize->versions_store =WWW_ROOT.'skill_images'.DS; 
		$resize->versions_public =WWW_ROOT.'skill_images_details'.DS;
		$destination_width2="650";
		$destination_height2 ="460";
		$resize->wrap($newimageName, $destination_width2, $destination_height2);

		  $this->Session->write('SKILLIMG.'.$cnt, $newimageName);

		  $cnt++;
		  echo "1";
		}
		else
		{
		echo "0";
		exit;
		}
	  }
	}
    $this->Session->write('CNTIMG',$cnt);
	exit;
 }

 public function my_target_url2()
 {
	
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}
	// decairing the helper 

	 App::import('Helper', 'Resize');
	$resize = new ResizeHelper();


	$uploadFolder = "tool_images";
	$uploadPath = WWW_ROOT . $uploadFolder;

    $cnt = $this->Session->read('CNTIMGT');
	if(isset($cnt) && $cnt!='')
	{
       $cnt=$cnt;
	}
	else
	{
      $cnt=1;
	}

	foreach ($_FILES["file"]["error"] as $key => $error){
		if ($error == UPLOAD_ERR_OK){
		$time=time();
		$random_num=rand(00,99);
		$name = $time.$random_num.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
        $newimageName = time().'_'.rand().'_'.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];

		if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $uploadPath.'/'.$name))
		{

		

		$full_image_path = $uploadPath . '/' . $name;
		

		
		
		  $full_image_path_new = $uploadPath . '/' . $newimageName;

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

		$resize->versions_store =WWW_ROOT.'tool_images'.DS; 
		$resize->versions_public =WWW_ROOT.'tool_images'.DS;
		$destination_width="200";
		$destination_height ="200";

	   $resize->wrap($newimageName, $destination_width, $destination_height);

	   	$resize->versions_store =WWW_ROOT.'tool_images'.DS; 
		$resize->versions_public =WWW_ROOT.'tool_images_details'.DS;
		$destination_width2="850";
		$destination_height2 ="450";

	   $resize->wrap($newimageName, $destination_width2, $destination_height2);
		  
		  $this->Session->write('TOOLIMG.'.$cnt, $newimageName);		
		  $cnt++;
		  echo "1";
		}
		else
		{
		echo "0";
		exit;
		}
	  }
	}
    $this->Session->write('CNTIMGT',$cnt);
	exit;
 }
 public function my_target_url3()
 {
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	App::import('Helper', 'Resize');
	$resize = new ResizeHelper();

	$uploadFolder = "order_images";
	$uploadPath = WWW_ROOT . $uploadFolder;

    $cnt = $this->Session->read('CNTIMGO');
	if(isset($cnt) && $cnt!='')
	{
       $cnt=$cnt;
	}
	else
	{
      $cnt=1;
	}

	foreach ($_FILES["file"]["error"] as $key => $error){
		if ($error == UPLOAD_ERR_OK){
		$time=time();
		$random_num=rand(00,99);
		$name = $time.$random_num.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
		$newimageName = time().'_'.rand().'_'.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];

		if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $uploadPath.'/'.$name))
		{

		

	    $full_image_path = $uploadPath . '/' . $name;

		  $full_image_path_new = $uploadPath . '/' . $newimageName;

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
		  
		  $resize->versions_store =WWW_ROOT.'order_images'.DS; 
		$resize->versions_public =WWW_ROOT.'order_images'.DS;
		$destination_width="200";
		$destination_height ="200";

	   $resize->wrap($newimageName , $destination_width, $destination_height);

		  $this->Session->write('ORDERIMG.'.$cnt, $newimageName);		
		  $cnt++;
		  echo "1";
		}
		else
		{
		echo "0";
		exit;
		}
	  }
	}
    $this->Session->write('CNTIMGO',$cnt);
	exit;
 }

 public function my_target_url4()
 {
    $userid = $this->Session->read('Auth.User.id');
	if(!isset($userid) && $userid=='')
	{
		$this->redirect('/');
	}

	App::import('Helper', 'Resize');
	$resize = new ResizeHelper();

	
	$uploadFolder = "order_images";
	$uploadPath = WWW_ROOT . $uploadFolder;

	
	foreach ($_FILES["file"]["error"] as $key => $error){
		if ($error == UPLOAD_ERR_OK){
		$time=time();
		$random_num=rand(00,99);
		$name = $time.$random_num.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];
        $newimageName = time().'_'.rand().'_'.preg_replace('/\s+/', '_', $_FILES["file"]["name"])[$key];

		if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $uploadPath.'/'.$name))
		{
		  $full_image_path = $uploadPath . '/' . $name;

		  $full_image_path_new = $uploadPath . '/' . $newimageName;

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
		  
		$resize->versions_store =WWW_ROOT.'order_images'.DS; 
		$resize->versions_public =WWW_ROOT.'order_images'.DS;
		$destination_width="200";
		$destination_height ="200";

	   $resize->wrap($newimageName, $destination_width, $destination_height);
		  
		  $this->Session->write('ORDERIMG.'.$cnt, $newimageName);		
		  $cnt++;
		  echo "1";
		}
		else
		{
		echo "0";
		exit;
		}
	  }
	}
	$this->Session->write('CNTIMGO',$cnt);
	exit;
 }

 public function remove_session($ssnid=null)
 {
   $this->Session->delete('TOOLIMG.'.$ssnid);
   echo 'success';
   exit;
 }
 public function remove_session1($ssnid=null)
 {
   $this->Session->delete('SKILLIMG.'.$ssnid);
   echo 'success';
   exit;
 }
 public function remove_session2($ssnid=null)
 {
   $this->Session->delete('ORDERIMG.'.$ssnid);
   echo 'success';
   exit;
 }
public function unpublish($id=null)
{
   $this->request->data['Skill']['id']=$id;
   $this->request->data['Skill']['is_active']=0;
   $this->Skill->save($this->request->data);
$this->Session->setFlash('The skills Unpublish sucessfully', 'default', array('class' => 'success'));
   return $this->redirect(array('controller'=>'users','action' => 'my_offers'));
}
public function publish($id=null)
{
   $this->request->data['Skill']['id']=$id;
   $this->request->data['Skill']['is_active']=1;
   $this->Skill->save($this->request->data);
   $this->Session->setFlash('The skills Publish sucessfully', 'default', array('class' => 'success'));
  return $this->redirect(array('controller'=>'users','action' => 'my_offers'));
}
public function myoffer_delete($id=null)
{
  	$this->Skill->id = $id;
		if (!$this->Skill->exists()) {
			throw new NotFoundException(__('Invalid skill'));
		}
		#$this->request->allowMethod('post', 'delete');
		if ($this->Skill->delete()) {
                    $this->loadModel('SkillImage');
        $this->loadmodel('Availability');
                    $this->SkillImage->skill_id = $id;
                    $this->Availability->skill_id = $id;
                    $this->SkillImage->delete();
                    $this->Availability->delete();
        $this->Session->setFlash('The skills has been deleted sucessfully', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The skill could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('controller'=>'users','action' => 'my_offers'));  
}

}
