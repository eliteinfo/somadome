<?php 
include('../lib/module.php');
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

 

    <title>Category | <?php echo $_SESSION['classgod_site']; ?></title>

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

		<?php include('includes/add_new_subcategory.inc.php'); ?>

		<!-- END PAGE -->  

	</div>

	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->

	<?php include('includes/footer.inc.php'); ?>

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
		
				
				//check if email exists
						
				
			
		   App.init();
		   FormValidation.init();
		   FormComponents.init();
		});
		
function check_data()
{
		
		name = jQuery("#catname").val();
		
		if(name=='')
		{
		
			jQuery("#catname").closest('.control-group').addClass('error');
			jQuery( "#catname" ).after( "<span for=catname class=help-inline>This field is required.</span>" );
			jQuery(".alert-error").show();
			return false;
                        
		}
var btn_val = jQuery("#btn_add").val();

	if(btn_val == "Add"){
		jQuery.ajax({
			type: "POST",
			url: "ajax.php",
			data: ({
				name: jQuery("#catname").val(),
				btn_val: btn_val,
			}),
			cache: false,
			success: function(data)
			{	
														
				if(data == 0) 
				{												
					jQuery("#catname").closest('.control-group').removeClass('success').addClass('error');
					alert("Category already Exist, Please Enter another one.");
					return false;
				}
				else if (data==1)
				{
					jQuery(".alert-error").hide();
					document.form_sample_2.action = "add_new_category.php";
					document.form_sample_2.submit(); 
					return true;
				}											
			}
		});
	}else if(btn_val == "Edit"){
		var cat_id = "<?php echo $_GET['id']; ?>";		
		jQuery.ajax({
			type: "POST",
			url: "ajax.php",
			data: ({				
				name: jQuery("#catname").val(),
				cat_id: cat_id,
				btn_val: btn_val,
			}),
			cache: false,
			success: function(data)
			{	
				//alert(data);								
				if(data == 0) 
				{			
													
					jQuery("#catname").closest('.control-group').removeClass('success').addClass('error');
					alert("Category already Exist, Please Enter another one.");
					return false;
				}
				else if (data==1)
				{
					jQuery(".alert-error").hide();
					document.form_sample_2.action = "add_new_category.php";
					document.form_sample_2.submit(); 
					return true;
				}											
			}
		});
	}
}
	</script>

   

	<!-- END JAVASCRIPTS -->   

</body>

<!-- END BODY -->

</html>