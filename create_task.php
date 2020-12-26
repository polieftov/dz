<?php
	require('layout.php');
	if(isset($_POST['task']) && isset($_POST['worker'])){
	require('connection.php');
	$task = $_POST['task'];
	$workerId = $_POST['worker'];
	$admin = $_COOKIE['login'];

	$adminQ = $pdo->prepare("SELECT id FROM users WHERE login = ?");
	$adminQ -> bindParam(1, $admin);
	$adminQ -> execute();

	$adminId = $adminQ->fetch(PDO::FETCH_ASSOC);

	$res = $pdo->prepare("INSERT INTO tasks (adminId, workerId, task) VALUES (:adminId, :workerId, :task)");
	$res ->bindParam(':adminId', $adminId['id']);
	$res ->bindParam(':workerId', $workerId);
	$res ->bindParam(':task', $task);
	$res -> execute();

	if ($res) $Smessage = "Задание отправлено";
	else $Fmessage = "Ошибка";
}?>

<?php if(isset($Smessage)){?><div class="alert-success" role="alert"><?php echo $Smessage;?> </div><?php }?>
<?php if(isset($Fmessage)){?><div class="alert-danger" role="alert"><?php echo $Fmessage;?> </div><?php }?>
<form method="post">
	<p><select size="1" name="worker">
	<? require('connection.php');
		require('admin_func.php');
	$workers = getAllWorkers();
	foreach ($workers as $worker){
	$id = $worker['id'];
	echo "<option value= $id>  $worker[login] </option>";
	}?>
	</select></p>

	Задание: <input type="text" name="task" />
	<input type="submit" value="готово">
</form>
<a href="/">Вернуться на главную</a>

</body>
</html>