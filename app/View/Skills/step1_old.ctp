<div class="users index">
 <form class="contact_form" name="step1" id="step1" action="<?php echo $this->webroot.'skills/step1'; ?>"method="POST" >
  What is that you do best?<br>
  <select name="data[Skill][category_id]" id="category_id" class="validate[required]">
    <option value="">Select Skill</option>
	<?php 
	  if(!empty($categories)){
		  foreach($categories as $category)
	      {
	?>
     <option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></option>
	<?php }} ?>
  </select>
    <input type="text" name="data[Skill][sub_category]" id="Tags" value="" style="width:200px"/>&nbsp;<input type="button"  value="Add" onclick="addnewTag();" class="tag_btn" />
	<p>
	    <input type="hidden" name="data[List][tagnum]" value="0" id="tagnum"/>
		<input type="hidden" name="data[List][totalTags]" value="0" id="totalTags"/>
		<div id="newTags"></div>
		<div class="clear"></div>
	</p>
	<textarea name="data[Skill][skill_details]" id="skill_details" class="validate[required]"></textarea>
    <div id="Preview" style="float:left;"></div>
	<div class="image_add" style="float:left;"><img src="/img/add_photo.png" onclick="performClick()" style="cursor:pointer" alt="" /></div>
	<!-- <input type="file" id="theFile" style="display:none;" multiple="multiple"/> -->
	<input type="file" id="theFile" required name="data[List][photos]" style="display:none;"/>
	<input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
	<input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
	<div class="clear"></div>
	<p><i>Please add at least one photo.</i>&nbsp;&nbsp;<span id="photoErr" class="showError"></span></p>
	<input type="text" name="data[Skill][skill_video_url]" id="skill_video_url" onblur="check_link()" value="" style="width:200px" class="validate[required]"/>
	<div id="map-canvas" style="height:300px;width:100%;margin-bottom:10px;"></div>
	<textarea name="location" id="location" class="with-border"  style="height:40px;" onblur="on_address(this.value)"></textarea>
	<input type="hidden" id="lat" name="lat" value="55.5314076"/>
	<input type="hidden" id="lang" name="lang" value="10.046474"/>
 </form>
</div>
