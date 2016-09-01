<?php
include('lib/module.php');
if($_POST['unit_country']!='' and $_POST['ctr_id']!='')
{
?>
<li>
<label>State*</label>
<select class="required" name="Ustate" id="Ustate" onchange="get_city(this.value)">
			<option value="">Select State</option>
			 <?php
			 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$_POST['ctr_id']."'");
			 foreach($db_state as $data){ ?>
			  <option value="<?php echo $data['state_id']; ?>"><?php echo $data['state_name']; ?></option>
			 <?php } ?>
			</select>
</li>			

<?php }
if($_POST['unit_state']!='' and $_POST['state_id']!='')
{
?><li>
<label>City*</label>
<input type="text" name="Ucity" class="required" id="Ucity" placeholder="City">
</li>
<?php }

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
if($_POST['CMD'] == 'Event_Add'){
	
		date_default_timezone_set($_REQUEST['timezone']);
		
		//echo"<pre>";print_r($_SESSION);exit;
		$UserEmail = $_SESSION['Uemail'];
		$CurrDateTime = date('Y-m-d H:i:s');
		$frm_date = date('Y-m-d', strtotime($_REQUEST['start_Date']));
		$frtime = str_replace("-",":",$_REQUEST['time']);
		$frm_time = date('H:i', strtotime($frtime));
		
		$to_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
		$totime = str_replace("-",":",$_REQUEST['time']);
		$to_time = date('H:i', strtotime($totime.' + 30 minutes'));
	
		
		$weekDay = date('l', strtotime($frm_date));
		if(strtolower($weekDay) == 'saturday' || strtolower($weekDay) == 'sunday'){
			
			$frm_time_1 = explode(':',$frm_time);
			$frm_T1 = $frm_time_1[0] * 60;
			$ftmCtime = $frm_T1+$frm_time_1[1]; 
			
			$to_time_1 = explode(':',$to_time);
			$to_T1 = $to_time_1[0] * 60;
			$toCtime = $to_T1+$to_time_1[1]; 
			
			$getTime = $objData->getAll("select u.unit_weekendopen, u.unit_weekendclose,u.unitcity,u.unitname,u.unit_timezone,ft.full_timezone  from soma_units u, tbl_timezone ft where ft.id = u.unit_timezone AND  u.Id = '".$_REQUEST['dom_id']."'");
			
			//echo"<pre>";print_r($getTime);exit;
			
			
			/*if($getTime['unit_weekendopen'] <= $ftmCtime &&  $getTime['unit_weekendclose'] <= $toCtime){*/
			if(($ftmCtime >= $getTime[0]['unit_weekendopen'] &&  $ftmCtime <= $getTime[0]['unit_weekendclose']) && ($toCtime >= $getTime[0]['unit_weekendopen'] &&  $toCtime <= $getTime[0]['unit_weekendclose'])){
				
				$chkCurrDateTime = $objData->getAll("select * from soma_user_unit_booking where from_date = '".$frm_date."' AND to_date = '".$frm_date."' and from_time = '".$frm_time."' AND to_time = '".$to_time."' AND dom_id = '".$_REQUEST['dom_id']."' ");
				if(count($chkCurrDateTime)>0){
					
					/*$objData->setTableDetails("soma_user_unit_booking", "Id");
					$objData->setFieldValues("user_status", '1');
					$objData->setFieldValues("book_status", '1');
					$objData->setFieldValues("Uid", $_SESSION['Uid']);
					$objData->setWhere("Id = '".$chkCurrDateTime[0]['Id']."'");
					$objData->update();*/
					$objData->setTableDetails("soma_user_unit_booking", "Id");
					$objData->setFieldValues("Uid", $_SESSION['Uid']);
					$objData->setFieldValues("book_status", '1');
					$objData->setFieldValues("book_datetime", $CurrDateTime);
					$objData->setFieldValues("dom_id", $_REQUEST['dom_id']);
					$objData->setFieldValues("from_date",$frm_date);
					$objData->setFieldValues("to_date", $to_date);
					$objData->setFieldValues("from_time", $frm_time);
					$objData->setFieldValues("to_time", $to_time);
					$objData->setFieldValues("event", $_REQUEST['title']);
					$objData->setFieldValues("user_status", '1');
					$objData->insert();
					//echo"<pre>";print_r($objData->getSQL());
$strMessage .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <style type="text/css">
#outlook a {
 padding: 0;
}
/ Force Outlook to provide a "view in browser" button. /
 body {
 width: 100% !important;
 margin: 0;
 font-family: Open Sans;
}
body {
 -webkit-text-size-adjust: none;
}
 / Prevent Webkit platforms from changing default text sizes. /
body {
 margin: 0;
 padding: 0;
}
img {
 border: 0;
 height: auto;
 line-height: 100%;
 outline: none;
 text-decoration: none;
}
table td {
 border-collapse: collapse;
 width:100%;
}
#backgroundTable {
 height: 100% !important;
 margin: 0;
 padding: 0;
 width: 100% !important;
}
 @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
 / Loading Open Sans Google font /
   body, #backgroundTable {
 background-color: #ccc;
}
table {
 background:#ccc;
}
.TopbarLogo {
 padding: 10px;
 text-align: left;
 vertical-align: middle;
}
h2, .h2 {
 color: #fff;
 display: block;
 font-family: Open Sans;
 font-size: 30px;
 font-weight: 400;
 line-height: 100%;
 margin-top: 2%;
 margin-right: 0;
 margin-bottom: 1%;
 margin-left: 0;
 text-align: left;
}
.textdark {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
}
.textwhite {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
 background:#111116;
}
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ccc; height:52px;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="center" valign="middle" style="padding-left:230px; padding-top:10px; padding-bottom:10px;"><a href="'.$objData->SITEURL.'"> <img src="'.$objData->SITEURL.'images/logo.png" alt="" /> </a></td>
            <td align="right" valign="middle" style="padding-right:0; padding-top:5px;"><table border="0" cellpadding="0" cellspacing="0" width="150px" style="height:100%;">
                <tr> </tr>
              </table></td>
          </tr>
        </table>     
      </center></td>
  </tr> 
   </table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #666;">
    <tr>
        <td>
            <center>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
                    <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center;">You have booked the dome successfully.</h2>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Dome Name:
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                          '.$getTime[0]['unitname'].'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Date
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                            '.$frm_date.'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Time
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '. $frm_time.' to '. $to_time.' '.$getTime[0]['full_timezone'].'
                        </td>
                    </tr>
                     <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            City
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '.$getTime[0]['unitcity'].'
                        </td>
                    </tr>
                     <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center; font-size: 15px;">Thank you for booking with somadome.</h2>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#00538D;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;color:#fff; font-family: arial;">&copy; '.date("Y").' </td>
          </tr>
        </table>
      </center></td>
  </tr>
</table>
</body>
</html>';

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$objData->INFO_MAIL.'';
		mail($UserEmail,'User Booking - Somadome',$strMessage,$headers);
		
					echo "1";exit;
				}else{
					if(isset($_REQUEST['booking']) && $_REQUEST['booking']!='')
					{
						$objData->getAll("delete from soma_user_unit_booking where Id='".$_REQUEST['booking']."'");
					}
					$objData->setTableDetails("soma_user_unit_booking", "Id");
					$objData->setFieldValues("Uid", $_SESSION['Uid']);
					$objData->setFieldValues("book_status", '1');
					$objData->setFieldValues("book_datetime", $CurrDateTime);
					$objData->setFieldValues("dom_id", $_REQUEST['dom_id']);
					$objData->setFieldValues("from_date",$frm_date);
					$objData->setFieldValues("to_date", $to_date);
					$objData->setFieldValues("from_time", $frm_time);
					$objData->setFieldValues("to_time", $to_time);
					$objData->setFieldValues("event", $_REQUEST['title']);
					$objData->insert();
					
					$strMessage .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <style type="text/css">
#outlook a {
 padding: 0;
}
/ Force Outlook to provide a "view in browser" button. /
 body {
 width: 100% !important;
 margin: 0;
 font-family: Open Sans;
}
body {
 -webkit-text-size-adjust: none;
}
 / Prevent Webkit platforms from changing default text sizes. /
