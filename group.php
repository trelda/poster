<?php
include 'connect.php';
global $mysqli;
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>
<?php if (is_numeric($_GET['id'])) {
	$region = $_SESSION['region'];
	$query = "SELECT id, groupName FROM poster_groups WHERE id='".mysqli_real_escape_string($mysqli, $_GET['id'])."' AND region='".$region."'";
	$result = $mysqli->query($query);
	$res = $result->fetch_assoc();
	$id = $res['id'];
	$groupName = $res['groupName'];
	if ($result->num_rows == 0) {
		echo "Группа не найдена";
	} else {
	?>
<div id='page-wrapper'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='bot_container'>
				<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
				<div class='groupsContainer'>
					<div class='groupsList'>
						<?php if ((isset($_GET['social'])) && ($_GET['social']!='')) {
							$querySocial = " AND social='".mysqli_real_escape_string($mysqli, $_GET['social'])."'";
						} else {
							$querySocial = '';
						}
						$query = "SELECT * FROM poster_bots WHERE region='".$_SESSION['region']."' AND (owner='".$_SESSION['login']."' or public='1') ".$querySocial;
							$result = $mysqli->query($query);
							if ($result->num_rows > 0) {
								echo "<h2>".$groupName."</h2>";
								echo "<div class='botList'>";
								foreach ($result as $value) {
									$check = '';
									if ($value['groupIds'] != null) {
										$check = (in_array($id, json_decode($value['groupIds']))) ? 'checked' : '';
									}
									echo "<div class='botUnit'>
											<input name='bot_".$value['id']."' id='bot_".$value['id']."' ".$check." type='checkbox' class='botFromList' onchange='changeBotState(this.checked, ".$id.", ".$value['id'].")'/>
											<label for='bot_".$value['id']."'>".strtoupper($value['social']).": ".$value['chanName']."</label>
											<div class='botHelper'>".$value['comment']."</div>
											</div>";
								}
								echo "</div>";
							} else {
								echo "Боты не найдены.";
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php }
} else {
	header('Location: 404.php'); 
}
?>
<?php endif; ?>
<?php include 'footer.php';
?>