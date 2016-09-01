<?php

include_once('lib/module.php');

$url=$_SERVER['REQUEST_URI'];

$url1=explode('/',$url);



if(isset($_POST['login']))

{    



	//echo"<pre>";print_r($_POST);exit;



	$user_check=$objData->getAll("select * from soma_users where Uemail = '".$_REQUEST['Uemail']."' AND Upass='".md5($_REQUEST['Upass'])."' AND Ustatus='1'");

	if(count($user_check)>0){

		$_SESSION['Uid']=$user_check[0]['Uid'];

		$_SESSION['Uemail']=$user_check[0]['Uemail'];

		if($_POST['book_val']==''){

			$objModule->redirect("index.php");

		}else{
			
			
			loginbooking($_POST['all_info_head'],$_POST['booking_head']);
			if($_POST['booking_type_head'] == 'week'){
			$objModule->redirect("Choose_Session_Time.php?Domid=".$_POST['book_val']);
			}else{
			$Getid = explode("&",$_POST['book_val']);	
			$objModule->redirect("Choose_Session_Time_day.php?Domid=".$Getid[0]."&dt=".$_GET['dt']);	
			}

		}

	}

	else{

		$objModule->setMessage("Invalid Email or Password.","error");

		$objModule->redirect("index.php?msg=error");

	}

}

if(isset($_POST['forgot_pw']))

