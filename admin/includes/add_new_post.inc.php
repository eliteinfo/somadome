<?php
if ($_POST['btnSubmit'] != '')
{
    $objData = new PCGData();
    $objData->setTableDetails("tbl_post", "id");
    $objData->setFieldValues("status", $_POST['cmbStatus']);
    $objData->setWhere("id = '" . $_GET['id'] . "' ");
    $objData->update();
    //echo "<pre>";print_r($objData->getSQL());die;
    unset($objData);
    echo "<script>window.location='list_post.php'</script>";
}
if ($_GET['id'] != '')
{
    $strSql = "SELECT tp.*,tc.name as maincat,ts.sname as subcname,tu.Username FROM 
                        tbl_post tp 
                        INNER JOIN tbl_users tu ON tu.Id = tp.uid
                        LEFT JOIN tbl_category tc ON tc.id = tp.category_id
                        LEFT JOIN tbl_subcategory ts on ts.sid = tp.sub_cat where tp.id = '" . $_GET['id'] . "'  GROUP BY tp.id ";
    $arrData = $objModule->getAll($strSql);
    $arrAtatch = $objModule->getAll("SELECT * FROM tbl_post_attach WHERE post_id = '" . $_GET['id'] . "' ");
}
$arrCategory = $objModule->getCategory();
$arrUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Status = '1' AND User_type = '1' ");
$arrTempSkills = $objModule->getAll("SELECT * FROM tbl_skills ORDER BY sk_id ASC");

foreach ($arrTempSkills as $intKey => $strValue)
{
    $arrSkill[$strValue['sk_id']] = $strValue['sk_name'];
}
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
                <h3 class="page-title"> <?php  echo ucfirst($arrData[0]['title']);?> </h3>
                <ul class="breadcrumb">
                    <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
                    <li> <a href="list_post.php">List Post</a> <span class="icon-angle-right"></span> </li>
                    <li>  <?php  echo ucfirst($arrData[0]['title']);?> </li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12"> 
                <!-- BEGIN VALIDATION STATES-->
                <div class="span3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="active"><a data-toggle="tab" href="#tab_1"><i class="icon-briefcase"></i>Post Info</a><span class="after"></span></li>
                <li><a href="post_messages.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-group"></i> Messages</a></li>
                <li><a href="bidding.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-leaf"></i> Bidding</a></li>
                <li><a href="attchmnt.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-plus"></i> Attachments</a></li>
                <li><a href="milestone.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-tags"></i> Milestone</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <div class="form-horizontal">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div  class="accordion-heading" style="padding: 2.5%;">
                                    <div class="row-fluid">
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label for="firstName" class="control-label">Category:</label>
                                                <div class="controls"> <span class="text"><?php echo $arrData[0]['maincat']; ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="lastName" class="control-label">Sub Category :</label>
                                                <div class="controls"> <span class="text"><?php echo $arrData[0]['subcname']; ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span--> 
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">Skills:</label>
                                                <div class="controls"> <span class="text">
                                                        <?php if ($arrData[0]['skills'] != ''): ?>
                                                            <?php
                                                            $arrS = array();
                                                            $arrS = @explode(',', $arrData[0]['skills']);
                                                            foreach ($arrS as $intS => $strS):
                                                                $strS1 .= ucfirst($arrSkill[$strS]) . ' ,';
                                                            endforeach;
                                                            echo trim($strS1, ',');
                                                        endif;
                                                        ?>
                                                    </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">End Date:</label>
                                                <div class="controls"> <span class="text bold"><?php echo date("d M Y", strtotime($arrData[0]['end_date_time'])); ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span--> 
                                    </div>
                                   <?php /* ?>
                                    <div class="row-fluid">
                                        <div class="span12 ">
                                            <div class="control-group">
                                                <label class="control-label">Attachments : </label>
                                                <div class="controls">
                                                    <span class="text">
                                                        <?php if (!empty($arrAtatch)): ?>
                                                            <?php foreach ($arrAtatch as $intKey => $strValue): ?>
                                                                <?php if (file_exists("../upload/attachment/".$strValue['post_id']."/" . $strValue['filename']) && $strValue['filename'] != ''): ?>
                                                        <a target="_blank" href="<?php echo $objModule->SITEURL; ?>upload/attachment/<?php echo $strValue['post_id']."/".$strValue['filename']; ?>">Attachment <?php echo ($intKey + 1); ?> </a>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </span> 
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <!--/span--> 
                                    </div><?php */ ?>
                                    <div class="row-fluid">
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">Price:</label>
                                                <div class="controls"> <span class="text">$ <?php echo $arrData[0]['price']; ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Create Date:</label>
                                                <div class="controls"> <span class="text"><?php echo date("d M Y", strtotime($arrData[0]['start_date_time'])); ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span--> 
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">User :</label>
                                                <div class="controls"> <span class="text"><?php echo $arrData[0]['Username']; ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <!--/span--> 
                                    </div>
                                     <div class="row-fluid">
                                        <div class="span12 ">
                                            <div class="control-group">
                                                <label class="control-label">Description:</label>
                                                <div class="controls"> <span class="text bold"><?php echo $arrData[0]['description']; ?></span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <!--/span--> 
                                    </div>
                                    <div class="form-actions">
                                        <form name="frmStaus" method="post" action="">
                                            <select name="cmbStatus">
                                                <option value="1" <?php if ($arrData[0]['status'] == 1): echo 'selected';
                                                        endif; ?>>Approve</option>
                                                <option value="0" <?php if ($arrData[0]['status'] == 0): echo 'selected';
                                                        endif; ?>>Denied</option>
                                            </select> 
                                            <input class="btn blue" name="btnSubmit" type="submit" value="Save" />
                                        </form>


                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>






                <!-- END VALIDATION STATES--> 
            </div>
        </div>
        <!-- END PAGE CONTENT--> 
    </div>
    <!-- END PAGE CONTAINER--> 
</div>