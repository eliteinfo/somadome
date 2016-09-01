<?php
include('../lib/module.php');
if ($_SESSION['admin_id'] == '')
{
    $objModule->redirect('login.php');
}
$arrCustomers = $objModule->getAll("select (select count(*)  from soma_customers WHERE Cstatus='1')as tcustomer FROM soma_customers");
$arrUnits = $objModule->getAll("select (select count(*)  from soma_units WHERE unitstatus='1')as tunit FROM soma_units");
$arrUsers = $objModule->getAll("select (select count(*)  from soma_users WHERE Ustatus='1')as tuser FROM soma_units");

//echo "<pre>";print_r($objModule);die;
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />  
        <title>Dashboard | <?php echo $_SESSION['Somadome_site']; ?></title>
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
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 
        <?php /* ?><link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/><?php */ ?>
        <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
        <!-- END PAGE LEVEL PLUGIN STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES --> 
        <link href="assets/css/pages/tasks.css" rel="stylesheet" type="text/css" media="screen"/>
        <!-- END PAGE LEVEL STYLES -->
        <link rel="shortcut icon" href="../upload/site/favicon.ico" />
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
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div id="portlet-config" class="modal hide">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"></button>
                        <h3>Widget Settings</h3>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                </div>
                <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <!-- BEGIN PAGE CONTAINER-->
                <div class="container-fluid">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- END PAGE HEADER-->
                    <div class="row-fluid">
                        <div class="span12">
                            <!-- BEGIN STYLE CUSTOMIZER -->
                            <div class="color-panel hidden-phone">
                                <?php //include('includes/inner_header.inc.php');   ?>
                            </div>
                            <!-- END BEGIN STYLE CUSTOMIZER -->    
                            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                            <h3 class="page-title">
                                Dashboard <small>Statistics And More</small>
                            </h3>
                            <ul class="breadcrumb">
                                <li>
                                    <i class="icon-home"></i>
                                    <a href="dashboard.php">Home</a> 
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li>Dashboard</li>
                            </ul>
                            <!-- END PAGE TITLE & BREADCRUMB-->
                        </div>
                    </div>
                    <div id="dashboard">
                        <!-- BEGIN DASHBOARD STATS -->
                        <div class="row-fluid">
                            <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                                <div class="dashboard-stat blue">
                                    <div class="visual">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <?php echo $arrCustomers[0]['tcustomer']; ?>
                                        </div>
                                        <div class="desc">                           
                                            Total Hosts
                                        </div>
                                    </div>
                                    <a class="more" href="list_customers.php">
                                        View more <i class="m-icon-swapright m-icon-white"></i>
                                    </a>                 
                                </div>
                            </div>
							 <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                                <div class="dashboard-stat yellow">
                                    <div class="visual">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <?php echo $arrUnits[0]['tunit']; ?>
                                        </div>
                                        <div class="desc">                           
                                            Total Domes
                                        </div>
                                    </div>
                                    <a class="more" href="list_units.php">
                                        View more <i class="m-icon-swapright m-icon-white"></i>
                                    </a>                 
                                </div>
                            </div>
							 <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                                <div class="dashboard-stat green">
                                    <div class="visual">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <?php echo $arrUsers[0]['tuser']; ?>
                                        </div>
                                        <div class="desc">                           
                                            Total Users
                                        </div>
                                    </div>
                                    <a class="more" href="list_users.php">
                                        View more <i class="m-icon-swapright m-icon-white"></i>
                                    </a>                 
                                </div>
                            </div>
                         
                            <div class="clearfix"></div>
                        </div>
                      
                        
                        
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->    
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="footer-inner">
            <?php echo date('Y'); ?> &copy; <?php echo $_SESSION['Somadome_site']; ?>
        </div>
        <div class="footer-tools">
            <span class="go-top">
                <i class="icon-angle-up"></i>
            </span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
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
    <script src="assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>   
    <script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
    <script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
    <script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script src="assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>  
    <script src="assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/date.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>     
    <?php /* ?><script src="assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script><?php */ ?>
    <script src="assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>  
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/app.js" type="text/javascript"></script>
    <script src="assets/scripts/index.js" type="text/javascript"></script>
    <script src="assets/scripts/tasks.js" type="text/javascript"></script>        
    <!-- END PAGE LEVEL SCRIPTS -->  
    <script>
        jQuery(document).ready(function () {
            App.init(); // initlayout and core plugins
            Index.init();
            Index.initJQVMAP(); // init index page's custom scripts
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
            Index.initDashboardDaterange();
            Index.initIntro();
            Tasks.initDashboardWidget();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>