body {
 margin: 0;
 padding: 0;
}
img {
 border: 0;
 height: auto;
 line-height: 100%;
 outline: none;
 text-decoration: none;
}
table td {
 border-collapse: collapse;
 width:100%;
}
#backgroundTable {
 height: 100% !important;
 margin: 0;
 padding: 0;
 width: 100% !important;
}
 @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
 / Loading Open Sans Google font /
   body, #backgroundTable {
 background-color: #ccc;
}
table {
 background:#ccc;
}
.TopbarLogo {
 padding: 10px;
 text-align: left;
 vertical-align: middle;
}
h2, .h2 {
 color: #fff;
 display: block;
 font-family: Open Sans;
 font-size: 30px;
 font-weight: 400;
 line-height: 100%;
 margin-top: 2%;
 margin-right: 0;
 margin-bottom: 1%;
 margin-left: 0;
 text-align: left;
}
.textdark {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
}
.textwhite {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
 background:#111116;
}
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ccc; height:52px;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="center" valign="middle" style="padding-left:230px; padding-top:10px; padding-bottom:10px;"><a href="'.$objData->SITEURL.'"> <img src="'.$objData->SITEURL.'images/logo.png" alt="" /> </a></td>
            <td align="right" valign="middle" style="padding-right:0; padding-top:5px;"><table border="0" cellpadding="0" cellspacing="0" width="150px" style="height:100%;">
                <tr> </tr>
              </table></td>
          </tr>
        </table>     
      </center></td>
  </tr> 
   </table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #666;">
    <tr>
        <td>
            <center>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
                    <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center;">You have booked the dome successfully.</h2>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Dome Name:
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                          '.$getTime[0]['unitname'].'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Date
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                            '.$frm_date.'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Time
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '. $frm_time.' to '. $to_time.' '.$getTime[0]['full_timezone'].'
                        </td>
                    </tr>
                     <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            City
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '.$getTime[0]['unitcity'].'
                        </td>
                    </tr>
                     <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center; font-size: 15px;">Thank you for booking with somadome.</h2>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#00538D;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;color:#fff; font-family: arial;">&copy; '.date("Y").' </td>
          </tr>
        </table>
      </center></td>
  </tr>
