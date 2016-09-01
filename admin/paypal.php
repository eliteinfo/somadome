<?php 
include '../lib/module.php';
if($_SESSION['classgod_id'] == '')
{
    echo "<script> window.location.href = 'login.php' </script>";	
}
$intMId     =   base64_decode($_GET['id']);
$arrM       =   $objModule->getAll("SELECT tm.*,tp.title as post_title,tu.paypal FROM 	
	`tbl_milestone` tm 
		LEFT JOIN `tbl_milestone_payment` tmp ON tmp.`mid` = tm.`id`	
		INNER JOIN tbl_post tp ON tm.`post_id` = tp.`id`
                INNER JOIN tbl_users tu ON tu.Id = tp.win_uid
		WHERE tm.`id` = '".$intMId."' AND (tp.`win_status` = '1' OR tp.`win_status` = '4') AND tp.`status` = '1'
            GROUP BY tm.`id`
            ORDER BY tm.`id` DESC");

if(!empty($arrM))
{
    if($arrM[0]['status']!=3)
    {
        $objModule->setMessage("Payment not done of selected milestone by buyer","error");
        $objModule->redirect("payment.php");
    }
    if($arrM[0]['paypal']=='')
    {
        $objModule->setMessage("Tutor not have valid paypal email id ","error");
        $objModule->redirect("payment.php");
    }
    
    $arrFactor = $objModule->getAll("SELECT * FROM tbl_factor WHERE id = '1'");
    if($arrFactor[0]['perce']!='')
    {
         $intTemp = $arrM[0]['cost'] - ($arrM[0]['cost'] * $arrFactor[0]['perce'])/100;
         $intAmount = round($intTemp, 2);
    }
    else
    {
        $intAmount = round($arrM[0]['cost'], 2);
    }
    if($intAmount!='')
    {
        $objData =  new PCGData();
        $objData->setTableDetails("tbl_temp_tutor","id");
        $objData->setFieldValues("mid",$arrM[0]['id']);
        $objData->setFieldValues("cost",$intAmount);
        $objData->setFieldValues("uid",$arrM[0]['uid']);
        $objData->setFieldValues("post_id",$arrM[0]['post_id']);
        $objData->insert();
        $intLastId = $objData->intLastInsertedId;
        unset($objData);
    }
    else
    {
        $objModule->setMessage("Amount Should not be blank","error");
        $objModule->redirect("payment.php");
    }
}
else
{
    $objModule->setMessage("Link not valid","error");
    $objModule->redirect("payment.php");
}
?>
<body style='width: 70%;margin: 0 auto;'>
   <span style='text-align: center;'><p style='margin-top: 20px;border: 1px solid;border-radius: 6px;padding: 8px 25px;'>Please<strong> do not</strong> close the PayPal window until you have been redirected to the thank you confirmation page on our website otherwise your order will not be processed.<br/><br/><br/>Please wait while we redirect you to Paypal...</p></span> 
</body>
<form id="frmpaypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="pixcapp_form">
    <input type="hidden" name="cmd" value="_xclick"/>
    <input type="hidden" name="item_name" value="Assignment"/>
    <input type="hidden" name="amount" value="<?php echo $intAmount; ?>" id="amount"/>
    <input type="hidden" name="business" value="<?php echo $arrM[0]['paypal'];?>"/> <!-- vipul.eng.55-facilitator@gmail.com -->
    <input type="hidden" name="notify_url" value="<?php echo $objModule->SITEURL."admin/paypal_notify.php" ?>"/>
    <input type="hidden" name="currency_code" value="USD"/>
    <input type="hidden" name="return" value="<?php echo $objModule->SITEURL."admin/payment.php" ?>"/>
    <input type="hidden" name="cancel_return" value="<?php echo $objModule->SITEURL."admin/payment.php" ?>"/>
    <input type="hidden" name="custom" value="<?php echo $intLastId;?>" />
    <input type="hidden" name="cbt" value="Click here to return to site"/>
</form>
<script type="text/javascript">
    document.getElementById("frmpaypal").submit();
</script>