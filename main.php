<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<div id='page-wrapper'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='bot_container'>
			<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
				<div class="bot_header">Таблица соответствия тг-каналов и их ботов-предложек/людей</div>
				<div class="bot_add">
					<div class="table_header">
						<span>Добавление ботов/людей в таблицу</span>
					</div>
					<table border="0" cellpadding="0" cellspacing="0" class="bot_table">
						<thead>
							<tr>
								<th class="table_header_bot">Соцсеть
								</th>
								<th class="table_header_bot">Название канала
								</th>
								<th class="table_header_bot">Бот/человек с @/ссылка на группу(ОК/ВК)
								</th>
								<th class="table_header_bot">Комментарий
								</th>
								<th class="table_header_bot">Человек
								</th>
								<th class="table_header_bot">Публичный
								</th>
								<th class="table_header_bot">Добавить
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bot_table_cell">
									<div class='socialContainer'>
										<select class='socialSelector'>
											<option />
											<option value='tg'>tg</option>
											<option value='vk'>vk</option>
											<option value='ok'>ok</option>
										</select>
									</div>
								</td>
								<td class="bot_table_cell">
									<input type="text" class="bot_table_field" />
								</td>
								<td class="bot_table_cell">
									<input type="text" class="bot_table_field" />
								</td>
								<td class="bot_table_cell">
									<input type="text" class="bot_table_field" />
								</td>
								<td class="bot_table_cell">
									<input type="checkbox" name="typeRecepient" class="bot_table_field" />
								</td>
								<td class="bot_table_cell">
									<input type="checkbox" name="share" id="share" class="bot_table_field" />
								</td>
								<td class="bot_table_cell">
									<div class="addBot" onclick="addbot(this);"><span>Добавить</span></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
<?php
$query = "SELECT * FROM poster_bots WHERE region='".$_SESSION['region']."' and (owner='".$_SESSION['login']."' or public='1')";
$result = $mysqli->query($query);
$row = $result->num_rows;
if ($row > 0) : {
?>
				<div class="bot_list">
					<div class="table_header">
						<span>Таблица ботов-предложек/людей</span>
					</div>
					<table border="0" cellpadding="0" cellspacing="0" class="bot_table">
						<thead>
							<tr>
								<th class="table_header_bot" style='width: 100px;'>Соцсеть
								</th>
								<th class="table_header_bot">Название канала
								</th>
								<th class="table_header_bot">Имя бота-предложки/человека
								</th>
								<th class="table_header_bot">Комментарий
								</th>
								<th class="table_header_bot">Человек
								</th>
								<th class="table_header_bot">Публичный
								</th>
								<th class="table_header_bot">Отключить
								</th>
								<th class="table_header_bot">
								</th>
							</tr>
						</thead>
						<tbody>
<?php
foreach ($result as $key=>$val) {
?>
							<tr>
								<td class="bot_table_cell">
									<input type="text" id="social" class="bot_table_field" value="<?php echo $val['social']; ?>"  style='width: 100px;'/>
								</td>
								<td class="bot_table_cell">
									<input type="text" id="chanName" class="bot_table_field" value="<?php echo $val['chanName']; ?>"/>
								</td>
								<td class="bot_table_cell">
									<input type="text" id="botName" class="bot_table_field" value="<?php echo $val['botName']; ?>"/>
								</td>
								<td class="bot_table_cell">
									<input type="text" id="comment" class="bot_table_field" value="<?php echo $val['comment']; ?>"/>
								</td>
								<td class="bot_table_cell">
									<?php if ($val['social']==='tg') : ?>
										<input type="checkbox" <?php if ($val['typeRecepient']=='1') { echo 'checked'; } ?> id="typeRecepient" class="bot_table_field" />
									<?php endif; ?>
								</td>
								<td class="bot_table_cell">
									<input type="checkbox" <?php if ($val['public']=='1') { echo 'checked'; } ?> id="share" class="bot_table_field" />
								</td>
								<td class="bot_table_cell bot_table_cell_status">
									<input type="checkbox" <?php if ($val['del']=='1') { echo 'checked'; } ?> id="status_<?php echo $val['id']; ?>" onclick="changeState(this);"/>
								</td>
								<td class="bot_table_cell">
									<div class="buttonsBot">
										<div class="saveBot" id="botId_<?php echo $val['id']; ?>" onclick="saveBot(this);"><span>Сохранить</span></div>
									</div>
								</td>
							</tr>
<?php }; ?>
						</tbody>
					</table>
				</div>
<?php } endif; ?>
			</div>
		 </div>
	</div>
</div>

<?php endif; ?>
<?php include('footer.php'); ?>