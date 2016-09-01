<?php
for($i=00;$i<=23;$i++)
{
	$r[]=$i;
}
function createHours($id='hours_select', $selected=null,$r = array("05","06","07","08","09",10,11,12,13,14,15,16,17,18,19,20,21,22,23))
{
/*** range of hours ***/
$m = array("00",30);

$arrHour = array("00");

$select .= "";
foreach ($r as $hour)
{
foreach($m as $min)
{

$selected_cond = '';
$intMinute = $hour*60+$min;
if($intMinute==$selected){ $selected_cond = 'selected="selected"';}
$select .= '<option value="'.$intMinute.'" '.$selected_cond.'>'.$hour.':'.$min.'</option>';

}
}
$totalmin = 1440;
foreach($arrHour as $intHour)
{
foreach ($m as $min)
{
if(($min=="30" && $intHour=="01"))
{
continue;
}
$selected_cond = '';
$intMinute = $totalmin + $intHour*60+$min;
if($intMinute==$selected){ $selected_cond = 'selected="selected"';}
$select .= '<option value="'.$intMinute.'" '.$selected_cond.'>'.$intHour.':'.$min.'</option>';
}
}
return $select;
}



function getLnt($unitaddress,$unitcountry,$unitzipcode,$unitcity){

    $address = str_replace(" ", "+", $unitaddress);
	$unitcity = str_replace(" ", "%20", $unitcity);
	$unitcountry = str_replace(" ", "%20", $unitcountry);
	$address = $address.',+'.$unitcity;
	
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($unitzipcode).",$unitcountry&sensor=false&region=$region");
    $json = json_decode($json);
	
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	
    return $lat.','.$long;
}


