<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styless.css">
</head>
<body>
<?php
	require('connection.php');
	$taskId = $_POST['taskId'];
	$res = $pdo->query("SELECT tasks.id, tasks.adminId, tasks.workerId, tasks.task, tasks.status, users.login FROM tasks, users WHERE tasks.id = '$taskId' AND tasks.workerId = users.id");
	$task = $res->fetch(PDO::FETCH_ASSOC);

?>

	<table>
		<tr>
			<th>ID</th>
			<th>Исполнитель</th>
			<th>Задание</th>
			<th>Статус</th>
		</tr>
		<tr><form action="admin_task_edit.php" method="POST">
			<td><input type="text" name="taskId" value=<?echo $task['id']; ?>  readonly> </td>
			<td><select name="taskWorker" selected value=<?php echo $task['login']; ?>> 

				<?require('admin_func.php');
				$workers = getAllWorkers();
				foreach ($workers as $worker){ 
					$id = $worker['id'];
					echo "<option value= $id>  $worker[login] </option>";
				}?>
			</td>
			<td><input type="text" name="taskText" value='<?echo $task['task']; ?>'> </td>
			<td><select name="taskStatus" selected value=<?echo $task['status']; ?>>
				<option value="0"> 0 </option>
				<option value="1"> 1 </option>
			</td>
		</tr>
	</table>
<input type="submit" value="готово"></form>

<? if (isset($_POST['taskWorker']) or isset($_POST['taskText']) or isset($_POST['taskStatus'])){//обновляет данные задачи
	$newWorker = $_POST['taskWorker'];
	$newStatus = $_POST['taskStatus'];
 	$newText = $_POST['taskText'];
 	$id = $_POST['taskId'];
	$res = $pdo->query("UPDATE tasks SET workerId = '$newWorker', status = '$newStatus', task = '$newText' WHERE id = '$id'");
	unset($_POST['taskWorker']);unset($_POST['taskText']);unset($_POST['taskStatus']);
}?>
<a href="/">Вернуться на главную</a>