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

if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$sql = "SELECT * FROM users WHERE id = " . $user_id;
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
	unset($sql);
	mysqli_free_result($result);
	
	$sql = "SELECT id, action_name, time FROM userCase WHERE user_id = " . $user_id . " ORDER BY time";
	$result = mysqli_query($conn, $sql);
	$userCases = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$userCases[] = $row;
	}
	unset($sql);
	mysqli_free_result($result);
}
unset($_GET);
mysqli_close($conn);
?>
<!doctype html>
<html style="font-size: 12px;">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo isset($user) ? $user['full_name'] : 'Пожалуйста, выберите пользователя на главной странице' ; ?></title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	</head>
	<body>
		<header class="border-bottom border-secondary">
			<h1 class="display-3 text-center">Тестовое задание "Фитнес Хаус"</h1>
			<p class="lead text-center">Автор: Костиков Александр Юрьевич <a href="mailto: kila14@yandex.ru">kila14@yandex.ru</a></p>
		</header>
		<main class="mb-5">
			<div class="container">
				<?php if (isset($user)) { ?>
					<h2 class="display-4 mt-5 mb-5 text-center"><?php echo $user['full_name']; ?></h2>
					<p>Пол: <?php echo $user['sex']; ?></p>
					<p>Телефон: <?php echo $user['phone']; ?></p>
					<p>День рождения: <?php echo date('d.m.Y', strtotime($user['birthday'])); ?></p>
					<h4 class="mt-5 mb-3 text-center">Действия пользователя</h4>
					<table class="table table-hover mb-5" style="font-size: 14px;">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Действие</th>
								<th scope="col">Время</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($userCases as $userCase) {
									echo '<tr>';
										foreach ($userCase as $index => $value) {
											switch ($index) {
												case 'id':
													echo '<th scope="row">' . $value . '</th>';
													break;
												case 'action_name':
													echo '<td>' . $value . '</td>';
													break;
												case 'time':
													echo '<td>' . date('d.m.Y H:i:s', $value) . '</td>';
													break;
											}
										}
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
					<a href="/" class="btn btn-primary mb-5">&larr; Все пользователи</a>
				<?php } else { ?>
					<h4 class="mt-5 mb-3 text-center">Пожалуйста, <a href="/">выберите</a> пользователя на главной странице.</h4>
				<?php } ?>
			</div>
		</main>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>