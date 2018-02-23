<?php
$image_name=$this->request->data['Advertisement']['image_name'];
$link=$this->request->data['Advertisement']['link'];
$amount=$this->request->data['Advertisement']['amount'];
$start_date=date('d/m/Y',strtotime($this->request->data['Advertisement']['start_date']));
$end_date=date('d/m/Y',strtotime($this->request->data['Advertisement']['end_date']));

$is_paid=$this->request->data['Advertisement']['is_paid'];
$type=$this->request->data['Advertisement']['type'];
$pos=$this->request->data['Advertisement']['page_position'];
$uploadPath=WWW_ROOT.'advertisement';

?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><?php echo __('Edit Advertisement'); ?></div>
			</div>
			<div class="users view">
			<?php echo $this->Form->create('Advertisement',array('enctype'=>'multipart/form-data')); ?>
                            <fieldset>
				<?php
                                    echo $this->Form->input('id');
                                ?>
                                <dl>
                                <dt><?php echo __('Page to display Advert'); ?></dt>
                                <dd>
                                    <?php
                                    if(isset($type) && $type==1){
                                        if(isset($pos) && $pos!=''){
                                                echo '<p>Home page '.$pos.' banner advert</p>';
                                        }
                                        else{
                                                echo '<p>Home page Top banner advert</p>';
                                        }
                                    }elseif(isset($type) && $type==2){
                                        echo '<p>Product Detail Page</p>';
                                    }elseif(isset($type) && $type==3){
                                        echo '<p>Home page banner advert</p>';
                                        echo '<p>Product Detail Page</p>';
                                    }
                                    ?>
                                </dd>
                                <dt><?php //echo __('Order Transaction ID'); ?></dt>
                                <dd>
                                    <?php
                                    if(isset($image_name) && $image_name!='' && file_exists($uploadPath . '/' . $image_name)){
                                        $AdvertiseImg=$this->webroot.'advertisement/'.$image_name;
                                    }else{
                                        $AdvertiseImg=$this->webroot.'shop_images/img.png';
                                    }
                                    ?>
                                    <img src="<?php echo $AdvertiseImg;?>" height="100" width="200" alt="" />
                                </dd>
                                <dt><?php echo __('Link'); ?></dt>
                                <dd>
                                    <?php echo isset($link)?$link:'';?>
                                </dd>
                                <dt><?php echo __('Selected plan'); ?></dt>
                                <dd>
                                    <p>
                                        <?php
                                        $pkg_name=$this->request->data['Package']['name'];
                                        $pkg_duration=$this->request->data['Package']['duration'];
                                        $pkg_price=$this->request->data['Package']['price'];
                                        echo $pkg_name.' - for '.$pkg_duration.' months $'.$pkg_price;
                                        ?>
                                    </p>
                                </dd>
                                <dt><?php echo __('Start Date'); ?></dt>
                                <dd>
                                    <?php echo isset($start_date)?$start_date:'';?>
                                </dd>
                                <dt><?php echo __('End Date'); ?></dt>
                                <dd>
                                    <?php echo isset($end_date)?$end_date:'';?>
                                </dd>
                                <dt><?php echo __('No. of months'); ?></dt>
                                <dd>
                                    <?php echo isset($pkg_duration)?$pkg_duration:'';?>
                                </dd>
                                <dt><?php echo __('Total'); ?></dt>
                                <dd>
                                    $<?php echo isset($amount)?$amount:'';?>
                                </dd>
                                </dl>
				<div class="input checkbox">
                                    <input id="UserIsActive_" type="hidden" value="0" name="data[Advertisement][is_active]">
                                    <input id="UserIsActive" type="checkbox" value="1" name="data[Advertisement][is_active]" <?php if(isset($this->request->data['Advertisement']['is_active']) && $this->request->data['Advertisement']['is_active']==1){echo 'checked';}?>>
                                    <label for="UserIsActive">Is Active</label>
                                </div>
                            </fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
