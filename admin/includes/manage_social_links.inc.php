<?php
error_reporting(0);
$strAction = ($_GET['id'] != '') ? 'E' : 'A';
if(isset($_POST['update']))
{
	 
		$objData->setTableDetails("social_links", "Id");
		$objData->setFieldValues("Link", $_REQUEST['link_name']);
        //$objData->setFieldValues("Name", trim($_REQUEST['state']));
      
        if($strAction=='E')
		{
         
            $objData->setWhere("Id = '".$_GET['id']."'");
            $objData->update();
            $objModule->setMessage("social link Update Sucessfully","success");
		}
        
        
        $objModule->redirect("./social_links.php");
	
	
}
$social = "select * from social_links where Id='".$_GET['id']."'";
$db_social = $objData->getAll($social);
 
?>
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
      <div class="color-panel hidden-phone">
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
            <span class="color-mode-label">Fixed Header</span> </label>
        </div>
      </div>
      <h3 class="page-title">Manage Social Link</h3>
      <ul class="breadcrumb">
        <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <i class="icon-angle-right"></i> </li>
        <li>Manage Social Link</li>
      </ul>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <div class="tabbable tabbable-custom boxless">
        <ul class="nav nav-tabs">
          <!--<li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>-->
          <li class="active"><a href="#tab_5" data-toggle="tab">Edit</a></li>
              
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_5">
            <div class="portlet box blue">
              <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Manage Social Link</div>
                <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
              </div>
              <div class="portlet-body form">
                  <form  method="post" id="form_sample_2" name="form_sample_3" action="" class="form-horizontal" enctype="multipart/form-data"  onsubmit="return validateFormOnSubmit(this)" >
                    <div class="alert alert-error hide">
                      <button class="close" data-dismiss="alert"></button>
                      You have some form errors. Please check below. </div>
                      
                      
                      <h3 style="color:#C33">Social Link Detail</h3>
                  
                    <div class="control-group">
                      <label class="control-label">Name</label>
                      <div class="controls">
                        <input type="text" id="social_name" name="social_name" value="<?php echo $db_social[0]['Name']; ?>" readonly="readonly" class="span6 m-wrap"  />
                      </div>
                    </div>
                    
                      <div class="control-group">
                      <label class="control-label">Link<span class="required">*</span></label>
                      <div class="controls">
                        <input type="text" id="link_name" name="link_name" value="<?php echo $db_social[0]['Link']; ?>" class="span6 m-wrap required"  />
                      </div>
                    </div>
                      
                    <div class="form-actions">
                     
                      <input type="submit" name="update" class="btn blue" value="Save">
                     <!-- <a href="manage_product.php?del=<?php echo $_GET['id']; ?>" class="btn red">Delete This Menu Item</a>-->
                      
                    </div>
                  </form>
                </div>
              </div>
            </div>
        
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.size
{
	height:60px;
}
.details { display:none; }
</style>

 
