<?php
//  Buyer Account
$sql="select * from tbl_post where uid = '".$_GET['id']."' ";
$ans=$objData->getAll($sql);
$count = count($ans);
function time_diff($date1, $date2) {
    $dateF = new DateTime($date1);
    $dateL = new DateTime($date2);
    $interval = $dateF->diff($dateL);
    $years = $interval->y;
    $days = $interval->d;
    $hours = $interval->h;
    $mins = $interval->i;
    $sec = $interval->s;
    $diff = abs(strtotime($date2) - strtotime($date1));
    $weeks = floor($diff / 604800);
    $str = '';
    if ($years > 0) {
        $str = chk_gtr2($years, 'year');
    } else if ($weeks > 0) {
        $str = chk_gtr2($weeks, 'week');
    } else if ($days > 0) {
        $str = chk_gtr2($days, 'day');
    } else if ($hours > 0) {
        $str = chk_gtr2($hours, 'hour');
    } else if ($mins > 0) {
        $str = chk_gtr2($mins, 'minute');
    } else if ($sec > 0) {
        $str = chk_gtr2($sec, 'second');
    } else {
        $str = "1second remaining";
    }
    return $str;
}

function chk_gtr2($count, $attr) {
    if ($count > 1) {
        return $count . ' ' . $attr . 's remaining';
    } else {
        return $count . ' ' . $attr . ' remaining';
    }
}
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
	echo "<script> window.location.href = 'list_users.php' </script>";	
}
if(isset($_POST['submit']))
{	
	$date = date('Y/m/d');	
	if($_POST['usertype']=='1')
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
	}
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
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../upload/user_profile',$_FILES['file']['name']);
           
		   	list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);				
				if($width > 300 && $height > 300)
				{
					$objImg = new SimpleImage();
					$objImg->load($_FILES['file']['tmp_name']);
					$objImg->resize(300,300);
					$objImg->save('../upload/user_profile/profile_200/'.$strFile);
					unset($objImg);
					unset($_FILES['file']['tmp_name']);
					//move_uploaded_file($_FILES['image']['tmp_name'],"uploads/users/".$strFile);
				}
				else
				{
					move_uploaded_file($_FILES['file']['tmp_name'],"../upload/user_profile/".$strFile);
					//move_uploaded_file($_FILES['image']['tmp_name'],"uploads/users/thumb/".$strFile);
				}
			}
 	 	$objData->setTableDetails("tbl_users", "Id");
		$objData->setFieldValues("Name", $_REQUEST['name']);
        $objData->setFieldValues("Email", $_REQUEST['email']);
		$objData->setFieldValues("Password", md5($_POST['password']));
		$objData->setFieldValues("Photo",$strFile);
		$objData->setFieldValues("Status", $_REQUEST['drpStatus']);
		$objData->setFieldValues("Zipcode", $_REQUEST['Zipcode']);
		$objData->setFieldValues("Country", $country_id);
		$objData->setFieldValues("State", $_REQUEST['drpState']);
		$objData->setFieldValues("City", $_REQUEST['city']);
		$objData->setFieldValues("User_type", $_REQUEST['usertype']);
		$objData->setFieldValues("Website", $_REQUEST['website']);
		$objData->setFieldValues("Card_number", $_REQUEST['cnumber']);
		$objData->setFieldValues("CCV_number", $_REQUEST['ccv_number']);
		$objData->setFieldValues("Expiry_date", date('Y/m/d',strtotime($_POST['edate'])));
		$objData->setFieldValues("Contact_no", $_REQUEST['mobile_no']);
		$objData->setFieldValues("Creation_date", $date);
		$objData->setFieldValues("Current_credit", $current_credit);
		$objData->setFieldValues("Latitude", $lat);
		$objData->setFieldValues("Longitude", $lng);
		$objData->setFieldValues("Is_student", $is_student);
		$objData->setFieldValues("banner_image", $banner_image);
		$insert_data = $objData->insert();
		//$inserted_id =  mysql_insert_id($insert_data);	
		//$inserted_id = $objData->intLastInsertedId;
	echo "<script>window.location='list_users.php'</script>";
}
if(isset($_POST['update']))
{    
	if($_POST['usertype']=='1')
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
	}
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
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','../upload/user_profile',$_FILES['file']['name']);
            list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);
				if($width > 300 && $height > 300)
				{
				$objImg = new SimpleImage();
				$objImg->load($_FILES['file']['tmp_name']);
				$objImg->resize(300,300);
				$objImg->save('../upload/user_profile/profile_200/'.$strFile);
				unset($objImg);
				unset($_FILES['file']['tmp_name']);
				//move_uploaded_file($_FILES['image']['tmp_name'],"uploads/users/".$strFile);
				}
				else
				{
				move_uploaded_file($_FILES['file']['tmp_name'],"../upload/user_profile/".$strFile);
				//move_uploaded_file($_FILES['image']['tmp_name'],"uploads/users/thumb/".$strFile);
				}
			}else{
				$strFile = $_REQUEST['hdnImage'];
			}
	
		$objData->setTableDetails("tbl_users", "Id");
		$objData->setFieldValues("Name", $_REQUEST['name']);
     	$objData->setFieldValues("Photo",$strFile);
		$objData->setFieldValues("Status", $_REQUEST['drpStatus']);
		$objData->setFieldValues("Zipcode", $_REQUEST['Zipcode']);
		$objData->setFieldValues("Country", $country_id);
		$objData->setFieldValues("State", $_REQUEST['drpState']);
		$objData->setFieldValues("City", $_REQUEST['city']);
		$objData->setFieldValues("User_type", $_REQUEST['usertype']);
		$objData->setFieldValues("Website", $_REQUEST['website']);
		$objData->setFieldValues("Card_number", $_REQUEST['cnumber']);
		$objData->setFieldValues("CCV_number", $_REQUEST['ccv_number']);
		$objData->setFieldValues("Expiry_date", date('Y/m/d',strtotime($_POST['edate'])));
		$objData->setFieldValues("Contact_no", $_REQUEST['mobile_no']);
		$objData->setFieldValues("Creation_date", $date);
		$objData->setFieldValues("Current_credit", $current_credit);
		$objData->setFieldValues("Latitude", $lat);
		$objData->setFieldValues("Longitude", $lng);
		$objData->setFieldValues("Is_student", $is_student);
		$objData->setFieldValues("banner_image", $banner_image);
		
			$objData->setWhere("Id = '".$_GET['id']."'");
		 	$objData->update();
			echo "<script>window.location='list_users.php' </script>";
		
}
if(isset($_REQUEST['btneditprof'])){
	$objData =  new PCGData();
    $objData->setTableDetails("tbl_users","Id");
    $objData->setFieldValues("fname",$_POST['txtFName']);
    $objData->setFieldValues("lname",$_POST['txtLName']);
    $objData->setFieldValues("description",stripslashes($_POST['txtDescription']));
    $objData->setFieldValues("State",$_POST['txtState']);
    $objData->setFieldValues("City",$_POST['txtCity']);
    $objData->setFieldValues("Zipcode",$_POST['txtZip']);
    $objData->setFieldValues("Country",$_POST['cmbCountry']);
    $objData->setFieldValues("Contact_no",$_POST['Phone']);
    $objData->setWhere("Id = '".$_POST['hdnid']."'");
    $objData->update();
    unset($objData);
    $objModule->redirect("./buyer_list.php");
}
if($_REQUEST['btnsubmit']){
	/*echo "<pre>";
	print_r($_REQUEST);
	print_r($_FILES);
	exit;*/
	$objData =  new PCGData();
    $objData->setTableDetails("tbl_users","Id");
	if($_FILES['txtFile']['name']!='')
    {
       $strEx           = pathinfo($_FILES['txtFile']['name'],PATHINFO_EXTENSION);
       $strFilename     = uniqid().".".$strEx;
       move_uploaded_file($_FILES['txtFile']['tmp_name'],"../upload/user/".$strFilename);
       $objData->setFieldValues("Photo",$strFilename);
       if($_POST['hdnFile']!='')
       {
           $strDel = "../upload/user/".$_POST['hdnFile'];
           unlink($strDel);
       }
    }
	$objData->setWhere("Id = '".$_POST['hdnid']."' ");
    $objData->update();
    unset($objData);
	$objModule->redirect("./buyer_list.php");
}
$sql_member = "SELECT u.*,c.Name from tbl_users as u LEFT JOIN tbl_country as c  ON  c.Id=u.Country where u.Id = '".$_GET['id']."' AND u.User_type='1'";
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
     <!-- END BEGIN STYLE CUSTOMIZER -->
    <h3 class="page-title"> Users </h3>
    <ul class="breadcrumb">
      <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
      <li> <a href="tutor_list.php">List Users</a> <span class="icon-angle-right"></span> </li>
      <li><a href="#">Users</a></li>
    </ul>
  </div>
