<div class="container_960">
	<?php echo $this->element('user_leftbar'); ?>
	<div class="dash_right pull-right">
		<div class="dash_right_head">
			<h2>My Offers</h2>
		</div>
		<div class="width_step_3">
			<div class="row">
			  <?php if(!empty($skills)){
			   foreach($skills as $skill){
				 $skillimages_exp=array();
				 if(isset($skill['SkillImage']['0']['image']) && $skill['SkillImage']['0']['image']!='')
				 {
				   $skillimages_exp=explode(',',$skill['SkillImage']['0']['image']);
				 }
			  ?>
				<div class="col-sm-4">
					<div class="offer_img">
						   <?php
							if(isset($skillimages_exp[0]) && $skillimages_exp[0]!=''){
							$uploadFolder = "skill_images";
							$uploadPath = WWW_ROOT . $uploadFolder . '/' . $skillimages_exp[0];
							if (file_exists($uploadPath))
							{
						   ?>
						      <img src="<?php echo $this->webroot;?>skill_images/thumb/<?php echo $skillimages_exp[0];?>" alt="Cover Image" />
						  <?php }else{ ?>
						      <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Cover Image" />
						  <?php
							}}
							else{
						  ?>
						      <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Cover Image" />
						  <?php } ?>
<!--						<a href="<?php echo $this->webroot;?>skills/edit_step1/<?php echo $skill['Skill']['id'];?>"><div class="offer_hover" style="text-align:center;color:#fff">
							<img src="<?php echo $this->webroot;?>img/edit_offer.png" alt="Edit offer"/><br>Edit skill
						</div></a>-->
                                                      			<div class="my_offer_icon" id="my_offer_icon<?php echo $skill['Skill']['id'];?>">
                                	<a href="javascript:void(0)" onclick="show_div(this.id)" id="<?php echo $skill['Skill']['id'];?>"><img src="<?php echo $this->webroot;?>img/my_offer_icon.png" alt=""></a>
                                </div>
                                	<div class="up_arrow" id="up_arrow<?php echo $skill['Skill']['id'];?>" style="display:none;"><img src="<?php echo $this->webroot;?>img/up_arrow.png" alt=""></div>
                                	<ul class="drop_my_offer" id="drop_my_offer<?php echo $skill['Skill']['id'];?>" style="display:none;">
                                            <?php if(isset($skill['Skill']['is_active']) && $skill['Skill']['is_active']==1) 
                                            {
                                                ?>
                                            <li><a href="<?php echo $this->webroot;?>skills/unpublish/<?php echo $skill['Skill']['id'];?>" onclick="return confirm('are you sure?');">Unpublish</a></li>
                                        <?php
                                            }
                                            else
                                            {
                                            ?>
                                        <li><a href="<?php echo $this->webroot;?>skills/publish/<?php echo $skill['Skill']['id'];?>" onclick='return confirm("are you sure?");'>Publish</a></li>
                                        <?php
                                            }
                                            ?>
                                        <li><a href="<?php echo $this->webroot;?>skills/edit_step1/<?php echo $skill['Skill']['id'];?>">Edit</a></li>
                                        <li><a href="<?php echo $this->webroot;?>skills/myoffer_delete/<?php echo $skill['Skill']['id'];?>" onclick='return confirm("are you sure?");'>Delete</a></li>
                                    </ul>
					</div>
					<div class="offer_des">
						<p>
						  <a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>" style="color:#000"><b><?php echo ((isset($skill['Skill']['about_specifically']) && $skill['Skill']['about_specifically']!='')?$skill['Skill']['about_specifically']:$skill['Category']['name']);?></b></a>
						</p>
						<div class="clearfix"></div>
						<span>
						 <?php       $workshop_no=$this->requestAction('users/getnoofworkshop/'.$skill['Skill']['id']);
						 $review_no=$this->requestAction('users/getnoofreview/'.$skill['Skill']['id']);
						 ?>
						  <?php echo $workshop_no;?> Workshops&nbsp;&nbsp;&nbsp;<?php echo $review_no;?> Reviews
						</span>
					</div>
				</div>
			  <?php }} ?>
				<div class="col-sm-4">
					<div class="creat_skill">
						<a href="<?php echo $this->webroot;?>skills/teaser"><img src="<?php echo $this->webroot;?>img/creat_trans.png" alt="Create skill"/></a>
						<a href="<?php echo $this->webroot;?>skills/teaser">Create skill</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<style>
.offer_des a
{
 color:#4743e2;
}
</style>
			<script type="text/javascript">
            function show_div(id)
            {
                $('.up_arrow').hide();
                $('.drop_my_offer').hide();
                $("#drop_my_offer"+id).show();
                $("#up_arrow"+id).show();
                $("#my_offer_icon"+id).html('');
                $("#my_offer_icon"+id).html('<a href="javascript:void(0)" onclick="show_div1(this.id)" id="'+id+'"><img src="<?php echo $this->webroot;?>img/my_offer_icon.png" alt=""></a>');
                
            }
             function show_div1(id)
            {
                $("#drop_my_offer"+id).hide();
                $("#up_arrow"+id).hide();
                $("#my_offer_icon"+id).html('');
                $("#my_offer_icon"+id).html('<a href="javascript:void(0)" onclick="show_div(this.id)" id="'+id+'"><img src="<?php echo $this->webroot;?>img/my_offer_icon.png" alt=""></a>');
                
            }
		</script>