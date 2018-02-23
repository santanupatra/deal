<link href="<?php echo $this->webroot; ?>css/dropzone.css" rel="stylesheet">
<script src="<?php echo $this->webroot; ?>js/dropzone.js"></script>
<?php
#pr($productimages);
?>
<div class="span9" id="content">
	<div class="row-fluid">
	<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Product Images For '.$productimages[0]['Product']['name']); ?></div>
			</div>
			<div class="image_upload_div" style="margin-top: 14px;margin-left: 25px;">
				<form action="<?php echo $this->webroot; ?>admin/products/uploadProduct/<?php echo $this->params['pass'][0]; ?>" class="dropzone">
				</form>
			</div> 

			<?php 
			if(!empty($productimages)){
			?>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
                                                <th>&nbsp;</th>
                                                <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($productimages as $product): ?>
					<tr>
                                            <td><?php echo h($product['ProductImage']['id']); ?>&nbsp;</td>
                                            <td>
                                                    <img height="100" width="100" src="<?php echo($this->webroot)?>product_images/<?php echo($product['ProductImage']['name']);?>"/>
                                            <td class="actions"> 
                                                <a href="<?php echo $this->webroot;?>admin/products/imagedelete/<?php echo $product['ProductImage']['id'];?>/<?php echo $product['ProductImage']['product_id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Product Image" width="24" height="24"></a>
                                            </td>
					</tr>
                   
                                        <?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>

			<?php } ?>
		</div>
	</div>
</div>
