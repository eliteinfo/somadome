<?php
if(isset($_REQUEST['btnsubmit']))
    {
     if(!empty($_REQUEST['chkbox']))
     {
         $arrCat        =   $_POST['arrCat'];
         $arrName       =   $_POST['arrName'];
         $arrSkUser     =   $_POST['arrUser'];
         $arrUser       =   array();
         
         foreach($_REQUEST['chkbox'] as $intKey=>$strValue)
         {
             if($_REQUEST['cmbStatus']=="1")
             {
                 $arrCheck  =   array();
                 $arrCheck  =   $objModule->getAll("SELECT * FROM tbl_skills WHERE cat_id = '".$arrCat[$strValue]."' AND sk_name = '".$arrName[$strValue]."'  ");
                 if(empty($arrCheck))
                 {
                     $objData= new PCGData();
                     $objData->setTableDetails("tbl_skills","sk_id");   
                     $objData->setFieldValues("cat_id", $arrCat[$strValue]);
                     $objData->setFieldValues("sk_name",$arrName[$strValue]);
                     $objData->insert();
                     unset($objData);
                     
                }
                 if(array_key_exists($arrSkUser[$strValue], $arrUser)):
                    $arrUser[$arrSkUser[$strValue]][] = $arrName[$strValue];
                 else:
                     $arrUser[$arrSkUser[$strValue]][] = $arrName[$strValue];
                 endif;
             }
             
         }
         
         $arrMailUser = $objModule->getAll("SELECT * FROM tbl_users WHERE Id in (".  implode(',',  array_keys($arrUser)).")");
         if(!empty($arrMailUser))
         {
            foreach($arrMailUser as $arrU)
            {
                $strMess = '';
                $strHtml ='';
                
                $strHtml = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:1px solid #e7e7e7; color:#444444;">
		<tr>
			<td style="padding:20px;">
				<center>
					<table border="0" cellpadding="5px" cellspacing="0" width="100%" style="height:100%; border-left:1px solid #ccc; border-top:1px solid #ccc;">
                                            <thead style="background-color:#efefef;">
						<tr>
                                                    <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">No </th>
                                                    <th style="padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Skill</th>
                                                </tr>
                    </thead>';
                foreach($arrUser[$arrU['Id']] as $intSk=>$strSk)
                {
                    
                    $strHtml .='<tbody>    
                        <tr>
                            <td align="center" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.($intSk+1).'</td>
                            <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">'.$strSk.'</td>
                         </tr>';
                }
                $strHtml .='</tbody>                            
					</table>
				</center>
			</td>
		</tr>
	</table>';
                
                
                 $strMess = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Metronic | Email 1</title>
	<style type="text/css">
		#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
		body{width:100% !important; margin:0; font-family:Open Sans;} 
		body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
		body{margin:0; padding:0;}
		img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
		table td{border-collapse:collapse;}
		#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700); /* Loading Open Sans Google font */ 
		body, #backgroundTable{ background-color:#FFF; }
		.TopbarLogo{
		padding:10px;
		text-align:left;
		vertical-align:middle;
		}
		h1, .h1{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:35px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h2, .h2{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:30px;
		font-weight: 400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h3, .h3{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:24px;
		font-weight:400;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h4, .h4{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:18px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		h5, .h5{
		color:#444444;
		display:block;
		font-family:Open Sans;
		font-size:14px;
		font-weight:400;
		line-height:100%;
		margin-top:2%;
		margin-right:0;
		margin-bottom:1%;
		margin-left:0;
		text-align:left;
		}
		.textdark { 
		color: #444444;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.textwhite { 
		color: #fff;
		font-family: Open Sans;
		font-size: 16px;
		line-height: 150%;
		text-align: left;
		}
		.fontwhite { color:#fff; }
		.btn {
		background-color: #e5e5e5;
		background-image: none;
		filter: none;
		border: 0;
		box-shadow: none;
		padding: 7px 14px; 
		text-shadow: none;
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		font-size: 14px;  
		color: #333333;
		cursor: pointer;
		outline: none;
		-webkit-border-radius: 0 !important;
		-moz-border-radius: 0 !important;
		border-radius: 0 !important;
		}
		.btn:hover, 
		.btn:focus, 
		.btn:active,
		.btn.active,
		.btn[disabled],
		.btn.disabled {  
		font-family: "Segoe UI", Helvetica, Arial, sans-serif;
		color: #333333;
		box-shadow: none;
		background-color: #d8d8d8;
		}
		.btn.red {
		color: white;
		text-shadow: none;
		background-color: #d84a38;
		}
		.btn.red:hover, 
		.btn.red:focus, 
		.btn.red:active, 
		.btn.red.active,
		.btn.red[disabled], 
		.btn.red.disabled {    
		background-color: #bb2413 !important;
		color: #fff !important;
		}
		.btn.green {
		color: white;
		text-shadow: none; 
		background-color: #35aa47;
		}
		.btn.green:hover, 
		.btn.green:focus, 
		.btn.green:active, 
		.btn.green.active,
		.btn.green.disabled, 
		.btn.green[disabled]{ 
		background-color: #1d943b !important;
		color: #fff !important;
		}
	</style>
</head><body>';
        $strMess .='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343; height:52px;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="left" valign="middle" style="padding-left:20px; padding-top:5px;">
								<a href="' . $objModule->SITEURL . '">
								<img src="' . $objModule->SITEURL . 'images/logo2.png" width="246px" alt="Metronic logo"/>
								</a>
							</td>
							<td align="right" valign="middle" style="padding-right:0; padding-top:5px;">
								<table border="0" cellpadding="0" cellspacing="0" width="120px" style="height:100%;">
									<tr>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/fb_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/tw_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
										<td>
											<a href="#">
											<img src="' . $objModule->SITEURL . 'images/youtube_icon2.png"  width="30px" height="30px" alt="social icon"/>
											</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td style="padding:20px;">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px; height:100%;">
						<tr>
							<td valign="top" colspan="4">
								<h2> Your skills are approve !</h2>
								<br />
								<div class="textdark">
									<strong>Dear '.$arrU[0]['Username'].' </strong><br /><br />
									Your skills are approve on classgod<br/>
                                                                        <strong>Detail is as bellow</strong><br /><br />
								</div>
								<br />
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table> '.$strHtml.'
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#434343;color:#fff;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
						<tr>
							<td align="center" valign="middle" class="textwhite" style="font-size:12px;padding:20px;">
								&copy; ' . date("Y") . ' ClassGod.
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>';
        
            $headers1 = "MIME-Version: 1.0" . "\r\n";
            $headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers1 .= 'From: ' . $objModule->INFO_MAIL;
            mail($arrU['Email'], "Skills Approved on classgod", $strMess, $headers1); 

            }
         }
         
         $objModule->getAll("delete from tmp_skills where id in (".implode(',',$_REQUEST['chkbox']).")");
         $objModule->redirect("./list_suggest.php");
     }
     else
     {
         $objModule->setMessage("Please Select any skills","error");
     }
}
if($_GET['id'] != '')
{
      $objModule->getAll("delete from tmp_skills where id = '".$_GET['id']."'");
      $objModule->redirect('list_suggest.php');
}
$arrSkils    =   $objModule->getAll("SELECT ts.*,tc.name,tc.id as cate_id FROM tmp_skills ts LEFT JOIN tbl_category tc ON tc.id = ts.cat_id WHERE 1 GROUP BY ts.id ORDER BY ts.id DESC");

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
               
                <h3 class="page-title">
                    Suggest Skill
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        List Suggest Skill                        
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
                
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-globe"></i>List Suggest Skill</div>
                    </div>
                    
                    <div class="portlet-body">
                   <?php echo $objModule->getMessage(); ?>
                    <form name="frm" method="post"  action="" >
            <select name="cmbStatus">
              <option value="1">Approved</option>
              <option value="2">Denied</option>
            </select> 
            <input type="submit" name="btnsubmit"  class="btn green" value="Submit" id="btnsubmit" />
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <?php /* ?><th>#</th><?php */ ?>
                                    <th style="width:8px;">
                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    </th>
                                    <th>Skills</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($arrSkils as $intKey=>$strValue):?>
                                <tr class="odd gradeX">
                                    <td style="display:none"></td>
                                     <td>
                                         <input type="checkbox" class="checkboxes" name="chkbox[]" value="<?php echo $strValue['id'];  ?>" />
                                         <input type="hidden" name="arrCat[<?php echo $strValue['id'];?>]" value="<?php echo $strValue['cate_id'];?>" />
                                         <input type="hidden" name="arrName[<?php echo $strValue['id'];?>]" value="<?php echo $strValue['skills'];?>" />
                                         <input type="hidden" name="arrUser[<?php echo $strValue['id'];?>]" value="<?php echo $strValue['uid'];?>" />
                                     </td>
                                    <?php /*<td><?php echo ($intKey+1);?></td> */ ?>
                                    <td><?php echo $strValue['skills'];?></td>
                                    <td><?php echo $strValue['name']; ?></td>
                                    <td><?php if($strValue['status'] == '1'){ echo "Approved"; }else if($strValue['status'] == '2'){ echo "Denied"; }else{ echo "----"; } ?></td>
                                    <td>
                                        <a href="add_suugest.php?id=<?php echo $strValue['id'];?>" class="btn mini purple"><i class="icon-edit"></i> Edit</a>
                                        <a href="javascript:;" onclick="return doYouWantTo('<?php echo $strValue['id'];?>')" class="btn mini red"><i class="icon-trash"></i> Delete</a>
                                    </td>                                        
                                </tr>
                           <?php endforeach;?>     
                            </tbody>
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
<script type="text/javascript">
	function doYouWantTo(id){
	  doIt=confirm('Do you want to delete it?');
	  if(doIt){
		window.location.href = 'list_suggest.php?id='+id;
	  }
	  else{
		  return false;
	  }
	  return false;
	}
</script>