<?php include('includes/header.inc.php');
/*if($_SESSION['Uid'] == ''){
$objModule->redirect("./index.php");
}*/
if($_REQUEST['Domid']!='')
	$arrDom = $objData->getAll("select u.*,C.Cname,C.Cimage,C.Caddress,C.Ccountry,C.Czipcode,t.timezone,t.full_timezone,t.offset from soma_units u left join soma_customers C on u.Cus_id=C.Cid left join tbl_timezone t on u.unit_timezone=t.id where u.Id ='".$_REQUEST['Domid']."'");
	
	//echo"<pre>";print_r($arrDom);exit;
date_default_timezone_set($arrDom[0]['full_timezone']);
//echo $Today=date('Y-m-d H;i:s');

?>
<!--- header ends -->
	<!--jQuery-->
	<!--<script src='jquery/jquery-1.9.1.min.js'></script>
	<script src='jquery/jquery-ui-1.10.2.custom.min.js'></script>-->
	<script src="js/custom-alert.js" language="javascript"></script>
	<!--FullCalendar-->
	<style type="text/css">
		#calendar
		{
			width: 800px;
			margin: 0 auto;
		}
	</style>
<!---top head start----->
<div class="top_head">
	<div class="wrapper">
    <div class="tpleft">
    <div class="prev_aerow" id="prev_aerow"></div>
    <div class="tpbox">
        <?php
        if($arrDom[0]['Cimage']!='' && file_exists("uploads/cus_profile/".$arrDom[0]['Cimage']))
        {
            $img=$arrDom[0]['Cimage'];
        }
        else
        {
            $img='placeholder.jpg';
        }
        ?>
    <img src="lib/timthumb.php?src=uploads/cus_profile/<?php echo $img; ?>&w=127&h=72&zc=1" alt="" />
    </div>
    <div class="tptxt">
    <h2><?php //echo ucfirst($arrDom[0]['Cname']); ?><?php echo ucfirst($arrDom[0]['unitname']); ?></h2>
    <?php 
    	$DomCountry = $objData->getAll("select ctr_name from tbl_country where ctr_id = '".$arrDom[0]['unitcountry']."'");
    	$DomState = $objData->getAll("select state_name from tbl_state where state_id = '".$arrDom[0]['unitstate']."'");
    ?>
    <h3><?php echo $arrDom[0]['unitaddress'];?>, <?php echo $arrDom[0]['unitcity'];?>, <?php echo $DomState[0]['state_name'];?>, <?php echo $arrDom[0]['unit_zip'];?>, <?php echo $DomCountry[0]['ctr_name'];?></h3>
    </div>
    <div class="tptxt tptxt2">
    <?php if($_GET['dt'] != ''){ ?>
    	<?php $Today=$_GET['dt'];?>
        <?php $Today = date("Y-m-d",strtotime($Today));?>
    <?php }else{ ?>
    	<?php $Today=date('Y-m-d');?>
    <?php } ?>
    
    <h2 class="dome_date"><?php echo date("D d F", strtotime($Today)); ?></h2>
    <span class="time">Hours of Operation:
    <span class="txtcol dometime">
    <?php if($_GET['dt'] != ''){ ?>
    	<?php $date=$_GET['dt'];?>
        <?php $date = date("Y-m-d",strtotime($date));?>
    <?php }else{ ?>
    	<?php $date=date('Y-m-d');?>
    <?php } ?>
    <?php 
	
	
	$weekDay = date('l', strtotime($date));
   if(strtolower($weekDay) == 'saturday' || strtolower($weekDay) == 'sunday'){ ?>
   	    	<?php $SaHtime = floor($arrDom[0]['unit_weekendopen']/60);
            	  $EaHtime = floor($arrDom[0]['unit_weekendclose']/60);
				  $SaMtime = $arrDom[0]['unit_weekendopen']%60;
				  if($SaMtime=='0'){
            			$SaMtime = '00';
           		  } 
				  $EaMtime = $arrDom[0]['unit_weekendclose']%60;
				  if($EaMtime=='0'){
            			$EaMtime = '00';
           		  }
           		  
           		  $start = $SaHtime.':'.$SaMtime.$AM;
           		  $end = $EaHtime.':'.$EaMtime;
           		  ?>
           		  <?php echo date('h:i A', strtotime($start));?> to <?php echo date('h:i A', strtotime($end));?>
   <?php }else { ?>
   		<?php $SaHtime = floor($arrDom[0]['unit_weekopen']/60);
            	  $EaHtime = floor($arrDom[0]['unit_weekclose']/60);
				  $SaMtime = $arrDom[0]['unit_weekopen']%60;
				  if($SaMtime=='0'){
            			$SaMtime = '00';
           		  } 
				  $EaMtime = $arrDom[0]['unit_weekclose']%60;
				  if($EaMtime=='0'){
            			$EaMtime = '00';
           		  } 
           		  
           		  $start = $SaHtime.':'.$SaMtime.$AM;
           		  $end = $EaHtime.':'.$EaMtime;
           		  ?> 
       			<?php echo date('h:i A', strtotime($start));?> to <?php echo date('h:i A', strtotime($end));?>
   <?php } ?>
   
  
   </span>
    <?php $TimeZone = $objData->getAll("select * from tbl_timezone where id='".$arrDom[0]['unit_timezone']."'");?>
   <span class="time_zone txtcol"><?php echo $TimeZone[0]['timezone'];?> America</span>
    </span>
    </br>
    <!-- <span class="time">Unit ID. : <span class="txtcol domeid"><?php echo $arrDom[0]['unitid']; ?></span> -->
    </span>
    </div>
    
    </div>
    <input type="hidden" name="all_info" id="all_info" value="">
    <input type="hidden" name="booking" id="booking" value="<?php echo $_REQUEST['booking']; ?>">
    <input type="hidden" name="booking_access" id="booking_access" value="<?php echo $arrDom[0]['unit_access']; ?>">
    <input type="hidden" name="booking_dome_timezone" id="booking_dome_timezone" value="<?php echo $arrDom[0]['offset']; ?>">
    <input type="hidden" name="booking_timezone" id="booking_timezone" value="<?php echo $arrDom[0]['ful_timezone']; ?>">

        <?php if($arrDom[0]['unit_rsvpmode']=='ViaApp') { ?>
        
        	<?php if($_SESSION['Uid'] == ''){ ?>
            	<!--<div class="tpright"><a href="#inline1" class="btn fancybox">Book session</a></div>-->
                <div class="tpright"><a href="javascript:void(0);" class="btn" onclick="booking()">Book session</a></div>
            	
            <?php }else{ ?>
               <div class="tpright"><a href="javascript:void(0);" class="btn" onclick="booking()">Book session</a></div>
            <?php } ?>
        <?php } ?>

    </div>
