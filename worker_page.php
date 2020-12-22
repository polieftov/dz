<?php
require('connection.php');
$res = $pdo->query("SELECT * FROM tasks WHERE workerId = $UID");
?>
<table>
	<tr>
		<th>Задания</th>
		<th>Статус</th>
	</tr>
	<?php
	$tasks = $res->fetchAll(PDO::FETCH_ASSOC);
	foreach($tasks as $task){
		echo "<tr><td> $task[task] </td><td> $task[status] </td></tr>";	
	}?>
</table>