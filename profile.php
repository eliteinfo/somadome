<?php include('includes/header.inc.php');
if($_SESSION['Uid']==''){
	$objModule->redirect("register.php");
}
function getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity){

    $address = str_replace(" ", "+", $Uaddress);
	$Ucity = str_replace(" ", "%20", $Ucity);
	$Ucountry = str_replace(" ", "%20", $Ucountry);
	//echo "http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($Uzipcode).",$Ucountry&sensor=false&region=$region";
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address,".urlencode($Uzipcode).",$Ucountry&sensor=false&region=$region");
    $json = json_decode($json);
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	//echo $lat.','.$long;exit;
    return $lat.','.$long;
}



if(isset($_POST['update']))
{    

	//echo"<pre>";print_r($_POST);//exit;
	$user_email=$objData->getAll("select * from soma_users where Uemail = '".$_REQUEST['Uemail']."'");
	
	$country=$objData->getAll("select * from tbl_country where ctr_id = '".$_REQUEST['Ucountry']."'");
	$User_hosts =$_REQUEST['User_hosts'];
	$User_corporates=$_REQUEST['User_corporates'];
	$Uaddress =$_REQUEST['Uaddress'];
	$Ucountry =$country[0]['ctr_name'];
	$Uzipcode =$_REQUEST['Uzipcode'];
	$Ucity =$_REQUEST['Ucity'];
	$latlong = getLnt($Uaddress,$Ucountry,$Uzipcode,$Ucity);
	$latlngs=explode(',' ,$latlong);
	$lat =  $latlngs[0];
	$lng = $latlngs[1];
	//$lat='23.0244158';
	//$lng = '72.664566';
	if($lat!="" AND $lng!=""){
	$objData->getAll("delete FROM soma_user_customer WHERE Uid='".$_SESSION['Uid']."'");
	foreach($User_hosts as $datas){
		$objData->getAll("insert into soma_user_customer (Uid,Cid) values ('".$_SESSION['Uid']."','".$datas."')");
	}
		foreach($User_corporates as $datas){
			$objData->getAll("insert into soma_user_customer (Uid,Cid) values ('".$_SESSION['Uid']."','".$datas."')");
		}
 	$filename = $_FILES['Upic']['name'];
        if($filename != '')
        {
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','uploads/user_profile',$_FILES['Upic']['name']);
			move_uploaded_file($_FILES['Upic']['tmp_name'],"uploads/user_profile/".$strFile);
		}else{
			$strFile = $_REQUEST['hdnImage'];
		}
	
		$objData->setTableDetails("soma_users", "Uid");
		$objData->setFieldValues("Fname", $_REQUEST['Fname']);
		$objData->setFieldValues("Lname", $_REQUEST['Lname']);
        $objData->setFieldValues("Uemail", $_REQUEST['Uemail']);
		if($_REQUEST['Upass']!=''){
			$objData->setFieldValues("Upass", md5($_REQUEST['Upass']));
		}
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
		$objData->setWhere("Uid = '".$_SESSION['Uid']."'");
		$objData->update();
		$objModule->setMessage("Updated successfully.","success");
		$objModule->redirect("profile.php");
	}else{
		$objModule->setMessage("Please enter valid address.","error");
		$objModule->redirect("profile.php");
	}
	
		
}

$db_member = $objData->getAll("select * from soma_users where Uid = '".$_SESSION['Uid']."'");
?>
<!--- header ends -->
<script src='js/jquery.form.js'></script>
<!-----------profil start------------>
<div class="profile_cont">
<div class="wrapper">

<div class="profileleft_div">
<div class="profleft">
<a href="javascript:void(0);" class="profedit"> </a>
<form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
Upload your image <input type="file" name="photoimg" id="photoimg" />
</form>

<div class="prof_img">
<div id="preview"><a href="javascript:void(0);"><img src="lib/timthumb.php?src=uploads/user_profile/<?php echo $db_member[0]['Upic']; ?>&h=195&w=195" /></a></div>
<h1><?php echo $db_member[0]['Fname']." ".$db_member[0]['Lname']; ?></h1>
<a href="mailto:<?php echo $db_member[0]['Uemail']; ?>" class="profmail"><?php echo $db_member[0]['Uemail']; ?></a>
</div>
</div>
</div>

<div class="profright">
  <?php echo $objData->getMessage(); ?>
<form name="register" id="register" method="post" action="" class="form_valid" enctype="multipart/form-data">
 <span class="error_class"></span>
<ul class="profform">
<input type="hidden" name="hdnImage" value="<?php echo $db_member[0]['Upic']; ?>" id="htmlhdnImage">
<li><label>First Name*</label> <input type="text" name="Fname" class="required lettersonly" id="Fname" value="<?php echo $db_member[0]['Fname']; ?>" placeholder="First name"></li>
<li><label>Last Name*</label> <input type="text" name="Lname" class="required lettersonly" id="Lname" value="<?php echo $db_member[0]['Lname']; ?>" placeholder="Last Name"></li>
<li>
	<label>Hosts</label>
	<select class="" name="User_hosts[]" id="User_hosts" multiple="multiple">
			
			 <?php
			 $user_cus = $objData->getAll("SELECT * FROM soma_user_customer WHERE Uid='".$_SESSION['Uid']."'");
			 foreach($user_cus as $data){
				 $customers[]=$data['Cid'];
			 }
			 $db_customers = $objData->getAll("SELECT * FROM soma_customers WHERE Cstatus='1' and Cclub='1' OR Cclub='2' order by Cname ASC");
			 foreach($db_customers as $data){ ?>
			  <option value="<?php echo $data['Cid']; ?>" <?php if(in_array($data['Cid'],$customers)){ echo "selected='selected'";}?>><?php echo $data['Cname']; ?></option>
			 <?php } ?>
	</select>
