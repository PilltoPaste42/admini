<?php
    session_start();
    $login = 'user';
    $password = 'ee11cbb19052e40b07aac0ca060c23ee'; //user

    if(isset($_POST['submit']))
    {
    	if($_POST['user'] == $login && md5($_POST['pass']) == $password)
        {
    		$_SESSION['user'] = $login;
    		header("Location: /index.php");
    		exit;
    	}
        else 
        {
            echo '<p>Логин или пароль неверны!</p>';
        }
    }
?>

<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Вход</title>
    </head>
</html>

<form method="post" align="center">
    Имя пользователя: <input type="text" name="user" /> <br/>
	Пароль: <input type="password" name="pass" /> <br/>
	<input type="submit" name="submit" value="Войти" />
</form>