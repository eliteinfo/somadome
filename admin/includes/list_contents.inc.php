<?php 
if(isset($_GET['id']))
{
	$objData->getAll("delete from contents where id = '".$_GET['id']."'");
	$objData->redirect('list_contents.php');	
}
$pms = $objData->getAll("select * from contents order by id");

?>
<style>
.details { display:none; }
</style>
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
                    List Contents
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        List Contents
                    </li>
                    <!--<div class="btn-group" style="float:right; margin-top:-7px;">
                    <a href="add_new_content.php"><button id="sample_editable_1_new" class="btn green">
                    Add New <i class="icon-plus"></i>
                    </button></a>
                </div>-->
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
                        <div class="caption"><i class="icon-globe"></i>List Contents</div>
                        
                    </div>
                    
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th width="25px">#</th>
                                    <th>Page Name</th>
                                    <th>Page Url</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                             
                            <tbody>
                            <?php $i=1; foreach($pms as $contents) { ?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo ucfirst($contents['page_name']);?></td>
                                    <td><?php echo $contents['page_url'];?></td>	
                                   <td><a href="add_new_content.php?id=<?php echo $contents['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>                                </tr>
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
		window.location.href = 'list_contents.php?id='+id;
	  }
	  else{
		  return false;
	  }
	  return true;
	}
</script>