<?php
$strAction = ($_GET['id'] != '') ? 'E' : 'A';
if($_POST['btnSubmit']!='') 
{
    if($_POST['skills']!='')
    {
        if($_POST['cmbStatus']==1)
        {
            $arrSk = @explode(",",$_POST['skills']);
            foreach($arrSk as $intKey=>$strValue):
                if($strValue!='')
                {
                    $objData = new PCGData();
                    $objData->setTableDetails("tbl_skills", "sk_id");
                    $objData->setFieldValues("cat_id", $_REQUEST['hdnCatId']);
                    $objData->setFieldValues("sk_name",$strValue);
                    $objData->insert();
                    unset($objData);
                }
            endforeach;
        }
        $objData = new PCGData();
        $objData->setTableDetails("tmp_skills", "id");
        $objData->setFieldValues("status",$_POST['cmbStatus']);
        $objData->setWhere("id = '".$_GET['id']."' ");
        $objData->delete();
        unset($objData);
        $objModule->redirect("./list_suggest.php");
    }
}
if($strAction=="E"):
    $arrSkils    =   $objModule->getAll("SELECT ts.*,tc.name,tc.id as cat_id FROM tmp_skills ts LEFT JOIN tbl_category tc ON tc.id = ts.cat_id WHERE  ts.id = '".$_GET['id']."' GROUP BY ts.id ORDER BY ts.id DESC");
endif;    
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
                    Suggest Skills                    
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="list_suggest.php">List Suggest skills</a>
                        <span class="icon-angle-right"></span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        
        
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="btn-group" style="margin-bottom:10px; float:right">
                    <a href="list_suggest.php"><button id="sample_editable_1_new" class="btn green">
                    List Suggest skills
                    </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>Suggest Skills</div>
                    </div>
                    <div class="portlet-body form">
                        <form method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                             <div class="control-group" >
                                <label class="control-label">Category<span class="required">*</span></label>
                                <div class="controls">
                                    <span class="text"><?php echo $arrSkils[0]['name'];?></span>
                                </div>                               
                            </div>
                            <div class="control-group">
                                <label class="control-label">Skills<span class="required">*</span></label>
                                <div class="controls">
                                    <input name="skills" class="required" readonly="" value="<?php echo $arrSkils[0]['skills'];?>" />
                                </div>                               
                            </div>
                            <div class="control-group">
                                <label class="control-label">Status<span class="required">*</span></label>
                                <div class="controls">
                                    <select name="cmbStatus" class="required">
                                        <option value="">-Select-</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Denied</option>
                                    </select>    
                                </div>                               
                            </div>
                           
                         
                        <input type="hidden" name="hdnCatId" id="hdnId"  value="<?php echo $arrSkils[0]['cat_id'];?>" />
                        <div class="form-actions">
                            <input type="submit" name="btnSubmit" class="btn blue" value="Save">
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
<script language="javascript">
function valid()
{
	if(document.form1.Name.value == '')
	{
		alert('Please Insert Country Name');
		document.form1.Name.focus();
		return false;
	}
	return true;
}

</script>