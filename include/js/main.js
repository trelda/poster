function delay(data) {
	var timeDelay = 100;
	let a = document.getElementById('report');
	a.innerHTML = JSON.parse(data)[0]['status'];
	a.style.opacity = 1;
	const run = setInterval(frame, 50);
	function frame() {
		if (timeDelay == 0) {
			clearInterval(run);
			a.style.opacity = 0;
		} else {
			timeDelay--;
		}
	}
};

function changeState(elm) {
	$.ajax({
		url: 'ajax.php?type=changeState&botId='+elm.id+'&state='+elm.checked,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function changeStateUser(elm) {
	$.ajax({
		url: 'ajax.php?type=changeStateUser&userId='+elm.id+'&state='+elm.checked,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function saveBot(elm) {
	let chanName = elm.parentNode.parentNode.parentNode.children[1].children[0].value;
	let botName = elm.parentNode.parentNode.parentNode.children[2].children[0].value;
	let comment = elm.parentNode.parentNode.parentNode.children[3].children[0].value;
	let typeRecepient = elm.parentElement.parentElement.parentElement.children[4].children[0].checked;
	let share = elm.parentNode.parentNode.parentNode.children[5].children[0].checked;
	$.ajax({
		url: 'ajax.php?type=saveBot&botId='+elm.id+'&chanName='+encodeURI(chanName)+'&botName='+encodeURI(botName)+'&comment='+encodeURI(comment)+'&typeRecepient='+typeRecepient+'&share='+share,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function addbot(elm) {
	let botNet = elm.parentNode.parentNode.children[0].children[0].children[0].value;
	let chanName = elm.parentNode.parentNode.children[1].children[0].value;
	let botName = elm.parentNode.parentNode.children[2].children[0].value;
	let comment = elm.parentNode.parentNode.children[3].children[0].value;
	let typeRecepient = elm.parentNode.parentNode.children[4].children[0].checked;
	let share = elm.parentNode.parentNode.children[5].children[0].checked;
	if ((botNet!='') && (chanName!='') && (botName!='')) {
		$.ajax({
			url: 'ajax.php?type=addBot&chanName='+encodeURI(chanName)+'&botName='+encodeURI(botName)+'&comment='+encodeURI(comment)+'&checked='+typeRecepient+'&share='+share+'&botnet='+botNet,
			method: 'post',
			dataType: 'html',
			success: function(data){
				if (JSON.parse(data)[0]['ok']===true) {
					delay(data);
				} else {
					console.log('ajax error');
				}
			}
		});
	} else {
		var timeDelay = 100;
		let a = document.getElementById('report');
		a.innerHTML = 'Не все обязательные поля заполнены!';
		a.style.opacity = 1;
		const run = setInterval(frame, 50);
		function frame() {
			if (timeDelay == 0) {
				clearInterval(run);
				a.style.opacity = 0;
			} else {
				timeDelay--;
			}
		}
	}
};

function closeReport() {
	document.getElementById('report').style.opacity = 0;
};

function sendPost() {
	document.getElementsByClassName('sendButton')[0].style.pointerEvents = 'none';
	console.log('sendPost');
	let anon = document.getElementById('anonymous').checked;
	let header = document.getElementById('autopostHeader').value;
	let text = document.getElementById('autopostText').value;
	let fileVideo = document.getElementById('fileVideo').value;
	const files = document.querySelector('[name=file]').files;
	var formData = new FormData();
	console.log(files[0]);
	formData.append('file', files[0]);
	let elems = document.getElementsByClassName('botUnit');
	let botsArray = [];
	for (var i = 0; i < elems.length; i++) {
		if (elems[i].children[0].checked) {
			botsArray.push(elems[i].children[0].name);
		}
	}
 	const url = 'ajax.php';
	
	const request = new XMLHttpRequest();
	request.responseType = 'text';
	request.onload = () => {
		console.log(request.responseText);
		if (JSON.parse(request.responseText).ok==true) {
			document.getElementById('autopostHeader').value = '';
			document.getElementById('autopostText').value = '';
			let elems = document.getElementsByClassName('botUnit');
			for (var i = 0; i < elems.length; i++) {
				elems[i].children[0].checked = '';
			}
			var timeDelay = 100;
			let a = document.getElementById('report');
			a.innerHTML = JSON.parse(request.responseText).status;
			a.style.opacity = 1;
			const run = setInterval(frame, 50);
			function frame() {
				if (timeDelay == 0) {
					clearInterval(run);
					a.style.opacity = 0;
				} else {
					timeDelay--;
				}
			}
		}
		document.getElementsByClassName('sendButton')[0].style.pointerEvents = '';
	};
	request.open('POST', url, true);
	request.setRequestHeader('Access-Control-Allow-Headers', 'Content-Type');
	request.setRequestHeader('type', 'addpost');
	request.setRequestHeader('anon', anon);
	request.setRequestHeader('postheader', encodeURI(header));
	request.setRequestHeader('posttext', encodeURI(text));
	request.setRequestHeader('bots', JSON.stringify(botsArray));
	request.setRequestHeader('filevideo', fileVideo);
	request.send(formData);
};

document.addEventListener("DOMContentLoaded", function(event) {
	var f = document.getElementById('fileImg');
	if (f) {
		f.onchange = function() {
			document.getElementById('fileName').innerHTML = f.files[0].name;
		}
	}
});

function addUser(elm, reg) {
	let userName = document.getElementById('addLogin').value; 
	let userPass = document.getElementById('addPass').value;
	let userFIO = encodeURI(document.getElementById('addFIO').value);
	$.ajax({
		url: 'ajax.php?type=addUser&userName='+userName+'&userPass='+userPass+'&userFIO='+userFIO+'&region='+reg,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function saveUser(elm) {
	let userId = elm.id;
	let userName = elm.parentNode.parentNode.parentNode.children[0].children[0].value; 
	let userFIO = encodeURI(elm.parentNode.parentNode.parentNode.children[1].children[0].value);
	let userRole = elm.parentNode.parentNode.parentNode.children[2].children[0].value; 
	$.ajax({
		url: 'ajax.php?type=saveUser&userName='+userName+'&userFIO='+userFIO+'&userRole='+userRole+'&userId='+userId,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function generatePass(elm) {
	var alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        var pass = "";
        while (pass.length < 6) {
            pass += alphabet[Math.floor(Math.random() * alphabet.length)];
        }
	let userId = elm.id;
	elm.parentNode.children[2].innerHTML = pass;
	elm.parentNode.children[2].style.display = 'flex';
	$.ajax({
		url: 'ajax.php?type=changeUserPass&userPass='+pass+'&userId='+userId,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
				var timeDelay = 200;
				let a = elm.parentNode.children[2];
				const run = setInterval(frame, 50);
				function frame() {
					if (timeDelay == 0) {
						clearInterval(run);
						a.style.display = 'none';
					} else {
						timeDelay--;
					}
				}
			} else {
				console.log('ajax error');
			}
		}
	});
};

function clearBots() {
	document.querySelectorAll("input[type='checkbox']").forEach(item=>{
		item.checked = false;
	})
};

function addVkRobot(elm, id, social, region) {
	let user = elm.parentNode.parentNode.children[1].children[1].value;
	let token = elm.parentNode.parentNode.children[2].children[1].value;
	let share = elm.parentNode.parentNode.children[3].children[1].value;
	$.ajax({
		url: 'ajax.php?type=addvkrobot&userid='+user+'&token='+token+'&author='+id+'&social='+social+'&region='+region+'&share='+share,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			} else {
				console.log('ajax error');
			}
		}
	});
};

function removeVkRobot(id) {
	$.ajax({
		url: 'ajax.php?type=removevkrobot&robot='+id,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
				window.location.reload();
			} else {
				console.log('ajax error');
			}
		}
	});
};

function addOkRobot(elm, id, social, region) {
	let token = elm.parentNode.parentNode.children[1].children[1].value;;
	let share = elm.parentNode.parentNode.children[2].children[1].value;
	$.ajax({
		url: 'ajax.php?type=addokrobot&author='+id+'&social='+social+'&region='+region+'&share='+share+'&token='+token,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
				window.location.reload();
			} else {
				console.log('ajax error');
			}
		}
	});
};

function addTgRobot() {
	$.ajax({
		url: 'ajax.php?type=addtgrobot',
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				document.getElementById('tgSession').innerHTML = JSON.parse(data)[0]['session'];
				document.getElementById('tgBotActivate').classList.remove('nodisplay');
			}
		}
	});
};

function uploadImg() {
	document.getElementById('fileContainerVideo').style.display = 'none';
	document.getElementById('btnVideoUpload').classList.remove('botsActive');
	document.getElementById('fileContainerImg').style.display = 'flex';
	document.getElementById('btnImageUpload').classList.add('botsActive');
};

function uploadVideo() {
	document.getElementById('fileContainerVideo').style.display = 'flex';
	document.getElementById('btnVideoUpload').classList.add('botsActive');
	document.getElementById('fileContainerImg').style.display = 'none';
	document.getElementById('btnImageUpload').classList.remove('botsActive');
};

function sendBack() {
	let text = document.getElementById('sendBack').value;
	$.ajax({
		url: 'ajax.php?type=sendback&text='+text,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				document.getElementById('sendBack').value = '';
				delay(data);
			}
		}
	});
};

function changeBotState(elm, groupId, botId) {
		$.ajax({
		url: 'ajax.php?type=changebotstate&group=' + groupId + '&botId=' + botId + '&state=' + elm,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
			}
		}
	});
};

function drawBots(elm) {
	$.ajax({
		url: 'ajax.php?type=drawbots&group=' + elm.id,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok']===true) {
				delay(data);
				document.getElementsByClassName('botList')[0].innerHTML = JSON.parse(data)[0]['response'];
			}
		}
	});
};

