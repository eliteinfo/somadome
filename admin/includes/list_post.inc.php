<?php 
if(isset($_REQUEST['btnsubmit'])){
	$n = implode(",",$_REQUEST['chkbox']);
	$objData = new PCGData();
	$objData->setTableDetails("tbl_post", "id");
	$objData->setFieldValues("status", $_POST['cmbStatus']);
	$objData->setWhere("id IN (".$n.") ");
	$objData->update();
	unset($objData);
	echo "<script>window.location='list_post.php'</script>";
}
$sql="select *,CASE status WHEN '1' THEN 'Approved' ELSE 'Not Approve' END AS  sts from tbl_post WHERE 1 ";
if(isset($_GET['status']) && $_GET['status'] == 'runing'){
  $sql.="AND win_status='0' ";
}else if (isset($_GET['status']) && $_GET['status'] == 'awarded') {
  $sql.="AND  win_status='1'";
//  $sql="select * from tbl_post  WHERE status= '0' AND win_uid NOT IN('0') order by id";
}else if (isset($_GET['status']) && $_GET['status'] == 'completed') {
  $sql.="AND win_status='2'";
}else if (isset($_GET['status']) && $_GET['status'] == 'notawarded') {
  $sql.="AND win_status='3'";
}else{
  //$sql="select * from tbl_post order by id";
}
$sql.= "  order by id DESC";
$ans=$objModule->getAll($sql);
?>
<style>
.details {
	display: none;
}
</style>
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
        <div class="color-panel hidden-phone">
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
            <label> <span>Layout</span>
              <select class="layout-option m-wrap small">
                <option value="fluid" selected>Fluid</option>
                <option value="boxed">Boxed</option>
              </select>
            </label>
            <label> <span>Header</span>
              <select class="header-option m-wrap small">
                <option value="fixed" selected>Fixed</option>
                <option value="default">Default</option>
              </select>
            </label>
            <label> <span>Sidebar</span>
              <select class="sidebar-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
            <label> <span>Footer</span>
              <select class="footer-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
          </div>
        </div>
        <!-- END BEGIN STYLE CUSTOMIZER --> 
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title"> List Post </h3>
        <ul class="breadcrumb">
          <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <i class="icon-angle-right"></i> </li>
          <li> List Post </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB--> 
      </div>
    </div>
    <!-- END PAGE HEADER--> 
    <!-- BEGIN PAGE CONTENT-->
    <div class="row-fluid">
      <div class="span12"> 
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="btn-group" style="margin-bottom:10px; float:right; display:block"> <a href="add_new_post.php">
          
          </a> </div>
        <div class="portlet box green">
          <div class="portlet-title">
            <div class="caption"><i class="icon-globe"></i>List Post</div>
          </div>
          <script src="http://code.jquery.com/jquery-1.9.1.js"></script> 
          <script>
				  $(function() {
					$( "#startdate" ).datepicker({
					  class:"m-wrap medium ",
					  id:"startdate",
					  dateFormat:"dd-mm-yy"	,										  
					   onClose: function( selectedDate ) {
						$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
						}
					});
					
				  });
					$(function() {
					$( "#enddate" ).datepicker({
					  class:"m-wrap medium ",
					  id:"enddate",
					  dateFormat:"dd-mm-yy"	,
						onClose: function( selectedDate ) {
						$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
						}		
					 });
				 });
		   </script>
          <div class="portlet-body">
            <table width="100%" border="0" align="left">
              <tr>
                <td valign="top"><strong>Select Stauts</strong></td>
                <td valign="top">
                  <select id="post_status" name="post_status" onchange="view_records();">
                    <option value="">Select Status</option>
                    <option value="0">Running</option>
                    <option value="1">Assigned</option>
                    <option value="2">Completed</option>                    
                    <option value="3">Not Awarded</option>
                  </select>
                </td>
                <td valign="top"><strong>Select Start Date</strong></td>
                <td align="left" valign="top">
                  <input type="text" name="startdate" id="startdate" /></td>
                <td valign="top"><strong>Select End Date</strong></td>
                <td valign="top">
                  <input type="text" name="enddate" id="enddate" /></td>
                <td align="left" valign="top"><div style="margin-bottom:10px;  display:block" class="btn-group">
                    <button class="btn green" id="sample_editable_1_new" onclick="view_records();">View</button>
                  </div></td>
              </tr>
              <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table>
            <br />
            <div id="loading" 
                   style="display: none; width: 100%;text-align:center; height: 82px; border: 0px solid gray; position: relative; padding: 2px;"> <img width="64" height="64" src="images/loading.gif"><br>
              Loading..</div>
            <div id="viewdata"> 
            <form name="frm" method="post"  action="" />
            <select name="cmbStatus">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select> 
            <input type="submit" name="btnsubmit"  class="btn green" value="Submit" id="btnsubmit" />
              <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                <thead>
                  <tr>
                    <th style="display:none"></th>
                    <th width="25px">#</th>
                    <?php /*<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> */ ?>
                    <th>Title</th>
                    <th>Winning Status</th>
                    <th>Start Date</th>
                    <th>End date</th>
                    <th>Status</th>
                    <th>Manage</th>
                  </tr>
                </thead>
                <tbody>
                  <?php for($i=0;$i<count($ans);$i++){?>
                  <tr class="odd gradeX">
                    <td style="display:none"></td>
                   <?php /* <td><?php echo ($i+1);?></td> */ ?>
                    <td><input type="checkbox" class="checkboxes" name="chkbox[]" value="<?php echo $ans[$i]['id'];  ?>" /></td>
                    <td><?php echo $ans[$i]['title'];?></td>
                    <td><?php if($ans[$i]['win_status']=='0'){ echo "Running"; }else if($ans[$i]['win_status']=='1'){ echo "Assigned"; } else if($ans[$i]['win_status']=='2'){ echo "Completed"; } else if($ans[$i]['win_status']=='3'){ echo "Not Awarded"; }else if($ans[$i]['win_status']=='4'){ echo "Mark as Done"; }else { echo "------"; } ?></td>
                   <!-- <td><?php //echo $ans[$i]['win_status'];?></td> -->
                    <td><?php echo $date = date('d M Y',strtotime($ans[$i]['start_date_time'])); ?></td>
                    <td><?php if($ans[$i]['end_date_time']!='0000-00-00 00:00:00') { echo $date = date('d M Y',strtotime($ans[$i]['end_date_time'])); } ?></td>
                    <td><?php echo $ans[$i]['sts'];?></td>
                    <td><a href="add_new_post.php?id=<?php echo $ans[$i]['id']; ?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE CONTENT--> 
  </div>
  <!-- END PAGE CONTAINER--> 
</div>
<script type="text/javascript">
	function doYouWantTo(id){
	  doIt=confirm('Do you want to delete it?');
	  if(doIt){
		window.location.href = 'list_contents.php?id='+id;
	  }
	  else{
		  return false;
	  }
	  return true;
	}
</script>