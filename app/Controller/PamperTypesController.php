<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class PamperTypesController extends AppController {



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
	
	  $title_for_layout = 'PamperType List';
          $this->paginate = array(
		'order' => array(
			'PamperType.id' => 'desc'
		)
	  );
          $this->Paginator->settings = $this->paginate;
	  $this->set('pampertypes', $this->Paginator->paginate());
	  $this->set(compact('title_for_layout'));
	}

        public function admin_add() {
          $title_for_layout = 'PamperType Add';
	  $userid = $this->Session->read('Auth.User.id');
	  if(!isset($userid) && $userid=='')
	  {
	    $this->redirect('/admin');
	  }
	  if ($this->request->is(array('post', 'put'))) {
		$options = array('conditions' => array('PamperType.name'  => $this->request->data['PamperType']['name']));
		$pampertypeexists = $this->PamperType->find('first', $options);
                if(!$pampertypeexists)
	        {
			$this->PamperType->create();
                        if ($this->PamperType->save($this->request->data))
			{
			   $this->Session->setFlash('The pamper type added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	        }
	       else
	        {
	          $this->Session->setFlash(__('Pamper type already exists. Please, try another.', 'default', array('class' => 'error')));
	        }
	    }
	    $this->set(compact('title_for_layout'));
	}


	public function admin_edit($id = null) 
	{
            $title_for_layout = 'PamperType Edit';
            $userid = $this->Session->read('Auth.User.id');
	    if(!isset($userid) && $userid=='')
	    {
		$this->redirect('/admin');
	    }	
	    if (!$this->PamperType->exists($id)) {
		throw new NotFoundException(__('Invalid pamper type.'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
		  $options = array('conditions' => array('PamperType.name'  => $this->request->data['PamperType']['name'],'PamperType.id !='=>$this->request->data['PamperType']['id']));
		  $pampertypeexists = $this->PamperType->find('first', $options); 
                  if(!$pampertypeexists)
	          {
			if ($this->PamperType->save($this->request->data)) {
			    $this->Session->setFlash('The pamper type has been saved.', 'default', array('class' => 'success'));
			} else {
			    $this->Session->setFlash(__('The pamper type could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                    $this->Session->setFlash(__('Pamper type already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		} 
		else 
		{
		   $options = array('conditions' => array('PamperType.' . $this->PamperType->primaryKey => $id));
		   $this->request->data = $this->PamperType->find('first', $options);
		}
		$this->set(compact('title_for_layout'));
	}
	
        public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		$this->PamperType->id = $id;
		if (!$this->PamperType->exists()) {
		  throw new NotFoundException(__('Invalid pamper type.'));
		}
		if ($this->PamperType->delete($id)) {
			$this->Session->setFlash('The pamper type has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The pamper type could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'list'));
	}


}

