﻿<?php session_start(); include "../db.php";
if (isset($_GET['exit'])) unset($_SESSION['user_id']);
isset($_SESSION['user_id']) or die("Вы не авторизованы. Пожалуйста, авторизуйтесь <a href=\"../index.php\">здесь</a>");
connect_db();

if (isset($_POST['login'])) {
    $updateSql = "UPDATE `User` SET Name='" . $_POST['name'] . "', Surname='" . $_POST['surname'] . "', GroupNumber=" . $_POST['gnum'] . ", Password='" . $_POST['password'] . "' WHERE UserID='" . $_POST['login'] . "'";

    if (mysql_query($updateSql)) {
        echo "<font color=\"green\">Информация успешно отредактирована.</font>";
    } else {
        echo "<font color=\"red\">Ошибка.</font>";
    }

}

$query = "SELECT *
            FROM `User`
            WHERE `UserID`='" . $_SESSION['user_id'] . "' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);


?>
<html>
<head>
    <LINK REL="SHORTCUT ICON" href="../favicon.ico">
	<title>Профиль</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<table width="100%">
    <tr>
        <td align="right"><a href="../index.php">На главную</a>
        <td>
    </tr>
</table>
<br/>
<br/>

<h2 align="center">Редактирование профиля</h2>
<br/>

<form action="profile.php" method="post">
    <table>
        <input type="hidden" name="login" value="<?php echo $_SESSION['user_id'];?>">
        <tr>
            <td>Логин:</td>
            <td><?php echo $row['UserID'];?></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" name="password" value="<?php echo $row['Password'];?>"/></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td><input name="name" value="<?php echo $row['Name'];?>"/></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td><input name="surname" value="<?php echo $row['Surname']; ?>"/></td>
        </tr>
        <tr>
            <td>Номер группы:</td>
            <td><input name="gnum" value="<?php echo $row['GroupNumber'];?>"/></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Применить"/></td>
        </tr>
    </table>
</form>
</body>
</html>