</li>
	<?php /*?><li>
		<label>Corporates</label>
		<select class="" name="User_corporates[]" id="User_corporates" multiple="multiple">

			<?php
			$user_cus = $objData->getAll("SELECT * FROM soma_user_customer WHERE Uid='".$_SESSION['Uid']."'");
			foreach($user_cus as $data){
				$customers[]=$data['Cid'];
			}
			$db_customers = $objData->getAll("SELECT * FROM soma_customers WHERE Cstatus='1' and Cclub='2' order by Cname ASC");
			foreach($db_customers as $data){ ?>
				<option value="<?php echo $data['Cid']; ?>" <?php if(in_array($data['Cid'],$customers)){ echo "selected='selected'";}?>><?php echo $data['Cname']; ?></option>
			<?php } ?>
		</select>
	</li><?php */?>
<li><label>E-mail*</label> <input type="text" name="Uemail" readonly id="Uemail" class="required email" value="<?php echo $db_member[0]['Uemail']; ?>" placeholder="Email"></li>
<li><label>Password</label> <input type="password" name="Upass" class="" id="Upass" placeholder="Password"></li>
<li><label>Image</label> <input type="file" name="Upic" accept="image/*" class="" id="Upic">
<div class="uploaded_img" id="upload_bash_img">
<img src="lib/timthumb.php?src=uploads/user_profile/<?php echo $db_member[0]['Upic']; ?>&h=75&w=75" id="blah"></img>
</div></li>
<li><label>Address*</label> <textarea rows="3" name="Uaddress" class="required" value="<?php echo $db_member[0]['Uaddress']; ?>" id="Uaddress"><?php echo $db_member[0]['Uaddress']; ?></textarea></li>
<li><label>Country*</label>
			<select class="required" name="Ucountry" id="Ucountry" onchange="get_state(this.value)">
			<option value="">Select Country</option>
			 <?php
			 $db_country = $objData->getAll("SELECT * FROM tbl_country where ctr_code = 'US'");
			 foreach($db_country as $data){ ?>
			  <option value="<?php echo $data['ctr_id']; ?>" <?php if($data['ctr_id']==$db_member[0]['Ucountry']){ echo "selected='selected'";}?>><?php echo $data['ctr_name']; ?></option>
			 <?php } ?>
			</select>
</li>
<div id="user_state">
	<li>
	<label>State</label>
	<select class="required" name="Ustate" id="Ustate" onchange="get_city(this.value)">
				<option value="">Select State</option>
				 <?php
				 $db_state = $objData->getAll("SELECT * FROM tbl_state WHERE ctr_id='".$db_member[0]['Ucountry']."'");
				 foreach($db_state as $data){ ?>
				  <option value="<?php echo $data['state_id']; ?>" <?php if($data['state_id']==$db_member[0]['Ustate']){ echo "selected='selected'";}?>><?php echo $data['state_name']; ?></option>
				 <?php } ?>
				</select>
	</li>
</div>
<div id="user_city">
	<li>
	<label>City</label>
	<input type="text" name="Ucity" class="required" id="Ucity" value="<?php echo $db_member[0]['Ucity']; ?>" placeholder="City">
	</li>
</div>
<li><label>Zipcode*</label> <input type="text" name="Uzipcode" class="required" id="Uzipcode" value="<?php echo $db_member[0]['Uzipcode']; ?>" placeholder="Zip code"></li>

<li><input type="checkbox" <?php if($db_member[0]['U_newsletter'] == 1){?> checked="checked" <?php } ?> class="checkbox" id="is_subscribed" value="1" title="Sign Up for Newsletter" name="is_subscribed"> <span class="signup_span">Sign Up for Newsletter</span></li>

<li>
<div class="formbtn">
<input type="submit" name="update" value="Save Changes" class="btn">
</div>
</li>
</form>
</ul>
</div>
</div>
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
  



		
            $('#photoimg').live('change', function(){ 
			    $("#preview").html('');
			    $("#preview").html('<img src="images/loading1.gif" alt="Uploading...."/>');
				$("#imageform").ajaxForm({
						   
							//target: '#preview',
							success: function(data) {
								//alert(data);
								$('#preview').html('<a href=javascript:void(0);><img src=lib/timthumb.php?src=uploads/user_profile/'+data+'&h=195&w=195 /></a>')
							    $('#upload_bash_img').html('<a href=javascript:void(0);><img src=lib/timthumb.php?src=uploads/user_profile/'+data+'&h=75&w=75 /></a>');
								$('#htmlhdnImage').val(data);
							}
				}).submit();       
				//alert('test');     
				//window.location.href="http://www.aurosys.co/Somadome_New/profile.php";
			});
    


</script>

<!-----------profil end------------>

<?php include('includes/footer.inc.php');?>
