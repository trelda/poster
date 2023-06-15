<?php
session_start();
$_SESSION['login']=0;
$_SESSION['poster']=0;
$_SESSION['fio']='';
session_destroy();
session_unset();
header('Location: '."index.php");
?>