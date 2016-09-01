<?php
if ($_POST['btnSubmit'] != '')
{
    $strMessage = '';
    $strEndate = date("Y:m:d H:i:s", strtotime($_POST['end_date']));
    $objData = new PCGData();
    $objData->setTableDetails("tbl_post", "id");
    $objData->setFieldValues("title", $_POST['title']);
    $objData->setFieldValues("uid", $_POST['cmbUser']);
    $objData->setFieldValues("category_id", $_POST['cmbCategory']);
    $objData->setFieldValues("sub_cat", $_POST['cmbSubCategory']);
    $objData->setFieldValues("start_date_time", date("Y:m:d H:i:s"));
    $objData->setFieldValues("end_date_time", $strEndate);
    $objData->setFieldValues("description", $_POST['description']);
    $objData->setFieldValues("created_date", date("Y:m:d H:i:s"));
    $objData->setFieldValues("zipcode", $Zipcode);
    $objData->setFieldValues("price", $_POST['price']);
    if (!empty($_POST['cmbSkills']))
    {
        $strSkill = @implode(',', $_POST['cmbSkills']);
        $objData->setFieldValues("skills", $strSkill);
    }
    $objData->insert();
    $intPostId = $objData->intLastInsertedId;
    unset($objData);
	if(!file_exists('./upload/attachment/'.$intPostId)) {
			mkdir('./upload/attachment/'.$intPostId, 0755, true);
	}
	if(!empty($_FILES['files']['name']))
	{
		foreach($_FILES['files']['name'] as $intKey => $strValue)
		{
			$strEx = pathinfo($_FILES['files']['name'][$intKey], PATHINFO_EXTENSION);
			//$strFilename = uniqid() . '.' . $strEx;
			$strFilename    =   $_FILES['files']['name'][$intKey];
            move_uploaded_file($_FILES['files']['tmp_name'][$intKey], "./upload/attachment/".$intPostId."/" . $strFilename);
            $objData = new PCGData();
			$objData->setTableDetails("tbl_post_attach", "att_id");
			$objData->setFieldValues("post_id", $intPostId);
            $objData->setFieldValues("filename", $strFilename);
            $objData->insert(); 	
			echo "<pre>"; print_r($objData->getSQL());die;		
		}		
	}	
    echo "<script>window.location='list_post.php'</script>";
}
if ($_GET['id'] != '')
{
    $sql_data = "select * from tbl_post where id='" . $_GET['id'] . "'";
    $db_data = $objModule->getAll($sql_data);
}
$arrCategory = $objModule->getCategory();
$arrUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Status = '1' AND User_type = '1' ");
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
                    Post                    
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="list_post.php">List Post</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li> Post</li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="btn-group" style="margin-bottom:10px; float:right">
                    <a href="list_post.php"><button id="sample_editable_1_new" class="btn green">
                            List Post
                        </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>Post</div>
                    </div>
                    <div class="portlet-body form">
                        <?php echo $objModule->getMessage(); ?>
                        <form method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Name:<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" class="span6 required"  name="title"  value="<?php echo $arrEditData[0]['title']; ?>"/>
                                </div>                               
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Description<span class="required">*</span></label>
                                <div class="controls">
                                    <textarea name="description"></textarea>
                                </div>                               
                            </div>
                            <div class="control-group" >
                                <label class="control-label">User<span class="required">*</span></label>
                                <div class="controls">
                                    <select name="cmbUser" id="cmbUser" class="required">
                                        <option value="">-Select-</option>
                                        <?php foreach ($arrUser as $intKey => $strValue): ?>
                                            <option value="<?php echo $strValue['Id']; ?>"><?php echo $strValue['Username']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Category<span class="required">*</span></label>
                                <div class="controls">
                                    <select name="cmbCategory" id="cmbCategory" class="required" onchange="getSubcat(this.value, '');">
                                        <option value="">-Select the Catagory of Assignment-</option>
                                        <?php foreach ($arrCategory as $intKey => $strValue): ?>
                                            <option value="<?php echo $strValue['id']; ?>"><?php echo $strValue['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Sub Catgory<span class="required">*</span></label>
                                <div class="controls" id="subCat">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Skills<span class="required">*</span></label>
                                <div class="controls">
                                    <select name="cmbSkills[]" multiple=""  id="cmbSkills" class="required">
                                        <option value="">-Request specific skills or groups (optional)-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price<span class="required">*</span></label>
                                <div class="controls" >
                                    <input type="text" value="" name="price" class="required"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">End date<span class="required">*</span></label>
                                <div class="controls" >
                                    <input type="text" value="" id="end_date" name="end_date" class="required"/>
                                </div>
                            </div>
							
                            <div id="filegroup">
                            	 <label class="control-label">Attachment<span class="required">*</span></label>
                                    <div class="files">
                                        <input type="file" name="files[]" /> <a href="javascript:;" onclick="addFile();" class="add-more">Add</a>
                                    </div>
                                </div>
                            <br />
                            <div class="form-actions">
                                <input type="submit" name="btnSubmit" class="btn blue" value="<?php if ($strAction == 'E'): echo 'Update Post';
                                        else: echo 'Add Post';
                                        endif; ?>">
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
<script type="text/javascript">
    function getSubcat(intCat, intSelect)
    {
        jQuery.ajax({
            url: '../ajax.php',
            data: {intSelect: intSelect, intCat: intCat, CMD: "GET_SUBCATEGORY"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                var arrSk = data.split('~~~~');
                jQuery("#subCat").html(arrSk[0]);
                jQuery("#cmbSkills").html(arrSk[1]);
            }
        });
    }
    function addFile()
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        if (intCnt == 10 || intCnt > 10)
        {
            alert("Maximum 10 files allowed");
            return false;
        }
        jQuery.ajax({
            url: 'ajax.php',
            data: {CMD: "ADD_FILE"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                jQuery("#filegroup").append(data);
                jQuery("#hdnFileCnt").val(intCnt + 1);
            }
        });
    }
    function removeFile(strObj)
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        jQuery(strObj).parent("div.files").remove();
        jQuery("#hdnFileCnt").val(intCnt - 1);
    }
    jQuery(function () {
        jQuery("#datepicker").datepicker({
            minDate: 1
        });
    });
</script> 