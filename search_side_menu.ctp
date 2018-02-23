


<div class="col-lg-3 col-side-menu-bar">
                    <div id="accordionMenu" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h5 class="panel-title m-0">
                            <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Category
                            </a>
                          </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-block">
                                    <div class="gw-sidebar">
  <div id="gw-sidebar" class="gw-sidebar">
    <div class="nano-content">
                                    <ul class="gw-nav gw-nav-list side-menu list-unstyled">
                                        <?php 
							  if(isset($categories) && !empty($categories))
							  {	
								foreach($categories as $category)

								{ ?>
									   
											 <?php 
											 $subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$category['Category']['id']));
if(!empty($subcats))
{   
    ?>
                                       <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text"><?php echo $category['Category']['name']?></span></a>
    <?php
              foreach($subcats as $subcat)
              {
?>


 <?php 
$subsubcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$subcat['Category']['id']));
if(!empty($subsubcats))
{   
    ?>
    <label><?php echo $subcat['Category']['name']?></label> 
    <?php
              foreach($subsubcats as $subcat2)
              {
?>
    <ul class="gw-submenu">
        <li><input type="checkbox" name="cat[]" onclick="takesearchvalue()" value="<?php echo $subcat2['Category']['id'];?>" ><?php echo $subcat2['Category']['name'];?></li>
    </ul>

<?php	}
?>

<?php
}
else
{
    ?>
    <ul class="gw-submenu">
    <li><input type="checkbox" name="cat[]" onclick="takesearchvalue()" value="<?php echo $subcat['Category']['id'];?>"><?php echo $subcat['Category']['name'];?></li>
    </ul>
     </li>                                  
    <?php
}
?>

<?php	}
?>

<?php
}
else
{
    ?>
     <li><a href="javascript:void(0)"><span class="gw-menu-text"><input type="checkbox" name="cat[]" onclick="takesearchvalue()" value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></span></a></li>
    <?php
}
?>

<?php	}
}
?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                                </div>
                            </div>
                        </div>
                   
                        


                        <div class="card">
                            <div class="card-header" role="tab" id="headingFour">
                                <h5 class="panel-title m-0">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                              Price
                            </a>
                          </h5>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingFour">
                                <div class="card-block">
                                    <ul class="side-menu list-unstyled">
                                        <li>
                                            <label>
                                                <input type="radio" onclick="takesearchvalue()" id="price" value="50-150" name="price">$50 - $150</label>
                                        </li>
                                        <li>
                                            <label>
                                         <input type="radio" onclick="takesearchvalue()" name="price" id="price" value="151-200">$151 - $200</label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" onclick="takesearchvalue()" name="price" id="price" value="201-500">$201 - $500</label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" onclick="takesearchvalue()" name="price" id="price" value="501-1000">$501 - $1000</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


<input type="hidden" value="<?php echo $keyword;?>" name="keyword">


                    </div>
                </div>
<script src="<?php echo ($this->webroot);?>js/bs_leftnavi.js"></script>
<script type="text/javascript">
    
    
    function takesearchvalue(){
    //alert(obj);
    var price = $('input[name=price]:checked').val();
    //var cat=[];
   // var cat= $('input[name="cat[]"]:checked').val();
    
    var catids = new Array();
    $.each($("input[name='cat[]']:checked"), function() {       
        catids.push($(this).val());
    });  
    //alert(catids);
        
        
    var keyword=$('input[name=keyword]').val();
    //var subcat= $('input[name=subcat]:checked').val();
    //var subcat1= $('input[name=subcat1]:checked').val();
    
    //console.log(.join(","));
    //alert(price);
    //alert(subcat);
   //alert(subcat1);
    //alert(cat);
    $.post('<?php $this->webroot;?>filter_search',
    {price:price,cat:catids,keyword:keyword},
    function(data,status){
        
       if(status=='success'){
           
          $('#result').html(data);
           
        }
        
        
    }
          );
    
    
}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    
    <script>
        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');


            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });


            return false;
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".nav-toggle").click(function() {
                $(".full-nav").toggle();
            });
        });
    </script>
    <script>
        $(function() {
            $('a[data-toggle="collapse"]').on('click', function() {

                var objectID = $(this).attr('href');

                if ($(objectID).hasClass('in')) {
                    $(objectID).collapse('hide');
                } else {
                    $(objectID).collapse('show');
                }
            });


            $('#expandAll').on('click', function() {

                $('a[data-toggle="collapse"]').each(function() {
                    var objectID = $(this).attr('href');
                    if ($(objectID).hasClass('in') === false) {
                        $(objectID).collapse('show');
                    }
                });
            });

            $('#collapseAll').on('click', function() {

                $('a[data-toggle="collapse"]').each(function() {
                    var objectID = $(this).attr('href');
                    $(objectID).collapse('hide');
                });
            });

        });
    </script>
   