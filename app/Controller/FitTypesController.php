<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class FitTypesController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');


	

	public function admin_list() {		
          $userid = $this->Session->read('Auth.User.id');
	  if(!isset($userid) && $userid=='')
	  {
	    $this->redirect('/admin');
	  }
	
	  $title_for_layout = 'FitType List';
          $this->paginate = array(
		'order' => array(
			'FitType.id' => 'desc'
		)
	  );
          $this->Paginator->settings = $this->paginate;
	  $this->set('fittypes', $this->Paginator->paginate());
	  $this->set(compact('title_for_layout'));
	}

        public function admin_add() {
          $title_for_layout = 'FitType Add';
	  $userid = $this->Session->read('Auth.User.id');
	  if(!isset($userid) && $userid=='')
	  {
	    $this->redirect('/admin');
	  }
	  if ($this->request->is(array('post', 'put'))) {
		$options = array('conditions' => array('FitType.name'  => $this->request->data['FitType']['name']));
		$fittypeexists = $this->FitType->find('first', $options);
                if(!$fittypeexists)
	        {
			$this->FitType->create();
                        if ($this->FitType->save($this->request->data))
			{
			   $this->Session->setFlash('The fit type added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	        }
	       else
	        {
	          $this->Session->setFlash(__('Fit type already exists. Please, try another.', 'default', array('class' => 'error')));
	        }
	    }
	    $this->set(compact('title_for_layout'));
	}


	public function admin_edit($id = null) 
	{
            $title_for_layout = 'FitType Edit';
            $userid = $this->Session->read('Auth.User.id');
	    if(!isset($userid) && $userid=='')
	    {
		$this->redirect('/admin');
	    }	
	    if (!$this->FitType->exists($id)) {
		throw new NotFoundException(__('Invalid fit type.'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
		  $options = array('conditions' => array('FitType.name'  => $this->request->data['FitType']['name'],'FitType.id !='=>$this->request->data['FitType']['id']));
		  $fittypeexists = $this->FitType->find('first', $options); 
                  if(!$fittypeexists)
	          {
			if ($this->FitType->save($this->request->data)) {
			    $this->Session->setFlash('The fit type has been saved.', 'default', array('class' => 'success'));
			} else {
			    $this->Session->setFlash(__('The fit type could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                    $this->Session->setFlash(__('Fit type already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		} 
		else 
		{
		   $options = array('conditions' => array('FitType.' . $this->FitType->primaryKey => $id));
		   $this->request->data = $this->FitType->find('first', $options);
		}
		$this->set(compact('title_for_layout'));
	}
	
        public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		$this->FitType->id = $id;
		if (!$this->FitType->exists()) {
		  throw new NotFoundException(__('Invalid fit type.'));
		}
		if ($this->FitType->delete($id)) {
			$this->Session->setFlash('The fit type has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The fit type could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'list'));
	}


}

