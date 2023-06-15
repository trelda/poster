<?php
if (!isset($_SESSION)) {
	session_start();
}
?>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='include/css/main.css'/>
		<script type='text/javascript' src='https://code.jquery.com/jquery-latest.min.js'></script>
		<script type='text/javascript' src='include/js/main.js'></script>
	</head>
	<body>
	<div class='post_container'>
		<div class='menuTop'>
			<ul class="mainMenu">
				<li ><a href="dashboard.php">Главная</a></li>
				<li ><a href="main.php">Боты</a></li>
				<li><a href="autopost.php">Рассылка</a></li>
				<?php 
					if ($_SESSION['role']=='4') {
						echo '<li><a href="users.php">Пользователи</a></li>';
					}
				?>
				<li><a href="settings.php">Настройки</a></li>
				<li><a href="groups.php">Группы</a></li>
				<li><a href="reports.php">Отчеты</a></li>
				<li><a href="todo.php">Планы</a></li>
				<li style="float:right;display:flex;align-items: center;">
						<div style='float: left;color: #fff'>Добро пожаловать, <?php echo $_SESSION['fio']; ?></div>
						<a class="active" style='float:right' href="logout.php">Выход</a>
				</li>
			</ul>
		</div>
		<div class='mainContainer'>