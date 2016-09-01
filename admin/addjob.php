<?php
include 'lib/module.php';
if($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if($_SESSION['clg_usertype']==1)
{
    // redirect to tutor dashboard
    $objModule->redirect("./tutordashboard.php");
}
$arrCategory = $objModule->getAll("SELECT * FROM tbl_category ORDER BY name ASC");
if($_POST['btnPost']!='')
{
    if($_POST['txtName']!='' && $_POST['description']!='' && $_POST['cmbCategory']!='' && $_POST['cmbSubCategory']!='' )
    {
        $strEndate = date("Y:m:d H:i:s",strtotime($_POST['end_date']));
        $objData = new PCGData();
        $objData->setTableDetails("tbl_post","id");
        $objData->setFieldValues("title",$_POST['txtName']);
        $objData->setFieldValues("uid",$_SESSION['clg_userid']);
        $objData->setFieldValues("category_id",$_POST['cmbCategory']);
        $objData->setFieldValues("sub_cat",$_POST['cmbSubCategory']);
        $objData->setFieldValues("start_date_time",date("Y:m:d H:i:s"));
        $objData->setFieldValues("end_date_time",$strEndate);
        $objData->setFieldValues("description",$_POST['description']);
        $objData->setFieldValues("created_date",date("Y:m:d H:i:s"));
        if(!empty($_POST['cmbSkills']))
        {
            $strSkill = @implode(',', $_POST['cmbSkills']);
            $objData->setFieldValues("skills",$strSkill);
        }
        //set work type
        $objData->setFieldValues("work_type",$_POST['workType']);
        if($_POST['workType']==0):
            $objData->setFieldValues("work_op",$_POST['fixedBudget']);
        else:
            $objData->setFieldValues("work_op",$_POST['hourlyRate']);
        endif;
        if($_POST['fixedBudget']==1 || $_POST['hourlyRate']==1)
        {
            $objData->setFieldValues("w_min",$_POST['txtMin']);
            $objData->setFieldValues("w_max",$_POST['txtMax']);
        }
        $objData->insert();
        $intPostId = $objData->intLastInsertedId;
        unset($objData);
		if(!file_exists('./upload/attachment/'.$intPostId)) {
				mkdir('./upload/attachment/'.$intPostId, 0755, true);
		}
        
        if(!empty($_FILES['files']['name']))
        {
            foreach($_FILES['files']['name'] as $intKey=>$strVal):
                $strEx          =   pathinfo($_FILES['files']['name'][$intKey],PATHINFO_EXTENSION);
                //$strFilename    =   uniqid().'.'.$strEx;
				$strFilename    =   $_FILES['files']['name'][$intKey];
                move_uploaded_file($_FILES['files']['tmp_name'][$intKey],"./upload/attachment/".$intPostId."/" .$strFilename);
                $objData = new PCGData();
                $objData->setTableDetails("tbl_post_attach","att_id");
                $objData->setFieldValues("post_id",$intPostId);
                $objData->setFieldValues("filename",$strFilename);
                $objData->insert();
            endforeach;
        }
        $objModule->redirect("./buydashboard.php");
    }
    else
    {
        $objModule->setMessage("Fill all the required fields","errror");
    }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("ul.menu li:has(ul)").addClass("parent");
                $(".menu_link").click(function () {
                    $(this).next("ul").slideToggle(400);
                    return false;
                });
                $(".menu_link").toggle(function () {
                    $(this).addClass("active");
                }, function () {
                    $(this).removeClass("active");
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".custom-select").each(function () {
                    $(this).wrap("<span class='select-wrapper'></span>");
                    $(this).after("<span class='holder'></span>");
                });
                $(".custom-select").change(function () {
                    var selectedOption = $(this).find(":selected").text();
                    $(this).next(".holder").text(selectedOption);
                }).trigger('change');
            })
        </script>
    </head>
    <body class="home">
        <!----Top Start---->
        <?php include('includes/header_top.inc.php'); ?>
        <!----Top End----> 
        <!----header Start---->
        <div align="center">
            <form method="POST" id="frmRegister" name="frmRegister" onsubmit="return frmvalidate(this.id)" enctype="multipart/form-data">
                <input type="text" name="txtName" class="required" placeholder="Name your job : *" /><br/>
                <textarea name="description" class="required" placeholder="Description"></textarea>
                <div id="filegroup">
                    <div class="files">
                    <input type="file" name="files[]" /> <a href="javascript:;" onclick="addFile();">Add more</a>
                    </div>
                </div>
                <br/>
                <label>Select the Catagory of Assignment: </label>
                <select name="cmbCategory" id="cmbCategory" class="required" onchange="getSubcat(this.value,'');">
                    <option value="">-Select-</option>
                    <?php foreach($arrCategory as $intKey=>$strValue):?>
                        <option value="<?php echo $strValue['id'];?>"><?php echo $strValue['name'];?></option>
                    <?php endforeach;?>
                </select>
                <div id="subCat"></div>
                <br/>
                <label>Request specific skills or groups (optional)</label>
                <select name="cmbSkills[]" multiple="" id="cmbSkills">
                    <option value="">-Select-</option>
                </select>
                <br/>
                <select id="workTypeField" class="required" name="workType" onchange="setWorkType(this.value);">
                    <option value="0" selected>Fixed</option>
                    <option value="1">Hourly</option>
                </select>
                <select  id="fixedBudget" class="required" name="fixedBudget" onchange="setMinMax(this.value);">
                    <option value="">- Select budget -</option>
                    <option value="Less than $500" class="selectOption_fixedBugdet ">Less than $500</option>
                    <option value="Between $500 and $1,000" class="selectOption_fixedBugdet ">Between $500 and $1,000</option>
                    <option value="Between $1,000 and $5,000" class="selectOption_fixedBugdet ">Between $1,000 and $5,000</option>\
                    <option value="Between $5,000 and $10,000" class="selectOption_fixedBugdet ">Between $5,000 and $10,000</option>
                    <option value="More than $10,000" class="selectOption_fixedBugdet ">More than $10,000</option>
                    <option value="1" class="selectOption_fixedBugdet ">Enter my own range</option>
                </select>
                <select id="hourlyRate" name="hourlyRate" style="display: none;" onchange="setMinMax(this.value);">
                    <option value="">- Select hourly rate -</option>
                    <option >Less than $10 / hr</option>
                    <option value="About $10 to $15 / hr">About $10 to $15 / hr</option>
                    <option value="About $15 to $20 / hr">About $15 to $20 / hr</option>
                    <option value="About $20 to $30 / hr">About $20 to $30 / hr</option>
                    <option value="About $30 to $40 / hr">About $30 to $40 / hr</option>
                    <option value="About $40 to $50 / hr">About $40 to $50 / hr</option>
                    <option value="More than $50 / hr">More than $50 / hr</option> 
                    <option value="1" >Enter my own range</option> 
                </select>
                <div id="CustomRange" style="display: none;">
                    <input type="text" name="txtMin" class="onlynumber" placeholder="Enter minimum value: *" />
                    <br/>
                    <input type="text" name="txtMax" class="onlynumber" placeholder="Enter maximum value: *" />
                </div>
                <br/>
                <label>End date : </label>
                <input type="text" name="end_date" id="datepicker" />
                <input type="hidden" name="hdnFileCnt" value="1" id="hdnFileCnt" />
                <input type="submit" name="btnPost" value="Continue" />
            </form>
        </div>
        <!----mid End----> 
        <!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?>
    </body>
</html>
<script type="text/javascript">
    function getSubcat(intCat,intSelect)
    {
        jQuery.ajax({
                url: 'ajax.php',
                data: {intSelect:intSelect,intCat:intCat,CMD:"GET_SUBCATEGORY"},
                type: 'POST',
                cache: true,
                success: function (data)
                {
                    var arrSk = data.split('~~~~');
                    jQuery("#subCat").html(arrSk[0]);
                    jQuery("#cmbSkills").html(arrSk[1]);
                }
            });
    }
    function setWorkType(strVal)
    {
        if(strVal==1)
        {
            jQuery("#hourlyRate").show();
            jQuery("#hourlyRate").addClass("required");
            jQuery("#fixedBudget").hide();
            jQuery("#fixedBudget").removeClass("required");
        }
        else
        {
            jQuery("#fixedBudget").show();
            jQuery("#fixedBudget").addClass("required");
            jQuery("#hourlyRate").hide();
            jQuery("#hourlyRate").removeClass("required");
        }
    }
    function setMinMax(intCt)
    {
        if(intCt==1)
        {
           jQuery("#CustomRange").show(); 
        }
        else
        {
            jQuery("#CustomRange").hide(); 
        }
    }
    function addFile()
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        if(intCnt==10 || intCnt>10)
        {
            alert("Maximum 10 files allowed");
            return false;
        }
        jQuery.ajax({
                url: 'ajax.php',
                data: {CMD:"ADD_FILE"},
                type: 'POST',
                cache: true,
                success: function (data)
                {
                    jQuery("#filegroup").append(data);
                    jQuery("#hdnFileCnt").val(intCnt+1);
                }
            });
        
    }
    function removeFile(strObj)
    {
        var intCnt = parseInt(jQuery("#hdnFileCnt").val());
        jQuery(strObj).parent("div.files").remove();
        jQuery("#hdnFileCnt").val(intCnt-1);
    }
  jQuery(function() {
    jQuery("#datepicker" ).datepicker({
        minDate:1
    });
  });
  
</script>    