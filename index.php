<?php include('includes/header.inc.php');
if($_POST['btnSearch'] != ''){
	$search = "AND (c.Cname LIKE '%".$_POST['searchval']."%' OR u.unitname LIKE '%".$_POST['searchval']."%')";
}
if($_POST['btnsearchstate'] != ''){
	$search = "AND (tbl_state.state_name LIKE '%".$_POST['searchval']."%' OR c.Caddress LIKE '%".$_POST['searchval']."%')";
}
if($_POST['btnSearchAccessibility'] != ''){
	
	$search = "AND u.unit_access='".$_POST['unit_access_search']."'";
}

if($_POST['btnSearchrsvpmode'] != ''){
	
	$search = "AND u.unit_rsvpmode='".$_POST['unit_rsvpmode']."'";
}
if($_POST['btnSearchAddress'] != ''){
	
	
	$search = "AND (u.unitaddress LIKE '%".$_POST['searchaddress']."%' OR u.unitcity LIKE '%".$_POST['searchaddress']."%' OR u.unit_zip LIKE '%".$_POST['searchaddress']."%' OR ts.state_name LIKE '%".$_POST['searchaddress']."%')";
}



if($_SESSION['Uid']!=''){
	$db_user = $objData->getAll("select * from soma_users where Uid='".$_SESSION['Uid']."'");

        $db_soma_user_cus = $objData->getAll("select group_concat(Cid) as cids from soma_user_customer where Uid='".$_SESSION['Uid']."'");
	//$db_soma_user_cus = $objData->getAll("select group_concat(uc.Cid) as cids from soma_user_customer uc left join soma_customers c on uc.Cid=c.Cid where uc.Uid='".$_SESSION['Uid']."' ".$search."");
if($db_soma_user_cus[0]['cids']!='')
{
    $arrHostsdomes=$objData->getAll("SELECT GROUP_CONCAT(Id) as huids FROM  soma_units WHERE (unit_access ='Public' or unit_access='Member') and Cus_id in(".$db_soma_user_cus[0]['cids'].") AND unitstatus =  '1'");
}
	$db_public_cus=$objData->getAll("SELECT GROUP_CONCAT(Id) as puids FROM  soma_units WHERE (unit_access ='Public' or unit_access='Member') AND unitstatus = '1'");

	if($arrHostsdomes[0]['huids']!='')
	$prefinalids=$arrHostsdomes[0]['huids'].','.$db_public_cus[0]['puids'];
	else
	$prefinalids=$db_public_cus[0]['puids'];

	$table="soma_units u left join soma_customers c on c.Cid=u.Cus_id left join tbl_state ts on ts.state_id=u.unitstate";
	$fields=array("u.*,c.Cname,c.Cimage,ts.state_name,((((acos(sin((".$db_user[0]['Ulat']."*pi()/180)) * sin((u.unitlat*pi()/180)) + cos((".$db_user[0]['Ulat']."*pi()/180)) * cos(((u.unitlat)*pi()/180)) * cos(((".$db_user[0]['Ulong']." - (u.unitlong))*pi()/180))))*180/pi())*60*1.1515)) as dis");
	$where="u.unitstatus='1' and u.unit_access!='Private' and u.Id in(".$prefinalids.") ".$search."";
	$grpby='';
	$order="dis ASC, u.Id DESC";
	$start=0;
	$db_customer1=$objData->getAll($table,$fields,$where,$grpby,$order,$start,6);
	
	//echo $objData->getSQL();
	
	
}else {
	$db_public_cus = $objData->getAll("SELECT GROUP_CONCAT(Id) as puids FROM  soma_units WHERE (unit_access ='Public' or unit_access='Member') AND unitstatus ='1'");
	$prefinalids = $db_public_cus[0]['puids'];
	$table="soma_units u left join soma_customers c on c.Cid=u.Cus_id left join tbl_state ts on ts.state_id=u.unitstate";
// 	$table="soma_units u left join tbl_state ts on ts.state_id=u.unitstate";
	$fields=array("u.*,c.Cname,c.Cimage,ts.state_name");
	$where="u.unitstatus='1' and u.Id in(".$prefinalids.") ".$search."";
	$grpby='';
	$order="u.Id DESC";
	$start=0;
	$db_customer1=$objData->getAll($table,$fields,$where,$grpby,$order,$start,6);
	
	//echo $objData->getSQL();
	
	
	
}
//echo count($db_customer1);
//echo"<pre>";print_r($db_customer1)
?>
<div class="midcont">
<div class="wrapper">
	<?php echo $objModule->getMessage(); ?>
	<h1>CHOOSE A DOME</h1>
   <?php /*?> <span class="subtitle">Over 100 locations</span><?php */?>
	<input type="hidden" id="last_limit" name="last_limit" value="6">
	<input type="hidden" id="user" name="user" value="<?php echo $_SESSION['Uid']; ?>">
	<input type="hidden" id="total_domes" name="total_domes" value="<?php echo $objData->intTotalRows; ?>">
	<?php //echo"<pre>";print_r($db_customer1);?>
    <ul class="searchlist">
		<?php
		if(count($db_customer1)>0)
		{
		foreach($db_customer1  as $dballs){
			?>
            
            
           <?php  $arrDom = $objData->getAll("select u.*,C.Cname,C.Cimage,C.Caddress,C.Ccountry,C.Czipcode from soma_units u left join soma_customers C on u.Cus_id=C.Cid where u.Id ='".$dballs['Id']."'");?>
           
          
			<li>
            	
				<?php
				if($dballs['Cimage']!='' && file_exists("uploads/cus_profile/".$dballs['Cimage']))
				{
					$img=$dballs['Cimage'];
				}
				else
				{
					$img='placeholder.jpg';
				}
				?>
                <div class="home_a_div">
                
                <!------ Home Page Image Hover and clickLogin and withoutlogin ----------------------------->
                <?php if($_SESSION['Uid']!=''){ ?>
						<?php $db_soma_customer = $objData->getAll("select group_concat(Cid) as cids from soma_user_customer where Uid='".$_SESSION['Uid']."'"); ?>
                        <?php $SpecificId = '';?>
                        <?php if($dballs['unit_access'] == 'Member'){ ?>
                            <?php $SpecificId = $dballs['Cus_id'];?>
                            <?php $seprateIds = explode(',',$db_soma_customer[0]['cids']);?>
                             <?php if(in_array($SpecificId,$seprateIds)){ ?>
                            
                                     <a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php }else{?>  href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                                <?php }else{ ?>
                                <a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="javascript:void(0);" <?php }else{?>  href="javascript:void(0);" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                                <?php } ?>                
                        <?php }else{ ?>
                        
                                 <a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php }else{?>  href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                        <?php } ?>
                    
                    <?php }else{ ?>
						   <?php if($dballs['unit_access'] == 'Member'){ ?>
                           
                                 <a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="javascript:void(0);" <?php }else{?>  href="javascript:void(0);" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                           
                           <?php }else{ ?>
                           
                                <a <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?> href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php }else{?>  href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>" <?php }else{ ?> title="Contact host via call or email to book your session for this dome" <?php } ?>  <?php } ?> >
                                <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=331&h=131&zc=1" alt="" /></a>
                            <?php } ?>
                
                <?php } ?>
               <!------ Home Page Image Hover and clickLogin and withoutlogin End----------------------------->
               
               
               
               <!------ Home Page Icon Start----------------------------->
                <?php if($_SESSION['Uid']!=''){ ?> 
                 
                  <?php if($dballs['unit_access'] == 'Member'){ ?>
                  
                  
                  	<?php $SpecificId = $dballs['Cus_id'];?>
                    <?php $seprateIds = explode(',',$db_soma_customer[0]['cids']);?>
					<?php if(in_array($SpecificId,$seprateIds)){ ?>
						<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
                            <a class="soma_tp_a" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" title=""><img src="images/ico_BookNow.png" alt=""></a>
                         <?php }else{ 
                            if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
                            <a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                           <?php } else { ?>
                               <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                            <?php } ?>    
                         <?php } ?>
                         
                    <?php }else{ ?>
                    	   
                           <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
                            <a class="soma_tp_a" href="javascript:void(0);" title=""><?php if($dballs['unit_access'] == 'Member'){ ?> <img src="images/Black-Lock.jpg" alt=""> <?php }else{ ?><img src="images/ico_BookNow.png" alt=""><?php } ?></a>
                         <?php }else{ 
                            if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
                            <a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                           <?php } else { ?>
                               <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                            <?php } ?>    
                         <?php } ?>	
                    
                    <?php } ?>
                     
                     
                  <?php }else{ ?>
                  
                     <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
                        <a class="soma_tp_a" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" title=""><?php if($dballs['unit_access'] == 'Member'){ ?> <img src="images/Black-Lock.jpg" alt=""> <?php }else{ ?><img src="images/ico_BookNow.png" alt=""><?php } ?></a>
                     <?php }else{ 
                        if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
                        <a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                       <?php } else { ?>
                           <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                        <?php } ?>    
                     <?php } ?>
                     
                  <?php } ?>
                  
                 <?php }else{ ?>
                 
                 	<?php if($dballs['unit_access'] == 'Member'){ ?>
                 		
                         <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
                            <a class="soma_tp_a" href="javascript:void(0);" title=""><?php if($dballs['unit_access'] == 'Member'){ ?> <img src="images/Black-Lock.jpg" alt=""> <?php }else{ ?><img src="images/ico_BookNow.png" alt=""><?php } ?></a>
                         <?php }else{ 
                            if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
                            <a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                           <?php } else { ?>
                               <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                            <?php } ?>    
                         <?php } ?>	
                 
                 	<?php }else{ ?>
                    
                    	 <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>
                        <a class="soma_tp_a" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>" title=""><?php if($dballs['unit_access'] == 'Member'){ ?> <img src="images/Black-Lock.jpg" alt=""> <?php }else{ ?><img src="images/ico_BookNow.png" alt=""><?php } ?></a>
                     <?php }else{ 
                        if ($arrDom[0]['unit_rsvpmsg'] != ''){ ?>
                        <a class="soma_tp_a" href="javascript:void(0);" title="<?php echo $arrDom[0]['unit_rsvpmsg']; ?>"><!--<img src="images/help.png" alt="">--></a>
                       <?php } else { ?>
                           <a class="soma_tp_a" href="javascript:void(0);" title="Contact host via call or email to book your session for this dome"><!--<img src="images/help.png" alt="">--></a>
                        <?php } ?>    
                     <?php } ?>	
                    
                    <?php } ?>
                 <?php } ?>
                 <!------ Home Page Icon End----------------------------->
                 
                 </div>
                 
					<div class="bxlcont">
						<h2><?php //echo ucfirst($dballs['Cname']); ?><?php echo ucfirst($dballs['unitname']); ?>  <span><?php echo ucfirst($dballs['unit_access']); ?></span></h2>
                        
						
						<?php
