<?php include 'layouts/header.php';
$id= $_GET['ref'];
if(deletead($conn,$id))
{  
    redirection('ad_edit.php');
}
