<?php
$sql="select * from tbl_post where category_id = '".$_GET['id']."' ";
$ans=$objData->getAll($sql);

$count = count($ans);

if($_GET['did'] != '')
{
	$objData->getAll("delete from tbl_category where id = '".$_GET['did']."'");
	$objModule->redirect('list_category.php');
		
}

if($_REQUEST['mydata']==1)
{
	
	
					
		$objData->setTableDetails("tbl_category", "id");
		$objData->setFieldValues("name", $_REQUEST['catname']);
        $objData->setFieldValues("status", $_REQUEST['status']);
		$objData->setFieldValues("create_date", date('Y-m-d H:i:s'));
		
		$objData->insert();
         
        $objModule->setMessage("Category Added Sucessfully","success");
					
					
		$objModule->redirect("./list_category.php");
					
}

if($_REQUEST['mydata1'] == 1)
{	
		//echo $_REQUEST['status']; exit;				
						
		$objData->setTableDetails("tbl_category", "id");
		$objData->setFieldValues("name", $_REQUEST['catname']);
        $objData->setFieldValues("status", $_REQUEST['status']);
		$objData->setFieldValues("create_date", date('Y-m-d H:i:s'));
		
		$objData->setWhere("id = '".$_REQUEST['id']."'");
        $objData->update();
        $objModule->setMessage("Category Update Sucessfully","success");
						
		$objModule->redirect("./list_category.php");
					
}
$sql_category = "select * from tbl_category where id = '".$_GET['id']."'";
$db_category = $objData->getAll($sql_category);
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
        <!-- BEGIN STYLE CUSTOMIZER -->
        <div class="color-panel hidden-phone">
          <div class="color-mode-icons icon-color"></div>
          <div class="color-mode-icons icon-color-close"></div>
          <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
              <li class="color-black current color-default" data-style="default"></li>
              <li class="color-blue" data-style="blue"></li>
              <li class="color-brown" data-style="brown"></li>
              <li class="color-purple" data-style="purple"></li>
              <li class="color-grey" data-style="grey"></li>
              <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label> <span>Layout</span>
              <select class="layout-option m-wrap small">
                <option value="fluid" selected>Fluid</option>
                <option value="boxed">Boxed</option>
              </select>
            </label>
            <label> <span>Header</span>
              <select class="header-option m-wrap small">
                <option value="fixed" selected>Fixed</option>
                <option value="default">Default</option>
              </select>
            </label>
            <label> <span>Sidebar</span>
              <select class="sidebar-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
            <label> <span>Footer</span>
              <select class="footer-option m-wrap small">
                <option value="fixed">Fixed</option>
                <option value="default" selected>Default</option>
              </select>
            </label>
          </div>
        </div>
        <!-- END BEGIN STYLE CUSTOMIZER -->
        <h3 class="page-title"> Category </h3>
        <ul class="breadcrumb">
          <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
          <li> <a href="list_category.php">List Category</a><span class="icon-angle-right"></span> </li>
          <li>Category</li>
        </ul>
      </div>
    </div>
    <!-- END PAGE HEADER--> 
    <!-- BEGIN PAGE CONTENT-->    
    <div class="row-fluid">
      <div class="span12"> 
        <div class="tabbable tabbable-custom boxless">
         <?php if($_GET['id']!='') { ?>
        <ul class="nav nav-tabs">         
          <li class="active"><a href="#tab_1" data-toggle="tab">Edit</a></li>
          <li><a href="#tab_2" data-toggle="tab">Posts</a></li>            
        </ul>
        <?php } ?>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="portlet box blue">
              <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>  <?php if($_GET['id']!='') { echo "Edit Category"; } else { echo "Add Category";}?></div>
                <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
              </div>
              <div class="portlet-body form">
            <form action="" method="post" id="form_sample_2" name="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
              <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert"></button>
                You have some form errors. Please check below. </div>
              <div class="alert alert-success hide">
                <button class="close" data-dismiss="alert"></button>
                Your form validation is successful! </div>
              <!-- <div class="portlet box blue">
                <div class="portlet-title">
            		<div class="caption">Personal Details</div>
          		</div>
                </div>-->
                <?php if($_GET['id']=='') { ?>
              <h3 style="color:#C33">Add Category</h3>
       		    <?php } ?>
                 <?php if($_GET['id']!='') { ?>
                 <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
              <h3 style="color:#C33">Edit Category</h3>
       		    <?php } ?>
                
                  <div class="control-group">
             <span style="color:red;padding-left:180px;" >   <?php echo $_GET['msg'];?></span>
               
              </div>
              <div class="control-group">
                <label class="control-label">Category Name<span class="required">*</span></label>
                <div class="controls">
                  <input type="text" maxlength="50" name="catname" id="catname" data-required="1" value="<?php echo $db_category[0]['name'];?>" 
                  class="span6 m-wrap required"/>
                </div>
              </div>
            
             <div class="control-group">
                <label class="control-label">Category Status</label>
                <div class="controls">
                  <select name="status" id="status" class="span6 m-wrap"/>
                  <option value="Active" <?php if($db_category[0]['status']=='Active') { echo "selected"; } ?>> Active</option>
                  <option value="Inactive" <?php if($db_category[0]['status']=='Inactive') { echo "selected"; } ?>> Inactive</option>
                  </select>
                </div>
              </div>
              <div class="form-actions">
                <?php if($_GET['id'] == '') { ?>
                <input type="button" name="submit1" class="btn blue" id="btn_add" value="Add" onclick="return check_data();">
                <input type="hidden" name="mydata" value="1" />
                <?php } else { ?>
                <input type="button" name="update" class="btn blue" value="Edit" id="btn_add" onclick="return check_data();">
                <input type="hidden" name="mydata1" value="1" />
                <a href="add_new_category.php?did=<?php echo $_GET['id']; ?>"   class="btn red" >Delete Category</a>
                <?php } ?>
                <!--<button type="submit" class="btn green">Validate</button>
                                <button type="button" class="btn">Cancel</button>--> 
              </div>
            </form>
            <!-- END FORM--> 
          </div>
        </div>
        <!-- END VALIDATION STATES--> 
      </div>
      
      <div class="tab-pane" id="tab_2">
            
            <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
          
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List Post</div>
                        
                    </div>
                    
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th width="25px">#</th>
                                    <th>Title</th>
                                  
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                             
                            <tbody>
                            
                            <?php 
						
							if($count!=0) 
							{ 
							for($i=0;$i<count($ans);$i++){?>
                                <tr class="odd gradeX">
                                	<td style="display:none"></td>
                                    <td><?php echo ($i+1);?></td>
                                    <td><?php echo $ans[$i]['title'];?></td>
                                    
                                    <td><?php echo ($ans[$i]['status']==1)?"Active":"Inactive";?></td>	
                                   <td><a href="add_new_post.php?id=<?php echo $ans[$i]['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>                                         
                                </tr>
                                <?php }
								
							}
							else
							{ ?>
                             <tr ><Td colspan=5>
                             						No Posts for this category </Td>
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
    <!-- END PAGE CONTENT--> 
  </div>
  <!-- END PAGE CONTAINER--> 
</div>
<script>
function delete_order(id)
	{
		 var x=confirm('Do you want to delete this record?');
		 if(x)
		 {
			 return true;
			 //window.location.href = 'manage_order.php?ordid='+;
		 }
		 else
		 {
			 return false;
		 }
	}
</script> 
