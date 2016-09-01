<?php
$user="select * from soma_admin where Id='".$_SESSION['admin_id']."'";
$user_data=$objData->getAll($user);
	if(isset($_REQUEST['submit'])&& ($_REQUEST['submit']!=''))
	{
		
		if($_REQUEST['password']!='')
		{
$update="update soma_admin set email='".$_REQUEST['email']."',apass='".md5($_REQUEST['password'])."' where Id=".$_SESSION['admin_id'];
		}else
		{
$update="update soma_admin set email='".$_REQUEST['email']."' where Id=".$_SESSION['admin_id'];
			
		}
		$objData->getAll($update);
		echo '<script>location.replace("profile.php");</script>';
	}
?>
<script language="JavaScript">
function testing(val,x){
maxlen = x;

}

function Minimum(obj,min){
 if (obj.value.length<min) alert('Description minimim characters '+min);
}
</script>

<div class="page-content">
	<div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>portlet Settings</h3>
            </div>
            <div class="modal-body">
               <p>Here will be a configuration form</p>
            </div>
         </div>
	
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<!--<div class="color-panel hidden-phone">
                    <div class="color-mode-icons icon-color"></div>
                    <div class="color-mode-icons icon-color-close"></div>
                    <div class="color-mode">                    
                        <p>THEME COLOR</p>                   
                        <ul class="inline">                    
                            <li class="color-black current color-default" data-style="default"></li>                    
                            <li class="color-blue" data-style="blue"></li>                   
                            <li class="color-brown" data-style="brown"></li>                    
                            <li class="color-purple" data-style="purple"></li>                    
                            <li class="color-white color-light" data-style="light"></li>                    
                        </ul>                    
                        <label class="hidden-phone">                    
                        <input type="checkbox" class="header" checked value="" />                    
                            <span class="color-mode-label">Fixed Header</span>                    
                        </label>                                        
                    </div>
				</div>-->
                <h3 class="page-title">User Profile</h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Profile</a>
                     </li>
                  </ul>
			</div>
		</div>
		<div class="row-fluid"><div class="span12"></div></div>
		<div class="row-fluid">
           <div class="span12">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption"><i class="icon-reorder"></i>Admin Profile</div>
                    <div class="tools"></div>
                 </div>
                 <div class="portlet-body form">
                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                        <div class="alert alert-error hide">
                            <button class="close" data-dismiss="alert"></button>You have some form errors. Please check below.
                        </div>
                       
						<div class="control-group">
                            <label class="control-label">Email<span class="required">*</span></label>
                            <div class="controls">
                            	<input type="text" class="m-wrap medium email required" name="email" id="email" value="<?php echo $user_data[0]['email'];?>" />
                          </div>
                        </div> 
                      
                         <div class="control-group">
                            <label class="control-label">Password</label>
                            <div class="controls">
                            	<input type="password" class="m-wrap medium" name="password" id="password" value="" />
                          </div>
                        </div>  
                                                   
                        <div class="form-actions">
                            <input type="submit" name="submit" class="btn blue" value="Update">
                        </div>
                    </form>                        
                 </div>
              </div>
           </div>
		</div>
		<div class="row-fluid"><div class="span12"></div></div>
	</div>

</div>