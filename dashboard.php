<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<div class='dashboard_container'>
	<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
	<div class="users_header">Статистика системы</div>
Пока не представляю что тут должно быть, открыт для всех идей ;)<br>
Это просто картинка в пайнте как пример
<img style="width:50%;" src="/include/img/tmp.png">
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>