</table>
</body>
</html>';

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$objData->INFO_MAIL.'';
		mail($UserEmail,'User Booking - Somadome',$strMessage,$headers);
					
					
					
					
					
				echo "0";
				}
				
			}else{
				
				    $SHtime_A = floor($getTime[0]['unit_weekendopen']/60);
					$EHtime_A = floor($getTime[0]['unit_weekendclose']/60);
					$SMtime_A = $getTime[0]['unit_weekendopen']%60;
					if($SMtime_A=='0'){
						$SMtime_A = '00';
					}
					$EMtime_A = $getTime[0]['unit_weekendclose']%60;
					if($EMtime_A=='0'){
						$EMtime_A = '00';
					}
					$FinalStartTime_A = $SHtime_A.':'.$SMtime_A;
					$FinalEndTime_A = $EHtime_A.':'.$EMtime_A;
				
				
				 echo $FinalStartTime_A.'-'.$FinalEndTime_A.'-'.'11';
			}
			
		} else {
			
			
			$frm_time_1 = explode(':',$frm_time);
			$frm_T1 = $frm_time_1[0] * 60;
			$ftmCtime = $frm_T1+$frm_time_1[1]; 
			
			$to_time_1 = explode(':',$to_time);
			$to_T1 = $to_time_1[0] * 60;
			$toCtime = $to_T1+$to_time_1[1]; 
			
			$getTime = $objData->getAll("select u.unit_weekopen,u.unit_weekclose,u.unitcity,u.unitname,u.unit_timezone,ft.full_timezone  from soma_units u, tbl_timezone ft where ft.id = u.unit_timezone AND  u.Id = '".$_REQUEST['dom_id']."'");
			
			//echo"<pre>";print_r($getTime);//exit;
			
			
			/*if($getTime['unit_weekendopen'] <= $ftmCtime &&  $getTime['unit_weekendclose'] <= $toCtime){*/
			if(($ftmCtime >= $getTime[0]['unit_weekopen'] &&  $ftmCtime <= $getTime[0]['unit_weekclose']) && ($toCtime >= $getTime[0]['unit_weekopen'] &&  $toCtime <= $getTime[0]['unit_weekclose'])){	
		
		
		$chkCurrDateTime = $objData->getAll("select * from soma_user_unit_booking where from_date = '".$frm_date."' AND to_date = '".$frm_date."' and from_time = '".$frm_time."' AND to_time = '".$to_time."' AND dom_id = '".$_REQUEST['dom_id']."' ");
		
		/*echo"<pre>";print_r($chkCurrDateTime);
		echo count($chkCurrDateTime);exit;*/
		
		if(count($chkCurrDateTime)>0){
			
			/*$objData->setTableDetails("soma_user_unit_booking", "Id");
			$objData->setFieldValues("user_status", '1');
			$objData->setFieldValues("book_status", '1');
			$objData->setFieldValues("Uid", $_SESSION['Uid']);
			$objData->setWhere("Id = '".$chkCurrDateTime[0]['Id']."'");
			$objData->update();*/
			$objData->setTableDetails("soma_user_unit_booking", "Id");
			$objData->setFieldValues("Uid", $_SESSION['Uid']);
			$objData->setFieldValues("book_status", '1');
			$objData->setFieldValues("book_datetime", $CurrDateTime);
			$objData->setFieldValues("dom_id", $_REQUEST['dom_id']);
			$objData->setFieldValues("from_date",$frm_date);
			$objData->setFieldValues("to_date", $to_date);
			$objData->setFieldValues("from_time", $frm_time);
			$objData->setFieldValues("to_time", $to_time);
			$objData->setFieldValues("event", $_REQUEST['title']);
			$objData->setFieldValues("user_status", '1');
			$objData->insert();
			//echo"<pre>";print_r($objData->getSQL());
			
			$strMessage .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <style type="text/css">
#outlook a {
 padding: 0;
}
/ Force Outlook to provide a "view in browser" button. /
 body {
 width: 100% !important;
 margin: 0;
 font-family: Open Sans;
}
body {
 -webkit-text-size-adjust: none;
}
 / Prevent Webkit platforms from changing default text sizes. /
body {
 margin: 0;
 padding: 0;
}
img {
 border: 0;
 height: auto;
 line-height: 100%;
 outline: none;
 text-decoration: none;
}
table td {
 border-collapse: collapse;
 width:100%;
}
#backgroundTable {
 height: 100% !important;
 margin: 0;
 padding: 0;
 width: 100% !important;
}
 @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
 / Loading Open Sans Google font /
   body, #backgroundTable {
 background-color: #ccc;
}
table {
 background:#ccc;
}
.TopbarLogo {
 padding: 10px;
 text-align: left;
 vertical-align: middle;
}
h2, .h2 {
 color: #fff;
 display: block;
 font-family: Open Sans;
 font-size: 30px;
 font-weight: 400;
 line-height: 100%;
 margin-top: 2%;
 margin-right: 0;
 margin-bottom: 1%;
 margin-left: 0;
 text-align: left;
}
.textdark {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
}
.textwhite {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
 background:#111116;
}
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ccc; height:52px;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="center" valign="middle" style="padding-left:230px; padding-top:10px; padding-bottom:10px;"><a href="'.$objData->SITEURL.'"> <img src="'.$objData->SITEURL.'images/logo.png" alt="" /> </a></td>
            <td align="right" valign="middle" style="padding-right:0; padding-top:5px;"><table border="0" cellpadding="0" cellspacing="0" width="150px" style="height:100%;">
                <tr> </tr>
              </table></td>
          </tr>
        </table>     
      </center></td>
  </tr> 
   </table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #666;">
    <tr>
        <td>
            <center>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
                    <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center;">You have booked the dome successfully.</h2>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Dome Name:
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                          '.$getTime[0]['unitname'].'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Date
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                            '.$frm_date.'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Time
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '. $frm_time.' to '. $to_time.' '.$getTime[0]['full_timezone'].'
                        </td>
                    </tr>
                     <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            City
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '.$getTime[0]['unitcity'].'
                        </td>
                    </tr>
                     <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center; font-size: 15px;">Thank you for booking with somadome.</h2>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#00538D;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;color:#fff; font-family: arial;">&copy; '.date("Y").' </td>
          </tr>
        </table>
      </center></td>
  </tr>
