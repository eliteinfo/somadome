<?php include('includes/header.inc.php');?>
<?php if($_SESSION['Uid'] == ''){ ?>
	<?php  $objModule->redirect("./index.php");
}
if($_GET['del_id'] != '')
{
	
	
	//echo"<pre>";print_r($CancelData);exit;
	
	$objData->getAll("update soma_user_unit_booking set user_status='2', book_status='2' where Id = '".$_GET['del_id']."'");
	
	$CancelData = $objData->getAll("Select suub.*, su.unitname, ut.full_timezone from soma_user_unit_booking as suub, soma_units as su, tbl_timezone as ut  where su.unit_timezone = ut.id AND suub.dom_id = su.Id AND suub.Id = '".$_GET['del_id']."'");
	
	
	
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
                          '.$CancelData[0]['unitname'].'
                        </td> 
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Date
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                            '.$CancelData[0]['from_date'].'
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Time
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                           '. date("H:i",$CancelData[0]['from_time']).' to '. date("H:i",$CancelData[0]['to_time']).' '.$CancelData[0]['full_timezone'].'
                        </td>   
                    </tr>
                    <tr>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:right;">
                            Status
                        </td>
                        <td valign="top" style="padding:20px; width:45%; float:left; text-align:left;">
                          Cancel Booking
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
		mail($_SESSION['Uemail'],'Cancel Booking - Somadome',$strMessage,$headers);
	
	
	 echo "<script> window.location.href = 'booking_history.php' </script>";	
}
if(isset($_REQUEST['rebook']) && $_REQUEST['rebook'])
{
    $arrCancelDetail=$objData->getAll("select * from soma_user_unit_booking where Id='".$_REQUEST['rebook']."'");
	
	//echo count($arrCancelDetail);exit;

    if(count($arrCancelDetail)>0)
    {
        $ArrExists=$objData->getAll("select * from soma_user_unit_booking where dom_id='".$arrCancelDetail[0]['dom_id']."' and from_date='".$arrCancelDetail[0]['from_date']."' and from_time='".$arrCancelDetail[0]['from_time']."' and book_status='1'");
		
		//echo count($ArrExists);exit;
		
        if(count($ArrExists)>0)
        {
			
			
			   
        	echo '<script type="text/javascript">alert("This slot is booked by someone else, try to book new slot");</script>';
   			 //$objModule->setMessage("This slot is booked by someone else, try to book new slot","error");
            $objModule->redirect('booking_history.php');
        }
        else{
			
			$ttS1 = $arrCancelDetail[0]['from_date'].' '.$arrCancelDetail[0]['from_time'] ;
          /*  echo $dt=date('Y-m-d')."</br>";
            echo $tm=date("H:i:s")."</br>";
			echo $arrCancelDetail[0]['from_date']."</br>";
			echo $arrCancelDetail[0]['from_time']."</br>";*/
			if( strtotime($ttS1) > strtotime('now') ) 
            /*if($arrCancelDetail[0]['from_date']>=$dt && $arrCancelDetail[0]['from_time']<$tm)*/
            {
				
				//echo "test";exit;
                $objData->setTableDetails("soma_user_unit_booking", "Id");
                $objData->setFieldValues("Uid", $_SESSION['Uid']);
                $objData->setFieldValues("book_status", '1');
                $objData->setFieldValues("book_datetime", $arrCancelDetail[0]['book_datetime']);
                $objData->setFieldValues("dom_id", $arrCancelDetail[0]['dom_id']);
                $objData->setFieldValues("from_date",$arrCancelDetail[0]['from_date']);
                $objData->setFieldValues("to_date", $arrCancelDetail[0]['to_date']);
                $objData->setFieldValues("from_time", $arrCancelDetail[0]['from_time']);
                $objData->setFieldValues("to_time", $arrCancelDetail[0]['to_time']);
                $objData->setFieldValues("event", 'Booking');
                $objData->insert();
                $objData->getAll("delete from soma_user_unit_booking where Id='".$_REQUEST['rebook']."'");
				echo '<script type="text/javascript">alert("Congrats, your dome is re-booked");</script>';
                //$objModule->setMessage('Congrats, your dome is re-booked','success');
                $objModule->redirect('booking_history.php');
            }
            else{
				//echo"test";exit;
				echo '<script type="text/javascript">alert("You can not re-book dome for past date or time");</script>';
                $objModule->setMessage('You can not re-book dome for past date or time','error');
                $objModule->redirect('booking_history.php');
            }
        }
    }
}
?>
<?php
$arrEvent = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE Uid='".$_SESSION['Uid']."' order by from_date desc ");

$arrUpcommingList = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE Uid='".$_SESSION['Uid']."' AND book_status=1 order by from_date desc ");

$arrCompleteList = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE Uid='".$_SESSION['Uid']."' AND book_status=3 order by from_date desc ");


