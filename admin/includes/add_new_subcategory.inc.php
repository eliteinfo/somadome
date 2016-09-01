<?php
if($_GET['did'] != '')
{
	$objModule->getAll("delete from tbl_subcategory where sid = '".$_GET['did']."'");
	$objModule->redirect('list_subcategory.php');
		
}
if($_POST['btnSubmit']!='')
{
    $strCond = '';
    if($_GET['id']!=''):
        $strCond ="WHERE sid != '".$_GET['id']."' ";
    endif;
    $arrCheck = $objModule->getAll("SELECT * FROM tbl_subcategory WHERE sname = '".$_REQUEST['catname']."' AND cat_id = '".$_REQUEST['cmbCategory']."' ".$strCond." ");
    if(empty($arrCheck))
    {
    $objData =  new PCGData();
    $objData->setTableDetails("tbl_subcategory", "sid");
    $objData->setFieldValues("sname", $_REQUEST['catname']);
    $objData->setFieldValues("cat_id", $_REQUEST['cmbCategory']);
    if($_GET['id']!=''):
        $objData->setWhere("sid = '".$_GET['id']."' ");
        $objData->update();
    else:    
        $objData->insert();
    endif;
    unset($objData);
    $objModule->setMessage("Category Added Sucessfully","success");
    $objModule->redirect("./list_subcategory.php");
    }
    else
    {
        $objModule->setMessage("Category Already exist","error");
    }
    
}
$sql_category = "select * from tbl_subcategory where sid = '".$_GET['id']."'";
$db_category = $objData->getAll($sql_category);
$arrCategory = $objModule->getCategory();
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
        <!-- BEGIN STYLE CUSTOMIZER -->
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
              <li class="color-grey" data-style="grey"></li>
              <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label> <span>Layout</span>
              <select class="layout-option m-wrap small">
                <option value="fluid" selected>Fluid</option>
                <option value="boxed">Boxed</option>
              </select>
            </label>
            <label> <span>Header</span>
              <select class="header-option m-wrap small">
                <option value="fixed" selected>Fixed</option>
                <option value="default">Default</option>
              </select>
            </label>
            <label> <span>Sidebar</span>
              <select class="sidebar-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
            <label> <span>Footer</span>
              <select class="footer-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
          </div>
        </div>
        <!-- END BEGIN STYLE CUSTOMIZER -->
        <h3 class="page-title"> Sub Category </h3>
        <ul class="breadcrumb">
          <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
          <li> <a href="list_subcategory.php">List Sub Category</a><span class="icon-angle-right"></span> </li>
          <li>Sub Category</li>
        </ul>
      </div>
    </div>
    <!-- END PAGE HEADER--> 
    <!-- BEGIN PAGE CONTENT-->    
    <div class="row-fluid">
      <div class="span12"> 
        <div class="tabbable tabbable-custom boxless">
         <?php if($_GET['id']!='') { ?>
        <ul class="nav nav-tabs">         
          <li class="active"><a href="#tab_1" data-toggle="tab">Edit</a></li>
        </ul>
        <?php } ?>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="portlet box blue">
              <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>  <?php if($_GET['id']!='') { echo "Edit Sub Category"; } else { echo "Add Sub Category";}?></div>
                <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
              </div>
              <div class="portlet-body form">
            <form action="" method="post" id="form_sample_2" name="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
              <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert"></button>
                You have some form errors. Please check below. </div>
                
                <?php if($_GET['id']=='') { ?>
              <h3 style="color:#C33">Add Sub Category</h3>
       		    <?php } ?>
                 <?php if($_GET['id']!='') { ?>
                 <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
              <h3 style="color:#C33">Edit Sub Category</h3>
       		    <?php } ?>
                
                  <?php echo $objModule->getMessage();?>
              <div class="control-group">
                <label class="control-label">Parent Category<span class="required">*</span></label>
                <div class="controls">
                    <select name="cmbCategory" class="span6 m-wrap required" data-required="1">
                        <?php foreach($arrCategory as $intKey=>$strValue):?>
                                <option <?php if($db_category[0]['cat_id']==$strValue['id']): echo 'selected'; endif;?> value="<?php echo $strValue['id'];?>"><?php echo $strValue['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Name<span class="required">*</span></label>
                <div class="controls">
                  <input type="text" maxlength="50" name="catname" id="catname" data-required="1" value="<?php echo $db_category[0]['sname'];?>" 
                  class="span6 m-wrap required"/>
                </div>
              </div>
            
              <div class="form-actions">
                <input type="submit" name="btnSubmit" class="btn blue" value="Save">
                <?php if($_GET['id']!=''): ?>
                    <a href="add_new_subcategory.php?did=<?php echo $_GET['id']; ?>"   class="btn red" >Delete Sub Category</a>
                <?php endif;?>
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
<script>
function delete_order(id)
	{
		 var x=confirm('Do you want to delete this record?');
		 if(x)
		 {
			 return true;
			 //window.location.href = 'manage_order.php?ordid='+;
		 }
		 else
		 {
			 return false;
		 }
	}
</script> 
