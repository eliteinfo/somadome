<?php
$strSql = "SELECT tp.*,tu.Username FROM  
                tbl_post tp 
                        INNER JOIN tbl_bidding tb ON tb.Uid = tp.win_uid AND tb.Post_id = tp.id
                        INNER JOIN tbl_users tu ON tu.id = tp.win_uid
                 WHERE (tp.win_status = '1' or   tp.win_status = '4') AND tp.status = '1'
                 GROUP BY tp.id ORDER BY tp.id desc";
$arrData = $objModule->getAll($strSql);
if ($_REQUEST['custom'] != '' && $_REQUEST['txn_id'] != '')
{
    $objModule->setMessage("Payment Done successfully","success");
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
               
                <h3 class="page-title">
                    Pay to Tutor
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        Pay To Tutor                       
                    </li>
                    
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <?php echo $objModule->getMessage();?>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>Payment</div>
                    </div>
                    
                    <div class="portlet-body">
                   <?php echo $objModule->getMessage(); ?>
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th>#</th>
                                    <th>Post</th>
                                    <th>Tutor</th>
                                    <th>Milestone Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($arrData as $intKey=>$strValue):?>
                                <tr class="odd gradeX">
                                    <td style="display:none"></td>
                                    <td><?php echo ($intKey+1);?></td>
                                    <td><?php echo $strValue['title'];?></td>
                                    <td><?php echo $strValue['Username'];?></td>
                                    <td>
                                        <a href="listmilestone.php?id=<?php echo base64_encode($strValue['id']);?>" class="btn mini purple"><i class="icon-edit"></i> View Milestone</a>
                                    </td>                                        
                                </tr>
                           <?php endforeach;?>                              
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>