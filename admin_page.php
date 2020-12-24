<a href="create_task.php">Создать задание</a>

<? if (isset($_POST['delete'])){
		$taskId = $_POST['taskId'];
		$res = $pdo->query("DELETE FROM tasks WHERE id = '$taskId'");
}
?>

<?php
$res = $pdo->query("SELECT tasks.id, tasks.workerId, tasks.task, tasks.status, users.login FROM tasks, users WHERE tasks.adminId = '$UID' AND tasks.workerId = users.id");
$tasks = $res->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
	<tr>
		<th>Исполнитель</th>
		<th>Задания</th>
		<th>Статус</th>
		<th></th>
		<th></th>
	</tr>
	<?php
	foreach($tasks as $task){
		if ($task['status'] == 1) $strStat = 'выполнено';
		else $strStat = 'не выполнено';
		echo "<form method='POST'><input type='hidden' name='taskId' value='$task[id]'><tr><td> $task[login] </td><td> $task[task] </td><td> $strStat </td><td><input class='small-btn' type='submit' formaction
='admin_task_edit.php' value='изменить'></td> <td> <input class='small-btn' type='submit' formaction
='/' name='delete' value='удалить'> </td></tr></form>";
	}?>
</table>