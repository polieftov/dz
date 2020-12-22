<?php
include('connection.php');

function lastAct($id)
{   
	include('connection.php');
	$tm = time(); 
	$query = "UPDATE users SET online='$tm', last_act='$tm' WHERE id='$id'";
	$res = $pdo->query($query);
 }

function enter ()
{
	include('connection.php');
	$error = array(); //массив для ошибок
	if ($_POST['login'] != "" && $_POST['password'] != "") //если поля заполнены
	{       
    	$login = $_POST['login'];
    	$password = $_POST['password'];
    	$res = $pdo->query("SELECT * FROM users WHERE login='$login'");//запрашивается строка из базы данных с логином, введённым пользователем
    	if ($res) //если нашлась одна строка, значит такой юзер существует в базе данных
    	{
    	    $row = $res->fetch(PDO::FETCH_ASSOC);      
        	if (md5($password) == $row['password']) //сравнивается хэшированный пароль из базы данных с хэшированными паролем, введённым пользователем
        	{
        	//пишутся логин и хэшированный пароль в cookie, также создаётся переменная сессии
        		setcookie ("login", $row['login'], time() + 50000);
        		setcookie ("password", md5($row['password']), time() + 50000);
        		$_SESSION['id'] = $row['id'];   //записываем в сессию id пользователя
        		$id = $_SESSION['id'];              
        		lastAct($id);               
        		return $error;          
    		}           
    		else{ //если пароли не совпали             	               
        		$error[] = "Неверный пароль";                                       
        		return $error;          
    		}       
		}       
    	else //если такого пользователя не найдено в базе данных        
    	{           
        	$error[] = "Неверный логин и пароль";           
        	return $error;      
    	}   
	}   
    else    
    {       
        $error[] = "Поля не должны быть пустыми!";              
        return $error;  
    } 

}

function login() {
	include('connection.php');  
	//ini_set ("session.use_trans_sid", true);  
	session_start();

	if (isset($_SESSION['id']))//если сесcия есть   
	{
		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){ //если cookie есть, обновляется время их жизни и возвращается true      

			SetCookie("login", "", time() - 1, '/');            SetCookie("password","", time() - 1, '/');          

			setcookie ("login", $_COOKIE['login'], time() + 50000, '/');            

			setcookie ("password", $_COOKIE['password'], time() + 50000, '/');          

			$id = $_SESSION['id'];          
			lastAct($id);           
			return true;        
		}

		else //иначе добавляются cookie с логином и паролем, чтобы после перезапуска браузера сессия не слетала         
		{           
		         
			$res = $pdo->query("SELECT * FROM users WHERE id='{$_SESSION['id']}'");//запрашивается строка с искомым id
			$row = $res->fetchAll(PDO::FETCH_ASSOC);
			if (count($row) == 1){ //если получена одна строка                 
			 //она записывается в ассоциативный массив               

				setcookie ("login", $row['login'], time()+50000, '/');              

				setcookie ("password", md5($row['password']), time() + 50000, '/'); 

				$id = $_SESSION['id'];
				lastAct($id); 
				return true;            
			} 

			else return false;      
		}   
	}   
	else{ //если сессии нет, проверяется существование cookie. Если они существуют, проверяется их валидность по базе данных     
       
		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){ //если куки существуют                 
			 //запрашивается строка с искомым логином и паролем 

			$res = $pdo->query("SELECT * FROM users WHERE login='{$_COOKIE['login']}'");
			$row = $res->fetchAll(PDO::FETCH_ASSOC);         
			          

			if(count($row) == 1 && md5($row['password']) == $_COOKIE['password']){  //если логин и пароль нашлись в базе данных           

		              
				$_SESSION['id'] = $row['id']; //записываем в сесиию id              
				$id = $_SESSION['id'];              

				lastAct($id);               
				return true;            
			}           
			else{ //если данные из cookie не подошли, эти куки удаляются             
	               
				SetCookie("login", "", time() - 360000, '/');               

				SetCookie("password", "", time() - 360000, '/');                    
				return false;           
			}       
		}       
		else{ //если куки не существуют

				return false;       
		}   
	} 
}

function online(){
	include('connection.php');
	echo "gefgm";
	if(isset($_SESSION['id'])){
		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
			return true;
		}
		else{
			$res = $pdo->query("SELECT * FROM users WHERE login = {$_COOKIE['login']}");
			$row = $res->fetchAll(PDO::FETCH_ASSOC);
			if (count($row) == 1){
				return true;
			}
			return false;
		}
	}
	else{
		$res = $pdo->query("SELECT * FROM users WHERE login = {$_COOKIE['login']}");
		$row = $res->fetchAll(PDO::FETCH_ASSOC);
		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
			if(count($row) == 1 && md5($row['password']) == $_COOKIE['password']){
				$_SESSION['id'] = $row['id'];
				return true;
			}
			return false;
		}
		else{
			return false;
		}
	}
}

function is_admin($id){
	include('connection.php');
	$res = $pdo->query("SELECT roleId FROM users WHERE id='$id'");
	$row = $res->fetchAll(PDO::FETCH_ASSOC);
	if(count($row) == 1){
		$roleId = $row['roleId'];
		if ($roleId == 1) return true;
		else return false;
	}
	else return false;
}

function out(){
	include('connection.php');
	session_start();
	$id = $_SESSION['id'];
	$query = "UPDATE users SET online=0 WHERE id='$id'";
	$res = $pdo->query($query);
	unset($_SESSION['id']);
	SetCookie("login", "");

	SetCookie("password", "");
	header("'/'");
}
?>