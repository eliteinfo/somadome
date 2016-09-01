<?php
$sql="select * from tbl_post where uid = '".$_GET['id']."' ";
$ans=$objData->getAll($sql);
$count = count($ans);

function getLnt($Zipcode,$cntry_code)
{
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($Zipcode).",$cntry_code&sensor=false";
	$result_string = file_get_contents($url);
	$result = json_decode($result_string, true);
	$result1[]=$result['results'][0];
	$result2[]=$result1[0]['geometry'];
	$result3[]=$result2[0]['location'];
	return $result3[0];
}
if($_GET['did'] != '')
{
	$objData->getAll("delete from tbl_users where Id = '".$_GET['did']."'");
	echo "<script> window.location.href = 'buyer_list.php' </script>";	
}
if(isset($_POST['update']))
{    
	/*if($_POST['usertype']=='1')
	{
		$current_credit = $_POST['current_credit'];
		if($current_credit<5)
		{
			$current_credit =5;
		}
	}
	else
	{
		$current_credit ='';
	}*/
	$date = date('Y/m/d');
	$countrycode = explode('_',$_POST['drpCountry']);
	$country_id = $countrycode[0]; 
	$cntry_code = substr($countrycode[1],0,2);
	$Zipcode =$_POST['Zipcode'];
	$zipcode = getLnt($Zipcode,$cntry_code);
	$lat =  $zipcode['lat'];
	$lng = $zipcode['lng'];
 	$filename = $_FILES['file']['name'];
        if($filename != '')
        {
			$strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../upload/user',$_FILES['file']['name']);
           	list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);
				if($width > 300 && $height > 300)
				{
					$objImg = new SimpleImage();
					$objImg->load($_FILES['file']['tmp_name']);
					$objImg->resize(300,300);
					$objImg->save('../upload/user/'.$strFile);
					unset($objImg);
					unset($_FILES['file']['tmp_name']);
				}
				else
				{
					move_uploaded_file($_FILES['file']['tmp_name'],"../upload/user/".$strFile);
				}
			}else{
				$strFile = $_REQUEST['hdnImage'];
			}
		$objData->setTableDetails("tbl_users", "Id");
		//$objData->setFieldValues("Username", $_REQUEST['uname']);
		$objData->setFieldValues("fname", $_REQUEST['fname']);
		$objData->setFieldValues("lname", $_REQUEST['lname']);
		//$objData->setFieldValues("h_rate", $_REQUEST['hrate']);
		$objData->setFieldValues("Photo",$strFile);
		$objData->setFieldValues("Status", $_REQUEST['drpStatus']);
		$objData->setFieldValues("Zipcode", $_REQUEST['Zipcode']);
		$objData->setFieldValues("Country", $country_id);
		$objData->setFieldValues("State", $_REQUEST['drpState']);
		$objData->setFieldValues("City", $_REQUEST['city']);
		$objData->setFieldValues("Contact_no", $_REQUEST['mobile_no']);
		$objData->setWhere("Id = '".$_GET['id']."'");
		$objData->update();
			echo "<script>window.location='buyer_list.php' </script>";
		
}
$sql_member = "select * from tbl_users where Id = '".$_GET['id']."' AND User_type='0'";
$db_member = $objData->getAll($sql_member);
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
    <h3 class="page-title"> Buyer </h3>
    <ul class="breadcrumb">
      <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
      <li> <a href="buyer_list.php">List Buyer</a> <span class="icon-angle-right"></span> </li>
      <li><a href="#">Buyer</a></li>
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
    <!--<li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>-->
    <li class="active"><a href="#tab_1" data-toggle="tab">Edit</a></li>
    <?php if($db_member[0]['User_type'] == '0'){ ?>
    <li><a href="#tab_2" data-toggle="tab">Posts</a></li>
    <li><a href="#tab_4" data-toggle="tab">Payment</a></li>
    <?php  } ?>
    <?php /*if($db_member[0]['User_type'] == '1'){ ?>
    <li><a href="#tab_3" data-toggle="tab">Bids</a></li>
    <?php } ?>
     <?php if($db_member[0]['User_type'] == '3'){ ?>
     <li><a href="#tab_2" data-toggle="tab">Posts</a></li>
     <li><a href="#tab_3" data-toggle="tab">Bids</a></li>
     <?php }*/ ?>
   
  </ul>
  <?php } ?>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1">
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption"><i class="icon-reorder"></i> Buyer Details</div>
          <div class="tools"  style="display:none"> <a href="javascript:;" class="collapse"></a> <a href="#portlet-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
        </div>
        <div class="portlet-body form">
          <form action="" method="post" id="form_sample_2" class="form-horizontal" enctype="multipart/form-data">
            <div class="alert alert-error hide"><button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
            <div class="alert alert-success hide"><button class="close" data-dismiss="alert"></button>Your form validation is successful! </div>
             
           
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'Errfilesize'){ ?>
               <div class="alert alert-error "><button class="close" data-dismiss="alert"></button>            
              Image should be grater than 250X250 </div>
              <?php } ?>
              
            
            <!-- <div class="portlet box blue">
                <div class="portlet-title">
            		<div class="caption">Personal Details</div>
          		</div>
                </div>-->
            <?php
			if(isset($_GET['post_id']) && $_GET['post_id'] != ""){
			?>
            <input type="hidden" name="hdn_postid" id="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />  	
			<?php
			}
			?>
            <h3 style="color:#C33">Buyer Details</h3>
            <div class="control-group">
              <label class="control-label">First Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="fname" onkeypress="return onlyAlphabets(event,this);" data-required="1" value="<?php echo $db_member[0]['fname']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>
         	 <div class="control-group">
              <label class="control-label">Last Name<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="lname" onkeypress="return onlyAlphabets(event,this);" data-required="1" value="<?php echo $db_member[0]['lname']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Email Id<span class="required">*</span></label>
              <div class="controls">
                  <input type="text" name="email" data-required="1" value="<?php echo $db_member[0]['Email']; ?>" class="span6 m-wrap required email" disabled=""  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Username<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="username" data-required="1" value="<?php echo $db_member[0]['Username']; ?>" class="span6 m-wrap required" disabled=""  />
              </div>
            </div>
