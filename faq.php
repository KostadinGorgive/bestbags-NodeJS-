<?php
require("./header.php");
?>				


<div class="content faq" style="flex-direction: column;">
	<div class="page-title">General FAQ:</div>

	<li class="q">How do I register in the shop?</li>
	<li class="a">Account registration costs 40$ to start using our services.Unactivated accounts deleted weekly.</li>
	<li class="q">Can I withdraw my money from the shop?</li>
	<li class="a">No, we don't offer this option in our shop.</li>


	<div class="page-title">CARDS FAQ:</div>
	<li class="q">I bought a card and it's invalid and the checker marked it as VALID.</li>
	<li class="a">We cannot guarantee any balance on the cards you purchase. and we don't refund or replace for invalid address, state.</li>
	<li class="q">Can I get a refund for the VALID cards?</li>
	<li class="a">No, we can't refund or replace it if the checker marked the card as VALID, Please dont contact us about this.</li>
	<li class="q">How much is the cards checking time?</li>
	<li class="a">Checking time is <strong style="color:red;"> 10 minutes after you buy the card.</strong></li>

	<div class="page-title">PAYMENTS FAQ:</div>
	<li class="q">How much time do I need to wait after I sent the amount?</li>
	<li class="a">You need to wait until the transaction is confirmed. Bitcoin confirmations could take 5-3 hours. <strong style="color:red;"> if things going late, please feel free to contact our support.</strong></li>

	<div class="page-title">ACCOUNT FAQ:</div>
	<li class="q">My account has been deleted,why?</li>
	<li class="a">We have the right to delete any account and ban it for a reason , and we don't gonna restore it .</li>
	<li class="q">How I can change my account password? </li>
	<li class="a">For your security you can't, you have to contact us in jabber with your Jabber id.</li>
                     <p></p>
                                          <p></p>
                                                               <p></p>
                                                                                    <p></p>
                                                                                                         <p></p>
                                                                                                                              <p></p>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

$('li.q').on("click", function() {
	// Get next element
	$(this).next().slideToggle("500").siblings('li.a').slideUp();
});
</script>



