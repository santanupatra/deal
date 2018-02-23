<?php
App::uses('AppController', 'Controller');
/**
 * Availabilities Controller
 *
 * @property Availability $Availability
 * @property PaginatorComponent $Paginator
 */
class AvailabilitiesController extends AppController {

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
		$this->Availability->recursive = 0;
		$this->set('availabilities', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Availability->exists($id)) {
			throw new NotFoundException(__('Invalid availability'));
		}
		$options = array('conditions' => array('Availability.' . $this->Availability->primaryKey => $id));
		$this->set('availability', $this->Availability->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Availability->create();
			if ($this->Availability->save($this->request->data)) {
				$this->Session->setFlash(__('The availability has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The availability could not be saved. Please, try again.'));
			}
		}
		$users = $this->Availability->User->find('list');
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
		if (!$this->Availability->exists($id)) {
			throw new NotFoundException(__('Invalid availability'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Availability->save($this->request->data)) {
				$this->Session->setFlash(__('The availability has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The availability could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Availability.' . $this->Availability->primaryKey => $id));
			$this->request->data = $this->Availability->find('first', $options);
		}
		$users = $this->Availability->User->find('list');
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
		$this->Availability->id = $id;
		if (!$this->Availability->exists()) {
			throw new NotFoundException(__('Invalid availability'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Availability->delete()) {
			$this->Session->setFlash(__('The availability has been deleted.'));
		} else {
			$this->Session->setFlash(__('The availability could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