</table>
</body>
</html>';

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$objData->INFO_MAIL.'';
		mail($UserEmail,'User Booking - Somadome',$strMessage,$headers);
			
			
			echo "1";exit;
		}else{
            if(isset($_REQUEST['booking']) && $_REQUEST['booking']!='')
            {
                $objData->getAll("delete from soma_user_unit_booking where Id='".$_REQUEST['booking']."'");
            }
			$objData->setTableDetails("soma_user_unit_booking", "Id");
			$objData->setFieldValues("Uid", $_SESSION['Uid']);
			$objData->setFieldValues("book_status", '1');
			$objData->setFieldValues("book_datetime", $CurrDateTime);
			$objData->setFieldValues("dom_id", $_REQUEST['dom_id']);
			$objData->setFieldValues("from_date",$frm_date);
			$objData->setFieldValues("to_date", $to_date);
			$objData->setFieldValues("from_time", $frm_time);
			$objData->setFieldValues("to_time", $to_time);
			$objData->setFieldValues("event", $_REQUEST['title']);
			$objData->insert();
			$strMessage .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <style type="text/css">
#outlook a {
 padding: 0;
}
/ Force Outlook to provide a "view in browser" button. /
 body {
 width: 100% !important;
 margin: 0;
 font-family: Open Sans;
}
body {
 -webkit-text-size-adjust: none;
}
 / Prevent Webkit platforms from changing default text sizes. /
