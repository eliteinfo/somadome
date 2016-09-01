<?php
/*if(isset($_POST['submit']))
{
	$page_url = strtolower(str_replace(" ","-",$_POST['page_name']));
	$objData->setTableDetails("contents",'id');
	$objData->setFieldValues("page_name",$_POST['page_name']);
	$objData->setFieldValues("detail",$_POST['detail']);
	$objData->setFieldValues("seo_title",$_POST['seo_title']);
	$objData->setFieldValues("seo_meta",$_POST['seo_meta']);
	$objData->setFieldValues("seo_keywords",$_POST['seo_keywords']);
	$objData->setFieldValues("page_url",$page_url);
	$objData->insert();
	$objData->redirect('list_content.php');	
}*/
if(isset($_POST['update']))
{	
//echo $_POST['detail']; exit; 
	$data = stripcslashes($_POST['detail']);
	//echo strlen($data); exit; 
	$page_url = strtolower(str_replace(" ","-",$_POST['page_name']));
	$objData->setTableDetails("contents",'id');
	$objData->setFieldValues("page_name",$_POST['page_name']);
	$objData->setFieldValues("detail",$data);
	$objData->setFieldValues("seo_title",$_POST['seo_title']);
	$objData->setFieldValues("seo_meta",$_POST['seo_meta']);
	$objData->setFieldValues("seo_keywords",$_POST['seo_keywords']);
	$objData->setFieldValues("page_url",$page_url);
	$objData->setWhere("id='".$_POST['page_id']."'");
	$objData->update();
	$objModule->redirect('list_content.php');
}
$cms_det = $objData->getAll("SELECT * FROM contents where id = '".$_GET['id']."'");
?>
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->   
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    Content                    
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="list_content.php">List Content</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>Content</li>
                    <div class="btn-group" style="margin-top:-7px; float:right">
                    <a href="list_content.php"><button id="sample_editable_1_new" class="btn green">
                    List Content
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
                        <div class="caption"><i class="icon-reorder"></i>Content</div>
                    </div>
                    <div class="portlet-body form">
                        <form  method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
							<input type="hidden" name="page_id" value="<?php echo $cms_det[0]['id']; ?>">
                            <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>You have some form errors. Please check below.
							</div>                            
                            <div class="control-group">
                                <label class="control-label">Page Name<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="page_name" value="<?php echo $cms_det[0]['page_name']; ?>" class="span6 m-wrap required"/>
                                </div>                               
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Description<span class="required">*</span></label>
                                <div class="controls">
                                    <textarea class="span12 ckeditor m-wrap" name="detail"  rows="6"><?php echo $cms_det[0]['detail']; ?></textarea>
                                </div>
                            </div>
                           <?php /*?> <div class="control-group">
                                <label class="control-label">Detail<span class="required">*</span></label>
                                <div class="controls">
                                	<script type="text/javascript" src="../admin/assets/plugins/ckeditor/ckeditor.js" ></script>    
									<textarea cols="80" id="detail" name="detail" rows="10" class="span6 m-wrap required"><?php echo $cms_det[0]['detail']; ?></textarea>
    									<script type="text/javascript">
							  				CKEDITOR.replace( 'detail' );
							   			</script>       
                                </div>                               
                            </div><?php */?>
                             <div class="control-group">
                                <label class="control-label">SEO Title<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="seo_title" value="<?php echo $cms_det[0]['seo_title']; ?>" class="span6 m-wrap required"/>
                                </div>                               
                            </div>
                            <div class="control-group">
                                <label class="control-label">SEO Meta<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="seo_meta" value="<?php echo $cms_det[0]['seo_meta']; ?>" class="span6 m-wrap required"/>
                                </div>                               
                            </div>
                             <div class="control-group">
                                <label class="control-label">SEO Keywords<span class="required">*</span></label>
                                <div class="controls">
                                	<input type="text" name="seo_keywords" value="<?php echo $cms_det[0]['seo_keywords']; ?>" class="span6 m-wrap required"/>
                                </div>                               
                            </div>
                                                    
                            <div class="form-actions">
	                            <?php if($_GET['id'] == '') { ?>
                                <input type="submit" name="submit" class="btn blue" value="Add">
                                <?php } else { ?>
                                <input type="submit" name="update" class="btn blue" value="Edit">
                                <?php } ?>
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