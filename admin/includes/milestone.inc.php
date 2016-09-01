<?php
if ($_GET['id'] != '')
{
    $bidding1 = "select tm.*,ttp.pid from tbl_milestone tm LEFT JOIN tbl_tutor_pay ttp ON ttp.mid = tm.id where tm.post_id = '" . $_GET['id'] . "' GROUP BY tm.id order by id";
    $db_bidding1 = $objModule->getAll($bidding1);
    //echo "<pre>";print_r($objModule);die;
    $count2 = count($db_bidding1);
	$selpost = $objData->getAll("SELECT * FROM tbl_post WHERE id =".$_GET['id']."");
	
	$From_user = $db_bidding1[0]['uid'];
	$from_user_name = $objModule->getName("tbl_users", "CONCAT(fname,' ',lname) as name", "Id", $From_user);}
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
                <h3 class="page-title">  <?php echo ucfirst($selpost[0]['title']); ?> </h3>
                <ul class="breadcrumb">
                    <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
                    <li> <a href="list_post.php">List Post</a> <span class="icon-angle-right"></span> </li>
                    <li>  <?php echo ucfirst($selpost[0]['title']); ?></li>
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
                        <li>
                            <a href="add_new_post.php?id=<?php echo $_REQUEST['id'];?>">
                                <i class="icon-briefcase"></i> 
                                Post Info
                            </a> 
                            <span class="after"></span>                                    
                        </li>
            <li><a href="post_messages.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-group"></i> Messages</a></li>
            <li><a href="bidding.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-leaf"></i> Bidding</a></li>
            <li><a href="attchmnt.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-plus"></i> Attachments</a></li>
            <li class="active"><a data-toggle="tab" href="#tab_3"><i class="icon-tags"></i> Mile 	stones</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <div class="form-horizontal">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_3">
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-globe"></i> <?php  echo $from_user_name[0]['name']; ?></div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th style="display:none"></th>
                                                    <th width="25px">#</th>
                                                    <th>Title</th>
                                                    <th>Cost</th>
                                                    <th>Status</th>
                                                    <th>Admin pay</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($count2 != 0)
                                                {
                                                    for ($i = 0; $i < count($db_bidding1); $i++)
                                                    {
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td style="display:none"></td>
                                                            <td><?php echo ($i + 1); ?></td>
                                                            <td><?php echo $db_bidding1[$i]['title']; ?></td>
                                                            <td><?php echo "$ ".$db_bidding1[$i]['cost']; ?></td>
                                                            <td><?php 
															if($db_bidding1[$i]['status'] == 0){ 
																echo "Not Accepted";
															}elseif($db_bidding1[$i]['status'] == 1) {
																echo "Approved";
															}elseif($db_bidding1[$i]['status'] == 2) {
																echo "Reject";
															}elseif($db_bidding1[$i]['status'] == 3) {
																echo "Paid by buyer";
															}
															?></td>
                                                            <td>
                                                                <?php 
                                                                if($db_bidding1[$i]['status']==3):
                                                                    if($db_bidding1[$i]['pid']!=''):    
                                                                        echo 'Paid to tutor';
                                                                    else:
                                                                        echo 'Not paid to tutor';
                                                                    endif;
                                                                else:
                                                                    echo '&nbsp;';
                                                                endif;
?>
                                                            </td>
                                                            <td><?php echo date('d M Y H:m: A', strtotime($db_bidding1[$i]['edate'])); ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <tr><td colspan=5>No Milestone for this Job </Td>
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