</div>
<!---top head end----->

<div class="midcont">
<div class="wrapper">
<div class="leftbar leftbar_new">
        <?php include('Choose_Session_Time_Leftbar.php');?>
</div>
    <?php
    if($arrDom[0]['unit_rsvpmode']=='ViaApp') {

            ?>
            <div class="commom-head-div">
      <div class="daybox" <?php if(isset($_REQUEST['booking']) && $_REQUEST['booking']!='') { ?> style="display:none;"<?php } ?>>
      
      			
                
                <ul>
                    <li>
                        <a href="Choose_Session_Time_day.php?Domid=<?php echo $_GET['Domid']; ?>">Day</a>
                    </li>
                    <li class="active">
                        <a href="Choose_Session_Time.php?Domid=<?php echo $_GET['Domid']; ?>">Week</a>
                    </li>
                </ul>
                
                
                
                
                
            </div>
            
             <div class="daybox2" <?php if(isset($_REQUEST['booking']) && $_REQUEST['booking']!='') { ?> style="display:none;"<?php } ?>>
            <ul>
                	<?php 
                	if($_GET['dt'] != ''){ 
                            $sdt=$_GET['dt'];
                            $sdt = date("Y-m-d",strtotime($sdt));
                        }else{
                            $sdt=date('Y-m-d');
                        } 
					?>
                    <?php for($p=0;$p<=6;$p++){  ?>
                    		 <?php //echo $DateList = date("Y-m-d",strtotime($sdt."+ ".$p." days"));?>
                    	<?php if($p==0){?>
                        
                        	<?php $DateList = date("m/d/Y",strtotime($sdt."-7 days"));?>
                            	
                            <li><a <?php if(strtotime($DateList) > strtotime('now')){ ?>href="Choose_Session_Time.php?Domid=<?php echo $_GET['Domid'];?>&dt=<?php echo $DateList; ?>"<?php }else{ ?> href="Choose_Session_Time.php?Domid=<?php echo $_GET['Domid'];?>&dt=<?php echo date('m/d/Y'); ?>" <?php } ?>>Prev</a></li>
                        <?php } ?>
                        
                        <?php if($p==6){?>
                        	<?php $DateList = date("m/d/Y",strtotime($sdt."+7 days"));?>
                            <li><a href="Choose_Session_Time.php?Domid=<?php echo $_GET['Domid'];?>&dt=<?php echo $DateList; ?>">Next</a></li>
                        <?php } ?>
						
                       
               		 <?php } ?>
      				
                    
      			</ul>
            
            </div>
            
            </div>
            <?php

    }
    ?>
    