body {
 margin: 0;
 padding: 0;
}
img {
 border: 0;
 height: auto;
 line-height: 100%;
 outline: none;
 text-decoration: none;
}
table td {
 border-collapse: collapse;
 width:100%;
}
#backgroundTable {
 height: 100% !important;
 margin: 0;
 padding: 0;
 width: 100% !important;
}
 @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
 / Loading Open Sans Google font /
   body, #backgroundTable {
 background-color: #ccc;
}
table {
 background:#ccc;
}
.TopbarLogo {
 padding: 10px;
 text-align: left;
 vertical-align: middle;
}
h2, .h2 {
 color: #fff;
 display: block;
 font-family: Open Sans;
 font-size: 30px;
 font-weight: 400;
 line-height: 100%;
 margin-top: 2%;
 margin-right: 0;
 margin-bottom: 1%;
 margin-left: 0;
 text-align: left;
}
.textdark {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
}
.textwhite {
 color: #fff;
 font-family: Open Sans;
 font-size: 16px;
 line-height: 150%;
 text-align: left;
 background:#111116;
}
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ccc; height:52px;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="center" valign="middle" style="padding-left:230px; padding-top:10px; padding-bottom:10px;"><a href="'.$objData->SITEURL.'"> <img src="'.$objData->SITEURL.'images/logo.png" alt="" /> </a></td>
            <td align="right" valign="middle" style="padding-right:0; padding-top:5px;"><table border="0" cellpadding="0" cellspacing="0" width="150px" style="height:100%;">
                <tr> </tr>
              </table></td>
          </tr>
        </table>     
      </center></td>
  </tr> 
   </table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #666;">
    <tr>
        <td>
            <center>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
                    <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center;">You have booked the dome successfully.</h2>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Dome Name:
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                          '.$getTime[0]['unitname'].'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Date
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                            '.$frm_date.'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Time
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '. $frm_time.' to '. $to_time.' '.$getTime[0]['full_timezone'].'
                        </td>
                    </tr>
                     <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            City
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '.$getTime[0]['unitcity'].'
                        </td>
                    </tr>
                     <tr style="width:100%; text-align:center;">
                        <td colspan="2" align="center" valign="middle" style=" width:100%;padding:20px; text-align:center;">
                            <h2 style="text-align:center; font-size: 15px;">Thank you for booking with somadome.</h2>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#00538D;">
      <tr>
    <td align="center"><center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
          <tr>
            <td align="right" valign="middle" class="textwhite" style="font-size:12px;padding:20px;color:#fff; font-family: arial;">&copy; '.date("Y").' </td>
          </tr>
        </table>
      </center></td>
  </tr>
