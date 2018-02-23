<?php
App::uses('AppController', 'Controller');
/**
 * PreviousMakings Controller
 *
 * @property PreviousMaking $PreviousMaking
 * @property PaginatorComponent $Paginator
 */
class PreviousMakingsController extends AppController {

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
		$this->PreviousMaking->recursive = 0;
		$this->set('previousMakings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PreviousMaking->exists($id)) {
			throw new NotFoundException(__('Invalid previous making'));
		}
		$options = array('conditions' => array('PreviousMaking.' . $this->PreviousMaking->primaryKey => $id));
		$this->set('previousMaking', $this->PreviousMaking->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PreviousMaking->create();
			if ($this->PreviousMaking->save($this->request->data)) {
				$this->Session->setFlash(__('The previous making has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The previous making could not be saved. Please, try again.'));
			}
		}
		$users = $this->PreviousMaking->User->find('list');
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
		if (!$this->PreviousMaking->exists($id)) {
			throw new NotFoundException(__('Invalid previous making'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PreviousMaking->save($this->request->data)) {
				$this->Session->setFlash(__('The previous making has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The previous making could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PreviousMaking.' . $this->PreviousMaking->primaryKey => $id));
			$this->request->data = $this->PreviousMaking->find('first', $options);
		}
		$users = $this->PreviousMaking->User->find('list');
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
		$this->PreviousMaking->id = $id;
		if (!$this->PreviousMaking->exists()) {
			throw new NotFoundException(__('Invalid previous making'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PreviousMaking->delete()) {
			$this->Session->setFlash(__('The previous making has been deleted.'));
		} else {
			$this->Session->setFlash(__('The previous making could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
