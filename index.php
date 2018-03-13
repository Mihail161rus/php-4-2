<?php
$dsn = 'mysql:dbname=morlenko;host=localhost;charset=utf8';
$user = 'morlenko';
$password = 'neto1579';
$taskStatus = 0;
$description = '';
$infoText = '';
const TASK_IN_PROCESS = 1;
const TASK_IS_DONE = 2;

try {
	$db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

/*Функция возвращает название статуса*/
function getStatusName($param)
{
    switch($param) {
        case TASK_IN_PROCESS:
            return 'в процессе';
            break;
        case TASK_IS_DONE:
            return 'выполнено';
            break;
        default:
            return '';
            break;
    }
}

/*Добавляем задачу в список*/
if(isset($_POST) && !empty($_POST['description'])) {
    $description = $_POST['description'];

    $sqlAdd = "INSERT INTO tasks (description, is_done, date_added) VALUES (?, ?, NOW())";
    $statement = $db->prepare($sqlAdd);
    $statement->execute([$description, TASK_IN_PROCESS]);
} elseif(isset($_POST['description']) && empty($_POST['description'])) {
    $infoText = 'Вы не заполнили поле "Описание задачи". Задача не добавлена.';
}

$statement = $db->prepare("SELECT * FROM tasks");
$statement->execute();

echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Домашнее задание к лекции 4.2</title>

    <style>
        table {
            border-collapse: collapse;
            border: 1px solid;
        }

        th {
            background-color: #eeeeee;
        }

        th, td {
            padding: 4px 10px;
            border: 1px solid;
        }
    </style>
</head>
<body>
	<h1>Список дел</h1>

	<form method="POST">
		<input name="description" type="text" placeholder="Описание задачи">
		<input name="descEdit" type="submit" value="Добавить">
	</form>

    <p style="color: red"><?=$infoText?></p>

	<table>
		<tr>
			<th>Описание задачи</th>
			<th>Дата добавления</th>
			<th>Статус</th>
			<th>Операции</th>
		</tr>
        <?php while($row = $statement->fetch()) : ?>
        <tr>
            <td><?=$row['description']?></td>
            <td><?=$row['date_added']?></td>
            <td><?= getStatusName($row['is_done']) ?></td>
            <td>
                <a href="/index.php?id=<?=$row['id']?>&action=done">Выполнить</a>
                <a href="/index.php?id=<?=$row['id']?>&action=edit">Изменить</a>
                <a href="/index.php?id=<?=$row['id']?>&action=delete">Удалить</a>
            </td>
        </tr>
         <?php endwhile; ?>
	</table>
</body>
</html>