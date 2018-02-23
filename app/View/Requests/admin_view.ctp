<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('View Admin'); ?></div>
			</div>
			<div class="users view">
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($request['Request']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($request['Skill']['skill_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Maker'); ?></dt>
					<dd>
						<a href="<?php echo $this->webroot;?>admin/users/user_view/<?php echo h($request['Request']['maker']); ?>"><?php echo h($request['Skill']['User']['first_name'].' '.$request['Skill']['User']['last_name']); ?></a>
						&nbsp;
					</dd>
					<dt><?php echo __('User'); ?></dt>
					<dd>
						<a href="<?php echo $this->webroot;?>admin/users/user_view/<?php echo h($request['Request']['user_id']); ?>"><?php echo h($request['User']['first_name'].' '.$request['User']['last_name']); ?></a>
						&nbsp;
					</dd>
					<dt><?php echo __('Order Date'); ?></dt>
					<dd>
						<?php echo date('M d, Y',strtotime($request['Request']['sent_date'])); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Order Details'); ?></dt>
					<dd>
						<ul class="fashion_list">
							<li><?=date('M d Y',strtotime($request['Request']['request_date']));?> (<?=$request['Request']['request_time']?><?=$request['Request']['request_time_format']?>)</li>
							<li><?php echo $request['Request']['total_persons'];?> Persons</li>
							<li><?php echo nl2br($request['Request']['request_comment']);?></li>
						</ul>
						&nbsp;
					</dd>
					<?php
					 if(isset($request['Request']['image_paths']) && $request['Request']['image_paths']!='')
					 {
						 $ordr_images=explode(',',$request['Request']['image_paths']);
					?>
					<dt style="background:none"><?php echo __('Images'); ?></dt>
					<dd style="background:none">
					    <?php foreach($ordr_images as $ordr_image){ ?>
						  <img src="<?php echo $this->webroot;?>order_images/<?php echo $ordr_image;?>" style="width:120px;height:120px;float:left;margin-right:10px;margin-bottom:20px"/>
						<?php } ?>
						&nbsp;
					</dd>
					<?php } ?>
					<dt><?php echo __('Conversation'); ?></dt>
					<dd>
					 <?php 
					   $inbox_id=$this->requestAction('users/getinboxid/'.$request['Request']['id'].'/'.$request['Request']['user_id']);
					   $inboxdetails=$this->requestAction('users/getinboxdetails1/'.$inbox_id);
					 ?>
						 <div style="padding-left: 10px;">
								<?php 
								foreach($inboxdetails as $v=>$inv_messages) { 
								$sender_id=  $inv_messages['SentMessage']['sender']; 
								if($inv_messages['SentMessage']['is_invoice']==0)
								{
								  $userdetails=$this->requestAction('users/getuserdetails/'.$sender_id);
								?>
								  <div style="float:left;width:95%;background:#e8e8e8;margin-bottom:10px;padding:10px">
								 <?php
									 if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
								 {
								?><img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" style="width:25px;height:25px;border-radius:100%"/>
								<?php }else{ ?>
								   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" style="width:25px;height:25px;border-radius:100%"/>
								<?php } ?>
									  <strong><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></strong><b style="float:right"><?=date('M d Y',strtotime($inv_messages['SentMessage']['date_time']));?></b>
									 <div class="clearfix"></div>
									  <p style="margin:5px 0 20px 0"><?php echo nl2br($inv_messages['SentMessage']['message']);?></p>
									 </div>
								 <?php }else{ 
								  $invoice_details_msg=$this->requestAction('users/getinvoicedetailsmsg/'.$inv_messages['SentMessage']['invoice_id']);
								  if(!empty($invoice_details_msg))
								  {
								 ?>
								   <div style="float:left;width:95%;background:#e8e8e8;margin-bottom:10px;padding:10px">
									  <div class="right_meaasge_inner" style="background:none">
									   <div class="right_meaasge_container" style="width:99%;margin:0 auto">
										<div class="message_head">
										  <?php
											$userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details_msg['Invoice']['maker_id']);
											if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
											 {
											?>
											   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" style="margin-left:0px;width:25px;height:25px;border-radius:100%"/>
											<?php }else{ ?>
											   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" style="margin-left:0px;width:25px;height:25px;border-radius:100%"/>
											<?php } ?>
											<strong><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></strong>
											<b style="float:right"><?=date('M d Y',strtotime($invoice_details_msg['Invoice']['date']));?></b>
										<ul class="fashion_list" style="margin-top:0px">
											<li style="margin-top:5px !important"><?=date('M d Y',strtotime($invoice_details_msg['Request']['request_date']));?> (<?=$invoice_details_msg['Request']['request_time']?><?=$invoice_details_msg['Request']['request_time_format']?>)</li>
											<li style="margin-top:0px !important"><?php echo $invoice_details_msg['Request']['total_persons'];?> Persons</li>
											<li style="margin-top:0px !important"><?=$invoice_details_msg['Invoice']['how_long']?></li>
										</ul>
										<div class="clearfix"></div>
										<span>
										<?=nl2br($invoice_details_msg['Invoice']['message']);?>	
										</span>
										<table class="price_table" style="margin-top:20px">
											
											<tr>
												
												<td>Total cost</td>
												<td>$<?=$invoice_details_msg['Invoice']['how_mutch'];?></td>
											</tr>
											<tr>
												<td colspan="2">
																										                                              <?php 
													 if($invoice_details_msg['Request']['is_paid']==0)
													 { 
												  ?>
												   <strong style="float:left;font-size:12px">Not agree payment</strong>
												  <?php }else{
												  ?>
													<strong style="float:left;font-size:12px">Paid</strong>
												  <?php } ?>
												</td>
											  </tr>
										   </table>
										 </div>
									  </div>
								   </div>
								   </div>
								   <div class="clearfix"></div>
								<?php  }}} ?>       
                             </div>  
							 <div class="clearfix"></div>
						&nbsp;
					</dd>
				</dl>
			</div>
		</div>
	</div>
</div>