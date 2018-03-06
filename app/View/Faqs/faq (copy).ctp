<section class="faq">

<div class="container">
	<div class="row">

		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="RHS">
                           <h3>FAQ</h3>
                                        <?php

                                           foreach ($faqs as $faq){
                                        ?>

				       <button class="accordion"><?php echo $faq['Faq']['question'];?></button>
					<div class="panel">
					  <p><?php echo $faq['Faq']['answer']?></p>
					</div>

                                       <?php
                                         }
                                       ?>


					</div>
				</div>
			</div>
		</div>

</section>

<script>


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  }
}

$(".profile_menu li a").click(function(){
    	$(".profile_menu li a").removeClass("active");
    	$(this).addClass("active");

});
</script>