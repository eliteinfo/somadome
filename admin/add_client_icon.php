<?php
session_start();
include('../lib/module.php');
include('../lib/simpleimage.php');
if($_SESSION['classgod_id'] == '')
{
    echo "<script> window.location.href = 'login.php' </script>";	
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Client Icon | <?php echo $_SESSION['site_name']; ?></title>
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
    <?php include('includes/add_client_icon.inc.php'); ?>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.inc.php'); ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->   <script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
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
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<script src="assets/scripts/app.js"></script>
	<script src="assets/scripts/form-validation.js"></script> 
	<!-- END PAGE LEVEL STYLES -->    
	<script>
		jQuery(document).ready(function() {   
		   // initiate layout and plugins
		   App.init();
		   FormValidation.init();
		});
	</script>
    <script>
	function addFile()
    {		
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());				
        if (intCnt == 10 || intCnt > 10)
        {
            alert("Maximum 10 files allowed");
            return false;
        }
        jQuery.ajax({
            url: 'ajax.php',
            data: {CMD: "ADD_FILE"},
            type: 'POST',
            cache: true,
            success: function (data)
            {					
                jQuery("#div1").append(data);                
				jQuery("#hdnFileCnt").val(intCnt + 1);	
            }
        });
    }
	
	function checkFile(fieldObj)
	{
	  var intLimit = parseFloat(10485760);
	  var FileName  = fieldObj.value;
	  var FileExt = FileName.substr(FileName.lastIndexOf('.')+1);
	  var FileSize = parseFloat(fieldObj.files[0].size);
	  if(FileSize>intLimit)
	  {
		  jQuery(fieldObj).val('');
		  alert("Maximum 10 mb per file allowed");
		  return false;
	  }
	}
	
	 function removeFile(strObj)
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        jQuery(strObj).parent("div.files").remove();
        jQuery("#hdnFileCnt").val(intCnt - 1);
    } 
	
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>