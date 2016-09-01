<?php
if ($_GET['id'] != '')
{
	//$sql = "SELECT * from tbl_messages where post_id = '" .$_GET['id']. "' and Conversion='0' order by Create_date";
	
	$selpost = $objData->getAll("SELECT * FROM tbl_post WHERE id =".$_GET['id']."");
	//$sql1 = $objModule->getAll("SELECT group_concat(From_user) as frmuid from tbl_messages where post_id ='" .$_GET['id']. "' AND From_user NOT IN(".$selpost[0]['uid'].") order by Create_date");
	//$sql2 = $objModule->getAll("SELECT group_concat(To_user) as touid from tbl_messages where post_id ='" .$_GET['id']. "' AND To_user NOT IN(".$selpost[0]['uid'].") order by Create_date");
	$sql1 = $objModule->getAll("SELECT group_concat(m.From_user) as frmuid from tbl_messages as m  RIGHT JOIN tbl_users as u ON u.Id=m.From_user where m.post_id ='" .$_GET['id']. "' AND m.From_user NOT IN(".$selpost[0]['uid'].") order by m.Create_date");
	$sql2 = $objModule->getAll("SELECT group_concat(m.To_user) as touid from tbl_messages as m RIGHT JOIN tbl_users as u ON u.Id=m.To_user where m.post_id ='" .$_GET['id']. "' AND m.To_user NOT IN(".$selpost[0]['uid'].") order by m.Create_date");
	$str = $sql1[0]['frmuid'].",".$sql2[0]['touid'];
	$arru = array_unique(explode(",",$str));
	$uids = implode(",",$arru);
	$sql = "SELECT DISTINCT From_user,Post_id,From_user,To_user from tbl_messages where post_id ='" .$_GET['id']. "' AND ((From_user IN(".$uids.") AND To_user =".$selpost[0]['uid'].") OR (From_user =".$selpost[0]['uid'] ." AND To_user IN(".$uids."))) GROUP BY From_user, To_user  order by Create_date";
	$db_message = $objModule->getAll($sql);
    $count = count($db_message);
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
                <h3 class="page-title"> <?php echo ucfirst($selpost[0]['title']); ?> </h3>
                <ul class="breadcrumb">
                <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
                <li> <a href="list_post.php">List Post</a> <span class="icon-angle-right"></span> </li>
                <li> <?php echo ucfirst($selpost[0]['title']); ?></li>
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
                <li class="active"><a data-toggle="tab" href="#tab_2"><i class="icon-group"></i> Messages</a></li>
                <li><a href="bidding.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-leaf"></i> Bidding</a></li>
                <li><a href="attchmnt.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-plus"></i> Attachments</a></li>
                <li><a href="milestone.php?id=<?php echo $_REQUEST['id'];?>"><i class="icon-tags"></i> Milestone</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <div class="row-fluid">
                        <div class="span12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->

                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption"><i class="icon-globe"></i>List Messages</div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th style="display:none"></th>
                                                <th width="25px">#</th>
                                                <th>User Name</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($arru[0] != "")
                                            {
												foreach($arru as $key=> $val){
													if(!empty($val)){
$sql = "SELECT DISTINCT From_user,Post_id,From_user,To_user from tbl_messages where post_id ='" .$_GET['id']. "' AND (From_user =".$val." OR (To_user =".$val.")) GROUP BY From_user, To_user order by Create_date";
	//$sql = "SELECT DISTINCT From_user,Post_id,From_user,To_user from tbl_messages where post_id ='" .$_GET['id']. "' GROUP BY  From_user, To_user  order by Create_date";
    $db_message = $objModule->getAll($sql);
	//for ($i = 0; $i < count($db_message); $i++)
	//{
?>
                      <tr class="odd gradeX">
                        <td style="display:none"></td>
                        <td><?php echo ($i + 1); ?></td>
                        <td><?php
							if($db_message[0]['From_user'] != $selpost[0]['uid']){
                            	$From_user = $db_message[0]['From_user'];
								$to_user = $db_message[0]['To_user'];
							}else {
								$From_user = $db_message[0]['To_user'];
								$to_user = $db_message[0]['From_user'];
							}
                            $arrName = $objModule->getName("tbl_users", "CONCAT(fname,' ',lname) as name", "Id", $From_user);
							echo $arrName[0]['name'];
                            ?>
                        </td>
                        <td><a data-toggle="modal"  href="post_messages.php?user=<?php echo $From_user; ?>#responsive" class="btn mini purple" onclick="add_value('<?php echo $From_user; ?>', '<?php echo $to_user; ?>', '<?php echo $db_message[0]['Post_id']; ?>')"><i class="icon-edit"></i> View</a></td>
                    </tr>
                   <?php  } /* ?> <tr class="odd gradeX">
                        <td style="display:none"></td>
                        <td><?php echo ($i + 1); ?></td>
                        <td><?php
							if($db_message[$i]['From_user'] != $selpost[0]['uid']){
                            	$From_user = $db_message[$i]['From_user'];
							}else {
								$From_user = $db_message[$i]['To_user'];
							}
                            $arrName = $objModule->getName("tbl_users", "CONCAT(fname,' ',lname) as name", "Id", $From_user);
                            echo $arrName[0]['name'];
                            ?></td>
                        <td><a data-toggle="modal" href="post_messages.php?user=<?php echo $db_message[$i]['From_user']; ?>#responsive" class="btn mini purple" onclick="add_value('<?php echo $db_message[$i]['From_user']; ?>', '<?php echo $db_message[$i]['To_user']; ?>', '<?php echo $db_message[$i]['Post_id']; ?>')"><i class="icon-edit"></i> View</a></td>
                    </tr><?php */ ?>
                   	<?php
                                                }
                                           }
                                            else
                                            {
                                                ?>
                                                <tr><td colspan=5>No Messages for this post </Td>
                                                <?php } ?>                              
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div id="responsive" class="modal hide fade" tabindex="-1" data-width="760"></div>
                    </div>
                    <!-------- Scripts for scrolling ------>
				<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
                <script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
                <script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
                <script src="assets/scripts/ui-modals.js"></script> 
                </div>
          <!-- END VALIDATION STATES--> 
            </div>
        </div>
        <!-- END PAGE CONTENT--> 
    </div>
    <!-- END PAGE CONTAINER--> 
</div>