<?php
if ($_POST['btnSubmit'] != '')
{
    /*echo "<script>window.location='list_post.php'</script>"; */
}
if ($_GET['id'] != '')
{
    $strSql = "SELECT tp.title,tu.Username,tb.Bid_amt,tbp.create_at,tbp.pid,tbp.status,
            CASE tbp.status
            WHEN '2' THEN 'Payment Done'
            ELSE 'Pending'
            End as p_status
            FROM tbl_buyer_pay tbp  
                        INNER JOIN tbl_post tp ON tbp.post_id = tp.id
                        INNER JOIN tbl_bidding tb ON tb.Uid = tp.win_uid AND tb.Post_id = tp.id
                        INNER JOIN tbl_users tu ON tu.id = tp.win_uid
            WHERE tbp.pid = '".$_GET['id']."'       GROUP BY tbp.pid";
    $arrData = $objModule->getAll($strSql);
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
        <h3 class="page-title"> Payment </h3>
        <ul class="breadcrumb">
          <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
          <li> <a href="payment.php">List Payment</a> <span class="icon-angle-right"></span> </li>
          <li> Payment Detail</li>
        </ul>
      </div>
    </div>
    <!-- END PAGE HEADER--> 
    <!-- BEGIN PAGE CONTENT-->
    <div class="row-fluid">
      <div class="span12"> 
        <!-- BEGIN VALIDATION STATES-->
        
        <div class="portlet box green">
          <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Payment Detail</div>
          </div>
          <div class="portlet-body form">
            <div class="form-horizontal form-view">
                <h3> <?php echo stripslashes($arrData[0]['title']);?></h3>
              
              <div class="row-fluid">
                <div class="span6 ">
                  <div class="control-group">
                    <label for="firstName" class="control-label">Win Tutor : </label>
                    <div class="controls"> <span class="text"><?php echo $arrData[0]['Username'];?></span> </div>
                  </div>
                </div>
                <!--/span-->
                <div class="span6 ">
                  <div class="control-group">
                    <label for="lastName" class="control-label">Amount :</label>
                    <div class="controls"> <span class="text"><?php echo $arrData[0]['Bid_amt'];?></span> </div>
                  </div>
                </div>
                
              </div>
                <div class="row-fluid">
                <div class="span6 ">
                  <div class="control-group">
                    <label for="firstName" class="control-label">Pay to tutor : </label>
                    <div class="controls"> <span class="text"><?php echo $arrData[0]['p_status'];?></span> </div>
                  </div>
                </div>
                <!--/span-->
              </div>
              <!--/row-->
              <?php if($arrData[0]['status']==1): ?>
              <div class="form-actions">
                  <form name="frmStaus" method="post" action="">
                        <input class="btn blue" name="btnSubmit" type="submit" value="Pay to Tutor" />
                  </form>
              </div>
              <?php endif;?>
            </div>
            
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
    function getSubcat(intCat, intSelect,strSkill)
    {
        jQuery.ajax({
            url: '../ajax.php',
            data: {intSelect: intSelect,strSkill:strSkill,intCat: intCat, CMD: "GET_SUBCATEGORY"},
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
            url: '../ajax.php',
            data: {CMD: "ADD_FILE_ADMIN"},
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
    <?php if($_REQUEST['id']!='' &&  $arrData[0]['category_id']!=''): ?>
            getSubcat('<?php echo $arrData[0]['category_id'];?>','<?php echo $arrData[0]['sub_cat'];?>','<?php echo $arrData[0]['skills'];?>');
    <?php endif;?>    
</script>
<style>
    .remove{background: url("images/add-more.png") no-repeat}
</style>