<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['fio']) || ($_SESSION['fio'] == "Гость")) header('Location: '."index.php");
include('header.php');
?>
<?php if ((isset($_SESSION['login'])) && ($_SESSION['login']>0)) : ?>

<?php echo 'Посты автора "'.$_SESSION['fio'].'":'; ?>

<div class='reportPostsList'>

<?php
global $mysqli;
$query = "SELECT * FROM poster_posts WHERE authorId = '".$_SESSION['login']."' ORDER BY id DESC";
$result = $mysqli->query($query); ?>
<table cellpadding='0' cellspacing='0' class="reportTable">
<tr>
	<th>ID</th>
	<th>Текст</th>
	<th>Медиа</th>
	<th>Статус</th>
	<th>Ответ</th>
</tr>
<?php foreach ($result as $value) { ?>
<tr>
<td class='reportId'><?php echo $value['id']; ?></td>
<td class='reportText'><?php echo $value['postText']; ?></td>
<td class='reportMedia'><a target="_blank" href='files/<?php echo $value['postMedia']; ?>'>Click</a></td>
<td><?php $response = ($value['posted'] =='1') ? 'Разослано' : 'Ожидание'; echo $response; ?></td>
<td class='reportReport'><?php echo $value['report']; ?></td>
</tr>


<?php } ?>

</table>

</div>

<?php endif; ?>
<?php include 'footer.php'; ?>