<div class="rightbar rightbar_new">
<?php if($arrDom[0]['unit_rsvpmode']=='ViaApp')
{
?>
    <div class="rgcalbox" id="calendar">
        <?php
        $height=50;

        ?>
        <div class="weekdays show">
                <div class="week_box">&nbsp;</div>
                <?php
				if($_GET['dt'] != ''){ 
    				$sdt=$_GET['dt'];
        			$sdt = date("Y-m-d",strtotime($sdt));
		    	}else{
    				$sdt=date('Y-m-d');
 			    } 
                
                for($i=0;$i<=6;$i++){  ?>
                    <?php $DateList = date("Y-m-d",strtotime($sdt."+ ".$i." days"));?>
                    <div class="week_box"><?php echo date("D d F", strtotime($DateList)); ?></div>
                <?php } ?>
            </div>
           <div class="week_new_div"> 
        <div class="calendar_part" >
            <div class="weekdays hide">  
                <div class="week_box">&nbsp;</div>
                <?php
                //$sdt=date('Y-m-d');
				if($_GET['dt'] != ''){ 
    				$sdt=$_GET['dt'];
        			$sdt = date("Y-m-d",strtotime($sdt));
		    	}else{
    				$sdt=date('Y-m-d');
 			    } 
				
                for($i=0;$i<=6;$i++){  ?>
                    <?php $DateList = date("Y-m-d",strtotime($sdt."+ ".$i." days"));?>
                    <div class="week_box"><?php echo date("D d F", strtotime($DateList)); ?></div>
                <?php } ?>
            </div>
            <?php if(!isset($_GET['Domid'])){
                $arrDom = $objData->getAll("SELECT * FROM soma_units WHERE Id='".$arrDom[0]['Id']."'");
                $arrBooking=$objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE Uid =  '".$_SESSION['Uid']."' AND dom_id =  '".$arrDom[0]['Id']."'");
            }else{
                $arrDom = $objData->getAll("SELECT * FROM soma_units WHERE Id='".$_GET['Domid']."'");
                $arrBooking=$objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE Uid =  '".$_SESSION['Uid']."' AND dom_id =  '".$_GET['Domid']."'");
            }
            ?>
            <?php foreach($arrDom as $arrDoms){
                if($arrDoms['unit_weekopen'] > $arrDoms['unit_weekendopen']){
                    $startTime = $arrDoms['unit_weekendopen'];
                }else{
                    $startTime = $arrDoms['unit_weekopen'];
                }
                if($arrDoms['unit_weekclose'] > $arrDoms['unit_weekendclose']){
                    $endTime = $arrDoms['unit_weekclose'];
                }else{
                    $endTime = $arrDoms['unit_weekendclose'];
                }
            }
            $SHtime = floor($startTime/60);
            $EHtime = floor($endTime/60);
            $SMtime = $startTime%60;
            if($SMtime=='0'){
                $SMtime = '00';
            }
            $EMtime = $endTime%60;
            if($EMtime=='0'){
                $EMtime = '00';
            }
			
			
			/*echo $SHtime.'-'.$SMtime."ttt</br>";
			echo $EHtime.'-'.$EMtime."fff</br>";*/
 
            $FinalStartTime = $SHtime.':'.$SMtime;
            $FinalEndTime = $EHtime.':'.$EMtime;
            ?>
            <?php
            for($i = $SHtime;$i <= $EHtime;$i++){

            for ($j = 0;$j <= 1;$j++){
                if ($j == 0) {
                    $tm = $i . ':00';
                    $tm1= $i . ':00:00';
                } else if ($j == 1) {
                    $tm = $i . ':30';
                    $tm1= $i . ':30:00';
                } 
				/*echo $i."iii</br>";
				echo $SHtime."ggg</br>";
				
				echo $EHtime."kkk</br>";
				echo $tm."test</br>";
    			echo $FinalStartTime."ddd</br>";
				echo $FinalEndTime."ppp</br>";*/
    
	            if($i==$SHtime && $tm!=$FinalStartTime && $tm <= $FinalStartTime)
                {
                    continue;
                }
                
            ?>
            <div class="date_mainbox">

                <div class="days_box"><b><?php //echo $tm; ?><?php echo date('h:i A', strtotime($tm)); ?></b></div>
                <?php
                for ($k = 0; $k <= 6; $k++) {
                    $DateList = date("Y-m-d", strtotime($sdt . "+" . $k . " days"));

                    if (!isset($_GET['Domid'])) {
                        $arrBooking = $objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE book_status!='2' and user_status='1' and dom_id ='" . $arrDom[0]['Id'] . "' and from_date='" . $DateList . "' and from_time='" . $tm1 . "'");
						
						$arrCancel = $objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE book_status!='1' and user_status='2' and dom_id ='" . $arrDom[0]['Id'] . "' and from_date='" . $DateList . "' and from_time='" . $tm1 . "' and Uid = '".$_SESSION['Uid']."'");

                    } else {
                        $arrBooking = $objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE  book_status!='2' and user_status='1' and dom_id='" . $_GET['Domid'] . "' and from_date='" . $DateList . "' and from_time='" . $tm1 . "'");
						
						$arrCancel = $objData->getAll("SELECT * FROM  soma_user_unit_booking WHERE  book_status!='1' and user_status='2' and dom_id='" . $_GET['Domid'] . "' and from_date='" . $DateList . "' and from_time='" . $tm1 . "' and Uid = '".$_SESSION['Uid']."'");
						
                    }
                    $divid = $arrDom[0]['Id'] . '_' . str_replace(":","-",$tm1). '_' . $DateList;
                    if($arrBooking[0]['Id']==$_REQUEST['booking'])
                    {
                        ?>
                        <input type="hidden" value="<?php echo $divid; ?>" name="editedid" id="editedid">
                        <?php
                    }
					
					
					$weekDay = date('l', strtotime($DateList));
					if(strtolower($weekDay) == 'saturday' || strtolower($weekDay) == 'sunday'){ ?>
                    	<?php 
						//echo $tm1;
						$frm_time = date('H:i', strtotime($tm1));
						$to_time = date('H:i', strtotime($tm1));
						
						$frm_time_1 = explode(':',$frm_time);
						$frm_T1 = $frm_time_1[0] * 60;
						$ftmCtime = $frm_T1+$frm_time_1[1]; 
						
						$to_time_1 = explode(':',$to_time);
						$to_T1 = $to_time_1[0] * 60;
						$toCtime = $to_T1+$to_time_1[1];  
						
						$getTime = $objData->getAll("select unit_weekendopen,unit_weekendclose  from soma_units where Id = '".$_GET['Domid']."'");
						
						if(($ftmCtime >= $getTime[0]['unit_weekendopen'] &&  $ftmCtime <= $getTime[0]['unit_weekendclose']) && ($toCtime >= $getTime[0]['unit_weekendopen'] &&  $toCtime <= $getTime[0]['unit_weekendclose'])){ ?>
							
							
					<?php 
					$ttS1 = $DateList.' '.$tm1 ;
                    $ctm=date('H:i:s');
					if( strtotime($ttS1) > strtotime('now') ) { ?>
						<div <?php if (count($arrBooking) == "0" && count($arrCancel) == "0") { ?> class="days_box available"
                         <?php } else if(count($arrBooking)>0) { ?>  <?php if($arrBooking[0]['Uid'] == $_SESSION['Uid']) {?> style="background-color: #0000FF;" class="days_box" <?php }else{ ?> style="background-color: #ccc;" class="days_box" <?php } ?> <?php } ?>
                         
                         <?php if (count($arrCancel) > "0" && count($arrBooking) == "0"){?>style="background-color: #FF0000;" class="days_box cancel"<?php } ?>
                         
                         id="<?php echo $divid; ?>">
                        <span <?php if (count($arrBooking)== "0" && count($arrCancel) == "0") { ?> class="spntxt available_span" <?php } else{?> class="spntxt" <?php } ?> id="<?php echo $divid . '_spantxt'; ?>"><?php if (count($arrBooking) > "0") {echo "Booked";}else{ ?> <?php echo"Cancelled"; } ?></span>
                    </div>
					<?php }else{ ?>
						<div <?php if (count($arrBooking) == "0") { ?> class="days_box"
                         <?php } else if(count($arrBooking)>0) { ?>style="background-color: #00FF00;" class="days_box"<?php } ?>
                         <?php if (count($arrCancel) > "0" && count($arrBooking) == "0"){?>style="background-color: #FF0000;" class="days_box"<?php } ?>
                         id="<?php echo $divid; ?>">
                        <span <?php if (count($arrBooking)== "0") { ?> class="spntxt" <?php } else{?> class="spntxt" <?php } ?> id="<?php echo $divid . '_spantxt'; ?>"><?php if (count($arrBooking) > "0") {echo "Completed";}else{ ?> <?php echo"Cancelled"; } ?>  </span>
                    </div>
					<?php } ?>
							
							
						<?php }else{ ?>
							
							<div id="" class="days_box not-available" style="background-color:#808080;">
                                <span id="" class="spntxt not-available_span">  </span>
                            </div>
							
						<?php } ?>
                      
                    <?php }else{ ?>
						
						<?php 
						//echo $tm1;
						$frm_time = date('H:i', strtotime($tm1));
						$to_time = date('H:i', strtotime($tm1));
						
						$frm_time_1 = explode(':',$frm_time);
						$frm_T1 = $frm_time_1[0] * 60;
						$ftmCtime = $frm_T1+$frm_time_1[1]; 
						
						$to_time_1 = explode(':',$to_time);
						$to_T1 = $to_time_1[0] * 60;
						$toCtime = $to_T1+$to_time_1[1];  
						
						$getTime = $objData->getAll("select unit_weekopen,unit_weekclose  from soma_units where Id = '".$_GET['Domid']."'");
						
						if(($ftmCtime >= $getTime[0]['unit_weekopen'] &&  $ftmCtime <= $getTime[0]['unit_weekclose']) && ($toCtime >= $getTime[0]['unit_weekopen'] &&  $toCtime <= $getTime[0]['unit_weekclose'])){ ?>
							
							
					<?php 
					$ttS1 = $DateList.' '.$tm1 ;
                    $ctm=date('H:i:s');
					if( strtotime($ttS1) > strtotime('now') ) { ?>
						<div <?php if (count($arrBooking) == "0" && count($arrCancel) == "0") { ?> class="days_box available"
                         <?php } else if(count($arrBooking)>0) { ?> <?php if($arrBooking[0]['Uid'] == $_SESSION['Uid']) {?> style="background-color: #0000FF;" class="days_box" <?php }else{ ?> style="background-color: #ccc;" class="days_box" <?php } ?> <?php } ?>
                       
                         <?php if (count($arrCancel) > "0" && count($arrBooking) == "0"){?>style="background-color: #FF0000;" class="days_box cancel"<?php } ?>
                         
                         id="<?php echo $divid; ?>">
                        <span <?php if (count($arrBooking)== "0" && count($arrCancel) == "0") { ?> class="spntxt available_span" <?php } else{?> class="spntxt" <?php } ?> id="<?php echo $divid . '_spantxt'; ?>"><?php if (count($arrBooking) > "0") {echo "Booked";}else{ ?> <?php echo"Cancelled"; } ?></span>
                    </div>
					<?php }else{ ?>
						<div <?php if (count($arrBooking) == "0") { ?> class="days_box"
                         <?php } else if(count($arrBooking)>0) { ?>style="background-color: #00FF00;" class="days_box"<?php } ?>
                         <?php if (count($arrCancel) > "0" && count($arrBooking) == "0"){?>style="background-color: #FF0000;" class="days_box"<?php } ?>
                         id="<?php echo $divid; ?>">
                        <span <?php if (count($arrBooking)== "0") { ?> class="spntxt" <?php } else{?> class="spntxt" <?php } ?> id="<?php echo $divid . '_spantxt'; ?>"><?php if (count($arrBooking) > "0") {echo "Completed";}else{ ?><?php /*?> <div class="unavailable" onclick="unavailable()"> <?php echo"&amp;";  ?></div><?php */?> <div class="unavailable" style="background-color:#ccc;"> <span><?php echo"Unavailable";  ?></span></div><?php } ?>  </span>
                    </div>
					<?php } ?>
							
							
						<?php }else{ ?>
							
							<div id="" class="days_box not-available" style="background-color:#808080;">
                                <span id="" class="spntxt not-available_span">  </span>
                            </div>
							
						<?php } ?>
						
						
						
						
					<?php } ?>
                    
                    
                    <?php
                }
                echo "</div>";
				
				if($i==$EHtime && $tm==$FinalEndTime)
                {
                    break;
                }

                }

                }
                ?>
            </div>
        </div>
   		</div>	
    </div>
    <?php
}
else
{
    ?>
    <h2 style="text-align: center;padding-top: 80px;">
    <?php
    if ($arrDom[0]['unit_rsvpmsg'] != '')
        echo $arrDom[0]['unit_rsvpmsg'];
    else
        echo "Contact host via call or email to book your session for this dome";
    ?>
    </h2>
    <?php
}
?>
</div>
</div>
<script>
    $(document).on('click','.available',function(){

       var id=$(this).attr("id");
        $('#all_info').val(id);
        
		/*var currentdate = new Date(); 
		var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1) + "-" 
                + currentdate.getDate() + ""  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
				
		alert(datetime);*/	
		var booking_access = $('#booking_access').val();
		if(booking_access == 'Member'){
			 //alert('This is not a public dome. Make sure you are allowed to use it before booking a session');
			 confirm('This is not a public dome. Make sure you are allowed to use it before booking a session',  {return: true});	
		}
			
		
		$('.available').css("background-color", "");
        $('.available_span').html("");
        $("#"+id).css("background-color", "#c6ace2");
        $("#"+id+'_spantxt').html('Booking');
		
		
		
		
        var weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
        var AllVal = id.split('_');
        var d_id = AllVal[0];
		var time = AllVal[1];
		var AllTime = time.split('-');
		//alert(time);
        var start = AllVal[2];
		//alert(start);
        var str1=new Date(start);
		//alert(str1+"dddd");
        var year = str1.getFullYear();
        var Dy=str1.getDay();
        var month=str1.getMonth();
        var dt=str1.getDate();
		//alert(dt);
		var expireDate = new Date(year, month, dt, AllTime[0], AllTime[1], '00');
		//alert(expireDate);
		//var todayDate = new Date();
		var offset = $('#booking_dome_timezone').val();
		offset = parseInt(offset)+parseInt(1);
		//alert(offset);
		var todayDate = new Date( new Date().getTime() + offset * 3600 * 1000).toUTCString().replace( / GMT$/, "" )
		//alert(todayDate);
		//alert(str1);
		if (todayDate > expireDate) {
		   alert('You cannot book dome at this time as it is already passed.')	
		   $('#all_info').val("");	
		   $('.available').css("background-color", "");
           $('.available_span').html("");
		   return false;
		};
		
        var str=weekdays[Dy]+', '+monthNames[month]+' '+dt+', '+year;
		//alert(str);
        $('.dome_date').html(str);
        jQuery.ajax({
            url: 'ajax.php',
            data: {domid: d_id,CMD:"GET_DOME_DETAIL",cdate:start},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                $('.dometime').html(data);
            }
        });
    });
	
	
    $(document).on('click','.cancel',function(){

       var id=$(this).attr("id");
        $('#all_info').val(id);
        
		/*var currentdate = new Date(); 
		var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1) + "-" 
                + currentdate.getDate() + ""  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
				
		alert(datetime);*/		
		
		$('.available').css("background-color", "");
		$('.cancel').css("background-color", "");
        $('.available_span').html("");
        $("#"+id).css("background-color", "#c6ace2");
        $("#"+id+'_spantxt').html('Booking');
		
		
		
        var weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
        var AllVal = id.split('_');
        var d_id = AllVal[0];
		var time = AllVal[1];
		var AllTime = time.split('-');
		//alert(time);
        var start = AllVal[2];
		//alert(start);
        var str1=new Date(start);
		//alert(str1+"dddd");
        var year = str1.getFullYear();
        var Dy=str1.getDay();
        var month=str1.getMonth();
        var dt=str1.getDate();
		//alert(dt);
		var expireDate = new Date(year, month, dt, AllTime[0], AllTime[1], '00');
		//alert(expireDate);
		var offset = $('#booking_dome_timezone').val();
		offset = parseInt(offset)+parseInt(1);
		//alert(offset);
		var todayDate = new Date( new Date().getTime() + offset * 3600 * 1000).toUTCString().replace( / GMT$/, "" )
		//alert(todayDate);
		//alert(str1);
		if (todayDate > expireDate) {
		   alert('You cannot book dome at this time as it is already passed.')	
		   $('#all_info').val("");	
		   $('.available').css("background-color", "");
           $('.available_span').html("");
		   return false;
		};
		
        var str=weekdays[Dy]+', '+monthNames[month]+' '+dt+', '+year;
		//alert(str);
        $('.dome_date').html(str);
        jQuery.ajax({
            url: 'ajax.php',
            data: {domid: d_id,CMD:"GET_DOME_DETAIL",cdate:start},
            type: 'POST',
            cache: true,
            success: function (data)
            {
                $('.dometime').html(data);
            }
        });
    });
	
