<?php include('includes/header.inc.php');?>
<?php
function getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity){
	
	//echo $Uaddress."</br>";
	
	//echo $Ucountry."</br>";
	

    $address = str_replace(" ", "+", $Uaddress);
	//echo $address."</br>";
	$Ucity = str_replace(" ", "%20", $Ucity);
	$address = $address.',+'.$Ucity;
	$Ucountry = str_replace(" ", "%20", $Ucountry);
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($Uzipcode).",$Ucountry&sensor=false&region=$region");
    $json = json_decode($json);
   
	//echo $json;
	
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	
	//echo $lat.','.$long; exit;
    return $lat.','.$long;
}
if(isset($_POST['submit']))
{    
	//echo"<pre>";print_r($_POST);
	$user_email=$objData->getAll("select * from soma_users where Uemail = '".$_REQUEST['Uemail']."'");
	if(count($user_email)=='0'){
	$country=$objData->getAll("select * from tbl_country where ctr_id = '".$_REQUEST['Ucountry']."'");
	$Uaddress =$_REQUEST['Uaddress'];
	$Ucountry =$country[0]['ctr_name'];
	$state=$objData->getAll("select * from tbl_state where state_id = '".$_REQUEST['Ustate']."'");
	$Ustate =$state[0]['state_name'];
	$Uzipcode =$_REQUEST['Uzipcode'];
	$Ucity =$_REQUEST['Ucity'];
	$latlong = getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity,$Ucity);
	$latlngs=explode(',' ,$latlong);
	$lat =  $latlngs[0];
	$lng = $latlngs[1];
	$Cdate=date("Y-m-d H:i:s");
	     
	if($lat!="" AND $lng!=""){
 	$filename = $_FILES['Upic']['name'];
        if($filename != '')
        {
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','uploads/user_profile',$_FILES['Upic']['name']);
			move_uploaded_file($_FILES['Upic']['tmp_name'],"uploads/user_profile/".$strFile);
		}else{
			$strFile = 'default_user.png';
		}
	
		$objData->setTableDetails("soma_users", "Uid");
		$objData->setFieldValues("Fname", $_REQUEST['Fname']);
		$objData->setFieldValues("Lname", $_REQUEST['Lname']);
        $objData->setFieldValues("Uemail", $_REQUEST['Uemail']);
		$objData->setFieldValues("Upass", md5($_REQUEST['Upass']));
		$objData->setFieldValues("Upic",$strFile);
		$objData->setFieldValues("Ucountry", $_REQUEST['Ucountry']);
		$objData->setFieldValues("Ustate", $_REQUEST['Ustate']);
		$objData->setFieldValues("Ucity", $_REQUEST['Ucity']);
		$objData->setFieldValues("Uzipcode", $_REQUEST['Uzipcode']);
		$objData->setFieldValues("Uaddress", $_REQUEST['Uaddress']);
		$objData->setFieldValues("Ulat", $lat);
		$objData->setFieldValues("Ulong",$lng);
		if($_REQUEST['is_subscribed'] == ''){
			$subscribe = '0';	
		}else{
			$subscribe = '1';
		}
		$objData->setFieldValues("U_newsletter",$subscribe);
		$objData->setFieldValues("Cdate", $Cdate);
		$objData->setFieldValues("Ustatus", "0");
		$objData->insert();
		$intLastId = $objData->intLastInsertedId;
		$pass = md5($_REQUEST['Upass']);
		$varify = substr($pass, 0, 5).'@'.$intLastId;
		
		
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
                            <h2>Dear, '.$_REQUEST['Fname'].',</h2>
                            <div class="textdark">
                               <p>Please <a href="' . $objData->SITEURL . 'verify_email.php?varifyCode=' . $varify . '&code=varify_email">Click here</a> for verify Email<p>
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
		mail($_REQUEST['Uemail'],'User Register - Somadome',$strMessage,$headers);

 

		$objModule->setMessage("Registered successfully. Please Check your Mail For Varified Account.","success");
		$objModule->redirect("index.php?msg=sucess");
	}else{
		$objModule->setMessage("Please enter valid address.","error");
		$objModule->redirect("register.php");
	}
	}
	else{
		$objModule->setMessage("Email already exists.","error");
		$objModule->redirect("register.php");
	}
		
}
?>
<!--- header ends -->

