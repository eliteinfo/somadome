<?php 

$fb_link = $objData->getAll("select * from social_links WHERE Id='1'");

$twitter_link = $objData->getAll("select * from social_links WHERE Id='2'");

$insta_link = $objData->getAll("select * from social_links WHERE Id='3'"); 

?>

<div class="footer">

	<div class="wrapper">

    	<div class="fleft">&copy; Somadome <?php echo date('Y');?> ・ Santa Monica, CA <br />・ 415-640-5806 ・ <a href="mailto:<?php echo $objModule->INFO_MAIL; ?>"><?php echo $objModule->INFO_MAIL; ?></a> | <a href="<?php echo $objData->SITEURL; ?>privacy-policy.php">Privacy Policy</a></div>

        <div class="fright">

        	<a href="<?php echo $twitter_link[0]['Link']; ?>" target="blank"><i class="fa fa-twitter"></i></a>            

        	<a href="<?php echo $fb_link[0]['Link']; ?>" target="blank"><i class="fa fa-facebook"></i></a>

        	<a href="<?php echo $insta_link[0]['Link']; ?>" target="blank"><i class="fa fa-instagram"></i></a>            

        </div>

    </div>

</div> <!-- footer ends -->



<script type="text/javascript" src="../js/common.js"></script>

</div>

</body>

</html>

