<?php include_once('lib/module.php'); ?>

<?php 
$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1');

$allDome = $objData->getAll('Select suub.*,su.unit_timezone from soma_user_unit_booking as suub, soma_units as su where suub.dom_id = su.Id and suub.book_status != 2');

//echo"<pre>";print_r($allDome);exit;
foreach($allDome as $allDomes){
	
	if($allDomes['unit_timezone']== 10){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=10');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
		
		
	}elseif($allDomes['unit_timezone']== 11){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=11');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
		
		
	}elseif($allDomes['unit_timezone']== 12){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=12');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
		
		
	}elseif($allDomes['unit_timezone']== 13){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=13');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
		
		
	}elseif($allDomes['unit_timezone']== 14){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=14');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
	
	}elseif($allDomes['unit_timezone']== 15){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=15');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
	
			
	}elseif($allDomes['unit_timezone']== 16){
		
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=16');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
				
	
	}elseif($allDomes['unit_timezone']== 17){
					
	
		$AllTimeZone = $objData->getAll('select * from tbl_timezone where status = 1 and id=17');
		date_default_timezone_set($AllTimeZone[0]['full_timezone']);
		$dt=date('Y-m-d');
		$tm=date('H:i:s');
		$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2' and dom_id = '".$allDomes['Id']."'");
	
	}else{
	
						
	}
	
}

/*if($allDome[0]['unit_timezone']== 10){
	
	
}elseif($allDome[0]['unit_timezone']== 11){
	
	
}elseif($allDome[0]['unit_timezone']== 12){
	
	
}elseif($allDome[0]['unit_timezone']== 13){
	
	
}elseif($allDome[0]['unit_timezone']== 14){
	

}elseif($allDome[0]['unit_timezone']== 15){

		
}elseif($allDome[0]['unit_timezone']== 16){
			

}elseif($allDome[0]['unit_timezone']== 17){
				

}else{

					
}*/


?>





<?php 
$dt=date('Y-m-d');
$tm=date('H:i:s');
$allTime = $objData->getAll("update soma_user_unit_booking set book_status='3' Where from_date<='".$dt."' and from_time<'".$tm."' and book_status!='2'");?>
