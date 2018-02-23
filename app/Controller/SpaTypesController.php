<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class SpaTypesController extends AppController {



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
	
	  $title_for_layout = 'SpaType List';
          $this->paginate = array(
		'order' => array(
			'SpaType.id' => 'desc'
		)
	  );
          $this->Paginator->settings = $this->paginate;
	  $this->set('spatypes', $this->Paginator->paginate());
	  $this->set(compact('title_for_layout'));
	}

        public function admin_add() {
          $title_for_layout = 'SpaType Add';
	  $userid = $this->Session->read('Auth.User.id');
	  if(!isset($userid) && $userid=='')
	  {
	    $this->redirect('/admin');
	  }
	  if ($this->request->is(array('post', 'put'))) {
		$options = array('conditions' => array('SpaType.name'  => $this->request->data['SpaType']['name']));
		$spatypeexists = $this->SpaType->find('first', $options);
                if(!$spatypeexists)
	        {
			$this->SpaType->create();
                        if ($this->SpaType->save($this->request->data))
			{
			   $this->Session->setFlash('The spa type added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	        }
	       else
	        {
	          $this->Session->setFlash(__('Spa type already exists. Please, try another.', 'default', array('class' => 'error')));
	        }
	    }
	    $this->set(compact('title_for_layout'));
	}


	public function admin_edit($id = null) 
	{
            $title_for_layout = 'SpaType Edit';
            $userid = $this->Session->read('Auth.User.id');
	    if(!isset($userid) && $userid=='')
	    {
		$this->redirect('/admin');
	    }	
	    if (!$this->SpaType->exists($id)) {
		throw new NotFoundException(__('Invalid spa type.'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
		  $options = array('conditions' => array('SpaType.name'  => $this->request->data['SpaType']['name'],'SpaType.id !='=>$this->request->data['SpaType']['id']));
		  $spatypeexists = $this->SpaType->find('first', $options); 
                  if(!$spatypeexists)
	          {
			if ($this->SpaType->save($this->request->data)) {
			    $this->Session->setFlash('The spa type has been saved.', 'default', array('class' => 'success'));
			} else {
			    $this->Session->setFlash(__('The spa type could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                    $this->Session->setFlash(__('Spa type already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		} 
		else 
		{
		   $options = array('conditions' => array('SpaType.' . $this->SpaType->primaryKey => $id));
		   $this->request->data = $this->SpaType->find('first', $options);
		}
		$this->set(compact('title_for_layout'));
	}
	
        public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		$this->SpaType->id = $id;
		if (!$this->SpaType->exists()) {
		  throw new NotFoundException(__('Invalid spa type.'));
		}
		if ($this->SpaType->delete($id)) {
			$this->Session->setFlash('The spa type has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The spa type could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'list'));
	}


}

