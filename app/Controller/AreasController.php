<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class AreasController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('Area','City','State','Country');

	

	public function admin_list() {		
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Area List';
                $this->paginate = array(
			'order' => array(
				'Area.id' => 'desc'
			)
		);
		$this->Area->recursive = 0;
                $this->Paginator->settings = $this->paginate;
		$this->set('areas', $this->Paginator->paginate());
		$this->set(compact('title_for_layout'));
	}

        public function admin_add() {
		$title_for_layout = 'Area Add';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
		if ($this->request->is(array('post', 'put'))) {
		    $options = array('conditions' => array('Area.name'  => $this->request->data['Area']['name'],'Area.country_id'  => $this->request->data['Area']['country_id'],'Area.state_id'  => $this->request->data['Area']['state_id'],'Area.city_id'  => $this->request->data['Area']['city_id']));
		    $areaexists = $this->Area->find('first', $options);
                    if(!$areaexists)
	            {
			$this->Area->create();
                        if ($this->Area->save($this->request->data))
			{
			   $this->Session->setFlash('The area added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	            }
		    else
		    {
			 $this->Session->setFlash(__('Area already exists. Please, try another.', 'default', array('class' => 'error')));
		    }
	        }
                $optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
	        $this->set(compact('allcountries','title_for_layout'));
	}


	public function admin_edit($id = null) {
                $title_for_layout = 'Area Edit';
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}	
		if (!$this->Area->exists($id)) {
		   throw new NotFoundException(__('Invalid area.'));
		}

		if ($this->request->is(array('post', 'put'))) 
		{
		  $options = array('conditions' => array('Area.name'  => $this->request->data['Area']['name'],'Area.country_id'  => $this->request->data['Area']['country_id'],'Area.state_id'  => $this->request->data['Area']['state_id'],'Area.city_id'  => $this->request->data['Area']['city_id'],'Area.id !='=>$this->request->data['Area']['id']));
		  $areaexists = $this->Area->find('first', $options); 

                  if(!$areaexists)
	          {
			if ($this->Area->save($this->request->data)) {
			   $this->Session->setFlash('The area has been saved.', 'default', array('class' => 'success'));
			} else {
			   $this->Session->setFlash(__('The area could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                       $this->Session->setFlash(__('Area already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		  $options = array('conditions' => array('Area.' . $this->Area->primaryKey => $this->request->data['Area']['id']));
		  $this->request->data = $this->Area->find('first', $options);
		  $cntryid=$this->request->data['Area']['country_id'];
		  $stateid=$this->request->data['Area']['state_id'];
		} else {
		    $options = array('conditions' => array('Area.' . $this->Area->primaryKey => $id));
		    $this->request->data = $this->Area->find('first', $options);
		    $cntryid=$this->request->data['Area']['country_id'];
		    $stateid=$this->request->data['Area']['state_id'];
		}
		
		$optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
                $optionstate = array('conditions' => array('State.is_active'  => 1,'State.country_id'=>$cntryid));
                $allstates = $this->State->find('all',$optionstate);
                $optioncity = array('conditions' => array('City.is_active'  => 1,'City.state_id'=>$stateid));
                $allcities = $this->City->find('all',$optioncity);
	        $this->set(compact('allcountries','title_for_layout','allstates','allcities'));
	}
	
        public function admin_delete($id = null) {
	   $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->Area->id = $id;
	   if (!$this->Area->exists()) {
	      throw new NotFoundException(__('Invalid area.'));
	   }
	   if ($this->Area->delete($id)) {
		$this->Session->setFlash('The area has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('The area could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'list'));
	}
	
	

}

