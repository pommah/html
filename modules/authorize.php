<?php
include('db.php');
$login = $_POST['login'];
$password = $_POST['password'];

if(!preg_match("/^[a-zA-Z][a-zA-Z0-9-_\.]{3,25}$/",$login)) {
    exit('Некорректный логин');
}
if(!preg_match("/^[А-яёЁA-z0-9-_\.]{5,30}$/u",$password)) {
    exit('Некорректный пароль');
}

$req=$conn->prepare("SELECT * FROM User WHERE login=? AND password=?");
$req->bindParam(1,$login);
$req->bindParam(2, $password);
$req->execute();
if($req->rowCount()) {
    session_start();
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    echo "OK";
}
else
    echo "Неверный логин или пароль";
?>