{    
	//echo"<pre>";print_r($_POST);
	$user_check=$objData->getAll("select * from soma_users where Uemail = '".$_REQUEST['Uemail']."' AND Ustatus='1'");
	//echo"<pre>";print_r($user_check);
	//echo $user_check[0]['id'];exit;

	if(count($user_check)>0){
/*
		$newpassword = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);

        $hashpassword = md5($newpassword);*/
		
		  $encrypt = md5(90*13+$user_check[0]['Uid']);
		 // echo $encrypt;exit;



        $strMessage .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title></title>

    <style type="text/css">

#outlook a {

	padding: 0;

}

/* Force Outlook to provide a "view in browser" button. */

 body {

 width: 100% !important;

 margin: 0;

 font-family: Open Sans;

}

body {

	-webkit-text-size-adjust: none;

}

 /* Prevent Webkit platforms from changing default text sizes. */

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

 /* Loading Open Sans Google font */

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

                    <tr>

                        <td valign="top" style="padding:20px;">

                            <h2>Dear '.$user_check[0]['Uemail'].',</h2>

                            <br/>



                            <div class="textdark">

                                Click here to reset your password.<br/>

								<a href="'.$objData->SITEURL.'reset.php?encrypt='.$encrypt.'&action=reset">'.$objData->SITEURL.'reset.php?encrypt='.$encrypt.'&action=reset</a>
                               

                            </div>

                            <br/>

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

        mail($user_check[0]['Uemail'],'Forgot password - Somadome',$strMessage,$headers);

		/*$sql=$objData->getAll("update soma_users set Upass='".$hashpassword."' where Uemail='".$_REQUEST['Uemail']."'");*/

		//$objModule->setMessage("Please check your email.","success");
		echo "<script language='javascript'>alert('Please check your email.');</script>"; 
		$objModule->redirect("index.php");

	}

	else{

		echo "<script language='javascript'>alert('Invalid Email Address.');</script>"; 
		//$objModule->setMessage("Invalid Email.","error");
		$objModule->redirect("index.php");

	}

		

}
function loginbooking($val,$booking_head){
	
	$objData =  new PCGData();
	//echo $val;exit;
	$value = explode('_',$val);
	//echo"<pre>";print_r($value);
	
	
	
		$d_id = $value[0];
		$title = "Booking";
		$CurrDateTime = date('Y-m-d H:i:s');
		$frm_date = date('Y-m-d', strtotime($value[2]));
		$frtime = str_replace("-",":",$value[1]);
		$frm_time = date('H:i', strtotime($frtime));
		
		$to_date = date('Y-m-d', strtotime($value[2]));
		$totime = str_replace("-",":",$value[1]);
		$to_time = date('H:i', strtotime($totime.' + 20 minutes'));
		
		
		
		$chkCurrDateTime = $objData->getAll("select * from soma_user_unit_booking where from_date = '".$frm_date."' AND to_date = '".$to_date."' and from_time = '".$frm_time."' AND to_time = '".$to_time."' AND dom_id = '".$d_id."'");
		
		
		
		//echo"<pre>";print_r($chkCurrDateTime);
		//echo count($chkCurrDateTime);exit;
		
		if(count($chkCurrDateTime)>0){
			
			$objData->setTableDetails("soma_user_unit_booking", "Id");
			$objData->setFieldValues("user_status", '1');
			$objData->setFieldValues("book_status", '1');
			$objData->setFieldValues("Uid", $_SESSION['Uid']);
			$objData->setWhere("Id = '".$chkCurrDateTime[0]['Id']."'");
			$objData->update();
			//echo"<pre>";print_r($objData->getSQL());
			//echo "1";//exit;
		}else{
            if(isset($booking_head) && $booking_head!='')
            {
                $objData->getAll("delete from soma_user_unit_booking where Id='".$booking_head."'");
            }
			$objData->setTableDetails("soma_user_unit_booking", "Id");
			$objData->setFieldValues("Uid", $_SESSION['Uid']);
			$objData->setFieldValues("book_status", '1');
			$objData->setFieldValues("book_datetime", $CurrDateTime);
			$objData->setFieldValues("dom_id", $d_id);
			$objData->setFieldValues("from_date",$frm_date);
			$objData->setFieldValues("to_date", $to_date);
			$objData->setFieldValues("from_time", $frm_time);
			$objData->setFieldValues("to_time", $to_time);
			$objData->setFieldValues("event", $title);
			$objData->insert();
			//echo "0";
		}
		
		
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Somadome</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href='https://fonts.googleapis.com/css?family=Cabin:400,500,600' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<link rel="stylesheet" type="text/css" href="css/responsive.css" />

<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />

<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />

<link rel="stylesheet" type="text/css" href="css/custom-alert.min.css" />

<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>

<script type="text/javascript" src="js/jquery.fancybox.js"></script>

<script type="text/javascript" src="js/validation.js"></script>



<script type="text/javascript">

$(document).ready(function(){

        $(".fancybox").fancybox();

});     

$(document).ready(function(){

        $(".fancybox2").fancybox();

}); 

function close_box(){

	$('.fancybox-close').trigger("click");

}

function open_popup()

{

   $('.lgin').trigger("click");

    window.history.pushState("string", "Title", "index.php");

}

</script>

<script language="javascript" type="text/javascript">

        $(document).scroll(function () {

                var y = $(this).scrollTop();

                if (y > 150) {

                    $('.top_head').addClass("fix1");

                } else {

                    $('.top_head').removeClass("fix1");

                }

				});

</script>
<script type="text/javascript">
$(document).ready(function(){
$(".advance_icon").click(function(){
$(".advance_search").slideToggle(400);
return false;
});
$(".advance_icon").toggle(function(){
$(this).addClass("active");
}, function () {
$(this).removeClass("active");  
});
});
</script>

</head>

<?php $db_user = $objData->getAll("select * from soma_users where Uid = '".$_SESSION['Uid']."'"); ?>

<body <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']!=''){ ?> onload="open_popup()" <?php } ?>>

<div class="container">

<div class="header">

  <div class="wrapper">

    <div class="logo"><a href="<?php echo $objData->SITEURL ?>"><img src="images/logo.png" alt="" /></a></div>

    <div class="search">

   <form action="index.php" method="POST">

      <input name="searchval" value="<?php echo $_REQUEST['searchval']; ?>" type="text" placeholder="Search" />

       <input type="submit" name="btnSearch" value="Search" />

     </form> 
     
      	
    </div>
    
 <div class="advance_box"><a href="#" class="advance_icon">&nbsp;</a>    <div class="advance_search">
			<div class="accessebility_search">     
               
			<form action="index.php" method="POST">
               <?php /*?><input name="searchval" value="<?php echo $_REQUEST['searchval']; ?>" type="text" placeholder="Search" /><?php */?>
                <label>Search by Dome Accessbility</label>
        		<select name="unit_access_search" id="unit_access_search">
                	<option value="">Please Select</option>
                	<option value="Public">Public</option>
                    <option value="Member">Member</option>
                    <option value="Private">Private</option>
                </select>
                
               <input type="submit" name="btnSearchAccessibility" value="Search" />
        
             </form> 
            </div> 
            <div class="accessebility_search">      
             <form action="index.php" method="POST">
                 <label>Search by Dome RSVPMode</label>
				<select name="unit_rsvpmode" id="unit_rsvpmode">
                	<option value="">Please Select</option>
                	<option value="ViaApp">ViaApp</option>
                    <option value="ViaHost">ViaHost</option>
                </select>
                <input type="submit" name="btnSearchrsvpmode" value="Search" />
             </form>
            </div> 
            <div class="accessebility_search">      
             <form action="index.php" method="POST">
              	  <label>Search by Dome Address</label>
                 <input name="searchaddress" value="<?php echo $_REQUEST['searchval']; ?>" type="text" placeholder="Search" />

      			 <input type="submit" name="btnSearchAddress" value="Search" />
             </form>             
            </div>
		</div>   </div>

	<?php if($_SESSION['Uid']!=''){ ?>

	  <div class="rightlnk"><a href="javascript:void(0);"><div class="proftxt"><?php echo $db_user[0]['Fname']; ?> <img style="width:32px; height:32px;" src="uploads/user_profile/<?php echo $db_user[0]['Upic']; ?>" alt="" /></div></a>

  <div class="profmenu">

  <ul>

   <li><a href="profile.php">Profile</a></li>

   <li><a href="booking_history.php">Bookings</a></li>

   <!--<li><a href="javascript:void(0);">Settings</a></li>-->

   <li><a href="logout.php">Logout</a></li>

   </ul></div>

  </div>

	<?php } else{ ?>

    <div class="rightlnk"><a class="fancybox lgin" href="#inline1">Login/Singup</a></div>

<!--     <div class="rightlnk"><a class="fancybox lgin" href="#inline1"> / </a></div> -->

<!--     <div class="rightlnk"><a class="lgin" href="register.php">Signup</a></div> -->

	<?php } ?>

    <div id="inline1" style="display:none;">

      <div class="signinbox">

       <form name="login" id="login" method="post" action="" class="form_valid" enctype="multipart/form-data">



          <h1>Signin with your somadome account</h1>



           <?php

           if(($url1[2]=='register.php' || $url1[2]=='index.php' || $url1[2]=='') || $_REQUEST['msg']!='success' and $url1[2]!='register.php')

           echo $objModule->getMessage(); ?>

          <input type="text" name="Uemail" id="Uemail" class="required email" placeholder="Email">

          </p>

         <input type="password" name="Upass" class="required" id="Upass" placeholder="Password">

          <input type="checkbox" name="checkboxG1" id="checkboxG1" class="css-checkbox" />

          <label for="checkboxG1" class="css-label">Remember me</label>

          <a href="#inline2" class="frgps fancybox2" onclick="close_box();">Forgot your password?</a> <input type="submit" name="login" value="SIGN IN" class="btn">

          <div class="acc_box">Don't have a somadome account?<br />

            <a href="register.php">Click here</a> to create one</div>

            <input type="hidden" value="" name="book_val" id="book_val">
            <input type="hidden" value="" name="all_info_head" id="all_info_head">
            <input type="hidden" value="" name="booking_head" id="booking_head">
            <input type="hidden" value="" name="booking_type_head" id="booking_type_head">
            

        </form>

      </div>

      <!-------create acc popup--------->

      <!-------create acc popup end--------->

    </div>

	<!-- for got password pop-up -->

	  <div id="inline2"  style="display:none;">

      <div class="signinbox">

       <form name="forgot" id="forgot" method="post" action="" class="form_valid" enctype="multipart/form-data">

          <h1>Enter your Email id here.</h1>

          <input type="text" name="Uemail" id="Uemail" class="required email" placeholder="Email">

          </p><input type="submit" name="forgot_pw" value="SUBMIT" class="btn">

        </form>

      </div>

	</div>

  

  <!-- wrapper ends --> 

</div>

</div>