function Booking_dome(id){
	/*$('#all_info').val(id);
    $('.available').css("background-color", "");
    $('.available_span').html("");
	$("#"+id).css("background-color", "#c6ace2");
    $("#"+id+'_spantxt').html('Booking');
    var weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    var AllVal = id.split('_');
    var d_id = AllVal[0];
    var start = AllVal[2];
    var str1=new Date(start);
    var year = str1.getFullYear();
    var Dy=str1.getDay();
    var month=str1.getMonth();
    var dt=str1.getDate();
    var str=weekdays[Dy]+', '+monthNames[month]+' '+dt+', '+year;
    $('.dome_date').html(str);
    jQuery.ajax({
        url: 'ajax.php',
        data: {domid: d_id,CMD:"GET_DOME_DETAIL",cdate:start},
        type: 'POST',
        cache: true,
        success: function (data)
        {
            $('.dometime').html(data);
        }
    });*/
}
function booking(){
   var session_id = '<?php echo $_SESSION['Uid'] ?>';
   //alert(session_id);
   //return false;
   if(session_id != ''){
   
	var value = $('#all_info').val();
    if(value!='')
    {
        var AllVal = value.split('_');
        var start = AllVal[2];
        var end = AllVal[2];
        var d_id = AllVal[0];
        var stime = AllVal[1];
        var title = 'Booking';
        var booking=$('#booking').val();
		var timezone=$('#booking_timezone').val();
        jQuery.ajax({
            url: 'ajax.php',
            data: {title: title,start_Date:start,end_date:end,booking:booking,dom_id:d_id,time:stime,timezone:timezone,CMD:"Event_Add"},
            type: 'POST',
            cache: true,
            success: function (data)
            {
				var res_week = data.split('-'); 
				//alert(res_week);
                if (data == 1)
                {
                    //alert('Events Already Booked');
                    window.location.href = document.URL;
                    //return false;
                }else if(res_week[2] == 11){
					//alert(data);
					var text = "Dome is not available at this time. On weekend days, dome is only available from "+ res_week[0] +" to"+ res_week[1] +" closed hour."
					alert(text);
					$('.available').css("background-color", "");
        			$('.available_span').html("");
					
				}else
                {
                    $('#'+value).css('background-color','#0000FF');
                    $('#'+value+'_spantxt').html('Booked');
                    $('#'+value).removeClass('available');
                    $('#'+value+'_spantxt').removeClass('available_span');
                    if(booking!='')
                    {
                        var edited=$('#editedid').val();
                        $("#"+edited).removeAttr("style");
                        $("#"+edited).addClass("available");
                        $("#"+edited+'_spantxt').html('');
                        $('#booking').val('');
                        $('.daybox').css('display','block');
                        window.history.pushState("string", "Title", "Choose_Session_Time.php?Domid="+d_id);
                    }
                    return true;
                }
            }
        });
    }
    else {
        alert('Select at-least one time slot to book');
    }
	
   }else{
	   var url = window.location.href ;
	   //alert(url);return false;
	   var sp_val = url.split('=');
	   var value = $('#all_info').val();
	   var booking=$('#booking').val();
	   $('#book_val').val(sp_val[1]);
	   $('#all_info_head').val(value);
	    $('#booking_head').val(value);
		$('#booking_type_head').val('week');
	   
	   $(".fancybox").fancybox().trigger('click');
   }

}


function unavailable(){
alert('Unavailable');	
}
/*jQuery("#dom_select").change(function() {
  //alert(this.value);
  
  
  
  var url = '<?php echo $objData->SITEURL ?>Choose_Session_Time.php'+'?Cid='+'<?php echo $_GET['Cid']; ?>';
  var value = this.value;
 // alert(url+'&Did='+ value); 
  window.location.href = url+'&Did='+ value;
});*/

$(document).ready(function(){
	$('#prev_aerow').click(function(){
		//parent.history.back();
		window.location.href="<?php echo $objData->SITEURL; ?>";
		return false;
	});
});

</script>

 
<?php include('includes/footer.inc.php');?>
