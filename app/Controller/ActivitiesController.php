<?php
App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class ActivitiesController extends AppController {

/**
 * Components
 *
 * @var array
 */

    public $components = array('Paginator','Session');
    public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('index');
	}

	public $paginate = array(
			'limit' =>25,
			'order' => array(
			   'Activity.id' => 'desc'
			 ), 
		     );

	
	//$this->Paginator->settings = $this->paginate;


	public function admin_list($id=null) {
	$this->loadModel('User');
	   $title_for_layout='Tracking User';
	   $this->Activity->recursive = 1;
	   $users = $this->User->find('all',array('condition'=>array('User.is_active'=>1)));

	//if(empty($id)){
	  
	if ($this->request->is(array('post', 'put'))) {
//pr($this->request->data);exit;
	   if($this->request->data['userid']==''){
		$this->Paginator->settings = $this->paginate;
		$this->set('activities', $this->Paginator->paginate());
	   }
	  else{
		$this->paginate = array(
	        'limit' =>25,
	        'order' => array(
		   'Activity.id' => 'desc'
	         ), 
	     );
	     $this->Paginator->settings = $this->paginate;
	     $this->set('activities', $this->Paginator->paginate('Activity',array('Activity.user_id'=>$this->request->data['userid'])));


		//$users = $this->Activity->find('all',array('condition'=>array('Activity.user_id'=>$id)));
		//$this->set('activities', $this->Paginator->paginate('Activity',array('conditions'=>array('Activity.user_id'=>$id))));
	    }
	}
	else{
		$this->Paginator->settings = $this->paginate;
		$this->set('activities', $this->Paginator->paginate());
	    }
	   $this->set(compact('users','title_for_layout'));
        }



}
?>
