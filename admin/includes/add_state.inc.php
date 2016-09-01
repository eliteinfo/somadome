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
    $arrExist  = $objData->getAll("tbl_state",array("*"),"Name = '".$_REQUEST['state']."' ".$strCond."");
    $intToatal  = $objData->intTotalRows;
	
	
	
    if($intToatal==0)
    {
	
		
		
		//exit;
        $objData->setTableDetails("tbl_state", "Id");
		$objData->setFieldValues("Cid", $_REQUEST['cntry']);
        $objData->setFieldValues("Name", trim($_REQUEST['state']));
      
        if($strAction=='E'):
         
            $objData->setWhere("Id = '".$_REQUEST['hdnId']."'");
            $objData->update();
            $objModule->setMessage("State Update Sucessfully","success");
        else:
           
            $objData->insert();
         
            $objModule->setMessage("State Added Sucessfully","success");
        endif;
        
        
        $objModule->redirect("./list_state.php");
		
    }
    else
    {
        $objModule->setMessage("State already exist","error");
    }
}
if($strAction=="E"):
    $arrEditData    =   $objData->getAll("SELECT * FROM tbl_state WHERE Id = '".$_REQUEST['id']."'");
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
                    State                    
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="list_state.php">List State</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>Add State</li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        
        
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="btn-group" style="margin-bottom:10px; float:right">
                    <a href="list_state.php"><button id="sample_editable_1_new" class="btn green">
                    List State
                    </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>State</div>
                        
                    </div>
                  
                    <div class="portlet-body form">
                    
                        <form method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
                       
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                         <div class="control-group" id="banner_link">
                                <label class="control-label">Country<span class="required">*</span></label>
                                <div class="controls">
                                	<?php
								$data    =   $objData->getAll("SELECT * FROM tbl_country");
								?>
 									<select name="cntry" id="cntry" class="span6 required">
                                   		 <option value="" selected="selected">Select Country</option>
                                   					<?php 
                                                           for($i=0;$i<count($data);$i++)
                                                           { ?>
                                                           <option <?php if($arrEditData[0]['Cid'] == $data[$i]['Id']){ ?> selected="selected"<?php } ?> value="<?php echo $data[$i]['Id']; ?>"><?php echo $data[$i]['Name'];?></option> 

                                             		<?php } ?>

                                </select>
                                </div>                               
                            </div>           
                         
                           <div class="control-group" >
                                <label class="control-label">State<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" class="span6 required"  name="state" id="state" value="<?php echo $arrEditData[0]['Name']; ?>"/>
                                </div>                               
                            </div>
                           
                           <input type="hidden" name="hdnId" id="hdnId"  value="<?php echo $_REQUEST['id'];?>" />
                                        <div class="form-actions">
                                            <input type="submit" name="submit" class="btn blue" value="<?php if ($strAction == 'E'): echo 'Update State';else: echo 'Add State';endif; ?>">
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

	if(document.form1.cntry.value =='Select Country')
	{

		alert('Please select Country Name');

		document.form1.cntry.focus();

		return false;

	}
	else if(document.form1.state.value == '')
	{
		alert('Please insert State Name');

		document.form1.state.focus();

		return false;
		
	}
	return true;

}

</script>