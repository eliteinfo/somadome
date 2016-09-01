<?php 
if(isset($_GET['id']))
{
	$objData->getAll("delete from tbl_client_icon where id = '".$_GET['id']."'");
	$objModule->redirect('list_client_icon.php');	
}
$country = $objData->getAll("select * from tbl_client_icon order by id desc");
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
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                   Client List
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                       Client list
                    </li>
                    <div class="btn-group" style="float:right; margin-top:-7px;">
                        <a href="add_client_icon.php"><button id="sample_editable_1_new" class="btn green">
                    Add New <i class="icon-plus"></i>
                    </button></a>
                </div>
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
                        <div class="caption"><i class="icon-globe"></i>Client list</div>
                        
                    </div>
                    
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th width="25px">#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                             
                            <tbody>
                            <?php $i=1; foreach($country as $values) { ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                    <td><?= $i;?></td>
                                    <td><?= $values['name'];?></td>
                                    <td>
                                        <?php
                                        if ($values['image'] != '' && file_exists("../upload/icon/".$values['image'])) {
                                    
                                             echo '<img src="../upload/icon/'.$values['image'].'" height="70" width="70" /><br/>';
                                         }
                                        ?>
                                    </td>
                                    
                                    <td><a href="add_client_icon.php?id=<?= $values['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Edit</a>
                                   <a href="javascript:;" onclick="doYouWantTo('<?= $values['id'];?>')" class="btn mini red"><i class="icon-trash"></i> Delete</a></td>                                </tr>
                                <? $i++; }?>                              
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
<script type="text/javascript">
	function doYouWantTo(id){
	  doIt=confirm('Do you want to delete it?');
	  if(doIt){
		window.location.href = 'list_client_icon.php?id='+id;
	  }
	  else{
		  return false;
	  }
	  return false;
	}
</script>