<!-----------profil start------------>
<div class="profile_cont">
<div class="wrapper">
<!--<div class="profleft">
<a href="#" class="profedit"> </a>
<div class="prof_img">
<a href="#"><img src="images/profilepic.jpg" />
<h1>Stephanie</h1></a>
<a href="mailto:stephaniepronk@gmail.com" class="profmail">stephaniepronk@gmail.com</a>
</div>
</div>-->

<div class="center_form">
  <?php echo $objData->getMessage(); ?>
<form name="register" id="register" method="post" action="" class="form_valid" enctype="multipart/form-data">
 <span class="error_class"></span>
<ul class="profform">

<li><label>First Name*</label> <input type="text" name="Fname" class="required lettersonly" id="Fname" placeholder="First name"></li>
<li><label>Last Name*</label> <input type="text" name="Lname" class="required lettersonly" id="Lname" placeholder="Last Name"></li>
<li><label>E-mail*</label> <input type="text" name="Uemail" id="Uemail" class="required email" placeholder="Email"></li>
<li><label>Password*</label> <input type="password" name="Upass" class="required pwdcheck" id="password1" placeholder="Password">
<span class="registrationFormAlert" id="divPasswordValidationResult"></span></li>
<li><label>Confirm Password*</label> <input type="password" name="Ucpass" class="required pass_confirm" id="password2" placeholder="CPassword" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" >
<span id="validate-status"></span></li>
<li><label>Image</label> <input type="file" name="Upic" accept="image/*" class="" id="Upic"><div class="uploaded_img"><img id="blah" src="" alt=""></img></div></li>
<li><label>Address*</label> <textarea rows="3" name="Uaddress" class="required" id="Uaddress"></textarea></li>
<li><label>Country*</label>
			<select class="required" name="Ucountry" id="Ucountry" onchange="get_state(this.value)">
			<option value="">Select Country</option>
			 <?php
			 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
			 //echo"<pre>";print_r($db_country);
			 foreach($db_country as $data){ ?>
			  <option value="<?php echo $data['ctr_id']; ?>"><?php echo $data['ctr_name']; ?></option>
			 <?php } ?>
			</select>
</li>
<div id="user_state"></div>
<div id="user_city"></div>
<li><label>Zipcode*</label> <input type="text" name="Uzipcode" class="required" id="Uzipcode" placeholder="Zip code"></li>
<li><input type="checkbox" class="checkbox" id="is_subscribed" value="1" title="Sign Up for Newsletter" name="is_subscribed">
<span class="signup_span">Please Sign me up for the Somadome Wellness e-zine</span>
</li>

<li>
<div class="formbtn">
<a href="#" class="canbtn btn">cancel</a>
<input type="submit" name="submit" value="Register" class="btn">
</div>
</li>
</form>
</ul>
</div>
</div>
</div>

<!-----------profil end------------>



<?php include('includes/footer.inc.php');?>
<script>
function get_state(ctr_id)
{ 
	$.ajax({
			url: 'ajax.php',
			data: {unit_country:"unit_country",ctr_id:ctr_id},
			type: "POST",
			success: function(data)
			{ 
				$('#user_state').html(data);
                
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
				$('#user_city').html(data);
                
			}
		});
}
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#Upic").change(function(){
    readURL(this);
});

$(document).ready(function() {
	  $("#password2").keyup(validate);
	});


	function validate() {
	  var password1 = $("#password1").val();
	  var password2 = $("#password2").val();

	    
	 
	    if(password1 == password2) {
	       $("#validate-status").text("Password Matching").css('color', 'green');        
	    }
	    else {
	        $("#validate-status").text("Password Not Matching").css('color', 'red');  
	    }
	    
	}

	function validatePassword() {
	    var password = $("#password1").val();
	    

	    if (password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
	        $("#divPasswordValidationResult").html("Valid Password").css('color', 'green');
	    else
	         $("#divPasswordValidationResult").html("Minimum 8 Characters, 1 capital, 1 Small, 1 Number").css('color', 'red');
	   
	}

	$(document).ready(function () {
	   $("#password1").keyup(validatePassword);
	});	
</script>
