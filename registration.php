<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
<meta charset="utf-8">
</head>
<body>

<?php
require('connection.php');

if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])){
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	$email = $_POST['email'];
	$role = $_POST['role'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL) and $login != "" and $password != "") {
   		$query = "INSERT INTO users (login, password, email, roleId) VALUES ('$login', '$password', '$email', '$role')";
   		$result = $pdo->query($query);
   		if($result){
   			$Smessage = "Регистрация прошла успешно!";
   		}
   		else {
   			$Fmessage = "Ошибка";
   		}
	}
	else{
 	  $Fmessage = "Email указан неправильно.";
	}
}
?>
<form method="post">
<?php if(isset($Smessage)){?><div class="alert-success" role="alert"><?php echo $Smessage;?> </div><?php }?>
<?php if(isset($Fmessage)){?><div class="alert-danger" role="alert"><?php echo $Fmessage;?> </div><?php }?>
<p>Логин: <input type="text" name="login" /></p>
<p>Почта: <input type="text" name="email" /></p>
<p>Пароль: <input type="password" name="password" /></p>
<p>Роль:</p>
<p><input type="radio" name="role" value="1"/>Админ</p>
<p><input type="radio" name="role" value="2"/>Работник</p>

<input type="submit" value="Готово"/>
</form>

</body>
</html>