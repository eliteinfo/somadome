<?php include('includes/header.inc.php');?>
<?php if($_SESSION['Uid'] == ''){ ?>
	<?php  $objModule->redirect("./index.php"); ?>
<?php } ?>


<?php 
$arrDom = $objData->getAll("select * from soma_units where Cus_id = '".$_GET['Cid']."'");
//echo"<pre>";print_r($arrDom);

/*foreach ($arrDom as $arrDoms){ 
				
				
					echo date("d", $arrDoms['from_date']);
				} exit;*/

?>
<?php if(!isset($_GET['Did'])){?>
	
	<?php $arrEvent = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE dom_id='".$arrDom[0]['Id']."'");?>
<?php }else{ ?>

	<?php $arrEvent = $objData->getAll("SELECT * FROM soma_user_unit_booking WHERE dom_id='".$_GET['Did']."'");?>
<?php } ?>
	

<?php //echo"<pre>";print_r($arrEvent);?>
<!--- header ends -->
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	
	<!--jQuery-->
	<script src='jquery/jquery-1.9.1.min.js'></script>
	<script src='jquery/jquery-ui-1.10.2.custom.min.js'></script>
	
	<!--FullCalendar-->
	<script src='fullcalendar/fullcalendar.min.js'></script>
	<script type="text/javascript">
		
		/*
			jQuery document ready
		*/
		
		$(document).ready(function()
		{
			/*
				date store today date.
				d store today date.
				m store current month.
				y store current year.
			*/
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			//alert(m);
			
			/*alert(d);
			alert(m);
			alert(y);*/
			
			/*
				Initialize fullCalendar and store into variable.
				Why in variable?
				Because doing so we can use it inside other function.
				In order to modify its option later.
			*/
			
			var calendar = $('#calendar').fullCalendar(
			{
				/*
					header option will define our calendar header.
					left define what will be at left position in calendar
					center define what will be at center position in calendar
					right define what will be at right position in calendar
				*/
				header:
				{
					left: 'prev,next today',
					center: 'title',
					right: 'agendaWeek,agendaDay'
				},
				/*
					defaultView option used to define which view to show by default,
					for example we have used agendaWeek.
				*/
				defaultView: 'agendaWeek',
				/*
					selectable:true will enable user to select datetime slot
					selectHelper will add helpers for selectable.
				*/
				selectable: true,
				selectHelper: true,
				/*
					when user select timeslot this option code will execute.
					It has three arguments. Start,end and allDay.
					Start means starting time of event.
					End means ending time of event.
					allDay means if events is for entire day or not.
				*/
				select: function(start, end, allDay)
				{
					//alert(start);
					//alert(end);
					
					/*
						after selection user will be promted for enter title for event.
					*/
					//var title = prompt('Event Title:');
					var title = '';
 
					//alert(title);
					/*
						if title is enterd calendar will add title and event into fullCalendar.
					*/
						//alert(start);
						//alert(end);
						$('#start_date').val(start);
						$('#end_date').val(end);
						
						calendar.fullCalendar('renderEvent',
							{
								title: 'Booking',
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
						
						
					if (title)
					{
						
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
						
						//test(title,start,end);
						
						
						
						/*alert(title);
						alert(start);
						alert(end);
						alert(allDay);*/
					}
					calendar.fullCalendar('unselect');
				},
				
				/*
					editable: true allow user to edit events.
				*/
				editable: false,
				/*
					events is the main option for calendar.
					for demo we have added predefined events in json object.
				*/
				
				
				events: [
				
				<?php foreach($arrEvent as $arrEvents){ ?>
	
					<?php $frm_date = date("d", strtotime($arrEvents['from_date']));?>
					<?php $frm_month = date("m", strtotime($arrEvents['from_date']));?>
					<?php $frm_year = date("Y", strtotime($arrEvents['from_date']));?>
					<?php $frm_hrs = date("H", strtotime($arrEvents['from_time']));?>
					<?php $frm_min = date("i", strtotime($arrEvents['from_time']));?>
					
					<?php $to_date = date("d", strtotime($arrEvents['to_date']));?>
					<?php $to_month = date("m", strtotime($arrEvents['to_date']));?>
					<?php $to_year = date("Y", strtotime($arrEvents['to_date']));?>
					<?php $to_hrs = date("H", strtotime($arrEvents['to_time']));?>
					<?php $to_min = date("i", strtotime($arrEvents['to_time']));?>
					
					
					{
						title: '<?php echo $arrEvents['event'] ?>',
						start: new Date('<?php echo $frm_year; ?>', '<?php echo $frm_month - 1; ?>', '<?php echo $frm_date; ?>', '<?php echo $frm_hrs; ?>', '<?php echo $frm_min; ?>'),
						end: new Date('<?php echo $to_year; ?>', '<?php echo $to_month - 1; ?>', '<?php echo $to_date; ?>', '<?php echo $to_hrs; ?>', '<?php echo $to_min; ?>'),
						allDay: false
					},
					
				
				<?php } ?>
				
				
				]
			});
			
		});

	</script>
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
    <div class="prev_aerow"></div>
    <div class="tpbox">
    <img src="images/tpimg.jpg" alt="" />
    </div>
    <div class="tptxt">
    <h2>Cornelia Spa at The Surrey</h2>
    <h3>20 E 76th St New York, NY 10021</h3>
    </div>
    
    <div class="tptxt tptxt2">
    <h2>Saturday, March 12, 2016</h2>
    <span class="time">Time: <span class="txtcol">6:00 to 6:30</span></span>
    <span class="time">Unit ID. : <!--<span class="txtcol">02</span>-->
    <select id="dom_select" name="dom_select">
    <?php foreach($arrDom as $arrDoms){ ?>
    <option value="<?php echo $arrDoms['Id']; ?>" <?php if($_GET['Did'] == $arrDoms['Id']){?> selected="selected" <?php } ?>><?php echo $arrDoms['unitname']  ?></option>
    <?php } ?>
    </select>
    </span>
    </div>
    
    </div>
    <input type="hidden" name="start_date" id="start_date" value="">
    <input type="hidden" name="end_date" id="end_date" value="">
   <div class="tpright"> <a href="#" class="btn" onclick="test()">Book session</a></div>
    
    </div>
</div>
<!---top head end----->

<div class="midcont">
<div class="wrapper">
<div class="leftbar">
<ul class="calpagi">
	<li><a href="#"> </a></li>
    <li><a href="#">March 2016</a></li>
    <li><a href="#"> </a></li>
</ul>
<img src="images/calendar.jpg" alt="" />
</div>
<div class="rightbar">
<!--<div class="righttop"><div class="listPagi">
<ul class="calpagi calpagi2">
	<li><a href="#"> </a></li>
    <li><a href="#">Monday, March 20, 2016</a></li>
    <li><a href="#"> </a></li>
</ul>
</div>
<div class="daybox">
	<ul>
    <li><a href="#">Day</a></li>
    <li class="active"><a href="#">week</a></li>
    </ul>
</div>
</div>-->
<div class="rgcalbox" id="calendar">

</div>
</div>

</div>

</div>
<script>
/*function test(title, start, end){
	
	var d_id = document.getElementById('dom_select').value;
	
	jQuery.ajax({
		   url: 'ajax.php',
		   data: {title: title,start_Date:start,end_date:end,dom_id:d_id,CMD:"Event_Add"},
		   type: 'POST',
		   cache: true,
		   success: function (data)
		   {
			  // alert(data);
			   if (data == 1)
			   {   
				  alert('Events Already Booking');
				  window.location.href = document.URL;
           		  //return false;
			   }
			   else
			   {
				  
				   return true;
			   }
		   }
	   });
}*/

function test(title, start, end){
	
	var d_id = document.getElementById('dom_select').value;
	var start = document.getElementById('start_date').value;
	var end = document.getElementById('end_date').value;
	
	jQuery.ajax({
		   url: 'ajax.php',
		   data: {title: title,start_Date:start,end_date:end,dom_id:d_id,CMD:"Event_Add"},
		   type: 'POST',
		   cache: true,
		   success: function (data)
		   {
			  // alert(data);
			   if (data == 1)
			   {   
				  alert('Events Already Booking');
				  window.location.href = document.URL;
           		  //return false;
			   }
			   else
			   {
				  
				   return true;
			   }
		   }
	   });
}

jQuery("#dom_select").change(function() {
  //alert(this.value);
  
  
  
  var url = '<?php echo $objData->SITEURL ?>Choose_Session_Time.php'+'?Cid='+'<?php echo $_GET['Cid']; ?>';
  var value = this.value;
 // alert(url+'&Did='+ value); 
  window.location.href = url+'&Did='+ value;
});
</script>


<?php include('includes/footer.inc.php');?>
