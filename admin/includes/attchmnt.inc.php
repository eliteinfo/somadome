<?php
if ($_GET['id'] != '')
{
    $arrAtatch = $objModule->getAll("SELECT pa.*,p.title FROM tbl_post_attach as pa LEFT JOIN tbl_post as p ON p.id=pa.post_id WHERE pa.post_id = '" . $_GET['id'] . "' ");
    //$db_bidding1 = $objModule->getAll($bidding1);
    $count2 = count($arrAtatch);
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
            	
                <h3 class="page-title">  <?php echo ucfirst($arrAtatch[0]['title']); ?> </h3>
                <ul class="breadcrumb">
                    <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
                    <li> <a href="list_post.php">List Post</a> <span class="icon-angle-right"></span> </li>
                    <li> <?php echo ucfirst($arrAtatch[0]['title']); ?></li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12"> 
                <!-- BEGIN VALIDATION STATES-->
<?php /* ?>                <div class="btn-group" style="margin-bottom:10px; float:right; display:block">
                	<a href="atchmnt_zip.php" style="margin-right:5px;">
                    <button id="sample_editable_1_new" class="btn green">
                        Upload csv <i class="icon-plus"></i>
                        </button></a>
                </div><?php */ ?>
                <div class="span3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li>
                            <a href="add_new_post.php?id=<?php echo $_REQUEST['id'];?>">
                                <i class="icon-briefcase"></i> 
                                Post Info
                            </a> 
                            <span class="after"></span>                                    
                        </li>
                        <li><a href="post_messages.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-group"></i> Messages</a></li>
                        <li><a href="bidding.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-leaf"></i> Bidding</a></li>
                        <li class="active"><a data-toggle="tab" href="#tab_4"><i class="icon-plus"></i> Attachments</a></li>
                    	<li><a href="milestone.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-tags"></i> Milestone</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <div class="form-horizontal">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_3">
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-globe"></i>List Attachment</div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th style="display:none"></th>
                                                    <th width="25px">#</th>
                                                    <th>Attachment</th>
                                                    <th>Download</th>
                                               </tr>
                                            </thead>
                                            <tbody>
                                            <?php
			if (!empty($arrAtatch))
			{
				for ($i = 0; $i < count($arrAtatch); $i++)
				{
					?>
					<tr class="odd gradeX">
						<td style="display:none"></td>
						<td><?php echo ($i + 1); ?></td>
						<td><?php if (file_exists("../upload/attachment/".$arrAtatch[$i]['post_id']."/". $arrAtatch[$i]['filename']) && $arrAtatch[$i]['filename'] != ''): ?>
								<a target="_blank" href="<?php echo $objModule->SITEURL; ?>upload/attachment/<?php echo $arrAtatch[$i]['post_id']; ?>/<?php echo $arrAtatch[$i]['filename']; ?>">Attachment <?php echo ($intKey + 1); ?> </a>
							<?php else: echo "File Not fond"; endif; ?>
                        </td>
                        <td><?php if($arrAtatch[$i]['filename'] != "" && file_exists("../upload/attachment/".$arrAtatch[$i]['post_id']."/" . $arrAtatch[$i]['filename'])){?><a href="dwnatmnt.php?img_id=<?php echo $arrAtatch[$i]['att_id']; ?>" class="btn mini yellow"><i class="icon-share"></i>Download</a>
	<?php } ?></td>
					</tr>
				<?php
				}
			}
			else
			{
	?>
	<tr><td colspan=5>No Attachment for this post </Td>
<?php }
?>                              
                                            </tbody>
                                        </table>
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