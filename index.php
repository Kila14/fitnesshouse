<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$servername = 'db4free.net';
$username = 'fitnesshouse';
$password = 'O4j*nD2(4hA';
$dbname = 'fitnesshouse';
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die('Connection failed: ' . mysqli_connect_error());
}
include_once ('createBD.php');

if (isset($_POST['usersLoad'])) {
	$sql = "SELECT * FROM users";
	$result = mysqli_query($conn, $sql);
	$resultArray = array();
	while($row = mysqli_fetch_assoc($result)){
		$resultArray[] = $row;
	}
	echo json_encode($resultArray);
	return;
}
mysqli_close($conn);
?>
<!doctype html>
<html style="font-size: 12px;">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Пользователи</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	</head>
	<body>
		<header class="border-bottom border-secondary">
			<h1 class="display-3 text-center">Тестовое задание "Фитнес Хаус"</h1>
			<p class="lead text-center">Автор: Костиков Александр Юрьевич <a href="mailto: kila14@yandex.ru">kila14@yandex.ru</a></p>
		</header>
		<main class="mb-5">
			<div class="container">
				<h2 class="display-4 mt-5 text-center">Пользователи</h2>
				<div class="row mt-4" id="users"></div>
			</div>
		</main>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<script>
			$.ajax({
				type: 'POST',
				url: '/',
				data: 'usersLoad=true',
				dataType: 'json',
				beforeSend: function() {
					$('#users').html('<div class="h3 w-100 mt-5 text-center"><small>Пожалуйста, подождите ...</small></div>');
				},
				success: function(responce) {
					var usersLoad = '';
					for (var i = 0; i < responce.length; i++) {
						var birthday = new Date(responce[i]['birthday']);
						usersLoad +=
							'<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-5">' +
								'<div class="card">' +
									'<h5 class="card-header text-center">' + responce[i]['full_name'] + '</h5>' +
									'<div class="card-body">' +
										'<p class="card-text mb-2">Пол: ' + responce[i]['sex'] + '</p>' +
										'<p class="card-text mb-2">Телефон: ' + responce[i]['phone'] + '</p>' +
										'<p class="card-text mb-4">День рождения: ' + ('0' + birthday.getDate()).slice(-2) + '.' + ("0" + (birthday.getMonth() + 1)).slice(-2) + '.' + birthday.getFullYear() + '</p>' +
										'<div class="text-center"><a href="/userCase.php?user_id=' + responce[i]['id'] + '" class="btn btn-success">Действия пользователя</a></div>' +
									'</div>' +
								'</div>' +
							'</div>';
					}
					$('#users').html(usersLoad);
				}
			});
		</script>
	</body>
</html>