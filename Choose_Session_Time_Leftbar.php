 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <?php /*?><ul class="calpagi">
        <li><a href="#"> </a></li>
        <li><a href="#">March 2018</a></li>
        <li><a href="#"> </a></li>
    </ul>
    <img src="images/calendar.jpg" alt="" />  <?php */?>
	<div id="datepicker"></div>
	  <script>
  /*$(function() {
    $( "#datepicker" ).datepicker();
  });*/
  
  
  $(function() {
    $("#datepicker").datepicker({
         	inline: true,
			defaultDate: '<?php echo $_GET['dt']; ?>',
			minDate: 0,
			onSelect: function(date)
			{
				//alert(date);
				var links="Choose_Session_Time.php?Domid=<?php echo $_GET['Domid'];?>&dt=";
				window.location.href = links+date;
			}
       

    });
  });
  </script>
  <script>
    $(document).ready(function(){
        //$('#datepicker').find(".ui-state-active").removeClass("ui-state-active");
        $('#datepicker').find(".ui-state-highlight").removeClass("ui-state-highlight");
    });
</script>