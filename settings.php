<?php
include 'connect.php';
global $mysqli;
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
<div class='settingsContainer'>
	<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
	<div class='settingsHeader'>
		Настройки для подключенных аккаунтов ВКонтакте
	</div>
	<div class='addNewVkRobot'>
		<a style='text-decoration:none;width:180px;' href='https://oauth.vk.com/authorize?client_id=51465346&scope=notify,friends,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email&response_type=token'>
			<div class='getVkToken'>Получить токен</div>
		</a>
		<div class='robotElem nodisplay'>
			<div>Id пользователя ВК:</div><input type='text' id='vkRobotId' class='robotInput'/>
		</div>
		<div class='robotElem nodisplay'>
			<div>Токен пользователя ВК:</div><input type='text' id='vkRobotToken' style='width: 100%;' class='robotInput'/>
		</div>
		<div class='robotElem nodisplay' style='flex-direction: row;'>
			<div>Публичный:</div><input type='checkbox' id='vkRobotPublic' class='robotInput'/>
		</div>
		<div class='robotElem nodisplay'>
			<div class='addBot nomargin' onclick='addVkRobot(this, <?php echo $_SESSION['login']; ?>,"vk",<?php echo $_SESSION['region']; ?>)'><span>Добавить</span></div>
		</div>
	</div>
	<div>
		Доступные роботы:
<?php
$query = "SELECT id, vkId, vkToken FROM poster_robots WHERE del='0' AND social='vk' AND region='".$_SESSION['region']."' AND (public='1' OR ownerId='".$_SESSION['login']."')";
$result = $mysqli->query($query);
$row = $result->num_rows;
if ($row > 0) : {
?>
<?php foreach ($result as $key=>$val) { ?>
<div>userId: <?php echo $val['vkId']; ?></div>
<div style='overflow-x: scroll;'>token:&nbsp;<?php echo $val['vkToken']; ?></div>
<div class='addBot nomargin' style='margin-top: 20px;' onclick='removeVkRobot(<?php echo $val['id']; ?>);'><span>Отключить</span></div>
<?php }; ?>
<?php } endif; ?>
	</div>
</div>
<div class='settingsContainer'>
	<div class='settingsHeader'>
		Настройки для подключенных аккаунтов Одноклассники
	</div>
	<div class='addNewOkRobot'>
		<a style='text-decoration:none;width:180px;' href='https://connect.ok.ru/oauth/authorize?client_id=512001575035&scope=VALUABLE_ACCESS;LONG_ACCESS_TOKEN;GROUP_CONTENT;PHOTO_CONTENT;VIDEO_CONTENT&response_type=token&redirect_uri=https://poster.ru/ok.php'>
			<div class='getVkToken' style='width:180px;'>Получить токен</div>
		</a>
		<div class='robotElem nodisplay'>
			<div>Токен</div><input type='text' style='width: 100%;' id='okToken' class='robotInput'/>
		</div>
		<div class='robotElem nodisplay' style='flex-direction: row;'>
			<div>Публичный:</div><input type='checkbox' id='okRobotPublic' class='robotInput'/>
		</div>
		<div class='robotElem nodisplay'>
			<div class='addBot nomargin' onclick='addOkRobot(this, <?php echo $_SESSION['login']; ?>,"ok",<?php echo $_SESSION['region']; ?>)'><span>Добавить</span></div>
		</div>
	</div>
	<div>
		Доступные роботы:
<?php
$query = "SELECT id, okToken FROM poster_robots WHERE del='0' AND social='ok' AND region='".$_SESSION['region']."' AND (public='1' OR ownerId='".$_SESSION['login']."')";
$result = $mysqli->query($query);
$row = $result->num_rows;
if ($row > 0) : {
?>
<?php foreach ($result as $key=>$val) { ?>

<div>Token: <?php echo $val['okToken']; ?></div>
<div class='addBot nomargin' style='margin-top: 20px;' onclick='removeVkRobot(<?php echo $val['id']; ?>);'><span>Отключить</span></div>
<?php }; ?>
<?php } endif; ?>
	</div>
</div>
<?php
$query = "SELECT tgSessionName FROM poster_robots WHERE del='0' AND social='tg' AND region='".$_SESSION['region']."' AND (public='1' OR ownerId='".$_SESSION['login']."') ORDER BY id DESC";
$result = $mysqli->query($query);
$row = $result->num_rows;
if ($row > 0) {
	$tgSessName = $result->fetch_array()[0];
	
}
?>
<div class='settingsContainer'>
	<div class='settingsHeader'>
		Настройки для подключенных аккаунтов Телеграм
	</div>
	<div class='addBot nomargin' onclick='addTgRobot();'><span>Добавить</span></div>
	<div style='display: flex; flex-direction: row;'>
		<div>Сессия: </div>
		<div id='tgSession'><?php echo $tgSessName; ?></div>
	</div>
	<a href='/include/poster/tgposter.php' target='_blank' style='margin-top: 30px;text-decoration:none;'>
		<div id='tgBotActivate' class='addBot nomargin <?php if (file_exists('/include/poster/'.$tgSessName)) echo ' nodisplay'; ?>' style='color:#fff'>Активировать</div>
	</a>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>