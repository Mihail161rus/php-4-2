<?php
$dsn = 'mysql:dbname=morlenko;host=localhost;charset=utf8';
$user = 'morlenko';
$password = 'neto1579';

try {
	$dbConnect = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}



echo '<pre>';
print_r($_POST);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Домашнее задание к лекции 4.2</title>
</head>
<body>
	<h1>Список дел</h1>

	<form method="POST">
		<input name="description" type="text" placeholder="Описание задачи">
		<input name="descEdit" type="submit" value="Добавить">
	</form>

	<table>
		<tr>
			<th>Описание задачи</th>
			<th>Дата добавления</th>
			<th>Статус</th>
			<th>Операции</th>
		</tr>
		
	</table>
</body>
</html>