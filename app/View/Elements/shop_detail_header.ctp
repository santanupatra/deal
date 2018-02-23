<span class="pull-left"><?php echo($shop['Shop']['name'])?></span>
<div class="pull-right">
        <?php if($shop['Shop']['user_id']!=$userid){ ?>
         <a style="color: #000; text-decoration: none;" href="javascript:;" data-toggle="modal" data-target="#contactnow"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Contact Now</a> 
         <?php } ?>
         <?php 
         if($shop['Shop']['user_id']!=$userid)
         {
         if(isset($follow) && !empty($follow))
         {?>
         <a href="<?php echo $this->webroot.'shops/un_follow/'.base64_encode($follow['Follow']['id']);?>"><button>Un Follow</button></a>
         <?php }else{
         ?>
         <a href="<?php echo $this->webroot.'shops/add_follow/'.base64_encode($shop['Shop']['id']);?>"><button>Follow</button></a>
         <?php 
         }
         }?>
</div>
<style>
.modal-body label {
    font-weight: normal;
    font-size: 14px;
}
</style>
<div class="modal fade" id="contactnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="background: transparent; color: #969494;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contact</h4>
            </div>
            <?php if(!empty($userid)){ ?>
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot; ?>shops/contact_mail" enctype="multipart/form-data">
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $shop['Shop']['user_id']; ?>">
                <input type="hidden" name="data[Comment][to_user_id]"  value="<?php echo $userid; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Subject</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="data[Comment][subject]" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Message:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="data[Comment][comments]" required="required"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">File:</label>
                        <div class="col-sm-9">
                            <input style="font-size: 14px;" type="file"  name="data[Comment][file_name]">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style=" padding: 8px 20px; border-radius: 5px;">Submit</button>
                    <button type="button" class="btn btn-default" style="padding-left: 20px;padding-right: 20px; background: #e2e1e1; box-shadow: none; text-shadow: none; border-color: #e2e1e1; color: #000;     padding: 8px 20px; border-radius: 5px; " data-dismiss="modal">Cancel</button>
                </div>
            </form>
            <?php }else{
            ?>
            <div class="modal-body">
                You need to login for contact.

            </div>
            <?php
            } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>