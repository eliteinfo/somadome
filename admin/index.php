<?php
session_start();
include_once '../lib/base.php';
if($_SESSION['adminid'] == '')
{
    $objData->redirect('login.php');
}
else
{
    $objData->redirect('dashboard.php');
}
?>
