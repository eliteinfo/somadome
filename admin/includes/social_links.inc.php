<?php

//echo"tst"; exit;

$social = "select * from social_links";

$db_social = $objData->getAll($social);

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

                        <label>

                            <span>Layout</span>

                            <select class="layout-option m-wrap small">

                                <option value="fluid" selected>Fluid</option>

                                <option value="boxed">Boxed</option>

                            </select>

                        </label>

                        <label>

                            <span>Header</span>

                            <select class="header-option m-wrap small">

                                <option value="fixed" selected>Fixed</option>

                                <option value="default">Default</option>

                            </select>

                        </label>

                        <label>

                            <span>Sidebar</span>

                            <select class="sidebar-option m-wrap small">

                                <option value="fixed">Fixed</option>

                                <option value="default" selected>Default</option>

                            </select>

                        </label>

                        <label>

                            <span>Footer</span>

                            <select class="footer-option m-wrap small">

                                <option value="fixed">Fixed</option>

                                <option value="default" selected>Default</option>

                            </select>

                        </label>

                    </div>

                </div>

                <!-- END BEGIN STYLE CUSTOMIZER -->  

                <!-- BEGIN PAGE TITLE & BREADCRUMB-->

                <h3 class="page-title">

                    List Social Links 

                </h3>

                <ul class="breadcrumb">

                    <li>

                        <i class="icon-home"></i>

                        <a href="dashboard.php">Home</a> 

                        <i class="icon-angle-right"></i>

                    </li>

                    <li>List Social Links                       

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

               <!-- <div class="" style="margin-bottom:10px; float:right">

                    <a href="add_new_product.php"><button id="sample_editable_1_new" class="btn green">

                    Add New <i class="icon-plus"></i>

                    </button></a>

                   

                </div>-->

                <div class="portlet box green">

                    <div class="portlet-title">

                        <div class="caption"><i class="icon-globe"></i>List Social Links </div>

                        

                    </div>

                    

                    <div class="portlet-body">

                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">

                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">

                        <?php if(!empty($db_social)) { ?>

	                        <thead>

                                <tr>

                                	<th style="display:none"></th>

                                	<th width="25px">#</th>

                                    

                                    <th>Link Name</th>

                                    <!--<th>Product Description</th>-->

                                    <th>Link</th>

                                    <!--<th>CreateDate</th>-->

                                    <!--<th>Sort Order</th>-->
                                       <!-- <th>Status</th> -->
   	                                <th>Manage</th>

                                </tr>

                            </thead>

                             

                            <tbody>

                             <?php  for($i=0;$i<count($db_social);$i++){

								

								 ?>

                                <tr class="odd gradeX">

                                	<td style="display:none"></td>

                                	<td><?php echo ($i+1);?></td>

                                   	<td><?php echo $db_social[$i]['Name'];?></td>

                                    <td><?php echo $db_social[$i]['Link'];?></td>                          

                                    <td width="80px"><a href="manage_social_links.php?id=<?php echo $db_social[$i]['Id']; ?>" class="btn mini purple"><i class="icon-edit"></i>Manage</a></td>    
                                     <?php /* ?>  <td><?php if($db_social[$i]['Status']=="1"){ echo '<a href="#" class="btn mini green">'."Active".'</a>';}else { echo '<a href="#" class="btn mini orange">'."Inactive".'</a>';} ?></td> <?php */ ?>                                    

                                </tr>

                                <? }?>                              

                            </tbody>

                            <?php }

							else{

								echo "No Records Found";

								} ?>

                        </table>

                        </form>

                    </div>

                </div>

                

            </div>

        </div>

        <!-- END PAGE CONTENT-->

    </div>

    <!-- END PAGE CONTAINER-->

</div>

<style>

.size

{

	width:50px;

	height:50px;

}

</style>