if($_GET['did'] != '')
{
	$objData->getAll("delete from soma_units where Id = '".$_GET['did']."'");
	echo "<script> window.location.href = 'list_units.php' </script>";	
}
if(isset($_POST['submit']))
{	
		//$customer_detail=$objData->getAll("select * from soma_customers where Cid = '".$_REQUEST['Cus_id']."'");
		$countryName = $objData->getAll("select ctr_name from tbl_country where ctr_id = '".$_REQUEST['unitcountry']."'");
		$unitconfig =$_REQUEST['unitconfig'];
		$Cus_id =$_REQUEST['Cus_id'];
		$unitid =$_REQUEST['unitid'];
		$unitname =$_REQUEST['unitname'];
		$unitaddress =$_REQUEST['unitaddress'];
		$unitcountry =$_REQUEST['unitcountry'];
		$unitstate =$_REQUEST['unitstate'];
		$unitcity =$_REQUEST['unitcity'];
		$unitzipcode =$_REQUEST['Czipcode'];
		
		$latlong = getLnt($unitaddress,$countryName['ctr_name'],$unitzipcode,$unitcity);
		$latlngs=explode(',' ,$latlong);
		$lat =  $latlngs[0];
		$lng = $latlngs[1];
		if($lat!="" AND $lng!=""){
			
		$unit_timezone = $_REQUEST['unit_timezone'];
		$unit_version =$_REQUEST['unitversion'];
		$unit_access =$_REQUEST['unit_access'];
		$unit_rsvpmode =$_REQUEST['unit_rsvpmode'];
		$unit_rsvpmsg =$_REQUEST['unit_rsvpmsg'];
		$unit_weekopen =$_REQUEST['unit_weekopen'];
		$unit_weekclose =$_REQUEST['unit_weekclose'];
		$unit_weekendopen =$_REQUEST['unit_weekendopen'];
		$unit_weekendclose =$_REQUEST['unit_weekendclose'];
		$unitcdate =date("Y-m-d H:i:s");
		
		
		
			$objData->setTableDetails("soma_units", "Id");
			$objData->setFieldValues("unit_version", $unit_version);
			$objData->setFieldValues("unit_config", $unitconfig);
			$objData->setFieldValues("Cus_id", $Cus_id);
			$objData->setFieldValues("unitname", $unitname);
			$objData->setFieldValues("unitid", $unitid);
			$objData->setFieldValues("unitaddress", $unitaddress);
			$objData->setFieldValues("unitcountry", $unitcountry);
			$objData->setFieldValues("unitstate", $unitstate);
			$objData->setFieldValues("unitcity", $unitcity);
			$objData->setFieldValues("unit_zip", $unitzipcode);
			$objData->setFieldValues("unitlat", $lat);
			$objData->setFieldValues("unitlong", $lng);
			$objData->setFieldValues("unit_access", $unit_access);
			$objData->setFieldValues("unit_rsvpmode", $unit_rsvpmode);
			$objData->setFieldValues("unit_rsvpmsg", $unit_rsvpmsg);
			$objData->setFieldValues("unit_timezone", $unit_timezone);
			$objData->setFieldValues("unit_weekopen", $unit_weekopen);
			$objData->setFieldValues("unit_weekclose", $unit_weekclose);
			$objData->setFieldValues("unit_weekendopen", $unit_weekendopen);
			$objData->setFieldValues("unit_weekendclose", $unit_weekendclose);
			$objData->setFieldValues("unitcdate", $unitcdate);
			$insert_data = $objData->insert();
			$objModule->setMessage("Dome added successfully.","success");
			$objModule->redirect("list_units.php");
			echo "<script>window.location='list_units.php'</script>";
		}else{
			
				$objModule->setMessage("Please enter valid address.","error");
				$objModule->redirect("list_units.php");
		}
}
if(isset($_POST['update']))
{    
	$countryName = $objData->getAll("select ctr_name from tbl_country where ctr_id = '".$_REQUEST['unitcountry']."'");
	$unitconfig =$_REQUEST['unitconfig'];
	$Cus_id =$_REQUEST['Cus_id'];
	$unitname =$_REQUEST['unitname'];
	$unitid =$_REQUEST['unitid'];
	$unitaddress =$_REQUEST['unitaddress'];
	$unitcountry =$_REQUEST['unitcountry'];
	$unitstate =$_REQUEST['unitstate'];
	$unitcity =$_REQUEST['unitcity'];
	$unitzipcode =$_REQUEST['Czipcode'];
	
	
	$latlong = getLnt($unitaddress,$countryName['ctr_name'],$unitzipcode,$unitcity);
	$latlngs=explode(',' ,$latlong);
	$lat =  $latlngs[0];
	$lng = $latlngs[1];
	if($lat!="" AND $lng!=""){
	
		$unit_timezone = $_REQUEST['unit_timezone'];
		$unit_version =$_REQUEST['unitversion'];
		$unit_access =$_REQUEST['unit_access'];
		$unit_rsvpmode =$_REQUEST['unit_rsvpmode'];
		$unit_rsvpmsg =$_REQUEST['unit_rsvpmsg'];
		$unit_weekopen =$_REQUEST['unit_weekopen'];
		$unit_weekclose =$_REQUEST['unit_weekclose'];
		$unit_weekendopen =$_REQUEST['unit_weekendopen'];
		$unit_weekendclose =$_REQUEST['unit_weekendclose'];
		$unitcdate =date("Y-m-d H:i:s");
		$unitstatus =$_REQUEST['unitstatus'];
 
 
	
		$objData->setTableDetails("soma_units", "Id");
		$objData->setFieldValues("unit_version", $unit_version);
		$objData->setFieldValues("unit_config", $unitconfig);
		$objData->setFieldValues("Cus_id", $Cus_id);
		$objData->setFieldValues("unitname", $unitname);
		$objData->setFieldValues("unitid", $unitid);
		$objData->setFieldValues("unitaddress", $unitaddress);
		$objData->setFieldValues("unitcountry", $unitcountry);
		$objData->setFieldValues("unitstate", $unitstate);
		$objData->setFieldValues("unitcity", $unitcity);
		$objData->setFieldValues("unit_zip", $unitzipcode);
		$objData->setFieldValues("unitlat", $lat);
		$objData->setFieldValues("unitlong", $lng);
		$objData->setFieldValues("unit_access", $unit_access);
		$objData->setFieldValues("unit_rsvpmode", $unit_rsvpmode);
		$objData->setFieldValues("unit_rsvpmsg", $unit_rsvpmsg);
		$objData->setFieldValues("unit_timezone", $unit_timezone);
		$objData->setFieldValues("unit_weekopen", $unit_weekopen);
		$objData->setFieldValues("unit_weekclose", $unit_weekclose);
		$objData->setFieldValues("unit_weekendopen", $unit_weekendopen);
		$objData->setFieldValues("unit_weekendclose", $unit_weekendclose);
		$objData->setFieldValues("unitstatus",$_REQUEST['unitstatus']);
		$objData->setWhere("Id = '".$_REQUEST['Id']."'");
		$objData->update();
		$objModule->setMessage("Dome updated successfully.","success"); 
		$objModule->redirect("list_units.php");
		
	}else{
		$objModule->setMessage("Please enter valid address.","error");
		$objModule->redirect("list_units.php");
		
	}
		
}
$sql_member = "select * from soma_units where Id = '".$_GET['Id']."'";
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
    
    <h3 class="page-title"> Domes </h3>
    <ul class="breadcrumb">
      <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
      <li> <a href="list_units.php">List Domes</a> <span class="icon-angle-right"></span> </li>
      <li><a href="#">Domes</a></li>
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
          <div class="caption"><i class="icon-reorder"></i> Dome Details</div>
          <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
        </div>
        <?php if($_GET['Id'] == ''){ ?>
		
        <div class="portlet-body form">
		 <?php echo $objModule->getMessage(); ?>
          <form action="" method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
		 
            <div class="alert alert-error hide">
              <button class="close" data-dismiss="alert"></button>
              You have some form errors. Please check below. </div>
            <div class="alert alert-success hide">
              <button class="close" data-dismiss="alert"></button>
              Your form validation is successful! </div>
             
          
            
            <h3 style="color:#C33">Dome Details</h3>
			<div class="control-group">
              <label class="control-label">Dome Id<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="unitid" data-required="1" readonly value="DOME<?php echo rand(11111,99999); ?>" class="span6 m-wrap required"/>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">Dome Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="unitname" data-required="1" value="" class="span6 m-wrap required"/>
              </div>
            </div>
			
			<div class="control-group">
              <label class="control-label">Dome Config<span class="required">*</span></label>
              <div class="controls">
              	<select class="span6 m-wrap required"  name="unitconfig" id="unitconfig" >
				<option value="">Select Dome Config</option>
                 <?php
				 $db_customers = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'AF' OR ctr_code = 'AL'");
				 foreach($db_customers as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"  <?php if($data['ctr_id']!=''){ echo "selected='selected'";}?>><?php echo $data['dome_config']; ?></option>
				 <?php } ?>
                </select>
				 <!-- <input type="text" name="unitconfig" data-required="1" value="" class="span6 m-wrap"/> -->
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">Dome Version</label>
              <div class="controls">
                <input type="text" name="unitversion" data-required="1" value="" class="span6 m-wrap"/>
              </div>
            </div>
         
			<div class="control-group">
              <label class="control-label">Host<span class="required">*</span></label>
              <div class="controls">
                <?php /*?><select class="span6 m-wrap required" onchange="get_address(this.value)" name="Cus_id" id="Cus_id" ><?php */?>
				<select class="span6 m-wrap required"  name="Cus_id" id="Cus_id" >
				<option value="">Select Host</option>
                 <?php
				 $db_customers = $objData->getAll("SELECT * FROM soma_customers WHERE Cstatus='1'");
				 foreach($db_customers as $data){ ?>
				  <option value="<?php echo $data['Cid']; ?>"><?php echo $data['Cname']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
			
			
			<div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="unitcountry" id="unitcountry" onchange="get_state(this.value)">
				<option value="">Select Country</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"><?php echo $data['ctr_name']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
			<div id="unit_state">
                <?php /*?><div class="control-group">
                  <label class="control-label">State<span class="required">*</span></label>
                  <div class="controls">
                    <select class="span6 m-wrap required" name="unitstate" id="unitstate" onchange="get_city(this.value)">
                    <option value="">Select State</option>
                     <?php
                     $db_state = $objData->getAll("SELECT * FROM tbl_state");
                     foreach($db_state as $data){ ?>
                      <option value="<?php echo $data['state_id']; ?>"><?php echo $data['state_name']; ?></option>
                     <?php } ?>
                    </select>
                  </div>
                </div><?php */?>
            
            </div>
			<div id="unit_city">
            	<div class="control-group">
                  <label class="control-label">City<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="unitcity" id="unitcity" value="" class="span6 m-wrap required" />
                  </div>
                </div>
            </div>
           	
           	<div class="control-group">
              <label class="control-label">Zip code<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Czipcode" id="Czipcode" value="" class="span6 m-wrap required" />
              </div>
            </div>
             
            <div class="control-group">
              <label class="control-label">Address<span class="required">*</span></label>
              <div class="controls">
                 <textarea name="unitaddress" id="unitaddress" value="" class="span6 m-wrap required" rows="3"></textarea>
              </div>
            </div>
           
           <div class="control-group">
              <label class="control-label">Accessibility<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="unit_access" id="unit_access" >
				<option value="">Select</option>
				  <option value="Public">Public</option>
				  <option value="Member">Member</option>
				  <option value="Private">Private</option>
                </select>
				  <img src="images/default.gif" class="loader" id="loader">
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">RSVP Mode<span class="required"></span></label>
              <div class="controls">
				<select class="span6 m-wrap" onchange="hide_msg(this.value)" name="unit_rsvpmode" id="unit_rsvpmode" >
				<!--<option value="">Select</option>-->
				  <option value="ViaApp" selected>ViaApp</option>
				  <option value="ViaHost">ViaHost</option>
                </select>
              </div>
            </div>
        
           <div class="control-group" id="rsvp_msg" style="display:none;">
              <label class="control-label">RSVP Message<span class="required"></span></label>
              <div class="controls">
                 <textarea name="unit_rsvpmsg" id="unit_rsvpmsg" value="" class="span6 m-wrap" rows="3"></textarea>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">Time Zone<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_timezone" id="unit_timezone" class="span6 m-wrap required">
              <option value="">Select</option>
              <?php $AllTimeZone = $objData->getAll("select * from tbl_timezone where status = 1");	?>
              	<?php foreach($AllTimeZone as $AllTimeZones){ ?>
                	 <option value="<?php echo $AllTimeZones['id'];?>"><?php echo $AllTimeZones['full_timezone'];?></option>
                <?php } ?>
              </select>
              </div>
            </div>
			
			<div class="control-group">
              <label class="control-label">Week OpenHour<span class="required">*</span></label>
              <div class="controls">
					<select name="unit_weekopen" id="unit_weekopen" class="span6 m-wrap required chosen"  style="width:auto">
                         <?php echo createHours('','',$r,$timings); ?>
					</select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Week CloseHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekclose" id="unit_weekclose" class="span6 m-wrap required chosen"  style="width:auto">
                    <?php echo createHours('','',$r,$timings); ?>
			  </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Weekend OpenHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekendopen" id="unit_weekendopen" class="span6 m-wrap required chosen"  style="width:auto">
                         <?php echo createHours('','',$r,$timings); ?>
					</select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Weekend CloseHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekendclose" id="unit_weekendclose" class="span6 m-wrap required chosen"  style="width:auto">
                         <?php echo createHours('','',$r,$timings); ?>
					</select>
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
        <div class="portlet-body form">
          <form action="" method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
            <div class="alert alert-error hide"><button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
            <div class="alert alert-success hide"><button class="close" data-dismiss="alert"></button>Your form validation is successful! </div>
             
           
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'Errfilesize'){ ?>
               <div class="alert alert-error "><button class="close" data-dismiss="alert"></button>            
              Image should be grater than 250X250 </div>
              <?php } ?>
            <?php
			if(isset($_GET['Id']) && $_GET['Id'] != ""){
			?>
            <input type="hidden" name="hdn_postid" id="hdn_postid" value="<?php echo $_GET['Id']; ?>" />  	
			<?php
			}
			?>
            <h3 style="color:#C33">Dome Details</h3>
           <div class="control-group">
              <label class="control-label">Dome Id<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="unitid" data-required="1" readonly value="<?php echo $db_member[0]['unitid']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Dome Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="unitname" data-required="1" value="<?php echo $db_member[0]['unitname']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Dome Config<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="unitconfig" id="unitconfig">
				<option value="">Select Dome Config</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'AF' OR ctr_code = 'AL'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"  <?php if($data['ctr_id']==$db_member[0]['unit_config']){ echo "selected='selected'";}?>><?php echo $data['dome_config']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Dome Version</label>
              <div class="controls">
                <input type="text" name="unitversion" id="unitversion" value="<?php echo $db_member[0]['unit_version']; ?>" class="span6 m-wrap " />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Host<span class="required">*</span></label>
              <div class="controls">                     
				<select class="span6 m-wrap required" name="Cus_id"  id="Cus_id" >
				<option value="">Select Host</option>
                 <?php
				 $hostclub='';
				 $db_customers = $objData->getAll("SELECT * FROM soma_customers WHERE Cstatus='1'");
				 foreach($db_customers as $data){

					 if($data['Cid']==$db_member[0]['Cus_id'])
						 $hostclub=$data['Cclub'];

					 ?>
				  <option value="<?php echo $data['Cid']; ?>" <?php if($data['Cid']==$db_member[0]['Cus_id']){ echo "selected='selected'";}?>><?php echo $data['Cname']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
			
			
			<div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="unitcountry" id="unitcountry" onchange="get_state(this.value)">
				<option value="">Select Country</option>
                 <?php
				 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
				 foreach($db_country as $data){ ?>
				  <option value="<?php echo $data['ctr_id']; ?>"  <?php if($data['ctr_id']==$db_member[0]['unitcountry']){ echo "selected='selected'";}?>><?php echo $data['ctr_name']; ?></option>
				 <?php } ?>
                </select>
              </div>
            </div>
			<div id="unit_state">
			<div class="control-group">
			  <label class="control-label">State<span class="required">*</span></label>
			  <div class="controls">
				<select class="span6 m-wrap required" name="unitstate" id="unitstate">
				<option value="">Select State</option>
				 <?php
				 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$db_member[0]['unitcountry']."'");
				 foreach($db_state as $data){ ?>
				  <option value="<?php echo $data['state_id']; ?>"  <?php if($data['state_id']==$db_member[0]['unitstate']){ echo "selected='selected'";}?>><?php echo $data['state_name']; ?></option>
				 <?php } ?>
				</select>
			  </div>
			</div>
			</div>
			
			<div id="unit_city">
			<div class="control-group">
			  <label class="control-label">City<span class="required">*</span></label>
			  <div class="controls">
			  <input type="text" name="unitcity" id="unitcity" value="<?php echo $db_member[0]['unitcity']; ?>" class="span6 m-wrap required" />
			  </div>
			</div>
			</div>

			<div class="control-group">
              <label class="control-label">Zip code<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Czipcode" id="Czipcode" value="<?php echo $db_member[0]['unit_zip']; ?>" class="span6 m-wrap required" />
              </div>
            </div>
          
            <div class="control-group">
              <label class="control-label">Address<span class="required">*</span></label>
              <div class="controls">
			  <textarea name="unitaddress" id="unitaddress" value="<?php echo $db_member[0]['unitaddress']; ?>" class="span6 m-wrap required" rows="3"><?php echo $db_member[0]['unitaddress']; ?></textarea>
              </div>
            </div>

		   <div class="control-group">
              <label class="control-label">Accessibility<span class="required">*</span></label>
              <div class="controls">
				<select class="span6 m-wrap required" name="unit_access" id="unit_access" >
				<option value="">Select</option>
				  <option <?php if($db_member[0]['unit_access']=='Public'){ echo "selected='selected'";}?> value="Public">Public</option>
				  <option  <?php if($db_member[0]['unit_access']=='Member'){ echo "selected='selected'";}?> value="Member"><?php if($hostclub=='1'){ ?>Member<?php } else {?> Corporate<?php } ?></option>
				  <option <?php if($db_member[0]['unit_access']=='Private'){ echo "selected='selected'";}?> value="Private">Private</option>
                </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">RSVP Mode<span class="required"></span></label>
              <div class="controls">
				<select class="span6 m-wrap" name="unit_rsvpmode" onchange="hide_msg(this.value)" id="unit_rsvpmode" >
				<option value="">Select</option>
				  <option   <?php if($db_member[0]['unit_rsvpmode']=='ViaApp'){ echo "selected='selected'";}?> value="ViaApp">ViaApp</option>
				  <option  <?php if($db_member[0]['unit_rsvpmode']=='ViaHost'){ echo "selected='selected'";}?> value="ViaHost">ViaHost</option>
                </select>
              </div>
            </div>
        
           <div id="rsvp_msg" class="control-group" <?php if($db_member[0]['unit_rsvpmode']=='ViaApp'){ ?> style="display:none"; <?php }?>>
              <label class="control-label">RSVP Message<span class="required"></span></label>
              <div class="controls">
                 <textarea name="unit_rsvpmsg"  <?php if($db_member[0]['unit_rsvpmode']=='ViaApp'){ }?> id="unit_rsvpmsg" value="<?php echo $db_member[0]['unit_rsvpmsg']; ?>" class="span6 m-wrap" rows="3"><?php echo $db_member[0]['unit_rsvpmsg']; ?></textarea>
              </div>
            </div>
			
            
            <div class="control-group">
              <label class="control-label">Time Zone<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_timezone" id="unit_timezone" class="span6 m-wrap required">
              <?php $AllTimeZone = $objData->getAll("select * from tbl_timezone where status = 1");	?>
              	<option value="">Select</option>
              	<?php foreach($AllTimeZone as $AllTimeZones){ ?>
                	 <option value="<?php echo $AllTimeZones['id'];?>" <?php if($AllTimeZones['id'] == $db_member[0]['unit_timezone']){?> selected="selected"  <?php } ?>><?php echo $AllTimeZones['full_timezone'];?></option>
                <?php } ?>
              </select>
              </div>
            </div>
            
			<div class="control-group">
              <label class="control-label">Week OpenHour<span class="required">*</span></label>
              <div class="controls">
					<select name="unit_weekopen" id="unit_weekopen" class="span6 m-wrap required chosen"  style="width:auto">
                         <?php echo createHours('',$db_member[0]['unit_weekopen'],$r,$timings); ?>
					</select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Week CloseHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekclose" id="unit_weekclose" class="span6 m-wrap required chosen"  style="width:auto">
                   <?php echo createHours('',$db_member[0]['unit_weekclose'],$r,$timings); ?>
			  </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Weekend OpenHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekendopen" id="unit_weekendopen" class="span6 m-wrap required chosen"  style="width:auto">
                        <?php echo createHours('',$db_member[0]['unit_weekendopen'],$r,$timings); ?>
					</select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Weekend CloseHour<span class="required">*</span></label>
              <div class="controls">
			  <select name="unit_weekendclose" id="unit_weekendclose" class="span6 m-wrap required chosen"  style="width:auto">
                        <?php echo createHours('',$db_member[0]['unit_weekendclose'],$r,$timings); ?>
					</select>
              </div>
            </div>
			
            
            <div class="control-group">
              <label class="control-label">Status<span class="required"></span></label>
              <div class="controls">
                <select name="unitstatus"  class="span6 m-wrap">
                  <option value="1" <?php if($db_member[0]['unitstatus'] == '1') { ?> selected="selected"<?php } ?>>Active</option>
                  <option value="0" <?php if($db_member[0]['unitstatus'] == '0') { ?> selected="selected"<?php } ?>>InActive</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="update" class="btn blue" value="Update">
              <a href="add_units.php?did=<?php echo $_GET['Id']; ?>" onclick="return delete_Cus('<?php echo $_GET['Id']; ?>');"  class="btn red" >Delete Dome</a> 
              
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
			data: {unit_country:"unit_country",ctr_id:ctr_id},
			type: "POST",
			success: function(data)
			{ 
				//alert(data);
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
function get_address(Cid)
{ 
    $('#loader').css('display','inline-block');
    $('#unitcountry').attr('readonly',true);
	$('#unitaddress').attr('readonly',true);
	$.ajax({
			url: 'ajax.php',
			data: {get_address:"get_address",Cid:Cid},
			type: "POST",
			success: function(data)
			{
				var resval=data.split('~~~~~');
				//alert(resval);
				
				
				$('#unitaddress').val(resval[0].trim());
				
				$('select[name^="unitcountry"] option[value='+resval[2]+']').attr("selected","selected");
				
				$('#unitcity').val(resval[4]);
				if (resval[1]== 2)
				{
					$('#unit_access option[value="Member"]').text("Corporate");
				}
				else
				{
					$('#unit_access option[value="Member"]').text("Member");
				}
				
				test(resval[2],resval[3]);
				//document.getElementById("unitcountry").onchange(resval[2]);
				//$('select[name^="unitstate"] option[value='+resval[3]+']').attr("selected","selected");
				$('#unitcountry').attr('readonly',false);
				$('#unitaddress').attr('readonly',false);
				$('#loader').css('display','none');
			}
		});
}

function test(state_id,cid)
{ 
	//alert(state_id);
	//alert(cid);
	$.ajax({
			url: 'ajax.php',
			data: {unit_select_state:"unit_select_state",state_id:state_id,ctr_id:cid},
			type: "POST",
			success: function(data)
			{ 
				$('#unit_state').html(data);

			}
		});      
}
function delete_Cus(id)
	{
		 var x=confirm('Do you want to delete this unit?');
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
function hide_msg(mode){
	//alert(mode);
	if(mode=='ViaApp'){
		$("#rsvp_msg").css('display','none');
		//$("#unit_rsvpmsg").text('');
		
		
	}
	else if(mode=='ViaHost'){
		$("#rsvp_msg").css('display','block');
	}else{
		
	}
}	
</script> 
<style>
.loader{display:none;}
</style>