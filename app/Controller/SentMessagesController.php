<?php
App::uses('AppController', 'Controller');
/**
 * SentMessages Controller
 *
 * @property SentMessage $SentMessage
 * @property PaginatorComponent $Paginator
 */
class SentMessagesController extends AppController {

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
		$this->SentMessage->recursive = 0;
		$this->set('sentMessages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SentMessage->exists($id)) {
			throw new NotFoundException(__('Invalid sent message'));
		}
		$options = array('conditions' => array('SentMessage.' . $this->SentMessage->primaryKey => $id));
		$this->set('sentMessage', $this->SentMessage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SentMessage->create();
			if ($this->SentMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The sent message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sent message could not be saved. Please, try again.'));
			}
		}
		$users = $this->SentMessage->User->find('list');
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
		if (!$this->SentMessage->exists($id)) {
			throw new NotFoundException(__('Invalid sent message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SentMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The sent message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sent message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SentMessage.' . $this->SentMessage->primaryKey => $id));
			$this->request->data = $this->SentMessage->find('first', $options);
		}
		$users = $this->SentMessage->User->find('list');
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
		$this->SentMessage->id = $id;
		if (!$this->SentMessage->exists()) {
			throw new NotFoundException(__('Invalid sent message'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SentMessage->delete()) {
			$this->Session->setFlash(__('The sent message has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sent message could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
