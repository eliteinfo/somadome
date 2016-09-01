<?php
include('../lib/module.php');
$sql="select ts.*,tc.name from tbl_subcategory ts INNER JOIN tbl_category tc ON tc.id = ts.cat_id  WHERE 1";
//$sql = "select * from tbl_post WHERE 1=1";
$post_status = $_REQUEST['post_status']; 
if($post_status != ''){
  $sql .= " and cat_id = ".$post_status."";
}
$sql1 = $sql." GROUP BY ts.sid  order by ts.sid";
$ans = $objData->getAll($sql1);
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
                                    <th>Category Name</th>
                                    <th>Parent</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                             
                            <tbody>
                            <?php for($i=0;$i<count($ans);$i++){?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                    <td><?php echo ($i+1);?></td>
                                    <td><?php echo $ans[$i]['sname'];?></td>
                                    <td><?php echo $ans[$i]['name'];?></td>
                                    <td><a href="add_new_subcategory.php?id=<?php echo $ans[$i]['sid'];?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>                                         
                                </tr>
                                <? }?>                              
                            </tbody>
                        </table>
