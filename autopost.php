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
			<div class='bot_autopost'>
				<div id="report" class="report" onclick="closeReport();">&nbsp;</div>
				<div class="bot_header">Рассылка материала по ботам-предложкам</div>
				<div class="newAutopost">
					<div class="newAutopostHeader">
						<span class="autoHead">Заголовок:</span>
						<input type="text" id="autopostHeader" class="autopost_field" />
					</div>
					<div class="newAutopostMedia">
						<span class="autoHead">Медиа файл:</span>
						<div id="mediaSelector">
							<div class="mediaTypeSelect">Выберите тип медиа материала:</div>
							<div class='btnMediaList'>
								<div id='btnImageUpload' class='selectMedia botsActive' onclick="uploadImg();">Изображение</div>
								<div id='btnVideoUpload' class='selectMedia' onclick="uploadVideo();">Ссылка на видео</div>
							</div>
						</div>
						<div id="anonymousVk">
							<div class="anonymousVkContainer">
								<label for="anonymous">Опубликовать анонимно(в случае отсутствия модерации)</label>
								<input type="checkbox" name="anonymous" id="anonymous"/>
							</div>
						</div>
						<div id="fileContainerImg" class="fileContainer">
							<label for="fileImg" class="fileSelector">Выберите файл</label>
							<input type="file" id="fileImg" name="file" class="fileInput"/>
							<div id="fileName" class="fileName"></div>
						</div>
						<div id="fileContainerVideo" class="fileContainerVideo">
							<span class="autoHead">Добавьте ссылку: </span>
							<input type="text" id="fileVideo" name="file" class="autopost_field"/>
							<div id="fileName" class="fileName"></div>
						</div>
					</div>
					<div class="newAutopostText">
					<span class="autoHead">Содержание:</span>
						<textarea id="autopostText" class="autopostText"></textarea>
					</div>
					<span class="autoHead">Выберите получателей рассылки</span>
					<div class="socialSelect">
						<div style="display: flex;">
							<div class='sociaItemBtn' id='tgBtn' onclick="showGroups(this);">tg</div> <!-- showTgBots(); -->
							<div class='sociaItemBtn' id='vkBtn' onclick="showGroups(this);">vk</div>
							<div class='sociaItemBtn' id='okBtn' onclick="showGroups(this);">ok</div>
						</div>
						<div class='clearGroup sociaItemBtn' onclick="dropSelectedGroups();">Сброс</div>
					</div>

					<div id='groupsContainer'>&nbsp;</div>
					<div class="botList" id='groupBots'></div>
					<div class="sendButton" onclick="sendPost()">
						<span>Разослать</span>
					</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

<?php
include 'footer.php';
?>