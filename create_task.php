<?php
	require('layout.php');
	if(isset($_POST['task']) && isset($_POST['worker'])){
	require('connection.php');
	$task = $_POST['task'];
	$workerId = $_POST['worker'];
	$admin = $_COOKIE['login'];
	$adminQ = $pdo->query("SELECT id FROM users WHERE login = '$admin'");
	$adminId = $adminQ->fetch(PDO::FETCH_ASSOC);
	$res = $pdo->query("INSERT INTO tasks (adminId, workerId, task) VALUES ('$adminId[id]', '$workerId', '$task')");
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