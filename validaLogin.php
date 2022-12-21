<?php
session_start();
require_once("model/MysqlDAOFactory.class.php");

$dao = new MysqlDAOFactory();
$usuario = $dao->getUsuariosDAO();


$login = $_POST['login'];
$senha = $_POST['senha'];
if($usuario->valida($_POST['login'],$_POST['senha'])){
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['senha'] = $_POST['senha'];
	header("Location: index");
}else{
	echo "<script>alert('ERRO!');history.back(0);</script>"; 
}


?>