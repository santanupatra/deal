<?php
App::uses('AppController', 'Controller');
/**
 * CarCategories Controller
 *
 * @property EmailTemplate $EmailTemplate
 * @property PaginatorComponent $Paginator
 */
class FaqsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('faq');
   }

/**
 * index method
 *
 * @return void
 */


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Faq->create();
			if ($this->Faq->save($this->request->data)) {
				$this->Session->setFlash('The faq has been saved.','default', array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faq template could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		//$this->request->onlyAllow('post', 'delete');
		if ($this->Faq->delete()) {
		    //$this->UserImage->delete()
			$this->Session->setFlash('The faq has been deleted.','default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('The faq could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_index() {

            $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'Faq List';
		 $this->paginate = array(
			'order' => array(
		        'Faq.id' => 'desc'
			)
		);
		//$this->Carcategory->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		$this->set('allfaq', $this->Paginator->paginate());
		$this->set(compact('title_for_layout'));
	}

	public function admin_edit($id = null) {
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}

		if ($this->request->is(array('post', 'put'))) {

                        $this->request->data['Faq']['id']=$id;

                        //print_r($this->request->data);
                        //exit;

			if ($this->Faq->save($this->request->data)) {

                         $this->Session->setFlash('The faq has been saved.','default', array('class' => 'success'));
                         return $this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('The faq could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$faq = $this->Faq->find('first', $options);
                        $this->set(compact('faq'));
		}
	}


        public function faq() {


            $options1 = array('conditions' => array('Faq.is_active' => 1));
            $faqs = $this->Faq->find('all', $options1);

            //print_r($faqs);
            //exit;
            $this->set(compact('faqs'));


        }


}
