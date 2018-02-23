<?php
?>
<section class="frame-section">
    	<div style="margin: 20px auto; overflow: hidden;" class="container">
			<div class="row">
				<div class="col-md-9 left_frame">
					<h2><?php echo($product['Product']['name']);?></h2>
					
					<!--<div class="frame_body">
						<img src="<?php echo $this->webroot;?>product_images/<?php echo $product['ProductImage'][0]['name'];?>" alt="<?php echo($product['Product']['name']);?>" />
					</div>-->
					<div id="kk_fs-motivView">
				         <div id="kk_bg_area" style="height:800px;">
			                  <div class="kk_bg_layer" id="bg_layer">				 
				           <div align="center" id="kk_motiv_lay" style="z-index:1000!important; width:100%;">
					     <div style="position:absolute;top:0px;left:52%;margin-left:-220px;" id="outer_div">
					     
					     <div style="z-index:3;height:39px;width:39px;overflow:visible;position:absolute;top:0px;left:0px;" id="topcorner">
					     </div>	
							
					     <div style="z-index:2;height:39px;overflow:visible;position:absolute;top:0px;left:39px;" id="tophorizontal">
					     </div>
																					    <div style="z-index:2;height:39px;width:39px;overflow:visible;position:absolute;top:0px;left:389px;" id="rightcorner">
					     </div>
					     
					     <div style="z-index:1;width:39px;overflow:visible;position:absolute;top:39px;left:0px;" id="leftvertical">											
					     </div>

					      <div id="thirdlayerborder" style="width:314px;overflow:visible;position:absolute;">
						<div id="secondlayerborder" style="width:314px">
						 <div style="border:2px solid #FFFFFF;width:314px;background-color:#FFFFFF;" id="firstlayerborder">
						   <img id="detail_image" title="" alt="" src="<?php echo $this->webroot;?>product_images/<?php echo $product['ProductImage'][0]['name'];?>" width="310" style="vertical-align:top;width:310px;" vspace="0" hspace="0">															
						 </div>
						</div>
					     </div>
							
					      <div style="z-index:1;width:39px;overflow:visible;position:absolute;top:39px;" id="rightvertical">
					      </div>
														
					      <div style="z-index:3;height:39px;width:39px;overflow:visible;position:absolute;left:0px;" id="leftbottomcorner">
					      </div>

					      <div style="z-index:2;height:39px;overflow:visible;position:absolute;left:39px;" id="bottomhorizontal">
					      </div>

					      <div style="z-index:2;height:39px;width:39px;overflow:visible;position:absolute;" id="rightbottomcorner">
					      </div>
					      </div>
				           </div>
				          <div class="kk_clear"></div>
                                         </div>
                                        </div>		
                                       </div>
				       <div class="row frame_option">
						<div class="col-md-8">
							<p><?php echo(nl2br($product['Product']['description']));?></p>
						</div>
						<div class="col-md-4">
							<a href=""><i class="fa fa-child"></i></a>
							<a href=""><i class="fa fa-arrows"></i></a>
							<a href=""><i class="fa fa-search-minus"></i></a>
							<a href=""><i class="fa fa-search-plus"></i></a>
							<a href=""><i class="fa fa-thumbs-up"></i></a>
							<a href=""><i class="fa fa-heart"></i></a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
						<div id="init"></div>

							<!--<select name="colorpicker-shortlist">
							  <option value="#7bd148">Green</option>
							  <option value="#5484ed">Bold blue</option>
							  <option value="#a4bdfc">Blue</option>
							  <option value="#46d6db">Turquoise</option>
							  <option value="#7ae7bf">Light green</option>
							  <option value="#51b749">Bold green</option>
							  <option value="#fbd75b">Yellow</option>
							  <option value="#ffb878">Orange</option>
							  <option value="#ff887c">Red</option>
							  <option value="#dc2127">Bold red</option>
							  <option value="#dbadff">Purple</option>
							  <option value="#e1e1e1">Gray</option>
							  <option value="#7bd148">Green</option>
							  <option value="#5484ed">Bold blue</option>
							  <option value="#a4bdfc">Blue</option>
							  <option value="#46d6db">Turquoise</option>
							  <option value="#7ae7bf">Light green</option>
							  <option value="#51b749">Bold green</option>
							  <option value="#fbd75b">Yellow</option>
							  <option value="#ffb878">Orange</option>
							  <option value="#ff887c">Red</option>
							  <option value="#dc2127">Bold red</option>
							  <option value="#dbadff">Purple</option>
							  <option value="#e1e1e1">Gray</option>
							  <option value="#7bd148">Green</option>
							  <option value="#5484ed">Bold blue</option>
							  <option value="#a4bdfc">Blue</option>
							  <option value="#46d6db">Turquoise</option>
							  <option value="#fbd75b">Yellow</option>
							  <option value="#ffb878">Orange</option>
							</select>-->
						</div>
						<!--<div class="col-md-6">
							<b>WOHNRAUM WÄHLEN</b>
							<div id="thumbcarousel" class="carousel slide small_carousel frame_carsole" data-interval="false">
	                    	<div class="carousel-inner">
		                        <div class="item active">
		                            <div data-target="#carousel" data-slide-to="0" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-1.jpg" alt="">
		                            </div>
		                            <div data-target="#carousel" data-slide-to="1" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-2.jpg" alt="">
		                            </div>

		                            <div data-target="#carousel" data-slide-to="2" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-3.jpg" alt="">
		                            </div>
		                            <div data-target="#carousel" data-slide-to="3" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-3.jpg" alt="">
		                            </div>
		                        </div>
		                        <div class="item">
		                            <div data-target="#carousel" data-slide-to="3" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-4.jpg" alt="">
		                            </div>
		                            <div data-target="#carousel" data-slide-to="4" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-5.jpg" alt="">
		                            </div>
		                            <div data-target="#carousel" data-slide-to="5" class="thumb">
		                                <img src="<?php echo $this->webroot;?>images/multi-thumb-6.jpg" alt="">
		                            </div>
		                        </div>
	                    	</div>
	                    	<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
	                        	<i class="fa fa-angle-left"></i>
	                    	</a>
	                    	<a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
	                        	<i class="fa fa-angle-right"></i>
	                    	</a>
                			</div>
						</div>-->
						<div class="clearfix"></div>
					</div>
					<!--<div class="col-md-12 green_table">
						<h3>GESAMTPREIS</h3>
						<table>
							<tr>
								<td>Versandfertig in</td>
								<td>8 Arbeitstagen</td>
								<td><h3>590,77 EUR</h3>
								<p>Alle Preise incl. MwSt.</p>
								<a href="">Versandkosten hier</a> 
								</td>
								<td><button class="btn btn-primary"> ADD TO CART</button></td>
							</tr>
						</table>
						<h3>SO IT TURNS YOUR PRICE TOGETHER</h3>
						<table>
							<tr>
								<td>Gemälde</td>
								<td>Selbstbildnis mit Barett (Claude Monet) 
								120,00 x 143,00 cm </td>
								<td>139,11 EUR </td>
							</tr>
							<tr>
								<td>Motivgröße Größe mit Rand:</td>
								<td>130,00 x 153,00 cm </td>
								<td>2,60 EUR</td>
							</tr>
							<tr>
								<td>Bilderrahmen</td>
								<td>Auf Mdf Bilderrahmenrückwand aufziehen 
								Rahmen 4484748 Klassik: Silber,  Profilbreite 4,40 cm
								Um die Stabilität zu gewährleisten, wird Ihrem Rahmen eine Versteifung hinzugefügt.
								</td>
								<td>2,60 EUR</td>
							</tr>
							<tr>
								<td>Gemälde</td>
								<td>Selbstbildnis mit Barett (Claude Monet) 
								120,00 x 143,00 cm </td>
								<td>139,11 EUR </td>
							</tr>
						</table>
						<h3>IHRE RABATTE</h3>
						<table>
							<tr>
								<td>Gemälderabatt: </td>
								<td>Selbstbildnis mit Barett (Claude Monet) 
								120,00 x 143,00 cm </td>
								<td>139,11 EUR </td>
							</tr>
						</table>
					</div>-->
					<!--<div class="row">
					<div class="col-md-12">
					<div class="tabs">
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">INFOS ZUM KUNSTWERK</a></li>
					    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">KUNDENSTIMMEN</a></li>
					  </ul>
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="home">
					    	<table>
								<tr>
									<td>Künstler:</td>
									<td>Claude Monet (1840 - 1926)</td>
								</tr>
								<tr>
									<td>Kunststil:</td>
									<td>Impressionismus</td>
								</tr>
								<tr>
									<td>Werk:</td>
									<td>Selbstbildnis mit Barett (1886)</td>
								</tr>
								<tr>
									<td>Originalgröße:</td>
									<td>46 x 56 cm Technik Öl Leinwand</td>
								</tr>
								<tr>
									<td>Standort:</td>
									<td>London, Private Collection Lefevre Fine Art Ltd.</td>
								</tr>
								<tr>
									<td>Bildnummer:</td>
									<td> LEF220978</td>
								</tr>
								<tr>
									<td>EAN-Nummer:</td>
									<td>4050356825341 Bild bridgeman berlin</td>
								</tr>
							</table>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="profile">
					    	13.11.2010
