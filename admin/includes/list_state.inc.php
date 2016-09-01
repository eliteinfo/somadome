<?php
if($_GET['id'] != '')
	{
		$objData->getAll("delete from tbl_state where Id = '".$_GET['id']."'");
		$objModule->redirect('list_state.php');		
	}
	$sql  =  $objData->getAll("select ts.*,tc.Name as country_name from tbl_state ts left join tbl_country tc on tc.Id=ts.Cid");
    //echo'<pre>'; print_r($sql);
        
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
                    State
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        List State                        
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
                <div class="btn-group" style="margin-bottom:5px; float:right">
                    <a href="add_state.php"><button id="sample_editable_1_new" class="btn green">
                    Add State <i class="icon-plus"></i>
                    </button></a>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List State</div>
                    </div>
                    
                    <div class="portlet-body">
                     <?php echo $objModule->getMessage(); ?>
                   
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th>Country Name</th>
                                    <th>State Name</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php foreach($sql as $state){ ?> 
                           <?php if($state['country_name'] != ''){ ?>
                                <tr>
                                    <td style="display:none"></td>
                                    <td><?php echo $state['country_name']; ?></td>
                                    <td><?php echo $state['Name']; ?></td>
                                    <td>
                                        <a href="add_state.php?id=<?php echo $state['Id'];?>" class="btn mini purple"><i class="icon-edit"></i> Edit</a>
                                        <a href="javascript:;" onclick="return doYouWantTo('<?php echo $state['Id'] ?>')" class="btn mini red"><i class="icon-trash"></i> Delete</a>
                                    </td>                                        
                                </tr>
                                <?php } 
								}?>                              
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
		window.location.href = 'list_state.php?id='+id;
	  }
	  else{
		  return false;
	  }
	  return false;
	}
</script>