function showGroups(elm) {
	var type = elm.innerHTML;
	$.ajax({
		url: 'ajax.php?type=drawgroups&group=' + type,
		method: 'post',
		dataType: 'html',
		success: function(data){
			if (JSON.parse(data)[0]['ok'] === true) {
				delay(data);
				document.getElementById('groupsContainer').innerHTML = JSON.parse(data)[0]['response'];
				redrawSocialItemBtn(type);
			}
		}
	});
};

function redrawSocialItemBtn(type) {
	document.getElementById('groupBots').innerHTML = '';
	type = type + 'Btn';
	let elms = document.getElementsByClassName('sociaItemBtn');
	for (var i = 0; i < elms.length; i++) {
		if (elms[i].id === type) {
			elms[i].classList.add('botsActive');
		} else {
			elms[i].classList.remove('botsActive');			
		}
	}
	if (type === 'vkBtn') {
		document.getElementById('anonymousVk').style.display = 'block';
	} else {
		document.getElementById('anonymousVk').style.display = 'none';
	}
	if (type === 'okBtn') {
		document.getElementById('mediaSelector').style.display = 'block';
	} else {
		document.getElementById('mediaSelector').style.display = 'none';
	}
};

function drawGroupBots(elm) {
	var group = elm.id;
	$.ajax({
		url: 'ajax.php?type=drawbots&group=' + group,
		method: 'post',
		dataType: 'html',
		success: function(data) {
			if (JSON.parse(data)[0]['ok'] === true) {
				delay(data);
				document.getElementById('groupBots').innerHTML = JSON.parse(data)[0]['response'];
			}
		}
	});
};

function dropSelectedGroups() {
	let elems = document.getElementsByClassName('botUnit');
	for (var i = 0; i < elems.length; i++) {
		elems[i].children[0].checked = '';
	}
};