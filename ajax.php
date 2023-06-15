<?php
include 'connect.php';
session_start();
if ((isset($_SESSION['poster']))) {
	if ($_SESSION['poster'] !== 'PostYES') {
		$arr = array();
		$reply = array();
		$arr = ['ok'=>false, 'status'=>'user not authorized'];
		array_push($reply, $arr);
		print_r(json_encode($reply));
	}
} else {
	die('not authorized');
}
global $mysqli;
$headers = apache_request_headers();
foreach ($_GET as $key=>$value) {
	$_GET[$key] = mysqli_real_escape_string($mysqli, $value);
}
if (isset($_GET['type'])) {
	$arr = array();
	$reply = array();
	if ($_GET['type'] == 'changeState') {
		$botId = preg_replace('/\D/', '', $_GET['botId']);
		$query = "UPDATE poster_bots SET del = ".$_GET['state']." WHERE id='".$botId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'changed to '.$_GET['state']];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'saveBot') {
		$botId = preg_replace('/\D/', '', $_GET['botId']);
		if ($_GET['typeRecepient']=='true') {
			$type = 1;
		} else {
			$type = 0;
		}
		if ($_GET['share'] == 'true') {
			$share = '1';
		} else {
			$share = '0';
		}
		$query = "UPDATE poster_bots SET chanName='".$_GET['chanName']."', botName='".$_GET['botName']."', comment='".$_GET['comment']."', typeRecepient=".$type.", public=".$share." WHERE id='".$botId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'Bot #'.$_GET['botId'].' saved'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'addBot') {
		if ($_GET['checked'] == 'true') {
			$type = '1';
		} else {
			$type = '0';
		}
		if ($_GET['share'] == 'true') {
			$share = '1';
		} else {
			$share = '0';
		}
		if ($_GET['botnet'] === 'vk') {
			$group = $_GET['botName'];
			$group = substr($group, strrpos($group, '/')+1, strlen($group));
			$queryVkToken = "SELECT vkToken FROM poster_robots WHERE del='0' AND social='vk' AND region='".$_SESSION['region']."' AND (public='1' OR ownerId='".$_SESSION['login']."') LIMIT 1";
			$getToken = $mysqli->query($queryVkToken)->fetch_assoc();
			$params = array();
			$params['access_token'] = $getToken['vkToken'];
			$params['v'] = 5.131;
			$params['group_ids'] = $group;
			$url = "https://api.vk.com/method/groups.getById?".http_build_query($params);
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($curl);
			curl_close($curl);
			$response = json_decode($json, true);
			if ((!isset($response['error'])) && (!isset($response['error']['error_msg']))) {
				$groupId = $response['response'][0]['id'];
				$query = "INSERT INTO poster_bots (`chanName`, `botName`, `comment`, `typeRecepient`, `public`, `owner`, `region`, `social`, `groupIds`) VALUES ('".$_GET['chanName']."', '".$groupId."', '".$_GET['comment']."', '".$type."', '".$share."', '".$_SESSION['login']."', '".$_SESSION['region']."', '".$_GET['botnet']."', '[\"1\"]')";
				$result = $mysqli->query($query);
				if ($result) {
					$arr = ['ok'=>true, 'status'=>'New bot added'];
					array_push($reply, $arr);
					print_r(json_encode($reply));
				}
			} else {
				$arr = ['ok'=>true, 'status'=>$response['error']['error_msg']];
				array_push($reply, $arr);
				print_r(json_encode($reply));
			}
		} elseif ($_GET['botnet'] === 'ok') {
			$page = file_get_contents($_GET['botName']);
			preg_match_all('/st\.groupId=([0-9]*)"/', $page, $match);
			$groupId = preg_replace('/\D/', '', $match[0][0]);
			$query = "INSERT INTO poster_bots (`chanName`, `botName`, `comment`, `typeRecepient`, `public`, `owner`, `region`, `social`, `groupIds`) VALUES ('".$_GET['chanName']."', '".$groupId."', '".$_GET['comment']."', '".$type."', '".$share."', '".$_SESSION['login']."', '".$_SESSION['region']."', '".$_GET['botnet']."', '[\"1\"]')";
			$result = $mysqli->query($query);
			if ($result) {
				$arr = ['ok'=>true, 'status'=>'New bot added'];
				array_push($reply, $arr);
				print_r(json_encode($reply));
			}
		} else {
			$query = "INSERT INTO poster_bots (`chanName`, `botName`, `comment`, `typeRecepient`, `public`, `owner`, `region`, `social`, `groupIds`) VALUES ('".$_GET['chanName']."', '".$_GET['botName']."', '".$_GET['comment']."', '".$type."', '".$share."', '".$_SESSION['login']."', '".$_SESSION['region']."', '".$_GET['botnet']."', '[\"1\"]')";
			$result = $mysqli->query($query);
			if ($result) {
				$arr = ['ok'=>true, 'status'=>'New bot added'];
				array_push($reply, $arr);
				print_r(json_encode($reply));
			}			
		}
	} elseif ($_GET['type'] == 'addUser') {
		$query = "INSERT INTO poster_users (`userName`, `userPass`, `userFIO`, `userRole`, `userRegion`) VALUES ('".$_GET['userName']."', MD5('".$_GET['userPass']."'), '".urldecode($_GET['userFIO'])."', '1','".urldecode($_GET['region'])."')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'New user added'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'changeStateUser') {
		$userId = preg_replace('/\D/', '', $_GET['userId']);
		$query = "UPDATE poster_users SET del = ".$_GET['state']." WHERE userId='".$userId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'changed to '.$_GET['state']];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'saveUser') {
		$userId = preg_replace('/\D/', '', $_GET['userId']);
		$query = "UPDATE poster_users SET userName='".$_GET['userName']."', userFIO='".urldecode($_GET['userFIO'])."', userRole='".$_GET['userRole']."' WHERE userId='".$userId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'User saved'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'changeUserPass') {
		$userId = preg_replace('/\D/', '', $_GET['userId']);
		$query = "UPDATE poster_users SET userPass='".MD5($_GET['userPass'])."' WHERE userId='".$userId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'User password changed'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'addvkrobot') {
		$userId = preg_replace('/\D/', '', $_GET['author']);
		if ($_GET['share']=='on') {
			$share = 1;
		} else {
			$share = 0;
		}
		$query = "INSERT INTO poster_robots (`ownerId`, `region`, `public`, `social`, `vkId`, `vkToken`) VALUES ('".$_SESSION['login']."', '".$_SESSION['region']."', '".$share."', '".$_GET['social']."', '".$_GET['userid']."', '".$_GET['token']."')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'vkRobot added'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	}  elseif ($_GET['type'] == 'addokrobot') {
		$userId = preg_replace('/\D/', '', $_GET['author']);
		if ($_GET['share']=='on') {
			$share = 1;
		} else {
			$share = 0;
		}
		$query = "INSERT INTO poster_robots (`ownerId`, `region`, `public`, `social`, `okToken`) VALUES ('".$_SESSION['login']."', '".$_SESSION['region']."', '".$share."', '".$_GET['social']."', '".$_GET['token']."')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'okRobot added'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'addtgrobot') {
		$query = "INSERT INTO poster_robots (`ownerId`, `region`, `social`, `tgSessionName`) VALUES 
		('".$_SESSION['login']."', '".$_SESSION['region']."', 'tg', '".md5('telega'.$_SESSION['username'])."')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'tg session created', 'session'=>md5('telega'.$_SESSION['username'])];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'sendback') {
		$text = mysqli_real_escape_string($mysqli, $_GET['text']);
		$query = "INSERT INTO poster_wish (`author`, `text`) VALUES ('".$_SESSION['login']."', '".$text."')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'wish sended'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'removevkrobot') {
		$query = "UPDATE poster_robots SET del='1' WHERE id='".$_GET['robot']."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'vkRobot removed'];
			array_push($reply, $arr);
			print_r(json_encode($reply));
		}
	} elseif ($_GET['type'] == 'changebotstate') {
		$groupId = $_GET['group'];
		$botId = $_GET['botId'];
		$state = $_GET['state'];
		$query = "SELECT * FROM poster_bots WHERE del='0' AND (owner='".$_SESSION['login']."' or public='1') AND id='".$botId."'";
		$result = $mysqli->query($query)->fetch_assoc();
		if ($result['groupIds'] != '') {
			$groups = json_decode($result['groupIds']);
		} else {
			$group = array();
		}
		$msg = '';
		if ($state == 'true') {
				if (!in_array($groupId, $groups)) {
					array_push($groups, $groupId);
					$msg = 'Bot added to group';
				} else {
					$msg = 'Bot already in group';
				}
		} else {
			if (($key = array_search($groupId, $groups)) !== false) {
				unset($groups[$key]);
			}
			$msg = 'Bot removed from group';
		}
		$query = "UPDATE poster_bots SET groupIds='".json_encode($groups)."' WHERE id='".$botId."'";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'Group bots changed. '.$msg];
			array_push($reply, $arr);
		} else {
			$arr = ['ok'=>false, 'status'=>'Error group change. '.$msg];
			array_push($reply, $arr);			
		}
		print_r(json_encode($reply));
		
	} elseif ($_GET['type'] == 'drawbots') {
		$groupId = (int)$_GET['group'];																									//'%\"7\"%'
		$query = 'SELECT * FROM poster_bots WHERE del="0" AND (owner="'.$_SESSION['login'].'" or public="1") AND groupIds LIKE "%\"'.$groupId.'\"%"';
		$result = $mysqli->query($query);
		$response = '';
		foreach ($result as $value) {
			$response .= "<div class='botUnit'><input name='bot_".$value['id']."' type='checkbox' checked><label for='bot_".$value['id']."'>".$value['chanName']."</label><div class='botHelper'>".$value['comment']."</div></div>";
		}
		$arr = ['ok'=>true, 'status'=>'Group changed', 'response'=>$response];
		array_push($reply, $arr);
		print_r(json_encode($reply));
	} elseif ($_GET['type'] == 'drawgroups') {
		$query = "SELECT * FROM poster_groups WHERE del='0' AND region='".$_SESSION['region']."' AND social='".$_GET['group']."'";
		$result = $mysqli->query($query);
		if ($result->num_rows > 0) {
			$response = "<div class='groupList'>";
			foreach ($result as $value) {
				$response .= "<div class='groupLink' id='".$value['id']."' onclick='drawGroupBots(this)';>
					<div class='groupItems'>
						<div class='groupItem'>".$value['id']."</div>
						<div class='groupItem'>".$value['groupName']."</div>
					</div>
				</div>";
			}
			$response .= '</div>';
		}
		$arr = ['ok'=>true, 'status'=>'Social selected', 'response'=>$response];
		array_push($reply, $arr);
		print_r(json_encode($reply));		
	}
} elseif (isset($headers['type'])) {
	if ($headers['type']=='addpost') {
		$arr = array();
		$postHeader = $headers['postheader'];
		$postText = $headers['posttext'];
		$anon = $headers['anon'];
		$bots = json_decode($headers['bots']);
		$botList = '';
		foreach ($bots as $bot) {
			$botList .= preg_replace('/\D/', '', $bot).',';
		}
		$deny = array('phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
			'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html', 
			'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi', 'exe');
		$file = $_FILES['file']['name'];
		$ext = pathinfo($file,PATHINFO_EXTENSION);
		if ($headers['filevideo'] != '') {
			$fileName = $headers['filevideo'];
		} else {
			if ((isset($_FILES['file']['name'])) && (!in_array(strtolower($ext), $deny))) {
				$uploaddir = 'files/';
				$sub = time();
				$uploadfile = $uploaddir . basename($sub.'_'.$_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
				$file = $sub.'_'.$_FILES['file']['name'];
			}
			$fileName = basename($sub.'_'.$_FILES['file']['name']);
		}
		if ($anon == 'true') {
			$anon = 1;
		} else {
			$anon = 0;
		}
		$query = "INSERT INTO poster_posts (`postHeader`, `postMedia`, `postText`, `postRecepients`, `postDate`, `author`, `authorId`, `anon`, `report`) 
				VALUES ('".urldecode($postHeader)."', '".$fileName."', '".urldecode($postText)."', '".$botList."', '".date("Y-m-d H:i:s")."', '".$_SESSION['fio']."','".$_SESSION['login']."', '".$anon."', '-')";
		$result = $mysqli->query($query);
		if ($result) {
			$arr = ['ok'=>true, 'status'=>'New post added'];
			print_r (json_encode($arr));
		}
	}
}
?>