Klemens T. schrieb:

die Signatur war nicht mehr lesba, sollte bei einer hochauflösenden Vorlage eigentlich nicht vorkommen. Sont sehr guter Gesamteindruck.
50 x 60 cm
Echte Malerleinwand mit Firnis veredelt (410g)

					    </div>
					  </div>
					</div>
					</div>
					</div>-->
				</div>
				<div class="col-md-3 right_frame">
					<table>
						<tr>
							<td>Preis:</td>
							<td>Alle Preise incl. MwSt.</td>
						</tr>
						<tr>
							<td>0 EUR</td>
							<td>Versandkosten hier</td>
						</tr>
					</table>
					<button class="btn btn-primary btn-block">
						<i class="fa fa-shopping-cart"></i>Add to cart
					</button>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="headingOne">
					      <h4 class="panel-title">
					        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					         PRODUCT SIZE
					        </a>
					      </h4>
					    </div>
					    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body first_panel">
					        <h3>Choose Size(cm)</h3>
					        <div class="size_box">
					        	<input type="text" placeholder="↔ cm" id="imagewidth" name="imagewidth" onfocus="onErrorFocus('VS_WIDTH');" onkeyup="calculateSize('h','cm');"/>
					        	<b>X</b>
					        	<input type="text" placeholder="↕ cm" id="imageheight" name="imageheight" onfocus="onErrorFocus('VS_HEIGHT');" onkeyup="calculateSize('w','cm');"/> 
					        	<input type="hidden" id="imageoriginalwidth" name="imageoriginalwidth" value="<?php echo $product['ProductImage'][0]['max_width'];?>"/> 
					        	<input type="hidden" id="imageoriginalheight" name="imageoriginalheight" value="<?php echo $product['ProductImage'][0]['max_height'];?>"/> 
					        	<button class="btn btn-primary" onclick="savesize();">OK</button>
					        	<button class="btn btn_cut"><i class="fa fa-cut"></i></button>
					        </div>
					        <!--<h3>2. Schritt: Material/ Produkt ändern</h3>
					        <ul>
						   <li>
						     <img src="<?php echo $this->webroot;?>images/multi-thumb-1.jpg" alt="" />
						     Um die Stabilität zu gewährleisten, wird Ihrem Rahmen eine Versteifung hinzugefügt.
						   </li>
						   <li>
						     <img src="<?php echo $this->webroot;?>images/multi-thumb-1.jpg" alt="" />
						     Um die Stabilität zu gewährleisten, wird Ihrem Rahmen eine Versteifung hinzugefügt.
						   </li>
						   <li>
						     <img src="<?php echo $this->webroot;?>images/multi-thumb-1.jpg" alt="" />
						     Um die Stabilität zu gewährleisten, wird Ihrem Rahmen eine Versteifung hinzugefügt.
						   </li>
						</ul>-->
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="headingTwo">
					      <h4 class="panel-title">
					        <a class="collapsed" role="button" data-parent="#accordion" href="javascript:void(0);" aria-expanded="false" aria-controls="collapseTwo" id="framecollapse">
					         FRAMES
					        </a>
					      </h4>
					    </div>
					    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					      <div class="panel-body second_panel">
					        <div class="frame_search">
				        	  <select name="">
				        		<option>Modern</option>
				        		<option>Modern</option>
				        		<option>Modern</option>
				        	  </select>
					        </div>
					        <input type="hidden" id="selectedframecode" value=''>
					        <ul>
						 <?php 
						  if(!empty($frames)){ 
						    foreach($frames as $frame){
						 ?>	
						      <li>
							<a href="javascript:void(0);" onclick="setFrame('<?php echo $frame['Frame']['code']; ?>');"><img src="<?php echo $this->webroot;?>images/<?php echo $frame['Frame']['pic1']; ?>" alt="<?php echo $frame['Frame']['pic1']; ?>" /></a>
							<?php echo $frame['Frame']['code']; ?>
							<b>?</b>
						      </li>
						  <?php }} ?>
						</ul>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="headingThree">
					      <h4 class="panel-title">
					        <a class="collapsed" role="button" data-parent="#accordion" href="javascript:void(0);" aria-expanded="false" aria-controls="collapseThree" id="passepartoutcollapse">PASSEPARTOUTS
					        </a>
					      </h4>
					    </div>
					    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					      <div class="panel-body third_panel">
					       <h3>Passepartout-Maße eingeben in cm</h3>
					       <h3>Farbe bestimmen</h3>
					       <div class="image_squre">
					       		<input type="text" class="top_box" placeholder="In cm" id="padding_top"/>
					       		<input type="text" class="bottom_box" placeholder="In cm" id="padding_bottom"/>
					       		<input type="text" class="left_box" placeholder="In cm" id="padding_left"/>
					       		<input type="text" class="right_box" placeholder="In cm" id="padding_right"/>
					       		<img src="<?php echo $this->webroot;?>product_images/<?php echo $product['ProductImage'][0]['name'];?>" alt="<?php echo $product['ProductImage'][0]['name'];?>" placeholder="In cm"/>
					       </div>
					       <ul>
						<?php 
						  if(!empty($passepartouts)){ 
						    foreach($passepartouts as $passepartout){
						 ?>	
						      <li>
							<a href="javascript:void(0);" onclick="setPadding('<?php echo $passepartout['Passepartout']['colour']; ?>');"><img src="<?php echo $this->webroot;?>images/<?php echo $passepartout['Passepartout']['pic1']; ?>" alt="<?php echo $passepartout['Passepartout']['pic1']; ?>" /></a>
							<?php echo $passepartout['Passepartout']['code']; ?>
							<b>%</b>
						      </li>
						  <?php }} ?>	
						 </ul>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="headingFour">

					      <h4 class="panel-title">
					        <a class="collapsed" role="button" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" data-toggle="collapse">BACKGROUND COLOR
					        </a>
					      </h4>
					    </div>
					    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
					      <div class="panel-body third_panel">
					       <div id="mycolor"></div>
					      </div>
					    </div>
					  </div>
					  
					</div>
				</div>
			</div>
   		</div>
 </section>
 <style>
  #kk_fs-motivView {text-align: center;position: relative;top: 0px;left: 0px;width: 99.6%;z-index: 2;background:rgb(224, 230, 248);}
  #kk_bg_area{position: relative;width: auto;overflow: hidden;padding: 0px;vertical-align: top;display: run-in;border: 0px solid red;}
  div.kk_bg_layer {height: 100%;width: 100%;z-index: 0;position: relative;display: inline-table;}
  #kk_motiv_lay {background-repeat: no-repeat;background-position: center;position: absolute;top: 50px;margin-left: auto;margin-right: auto;height: auto;display: table;left: 0px;}
  .kk_clear {clear: both;}
 </style>
 <script>
   function savesize()
   {
      var height=$('#imageheight').val();
      var width=$('#imagewidth').val();
      if(width!='' && height!='')
      {
        $('#framecollapse').attr('href','#collapseTwo');
        $('#framecollapse').attr('data-toggle','collapse');
        $('#passepartoutcollapse').attr('href','#collapseThree');
        $('#passepartoutcollapse').attr('data-toggle','collapse');
        $('#framecollapse').click();
      }
   }
   function onErrorFocus(param)
   {
     if(param=="VS_WIDTH")
     {
       $('#imageheight').val('');
     }
     else if(param=="VS_HEIGHT")
     {
       $('#imagewidth').val('');
     }
   }
   function calculateSize(type,unit)
   {
     var imageoriginalwidth=$('#imageoriginalwidth').val();
     var imageoriginalheight=$('#imageoriginalheight').val();
     var width_height_ratio=(imageoriginalwidth/imageoriginalheight);
     if(type=="h")
     {
       var insertedwidth=$('#imagewidth').val();
       var height=parseInt(insertedwidth*width_height_ratio);
       $('#imageheight').val(height);
     }
     else if(type=="w")
     {
       var insertedheight=$('#imageheight').val();
       var width=parseInt(insertedheight*width_height_ratio);
       $('#imagewidth').val(width);
     }
   }
   function setPadding(color)
   {
     var padding_top=$('#padding_top').val();
     var padding_bottom=$('#padding_bottom').val();
     var padding_left=$('#padding_left').val();
     var padding_right=$('#padding_right').val();
     if(padding_top=='')
     {
       $('#padding_top').css('border','1px solid red');
       $('#padding_bottom').css('border','1px solid #ccc');
       $('#padding_left').css('border','1px solid #ccc');
       $('#padding_right').css('border','1px solid #ccc');
     }
     else if(padding_right=='')
     {
       $('#padding_top').css('border','1px solid #ccc');
       $('#padding_bottom').css('border','1px solid #ccc');
       $('#padding_left').css('border','1px solid #ccc');
       $('#padding_right').css('border','1px solid red');
     }
     else if(padding_bottom=='')
     {
       $('#padding_top').css('border','1px solid #ccc');
       $('#padding_bottom').css('border','1px solid red');
       $('#padding_left').css('border','1px solid #ccc');
       $('#padding_right').css('border','1px solid #ccc');
     }
     else if(padding_left=='')
     {
       $('#padding_top').css('border','1px solid #ccc');
       $('#padding_bottom').css('border','1px solid #ccc');
       $('#padding_left').css('border','1px solid red');
       $('#padding_right').css('border','1px solid #ccc');
     }
     if(padding_top!='' && padding_right!='' && padding_bottom!='' && padding_left!='')
     {
        $('#secondlayerborder').css('border-top',(padding_top*10)+'px solid '+color);
        $('#secondlayerborder').css('border-right',(padding_right*10)+'px solid '+color);
        $('#secondlayerborder').css('border-bottom',(padding_bottom*10)+'px solid '+color);
        $('#secondlayerborder').css('border-left',(padding_left*10)+'px solid '+color);
        $('#secondlayerborder').css('background-color',color);
        $('#secondlayerborder').css('margin','0px 0px 0px 0px');
        var image_width=$('#detail_image').attr('width');
        var total_width=parseInt(image_width)+parseInt(padding_right*10)+parseInt(padding_left*10)+4;
        $('#secondlayerborder').css('width',total_width+'px');
        $('#thirdlayerborder').css('background-color',color);
        var selectedframecode=$('#selectedframecode').val();
        if(selectedframecode!='')
        {
          setFrame(selectedframecode);
        }
     }
   }
   function setFrame(framecode)
   {
     $('#selectedframecode').val(framecode);
     var innerframewidth=$('#secondlayerborder').css('width');
     var innerframeheight=$('#secondlayerborder').css('height');
     var innerframewidthsubstr=innerframewidth.substr(0,(innerframewidth.length-2));
     var innerframeheightsubstr=innerframeheight.substr(0,(innerframeheight.length-2));
     $('#outer_div').css('width',(parseInt(innerframewidthsubstr)+78)+'px');
     $('#outer_div').css('height',innerframeheight);
     $('#topcorner').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-ol-b.jpg" style="vertical-align:top;width:39px;height:39px;" border="0">');
     $('#tophorizontal').css('width',innerframewidth);
     $('#tophorizontal').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-o-b.jpg" style="vertical-align:top;width:'+innerframewidth+';height:39px;" border="0">');
     $('#rightcorner').css('left',(parseInt(innerframewidthsubstr)+39)+'px');
     $('#rightcorner').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-or-b.jpg" style="vertical-align:top;width:39px;height:39px;" border="0">');
     $('#leftvertical').css('height',innerframeheight);
     $('#leftvertical').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-l-b.jpg" style="vertical-align:top;width:39px;height:'+innerframeheight+'" border="0">');
     $('#rightvertical').css('height',innerframeheight);
     $('#rightvertical').css('left',(parseInt(innerframewidthsubstr)+39)+'px');
     $('#rightvertical').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-r-b.jpg" style="vertical-align:top;width:39px;height:'+innerframeheight+'" border="0">');
     $('#leftbottomcorner').css('top',(parseInt(innerframeheightsubstr)+39)+'px');
     $('#leftbottomcorner').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-ul-b.jpg" style="vertical-align:top;width:39px;height:39px" border="0">');
     $('#bottomhorizontal').css('top',(parseInt(innerframeheightsubstr)+39)+'px');
     $('#bottomhorizontal').css('width',innerframewidth);
     $('#bottomhorizontal').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-u-b.jpg" style="vertical-align:top;width:'+innerframewidth+';height:39px" border="0">');
     $('#rightbottomcorner').css('top',(parseInt(innerframeheightsubstr)+39)+'px');
     $('#rightbottomcorner').css('left',(parseInt(innerframewidthsubstr)+39)+'px');
     $('#rightbottomcorner').html('<img src="<?php echo $this->webroot;?>images/'+framecode+'-ur-b.jpg" style="vertical-align:top;width:39px;height:39px" border="0">');
     $('#thirdlayerborder').css('top','39px');
     $('#thirdlayerborder').css('left','39px');
     $('#thirdlayerborder').css('margin','0px 0px 0px 0px');
     $('#thirdlayerborder').css('padding','0px 0px 0px 0px');
     $('#thirdlayerborder').css('width',innerframewidth);
     $('#thirdlayerborder').css('height',innerframeheight);
   }
 </script>
 