$StateData=$objData->getAll("select * from tbl_state where state_id='".$dballs['unitstate']."'");
					echo $dballs['unitaddress']; ?>, <?php echo $dballs['unitcity'].", ". $StateData[0]['state_name'];?>
					</div>
					<?php if($_SESSION['Uid']!=''){?>
						<div class="dist"><?php echo round($dballs['dis']*0.621371,2);?><span>Miles</span></div>
					<?php } ?>
				
                
                
                	 <?php if($_SESSION['Uid']!=''){ ?> 
                     
                     		 <?php if($dballs['unit_access'] == 'Member'){ ?>
								 <?php $SpecificId = $dballs['Cus_id'];?>
                                 <?php $seprateIds = explode(',',$db_soma_customer[0]['cids']);?>
                                 <?php if(in_array($SpecificId,$seprateIds)){ ?>
                                 
                                 	<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>  
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span>Book Online</span>  </a>
                              <?php }else{?>   
                                    <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span><?php echo $arrDom[0]['unit_rsvpmsg']; ?></span></a>
                                    <?php }else{ ?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span>Contact host via call or email to book your session for this dome</span> </a>
                                    <?php } ?>  
                                	<?php } ?>
                                        
                             
                             	 <?php }else{ ?>	
                             	 
                                 	<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>  
                                        <a class="hover_div" href="javascript:void(0);"><?php if($dballs['unit_access'] == 'Member'){ ?><span>Associate yourself with this Host for booking their Member only Domes</span><?php }else{ ?> <span>Book Online</span> <?php } ?> </a>
                              <?php }else{?>   
                                    <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> 
                                        <a class="hover_div" href="javascript:void(0);"><span><?php echo $arrDom[0]['unit_rsvpmsg']; ?></span></a>
                                    <?php }else{ ?> 
                                        <a class="hover_div" href="javascript:void(0);"><span>Contact host via call or email to book your session for this dome</span> </a>
                                    <?php } ?>  
                                	<?php } ?> 
                                  
                                 <?php } ?>	
                             <?php }else{ ?>
                
								 <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>  
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><?php if($dballs['unit_access'] == 'Member'){ ?><span>Associate yourself with this Host for booking their Member only Domes</span><?php }else{ ?> <span>Book Online</span> <?php } ?> </a>
                              <?php }else{?>   
                                    <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span><?php echo $arrDom[0]['unit_rsvpmsg']; ?></span></a>
                                    <?php }else{ ?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span>Contact host via call or email to book your session for this dome</span> </a>
                                    <?php } ?>  
                                <?php } ?>
                                
                             <?php } ?>   
              		
                    <?php }else{ ?>
                            
                    <?php if($dballs['unit_access'] == 'Member'){ ?>
                 		
                     	<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>  
                                        <a class="hover_div" href="javascript:void(0)"><?php if($dballs['unit_access'] == 'Member'){ ?><span>Associate yourself with this Host for booking their Member only Domes</span><?php }else{ ?> <span>Book Online</span> <?php } ?> </a>
                              <?php }else{?>   
                                    <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> 
                                        <a class="hover_div" href="javascript:void(0);"><span><?php echo $arrDom[0]['unit_rsvpmsg']; ?></span></a>
                                    <?php }else{ ?> 
                                        <a class="hover_div" href="javascript:void(0);"><span>Contact host via call or email to book your session for this dome</span> </a>
                                    <?php } ?>  
                                <?php } ?>
                 
                 	<?php }else{ ?>
                    
                    		<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp'){ ?>  
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><?php if($dballs['unit_access'] == 'Member'){ ?><span>Associate yourself with this Host for booking their Member only Domes</span><?php }else{ ?> <span>Book Online</span> <?php } ?> </a>
                              <?php }else{?>   
                                    <?php if($arrDom[0]['unit_rsvpmsg'] != ''){?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span><?php echo $arrDom[0]['unit_rsvpmsg']; ?></span></a>
                                    <?php }else{ ?> 
                                        <a class="hover_div" href="Choose_Session_Time.php?Domid=<?php echo $dballs['Id']; ?>"><span>Contact host via call or email to book your session for this dome</span> </a>
                                    <?php } ?>  
                                <?php } ?>
                        
                    
                    <?php } ?>
                            
                    
                    <?php } ?>
                
			</li>
		<?php }
		}
		else{
			echo "<h2>No Domes found</h2>";
		}
		?>
    </ul>
	<?php
	if(count($db_customer1)>6)
	{
		?>  
		<div class="clear"></div>
		<a href="javascript:void(0)" id="load_more" name="load_more">
			<img class="ldmrtxt" src="images/dwn_arrow.png">
			<img class="ldmrimg" src="images/loading1.gif">
		</a>
	<?php
	}
	?>

</div><!-- wrapper ends -->
<div class="push"></div>
</div><!-- midcont ends -->

<?php include('includes/footer.inc.php');?>
<script>
	$(document).on('click','#load_more',function(){
		//alert(66);
		var total_domes=$('#total_domes').val();
		var last_limit=$('#last_limit').val();
		//alert(last_limit);
		//alert(total_domes);
		if(last_limit>total_domes)
		{
			$('.ldmrtxt').css('display', 'none');
			$('.ldmrimg').css('display', 'inline-block');
			var total_domes=$('#total_domes').val();
			var user_id = $('#user').val();
			$.ajax({
				type: 'POST',
				url: "ajax.php",
				data: {limit: last_limit, CMD: "MORE_DOMES", Uid: user_id},
				success: function (result) {
					$('.searchlist').append(result);
					$('.ldmrtxt').css('display', 'inline-block');
					$('.ldmrimg').css('display', 'none');
					var newlimit=(parseInt(last_limit)+ parseInt(6));
					$('#last_limit').val(newlimit);
					if(newlimit>=total_domes) {
						$('#load_more').css('display','none');
					}
				}
			});
		}
		else
		{
			$('#load_more').css('display','none');
		}
	});
</script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    //$( document ).tooltip();
  });
  </script>
