<?php
if(isset($_POST['submit']))
{
    $strFile = "cat_csv.csv";
    if($_FILES['txtfile']['name']!='')
    {
    move_uploaded_file($_FILES['txtfile']['tmp_name'],"category_csv/cat_csv.csv");
    $arrData = readCSV("category_csv/cat_csv.csv");
    foreach($arrData as $intKey=>$strValue)
    {
       // CSV FORMAT SRNO, CATEGORY NAME, CATEGORY IMAGE, CATEGORY STATUS[default 1] 
       if($intKey!=0)
        {
            $objData->setTableDetails("tbl_category", "id");
            $objData->setFieldValues("name", $strValue[1]);
            $objData->setFieldValues("status",'1');
            $objData->setFieldValues("create_date",date("Y-m-d H:i"));
            $objData->insert();
        }
    } 
    }
    else
    {
        $objModule->setMessage("Please upload csv file","error");
    }
}
function readCSV($csvFile){
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle) ) {
		$line_of_text[] = fgetcsv($file_handle, 1024);
	}
	fclose($file_handle);
	return $line_of_text;
}
?>
<div class="page-content">
<div id="portlet-config" class="modal hide">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>portlet Settings</h3>
    </div>
    <div class="modal-body">
        <p>Here will be a configuration form</p>
    </div>
</div>
    <div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="color-panel hidden-phone">
                <div class="color-mode-icons icon-color"></div>
                <div class="color-mode-icons icon-color-close"></div>
                <div class="color-mode">
                    <p>THEME COLOR</p>
                    <ul class="inline">
                        <li class="color-black current color-default" data-style="default"></li>
                        <li class="color-blue" data-style="blue"></li>
                        <li class="color-brown" data-style="brown"></li>
                        <li class="color-purple" data-style="purple"></li>
                        <li class="color-white color-light" data-style="light"></li>
                    </ul>
                    <label class="hidden-phone">
                        <input type="checkbox" class="header" checked value="" />
                        <span class="color-mode-label">Fixed Header</span>
                    </label>
                </div>
            </div>
            <h3 class="page-title">Category</h3>
            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="dashboard.php">Home</a>
                    <span class="icon-angle-right"></span>
                </li>
                <li>
                    <a href="list_category.php">Category List</a>
                    <span class="icon-angle-right"></span>
                </li>
                <li>Add Category</li>
                <div class="btn-group" style="margin-top:-7px; float:right">
                    <a href="list_category.php"><button id="sample_editable_1_new" class="btn green">
                        List Category
                        </button></a>
                </div>
            </ul>
        </div>
    </div>
    <div class="row-fluid"><div class="span12"></div></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <h4><i class="icon-reorder"></i>Add Category</h4>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body form">
                    <form  method="post" id="form_sample_2" name="form_sample_3" class="form-horizontal" enctype="multipart/form-data">
                        <?php echo $objModule->getMessage();?>
                        <div class="alert alert-error hide">
                            <button class="close" data-dismiss="alert"></button>You have some form errors. Please check below.
                        </div>
                        <div class="control-group">
                            <label class="control-label">Upload File <span class="required">*</span></label>
                            <div class="controls">
                                <input type="file" name="txtfile" class="required"/>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" name="submit" class="btn blue" value="Add Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid"><div class="span12"></div></div>
    </div>
</div>
<script>
    function change_tech(id)
    {
        if(id!='')
        {
            $.ajax({
                type:'POST',
                url:"technology.php",
                data:'Id='+id,
                success: function(result)
                {
                    $('.tech_task_div').css('display','block');
                    $('.tech_task').html(result);
                }
            });
        }
        else
        {
            $('.tech_task_div').css('display','none');
        }
    }
    function change_tech_edit(id)
    {
        if(id!='')
        {
            $.ajax({
                type:'POST',
                url:"technology.php",
                data:'Id='+id,
                success: function(result)
                {
                    $('.tech_task_div_edit').css('display','block');
                    $('.tech_task_edit').html(result);
                }
            });
        }
        else
        {
            $('.tech_task_div_edit').css('display','none');
        }
    }

    function set_value()
    {
        var from_date = $("#dfrom").val();
        var tot_hours = $("#est_hrs").val();
        var r = false;
        if(from_date!='' && tot_hours!='')
        {
            $.ajax({
                url: 'ajax_get_date.php',
                data: {from_date:from_date,tot_hours:tot_hours},
                type: 'POST',
                success: function(data)
                {
                    var from_date = $("#dto").val(data);
                    r = true;
                }
            });
        }

        if(r){return true;}
        else{return false;}
    }

    function get_detail(site_status)
    {
        if(site_status=='demo')
        {
            $("#demo_detail").css("display","block");
            $("#live_detail").css("display","none");
        }
        if(site_status=='live')
        {
            $("#live_detail").css("display","block");
            $("#demo_detail").css("display","none");
        }
    }
</script>