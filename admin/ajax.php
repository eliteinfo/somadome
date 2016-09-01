<?php

include('../lib/module.php');


if($_POST['c_country']!='' and $_POST['ctr_id']!=''){?>

<div class="control-group">
  <label class="control-label">State<span class="required">*</span></label>
  <div class="controls">
	<select class="span6 m-wrap required" name="Cstate" id="Cstate" onchange="get_city(this.value)">
	<option value="">Select State</option>
	 <?php
	 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$_POST['ctr_id']."'");
	 foreach($db_state as $data){ ?>
	  <option value="<?php echo $data['state_id']; ?>"><?php echo $data['state_name']; ?></option>
	 <?php } ?>
	</select>
  </div>
</div>

<?php }
if($_POST['c_state']!='' and $_POST['state_id']!=''){ ?>
	
    <div class="control-group">
      <label class="control-label">City<span class="required">*</span></label>
      <div class="controls">
         <input type="text" name="Ccity" id="Ccity" value="" class="span6 m-wrap required" />
      </div>
    </div>
<?php } ?>	
<?php if($_POST['unit_country']!='' and $_POST['ctr_id']!=''){ ?>

<div class="control-group">
  <label class="control-label">State<span class="required">*</span></label>
  <div class="controls">
	<select class="span6 m-wrap required" name="unitstate" id="unitstate" onchange="get_city(this.value)">
	<option value="">Select State</option>
	 <?php
	 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$_POST['ctr_id']."'");
	 foreach($db_state as $data){ ?>
	  <option value="<?php echo $data['state_id']; ?>"><?php echo $data['state_name']; ?></option>
	 <?php } ?>
	</select>
  </div>
</div>

<?php }
if($_POST['unit_state']!='' and $_POST['state_id']!='')
{
?>

<div class="control-group">
  <label class="control-label">City<span class="required">*</span></label>
  <div class="controls">
	 <input type="text" name="unitcity" id="unitcity" value="" class="span6 m-wrap required" />
  </div>
</div>

<?php }
if($_POST['get_address']!='' and $_POST['get_address']!='')
{
	$db_address = $objData->getAll("SELECT * FROM soma_customers WHERE Cid='".$_POST['Cid']."'");
	//echo"<pre>";print_r($db_address);exit;
	echo $db_address[0]['Caddress'].'~~~~~'.$db_address[0]['Cclub'].'~~~~~'.$db_address[0]['Ccountry'].'~~~~~'.$db_address[0]['Cstate'].'~~~~~'.$db_address[0]['Ccity'];
}

if($_POST['checkemail']!='' and $_POST['email']!='')
{
	$customers_email=$objData->getAll("select * from soma_customers where Cemail = '".$_POST['email']."'");
	if(count($customers_email)>0){
		echo '0';
	}
	else{
		echo '1';
	}
}
if($_POST['unit_select_state']!=''){ ?>
	
    <?php //echo"<pre>";print_r($_POST);?>
	<div class="control-group">
      <label class="control-label">State<span class="required">*</span></label>
      <div class="controls">
        <select class="span6 m-wrap required" name="unitstate" id="unitstate" onchange="get_city(this.value)">
        <option value="">Select State</option>
         <?php
         $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$_POST['state_id']."'");
		 //echo"SELECT * FROM tbl_state WHERE ctr_id='".$_POST['ctr_id']."'";
		 
         foreach($db_state as $data){ ?>
          <option value="<?php echo $data['state_id']; ?>" <?php if($data['state_id'] == $_POST['ctr_id']){?> selected="selected" <?php } ?> ><?php echo $data['state_name']; ?></option>
         <?php } ?>
        </select>
      </div>
    </div>
<?php }

?>



