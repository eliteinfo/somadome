<?php
if ($_GET['id'] != '')
{
    //$bidding1 = "select * from tbl_bidding where Post_id = '" . $_GET['id'] . "' order by Id";
	$bidding1 = "select b.* from tbl_bidding as b RIGHT JOIN tbl_users AS u ON u.Id=b.Uid where b.Post_id = '" . $_GET['id'] . "' order by b.Id";
    $db_bidding1 = $objModule->getAll($bidding1);
    $count2 = count($db_bidding1);
	$selpost = $objData->getAll("SELECT * FROM tbl_post WHERE id =".$_GET['id']."");
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
                        
                        <li class="active"><a data-toggle="tab" href="#tab_3"><i class="icon-leaf"></i> Bidding</a></li>
                                        <li><a href="attchmnt.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-plus"></i> Attachments</a></li>
                                        <li><a href="milestone.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-tags"></i> Milestone</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <div class="form-horizontal">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_3">
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-globe"></i>List Bidiing</div>
                                    </div>

                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th style="display:none"></th>
                                                    <th width="25px">#</th>
                                                    <th>Bidder Name</th>
                                                    <th>Bidding Amount</th>
                                                    <th>Bidding Date</th>
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

                                                            <td><?php
                                                                $From_user = $db_bidding1[$i]['Uid'];
                                                                 $from_user_name = $objModule->getName("tbl_users", "CONCAT(fname,' ',lname) as name", "Id", $From_user);
                                                                 echo $from_user_name[0]['name'];
                                                                ?></td>
                                                            <td><?php echo $db_bidding1[$i]['Bid_amt']; ?></td>
                                                            <td><?php echo date('d M Y H:m: A', strtotime($db_bidding1[$i]['create_at'])); ?></td>

                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                        <tr ><td colspan=5>No Bidding for this post </td></tr>

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