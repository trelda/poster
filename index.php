<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include('connect.php');
global $mysqli;
session_start();
if (isset($_SESSION['login'])) {
	header('Location: '."dashboard.php");
}
function isNameCorrect($name){ 
	if ((strlen($name)>2) && (preg_match("/^[a-z0-9-_]{2,20}$/i", $name))) {
		return true;
	} else {
		return false;
	}
};

function isUserExist($name) {
	if (isNameCorrect($name)) {
		$query = "SELECT userName FROM poster_users WHERE userName = '".$name."'";
		global $mysqli;
		$result = $mysqli->query($query);
		if($result->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
};

function isUserCorrect($name, $pass) {
	if (isNameCorrect($name)) {
		$userId = 0;
		global $mysqli;
		$query = "SELECT userId, userPass FROM poster_users WHERE userName = '".$name."'";
		$result = $mysqli->query($query)->fetch_assoc();
		if ($result['userPass'] == md5($pass)) {
			$userId = $result['userId'];
		}
	}
	return $userId;
};

function getUserFIO($name) {
	global $mysqli;
	$query = "SELECT userFIO FROM poster_users WHERE userName = '".$name."'";
	$result = $mysqli->query($query);
	if($result->num_rows > 0) {
		foreach ($result as $key=>$val) {
			return $val['userFIO'];	
		}
	} else {
		return '';
	}
};

function getUserParams($name) {
	global $mysqli;
	$query = "SELECT * FROM poster_users WHERE userName = '".$name."'";
	$result = $mysqli->query($query);
	if($result->num_rows > 0) {
		$params = [];
		foreach ($result as $key=>$val) {
			$params[$key]=$val;
		}
		return $params;
	} else {
		return '';
	}
};

echo "
<link rel='stylesheet' href='include/css/main.css'>
<div class='bgContainer'>
	
	<form class='loginForm' action=''>
	<h3 class='login-box-body'>Авторизация</h3>
		<div class='loginField'>
			<div class='loginText'>Login</div>
			<input type='text' name='user' />
		</div>
		<div class='passField'>
			<div class='passText'>Password</div>
			<input type='password' name='pass' />
		</div>
		<div class='submitField'>
			<input type='submit'>
		</div>
</div>

";
if ((isset($_GET['user'])) && (isset($_GET['pass']))) {
	if (isUserExist($_GET['user'])) {
		$userId = isUserCorrect($_GET['user'],$_GET['pass']);
		if ($userId > 0) {
			$a = getUserParams($_GET['user']);
			print_r($a[0]);
			$_SESSION["poster"]="PostYES";
			$_SESSION["login"]=$a[0]['userId'];
			$_SESSION["role"]=$a[0]['userRole'];
			$_SESSION["fio"]= $a[0]['userFIO'];
			$_SESSION["region"]= $a[0]['userRegion'];
			$_SESSION["username"] = $a[0]['userName'];
			header('Location: '."dashboard.php");
		} else {
			echo ("Имя/пароль не верны");
		}
	} else {
		echo "Введите имя/пароль";
	}
}
?>