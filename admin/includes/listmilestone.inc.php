<?php

$intPostId = base64_decode($_GET['id']);

$strSql = "SELECT tm.*,tmp.`transaction_id`,tp.title as post_title,tbp.pid FROM 	

	`tbl_milestone` tm 

		LEFT JOIN `tbl_milestone_payment` tmp ON tmp.`mid` = tm.`id`	

                LEFT JOIN tbl_tutor_pay tbp ON tbp.mid = tm.id

		INNER JOIN tbl_post tp ON tm.`post_id` = tp.`id`

		WHERE tp.`id` = '".$intPostId."' AND (tp.`win_status` = '1' OR tp.`win_status` = '4') AND tp.`status` = '1'

            GROUP BY tm.`id`

            ORDER BY tm.`id` DESC";

$arrData = $objModule->getAll($strSql);



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

                    Milestone list

                </h3>

                <ul class="breadcrumb">

                    <li>

                        <i class="icon-home"></i>

                        <a href="dashboard.php">Home</a>

                        <i class="icon-angle-right"></i>

                    </li>

                    <li>

                        Milestone

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



                <div class="portlet box green">

                    <div class="portlet-title">

                        <div class="caption"><i class="icon-globe"></i>Milestone List</div>

                    </div>



                    <div class="portlet-body">

                        <?php echo $objModule->getMessage(); ?>

                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">

                            <thead>

                            <tr>

                                <th style="display:none"></th>

                                <th>#</th>

                                <th>Title</th>

                                <th>Cost</th>

                                <th>Buyer Status</th>

                                <th>Admin Status</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php

                            if(!empty($arrData))

                            {

                                foreach($arrData as $intKey=>$strValue):?>

                                    <tr class="odd gradeX">

                                        <td style="display:none"></td>

                                        <td><?php echo ($intKey+1);?></td>

                                        <td><?php echo $strValue['title'];?></td>

                                        <td>$ <?php echo $strValue['cost'];?></td>

                                        <td>

                                            <?php if($strValue['status']==1): echo 'Payment not done';?>

                                            <?php elseif($strValue['status']==2): echo 'Rejected';?>

                                            <?php elseif($strValue['status']==3): echo 'Payment Done';?>

                                            <?php elseif($strValue['status']==0): echo 'Not Accepted';?>

                                            <?php endif;?>

                                        </td>

                                        <td>

                                            <?php if($strValue['status']==1): echo '&nbsp';?>



                                            <?php elseif($strValue['status']==2): echo '&nbsp;';?>

                                            <?php elseif($strValue['status']==3 && $strValue['transaction_id']!='' && $strValue['pid']!=''): echo 'Payment Done'; ?>

                                            <?php elseif($strValue['status']==3 && $strValue['transaction_id']!='' && $strValue['pid']==''): ?>

                                                <a href="paypal.php?id=<?php echo base64_encode($strValue['id']);?>" class="btn mini purple"><i class="icon-edit"></i>Make Payment</a>

                                            <?php elseif($strValue['status']==0): echo '&nbsp;';?>

                                            <?php endif;?>

                                        </td>

                                    </tr>

                                <?php endforeach;?>

                            <?php } else {?>

                            <tr><td colspan=6>No Bidding for this post </td>

                                <?php }?>

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