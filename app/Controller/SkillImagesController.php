<?php
App::uses('AppController', 'Controller');
/**
 * SkillImages Controller
 *
 * @property SkillImage $SkillImage
 * @property PaginatorComponent $Paginator
 */
class SkillImagesController extends AppController {

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
		$this->SkillImage->recursive = 0;
		$this->set('skillImages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SkillImage->exists($id)) {
			throw new NotFoundException(__('Invalid skill image'));
		}
		$options = array('conditions' => array('SkillImage.' . $this->SkillImage->primaryKey => $id));
		$this->set('skillImage', $this->SkillImage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SkillImage->create();
			if ($this->SkillImage->save($this->request->data)) {
				$this->Session->setFlash(__('The skill image has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill image could not be saved. Please, try again.'));
			}
		}
		$skills = $this->SkillImage->Skill->find('list');
		$this->set(compact('skills'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SkillImage->exists($id)) {
			throw new NotFoundException(__('Invalid skill image'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SkillImage->save($this->request->data)) {
				$this->Session->setFlash(__('The skill image has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill image could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SkillImage.' . $this->SkillImage->primaryKey => $id));
			$this->request->data = $this->SkillImage->find('first', $options);
		}
		$skills = $this->SkillImage->Skill->find('list');
		$this->set(compact('skills'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SkillImage->id = $id;
		if (!$this->SkillImage->exists()) {
			throw new NotFoundException(__('Invalid skill image'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SkillImage->delete()) {
			$this->Session->setFlash(__('The skill image has been deleted.'));
		} else {
			$this->Session->setFlash(__('The skill image could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