</div>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid profile">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1_1" data-toggle="tab">Overview</a></li>
                <li><a href="#tab_1_2" data-toggle="tab">Profile Info</a></li>
                <li><a href="#tab_1_3" data-toggle="tab">Account</a></li>
                 <li><a href="#tab_1_5" data-toggle="tab">Review</a></li>
                 <?php /* ?><li><a href="#tab_1_4" data-toggle="tab">Projects</a></li>
               
                <li><a href="#tab_1_6" data-toggle="tab">Help</a></li><?php */ ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane row-fluid active" id="tab_1_1">
                    <ul class="unstyled profile-nav span3">
                        <li>
                        <?php if($db_member[0]['Photo'] != "" && file_exists("../upload/user/".$db_member[0]['Photo'])):?>
                        <img src="<?php echo "../upload/user/".$db_member[0]['Photo'];?>" alt="" /> <?php /*<a href="view_user.php?id=<?php echo $_REQUEST['id']."#tab_2-2";?>" class="profile-edit">edit</a><?php */ ?>
                        <?php else: ?>
                        <img src="../upload/user/default.png" alt="" style="width: 188px;"/>
                        <?php /* ?><img src="assets/img/profile/profile-img.png" alt="" /> <a href="view_user.php?id=<?php echo $_REQUEST['id']."&#tab_2-2"; ?>" class="profile-edit">edit</a><?php */ ?>
                        <?php endif; ?>
                        </li>
                        <?php /* ?>
						<li><a href="#">Projects</a></li>
                        <li><a href="#">Messages <span>3</span></a></li>
                        <li><a href="#">Friends</a></li>
                        <li><a href="#">Settings</a></li>
						<?php */ ?>
                    </ul>
                    <div class="span9">
                        <div class="row-fluid">
                            <div class="span8 profile-info">
                                <h1><?php echo ucfirst($db_member[0]['fname'])." ".ucfirst($db_member[0]['lname']); ?></h1>
                                <p><?php echo stripcslashes($db_member[0]['description']); ?></p>
                                <?php /*<p><a href="#">www.mywebsite.com</a></p> */ ?>
                                <ul class="unstyled inline">
                                    <li><i class="icon-map-marker"></i> <?php echo $db_member[0]['Name']; ?></li>
                                    <li><i class="icon-calendar"></i> <?php echo date("d M Y",strtotime($db_member[0]['Creation_date']));  ?></li>
                                    <?php /*<li><i class="icon-briefcase"></i> Design</li> */ ?>
                                    <li>
                                    <?php
									 ///// To find the average Rating of User ////////////////
									 $ratings =0;
									 $flag=0;
									 $sql_r = "select * from tbl_reviews where review_to=".$_REQUEST['id'];
									 $result_r = $objData->getAll($sql_r);
									 $count = count($result_r);
									 foreach ($result_r as $data)
									 {
										$ratings = $ratings + $data['review_rate'];
									 }
									 
								     $finalratings = round($ratings / $count,2);
									 ?>
                                      <li><i class="icon-star"></i> <?php echo $finalratings ?></li>
									<?php /* if (strpos( $finalratings, '.' ) === 1 )
									 			$flag=1;
									 else
									 			$flag=0;		
									 if($finalratings >0) 
									 {
											 $j=1;
											 
											 for($j=1;$j<=$finalratings;$j++)
											 {
													echo "<img src=images/star2.gif>";	 
											 }
											
											 if($flag==1)
											 {
												  echo "<img src=images/star3.gif>";	
												  for($k=$finalratings;$j<5;$j++)
													 {
															echo "<img src=images/star1.gif>";	 
													 }
											 }
											 
											 if($flag==0)
											 {
													
												  for($k=$finalratings;$j<=5;$j++)
													 {
															echo "<img src=images/star1.gif>";	 
													 }
											 }
									 }
									 else
									 {
										
										 $z=1;
											 for($z=1;$z<=5;$z++)
											 {
													echo "<img src=images/star1.gif>";	 
											 } 
									  }
									 
                                     </li> */ ?>
                                    <?php /*<li><i class="icon-heart"></i> BASE Jumping</li> */ ?>
                                </ul>
                            </div>
                            <!--end span8-->
                            <div class="span4">
                                <div class="portlet sale-summary">
                                    <div class="portlet-title">
                                        <div class="caption">Stastistics</div>
                                        <div class="tools">
                                           <?php /* <a class="reload" href="javascript:;"></a> */ ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <ul class="unstyled">
                                            <li>
                            <span class="sale-info">CURRENT MONTH BIDS <?php /*<i class="icon-img-up"></i> */ ?></span>
                            <span class="sale-num"><?php
		                    $sel_mpost = $objData->getAll("SELECT count(*) as cnt FROM tbl_bidding WHERE Uid=".$_REQUEST['id']." AND MONTH(create_at)=MONTH(CURRENT_DATE())");
                            echo $sel_mpost[0]['cnt']; ?></span>
                                            </li>
                                            <li>
                                                <span class="sale-info">CURRENT MONTH AWARDED <?php /*<i class="icon-img-down"></i> */ ?></span> 
                                                <span class="sale-num"><?php
                            $sel_mpost = $objData->getAll("SELECT count(*) as cnt1 FROM tbl_bidding WHERE Uid=".$_REQUEST['id']." AND MONTH(create_at)=MONTH(CURRENT_DATE()) AND status='3'");
                            echo $sel_mpost[0]['cnt1']; ?></span>
                                            </li>
                                            <li>
                                                <?php
                                                    $arrAwa =   $objModule->getAll("select count(id) as tcnt  from tbl_post where win_uid = '".$_REQUEST['id']."' ");
                                                    $arrEar =   $objModule->getAll("select sum(amount) as amt  from tbl_tutor_pay where uid = '".$_REQUEST['id']."' ");
                                                ?>
                                                <span class="sale-info">TOTAL AWARDED</span> 
                                                <span class="sale-num"><?php echo $arrAwa[0]['tcnt'];?></span>
                                            </li>
                                            <li>
                                                <span class="sale-info">EARNS</span> 
                                                <span class="sale-num">$<?php echo round($arrEar[0]['amt'],2); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end span4-->
                        </div>
                        <!--end row-fluid-->
                        <div class="tabbable tabbable-custom tabbable-custom-profile">
                            <ul class="nav nav-tabs">
                            <?php 
							$sqlpost = "SELECT p.title,p.id,b.*,CASE b.status WHEN '0' THEN 'Decline' WHEN '1' THEN 'Running' ELSE 'Closed' END AS  sts FROM tbl_bidding as b INNER JOIN tbl_post as p ON b.Post_id=p.id WHERE b.Uid =".$_REQUEST['id']." ORDER BY b.Id DESC LIMIT 5";
							$ans_post=$objModule->getAll($sqlpost);
							/*?>
                                <li class="active"><a href="#tab_1_11" data-toggle="tab">Total <?php echo count($ans_post);  ?> Bids</a></li>
                               <?php *//* ?> <li><a href="#tab_1_22" data-toggle="tab">Feeds</a></li><?php */ ?>
                               <li class="active"><a href="#tab_1_11" data-toggle="tab">Latest Bids</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_11">
                                    <div class="portlet-body" style="display: block;">
                                        <table class="table table-striped table-bordered table-advance table-hover">
                                            <thead>
                                            <tr>
                                            <th><i class="icon-briefcase"></i> Title</th>
                                            <th class="hidden-phone"><i class="icon-question-sign"></i> Status</th>
                                            <th><i class="icon-bookmark"></i> Bid Amount</th>
                                            <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
												if(count($ans_post)>0){
												foreach($ans_post as $key=> $vpost):
											?>
                                                <tr>
                                                    <td><a href="javascript:;"><?php echo $vpost['title']; ?></a></td>
                                                    <td class="hidden-phone"><?php echo $vpost['sts']; ?></td>
                                                    <td><?php echo $vpost['Bid_amt']; ?>$ <?php /*<span class="label label-success label-mini">Paid</span> */ ?></td>
                                                    <td><a class="btn mini green-stripe" href="add_new_post.php?id=<?php echo $vpost['id']; ?>">View</a></td>
                                                </tr>
                                            <?php endforeach;
											}else{ ?>
												<tr>
                                                    <td colspan="4">No post found.</td>
                                                </tr>
											<?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--tab-pane-->
                               <?php /* ?> <div class="tab-pane" id="tab_1_22">
                                    <div class="tab-pane active" id="tab_1_1_1">
                                        <div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
                                            <ul class="feeds">
                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-success">                        
                                                                    <i class="icon-bell"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc">
                                                                    You have 4 pending tasks.
                                                                    <span class="label label-important label-mini">
                                                                    Take action 
                                                                    <i class="icon-share-alt"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date">
                                                            Just now
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-info">                        
                                                                    <i class="icon-bullhorn"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc">
                                                                    New order received. Please take care of it.                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date">
                                                            22 hours
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php */ ?>
                                <!--tab-pane-->
                            </div>
                        </div>
                    </div>
                    <!--end span9-->
                </div>
                <!--end tab-pane-->
                <div class="tab-pane profile-classic row-fluid" id="tab_1_2">
                   <?php /* ?> <div class="span2"><img src="assets/img/profile/profile-img.png" alt="" /> <a href="javascript:;" class="profile-edit">edit</a></div><?php */ ?>
                    <ul class="unstyled span10">
                        <li><span>User Name:</span> <?php if($db_member[0]['Username'] != ""): echo $db_member[0]['Username']; else: echo "----"; endif;?></li>
                        <li><span>First Name:</span> <?php if($db_member[0]['fname'] != ""): echo ucfirst($db_member[0]['fname']); else: echo "----"; endif; ?></li>
                        <li><span>Last Name:</span> <?php if($db_member[0]['lname'] != ""): echo ucfirst($db_member[0]['lname']); else: echo "----"; endif; ?></li>
                        <li><span>Counrty:</span> <?php if($db_member[0]['Name'] != ""): echo $db_member[0]['Name']; else: echo "----"; endif; ?></li>
                        <?php /*<li><span>Birthday:</span> <?php if($db_member[0]['Creation_date'] != ""): echo date("d M Y",$db_member[0]['Creation_date']); else: echo "----"; endif; ?></li> */ ?>
                        <li><span>Email:</span> <a href="javascript:;"> <?php if($db_member[0]['Email'] != ""): echo $db_member[0]['Email']; else: echo "----"; endif; ?></a></li>
                        <li><span>Skills:</span> <?php 
						$skl_db = $objData->getAll("SELECT * FROM tbl_skills WHERE sk_id IN(".$db_member[0]['skills'].")");
						 if(count($skl_db)>0):
						  foreach($skl_db as $key=>  $val):
						  if($key != 0){ echo ", ";}
						  echo ucfirst($val['sk_name']);
						  endforeach;
						  else:
						  echo "----";
						  endif;
						?></li>
                        <?php /* <li><span>Website Url:</span> <a href="#">http://www.mywebsite.com</a></li> */ ?>
                        <li><span>Contact Number:</span> <?php if($db_member[0]['Contact_no'] != ""): echo $db_member[0]['Contact_no']; else: echo "----"; endif; ?></li>
                        <li><span>About:</span> <?php if($db_member[0]['description'] != ""): echo stripslashes($db_member[0]['description']);  else: echo "----"; endif; ?></li>
                    </ul>
                </div>
                <!--tab_1_2-->
                <div class="tab-pane row-fluid profile-account" id="tab_1_3">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="span3">
                                <ul class="ver-inline-menu tabbable margin-bottom-10">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab_1-1">
                                        <i class="icon-cog"></i> 
                                        Personal info
                                        </a> 
                                        <span class="after"></span>                                    
                                    </li>
                                <li><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Change Avatar</a></li>
                               <?php /* <li><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Change Password</a></li>
                                <li><a data-toggle="tab" href="#tab_4-4"><i class="icon-eye-open"></i> Privacity Settings</a></li> */?>
                                </ul>
                            </div>
                            <div class="span9">
                                <div class="tab-content">
                                    <div id="tab_1-1" class="tab-pane active">
                                        <div style="height: auto;" id="accordion1-1" class="accordion collapse">
                                            <form action="" method="post">
                                            <input type="hidden" name="hdnid" id="hdnid" value="<?php echo $_REQUEST['id']; ?>" />
                                                <label class="control-label">First Name</label>
                                                <input type="text" placeholder="First Name" class="m-wrap span8" name="txtFName" value="<?php echo $db_member[0]['fname']; ?>"/>
                                                <label class="control-label">Last Name</label>
                                                <input type="text" placeholder="Last Name" name="txtLName" class="m-wrap span8" value="<?php echo $db_member[0]['lname']; ?>" />
                                                <label class="control-label">Contact Number</label>
                                                <input type="text" placeholder="Contact Number" name="Phone" class="m-wrap span8" value="<?php echo $db_member[0]['Contact_no']; ?>" />
                                                <?php /*<label class="control-label">Skills</label>
                                                <input type="text" placeholder="Skills" class="m-wrap span8" /> */ ?>
                                                <label class="control-label">Counrty</label>
                                                <div class="controls">
                                                <select class="span8 m-wrap" name="cmbCountry" id="drpCountry" >
                                                 <option value="">---Select---</option>
												  <?php 
												  $currency = "select * from tbl_country";
			  									  $db_currency = $objData->getAll($currency);
												  for($i=0;$i<count($db_currency);$i++){ ?>
                                                  <option value="<?php echo $db_currency[$i]['Id']."_".$db_currency[$i]['curr_code']; ?>"<?php if($db_currency[$i]['Id'] == $db_member[0]['Country']){ ?> selected="selected"<?php } ?>><?php echo $db_currency[$i]['Name']; ?></option>
                                                  <?php } ?>
                                                  </select>
                                                </div>
                                                <label class="control-label">State</label>
                                                <input type="text" placeholder="State" name="txtState" class="m-wrap span8" value="<?php echo $db_member[0]['State']; ?>" />
                                                <label class="control-label">City</label>
                                                <input type="text" placeholder="City" name="txtCity" class="m-wrap span8" value="<?php echo $db_member[0]['City']; ?>" />
                                                <label class="control-label">Zipcode</label>
                                                <input type="text" placeholder="Zipcode" class="m-wrap span8" value="<?php echo $db_member[0]['Zipcode']; ?>" />
                                                <label class="control-label">About</label>
                                                <textarea class="span12 ckeditor m-wrap" name="txtDescription" rows="3"><?php echo stripslashes($db_member[0]['description']);  ?></textarea>
                                                
                                                <div class="submit-btn">
                                                	<input type="submit" name="btneditprof" id="submit" value="Save Changes" class="btn green" />
                                                   <?php /* <a href="#" class="btn green">Save Changes</a>
                                                    <a href="#" class="btn">Cancel</a> */ ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="tab_2-2" class="tab-pane">
                                        <div style="height: auto;" id="accordion2-2" class="accordion collapse">
                                            <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="hdnid" id="hdnid" value="<?php echo $_REQUEST['id']; ?>" />
                                               
                                                <br/>
                                                <div class="controls">
                                                    <div class="thumbnail" style="width: 225px; height: 170px;">
                                                     <?php if(file_exists("../upload/user/".$db_member[0]['Photo']) && $db_member[0]['Photo']!=''):?>
                                                      <img src="<?php echo "../upload/user/".$db_member[0]['Photo']; ?>" alt=""   />
                                                     <?php else: ?>
                       <img src="http://www.placehold.it/291x170/EFEFEF/AAAAAA&amp;text=no+image" alt=""  />
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="space10"></div>
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input">
                                                            <i class="icon-file fileupload-exists"></i> 
                                                            <span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="txtFile" />
                                                        <input type="hidden" value="<?php echo $db_member[0]['Photo'];?>" name="hdnFile" /> 
                                                        </span>
                                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="controls">
                                                    <?php /*<span class="label label-important">NOTE!</span>
                                                    <span>You can write some information here..</span> */ ?>
                                                </div>
                                                <div class="space10"></div>
                                                <div class="submit-btn">
                                                	<input type="submit" name="btnsubmit"  class="btn green" value="Submit" id="btnsubmit" />
                                                    <?php /* <a href="#" class="btn green">Submit</a>
                                                    <a href="#" class="btn">Cancel</a> */ ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="tab_3-3" class="tab-pane">
                                        <div style="height: auto;" id="accordion3-3" class="accordion collapse">
                                            <form action="#">
                                                <label class="control-label">Current Password</label>
                                                <input type="password" class="m-wrap span8" />
                                                <label class="control-label">New Password</label>
                                                <input type="password" class="m-wrap span8" />
                                                <label class="control-label">Re-type New Password</label>
                                                <input type="password" class="m-wrap span8" />
                                                <div class="submit-btn">
                                                    <a href="#" class="btn green">Change Password</a>
                                                    <a href="#" class="btn">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="tab_4-4" class="tab-pane">
                                        <div style="height: auto;" id="accordion4-4" class="accordion collapse">
                                            <form action="#">
                                                <div class="profile-settings row-fluid">
                                                    <div class="span9">
                                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..</p>
                                                    </div>
                                                    <div class="control-group span3">
                                                        <div class="controls">
                                                            <label class="radio">
                                                            <input type="radio" name="optionsRadios1" value="option1" />
                                                            Yes
                                                            </label>
                                                            <label class="radio">
                                                            <input type="radio" name="optionsRadios1" value="option2" checked />
                                                            No
                                                            </label>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end profile-settings-->
                                                <div class="profile-settings row-fluid">
                                                    <div class="span9">
                                                        <p>Enim eiusmod high life accusamus terry richardson ad squid wolf moon</p>
                                                    </div>
                                                    <div class="control-group span3">
                                                        <div class="controls">
                                                            <label class="checkbox">
                                                            <input type="checkbox" value="" /> All</label>
                                                            <label class="checkbox">
                                                            <input type="checkbox" value="" /> Friends </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end profile-settings-->
                                                <div class="profile-settings row-fluid">
                                                    <div class="span9">
                                                        <p>Pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson</p>
                                                    </div>
                                                    <div class="control-group span3">
                                                        <div class="controls">
                                                            <label class="checkbox">
                                                            <input type="checkbox" value="" /> Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end profile-settings-->
                                                <div class="profile-settings row-fluid">
                                                    <div class="span9">
                                                        <p>Cliche reprehenderit enim eiusmod high life accusamus terry</p>
                                                    </div>
                                                    <div class="control-group span3">
                                                        <div class="controls">
                                                            <label class="checkbox">
                                                            <input type="checkbox" value="" /> Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end profile-settings-->
                                                <div class="profile-settings row-fluid">
                                                    <div class="span9">
                                                        <p>Oiusmod high life accusamus terry richardson ad squid wolf fwopo</p>
                                                    </div>
                                                    <div class="control-group span3">
                                                        <div class="controls">
                                                            <label class="checkbox">
                                                            <input type="checkbox" value="" /> Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end profile-settings-->
                                                <div class="space5"></div>
                                                <div class="submit-btn">
                                                    <a href="#" class="btn green">Save Changes</a>
                                                    <a href="#" class="btn">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end span9-->                                   
                        </div>
                    </div>
                </div>
                <!--end tab-pane-->
                <div class="tab-pane" id="tab_1_4">
                    <?php /* ?><div class="row-fluid add-portfolio">
                        <div class="pull-left">
                            <span>502 Items sold this week</span>
                        </div>
                        <div class="pull-left">
                            <a href="#" class="btn icn-only green">Add a new Project <i class="m-icon-swapright m-icon-white"></i></a>                          
                        </div>
                    </div><?php */ ?>
                    <?php 
						$sel_post = $objData->getAll("SELECT * FROM tbl_post WHERE uid=".$_REQUEST['id']."");
						if(count($sel_post)>0){
						foreach($sel_post as $key=> $valps):
					?>
                    <!--end add-portfolio-->
                    <div class="row-fluid portfolio-block">
                        <div class="span5 portfolio-text">
                            <div class="portfolio-text-info">
                                <h4><?php echo $valps['title']; ?></h4>
                                <p><?php 
								//echo substr($valps['description'],0,120);
								//trim message to 100 characters, regardless of where it cuts off
								$cnt = strlen($valps['description']);
								$msgTrimmed = mb_substr($valps['description'],0,50);
								//find the index of the last space in the trimmed message
								if($cnt > 50){
								$lastSpace = strrpos($msgTrimmed, ' ', 0);
								//now trim the message at the last space so we don't cut it off in the middle of a word
								$s = mb_substr($msgTrimmed,0,$lastSpace);
								//if($cnt > 120){
								echo $s .= "... <a href='add_new_post.php?id=".$valps['id']."'>More</a>";
								}else{
									echo $msgTrimmed;
								}
								?></p>
                            </div>
                        </div>
                        <div class="span5" style="overflow:hidden;">
                            <div class="portfolio-info">
                                Price
                                <span><?php echo $valps['price']; ?></span>
                            </div>
                            <div class="portfolio-info">
                                Total Bids
                                <span><?php 
$sel_bids = $objData->getAll("SELECT Count(Id) as cid  FROM tbl_bidding WHERE Post_id=".$valps['id']."");
								echo $sel_bids[0]['cid']; ?></span>
                            </div>
                            <div class="portfolio-info">
                                Days end in
                                <span><?php 
								echo time_diff($valps['end_date_time'], date('Y-m-d H:i:s'));
								//echo date("d M Y",strtotime($valps['end_date_time'])); ?></span>
                            </div>
                        </div>
                        <div class="span2 portfolio-btn">
                            <a href="add_new_post.php?id=<?php echo $valps['id']; ?>" class="btn bigicn-only"><span>Manage</span></a>                      
                        </div>
                    </div>
                    <!--end row-fluid-->
                    <?php endforeach;
						}else{?>
                    	<div class="portfolio-info">
                               No project found.
                            </div>
                    
                    <?php } ?>
                </div>
                <!--end tab-pane-->
                <div class="tab-pane" id="tab_1_5">
                    <?php 
						$sel_post = $objData->getAll("SELECT r.*,u.fname,u.lname FROM tbl_reviews AS r LEFT JOIN tbl_users AS u ON u.Id=r.review_from WHERE review_to=".$_REQUEST['id']." ");
						
						if(count($sel_post)>0){
						foreach($sel_post as $key=> $valps):
					?>
                    <!--end add-portfolio-->
                    <div class="row-fluid portfolio-block">
                        <div class="span5 portfolio-text">
                            <div class="portfolio-text-info">
                                <h4><?php echo ucfirst($valps['fname'])." ".ucfirst($valps['lname']); ?></h4>
                                <p><?php
								echo $valps['review_desc']; 
								//echo substr($valps['description'],0,120);
								//trim message to 100 characters, regardless of where it cuts off
								//$cnt = strlen($valps['review_desc']);
								//$msgTrimmed = mb_substr($valps['review_desc'],0,50);
								//find the index of the last space in the trimmed message
								//if($cnt > 50){
								//$lastSpace = strrpos($msgTrimmed, ' ', 0);
								//now trim the message at the last space so we don't cut it off in the middle of a word
								//$s = mb_substr($msgTrimmed,0,$lastSpace);
								//if($cnt > 120){
								//echo $s .= "... <a href='add_new_post.php?id=".$valps['id']."'>More</a>";
								//}else{
								//	echo $msgTrimmed;
								//}
								?></p>
                            </div>
                        </div>
                  		<div class="span5" style="overflow:hidden;">
                         <?php /* ?>   <div class="portfolio-info">
                            Price 
                                <span><?php echo $valps['price']; ?></span>
                            </div>
                            <div class="portfolio-info">
                                Total Bids 
                                <span><?php 
$sel_bids = $objData->getAll("SELECT Count(Id) as cid  FROM tbl_bidding WHERE Post_id=".$valps['id']."");
								echo $sel_bids[0]['cid']; ?></span>
                            </div><?php */ ?>
                            <div class="portfolio-info">
                                Review Date 
                                <span><?php 
								//echo time_diff($valps['review_date'], date('Y-m-d H:i:s'));
								echo date("d M Y",strtotime($valps['review_date'])); ?></span>
                            </div>
                        </div>
                        <?php /* ?>  <div class="span2 portfolio-btn">
                            <a href="add_new_post.php?id=<?php echo $valps['id']; ?>" class="btn bigicn-only"><span>Manage</span></a>                      
                        </div><?php */ ?>
                    </div> 
                    <!--end row-fluid-->
                    <?php endforeach;
						}else{?>
                    	<div class="portfolio-info">
                               No Review found.
                            </div>
                    
                    <?php } ?>
                </div>
                <!--end tab-pane-->
                <div class="tab-pane row-fluid" id="tab_1_6">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="span3">
                                <ul class="ver-inline-menu tabbable margin-bottom-10">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab_1">
                                        <i class="icon-briefcase"></i> 
                                        General Questions
                                        </a> 
                                        <span class="after"></span>                                    
                                    </li>
                                    <li><a data-toggle="tab" href="#tab_2"><i class="icon-group"></i> Membership</a></li>
                                    <li><a data-toggle="tab" href="#tab_3"><i class="icon-leaf"></i> Terms Of Service</a></li>
                                    <li><a data-toggle="tab" href="#tab_1"><i class="icon-info-sign"></i> License Terms</a></li>
                                    <li><a data-toggle="tab" href="#tab_2"><i class="icon-tint"></i> Payment Rules</a></li>
                                    <li><a data-toggle="tab" href="#tab_3"><i class="icon-plus"></i> Other Questions</a></li>
                                </ul>
                            </div>                             
                        </div>
                    </div>
                </div>
                <!--end tab-pane-->
            </div>
        </div>
        <!--END TABS-->
    </div>
    </div>
    <!-- END PAGE CONTENT-->
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
