<div class="container_825">
	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1">Teach people your skill</div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				In vel leo pretium, porta justo venenatis, fringilla tellus. Praesent dignissim nisl non consectetur sagittis. Sed consectetur ante quis rutrum mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent nec magna orci. Sed malesuada arcu at  enim luctus, vel venenatis ante sodales.
			</div>
		</div>
	</div>
	<div class="step1_sec2">
		<div class="width_620">
		  <form class="contact_form" name="step1" id="step1" action="<?php echo $this->webroot.'skills/step1'; ?>" method="POST" enctype="multipart/form-data">
			<div class="name lato_step_1_sec_1_small">What is that you do best?&nbsp;&nbsp;<span id="caterr" style="color:red"></span></div>
			<div class="fields">
				<div class="list_box">
					<select name="data[Skill][category_id]" id="category_id" onchange="remove_err('caterr',this.value)">
						<option value="">Select Skill</option>
						<?php 
						  if(!empty($categories))
						  {
							  foreach($categories as $category)
							  {
						?>
						   <option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></option>
						<?php }} ?>
					</select>
				</div>   			
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small">Any subskills?&nbsp;&nbsp;<span id="suberr" style="color:red"></span></div>
			<div class="fields">
			    <input type="hidden" name="data[List][tagnum]" value="0" id="tagnum"/>
		        <input type="hidden" name="data[List][totalTags]" value="0" id="totalTags"/>
				<div id="newTags">
				</div>
				<div class="tag_open"><a href="javascript:void(0)" onclick="open_tag_textbox()"><img src="<?php echo $this->webroot; ?>img/stepplus.png" alt="Add Tag" /></a></div>
				<div id="tag_textbox_div" style="display:none;width:100%">
				  <input type="text" placeholder="Add subskills" name="data[Skill][sub_category]" id="Tags" style="width:80%" onkeypress="return add_tag_enter(event);"/>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small">Tell us about your skills&nbsp;&nbsp;<span id="deserr" style="color:red"></span></div>
			<div class="fields">
				<textarea name="data[Skill][skill_details]" id="skill_details" onkeyup="remove_err('deserr',this.value)"></textarea>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small">Add pictures of things you've made&nbsp;&nbsp;<span id="picerr" style="color:red"></span></div>
			<div class="fields">
				<ul class="up_image">
					<div id="Preview">
					</div>
					<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick()" style="cursor:pointer"/></li>
				</ul>
				<input type="file" id="theFile" name="photos[]" style="display:none;" multiple="true"/>
				<input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
				<input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small">Put in the box bellow your video URL&nbsp;&nbsp;<span id="urlerr" style="color:red"></span></div>
			<div class="fields">
				<input type="text" placeholder="Youtube or Vimeo Video Url" name="data[Skill][skill_video_url]" id="skill_video_url" onblur="return check_link()"/>
			</div>
			<div class="clearfix"></div>
			<div class="fields">
				<input type="submit" value="Studio" class="studio_btn" onclick="return step1_validate()"/>
			</div>
		  </form>
		</div>
	</div>
</div>