<?php
include('../lib/module.php');
$sql = "select * from tbl_post WHERE 1=1";
$post_status = $_REQUEST['post_status']; 
if($post_status != ''){
  $sql .= " and win_status = '$post_status'";
}
if($_REQUEST['startdate']!='' and $_REQUEST['enddate']!='')
{
	$startdate = date('Y-m-d',strtotime($_REQUEST['startdate']));
 	$enddate = date('Y-m-d',strtotime($_REQUEST['enddate']));
	$sql .= " AND date(start_date_time) >= '$startdate' AND date(end_date_time) <= '$enddate'";
}
$sql .= " order by id DESC";
$ans = $objModule->getAll($sql);
?>
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
<link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap.css" />
<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>
<script src="assets/scripts/table-advanced.js"></script>
<script>
		jQuery(document).ready(function() {       
		   App.init();
		   TableAdvanced.init();
		});
		   </script>
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
  <thead>
    <tr>
      <th style="display:none"></th>
      <th width="25px">#</th>
      <th>Title</th>
      <th>Winning Status</th>
      <th>Start Date</th>
      <th>End date</th>
      <th>Manage</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i=0;$i<count($ans);$i++){?>
    <tr class="odd gradeX">
      <td style="display:none"></td>
      <td><?php echo ($i+1);?></td>
      <td><?php echo $ans[$i]['title'];?></td>
      <td><?php if($ans[$i]['win_status']=='0'){ echo "Running"; }else if($ans[$i]['win_status']=='1'){ echo "Assigned"; } else if($ans[$i]['win_status']=='2'){ echo "Completed"; } else if($ans[$i]['win_status']=='3'){ echo "Not Awarded"; }else if($ans[$i]['win_status']=='4'){ echo "Mark as Done"; }else { echo "------"; } ?></td>
      <td><?php echo $date = date('d M Y',strtotime($ans[$i]['start_date_time']));?></td>
      <td><?php if($ans[$i]['end_date_time']!='0000-00-00 00:00:00') { echo $date = date('d M Y',strtotime($ans[$i]['end_date_time'])); } ?></td>
      <td><a href="add_new_post.php?id=<?php echo $ans[$i]['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>
    </tr>
    <? } ?>
  </tbody>
</table>