$arrCancelList = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE Uid='".$_SESSION['Uid']."' AND book_status=2 order by from_date desc ");

?>

<!--- header ends -->

<!---top head start----->
<div id="tabs">
<div class="top_head">
	<div class="wrapper">
    <div class="tpleft">
        <?php $arrBookEvent= $objData->getAll("SELECT COUNT(Id) as bid FROM soma_user_unit_booking where Uid='".$_SESSION['Uid']."' and book_status='2'");
        $arrUpcomming= $objData->getAll("SELECT COUNT(Id) as bid FROM soma_user_unit_booking where Uid='".$_SESSION['Uid']."' and book_status=1");


		$arrcmplt= $objData->getAll("SELECT COUNT(Id) as bid FROM soma_user_unit_booking where Uid='".$_SESSION['Uid']."' and book_status=3");
		?>

<ul class="booking">
<li class="gry" id="#tabs-1"><h1><?php echo count($arrEvent);?></h1>Bookings</li>
<li class="pur" id="#tabs-2"><h1><?php echo $arrUpcomming[0]['bid']; ?></h1>Upcoming</li>
<li class="green" id="#tabs-3"><h1><?php echo $arrcmplt[0]['bid'];?></h1>Completed</li>
<li class="red" id="#tabs-4"><h1><?php echo $arrBookEvent[0]['bid']; ?></h1>Cancelled</li>
</ul>

    </div>
        <?php if($url1[2]=='booking_history.php') {
            ?>
            <div style="float: right; margin-top: 18px;"><?php echo $objModule->getMessage(); ?></div>
        <?php
        }
?>
</div>
</div>
<!---top head end----->

<div class="book_cont">
	<div class="wrapper">
    <ul class="bkhead">



    	<li></li>
    	<li>Date</li>
        <li>Time</li>
        <li>Dome</li>
        <li>City</li>
        <li>Status</li>
    </ul>
    </div>
