<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class PackagesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('getsubcat','advertisement_viewcount','total_sale_range','total_sale_range_monthly','total_sale_range_yearly','payment_process','purchase_payment');
	}
        

/**
 * index method
 *
 * @return void
 */
	/*public function index() {
		$this->Package->recursive = 0;
		$this->set('categories', $this->Paginator->paginate());
	}*/
	
	public function admin_index() {		
            $title_for_layout = 'Package List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }
            $this->Paginator->settings = array(
                'limit' =>15,
                'order' => array(
                   'Package.id' => 'asc'
                )
            );
            $this->set('packages_list', $this->Paginator->paginate('Package'));
            $this->set(compact('title_for_layout'));
	}
        
        /*public function admin_saveorder() {
            $this->autoRender = false;
            $cat_order=$this->request->data['cat_order'];
            $Sl_cnt=0;
            if(count($cat_order)>0){
                foreach($cat_order as $val){
                    $Sl_cnt++;
                    $data_cat['Category']['id']=$val;
                    $data_cat['Category']['ordering']=$Sl_cnt;
                    $this->Category->save($data_cat);    
		}
            }
	}*/

	public function admin_add() {			
            $title_for_layout = 'Package Add';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }
            if ($this->request->is('post')) {
                $options = array('conditions' => array('Package.name'  => $this->request->data['Package']['name']));
                $name = $this->Package->find('first', $options);
                if(!$name){
                    if ($this->Package->save($this->request->data)) {
                        $this->Session->setFlash('The package name has been saved.', 'default', array('class' => 'success'));
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The package name could not be saved. Please, try again.'));
                    }

                } else {
                    $this->Session->setFlash(__('The package name already exists. Please, try again.'));
                }
            }

            $this->set(compact('title_for_layout'));
	}

	public function admin_edit($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }

            if (!$this->Package->exists($id)){
                throw new NotFoundException(__('Invalid package'));
            }

            if ($this->request->is(array('post', 'put'))){
                $options = array('conditions' => array('Package.name'  => $this->request->data['Package']['name'], 'Package.id <>'=>$id));
                $name = $this->Package->find('first', $options);
                    
                if(!$name){

                    //$this->request->data['Category']['id']=$id;

                    if ($this->Package->save($this->request->data)){                    
                        $this->Session->setFlash('The package name has been saved.', 'default', array('class' => 'success'));
                        return $this->redirect(array('action' => 'index')); 
                    } else {
                        $this->Session->setFlash(__('The package name could not be saved. Please, try again.'));
                    }
                }else{
                    $this->Session->setFlash(__('The package name already exists. Please, try again.'));
                }
            } 
			
            $options = array('conditions' => array('Package.'.$this->Package->primaryKey => $id));
            $this->request->data = $this->Package->find('first', $options);
            $this->set(compact('title_for_layout'));
	}


	public function admin_delete($id = null) {
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }
            $this->Package->id = $id;
            if (!$this->Package->exists()) {
                throw new NotFoundException(__('Invalid package name'));
            }

            if ($this->Package->delete($id)) {
                $this->Session->setFlash('The package name has been deleted.', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('The package name could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
	}
        
        public function admin_advertisement() {
            $title_for_layout = 'Advertisement List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }
            $this->loadModel('Advertisement');
            $this->Paginator->settings = array(
                'conditions'=> array(),
                'limit' =>15,
                'order' => array(
                   'Advertisement.id' => 'desc'
                )
            );
            
            $this->set('advertisement_list', $this->Paginator->paginate('Advertisement'));
            $this->set(compact('title_for_layout'));
	}
        
	public function admin_advertisement_edit($id=null) {
            $title_for_layout = 'Advertisement Edit';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/admin');
            }
            $this->loadModel('Advertisement');
            if ($this->request->is(array('post', 'put'))){
                if ($this->Advertisement->save($this->request->data)){                    
                    $this->Session->setFlash('The advertisement data successfully updated.', 'default', array('class' => 'success'));
                    return $this->redirect(array('action' => 'admin_advertisement')); 
                } else {
                    $this->Session->setFlash(__('The advertisement data could not be saved. Please, try again.'));
                }
            } 
            $Advertisement_det = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$id)));
            if(count($Advertisement_det)==0){
                $this->redirect('/admin/packages/advertisement');
            }
            $this->request->data =$Advertisement_det;
            $this->set(compact('title_for_layout','Advertisement_det'));
	}
        
        public function advertisement() {
            $title_for_layout = 'Advertisement List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Advertisement');
            $this->Paginator->settings = array(
                'conditions'=> array('Advertisement.user_id'=> $userid),
                'limit' =>15,
                'order' => array(
                   'Advertisement.id' => 'desc'
                )
            );
            
            $this->set('advertisement_list', $this->Paginator->paginate('Advertisement'));
            $this->set(compact('title_for_layout'));
	}
        
	public function advertisement_add() {
            $title_for_layout = 'Advertisement Add';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Advertisement');
	    $alldates = array();
	    $alldatesbtm = array();
	    $st_dates = $this->Advertisement->find('all',array('fields'=>array('start_date','end_date'),'conditions'=>array('Advertisement.is_paid'=>1, 'Advertisement.is_active'=>1,'Advertisement.page_position'=>'top')));
	  // pr($st_dates);
	    $datecount = count($st_dates);
	   // echo $datecount;
	    foreach($st_dates as $key=>$dates){
		//echo $key;
	       $start_date = date('Y-m-d',  strtotime($dates['Advertisement']['start_date']));
	       $end_date = date('Y-m-d',strtotime($dates['Advertisement']['end_date']));
	       $no_of_days = (strtotime($end_date) - strtotime($start_date))/(24*3600);
	       //echo $no_of_days.'<br>';
	      
	       
		$alldates[]=$start_date;
		    for($i=1;$i<=$no_of_days;$i++){
			$next_date='';
			$next_date = date('Y-m-d',  strtotime('+'.$i.' day',strtotime($start_date)));
			$alldates[]=$next_date;
		    }
		
		    if(($key+1) < $datecount){
			//echo "hiiii";
			$nxt_start_date = date('Y-m-d',  strtotime($st_dates[$key+1]['Advertisement']['start_date']));
			$curr_end_date = date('Y-m-d',  strtotime($st_dates[$key]['Advertisement']['end_date']));
			$datediff = (strtotime($nxt_start_date) - strtotime($curr_end_date))/(24*3600);
		//echo $datediff;
			if($datediff < 30){
			    for($j=1;$j<=$datediff;$j++){
				$next_date1='';
				$next_date1 = date('Y-m-d',  strtotime('+'.$j.' day',strtotime($curr_end_date)));
				$alldates[]=$next_date1;
			    }
			}
		    }
		
	    }
	    $allbdates = implode('", "',array_unique($alldates));
	    
	    $st_datesbtm = $this->Advertisement->find('all',array('fields'=>array('start_date','end_date'),'conditions'=>array('Advertisement.is_paid'=>1, 'Advertisement.is_active'=>1,'Advertisement.page_position'=>'bottom')));
	  // pr($st_dates);
	    $datecountbtm = count($st_datesbtm);
	   // echo $datecount;
	    foreach($st_datesbtm as $key1=>$dates1){
		//echo $key;
	       $start_datebtm = date('Y-m-d',  strtotime($dates1['Advertisement']['start_date']));
	       $end_datebtm = date('Y-m-d',strtotime($dates1['Advertisement']['end_date']));
	       $no_of_daysbtm = (strtotime($end_datebtm) - strtotime($start_datebtm))/(24*3600);
	       //echo $no_of_days.'<br>';
	      
	       
		$alldatesbtm[]=$start_datebtm;
		    for($i=1;$i<=$no_of_daysbtm;$i++){
			$next_datebtm='';
			$next_datebtm = date('Y-m-d',  strtotime('+'.$i.' day',strtotime($start_datebtm)));
			$alldatesbtm[]=$next_datebtm;
		    }
		
		    if(($key1+1) < $datecountbtm){
			//echo "hiiii";
			$nxt_start_datebtm = date('Y-m-d',  strtotime($st_datesbtm[$key1+1]['Advertisement']['start_date']));
			$curr_end_datebtm = date('Y-m-d',  strtotime($st_datesbtm[$key1]['Advertisement']['end_date']));
			$datediffbtm = (strtotime($nxt_start_datebtm) - strtotime($curr_end_datebtm))/(24*3600);
		//echo $datediff;
			if($datediffbtm < 30){
			    for($j=1;$j<=$datediffbtm;$j++){
				$next_date1btm='';
				$next_date1btm = date('Y-m-d',  strtotime('+'.$j.' day',strtotime($curr_end_datebtm)));
				$alldatesbtm[]=$next_date1btm;
			    }
			}
		    }
		
	    }
	    $allbdatesbtm = implode('", "',array_unique($alldatesbtm));
	   
	    
            $Vat_per= Configure::read('VAT_PER');
            $options = array('conditions' => array('Package.status'=> 1));
            $package_list = $this->Package->find('all', $options);
            //App::import('Helper', 'Resize');
            //$resize = new ResizeHelper(new View(null));
            if ($this->request->is('post')) {
		pr($this->request->data);
                if(isset($this->request->data['Advertisement']['image']) && $this->request->data['Advertisement']['image']['name']!=''){	
		    $ext = explode('.',$this->request->data['Advertisement']['image']['name']);
                    if($ext){
                        $ptype=isset($this->request->data['Advertisement']['ptype'])?$this->request->data['Advertisement']['ptype']:array();
                        if(count($ptype)>0){
                            if(count($ptype)==1){
                                $this->request->data['Advertisement']['type']=$ptype[0];
                            }elseif(count($ptype)==2){
                                $this->request->data['Advertisement']['type']=3;
                            }else{
                                $this->request->data['Advertisement']['type']=1;
                            }
                        }
                        
                        $package_id=$this->request->data['Advertisement']['package_id'];
                        $package_det = $this->Package->find('first',array('conditions'=>array('Package.id'=>$package_id)));
                        $pkg_duration=$package_det['Package']['duration'];
                        $pkg_price=$package_det['Package']['price'];
                        $Price_cal=$pkg_price+(($pkg_price*$Vat_per)/100);
                        
                        $end_date=gmdate('Y-m-d H:i:s', strtotime("+".$pkg_duration." month",strtotime($this->request->data['start_date'])));
                        $sdate = gmdate('Y-m-d H:i:s', strtotime($this->request->data['start_date']));
                        $uploadFolderbanner = "advertisement";
                        $uploadPath = WWW_ROOT . $uploadFolderbanner;
                        $extensionValid = array('JPG','JPEG','jpg','jpeg','png','gif');
                        if(in_array($ext[1],$extensionValid)){
                            $imageName = rand(1000,99999)."_".strtolower(trim($this->request->data['Advertisement']['image']['name']));
                            $full_image_path = $uploadPath . '/' . $imageName;
                            move_uploaded_file($this->request->data['Advertisement']['image']['tmp_name'],$full_image_path);
                            /********** resize *******/
				/*$max_height = "200";
				$size = getimagesize($full_image_path);
				$width = $size[0];
				$height = $size[1];
				if ($height > $max_height){
				    $scale = $max_height/$height;
				    $uploaded = $this->resizeImage($full_image_path,$width,$height,$scale);
				}else{
				    $scale = 1;
				    $uploaded = $this->resizeImage($full_image_path,$width,$height,$scale);
				}*/
				
				$max_width = "263";
				$size = getimagesize($full_image_path);
				$width = $size[0];
				$height = $size[1];
				if ($width > $max_width){
				    $scale = $max_width/$width;
				    $uploaded = $this->resizeImage($full_image_path,$width,$height,$scale);
				}else{
				    $scale = 1;
				    $uploaded = $this->resizeImage($full_image_path,$width,$height,$scale);
				}
			    /********* resize ***********/
				/*if($full_image_path){
				    unlink($full_image_path);
				}*/
                           //pr($uploaded);exit;
                            move_uploaded_file($uploaded,$full_image_path);
                            $this->request->data['Advertisement']['image_name'] = $imageName;
                            $this->request->data['Advertisement']['user_id'] = $userid;
                            $this->request->data['Advertisement']['package_id'] = $package_id;
                            $this->request->data['Advertisement']['amount'] = $Price_cal;
                            $this->request->data['Advertisement']['start_date'] = $sdate;
                            $this->request->data['Advertisement']['end_date'] = $end_date;
                            $this->request->data['Advertisement']['is_paid'] = 0;
                            $this->request->data['Advertisement']['is_active'] = 0;
                            $this->request->data['Advertisement']['cdate'] = gmdate('Y-m-d');
			   // pr($this->request->data);exit;
                            $this->Advertisement->create();			 
                            $this->Advertisement->save($this->request->data);
                            $this->Session->setFlash('You have successfully added the advertisement.', 'default', array('class' => 'success'));
                            $lstid = $this->Advertisement->getLastInsertId();
                            return $this->redirect(array('controller' => 'packages', 'action' => 'advertisement_details',  base64_encode($lstid)));
                        }else {
                            $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                        } 
                    } else {
                        $this->Session->setFlash(__('Please uploade image of .jpg, .jpeg, .png or .gif format.'));
                    }
                }
            }
            $this->set(compact('title_for_layout','package_list','allbdates','allbdatesbtm'));
	}
        
	public function resizeImage($image,$width,$height,$scale) {
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);
            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                case "image/gif":
                    $source=imagecreatefromgif($image); 
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source=imagecreatefromjpeg($image); 
                    break;
                case "image/png":
                case "image/x-png":
                    $source=imagecreatefrompng($image); 
                    break;
            }
	    
            imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

            switch($imageType) {
                case "image/gif":
                    imagegif($newImage,$image); 
                    break;
		case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$image,90); 
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$image);  
                    break;
            }

            chmod($image, 0777);
            return $image;
        }
	
        public function advertisement_details($id=null) {
            $title_for_layout = 'Advertisement Details';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Advertisement');
            $adv_id=  base64_decode($id);
            $Advertisement_det = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$adv_id)));
            if(count($Advertisement_det)==0){
                $this->redirect('/packages/advertisement');
            }
            $this->set(compact('title_for_layout','Advertisement_det'));
	}
        
	public function advertisement_renew($id=null) {
            $title_for_layout = 'Advertisement Renew';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
            $this->loadModel('Advertisement');
	    $alldates = array();
	    $st_dates = $this->Advertisement->find('all',array('fields'=>array('start_date','end_date'),'conditions'=>array('Advertisement.is_paid'=>1, 'Advertisement.is_active'=>1)));
	  // pr($st_dates);
	    $datecount = count($st_dates);
	   // echo $datecount;
	    foreach($st_dates as $key=>$dates){
		//echo $key;
	       $start_date = date('Y-m-d',  strtotime($dates['Advertisement']['start_date']));
	       $end_date = date('Y-m-d',strtotime($dates['Advertisement']['end_date']));
	       $no_of_days = (strtotime($end_date) - strtotime($start_date))/(24*3600);
	       //echo $no_of_days.'<br>';
	      
	       
		$alldates[]=$start_date;
		    for($i=1;$i<=$no_of_days;$i++){
			$next_date='';
			$next_date = date('Y-m-d',  strtotime('+'.$i.' day',strtotime($start_date)));
			$alldates[]=$next_date;
		    }
		
		    if(($key+1) < $datecount){
			//echo "hiiii";
			$nxt_start_date = date('Y-m-d',  strtotime($st_dates[$key+1]['Advertisement']['start_date']));
			$curr_end_date = date('Y-m-d',  strtotime($st_dates[$key]['Advertisement']['end_date']));
			$datediff = (strtotime($nxt_start_date) - strtotime($curr_end_date))/(24*3600);
		//echo $datediff;
			if($datediff < 30){
			    for($j=1;$j<=$datediff;$j++){
				$next_date1='';
				$next_date1 = date('Y-m-d',  strtotime('+'.$j.' day',strtotime($curr_end_date)));
				$alldates[]=$next_date1;
			    }
			}
		    }
		
	    }
	    $allbdates = implode('", "',array_unique($alldates));
            $adv_id=  base64_decode($id);
            $Advertisement_det = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$adv_id)));
            if(count($Advertisement_det)==0){
                $this->redirect('/packages/advertisement');
            }
	    
	    $options = array('conditions' => array('Package.status'=> 1));
            $package_list = $this->Package->find('all', $options);
            $this->set(compact('title_for_layout','Advertisement_det','allbdates','package_list'));
	}
	
        public function payment_success(){
            $this->loadModel('Payment');
            $this->loadModel('Advertisement');
            $userid = $this->Session->read('Auth.User.id');
            $custom_data=$this->request->data['custom'];
            $adv_id=  base64_decode($custom_data);
            $this->Advertisement->id = $adv_id;
            if (!$this->Advertisement->exists()) {
                $this->redirect('/packages/advertisement');
            }
            $Advertisement_det = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$adv_id)));
            $pkg_duration=$Advertisement_det['Package']['duration'];
            $end_date=gmdate('Y-m-d H:i:s', strtotime("+".$pkg_duration." month"));
            
            if($custom_data!=''){
                $data = array();
                $data['Payment']['userid'] =  $userid;
                $data['Payment']['datetime'] =  gmdate('Y-m-d H:i:s');
                $data['Payment']['amount'] = $this->request->data['payment_gross'];
                $data['Payment']['transaction_id'] = $this->request->data['txn_id'];
                $data['Payment']['status'] = $this->request->data['payment_status'];
                $data['Payment']['for'] = 'Advertisement plan';
                $data['Payment']['type'] = 1;
                $this->Payment->create();
                if($this->Payment->save($data)){
                    $arr = array();
                    $arr['Advertisement']['id'] = $adv_id;
                    $arr['Advertisement']['is_paid'] = 1;
                    $arr['Advertisement']['is_active'] = 1;
                    //$arr['Advertisement']['start_date'] = gmdate('Y-m-d H:i:s');
                    //$arr['Advertisement']['end_date'] = $end_date;
                    if($this->Advertisement->save($arr)){
                        $this->Session->setFlash('Your advertisement plan is successfully updated', 'default', array('class' => 'success'));
                        return $this->redirect(array('action' => 'advertisement'));
                    }
                }
            }else{
                $this->Session->setFlash('Your advertisement is not updated, Some Error occurs, Please try again', 'default', array('class' => 'error'));
                return $this->redirect(array('action' => 'advertisement'));
            }
        }
        
	public function payment_renew_success(){
            $this->loadModel('Payment');
            $this->loadModel('Advertisement');
            $userid = $this->Session->read('Auth.User.id');
            $custom_data=$this->request->data['custom'];
           // $adv_id=  base64_decode($custom_data);
            
            
            if($custom_data!=''){
              $custom = explode('##',$custom_data);
              $adv_id = base64_decode($custom[0]);
              $pkgid = $custom[1];
              $sdate = $custom[2];
              $edate = $custom[3];
              
                    $this->Advertisement->id = $adv_id;
                    if (!$this->Advertisement->exists()) {
                        $this->redirect('/packages/advertisement');
                    }
                    $Advertisement_det = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$adv_id)));
                    $pkg_duration=$Advertisement_det['Package']['duration'];
                    //$end_date=gmdate('Y-m-d H:i:s', strtotime("+".$pkg_duration." month",strtome()));
            
            
                $data = array();
                $data['Payment']['userid'] =  $userid;
                $data['Payment']['datetime'] =  gmdate('Y-m-d H:i:s');
                $data['Payment']['amount'] = $this->request->data['payment_gross'];
                $data['Payment']['transaction_id'] = $this->request->data['txn_id'];
                $data['Payment']['status'] = $this->request->data['payment_status'];
                $data['Payment']['for'] = 'Advertisement plan';
                $data['Payment']['type'] = 1;
                $this->Payment->create();
                if($this->Payment->save($data)){
                    $arr = array();
                    $arr['Advertisement']['id'] = $adv_id;
                    $arr['Advertisement']['package_id'] = $pkgid;
                    $arr['Advertisement']['is_paid'] = 1;
                    $arr['Advertisement']['is_active'] = 1;
                    $arr['Advertisement']['start_date'] = $sdate;
                    $arr['Advertisement']['end_date'] = $edate;
                    $arr['Advertisement']['cdate'] = gmdate('Y-m-d H:i:s');
                    if($this->Advertisement->save($arr)){
                        $this->Session->setFlash('Your advertisement plan is successfully renewed', 'default', array('class' => 'success'));
                        return $this->redirect(array('action' => 'advertisement'));
                    }
                }
            }else{
                $this->Session->setFlash('Your advertisement is not updated, Some Error occurs, Please try again', 'default', array('class' => 'error'));
                return $this->redirect(array('action' => 'advertisement'));
            }
        }
	
        public function advertisement_delete($id = null) {
            $this->loadModel('Advertisement');
            $del_id=  base64_decode($id);
            $uploadFolderbanner = "advertisement";
            $uploadPath = WWW_ROOT . $uploadFolderbanner;
            $proImage = $this->Advertisement->find('first',array('fields'=>array('id','image_name'),'conditions'=>array('Advertisement.id'=>$del_id)));
            $Prd_img=$proImage['Advertisement']['image_name'];
            
            if ($this->Advertisement->delete($del_id)) {
                if($Prd_img!='' && file_exists($uploadPath . '/' . $Prd_img)){
                    unlink($uploadPath. '/' .$Prd_img);
                }
                $this->Session->setFlash('The advertisement has been deleted.', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__('The advertisement could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'advertisement'));
        }
	
	
	
	public function getdetail($id=null){
	$Vat_per= Configure::read('VAT_PER');
	    if (!$this->Package->exists($id)){
                throw new NotFoundException(__('Invalid package'));
            }
	    
	   // $package = $this->Package->find('first',array('fields'=>array('duration'),'conditions'=>array('Package.id'=>$id)));
	    $package = $this->Package->find('first',array('conditions'=>array('Package.id'=>$id)));
	    $advTotal = $package['Package']['price'] + (($package['Package']['price']*$Vat_per)/100);
	    echo  $package['Package']['id'].'**'.$package['Package']['duration'].'**'.$package['Package']['price'].'**'.$advTotal; exit;
	}
	
	public function advertisement_viewcount($id){
	    $this->loadModel('AdvertisementReport');
            $this->loadModel('Advertisement');
            $userid = $this->Session->read('Auth.User.id');
	    if(!isset($userid)){
		$userid='';
	    }
	    $adv = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$id)));
	    if(!empty($adv)){
		$arr = array();
		$arr['AdvertisementReport']['adv_id']= $id;
		$arr['AdvertisementReport']['user_id']= $userid;
		$arr['AdvertisementReport']['ip_addr']= $_SERVER['REMOTE_ADDR'];
		$arr['AdvertisementReport']['cdate']= gmdate('Y-m-d H:i:s');
		$this->AdvertisementReport->create();
		if($this->AdvertisementReport->save($arr)){
		    $reports = $this->AdvertisementReport->find('all',array('conditions'=>array('AdvertisementReport.adv_id'=>$id)));
		    $arr1 = array();
		    $arr1['Advertisement']['id'] = $id;
		    $arr1['Advertisement']['view_count'] = count($reports);
		    if($this->Advertisement->save($arr1)){
			echo '1#'.$adv['Advertisement']['link'];exit;
		    }
		    else{
			echo '0';exit;
		    }
		}
	    }
	    else{
		echo '0';
	    }
	}
	
	public function advertisement_report() {
            $title_for_layout = 'Advertisement List';
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid) && $userid==''){
                $this->redirect('/users/signin');
            }
             $this->loadModel('AdvertisementReport');
            $this->loadModel('Advertisement');
	    $first  = strtotime('first day this month');
            $start=date("Y-m-d", strtotime("-6 days"));
            $end=date("Y-m-d", strtotime("-0 days"));
	    $mnth =  date('m', strtotime("-0 month", strtotime(date('Y-m-d'))));
	    $start_mnth = date('m', strtotime("-0 month", $first));
	    $end_mnth = date('m', strtotime("-11 month", $first));
	    $yr =  date('Y', strtotime("-0 year", strtotime(date('Y-m-d'))));
	    $start_yr =  date('Y', strtotime("-0 year", $first));
	    $end_yr =  date('Y', strtotime("-11 year", $first));
	    
	    
	    $startmnth=date("Y-m-d", strtotime("-11 month",strtotime(date('Y-m-d'))));
	    //echo $startmnth.'<br>';
	    $endmnth=date("Y-m-d", strtotime(date('Y-m-d')));
	     //echo $endmnth.'<br>';exit;
            $end=date("Y-m-d", strtotime("-0 days"));
	    $advertisements=$this->AdvertisementReport->find('all', array(
                            'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                            ),
                            
                            'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
                            'group'=>'AdvertisementReport.adv_id'
                            
                ));
            
            //pr($advertisements);exit;
            
            
            $advertisementscount = count($advertisements);
            /*$advertisement_lists=$this->AdvertisementReport->find('all', array(
                            'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                            ),
                            'conditions' => array(
                                'AdvertisementReport.cdate >= '=> $start.' 00:00:00','AdvertisementReport.cdate <= '=> $end.' 23:59:59',
                            ),
                            'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
                            
                ));*/
            
            $paginate1 = array(
		     'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                    ),
                    'conditions' => array(
                                'AdvertisementReport.cdate >= '=> $start.' 00:00:00','AdvertisementReport.cdate <= '=> $end.' 23:59:59',
                    ),
                    'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
		    'limit' =>15,
		    'order' => array(
		       'AdvertisementReport.id' => 'desc'
		    )
		);
		$this->Paginator->settings = $paginate1;
		//pr($paginate1);
		$this->set('advertisement_lists', $this->Paginator->paginate('AdvertisementReport'));
            
		/*$advertisementlist_month = $this->AdvertisementReport->find('all', array(
                            'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                            ),
		    'conditions' => array('MONTH(AdvertisementReport.cdate)'=>$mnth,'YEAR(AdvertisementReport.cdate)'=>$yr),
                    'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
                            
                ));*/
		
		$paginate2 = array(
		    'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                            ),
		    'conditions' => array('AdvertisementReport.cdate >='=>$startmnth, 'AdvertisementReport.cdate <='=>$endmnth),
                    'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
		    'limit' =>15,
		    'order' => array(
		       'AdvertisementReport.id' => 'desc'
		    )
		);
		$this->Paginator->settings = $paginate2;
		//pr($paginate2);exit;
		$this->set('advertisementlist_month', $this->Paginator->paginate('AdvertisementReport'));
		
		
		
		$advertisementlist_year = $this->AdvertisementReport->find('all', array(
                            'joins' => array(
                                array(
                                    'table' => 'advertisements',
                                    'alias' => 'Advertisement',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                    'Advertisement.id = AdvertisementReport.adv_id','Advertisement.is_paid'=>1,'Advertisement.is_active'=>1,"Advertisement.user_id"=>$userid
                                        
                                    )
                                )
                            ),
		    'conditions' => array('YEAR(AdvertisementReport.cdate)'=>$yr),
                            'fields' => array('AdvertisementReport.*', 'Advertisement.*'),
                            
                ));
           
            $this->set(compact('title_for_layout','advertisementscount','advertisements','advertisement_lists','advertisementlist_year','advertisementlist_month'));
	}
	
	
	
	public function total_sale_range($from, $to,$adv_id) {
            $this->autoRender = false;
            $this->loadModel('AdvertisementReport');
	    $this->loadModel('Advertisement');
            $PayAmt=0;
            $options_payment = array('fields'=>array('COUNT(id) as count'),'conditions' => array('AdvertisementReport.cdate >='=>$from. ' 00:00:00','AdvertisementReport.cdate <= '=>$to.' 23:59:59','AdvertisementReport.adv_id'=>$adv_id),'order' => array('AdvertisementReport.id' => 'desc'));
            $all_history = $this->AdvertisementReport->find('all',$options_payment);
	   // pr($all_history);exit;
	  //  echo $all_history;
            foreach($all_history as $val){
                $PayAmt=$val[0]['count'];
               
                //$TotAmt+=10;
            }    
            return $PayAmt;
        }
	
	
	public function total_sale_range_monthly($mnth, $yr, $adv_id) {
            $this->autoRender = false;
            $this->loadModel('AdvertisementReport');
            $TotAmt=0;
            $options_payment = array('fields'=>array('COUNT(id) as count'),'conditions' => array('MONTH(AdvertisementReport.cdate)'=>$mnth,'YEAR(AdvertisementReport.cdate)'=>$yr, 'AdvertisementReport.adv_id'=>$adv_id),'order' => array('AdvertisementReport.id' => 'desc'));
            $all_history = $this->AdvertisementReport->find('all',$options_payment);
            foreach($all_history as $val){
                $PayAmt=$val[0]['count'];
                $TotAmt+=$PayAmt;
                //$TotAmt+=10;
            }    
            return $TotAmt;
            
	}
	
	public function total_sale_range_yearly($yr, $adv_id) {
            $this->autoRender = false;
            $this->loadModel('AdvertisementReport');
            $TotAmt=0;
            $options_payment = array('fields'=>array('COUNT(id) as count'),'conditions' => array('YEAR(AdvertisementReport.cdate)'=>$yr, 'AdvertisementReport.adv_id'=>$adv_id),'order' => array('AdvertisementReport.id' => 'desc'));
	    //echo $options_payment;
            $all_history = $this->AdvertisementReport->find('all',$options_payment);
	   // pr($all_history);exit;
            foreach($all_history as $val){
                $PayAmt=$val[0]['count'];
                $TotAmt+=$PayAmt;
                //$TotAmt+=10;
            }    
            return $TotAmt;
            
	}
        
        
        public function wallet_details() {
            
        $title_for_layout = 'My Wallet';
        $this->loadModel('User');
        $this->loadModel('Package');

        $userid = $this->Session->read('Auth.User.id');
        $utype = $this->Session->read('Auth.User.type');
        if ((!isset($userid) && $userid == '') || $utype != 'V') {
            $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }



        $option = array('conditions' => array('Package.status' => 1));
        $package = $this->Package->find('all',$option);
        
        
        $option_wallet = array('conditions' => array('User.id' => $userid));
        $Wallet_details = $this->User->find('first',$option_wallet);
        
        
        //pr($package);
        $this->set(compact('package','Wallet_details'));
    
            
            
            
        }
        
        
        public function package_details()
        {
        
            $title_for_layout = 'Payment';
            $this->loadModel('Package');
            
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            
            if($this->request->is('post')) {
                
                 $pid = $this->request->data['Subscriber']['package_id'];
                    
                       
                   } 
                 
            
        $options = array('conditions' => array('Package.id' => $pid));
        $package_details = $this->Package->find('first', $options);
            
         $this->set(compact('title_for_layout','package_details'));
        }
        
        
        
        
        
        public function payment($id)
        {
        
            $title_for_layout = 'Payment';
            $this->loadModel('Package');
            
            $userid = $this->Session->read('Auth.User.id');
            if(!isset($userid)){
                $this->redirect('/');
            }
            
            if($this->request->is('post')) {
                
                 if($this->request->data['Package']['payment']=='paypal'){
                       
                       return $this->redirect(array('action' => 'payment_process/'.$id));
                       
                       
                   } 
                   
                   else{
                       $this->Session->setFlash('Order not placed successfully.','default', array('class' => 'error'));
                       
                   }
                   
                                    
            } 
           
          
            $this->set(compact('title_for_layout','coupon_details'));
        }
        
        
        
        public function payment_process($id){
            
      $this->layout = false;
      
      $this->loadModel('SiteSetting');
      $this->loadModel('Package');
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
        $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
        return $this->redirect(array('action' => 'login'));
      }


  $product = $this->Package->find('first', array('conditions' => array('Package.id' => $id),'fields'=>array('Package.price','Package.id')));
  //pr($product);exit;
  $paypalid = $this->SiteSetting->find('first');
    
  //nits.bikash@gmail.com
    //pr($paypalid);exit();
    $this->set(compact('product','userid','paypalid'));
  }
  
  
  public function purchase_payment(){
       
       
    $this->autoRender = false;
    $this->layout = false;
    $this->loadModel('Subscriber');
    $this->loadModel('User');
    $this->loadModel('Package');
    
    $post = array();
        foreach ($_POST as $field => $value) {
            array_push($post,urlencode($field)."=".urlencode($value));
        }

        $id = $_POST["txn_id"];
        
        
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$post)."&cmd=_notify-validate");
        $post = curl_exec($ch);

        curl_close($ch);
        
        //$this->send_smtpmail('spandan@natitsolved.com', 'nits.santanupatra@gmail.com', 'payment',$_POST["payment_status"]);           

    if ($_POST["payment_status"] == 'Pending' || $_POST["payment_status"] == 'Completed')
      {
        
        
          $custom = explode('_',$_POST["custom"]); 
          
         $userid= $custom[0];
         $couponid =$custom[1];
         
           $options_cart = array('conditions' => array('Package.id' => $couponid));
           $tempid = $this->Package->find('first', $options_cart);
           
                //pr($cart);exit;
                
                $this->request->data['Subscriber']['user_id']= $userid;
                $this->request->data['Subscriber']['package_id']=$couponid;
                $this->request->data['Subscriber']['payment_type']='Paypal';
                $this->request->data['Subscriber']['price']=$tempid['Package']['price'];
                $this->request->data['Subscriber']['payment_type']='paypal';
                $this->request->data['Subscriber']['transaction_id']=$id;
                $this->request->data['Subscriber']['subscription_date']=date('Y-m-d');
                
                $this->Subscriber->create(); 
               if($this->Subscriber->save($this->request->data)){
                   
                 
               $options = array('conditions' => array('User.id' => $userid));
               $user_deal_coupon = $this->User->find('first', $options);    
                   
                   
                $this->request->data['User']['id']= $userid;
                $this->request->data['User']['total_deal']=$user_deal_coupon['User']['total_deal'] + $tempid['Package']['no_deal'];
                $this->request->data['User']['total_coupon']= $user_deal_coupon['User']['total_coupon'] +$tempid['Package']['no_coupon']; 
                   
                  $this->User->save($this->request->data); 
                  
               }
               
               
      }


  }
    
   public function success_payment(){
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }

  }
        
    public function cancel(){
      $userid = $this->Session->read('Auth.User.id');
      if(!isset($userid) && $userid=='')
      {
      $this->Session->setFlash(__('Please login to access profile.', 'default', array('class' => 'error')));
      return $this->redirect(array('action' => 'login'));
      }
     
  }
        
        
        
        
        
        

}
