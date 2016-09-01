<?php
include_once('lib/module.php');


//$path = "uploads/";
		//echo"<pre>";print_r($_FILES);exit;

		$filename = $_FILES['photoimg']['name'];
        if($filename != '')
        {
			//echo"ttt"; exit;
            $strFile = uniqid().preg_replace('/[^.a-zA-Z0-9_-]/s','uploads/user_profile',$_FILES['photoimg']['name']);
			move_uploaded_file($_FILES['photoimg']['tmp_name'],"uploads/user_profile/".$strFile);
		}else{
			//$strFile = $_REQUEST['hdnImage'];
		}

   /* $objData->setTableDetails("soma_users", "Uid");
	$objData->setFieldValues("Upic",$strFile);
	$objData->setWhere("Uid = '".$_SESSION['Uid']."'");
	$objData->update();*/
	//echo "<img src='uploads/".$actual_image_name."'  class='preview'>";
	echo $strFile;
	//echo "lib/timthumb.php?src=uploads/user_profile/".$strFile."&h=195&w=195";
	//echo "<a href='javascript:void(0);'><img src='lib/timthumb.php?src=uploads/user_profile/".$strFile."&h=195&w=195' /></a>";
	
	
	?>