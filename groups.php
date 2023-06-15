<?php
include 'connect.php';
global $mysqli;
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<?php if (isset($_POST['groupname'])) {
	$cyr = [' ', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'];
	$lat = ['', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya','A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'];
	$groupname = mysqli_real_escape_string($mysqli, $_POST['groupname']);
	$social = mysqli_real_escape_string($mysqli, $_POST['social']);
	$region = $_SESSION['region'];
	$alias = strtolower(str_replace($cyr, $lat, mysqli_real_escape_string($mysqli, $_POST['groupname'])));
	$query = "INSERT INTO poster_groups (`groupName`, `region`, `alias`, `social`, `addDate`, `authorId`) VALUES ('".$groupname."', '".$region."', '".$alias."', '".$social."', '".date("Y-m-d H:i:s")."', '".$_SESSION['login']."')";

	$result = $mysqli->query($query);
	if ($result) {
		header('Location: groups.php');
	} else {
		header('Location: 404.php');
	}
} else { ?>
<div id='page-wrapper'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='bot_container'>
				<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
				<div class='groupsContainer mainContainerGr'>
					<form action='#' method='post' style='display:flex; flex-direction: column'>
						<div class=''>
							<label for='social'>Социальная сеть:</label>
							<select class='bot_table_field' name='social' required>
								<option value='tg'>tg</option>
								<option value='vk'>vk</option>
								<option value='ok'>ok</option>
							</select>
						</div>
						<div class='groupAdd'>
							<label for='groupname'>Название группы:</label>
							<input type='text' name='groupname' id='groupname' required class="bot_table_field" style="margin-bottom: 30px;">
							<input type='submit' class='addGroup'>
						</div>
					</form>
					<div class='groupsList'>
						<?php $query = "SELECT * FROM poster_groups WHERE del='0' AND region='".$_SESSION['region']."'";
							$result = $mysqli->query($query);
							if ($result->num_rows == 0) echo "<div>Группы отсутствуют</div>";
							foreach ($result as $value) {
								echo "<a class='groupLink' href='group.php?id=".$value['id']."&social=".$value['social']."'><div class='groupItems'>";
									echo "<div class='groupItem'>".$value['id']."</div>";
									echo "<div class='groupItem'>".$value['groupName']."</div>";
								echo "</div></a>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<?php endif; ?>
<?php include 'footer.php'; ?>