</table>
</body>
</html>';

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$objData->INFO_MAIL.'';
		mail($UserEmail,'User Booking - Somadome',$strMessage,$headers);
			
			
			echo "0";
		}
		}else{
			
			 		$SHtime_A = floor($getTime[0]['unit_weekopen']/60);
					$EHtime_A = floor($getTime[0]['unit_weekclose']/60);
					$SMtime_A = $getTime[0]['unit_weekopen']%60;
					if($SMtime_A=='0'){
						$SMtime_A = '00';
					}
					$EMtime_A = $getTime[0]['unit_weekclose']%60;
					if($EMtime_A=='0'){
						$EMtime_A = '00';
					}
					$FinalStartTime_A = $SHtime_A.':'.$SMtime_A;
					$FinalEndTime_A = $EHtime_A.':'.$EMtime_A;
				
				
				 echo $FinalStartTime_A.'-'.$FinalEndTime_A.'-'.'11';
			
		}
		}
}
if($_REQUEST['CMD']=='MORE_DOMES')
{
	if($_SESSION['Uid']!=''){
		$db_user = $objData->getAll("select * from soma_users where Uid='".$_SESSION['Uid']."'");

		$db_soma_user_cus = $objData->getAll("select group_concat(Cid) as cids from soma_user_customer where Uid='".$_SESSION['Uid']."'");

		$arrHostsdomes=$objData->getAll("SELECT GROUP_CONCAT(Id) as huids FROM  soma_units WHERE (unit_access ='Public' or unit_access='Member') and Cus_id in(".$db_soma_user_cus[0]['cids'].") AND unitstatus =  '1'");

		$db_public_cus=$objData->getAll("SELECT GROUP_CONCAT(Id) as puids FROM  soma_units WHERE unit_access ='Public' AND unitstatus = '1'");

		if($arrHostsdomes[0]['huids']!='')
			$prefinalids=$arrHostsdomes[0]['huids'].','.$db_public_cus[0]['puids'];
		else
			$prefinalids=$db_public_cus[0]['puids'];

		$table="soma_units u left join soma_customers c on c.Cid=u.Cus_id";
		$fields=array("u.*,c.Cname,c.Cimage,((((acos(sin((".$db_user[0]['Ulat']."*pi()/180)) * sin((u.unitlat*pi()/180)) + cos((".$db_user[0]['Ulat']."*pi()/180)) * cos(((u.unitlat)*pi()/180)) * cos(((".$db_user[0]['Ulong']." - (u.unitlong))*pi()/180))))*180/pi())*60*1.1515)) as dis");
		$where="u.unitstatus='1' and u.unit_access!='Private' and u.Id in(".$prefinalids.") ".$search."";
		$grpby='';
		$order="dis ASC, u.Id DESC";
		$start=$_REQUEST['limit'];
		$db_customer1=$objData->getAll($table,$fields,$where,$grpby,$order,$start,6);
	}else {
		$db_public_cus = $objData->getAll("SELECT GROUP_CONCAT(Id) as puids FROM  soma_units WHERE unit_access ='Public' AND unitstatus ='1'");
		$prefinalids = $db_public_cus[0]['puids'];
		$table="soma_units u left join soma_customers c on c.Cid=u.Cus_id";
		$fields=array("u.*,c.Cname,c.Cimage");
		$where="u.unitstatus='1' and u.Id in(".$prefinalids.") ".$search."";
		$grpby='';
		$order="u.Id DESC";
		$start=$_REQUEST['limit'];
		$db_customer1=$objData->getAll($table,$fields,$where,$grpby,$order,$start,6);
	}
	foreach($db_customer1  as $dballs){
		?>
        <?php  $arrDom = $objData->getAll("select u.*,C.Cname,C.Cimage,C.Caddress,C.Ccountry,C.Czipcode from soma_units u left join soma_customers C on u.Cus_id=C.Cid where u.Id ='".$dballs['Id']."'");?>
		<li>
            	
				<?php
				if($dballs['Cimage']!='' && file_exists("uploads/cus_profile/".$dballs['Cimage']))
				{
					$img=$dballs['Cimage'];
				}
				else
				{
					$img='placeholder.jpg';
				}
				?>
                <div class="home_a_div">
				<a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php }else{?>  href="javascript:void(0)" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                
                
                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
					<a class="soma_tp_a" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" title=""><img src="images/ico_BookNow.png" alt=""></a>
          		 <?php }else{ 
                    if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
               		<a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                   <?php } else { ?>
                       <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                	<?php } ?>    
		    	 <?php } ?>
                 </div>
                 
					<div class="bxlcont">
						<h2><?php //echo ucfirst($dballs['Cname']); ?><?php echo ucfirst($dballs['unitname']); ?> - <?php echo ucfirst($dballs['unit_access']); ?></h2>
                        
						
						<?php
