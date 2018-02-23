<?php

App::uses('AppController', 'Controller');

/**

 * Contents Controller

 *

 * @property Content $Content

 * @property PaginatorComponent $Paginator

 */

class CitiesController extends AppController {



/**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');
        var $uses=array('City','State','Country','Area');

	

	public function admin_list() {		
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
			$this->redirect('/admin');
		}
		$title_for_layout = 'City List';
                $this->paginate = array(
			'order' => array(
				'City.id' => 'desc'
			)
		);
		$this->City->recursive = 0;
                $this->Paginator->settings = $this->paginate;
		$this->set('cities', $this->Paginator->paginate());
		$this->set(compact('title_for_layout'));
	}

        public function admin_add() {
		$title_for_layout = 'City Add';
		$userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		    $this->redirect('/admin');
		}
		if ($this->request->is(array('post', 'put'))) {
		    $options = array('conditions' => array('City.name'  => $this->request->data['City']['name'],'City.country_id'  => $this->request->data['City']['country_id'],'City.state_id'  => $this->request->data['City']['state_id']));
		    $cityexists = $this->City->find('first', $options);
                    if(!$cityexists)
	            {
			$this->City->create();
                        if ($this->City->save($this->request->data))
			{
			   $this->Session->setFlash('The city added successfully.', 'default', array('class' => 'success'));
			   return $this->redirect(array('action' => 'list'));
			}
	            }
		    else
		    {
			 $this->Session->setFlash(__('City already exists. Please, try another.', 'default', array('class' => 'error')));
		    }
	        }
                $optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
	        $this->set(compact('allcountries','title_for_layout'));
	}


	public function admin_edit($id = null) {
                $title_for_layout = 'City Edit';
                $userid = $this->Session->read('Auth.User.id');
		if(!isset($userid) && $userid=='')
		{
		   $this->redirect('/admin');
		}	
		if (!$this->City->exists($id)) {
		   throw new NotFoundException(__('Invalid city.'));
		}

		if ($this->request->is(array('post', 'put'))) 
		{
		  $options = array('conditions' => array('City.name'  => $this->request->data['City']['name'],'City.country_id'  => $this->request->data['City']['country_id'],'City.state_id'  => $this->request->data['City']['state_id'],'City.id !='=>$this->request->data['City']['id']));
		  $cityexists = $this->City->find('first', $options); 

                  if(!$cityexists)
	          {
			if ($this->City->save($this->request->data)) {
			   $this->Session->setFlash('The city has been saved.', 'default', array('class' => 'success'));
			} else {
			   $this->Session->setFlash(__('The city could not be saved. Please, try again.'));
			}
		 }
                 else
		 {
                       $this->Session->setFlash(__('City already exists. Please, try another.', 'default', array('class' => 'error')));
		 }
		  $options = array('conditions' => array('City.' . $this->City->primaryKey => $this->request->data['City']['id']));
		  $this->request->data = $this->City->find('first', $options);
		  $cntryid=$this->request->data['City']['country_id'];
		} else {
		    $options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
		    $this->request->data = $this->City->find('first', $options);
		    $cntryid=$this->request->data['City']['country_id'];
		}
		
		$optioncountry = array('conditions' => array('Country.is_active'  => 1));
                $allcountries = $this->Country->find('all',$optioncountry);
                $optionstate = array('conditions' => array('State.is_active'  => 1,'State.country_id'=>$cntryid));
                $allstates = $this->State->find('all',$optionstate);
	        $this->set(compact('allcountries','title_for_layout','allstates'));
	}
	
        public function admin_delete($id = null) {
	   $userid = $this->Session->read('Auth.User.id');
	   if(!isset($userid) && $userid=='')
	   {
		$this->redirect('/admin');
	   }
	   $this->City->id = $id;
	   if (!$this->City->exists()) {
	      throw new NotFoundException(__('Invalid city.'));
	   }
	   if ($this->City->delete($id)) {
		$this->Session->setFlash('The city has been deleted.', 'default', array('class' => 'success'));
	   } else {
		$this->Session->setFlash(__('The city could not be deleted. Please, try again.'));
	   }
	   return $this->redirect(array('action' => 'list'));
	}
	
	public function get_states()
	{
	  $statestr="<option value=''>Select State</option>";
	  $this->State->recursive = -1;
	  $country_id=$_POST['country_id'];
	  $optionstate = array('conditions' => array('State.is_active'  => 1,'State.country_id'  => $country_id));
          $allstates = $this->State->find('all',$optionstate);
          foreach($allstates as $allstate)
          {
            $statestr.="<option value='".$allstate['State']['id']."'>".$allstate['State']['name']."</option>";
          }
          echo $statestr;exit;
	}	
	
	public function get_cities()
	{
	  $citystr="<option value=''>Select City</option>";
	  $this->City->recursive = -1;
	  $state_id=$_POST['state_id'];
	  $optioncity = array('conditions' => array('City.is_active'  => 1,'City.state_id'  => $state_id));
          $allcities = $this->City->find('all',$optioncity);
          foreach($allcities as $allcity)
          {
            $citystr.="<option value='".$allcity['City']['id']."'>".$allcity['City']['name']."</option>";
          }
          echo $citystr;exit;
	}
	
	public function get_areas()
	{
	  $areastr="<option value=''>Select Area</option>";
	  $this->Area->recursive = -1;
	  $city_id=$_POST['city_id'];
	  $optionarea = array('conditions' => array('Area.is_active'  => 1,'Area.city_id'  => $city_id));
          $allareas = $this->Area->find('all',$optionarea);
          foreach($allareas as $allarea)
          {
            $areastr.="<option value='".$allarea['Area']['id']."'>".$allarea['Area']['name']."</option>";
          }
          echo $areastr;exit;
	}	
	
	public function get_states_edit()
	{
	  $statestr="<option value=''>Select State</option>";
	  $this->State->recursive = -1;
	  $country_id=$_POST['country_id'];
	  $optionstate = array('conditions' => array('State.is_active'  => 1,'State.country_id'  => $country_id));
          $allstates = $this->State->find('all',$optionstate);
          $select = '';
		  foreach($allstates as $allstate)
          {
            $select = ($allstate['State']['id']==$_POST['state_id'])?'Selected':'';
			$statestr .="<option value='".$allstate['State']['id']."' ".$select.">".$allstate['State']['name']."</option>";
          }
          echo $statestr;exit;
	}	
	
	public function get_cities_edit()
	{
	  $citystr="<option value=''>Select City</option>";
	  $this->City->recursive = -1;
	  $state_id=$_POST['state_id'];
	  //echo $_POST['city_id'];
	  $optioncity = array('conditions' => array('City.is_active'  => 1,'City.state_id'  => $state_id));
          $allcities = $this->City->find('all',$optioncity);
          $selectct = '';
		  foreach($allcities as $allcity)
          {
             $selectct = ($allcity['City']['id']==$_POST['city_id'])?'Selected':'';
			$citystr.="<option value='".$allcity['City']['id']."' ".$selectct.">".$allcity['City']['name']."</option>";
          }
          echo $citystr;exit;
	}
	
	public function get_areas_edit()
	{
	  $areastr="<option value=''>Select Area</option>";
	  $this->Area->recursive = -1;
	  $city_id=$_POST['city_id'];
	  $optionarea = array('conditions' => array('Area.is_active'  => 1,'Area.city_id'  => $city_id));
          $allareas = $this->Area->find('all',$optionarea);
          $select = '';
		  foreach($allareas as $allarea)
          {
            $select = ($allarea['Area']['id']==$_POST['area_id'])?'Selected':'';
			$areastr.="<option value='".$allarea['Area']['id']."' ".$select.">".$allarea['Area']['name']."</option>";
          }
          echo $areastr;exit;
	}

}

