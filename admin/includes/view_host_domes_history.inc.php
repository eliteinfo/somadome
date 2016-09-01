<?php 
//$arrUser =  $objData->getAll("SELECT GROUP_CONCAT(Uid) as ids From soma_user_customer Where Cid = '".$_GET['Cid']."'");
//echo "SELECT GROUP_CONCAT(Uid) as ids From soma_user_customer Where Cid = '".$_GET['Cid']."'"; 
//echo"<pre>";print_r($arrUser);exit;

$arrUserId =  $objData->getAll("SELECT GROUP_CONCAT(Id) as ids From soma_units Where Cus_id = '".$_GET['Cid']."'");
//echo"<pre>";print_r($arrUser);exit;
$userIds = $arrUserId[0]['ids'];


//$data = $objData->getAll("SELECT * From soma_user_unit_booking Where  dom_id in(".$arrUser[0]['ids'].")");


$arrUser =  $objData->getAll("SELECT suub.*,su.unitname,su.unitid,u.Fname,u.Lname from soma_user_unit_booking suub, soma_units su, soma_users  u where suub.dom_id = su.Id AND suub.Uid = u.Uid AND suub.dom_id in(".$arrUserId[0]['ids'].") order by suub.Id desc");


//echo"<pre>";print_r($arrUser);exit;


//echo"SELECT * From soma_user_unit_booking Where dom_id in(".$arrUser[0]['ids'].")";exit;

//$id = explode(',',$userIds);
//echo"<pre>";print_r($id);exit;
//exit;
?>
<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button"></button>
            <h3>portlet Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here will be a configuration form</p>
        </div>
    </div>
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->        
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER -->
                <!--<div class="color-panel hidden-phone">
                    <div class="color-mode-icons icon-color"></div>
                    <div class="color-mode-icons icon-color-close"></div>
                    <div class="color-mode">
                        <p>THEME COLOR</p>
                        <ul class="inline">
                            <li class="color-black current color-default" data-style="default"></li>
                            <li class="color-blue" data-style="blue"></li>
                            <li class="color-brown" data-style="brown"></li>
                            <li class="color-purple" data-style="purple"></li>
                            <li class="color-grey" data-style="grey"></li>
                            <li class="color-white color-light" data-style="light"></li>
                        </ul>
                        <label>
                            <span>Layout</span>
                            <select class="layout-option m-wrap small">
                                <option value="fluid" selected>Fluid</option>
                                <option value="boxed">Boxed</option>
                            </select>
                        </label>
                        <label>
                            <span>Header</span>
                            <select class="header-option m-wrap small">
                                <option value="fixed" selected>Fixed</option>
                                <option value="default">Default</option>
                            </select>
                        </label>
                        <label>
                            <span>Sidebar</span>
                            <select class="sidebar-option m-wrap small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected>Default</option>
                            </select>
                        </label>
                        <label>
                            <span>Footer</span>
                            <select class="footer-option m-wrap small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected>Default</option>
                            </select>
                        </label>
                    </div>
                </div>-->
                <!-- END BEGIN STYLE CUSTOMIZER -->  
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    List Booking
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        List Booking
                    </li>
                    
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <!--<div class="" style="margin-bottom:10px; float:right">
                    <a href="add_users.php"><button id="sample_editable_1_new" class="btn green">
                    Add New <i class="icon-plus"></i>
                    </button></a>
                </div>-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List Booking</div>
                    </div>
                    <div class="portlet-body">
					 <?php echo $objModule->getMessage(); ?>
                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <?php if(!empty($arrUser)) { ?>
	                        <thead>
                                <tr>
                                	<th style="display:none"></th>
                                	<th width="25px">#</th>
                                    <th>UserName</th>
                                    <th>Book From Date</th>
							        <th>Book To Date</th>
                                    <th>Dome Name</th>
                                      
                                </tr>
                            </thead>
                            <tbody>
                             <?php  for($i=0;$i<count($arrUser);$i++)
							 { 
							 
							 
							
								 ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                	<td><?php echo ($i+1);?></td>
                                    <td><?php echo $arrUser[$i]['Fname'] ?></td>
                                    <td><?php echo $arrUser[$i]['from_date'].' '.$arrUser[$i]['from_time'] ?></td>
									<td><?php echo $arrUser[$i]['to_date'].' '.$arrUser[$i]['to_time'] ?></td>
                                    <td><?php echo $arrUser[$i]['unitname'] ?></td>	                                    
                                                                        
                                </tr>
                                <? }?>                              
                            </tbody>
                            <?php }
							else{
								echo "No Records Found";
								} ?>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<script type="text/javascript">
	function doYouWantTo(id){}
</script>
<style>
.size
{
	width:50px;
	height:50px;
}
</style>
<script>
function doYouWantToActive(id,Uid){
	
	
	//doIt=confirm('Are you sure to Inctive this User?');
	
	//alert(uid);
	if(id == 1){
		
		doIt=confirm('Are you sure to Inactive this User?');
		
		if(doIt){
			
			window.location.href = 'list_users.php?sid='+id+'&Uid='+Uid;
			
		  }
		  else{
			 return false;
		  }
	}else {
		
		doIt2=confirm('Are you sure to Active this User?');
	
		  if(doIt2){
			 //document.form_sample_3.flag.value = uid;
			 window.location.href = 'list_users.php?sid='+id+'&Uid='+Uid;
		  }
		  else{
			  return false
		  }
		
	}
	return false;
	
}
</script>