$StateData=$objData->getAll("select * from tbl_state where state_id='".$dballs['unitstate']."'");
					echo $dballs['unitaddress']; ?>, <?php echo $dballs['unitcity'].", ". $StateData[0]['state_name'];?>
					</div>
					<?php if($_SESSION['Uid']!=''){?>
						<div class="dist"><?php echo round($dballs['dis']*0.621371,2);?><span>Miles</span></div>
					<?php } ?>
				
                
                 
                
                
			</li>
	<?php }
}
if($_REQUEST['CMD']=='GET_DOME_DETAIL')
{
	$date=$_REQUEST['cdate'];
	$weekDay = date('l', strtotime($date));
		if($weekDay == 'Saturday' || $weekDay == 'Sunday'){
			$arrDom = $objData->getAll("select u.unit_weekendopen as stime,u.unit_weekendclose as etime from soma_units u where u.Id ='".$_REQUEST['domid']."'");
		}
	else{
		$arrDom = $objData->getAll("select u.unit_weekopen as stime,u.unit_weekclose as etime from soma_units u where u.Id ='".$_REQUEST['domid']."'");
	}

			$SaHtime = floor($arrDom[0]['stime']/60);

            	  $EaHtime = floor($arrDom[0]['etime']/60);
				  $SaMtime = $arrDom[0]['stime']%60;
				  if($SaMtime=='0'){
					  $SaMtime = '00';
				  }
				  $EaMtime = $arrDom[0]['etime']%60;
				  if($EaMtime=='0'){
					  $EaMtime = '00';
				  }
				  if (($EaHtime > 12 && $EaHtime < 24) || ($EaMtime >= 01 && $EaMtime < 59)){
           		  	$PM = "PM";
           		  }else {
           		  	$PM = "AM";
           		  }
           		  if (($SaHtime >= 0 && $SaHtime < 12)){
           		  	$AM = "AM";
           		  }else {
           		  	$AM = "PM";
           		  }

		$str=$SaHtime.':'.$SaMtime.$AM.' to '. $EaHtime.':'.$EaMtime.$PM;
		 
			echo $str;
}
?>



