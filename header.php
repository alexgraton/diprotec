<?php 
session_start();
require_once("model/MysqlDAOFactory.class.php");
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//Usuarios Mysql
$dao = new MysqlDAOFactory();
$usuario = $dao->getUsuariosDAO();

//Integracoes Mysql
$dao = new MysqlDAOFactory();
$integracoes = $dao->getIntegracoesDAO();

	$nomeLogado = '';

if (empty($_SESSION['login'])){
	echo $_SESSION['login'];
	header('Location: login'); 
}else{
	$usu_logado = $_SESSION['login'];
}


?>
<!DOCTYPE html>
<html lang="pt">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
  
	<title>Nectar x Acesse</title>
	<link rel="icon" type="image/x-icon" href="img/favicon.ico">
	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
<style>
table {font-size:12px}
select option {font-size:12px}

.loading {
    z-index: 999999;
    position: absolute;
    top: 0;
    left: -5px;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 83%);
}
.loading-content {
    position: fixed;
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 150px;
    height: 150px;
    top: calc(50% - 75px);
    left: calc(50% - 75px);
    animation: spin 1s linear infinite;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>

<section id="loading" class="">
    <div id="loading-content" class=""></div>
</section>
 <script>
    function loading() {
      $("#loading").toggleClass("loading");
      $("#loading-content").toggleClass("loading-content");
    }
	
  </script>
