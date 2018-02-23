<section class="category_headr">
			<ul class="pull-left">
                                
						
                            
				<li><a href="<?php echo $this->webroot.'shop/'.$shop['Shop']['slug'].'/'.$shop_id;?>">Home</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/category';?>">Category</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/sales';?>">Sale Item</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/top';?>">Top Selling</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/new';?>">New Arrivals</a></li>
				<li><a href="<?php echo $this->webroot.'shops/feedback/'.$shop_id;?>">Feedback</a></li>
				<li><a href="<?php echo $this->webroot.'shops/contact_details/'.$shop_id;?>">Contact Details</a></li>
			</ul>
			<div class="right_search pull-right">
				<?php echo $this->Form->create("Filter",array('class' => 'form-inline'));?>
				  <div class="form-group">
				    <div class="input-group">
				      <input style=" width: 70%;" type="text" class="form-control" name="data[Filter][keyword]" id="exampleInputAmount" placeholder="Keyword" value="<?php echo ((isset($this->request->params['named']['keyword']) && $this->request->params['named']['keyword']!='')?$this->request->params['named']['keyword']:'');?>">
				      <!--<div class="input-group-addon">Search</div>-->
                                      <button style=" padding: 9px 15px;" type="submit" class="input-group-addon">Search</button>
				    </div>
				  </div>
				<?php echo $this->Form->end();?>
			</div>
		</section>