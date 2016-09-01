<?php 
include('lib/module.php');
if($_REQUEST['act_code']!='' && isset($_REQUEST['act_code']))
{
   if($_REQUEST['user_type']=='Caregiver')
   {	
		$arrData = $objData->getAll("pre_caregiver_reg_form",array("*"),"verify = '".$_REQUEST['act_code']."'"); 
		//echo "Caregiver"; echo "<br>";
		//echo "<pre>"; print_r($objData->getSQL());die;
		if(!empty($arrData))
		{
			$objData = new PCGData();
			$objData->setTableDetails("pre_caregiver_reg_form", "id");
			$objData->setFieldValues("verify","");
			$objData->setFieldValues("status",'1');
			$objData->setWhere("id = '".$arrData[0]['id']."'");
			$objData->update();
			$objModule->setMessage("Thank You for registering as a Caregiver","success");			
			$objModule->redirect('./thank_you.php?type=verified&user_type=Caregiver');
		}
		else
		{
			$objModule->setMessage("User not exist","error");
			$objModule->redirect('./registration.php');
		} 
	   
   }
   else if($_REQUEST['user_type']=='Careseeker')
   {
	   $arrData = $objData->getAll("pre_careseeker_reg_form",array("*"),"verify = '".$_REQUEST['act_code']."'"); 
	  //echo "Careseeker"; echo "<br>";
	  //echo "<pre>"; print_r($objData->getSQL());die;
		if(!empty($arrData))
		{
			$objData = new PCGData();
			$objData->setTableDetails("pre_careseeker_reg_form", "id");
			$objData->setFieldValues("verify","");
			$objData->setFieldValues("status",'1');
			$objData->setWhere("id = '".$arrData[0]['id']."'");
			$objData->update();	
			$objModule->setMessage("Thank You for registering as a Family","success");			
			$objModule->redirect('./thank_you2.php?type=verified&user_type=Careseeker');
		}
		else
		{
			$objModule->setMessage("User not exist","error");
			$objModule->redirect('./registration.php');
		} 
	   
   }
}
?>