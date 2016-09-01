<?php
if(isset($_GET['sid']) && $_GET['sid'] != ''){
	$objData->setTableDetails("tbl_users",'Id');
	if($_GET['sid'] == 0){
	$objData->setFieldValues("Status",'1');
	}else{
		$objData->setFieldValues("Status",'0');
	}
	$objData->setWhere("Id='".$_GET['uid']."'");
	$objData->update();
	$objModule->redirect('buyer_list.php');
}
?>
<?php
if(isset($_GET['status']) && $_GET['status'] == '1'){
   $member = "select * from tbl_users WHERE Status=1 AND User_type='1'";
}else if (isset($_GET['status']) && $_GET['status'] == '0') {
   $member = "select * from tbl_users WHERE Status=0 AND User_type='1'";
}else{
   $member = "select * from tbl_users WHERE User_type='1'";
}
$db_member = $objData->getAll($member);
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
                    List Tutors
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        List Tutors
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
                <?php /* ?><div class="" style="margin-bottom:10px; float:right">
                    <a href="add_users.php"><button id="sample_editable_1_new" class="btn green">
                    Add New <i class="icon-plus"></i>
                    </button></a>
                </div><?php */ ?>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List Tutors</div>
                    </div>
                    <div class="portlet-body">
                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <?php if(!empty($db_member)) { ?>
	                        <thead>
                                <tr>
                                	<th style="display:none"></th>
                                	<th width="25px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Detail</th>  
                                </tr>
                            </thead>
                            <tbody>
                             <?php  for($i=0;$i<count($db_member);$i++)
							 {
								 ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                	<td><?php echo ($i+1);?></td>
                                    <td><?php echo ucfirst($db_member[$i]['fname'])." ".ucfirst($db_member[$i]['lname']);?></td>
                                    <td><?php echo $db_member[$i]['Email'];?></td>
                                    <?php /* ?> <td><?php echo date('d M Y',strtotime($db_member[$i]['Creation_date']));?></td>	<?php */ ?>
                                    <td><?php if($db_member[$i]['Status']=="1"){ echo '<a href="" onclick="return doYouWantToActive('.$db_member[$i]['Status'].','.$db_member[$i]['Id'].');" class="btn mini green">'."Active".'</a>';}else { echo '<a href="#" onclick="return doYouWantToActive('.$db_member[$i]['Status'].','.$db_member[$i]['Id'].');" class="btn mini orange">'."Inactive".'</a>';} ?></td>	
                                      <td width="80px"><a href="view_ttr.php?id=<?php echo $db_member[$i]['Id']; ?>" class="btn mini green"><i class="icon-edit"></i>Detail</a></td>                                          
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
function doYouWantToActive(id,uid){
	
	//doIt=confirm('Are you sure to Inctive this User?');
	
	//alert(uid);
	if(id == 1){
		
		doIt=confirm('Are you sure to Inctive this User?');
		
		if(doIt){
			
			window.location.href = 'tutor_list.php?sid='+id+'&uid='+uid;
			
		  }
		  else{
			 return false;
		  }
	}else {
		
		doIt2=confirm('Are you sure to Active this User?');
	
		  if(doIt2){
			 //document.form_sample_3.flag.value = uid;
			 window.location.href = 'tutor_list.php?sid='+id+'&uid='+uid;
		  }
		  else{
			  return false
		  }
		
	}
	return false;
	
}
</script>