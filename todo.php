<?php
include 'connect.php';
global $mysqli;
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<div id="report" class="report" onclick="closeReport();" style='z-index:999;'>&nbsp;</div>
<div class='settingsContainer'>
	<div>Планы дальнейшего развития:</div>
	<ul>
		<li>Выбор автора для отправки сообщений (ВК/ОК)</li>
		<li>Множественная загрузка изображений</li>
		<li>Ссылки на видео в Одноклассники</li>
		<li>Группировка соцсетей с привязкой к роботу</li>
		<li>"Прогрев" роботов</li>
		<li>User-agent/device генератор</li>
		<li>Метка группы соцсетей региональная/федеральная/политическая и т.п.</li>
	</ul>
	<div>Ваше предложение:</div>
	<textarea id='sendBack' rows='10' cols='45' style='resize:none;margin: 20px 0px'></textarea>
	<div class='addBot nomargin' onclick='sendBack()';>
		<div style='color: #fff;'>Отправить</div>
	</div>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>