<?php
require('connection.php');

if (isset($_POST['taskId']) && isset($_POST['status'])){
	$taskId = $_POST['taskId'];
	$status = $_POST['status'];
	if ($status == 1) $newStatus = $status - 1;
	else $newStatus = $status + 1;
	$query = "UPDATE tasks SET status = '$newStatus' WHERE id = '$taskId'";
	$res = $pdo->query($query);

}
//var_dump($_COOKIE['id']);
$res = $pdo->query("SELECT * FROM tasks WHERE workerId = '$UID'");
?>
<table>
	<tr>
		<th>Задания</th>
		<th>Статус</th>
		<th></th>
	</tr>
	<?php
	$tasks = $res->fetchAll(PDO::FETCH_ASSOC);
	foreach($tasks as $task){
		if ($task['status'] == 1) $strStat = 'выполнено';
		else $strStat = 'не выполнено';
		echo "<form action='/', method='POST'> <input type='hidden' name='taskId' value=$task[id]> <input type='hidden' name='status' value=$task[status]<tr><td> $task[task] </td><td> $strStat </td><td> <input type='submit' value = 'изменить статус'></td></form></tr>";
	}
	?>
</table>
