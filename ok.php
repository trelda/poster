<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['login']) || (!isset($_SESSION['region']))) header('Location: '."index.php");

if (isset($_GET['access_token'])) {
	global $mysqli;
	$query = "INSERT INTO poster_robots (`ownerId`, `region`, `public`, `social`, `okToken`) VALUES 
	('".$_SESSION['login']."', '".$_SESSION['region']."', '0', 'ok', '".$_GET['access_token']."')";
	$result = $mysqli->query($query);
	header("Location: https://poster.ru/settings.php");
}
?>

<script type='text/javascript'>
let hash = window.location.hash;
if (hash != '' ){
	hash = hash.replace('#', '?');
	window.location.href = 'https://poster.ru/ok.php' + hash;
}
</script>