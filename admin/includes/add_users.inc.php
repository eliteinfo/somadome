<?php
function getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity){

    $address = str_replace(" ", "+", $Uaddress);
	$Ucity = str_replace(" ", "%20", $Ucity);
	$Ucountry = str_replace(" ", "%20", $Ucountry);
	$address = $address.',+'.$Ucity;
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($Uzipcode).",$Ucountry&sensor=false&region=$region");
    $json = json_decode($json);
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	//echo $lat.','.$long;exit;
    return $lat.','.$long;
}

if($_GET['did'] != '')
{
	$objData->getAll("delete from soma_users where Uid = '".$_GET['did']."'");
	echo "<script> window.location.href = 'list_users.php' </script>";	
}

if(isset($_POST['update']))
{    


	//echo"<pre>";print_r($_POST);exit;
	$country=$objData->getAll("select * from tbl_country where ctr_id = '".$_REQUEST['Ucountry']."'");
	$Uaddress =$_REQUEST['Uaddress'];
	$Ucountry =$country[0]['ctr_name'];
	$Uzipcode =$_REQUEST['Uzipcode'];
	$Ucity = $_REQUEST['Ucity'];
	
	$latlong = getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity);
	$latlngs=explode(',' ,$latlong);
	$lat =  $latlngs[0];
	$lng = $latlngs[1];
	$Cdate=date("Y-m-d H:i:s");
	if($lat!="" AND $lng!=""){
 	$filename = $_FILES['Upic']['name'];
        if($filename != '')
        {
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../uploads/user_profile',$_FILES['Upic']['name']);
			move_uploaded_file($_FILES['Upic']['tmp_name'],"../uploads/user_profile/".$strFile);
		}else{
			$strFile = $_REQUEST['hdnImage'];
		}
	
		$objData->setTableDetails("soma_users", "Uid");
		$objData->setFieldValues("Fname", $_REQUEST['Fname']);
		$objData->setFieldValues("Lname", $_REQUEST['Lname']);
        $objData->setFieldValues("Uemail", $_REQUEST['Uemail']);
		$objData->setFieldValues("Upic",$strFile);
		$objData->setFieldValues("Ucountry", $_REQUEST['Ucountry']);
		$objData->setFieldValues("Ustate", $_REQUEST['Ustate']);
		$objData->setFieldValues("Ucity", $_REQUEST['Ucity']);
		$objData->setFieldValues("Uzipcode", $_REQUEST['Uzipcode']);
		$objData->setFieldValues("Uaddress", $_REQUEST['Uaddress']);
		$objData->setFieldValues("Ulat", $lat);
		$objData->setFieldValues("Ulong",$lng);
		$objData->setFieldValues("Cdate", $Cdate);
		$objData->setFieldValues("Ustatus",$_REQUEST['Ustatus']);
		$objData->setWhere("Uid = '".$_REQUEST['Uid']."'");
		$objData->update();
		$objModule->setMessage("User updated successfully","success");
		$objModule->redirect("list_users.php");
	}else{
		$objModule->setMessage("Please enter valid address.","error");
		$objModule->redirect("add_users.php?Uid=".$_REQUEST['Uid']);
	}
		
}
$sql_member = "select * from soma_users where Uid = '".$_GET['Uid']."'";
$db_member = $objData->getAll($sql_member);

/* $history = "select * from soma_user_unit_booking where Uid = '".$_GET['Uid']."'";
$booking_history = $objData->getAll($history); */

$history = "SELECT * FROM soma_user_unit_booking INNER JOIN soma_units ON soma_user_unit_booking.dom_id=soma_units.Id
			where soma_user_unit_booking.Uid = '".$_GET['Uid']."' ORDER BY soma_user_unit_booking.Id desc";
$booking_history = $objData->getAll($history);

//echo"<pre>";print_r($db_member);exit;
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
    </div>-->
    
    <!-- END BEGIN STYLE CUSTOMIZER -->
    
    <h3 class="page-title"> Users </h3>
    <ul class="breadcrumb">
      <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
      <li> <a href="list_users.php">List Users</a> <span class="icon-angle-right"></span> </li>
      <li><a href="#">Users</a></li>
    </ul>
  </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
