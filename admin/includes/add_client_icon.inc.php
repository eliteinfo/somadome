<?php
error_reporting(1);
$strAction = ($_GET['id'] != '') ? 'E' : 'A';
if (isset($_POST['btnSubmit']))
{   
	//if(!empty($_FILES['files']['name']))
		//{				
			foreach ($_FILES['files']['name'] as $intKey => $strVal)
			{	
				$strEx = pathinfo($_FILES['files']['name'][$intKey],PATHINFO_EXTENSION);
				$strFilename = uniqid().'.'.$strEx;
				move_uploaded_file($_FILES['files']['tmp_name'][$intKey],"../upload/icon/".$strFilename);				
				$objData->setTableDetails("tbl_client_icon","id");				
				$objData->setFieldValues("name",$_POST['username'][$intKey]);	
				$objData->setFieldValues("title",$_POST['icon_name'][$intKey]);								
				$objData->setFieldValues("image",$strFilename);
				$objData->setFieldValues("description",$_POST['detail'][$intKey]);				
				$objData->insert();					
				//echo ($objData->getSQL());
			}
				//echo "<br>";die;											
		//}    
    //unset($objData);
    $objModule->redirect("./list_client_icon.php");
}
if($strAction=="E"):
    $arrEditData = $objModule->getAll("SELECT * FROM tbl_client_icon where id = '".$_REQUEST['id']."' ");
endif;
?>
<div class="page-content">
<div class="container-fluid">
<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-title">
            Client Icon
        </h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="dashboard.php">Home</a>
                <span class="icon-angle-right"></span>
            </li>
            <li>
                <a href="list_client_icon.php">List Client Icon</a>
                <span class="icon-angle-right"></span>
            </li>
           
            <div class="btn-group" style="margin-top:-7px; float:right">
                <a href="list_client_icon.php"><button id="sample_editable_1_new" class="btn green">
                        List Client Icon
                    </button></a>
            </div>
        </ul>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Client Icon</div>
            </div>
            <div class="portlet-body form">
                <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="hdnId" value="<?= $arrEditData[0]['id']; ?>">
                    <input type="hidden" name="old_main_img" value="<?= $arrEditData[0]['image']; ?>">                    
                    
                    <?= $objModule->getMessage(); ?>
                    <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>You have some form errors. Please check below.
                    </div>
                    
                    <div class="control-group">
                <label class="control-label">Name<span class="required">*</span></label>
                <div class="controls">
                  <input type="text" maxlength="50" name="username[]" id="username" data-required="1" value="<?= $arrEditData[0]['name']; ?>" class="span6 m-wrap required"/>
                </div>
              </div>
                    
                    <div class="control-group">
                        <label class="control-label">Title<span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="icon_name[]" value="<?= $arrEditData[0]['title'];?>" class="span6 m-wrap required"/>
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                <label class="control-label">Description<span class="required">*</span></label>
                   <div class="controls">
                     <textarea class="span6 m-wrap required" name="detail[]"  rows="6"><?= $arrEditData[0]['description']; ?></textarea>
                      </div>
                   </div>
                   
                 <div class="control-group">
                	<label class="control-label">Image<span class="required">*</span></label>
                	<div class="files" id="div1">
                    <input type="file" name="files[]" id="files" onchange="checkFile(this)"/>
                    <a href="javascript:;" onclick="addFile();" class="add-more"></a> 
                                    
                 </div>
                 <?php // echo $arrEditData[0]['image']; ?>
              </div>  
                 
                   
                <!--<div class="control-group">
                <label class="control-label">User Profile<span class="required">*</span></label>
                <div class="files" id="div1">
                  <input type="file" name="image" id="image" />                 
                 </div>
              </div>-->
                    
                    <div class="form-actions">
                        <input type="submit" name="btnSubmit" class="btn blue" value="Submit">
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->
</div>