</div>
<div class="booklist">
	<div class="wrapper">
    
    	
    	<ul class="bklist" id="tabs-1" style="display:none;"> 
        
        <?php if(count($arrEvent)>0){ ?>       
        <?php foreach($arrEvent as $arrEvents){
            $arrHost=$objData->getAll("select U.*,C.Cname from soma_customers C left join soma_units U on C.Cid=U.Cus_id where U.Id='".$arrEvents['dom_id']."'");
            ?>
            
         <li>
            <ul>   
            <li <?php if($arrEvents['book_status']=='1'){ ?> class="elips" <?php } else if($arrEvents['book_status']=='2'){?> class="close1"<?php } else if($arrEvents['book_status']=='3'){ ?> class="rg_icon" <?php } ?>> </li>
            <li><span class="dtlable">Date:</span><?php echo date("F j, Y", strtotime($arrEvents['from_date'])); ?></li>
            <?php $frm_hrs = date("H:i", strtotime($arrEvents['from_time']));?>
            <?php $to_hrs = date("H:i", strtotime($arrEvents['to_time']));?>
            <li><span class="dtlable">Time:</span><?php echo $frm_hrs ?> to <?php echo $to_hrs ?></li>
            <li><span class="dtlable">Dome:</span><?php echo ucfirst($arrHost[0]['unitname']); ?></li>
            <li><span class="dtlable">City:</span><?php echo ucfirst($arrHost[0]['unitcity']); ?> </li>
            <?php $f_date = strtotime(date('Y-m-d'));?>
            <?php $t_date = strtotime($arrEvents['to_date']);?>
            
            <?php $f_time = date("h:i:s");?>
            <?php $t_date = strtotime($arrEvents['from_date']);?>
           
            <?php if($arrEvents['book_status']=='3'){ ?>
            		<li class="grntxt"><span class="dtlable">Status:</span>Completed</li>
            <?php }else if($arrEvents['book_status']=='2'){ ?>
            	 <li class="redtxt"><span class="dtlable">Status:</span>Cancelled</li>
                <li><a href="booking_history.php?rebook=<?php echo $arrEvents['Id']; ?>" class="btn purbtn">re-book</a></li>
            <?php }
            else {
                ?>
                <li class="purtxt"><span class="dtlable">Status:</span>Upcoming</li>
                <li>
                    <a href="booking_history.php?del_id=<?php echo $arrEvents['Id']; ?>" class="btn cancle">cancel</a>
                    <a href="Choose_Session_Time.php?Domid=<?php echo $arrEvents['dom_id']; ?>&booking=<?php echo $arrEvents['Id']; ?>" class="btn edit">edit</a>
                </li>
                <?php
            }
            ?>
    		</ul>
            
        </li>
        <?php } ?>
        <?php }else{ ?>
        
        <h1>No bookings found.</h1>
        <?php } ?>
        </ul>
        
        
        
        
       
        <ul class="bklist" id="tabs-2" style="display:block;">
         <?php if(count($arrUpcommingList)>0){ ?>     
        <?php foreach($arrUpcommingList as $arrEvents){
            $arrHost=$objData->getAll("select U.*, C.Cname from soma_customers C left join soma_units U on C.Cid=U.Cus_id where U.Id='".$arrEvents['dom_id']."'");
            ?>
         <li>
            <ul>   
            <li <?php if($arrEvents['book_status']=='1'){ ?> class="elips"; <?php } else if($arrEvents['book_status']=='2'){?> class="close1";<?php } else if($arrEvents['book_status']=='3'){ ?> class="rg_icon"; <?php } ?>> </li>
            <li><span class="dtlable">Date:</span><?php echo date("F j, Y", strtotime($arrEvents['from_date'])); ?></li>
            <?php $frm_hrs = date("H:i", strtotime($arrEvents['from_time']));?>
            <?php $to_hrs = date("H:i", strtotime($arrEvents['to_time']));?>
            <li><span class="dtlable">Time:</span><?php echo $frm_hrs ?> to <?php echo $to_hrs ?></li>
            <li><span class="dtlable">Dome:</span><?php echo ucfirst($arrHost[0]['unitname']); ?></li>
            <li><span class="dtlable">City:</span><?php echo ucfirst($arrHost[0]['unitcity']); ?> </li>
            <?php $f_date = strtotime(date('Y-m-d'));?>
            <?php $t_date = strtotime($arrEvents['to_date']);?>
            
            <?php $f_time = date("h:i:s");?>
            <?php $t_date = strtotime($arrEvents['from_date']);?>
           
            <?php if($arrEvents['book_status']=='3'){ ?>
            		<li class="grntxt"><span class="dtlable">Status</span>Completed</li>
            <?php }else if($arrEvents['book_status']=='2'){ ?>
            	 <li class="redtxt"><span class="dtlable">Status</span>Cancelled</li>
                <li><a href="booking_history.php?rebook=<?php echo $arrEvents['Id']; ?>" class="btn purbtn">re-book</a></li>
            <?php }
            else {
                ?>
                <li class="purtxt"><span class="dtlable">Status</span>Upcoming</li>
                <li>
                    <a href="booking_history.php?del_id=<?php echo $arrEvents['Id']; ?>" class="btn cancle">cancel</a>
                    <a href="Choose_Session_Time.php?Domid=<?php echo $arrEvents['dom_id']; ?>&booking=<?php echo $arrEvents['Id']; ?>" class="btn edit">edit</a>
                </li>
                <?php
            }
            ?>
    		</ul>
        </li>
        <?php } ?>
        <?php }else{ ?>
        <h1>No bookings found.</h1>
        <?php } ?>
        </ul>
        
        
        
        
       
        <ul class="bklist" id="tabs-3" style="display:none;">
         <?php if(count($arrCompleteList)>0){ ?>
        <?php foreach($arrCompleteList as $arrEvents){
            $arrHost=$objData->getAll("select U.*,C.Cname from soma_customers C left join soma_units U on C.Cid=U.Cus_id where U.Id='".$arrEvents['dom_id']."'");
            ?> 
         <li>
            <ul>   
            <li <?php if($arrEvents['book_status']=='1'){ ?> class="elips"; <?php } else if($arrEvents['book_status']=='2'){?> class="close1";<?php } else if($arrEvents['book_status']=='3'){ ?> class="rg_icon"; <?php } ?>> </li>
            <li><span class="dtlable">Date:</span><?php echo date("F j, Y", strtotime($arrEvents['from_date'])); ?></li>
             <?php $frm_hrs = date("H:i", strtotime($arrEvents['from_time']));?>
            <?php $to_hrs = date("H:i", strtotime($arrEvents['to_time']));?>
            <li><span class="dtlable">Time:</span><?php echo $frm_hrs ?> to <?php echo $to_hrs ?></li>
            <li><span class="dtlable">Dome:</span><?php echo ucfirst($arrHost[0]['unitname']); ?></li>
            <li><span class="dtlable">City:</span><?php echo ucfirst($arrHost[0]['unitcity']); ?> </li>
            <?php $f_date = strtotime(date('Y-m-d'));?>
            <?php $t_date = strtotime($arrEvents['to_date']);?>
            
            <?php $f_time = date("h:i:s");?>
            <?php $t_date = strtotime($arrEvents['from_date']);?>
           
            <?php if($arrEvents['book_status']=='3'){ ?>
            		<li class="grntxt"><span class="dtlable">Status</span>Completed</li>
            <?php }else if($arrEvents['book_status']=='2'){ ?>
            	 <li class="redtxt"><span class="dtlable">Status</span>Cancelled</li>
                <li><a href="booking_history.php?rebook=<?php echo $arrEvents['Id']; ?>" class="btn purbtn">re-book</a></li>
            <?php }
            else {
                ?>
                <li class="purtxt"><span class="dtlable">Status</span>Upcoming</li>
                <li>
                    <a href="booking_history.php?del_id=<?php echo $arrEvents['Id']; ?>" class="btn cancle">cancel</a>
                    <a href="Choose_Session_Time.php?Domid=<?php echo $arrEvents['dom_id']; ?>&booking=<?php echo $arrEvents['Id']; ?>" class="btn edit">edit</a>
                </li>
                <?php
            }
            ?>
    		</ul>
        </li>
        <?php } ?>
         <?php } else{ ?>
       <h1>No bookings found.</h1>
       <?php } ?> 
        </ul>
      
        
        
        
       
        <ul class="bklist" id="tabs-4" style="display:none;"> 
         <?php if(count($arrCancelList)>0){ ?>     
        <?php foreach($arrCancelList as $arrEvents){
            $arrHost=$objData->getAll("select U.*,C.Cname from soma_customers C left join soma_units U on C.Cid=U.Cus_id where U.Id='".$arrEvents['dom_id']."'");
            ?>
         <li>
            <ul>   
            <li <?php if($arrEvents['book_status']=='1'){ ?> class="elips"; <?php } else if($arrEvents['book_status']=='2'){?> class="close1";<?php } else if($arrEvents['book_status']=='3'){ ?> class="rg_icon"; <?php } ?>> </li>
             <li><span class="dtlable">Date:</span><?php echo date("F j, Y", strtotime($arrEvents['from_date'])); ?></li>
            <?php $frm_hrs = date("H:i", strtotime($arrEvents['from_time']));?>
            <?php $to_hrs = date("H:i", strtotime($arrEvents['to_time']));?>
            <li><span class="dtlable">Time:</span><?php echo $frm_hrs ?> to <?php echo $to_hrs ?></li>
            <li><span class="dtlable">Dome:</span><?php echo ucfirst($arrHost[0]['unitname']); ?></li>
            <li><span class="dtlable">City:</span><?php echo ucfirst($arrHost[0]['unitcity']); ?> </li>
            <?php $f_date = strtotime(date('Y-m-d'));?>
            <?php $t_date = strtotime($arrEvents['to_date']);?>
            
            <?php $f_time = date("h:i:s");?>
            <?php $t_date = strtotime($arrEvents['from_date']);?>
           
            <?php if($arrEvents['book_status']=='3'){ ?>
            		<li class="grntxt"><span class="dtlable">Status</span>Completed</li>
            <?php }else if($arrEvents['book_status']=='2'){ ?>
            	 <li class="redtxt"><span class="dtlable">Status</span>Cancelled</li>
                <li><a href="booking_history.php?rebook=<?php echo $arrEvents['Id']; ?>" class="btn purbtn">re-book</a></li>
            <?php }
            else {
                ?>
                <li class="purtxt"><span class="dtlable">Status</span>Upcoming</li>
                <li>
                    <a href="booking_history.php?del_id=<?php echo $arrEvents['Id']; ?>" class="btn cancle">cancel</a>
                    <a href="Choose_Session_Time.php?Domid=<?php echo $arrEvents['dom_id']; ?>&booking=<?php echo $arrEvents['Id']; ?>" class="btn edit">edit</a>
                </li>
                <?php
            }
            ?>
    		</ul>
            
        </li>
        <?php } ?>
        <?php }else{ ?>
         <h1>No bookings found.</h1>
        <?php } ?>
        </ul>
        
        
        
        
    </div>
</div>
</div>

 <script>
 $(document).ready(function(){
    $(".booking li").click(function(){
		var id = this.id;
		var res = id.split("#"); 
		
		if(res[1] == "tabs-1"){
			 $("#tabs-1").css("display", "block");
			 $("#tabs-2").css("display", "none");
			 $("#tabs-3").css("display", "none");
			 $("#tabs-4").css("display", "none");
		}else if(res[1] == "tabs-2"){
			 $("#tabs-1").css("display", "none");
			 $("#tabs-2").css("display", "block");
			 $("#tabs-3").css("display", "none");
			 $("#tabs-4").css("display", "none");
		}else if(res[1] == "tabs-3"){
			 $("#tabs-1").css("display", "none");
			 $("#tabs-2").css("display", "none");
			 $("#tabs-3").css("display", "block");
			 $("#tabs-4").css("display", "none");
		}else if(res[1] == "tabs-4"){
			 $("#tabs-1").css("display", "none");
			 $("#tabs-2").css("display", "none");
			 $("#tabs-3").css("display", "none");
			 $("#tabs-4").css("display", "block");
		}else{
			
		}
        //alert(this.id);
    });
});
 
 </script>
<?php include('includes/footer.inc.php');?>