<!--             <div class="control-group">
              <label class="control-label">Hourly Rate<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="hrate" onkeypress="return isNumber(event);" data-required="1" value="<?php echo $db_member[0]['h_rate']; ?>" class="span6 m-wrap required"/>
              </div>
            </div>-->
            <div class="control-group"> 
              <label class="control-label">Description</label>
              <div class="controls">
                  <textarea name="desc" class="span6 m-wrap"><?php echo stripslashes($db_member[0]['description']); ?></textarea>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label">Mobile No<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="mobile_no" id="mobile" maxlength="10" onkeypress="return isNumber(event)" value="<?php echo $db_member[0]['Contact_no']; ?>" class="span6 m-wrap required" />
              </div>
            </div>
            <?php
			  $currency = "select * from tbl_country ";
			  $db_currency = $objData->getAll($currency);
			  ?>
            <div class="control-group">
              <label class="control-label">Country<span class="required">*</span></label>
              <div class="controls">
                <select class="span6 m-wrap required" name="drpCountry" id="drpCountry" >
                  <option value="">---Select---</option>
                  <?php for($i=0;$i<count($db_currency);$i++){ ?>
                  <option value="<?php echo $db_currency[$i]['Id']."_".$db_currency[$i]['curr_code']; ?>"<?php if($db_currency[$i]['Id'] == $db_member[0]['Country']){ ?> selected="selected"<?php } ?>><?php echo $db_currency[$i]['Name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php
			  $state = "select * from tbl_state where Cid = '".$db_member[0]['Country']."'";
			  $db_state = $objData->getAll($state);
			?>
            <div class="control-group" id="app_state">
              <label class="control-label">State<span class="required">*</span></label>
              <div class="controls">
                 <input type="text" name="drpState" id="drpState" value="<?php echo $db_member[0]['State']; ?>" class="span6 m-wrap required"/>  
                <?php /* ?><select class="span6 m-wrap required" name="drpState" id="drpState">
                  <option value="">---Select---</option>
                  <?php for($j=0;$j<count($db_state);$j++){ ?>
                  <option value="<?php echo $db_state[$j]['Id']; ?>"<?php if($db_state[$j]['Id'] == $db_member[0]['State']){ ?> selected="selected"<?php } ?>><?php echo $db_state[$j]['Name']; ?></option>
                  <?php } ?>
                </select><?php */ ?>
              </div>
            </div>
           
           
            <div class="control-group">
              <label class="control-label">Zipcode<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="Zipcode" value="<?php echo $db_member[0]['Zipcode']; ?>" class="span6 m-wrap required" />
              </div>
            </div>
           
        <div id="responsive" class="modal hide fade" tabindex="-1" data-width="760">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Add Credit</h3>
                                        <div id="amt_div" style="display:none;color:green;text-align:center;font-size:14px;"><strong> Amount is Credited</strong></div>
                                        <div id="amt_error_div" style="display:none;color:red;text-align:center;font-size:14px;"><strong> Please Enter Amount</strong></div>
								  </div>
									<div class="modal-body">
										<div class="scroller" style="height:130px;width:100px;" data-always-visible="1" data-rail-visible1="1">
											<div class="row-fluid">
												<div class="span8">
													<h4>Enter Amount</h4>
													<p>
                                      <input type="text" class="span12 m-wrap" name="amount" id="amount" onkeypress="return isNumber(event)" maxlength="6" style="max-width:250px;float:left;margin-right:10px;">
                                       <span id="amt" style="color:green;font-size:18px;"> </span>
                                                    </p>
                                                    <input type="hidden" name="credit_amount" id="credit_amount" />
                                                    <input type="hidden" name="userid" id="userid" value="<?php echo $_GET['id'] ?>"/>
                                                    
												</div>
												<div id="amt_total_div"  class="span8" style="display:none;color:green;text-align:left;font-size:14px;margin-top:24px;margin-left:0px;"><strong> </strong></div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" data-dismiss="modal" class="btn">Close</button>
										<button type="button" class="btn blue" onclick="credit_amount_fun();">Save changes</button>
									</div>
							  </div>
           <!---------------------- Scripts for scrolling -------------------->
					<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
                    <script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
                    <script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
                    <script src="assets/scripts/ui-modals.js"></script>  
            <!-- ---------------------------------------------------------------- -->         
          
            <div class="control-group">
              <label class="control-label">Image<span class="required"></span></label>
              <div class="controls">
                <input type="file" name="file" id="ufile" class="span6 m-wrap" style="color:black; border:none;" />
              </div>
            </div>
            <?php if($db_member[0]['Photo'] == ""){ ?>
            <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">            
              <img src="../upload/user/default.png" width="75" height="75"  /> </div>
            </div>
           <?php }else{ ?>
            <input type="hidden" name="hdnImage" value="<?php echo $db_member[0]['Photo'];?>" />
           			<div class="control-group">
                      <label class="control-label"></label>
                      <div class="controls"> 
                      <img src="../upload/user/<?php echo $db_member[0]['Photo']; ?>" width="75" height="75"  /> </div>
                    </div>
           <?php } ?>
            
            <div class="control-group">
              <label class="control-label">Status<span class="required"></span></label>
              <div class="controls">
                <select name="drpStatus"  class="span6 m-wrap">
                  <option value="1" <?php if($db_member[0]['Status'] == '1') { ?> selected="selected"<?php } ?>>Active</option>
                  <option value="0" <?php if($db_member[0]['Status'] == '0') { ?> selected="selected"<?php } ?>>InActive</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="update" class="btn blue" value="Edit">
              <a href="add_users.php?did=<?php echo $_GET['id']; ?>" onclick="return delete_order('<?php echo $_GET['id']; ?>');"  class="btn red" >Delete User</a>
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
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Manage</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 	
				  if($count!=0) 
				{ 
				for($i=0;$i<count($ans);$i++){ ?>
                  <tr class="odd gradeX">
                    <td style="display:none"></td>
                     <td><?php echo ($i+1);?></td>
                     <td><?php echo $ans[$i]['title'];?></td>
                     <td><?php if($ans[$i]['win_status']=='0'){ echo "Running"; }else if($ans[$i]['win_status']=='1'){ echo "Assigned"; } else if($ans[$i]['win_status']=='2'){ echo "Completed"; } else if($ans[$i]['win_status']=='3'){ echo "Not Awarded"; }else if($ans[$i]['win_status']=='4'){ echo "Mark as Done"; }else { echo "------"; } ?></td>
                     <td><?php echo $date = date('d M Y H:i A',strtotime($ans[$i]['start_date_time'])); ?></td>
                    <td><?php if($ans[$i]['end_date_time']!='0000-00-00 00:00:00') { echo $date = date('d M Y H:i A',strtotime($ans[$i]['end_date_time'])); } ?></td>
                    <td><a href="add_new_post.php?id=<?php echo $ans[$i]['id'];?>&page=user&userid=<?php echo $_GET['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Manage</a></td>
                  </tr>
                  <?php }
								
							}
							else
							{ ?>
                  <tr >
                    <Td colspan=5>No Posts for this User </Td>
                    <?php }
							?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Start tab 4 -->
    <?php 
	$strSql = "SELECT tp.title,tu.Username,tb.Bid_amt,tbp.create_at,tbp.pid,
            CASE tbp.status
            WHEN '2' THEN 'Payment Done'
            ELSE 'Pending'
            End as p_status
            FROM tbl_buyer_pay tbp  
                        INNER JOIN tbl_post tp ON tbp.post_id = tp.id
                        INNER JOIN tbl_bidding tb ON tb.Uid = tp.win_uid AND tb.Post_id = tp.id
                        INNER JOIN tbl_users tu ON tu.id = tp.win_uid
                 WHERE tu.Id = ".$_REQUEST['id']." GROUP BY tbp.pid";
$arrData = $objModule->getAll($strSql);
	?>
    <div class="tab-pane" id="tab_4">
      <div class="row-fluid">
        <div class="span12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          
          <div class="portlet box green">
            <div class="portlet-title">
              <div class="caption"><i class="icon-globe"></i>Payment</div>
            </div>
            <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                <thead>
                    <tr>
                        <th style="display:none"></th>
                        <th>#</th>
                        <th>Post</th>
                        <th>Tutor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
			  <?php 	
              if(count($arrData)!=0) 
				{ 
				 foreach($arrData as $intKey=>$strValue):?>
                    <tr class="odd gradeX">
                        <td style="display:none"></td>
                        <td><?php echo ($intKey+1);?></td>
                        <td><?php echo $strValue['title'];?></td>
                        <td><?php echo $strValue['Username'];?></td>
                        <td><?php echo $strValue['Bid_amt'];?></td>
<?php /* ?>                                 <td><?php echo date("d M Y",strtotime($strValue['create_at']));?></td><?php */ ?>
                        <td><?php echo $strValue['p_status'];?></td>
                        <td>
                            <a href="payment_detail.php?id=<?php echo $strValue['pid'];?>" class="btn mini purple"><i class="icon-edit"></i> Detail</a>
                        </td>                                        
                    </tr>
               <?php endforeach;
                    
                }
                else
                { ?>
                  <tr >
                    <Td colspan=5>No Posts for this User </Td>
                    <?php }
							?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Tab 4 -->
    <?php 
    $bidding="select * from tbl_bidding where Uid = '".$_GET['id']."' order by Id";
	$db_bidding=$objData->getAll($bidding);
	$count1 = count($db_bidding);
	?> 
    <div class="tab-pane" id="tab_3">
      <div class="row-fluid">
        <div class="span12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          
          <div class="portlet box green">
            <div class="portlet-title">
              <div class="caption"><i class="icon-globe"></i>List Bids</div>
            </div>
            <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                <thead>
                  <tr>
                    <th style="display:none"></th>
                    <th width="25px">#</th>
                    
                    <th>Post name</th>
                    <th>Bidding Amount</th>
                    <th>Bidding Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
						
							if($count1!=0) 
							{ 
							
							for($i=0;$i<count($db_bidding);$i++){?>
                  <tr class="odd gradeX">
                    <td style="display:none"></td>
                    <td><?php echo ($i+1);?></td>
                    
                     <td><?php $From_user =  $db_bidding[$i]['Post_id'];
					 echo $from_user_name = getName("tbl_post","title","id",$From_user);
					  ?></td>
                    <td><?php echo $db_bidding[$i]['Bid_amt'];?></td>
                    <td><?php echo date('d M Y H:m:s',strtotime($db_bidding[$i]['Create_date_time'])); ?></td>
                  </tr>
                  <?php }
								
							}
							else
							{ ?>
                  <tr >
                    <Td colspan=5>No Bidding for this User </Td>
                    <?php }
							?>
                </tbody>
              </table>
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
