<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class StatesController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('State','Country');


	

	public function admin_list() {		
           $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
	      $this->redirect('/admin');
	   }
	   $title_for_layout = 'State List';
           $this->paginate = array(
		'order' => array(
			'State.id' => 'desc'
		)
	    );
	    $this->State->recursive = 0;
            $this->Paginator->settings = $this->paginate;
	    $this->set('states', $this->Paginator->paginate());
	    $this->set(compact('title_for_layout'));
	}

        public function admin_add() {
		$userid = $this->Session->read('Auth.User.id');
		$title_for_layout = 'State Add';
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		if ($this->request->is(array('post', 'put')))
	        {
		    $options = array('conditions' => array('State.name'  => $this->request->data['State']['name'],'State.country_id'  => $this->request->data['State']['country_id']));
		    $stateexists = $this->State->find('first', $options);
                    if(!$stateexists)
	            {
			$this->State->create();
                        if ($this->State->save($this->request->data))
			{
			   $this->Session->setFlash('The state added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	            }
		    else
		    {
			 $this->Session->setFlash(__('State already exists. Please, try another.', 'default', array('class' => 'error')));
		    }
	        }
                $optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
	        $this->set(compact('allcountries','title_for_layout'));
	}


	public function admin_edit($id = null) {
                $userid = $this->Session->read('Auth.User.id');
                $title_for_layout = 'State Edit';
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}	
		if (!$this->State->exists($id)) {
		  throw new NotFoundException(__('Invalid state.'));
		}

		if ($this->request->is(array('post', 'put'))) {
		  $options = array('conditions' => array('State.name'  => $this->request->data['State']['name'],'State.country_id'  => $this->request->data['State']['country_id'],'State.id !='=>$this->request->data['State']['id']));
		  $stateexists = $this->State->find('first', $options); 
                  if(!$stateexists)
	          {
			if ($this->State->save($this->request->data)) {
			    $this->Session->setFlash('The state has been saved.', 'default', array('class' => 'success'));
			} else {
			    $this->Session->setFlash(__('The state could not be saved. Please, try again.'));
			}
		  }
                  else
		  {
                    $this->Session->setFlash(__('State already exists. Please, try another.', 'default', array('class' => 'error')));
		  }
		} 
		else
		{
		   $options = array('conditions' => array('State.' . $this->State->primaryKey => $id));
		   $this->request->data = $this->State->find('first', $options);
		}
		$optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
	        $this->set(compact('allcountries','title_for_layout'));
	}
	
        public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		$this->State->id = $id;
		if (!$this->State->exists()) {
			throw new NotFoundException(__('Invalid state.'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash('The state has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The state could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'list'));
	}


}