<div class="span12">
<div class="tabbable tabbable-custom boxless">

  <div class="tab-content">
    <div class="tab-pane active" id="tab_1">
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption"><i class="icon-reorder"></i> User Details</div>
          <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
        </div>
      
        <div class="portlet-body form">
        	<div class="portlet-body">
                    	<a data-toggle="tab" href="#user"><button id="sample_editable_1_new" class="btn blue" style="margin-bottom: 15px;">

                                Users 

                                </button></a>

                                &nbsp;&nbsp;

                         <a data-toggle="tab" href="#history" style="margin-left:10px;"><button id="sample_editable_1_new" class="btn blue" style="margin-bottom: 15px;">

                                Bookings History

                                </button></a>
		<?php echo $objModule->getMessage(); ?>
          <form action="" method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
            <div class="alert alert-error hide"><button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
            <div class="alert alert-success hide"><button class="close" data-dismiss="alert"></button>Your form validation is successful! </div>
             
           
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'Errfilesize'){ ?>
               <div class="alert alert-error "><button class="close" data-dismiss="alert"></button>            
              Image should be grater than 250X250 </div>
              <?php } ?>
              
            
            <!-- <div class="portlet box blue">
                <div class="portlet-title">
            		<div class="caption">Personal Details</div>
          		</div>
                </div>-->
            <div class="tab-content">
            	<div id="user" class="tab-pane fade in active">
            <?php
			if(isset($_GET['Uid']) && $_GET['Uid'] != ""){
			?>
            <input type="hidden" name="hdn_postid" id="hdn_postid" value="<?php echo $_GET['Uid']; ?>" />  	
			<?php
			}
			?>
            <h3 style="color:#C33">Users Details</h3>
            <div class="control-group">
              <label class="control-label">First Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Fname" onkeypress="return onlyAlphabets(event,this);" data-required="1" value="<?php echo $db_member[0]['Fname']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Last Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Lname" onkeypress="return onlyAlphabets(event,this);" data-required="1" value="<?php echo $db_member[0]['Lname']; ?>" class="span6 m-wrap required"/>
              </div>
            </div> 			
            <div class="control-group">
              <label class="control-label">Email Id<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Uemail" data-required="1" readonly value="<?php echo $db_member[0]['Uemail']; ?>" class="span6 m-wrap required email" />
              </div>
            </div>          
            <div class="control-group">
              <label class="control-label">Image<span class="required"></span></label>
              <div class="controls">
                <input type="file" name="Upic" id="Upic" class="span6 m-wrap" accept="image/*" style="color:black; border:none;" />
              </div>
            </div>
            <?php if($db_member[0]['Upic'] == ""){ ?>
            <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">            
              <img src="../uploads/user_profile/default_user.png" width="75" height="75"  /> </div>
            </div>
           <?php }else{ ?>
            <input type="hidden" name="hdnImage" value="<?php echo $db_member[0]['Upic'];?>" />
           			<div class="control-group">
                      <label class="control-label"></label>
                      <div class="controls"> 
                      <img src="../uploads/user_profile/<?php echo $db_member[0]['Upic']; ?>" width="75" height="75"  /> </div>
                    </div>
           <?php } ?>
		    <div class="control-group">
              <label class="control-label">Address<span class="required">*</span></label>
              <div class="controls">
			    <textarea name="Uaddress" id="Uaddress" value="<?php echo $db_member[0]['Uaddress']; ?>" class="span6 m-wrap required" rows="3"><?php echo $db_member[0]['Uaddress']; ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="Ucountry" id="Ucountry" onchange="get_state(this.value)">
				<option value="">Select Country</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"  <?php if($data['ctr_id']==$db_member[0]['Ucountry']){ echo "selected='selected'";}?>><?php echo $data['ctr_name']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
			<div id="unit_state">
			<div class="control-group">
			  <label class="control-label">State<span class="required">*</span></label>
			  <div class="controls">
				<select class="span6 m-wrap required" name="Ustate" id="Ustate">
				<option value="">Select State</option>
				 <?php
				 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$db_member[0]['Ucountry']."'");
				 foreach($db_state as $data){ ?>
				  <option value="<?php echo $data['state_id']; ?>"  <?php if($data['state_id']==$db_member[0]['Ustate']){ echo "selected='selected'";}?>><?php echo $data['state_name']; ?></option>
				 <?php } ?>
				</select>
			  </div>
			</div>
			</div>
			
			<div id="unit_city">
			<div class="control-group">
			  <label class="control-label">City<span class="required">*</span></label>
			  <div class="controls">
			  <input type="text" name="Ucity" id="Ucity" value="<?php echo $db_member[0]['Ucity']; ?>" class="span6 m-wrap required" />
			  </div>
			</div>
			</div>
		 	<div class="control-group">
              <label class="control-label">Zip code<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Uzipcode" id="Uzipcode" value="<?php echo $db_member[0]['Uzipcode']; ?>" class="span6 m-wrap required" />
              </div>
            </div>	
		
            <div class="control-group">
              <label class="control-label">Status<span class="required"></span></label>
              <div class="controls">
                <select name="Ustatus"  class="span6 m-wrap">
                  <option value="1" <?php if($db_member[0]['Ustatus'] == '1') { ?> selected="selected"<?php } ?>>Active</option>
                  <option value="0" <?php if($db_member[0]['Ustatus'] == '0') { ?> selected="selected"<?php } ?>>InActive</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="update" class="btn blue" value="Update">
              <a href="add_users.php?did=<?php echo $_GET['Uid']; ?>" onclick="return delete_Cus('<?php echo $_GET['Uid']; ?>');"  class="btn red" >Delete User</a> 
              
              <!--<button type="submit" class="btn green">Validate</button>
                                <button type="button" class="btn">Cancel</button>--> 
              
            </div>
            </div>
            <div id="history" class="tab-pane fade">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <?php if(!empty($booking_history)) { ?>
	                        <thead>
                                <tr>
                                	<th style="display:none"></th>
                                	
                                    <th>Dome Name</th>
                                    <th>Date</th>
									<th>From Time</th>                                    
                                    <th>To Time</th>
                                    <th>Booking Staus</th>      
                                </tr>
                            </thead>
                            <tbody>
                             <?php  
                             
                             foreach ($booking_history as $booking_history1)
							 { 
							 ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                	
                                    <td><?php echo ucfirst($booking_history1['unitname']);?></td>
                                    <td><?php echo $booking_history1['from_date'];?></td>
									<td><?php echo $booking_history1['from_time'];?></td>									
									<td><?php echo $booking_history1['to_time'];?></td>  
									<td><?php 
											if ($booking_history1['book_status'] == '1'){
												echo "Pending";
											}elseif ($booking_history1['book_status'] == '2'){
												echo "Cancelled";
											}else{
												echo "Completed";
											}
										?>
									</td>                                                                       
                                </tr>
                                <? }?>                              
                            </tbody>
                            <?php }
							else{
								echo "No Records Found";
								} ?>
                        </table>    
                        </div>
            </div>
          </form>
          </div>
          
          <!-- END FORM--> 
          
        </div>
     
      </div>
      
      <!-- END VALIDATION STATES--> 
      
    </div>
   
    
    <!-- END PAGE CONTENT--> 
    
  </div>
  
  <!-- END PAGE CONTAINER--> 
  
</div>
<script>
function delete_Cus(id)
	{
		 var x=confirm('Do you want to delete this User?');
		 if(x)
		 {
			 return true;
		 }
		 else
		 {
			 return false;
		 }
	}
function get_state(ctr_id)
{ 
	$.ajax({
			url: 'ajax.php',
			data: {unit_country:"unit_country",ctr_id:ctr_id},
			type: "POST",
			success: function(data)
			{ 
				$('#unit_state').html(data);
                
			}
		});
}
function get_city(state_id)
{ 
	$.ajax({
			url: 'ajax.php',
			data: {unit_state:"unit_state",state_id:state_id},
			type: "POST",
			success: function(data)
			{ 
				$('#unit_city').html(data);
                
			}
		});
}	
</script> 
