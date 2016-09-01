<?php 
include('lib/module.php');
if($_REQUEST['code']!='' && isset($_REQUEST['code']))
{
   $code =	$_REQUEST['varifyCode'];
   $finalCode = explode('@',$code);
   //$arrData = $objData->getAll("select * from soma_users where Uid = '".$finalCode['1']."' and "); 
   
   			$objData = new PCGData();
			$objData->setTableDetails("soma_users", "Uid");
			$objData->setFieldValues("Ustatus",'1');
			$objData->setWhere("Uid = '".$finalCode['1']."'");
			$objData->update();
			$objModule->setMessage("Thank You for registering","success");
			$objModule->redirect('./index.php?msg=sucess');	
  
}
?>