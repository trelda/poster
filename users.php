<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<div class='users_container'>
	<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
	<div class="users_header">Управление пользователями</div>
	<div class='addUser'>
		<table border="0" cellpadding="0" cellspacing="0" class="bot_table">
			<thead>
				<tr>
					<th class="table_header_bot">Логин
					</th>
					<th class="table_header_bot">Пароль
					</th>
					<th class="table_header_bot">Ф.И.О.
					</th>
					<th class="table_header_bot">Добавить
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="bot_table_cell">
						<input type="text" id="addLogin" class="bot_table_field user_fields" />
					</td>
					<td class="bot_table_cell">
						<input type="text" id="addPass" class="bot_table_field user_fields" />
					</td>
					<td class="bot_table_cell">
						<input type="text" id="addFIO" class="bot_table_field user_fields" />
					</td>
					<td class="bot_table_cell bot_table_cell_status">
						<div class="addBot" onclick="addUser(this,<?php echo($_SESSION['region']); ?>);"><span>Добавить</span></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
$query = "SELECT * FROM poster_users where userRegion='".$_SESSION['region']."'";
$result = $mysqli->query($query);
$row = $result->num_rows;
if ($row > 0) : {
?>
	<div class='usersList'>
		<div class="table_header">
			<span>Пользователи системы</span>
		</div>
		<table border="0" cellpadding="0" cellspacing="0" class="bot_table">
			<thead>
				<tr>
					<th class="table_header_bot">Логин пользователя
					</th>
					<th class="table_header_bot">Фио пользователя
					</th>
					<th class="table_header_bot">Роль
					</th>
					<th class="table_header_bot">Отключить
					</th>
					<th>
					</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($result as $key=>$val) { ?>
				<tr>
					<td class="bot_table_cell">
						<input type="text" id="userName" class="bot_table_field" value="<?php echo $val['userName']; ?>"/>
					</td>
					<td class="bot_table_cell">
						<input type="text" id="userFIO" class="bot_table_field" value="<?php echo $val['userFIO']; ?>"/>
					</td>
					<td class="bot_table_cell">
						<input type="text" id="userName" class="bot_table_field" value="<?php echo $val['userRole']; ?>"/>
					</td>
					<td class="bot_table_cell bot_table_cell_status" style="height:40px;">
						<div>
							<input type="checkbox" <?php if ($val['del']=='1') { echo 'checked';} ?> id="status_<?php echo $val['userId']; ?>" onclick="changeStateUser(this);"/>&nbsp;
						</div>
					</td>
					<td class="bot_table_cell">
						<div class="buttonsBot">
							<div class="saveUser" id="userId_<?php echo $val['userId']; ?>" onclick="saveUser(this);"><span>Сохранить</span></div>
							<div class="generatePass" id="genId_<?php echo $val['userId']; ?>" onclick="generatePass(this);"><span>Новый пароль</span></div>
							<div class="newPassField">12312d</div>
						</div>
					</td>
				</tr>
<?php }; ?>
			</tbody>
		</table>


	</div>
<?php } endif; ?>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>