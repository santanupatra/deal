<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class CountriesController extends AppController {



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
	
	  $title_for_layout = 'Country List';
          $this->paginate = array(
		'order' => array(
			'Country.id' => 'desc'
		)
	  );
          $this->Paginator->settings = $this->paginate;
	  $this->set('countries', $this->Paginator->paginate());
	  $this->set(compact('title_for_layout'));
	}

        public function admin_add() {
          $title_for_layout = 'Country Add';
	  $userid = $this->Session->read('Auth.User.id');
	  if(!isset($userid) && $userid=='')
	  {
	    $this->redirect('/admin');
	  }
	  if ($this->request->is(array('post', 'put'))) {
		$options = array('conditions' => array('Country.name'  => $this->request->data['Country']['name']));
		$countryexists = $this->Country->find('first', $options);
                if(!$countryexists)
	        {
			$this->Country->create();
                        if ($this->Country->save($this->request->data))
			{
			   $this->Session->setFlash('The country added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	        }
	       else
	        {
	          $this->Session->setFlash(__('Country already exists. Please, try another.', 'default', array('class' => 'error')));
	        }
	    }
	    $this->set(compact('title_for_layout'));
	}


	public function admin_edit($id = null) 
	{
            $title_for_layout = 'Country Edit';
            $userid = $this->Session->read('Auth.User.id');
	    if(!isset($userid) && $userid=='')
	    {
		$this->redirect('/admin');
	    }	
	    if (!$this->Country->exists($id)) {
		throw new NotFoundException(__('Invalid country.'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
		  $options = array('conditions' => array('Country.name'  => $this->request->data['Country']['name'],'Country.id !='=>$this->request->data['Country']['id']));
		  $countryexists = $this->Country->find('first', $options); 
                  if(!$countryexists)
	          {
			if ($this->Country->save($this->request->data)) {
			    $this->Session->setFlash('The country has been saved.', 'default', array('class' => 'success'));
			} else {
			    $this->Session->setFlash(__('The country could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                    $this->Session->setFlash(__('Country already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		} 
		else 
		{
		   $options = array('conditions' => array('Country.' . $this->Country->primaryKey => $id));
		   $this->request->data = $this->Country->find('first', $options);
		}
		$this->set(compact('title_for_layout'));
	}
	
        public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}
		$this->Country->id = $id;
		if (!$this->Country->exists()) {
		  throw new NotFoundException(__('Invalid country.'));
		}
		if ($this->Country->delete($id)) {
			$this->Session->setFlash('The country has been deleted.', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The country could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'list'));
	}


}

