<?php
include('../lib/module.php');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
    <h3>View Conversion</h3>
</div>
<div class="modal-body">
    <div class="scroller" style="height:300px;" data-always-visible="1" data-rail-visible1="1">
        <div class="row-fluid">
            <div class="portlet-body" id="chats">
                <div  data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        <?php
                        $from_user_init = $_REQUEST['user'];
                        $to_user_init = $_REQUEST['touser'];
                        $sql1 = "select * from tbl_messages where post_id = '" . $_REQUEST['id'] . "' and ((From_user='$from_user_init' and To_user ='$to_user_init') or (From_user='$to_user_init' and To_user ='$from_user_init') )  order by Create_date";
                        $db_message1 = $objModule->getAll($sql1);
                        for ($i = 0; $i < count($db_message1); $i++)
                        {
                            $From_user = $db_message1[$i]['From_user'];
                            $Message = $db_message1[$i]['Message'];
                            $Create_date = $db_message1[$i]['Create_date'];
                            $from_user_name = $objModule->getName("tbl_users", "CONCAT(fname,' ',lname) as name", "Id", $From_user);
                            //echo "<pre>";print_r($from_user_name);die;
                            $Photo = $objModule->getName("tbl_users", "Photo", "Id", $From_user);
                            //$Photo_to = getName("tbl_users","Photo","Id",$To_user);
                            if ($from_user_init == $From_user)
                            {
                                ?>
                                <li class="in">
                                <?php }
                                else
                                {
                                    ?>
                                <li class="out">
                                <?php } ?>
                                <?php
                                if ($Photo[0]['Photo']!= '' && file_exists("../upload/user/".$Photo[0]['Photo']))
                                {
                                    ?>
                                    <img class="avatar"  src="../upload/user/<?php echo $Photo[0]['Photo']; ?>">
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <img class="avatar"  src="../images/default.png">
                            <?php } ?>
                                <div class="message"> <span class="arrow"></span> 
                                    <a href="javascript:;" class="name"><?php echo $from_user_name[0]['name']; ?></a> <span class="datetime">at <?php echo date("M d, Y h:i A", strtotime($Create_date)); ?></span> <span class="body"><?php echo $Message; ?></span> </div>
                            </li>
    <?php }
?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Close</button>
</div>