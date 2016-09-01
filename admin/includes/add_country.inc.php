<?php
$strAction = ($_GET['id'] != '') ? 'E' : 'A';

//$arrCountry = $objData->getAll("SELECT ctr_id,ctr_name FROM countries WHERE ctr_status = '1'");

if (isset($_POST['submit'])) 
{
    $strCond    =   "";
    //$arrShiping =   $_POST['shipping'];
    if($strAction=='E')
    {
        $strCond = " AND Id != '".$_REQUEST['hdnId']."'";
    }
    $arrExist  = $objData->getAll("tbl_country",array("*"),"Name = '".$_REQUEST['name']."' ".$strCond."");
    $intToatal  = $objData->intTotalRows;
	
	
	
    if($intToatal==0)
    {
	
		
		
		//exit;
        $objData->setTableDetails("tbl_country", "Id");
        $objData->setFieldValues("Name", trim($_REQUEST['name']));
		$objData->setFieldValues("curr_code", trim($_REQUEST['curr_code']));
      
        if($strAction=='E'):
         
            $objData->setWhere("Id = '".$_REQUEST['hdnId']."'");
            $objData->update();
            $objModule->setMessage("Country Update Sucessfully","success");
        else:
            $objData->insert();
            $objModule->setMessage("Country Added Sucessfully","success");
        endif;
        
        
        $objModule->redirect("./list_country.php");
		
    }
    else
    {
        $objModule->setMessage("Country already exist","error");
    }
}
if($strAction=="E"):
    $arrEditData    =   $objData->getAll("SELECT * FROM tbl_country WHERE Id = '".$_REQUEST['id']."'");
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
                    Country                    
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="list_country.php">List Country</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>Add Country</li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        
        
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="btn-group" style="margin-bottom:10px; float:right">
                    <a href="list_country.php"><button id="sample_editable_1_new" class="btn green">
                    List Country
                    </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>Country</div>
                        
                    </div>
                    <div class="portlet-body form">
                        <form method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
                         
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                           
                          
                             <div class="control-group" >
                                <label class="control-label">Name<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="name" class="span6 required" value="<?php echo $arrEditData[0]['Name']; ?>"/>
                                </div>                               
                            </div>
                            <div class="control-group" >
                                <label class="control-label">currency Code<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="curr_code" class="span6 required" value="<?php echo $arrEditData[0]['curr_code']; ?>"/>
                                </div>                               
                            </div>
                           
                         
                                        <input type="hidden" name="hdnId" id="hdnId"  value="<?php echo $_REQUEST['id'];?>" />
                                        <div class="form-actions">
                                            <input type="submit" name="submit" class="btn blue" value="<?php if ($strAction == 'E'): echo 'Update Country';else: echo 'Add Country';endif; ?>">
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