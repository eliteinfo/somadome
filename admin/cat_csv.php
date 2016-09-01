<?php 
session_start();
include('../lib/module.php');
if($_SESSION['classgod_id']=='')
{
	echo "<script>window.location='login.php' </script>";
}
?>
<!DOCTYPE html>
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
    <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
    <link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap.css" />
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
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <?php include('includes/leftbar.inc.php'); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <?php include('includes/cat_csv.inc.php'); ?>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php include('includes/footer.inc.php'); ?>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->   
    <!-- BEGIN CORE PLUGINS -->   
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
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/app.js"></script>
<!--<script src="assets/scripts/form-validation.js"></script>--> 
    <script src="assets/scripts/table-advanced.js"></script>     
    <script type="text/javascript">
        jQuery(document).ready(function() {       
             jQuery('#sample_1').dataTable({
"aLengthMenu": [
                    [50, 100, 200, -1],
                    [50, 100, 200, "All"] // change per page values here
                ],
 "iDisplayLength": 50,
});
           App.init();
          FormValidation.init();
          TableAdvanced.init();
        });
    </script>
    
    <script>
    
        var moveLeft = 0;
        var moveDown = 0;
    
        $('a.popper').hover(function(e) {
            var target = '#' + ($(this).attr('data-popbox'));
             
            $(target).show();
            moveLeft = $(this).outerWidth();
            moveDown = ($(target).outerHeight() / 2);
        }, function() {
            var target = '#' + ($(this).attr('data-popbox'));
            $(target).hide();
        });
     
        $('a.popper').mousemove(function(e) {
            var target = '#' + ($(this).attr('data-popbox'));
             
            leftD = e.pageX + parseInt(moveLeft);
            maxRight = leftD + $(target).outerWidth();
            windowLeft = $(window).width() - 40;
            windowRight = 0;
            maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 20);
             
            if(maxRight > windowLeft && maxLeft > windowRight)
            {
                leftD = maxLeft;
            }
         
            topD = e.pageY - parseInt(moveDown);
            maxBottom = parseInt(e.pageY + parseInt(moveDown) + 20);
            windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
            maxTop = topD;
            windowTop = parseInt($(document).scrollTop());
            if(maxBottom > windowBottom)
            {
                topD = windowBottom - $(target).outerHeight() - 20;
            } else if(maxTop < windowTop){
                topD = windowTop + 20;
            }
         
            $(target).css('top', topD).css('left', leftD);
        });
        function doYouWantTo(id){
          doIt=confirm('Do you want to delete it?');
          if(doIt){
            window.location.href = 'cat_list.php?id='+id;
          }
          else{
              return false;
          }
          return false;
        }
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>