<?php
if (!mysqli_query($conn, "SELECT * FROM users")) {
	$users = "CREATE TABLE users (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	full_name VARCHAR(100) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	sex VARCHAR(10) NOT NULL,
	birthday DATE NOT NULL
	)";
	if (!mysqli_query($conn, $users)) {
		echo 'Error creating table users: ' . mysqli_error($conn);
	}
	$usersArr = array(
		array('Акушева Т.Б.', '+79116289456', 'Женский', '1983-07-12'),
		array('Иванов П.С.', '+78128731569', 'Мужской', '1999-11-23'),
		array('Курочкин Б.Г.', '+79219758414', 'Мужской', '1976-11-02'),
		array('Петров В.В.', '+79315569513', 'Мужской', '1989-06-30'),
		array('Пиянзин Д.М.', '+79114876226', 'Мужской', '1968-09-21'),
		array('Пликина О.Б.', '+79255145486', 'Женский', '1970-08-19'),
		array('Сидорова М.Ю.', '+79059593259', 'Женский', '1995-01-28'),
		array('Смирнова С.В.', '+79545627841', 'Женский', '1984-04-11'),
		array('Смирнова Т.Ю.', '+79214158762', 'Женский', '1986-03-14'),
		array('Теремков Е.А.', '+79601476536', 'Мужской', '1979-12-06')
	);
	foreach ($usersArr as $user) {
		$sql = "INSERT INTO users (full_name, phone, sex, birthday)
		VALUES ('" . $user[0] . "', '" . $user[1] . "', '" . $user[2] . "', '" . $user[3] . "')";
		if (!mysqli_query($conn, $sql)) {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	unset($sql);
}
if (!mysqli_query($conn, "SELECT * FROM userCase")) {
	$userCase = "CREATE TABLE userCase (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	action_name VARCHAR(100) NOT NULL,
	user_id INT(10),
	time VARCHAR(15) NOT NULL
	)";
	if (!mysqli_query($conn, $userCase)) {
		echo 'Error creating table userCase: ' . mysqli_error($conn);
	}
	$userCaseArr = array(
		'Вход',
		'Выход',
		'Подписка',
		'Авторизация',
		'Создание сообщения', 
		'Ответ на сообщение',
		'Удаление сообщения',
		'Загрузка аватара',
		'Удаление аватара',
		'Поиск на сайте'
	);
	if ($result = mysqli_query($conn, "SELECT id FROM users")) {
		while ($row = mysqli_fetch_row($result)) {
			$actionsCount = 1;
			while ($actionsCount <= rand(1, 100)) {
				$start = mktime(0, 0, 0, 0, 0, 2015);
				$end  = time();
				$randomStamp = rand($start, $end);
				$sql = "INSERT INTO userCase (action_name, user_id, time)
				VALUES ('" . $userCaseArr[array_rand($userCaseArr)] . "', '" . $row[0] . "', '" . $randomStamp . "')";
				if (!mysqli_query($conn, $sql)) {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
				$actionsCount++;
			}
		}
		unset($sql);
		mysqli_free_result($result);
	}
}
?>