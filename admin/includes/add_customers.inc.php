<?php
function getLnt($Caddress,$Ccountry,$Czipcode,$Ccity){

    $address = str_replace(" ", "+", $Caddress);
	$Ccity = str_replace(" ", "%20", $Ccity);
	$Ccountry = str_replace(" ", "%20", $Ccountry);
	$address = $address.',+'.$Ccity;
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($Czipcode).",$Ccountry&sensor=false&region=$region");
    $json = json_decode($json);
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}
if($_GET['did'] != '')
{
	$objData->getAll("delete from soma_customers where Cid = '".$_GET['did']."'");
	echo "<script> window.location.href = 'list_customers.php' </script>";	
}
if(isset($_POST['submit']))
{	
	$customers_email=$objData->getAll("select * from soma_customers where Cemail = '".$_REQUEST['Cemail']."'");
	if(count($customers_email)=='0'){
		$Caddress =$_REQUEST['Caddress'];
		$Ccountry =$_REQUEST['Ccountry'];
		$Czipcode =$_REQUEST['Czipcode'];
		$Ccity =$_REQUEST['Ccity'];
		$latlong = getLnt($Caddress,$Ccountry,$Czipcode,$Ccity);
		$latlngs=explode(',' ,$latlong);
		$lat =  $latlngs[0];
		$lng = $latlngs[1];
		if($lat!="" AND $lng!=""){
		$filename = $_FILES['Cimage']['name'];
			if($filename != '')
			{
				//echo"ttt"; exit;
				$strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../uploads/cus_profile',$_FILES['Cimage']['name']);
			   
				move_uploaded_file($_FILES['Cimage']['tmp_name'],"../uploads/cus_profile/".$strFile);
			}
		
		
			$objData->setTableDetails("soma_customers", "Cid");
			$objData->setFieldValues("Ctype", $_REQUEST['Ctype']);
			$objData->setFieldValues("Cclub", $_REQUEST['Cclub']);
			$objData->setFieldValues("Cname", $_REQUEST['Cname']);
			$objData->setFieldValues("Cemail", $_REQUEST['Cemail']);
			$objData->setFieldValues("Cimage",$strFile);
			$objData->setFieldValues("Ccountry", $_REQUEST['Ccountry']);
			$objData->setFieldValues("Cstate", $_REQUEST['Cstate']);
			$objData->setFieldValues("Ccity", $_REQUEST['Ccity']);
			$objData->setFieldValues("Czipcode", $_REQUEST['Czipcode']);
			$objData->setFieldValues("Caddress", $_REQUEST['Caddress']);
			$objData->setFieldValues("Clat", $lat);
			$objData->setFieldValues("Clong",$lng);
			$objData->setFieldValues("Cwebsite", $_REQUEST['Cwebsite']);
			$objData->setFieldValues("Ctelephone", $_REQUEST['Ctelephone']);
			$insert_data = $objData->insert();
			$objModule->setMessage("Host added successfully.","success");
			$objModule->redirect("list_customers.php");
			}
			else{
				$objModule->setMessage("Please enter valid address.","error");
				$objModule->redirect("add_customers.php");
			}
	}
	else{
			$objModule->setMessage("Email already exists.","error");
			$objModule->redirect("add_customers.php");
	}
	
	
	echo "<script>window.location='list_customers.php'</script>";
}
if(isset($_POST['update']))
{    
	
	$Caddress =$_REQUEST['Caddress'];
	$Ccountry =$_REQUEST['Ccountry'];
	$Czipcode =$_REQUEST['Czipcode'];
	$latlong = getLnt($Caddress,$Ccountry,$Czipcode);
	$latlngs=explode(',' ,$latlong);
	$lat =  $latlngs[0];
	$lng = $latlngs[1];
 
	if($lat!="" AND $lng!=""){
		$filename = $_FILES['Cimage']['name'];
        if($filename != '')
        {
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../uploads/user_profile',$_FILES['Cimage']['name']);
			move_uploaded_file($_FILES['Cimage']['tmp_name'],"../uploads/cus_profile/".$strFile);
		}else{
			$strFile = $_REQUEST['hdnImage'];
		}
	
		$objData->setTableDetails("soma_customers", "Cid");
		$objData->setFieldValues("Ctype", $_REQUEST['Ctype']);
		$objData->setFieldValues("Cclub", $_REQUEST['Cclub']);
		$objData->setFieldValues("Cname", $_REQUEST['Cname']);
        $objData->setFieldValues("Cemail", $_REQUEST['Cemail']);
		$objData->setFieldValues("Cimage",$strFile);
		$objData->setFieldValues("Ccountry", $_REQUEST['Ccountry']);
		$objData->setFieldValues("Cstate", $_REQUEST['Cstate']);
		$objData->setFieldValues("Ccity", $_REQUEST['Ccity']);
		$objData->setFieldValues("Czipcode", $_REQUEST['Czipcode']);
		$objData->setFieldValues("Caddress", $_REQUEST['Caddress']);
		$objData->setFieldValues("Clat", $lat);
		$objData->setFieldValues("Clong",$lng);
		$objData->setFieldValues("Cwebsite", $_REQUEST['Cwebsite']);
		$objData->setFieldValues("Ctelephone", $_REQUEST['Ctelephone']);
		$objData->setFieldValues("Cstatus",$_REQUEST['Cstatus']);
		$objData->setWhere("Cid = '".$_REQUEST['Cid']."'");
		$objData->update();
		$objModule->setMessage("Host updated successfully","success");
		$objModule->redirect("list_customers.php");
		}
		else{
			$objModule->setMessage("Please enter valid address.","error");
			$objModule->redirect("add_customers.php?Cid=".$_REQUEST['Cid']);
		}
		
}
$sql_member = "select * from soma_customers where Cid = '".$_GET['Cid']."'";
$db_member = $objData->getAll($sql_member);
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
    
    <h3 class="page-title"> Hosts </h3>
    <ul class="breadcrumb">
      <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
      <li> <a href="list_customers.php">List Hosts</a> <span class="icon-angle-right"></span> </li>
      <li><a href="#">Hosts</a></li>
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
          <div class="caption"><i class="icon-reorder"></i> Host Details</div>
          <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
        </div>
        <?php if($_GET['Cid'] == ''){ ?>
		
        <div class="portlet-body form">
		 <?php echo $objModule->getMessage(); ?>
          <form action="" method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
		 
            <div class="alert alert-error hide">
              <button class="close" data-dismiss="alert"></button>
              You have some form errors. Please check below. </div>
            <div class="alert alert-success hide">
              <button class="close" data-dismiss="alert"></button>
              Your form validation is successful! </div>
             
          
            
            <h3 style="color:#C33">Host Details</h3>
            
            
             <div class="control-group">
              <label class="control-label">Host Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Cname" data-required="1" value="" class="span6 m-wrap required"/>
              </div>
            </div>
            
			
            
            <div class="control-group">
              <label class="control-label">Host Account Type<span class="required"></span></label>
              <div class="controls">
				<select class="span6 m-wrap" name="Cclub" id="Cclub">
				<option value="">Select Account Type</option>
             	<option value="1">Membership Club</option>
                <option value="2">Corporate</option>
                <option value="3">Fitness Club</option>
                <option value="4">Lounge</option>
                <option value="5">Spa</option>
                </select>
              </div>
            </div>
            
			<div class="control-group">
              <label class="control-label">Contact Name<span class="required"></span></label>
              <div class="controls">
                <input type="text" name="Ctype" data-required="1" value="" class="span6 m-wrap"/>
              </div>
            </div>
           
         
            <div class="control-group">
              <label class="control-label">Email Id<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Cemail" data-required="1" value="" onchange="check_email(this.value);" id="newemail" class="span6 m-wrap required email" />
              </div>
            </div>
           
          <div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="Ccountry" id="Ccountry" onchange="get_state(this.value)">
				<option value="">Select Country</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"><?php echo $data['ctr_name']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
            
            <div id="unit_state"></div>
            <div id="unit_city"></div>
            
            
			 <div class="control-group">
              <label class="control-label">Zip code<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Czipcode" id="Czipcode" value="" class="span6 m-wrap required" />
              </div>
            </div>
			
            <div class="control-group">
              <label class="control-label">Address<span class="required">*</span></label>
              <div class="controls">
			  <textarea name="Caddress" id="Caddress" class="span6 m-wrap required" rows="3"></textarea>
              </div>
            </div>
			
			  
			<div class="control-group">
              <label class="control-label">Website<span class="required">*</span></label>
              <div class="controls">
			  <input type="text" name="Cwebsite" id="Cwebsite" value="http://" class="span6 m-wrap url" />
              </div>
            </div>
			
			<div class="control-group">
              <label class="control-label">Tel Number.<span class="required">*</span></label>
              <div class="controls">
			  <input type="text" name="Ctelephone" id="Ctelephone" value="" maxlength="12" class="span6 m-wrap number required" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Image<span class="required"></span></label>
              <div class="controls">
                <input type="file" name="Cimage" id="Cimage" accept="image/*" class="span6 m-wrap" style="color:black; border:none;" />
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="submit" class="btn blue" value="Add" >
            </div>
          </form>
          <!-- END FORM-->
          
        </div>
        <?php }else {
			
			 ?>
			<?php //echo"<pre>";print_r($db_member); ?>
        <div class="portlet-body form">
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
            <?php
			if(isset($_GET['Cid']) && $_GET['Cid'] != ""){
			?>
            <input type="hidden" name="hdn_postid" id="hdn_postid" value="<?php echo $_GET['Cid']; ?>" />  	
			<?php
			}
			?>
            <h3 style="color:#C33">Host Details</h3>
            
            
            <div class="control-group">
              <label class="control-label">Host Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Cname"  data-required="1" value="<?php echo $db_member[0]['Cname']; ?>" class="span6 m-wrap required "/>
              </div>
            </div>
            
            
            <div class="control-group">
              <label class="control-label">Host Account Type<span class="required"></span></label>
              <div class="controls">
				<select class="span6 m-wrap" name="Cclub" id="Cclub">
				<option value="">Select Account Type</option>
             	<option value="1" <?php if($db_member[0]['Cclub'] == 1 || $db_member[0]['Cclub'] == '0' ){?> selected="selected" <?php } ?>>Membership Club</option>
                <option value="2" <?php if($db_member[0]['Cclub'] == 2){?> selected="selected" <?php } ?>>Corporate</option>
                </select>
              </div>
            </div>
            
            
            <div class="control-group">
              <label class="control-label">Contact Name<span class="required"></span></label>
              <div class="controls">
                <input type="text" name="Ctype" data-required="1" value="<?php echo $db_member[0]['Ctype']; ?>" class="span6 m-wrap" />
              </div>
            </div>
			
                       
            <div class="control-group">
              <label class="control-label">Email Id<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Cemail" data-required="1" readonly value="<?php echo $db_member[0]['Cemail']; ?>" class="span6 m-wrap required email" />
              </div>
            </div>
          
           <div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="Ccountry" id="Ccountry" onchange="get_state(this.value)">
				<option value="">Select Country</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>" <?php if($data['ctr_id']==$db_member[0]['Ccountry']){ echo "selected='selected'";}?>><?php echo $data['ctr_name']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
            
            
            <div id="unit_state">
			<div class="control-group">
			  <label class="control-label">State<span class="required">*</span></label>
			  <div class="controls">
				<select class="span6 m-wrap required" name="Cstate" id="Cstate">
				<option value="">Select State</option>
				 <?php
				 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$db_member[0]['Ccountry']."'");
				 foreach($db_state as $data){ ?>
				  <option value="<?php echo $data['state_id']; ?>"  <?php if($data['state_id']==$db_member[0]['Cstate']){ echo "selected='selected'";}?>><?php echo $data['state_name']; ?></option>
				 <?php } ?>
				</select>
			  </div>
			</div>
			</div>
            
            
            <div id="unit_city">
			<div class="control-group">
			  <label class="control-label">City<span class="required">*</span></label>
			  <div class="controls">
			  <input type="text" name="Ccity" id="Ccity" value="<?php echo $db_member[0]['Ccity']; ?>" class="span6 m-wrap required" />
			  </div>
			</div>
			</div>
            
            
			 <div class="control-group">
              <label class="control-label">Zip code<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Czipcode" id="Czipcode" value="<?php echo $db_member[0]['Czipcode']; ?>" class="span6 m-wrap required" />
              </div>
            </div>
           
            <div class="control-group">
              <label class="control-label">Address<span class="required">*</span></label>
              <div class="controls">
			    <textarea name="Caddress" id="Caddress" value="<?php echo $db_member[0]['Caddress']; ?>" class="span6 m-wrap required" rows="3"><?php echo $db_member[0]['Caddress']; ?></textarea>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Website<span class="required">*</span></label>
              <div class="controls">
			  <input type="text" name="Cwebsite" id="Cwebsite" value="<?php echo $db_member[0]['Cwebsite']; ?>" class="span6 m-wrap url" />
              </div>
            </div>
			
			<div class="control-group">
              <label class="control-label">Tel Number.<span class="required">*</span></label>
              <div class="controls">
			  <input type="text" name="Ctelephone" id="Ctelephone" value="<?php echo $db_member[0]['Ctelephone']; ?>" maxlength="12" class="span6 m-wrap number required" />
              </div>
            </div>
          
            <div class="control-group">
              <label class="control-label">Image<span class="required"></span></label>
              <div class="controls">
                <input type="file" name="Cimage" id="Cimage"  accept="image/*" class="span6 m-wrap" style="color:black; border:none;" />
              </div>
            </div>
            <?php if($db_member[0]['Cimage'] == ""){ ?>
            <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">            
              <img src="../uploads/cus_profile/default_cus.png" width="75" height="75"  /> </div>
            </div>
           <?php }else{ ?>
            <input type="hidden" name="hdnImage" value="<?php echo $db_member[0]['Cimage'];?>" />
           			<div class="control-group">
                      <label class="control-label"></label>
                      <div class="controls"> 
                      <img src="../uploads/cus_profile/<?php echo $db_member[0]['Cimage']; ?>" width="75" height="75"  /> </div>
                    </div>
           <?php } ?>
            
            <div class="control-group">
              <label class="control-label">Status<span class="required"></span></label>
              <div class="controls">
                <select name="Cstatus"  class="span6 m-wrap">
                  <option value="1" <?php if($db_member[0]['Cstatus'] == '1') { ?> selected="selected"<?php } ?>>Active</option>
                  <option value="0" <?php if($db_member[0]['Cstatus'] == '0') { ?> selected="selected"<?php } ?>>InActive</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="update" class="btn blue" value="Update">
              <a href="add_customers.php?did=<?php echo $_GET['Cid']; ?>" onclick="return delete_Cus('<?php echo $_GET['Cid']; ?>');"  class="btn red" >Delete Host</a> 
              
              <!--<button type="submit" class="btn green">Validate</button>
                                <button type="button" class="btn">Cancel</button>--> 
              
            </div>
          </form>
          
          <!-- END FORM--> 
          
        </div>
        <?php } ?>
      </div>
      
      <!-- END VALIDATION STATES--> 
      
    </div>
   
    
    <!-- END PAGE CONTENT--> 
    
  </div>
  
  <!-- END PAGE CONTAINER--> 
  
</div>
<script>
function get_state(ctr_id)
{ 
	$.ajax({
			url: 'ajax.php',
			data: {c_country:"unit_country",ctr_id:ctr_id},
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
			data: {c_state:"unit_state",state_id:state_id},
			type: "POST",
			success: function(data)
			{ 
				$('#unit_city').html(data);

			}
		});
}
function delete_Cus(id)
	{
		 var x=confirm('Do you want to delete this Host?');
		 if(x)
		 {
			 return true;
			 //window.location.href = 'manage_order.php?ordid='+;
		 }
		 else
		 {
			 return false;
		 }
	}
</script> 
