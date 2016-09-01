<?php 
session_start();
include('../lib/module.php');
include('../lib/simpleimage.php');
if($_SESSION['classgod_id']=='')
{
	echo "<script>window.location='login.php' </script>";
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
    <title>Tutor | <?php echo $_SESSION['classgod_site']; ?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
<style>
#responsive .help-inline
{
	display:none !important;
}
</style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
	<!-- BEGIN HEADER -->   
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<?php include('includes/header.inc.php'); ?>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php include('includes/leftbar.inc.php'); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->  
		<?php include('includes/tutor_add.inc.php'); ?>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			<?php echo date('Y'); ?> &copy; <?php echo $_SESSION['classgod_site']; ?>
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	 <script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<!--[if lt IE 9]>
	<script src="assets/plugins/excanvas.min.js"></script>
	<script src="assets/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>
    <!--<script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<!--<script src="assets/scripts/form-components.js"></script>-->
	<script src="assets/scripts/app.js"></script>
	<script src="assets/scripts/form-validation.js"></script> 
    
	<!-- END PAGE LEVEL STYLES -->    
	<script>
		jQuery(document).ready(function() {   
		   // initiate layout and plugins
		 var user = (jQuery('#usertype').val());
		 if(user==2 || user==3)
		 {
		 	
			jQuery('#credit').hide();
		}
		   App.init();
		   FormValidation.init();
		   FormComponents.init();
		  
		});
	</script>
<script>
	function add_credit()
	{
		 current_credit = $('#current_credit').val();
		 $('#credit_amount').val(current_credit);
		 $('#amt').html("  <b> +"+current_credit+ "<b>");
	}
	function credit_amount_fun()
	{
		credit_amount = $('#credit_amount').val();
		amount = $('#amount').val();
		id= $('#userid').val();
		$('.help-inline').hide();
		if(amount=='')
				{
					$('#amt_error_div').fadeIn();
					$('#amt_error_div').fadeOut(3000);
					$('#amount').focus();
					return false;								
				}
		if(amount!='')
				{
				finalamount = parseInt(credit_amount) + parseInt(amount);
				}
		jQuery.ajax({
										type: "POST",
										url: "add_credit.php",
										data: ({
											finalamount: finalamount,id:id
										}),
										cache: false,
										   complete: function(){
											   $('.help-inline').hide();
										   },
										success: function(data)
										{											
											$('.help-inline').hide();
											$('#amt_div').fadeIn();
											$('#amt_div').fadeOut(3000);
											$('#current_credit').val(finalamount);
											$('#amt').html("  <b> +"+finalamount+ "<b>");
											$('#amt_total_div').show();
											$('#amt_total_div').html('Total Credit Amount is : <b>' + finalamount + '</b>');
											$('#amount').val('');
										},										
									});		
	}
	function check_email(name){
		//alert(name);
		var checkemail = 'check_Email';
		$.ajax({
			url:'ajax.php',
			type:'POST',
			data:{
				name:name,email1:checkemail
				},
			success:function(msg){
				if(msg == 0){
					//alert(msg);
				alert('Email alredy exists');
				document.getElementById('newemail').focus();
				document.getElementById('newemail').value = '';
				return false;	
				}else{
					return true;
					}
				}
			});
	}
	function check_state(name){
		//alert(name);
		var checkstate = 'check_State';
		$.ajax({
			url:'ajax.php',
			type:'POST',
			data:{
				name:name,state:checkstate
				},
			success:function(msg){
				$('#app_state').html(msg);
				
				}
			});
	}
function show_credit(credit)
{
	if(credit==1)
	
		$('#credit').show();
	else
		$('#credit').hide();
}	
function change_credit()
{
	
	if($('#current_credit').val()<5)
	{
		$('#current_credit').val('5');
	}
	return false;
}
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function onlyAlphabets(e, t) {
            if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode==32) || (charCode==8) || (charCode==46) || (charCode==16) || (charCode==16) || (charCode==39))
                    return true;
                else
                    return false;
            }
	</script>
 
<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
$("#ufile").change(function(event,e) {
   var file, img;
	var name2 = this.name;
	var lastChar = name2.substr(name2.length - 1);
	
   if ((file = this.files[0])) {
       img = new Image();
       img.onload = function() {
		   if(this.height <= '250' || this.width <= '250'){
			alert('Image size atleast 250 x 250.');	
			var strImg	= document.getElementById("ufile");
			strImg.src = ''; 
			$('#ufile').val('');
			}
			/*if(this.height >= '500' || this.width >= '600'){
			alert('Image size should be 350 x 250.');	
			var strImg	= document.getElementById("ufile");
			strImg.src = ''; 
			$('#ufile').val('');
			}*/
	  	};
       img.onerror = function() {
           alert( "not a valid file: " + file.type);
       };
       img.src = _URL.createObjectURL(file);
	}
});
</script>
	<!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>