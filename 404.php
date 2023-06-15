<?php
include 'connect.php';
global $mysqli;
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
				<div class='groupsContainer'>Что-то пошло не так..
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
<?php include 'footer.php'; ?>