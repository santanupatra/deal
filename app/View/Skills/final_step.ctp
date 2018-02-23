<div class="container_825">
	<div class="final_step_back">
		<div class="final_step_banner">
			<h5>
				CONGRATULATIONS, YOU OFFERD YOUR SKILL!
			</h5>
		</div>
		<aside>
		   <?php if($user['User']['is_profile_complete']==0){?>
			<?php echo $sitesetting['SiteSetting']['skill_final_description']; ?>
		   <?php }else{ ?>
		   <?php echo $sitesetting['SiteSetting']['final_step_text']; ?>
		   <?php } ?>
		</aside>
		<aside>
		 <?php if($user['User']['is_profile_complete']==0){?>
		  <a href="<?php echo $this->webroot;?>users/account" style="text-decoration:none"><input class="studio_btn" type="button" value="Fill payout info" style="float:left;margin:0 30px 0 30px"></a>
		  <a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($skill_id);?>" style="text-decoration:none"><input class="studio_btn" type="button" value="View details" style="float:left"></a>
         <?php }else{ ?>
		  <a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($skill_id);?>" style="text-decoration:none"><input class="studio_btn" type="button" value="View details"></a>
		 <?php } ?>
		</aside>
		<br/>
		<aside><?php echo $sitesetting['SiteSetting']['final_step_text1']; ?><br />
        <?php echo $sitesetting['SiteSetting']['skill_final_payout']; ?></aside>
	</div>
</div>
<style>
.final_step_banner {
height: auto !important;
background: none !important;
}
.final_step_banner h5 {
margin-top:0px !important;
}
</style>