<?php
//include('lib/module.php');
include('includes/header.inc.php');
$access = '';
if($_GET['action']=="reset")
    {
        $encrypt = mysqli_real_escape_string($connection,$_GET['encrypt']);
		//echo $encrypt;exit;
        $query = $objData->getAll("SELECT * FROM soma_users where md5(90*13+Uid)='".$_GET['encrypt']."'");
		
        if(count($query)>=1)
        {
			$access = "available";
        }
        else
        {
            
			$objModule->setMessage("Invalid key please try again.","error");
			$objModule->redirect("index.php");
        }
    }
if(isset($_REQUEST['ResetPwd'])){
	//echo"<pre>";print_r($_REQUEST);exit;
	if($_REQUEST['Upass'] == $_REQUEST['Ucpass']){	
		$password = md5($_REQUEST['Upass']);
		$sql=$objData->getAll("update soma_users set Upass='".$password."' where Uid='".$_REQUEST['pwd_id']."'");
		$objModule->setMessage("Your Password Change Successfully.","success");
		$objModule->redirect("index.php?msg=sucess");
	}else{
		$objModule->setMessage("Password and Confirm Password Must be Same.","error");	
	}
}
?>



<?php if($access == 'available'){ ?>
<div class="profile_cont">
<div class="wrapper">

<div class="profright">
  <?php echo $objData->getMessage(); ?>
<form name="conformpwd" id="conformpwd" method="post" action="" class="form_valid" enctype="multipart/form-data">
 <span class="error_class"></span>
<ul class="profform">
<li><label>Email</label> <?php echo $query[0]['Uemail']; ?></li>
<li><label>Password*</label> <input type="password" name="Upass" class="required pwdcheck" id="password1" placeholder="Password"></li>
<li><label>Confirm Password*</label> <input type="password" name="Ucpass" class="required pass_confirm" id="password2" placeholder="CPassword"></li>
<input type="hidden" name="pwd_id" value="<?php echo $query[0]['Uid']; ?>">
<div class="formbtn"><input type="submit" id="ResetPwd" name="ResetPwd" value="Reset Password" class="btn"></div>
</ul>
</form>
</div>
</div>
</div>
<script>


</script>
<?php }else{ ?>


<?php } ?>


<?php include('includes/footer.inc.php');?>