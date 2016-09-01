<?php
if(isset($_POST['login']))
{
    $strEmail       = trim($_POST['email']);
    $strPassword    = md5($_POST['password']);
    $strSql  = "SELECT * FROM soma_admin WHERE email = '".$strEmail."' AND apass  = '".$strPassword."'";
    $arrData = $objData->getAll($strSql);
    
    if(count($arrData) == 0)
    {
        $objData->setMessage('Invalid email or Passsword','error');
        $objData->redirect('login.php');
    }
    else
    {
        if(count($arrData)>0)
        { 
            $_SESSION['admin_id'] = $arrData[0]['Id'];
			$_SESSION['Somadome_site'] = 'Somadome';
	}
        $objData->redirect('dashboard.php');
    }
}
?>
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" name="Admin_Login_Form"  method="post">
      <h3 class="form-title">Login to admin account</h3>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Enter Email and passowrd.</span>
      </div>
     
      <?php echo $objData->getMessage();?>
      
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" onkeypress="submit_form(event)"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password" onkeypress="submit_form(event)"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
          <button type="submit" style="margin-right:110px;" name="login" id="login" class="btn green btn-block" >
        Login <i class="m-icon-swapright m-icon-white"></i><?php // onclick="return valid();" ?>
        </button>  
       <a href="forget_password.php">Forgot Password?</a>
      </div>
    </form>
    <!-- END LOGIN FORM -->        
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="form-vertical forget-form" >
      <h3 class="">Forget Password ?</h3>
      <p>Enter your e-mail address below to reset your password.</p>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button type="button" id="back-btn" class="btn">
        <i class="m-icon-swapleft"></i> Back
        </button>
        <button type="submit" class="btn green pull-right">
        Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="form-vertical register-form" >
      <h3 class="">Sign Up</h3>
      <p>Enter your account details below:</p>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-ok"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
          <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>  
          <div id="register_tnc_error"></div>
        </div>
      </div>
      <div class="form-actions">
        <button id="register-back-btn" type="button" class="btn">
        <i class="m-icon-swapleft"></i>  Back
        </button>
        <button type="submit" id="register-submit-btn" class="btn green pull-right">
        Sign Up <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END REGISTRATION FORM -->
  </div>
<script language="javascript">
function valid()
{
	if(document.Admin_Login_Form.Username.value == '')
	{
		alert('Please Enter Username');
		document.Admin_Login_Form.Username.focus();
		return false;
	}
	if(document.Admin_Login_Form.Password.value == '')
	{
		alert('Please Enter Password');
		document.Admin_Login_Form.Password.focus();
		return false;
	}
	return true;
}
</script>
 <script>
  function submit_form(event)
  {
   if(event.keyCode==13){
          jQuery("#login").trigger('click');
        }
  }
  </script>