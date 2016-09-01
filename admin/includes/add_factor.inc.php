<?php
$strAction = ($_GET['id'] != '') ? 'E' : 'A';
if($_POST['btnSubmit']!='') 
{
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_factor","id");
    $objData->setFieldValues("perce",$_POST['txtPercen']);
    $objData->setWhere("id = '1'");
    $objData->update();
    unset($objData);
    $objModule->redirect("./add_factor.php");
}
$arrEdit    =   $objModule->getAll("SELECT * FROM tbl_factor WHERE id = '1'");
?>
<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button"></button>
            <h3>portlet Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here will be a configuration form</p>
        </div>
    </div>
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->   
        <div class="row-fluid">
            <div class="span12">
                 
                <h3 class="page-title">
                    Add Factor                   
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="javascript:;">Factor</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        
        
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>Factor</div>
                    </div>
                    <div class="portlet-body form">
                        <form method="post" name="form_sample_2" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                            <div class="control-group">
                                <label class="control-label">Percentage<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="txtPercen" value="<?php echo $arrEdit[0]['perce'];?>" class="required" /> 
                                </div>                               
                            </div>
                         
                        <div class="form-actions">
                            <input type="submit" name="btnSubmit" class="btn blue" value="Save" onclick="return valid();">
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