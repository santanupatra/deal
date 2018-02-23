<?php
App::uses('AppController', 'Controller');
/**
 * InboxMessages Controller
 *
 * @property InboxMessage $InboxMessage
 * @property PaginatorComponent $Paginator
 */
class InboxMessagesController extends AppController {

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
		$this->InboxMessage->recursive = 0;
		$this->set('inboxMessages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->InboxMessage->exists($id)) {
			throw new NotFoundException(__('Invalid inbox message'));
		}
		$options = array('conditions' => array('InboxMessage.' . $this->InboxMessage->primaryKey => $id));
		$this->set('inboxMessage', $this->InboxMessage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InboxMessage->create();
			if ($this->InboxMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The inbox message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inbox message could not be saved. Please, try again.'));
			}
		}
		$users = $this->InboxMessage->User->find('list');
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
		if (!$this->InboxMessage->exists($id)) {
			throw new NotFoundException(__('Invalid inbox message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->InboxMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The inbox message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inbox message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('InboxMessage.' . $this->InboxMessage->primaryKey => $id));
			$this->request->data = $this->InboxMessage->find('first', $options);
		}
		$users = $this->InboxMessage->User->find('list');
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
		$this->InboxMessage->id = $id;
		if (!$this->InboxMessage->exists()) {
			throw new NotFoundException(__('Invalid inbox message'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->InboxMessage->delete()) {
			$this->Session->setFlash(__('The inbox message has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inbox message could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
