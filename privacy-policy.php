<?php include('includes/header.inc.php');
$getPrivacyContent = $objData->getAll("Select * from contents where id = 4")
?>
<div class="midcont">
<div class="wrapper">
	<?php echo $getPrivacyContent[0]['detail']; ?>

</div><!-- wrapper ends -->
<div class="push"></div>
</div><!-- midcont ends -->

<?php include('includes/footer.inc.php');?>
<script>
	$(document).on('click','#load_more',function(){
		//alert(66);
		var total_domes=$('#total_domes').val();
		var last_limit=$('#last_limit').val();
		//alert(last_limit);
		//alert(total_domes);
		if(last_limit>total_domes)
		{
			$('.ldmrtxt').css('display', 'none');
			$('.ldmrimg').css('display', 'inline-block');
			var total_domes=$('#total_domes').val();
			var user_id = $('#user').val();
			$.ajax({
				type: 'POST',
				url: "ajax.php",
				data: {limit: last_limit, CMD: "MORE_DOMES", Uid: user_id},
				success: function (result) {
					$('.searchlist').append(result);
					$('.ldmrtxt').css('display', 'inline-block');
					$('.ldmrimg').css('display', 'none');
					var newlimit=(parseInt(last_limit)+ parseInt(6));
					$('#last_limit').val(newlimit);
					if(newlimit>=total_domes) {
						$('#load_more').css('display','none');
					}
				}
			});
		}
		else
		{
			$('#load_more').css('display','none');
		}
	});
</script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    //$( document ).tooltip();
  });
  </script>
