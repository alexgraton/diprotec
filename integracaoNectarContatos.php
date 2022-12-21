<?php
require_once("model/MysqlDAOFactory.class.php");
include  'PHPExcel/Classes/PHPExcel.php';
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(0);
//Integracoes Mysql
$dao = new MysqlDAOFactory();
$integracoes = $dao->getIntegracoesDAO();
$ultPaginaContatos = $integracoes->ultPaginaContatos();
$operacao = $_GET['operacao'];

if($operacao == 'atualizar'){
	$erro = false;
	$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDY5MDgzNzksImV4cCI6MTY3ODQ0NDM0MCwidXNlckxvZ2luIjoiYWxleC5ncmF0b25AZGlwcm90ZWMuY29tLmJyIiwidXNlcklkIjoiMTAxMzA5IiwidXN1YXJpb01hc3RlcklkIjoiOTc4NjUifQ.Yhgabhxkmzjn3CiA4xrxQLf1srP6OIjQNuS_Zx16tv0';
	$msgErro = '';
	$pagina = $ultPaginaContatos;
	$pagina ++;
	$bufferPagina = $pagina;
	
	while (true){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://app.nectarcrm.com.br/crm/api/1/contatos/?api_token='.$token.'&page='.$pagina);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		$formatado = json_decode($response,true);
		
		if(empty($formatado)){
			 break;
		}
		if($formatado ==''){
			break;			
		}
		
		foreach($formatado as $key => $value) {
			$retorno = (json_encode($value));
			$retorno = addslashes($retorno);
			if(!$integracoes->insereContatos($retorno,$pagina)){
				$erro = true;
				$msgErro .= 'erro ao inserir contatos';
			}
		}
		$pagina ++;
	}
	if($erro){
		echo $msgErro;
	}else{
		echo 0;
	}		
}

if($operacao == 'excluir'){
	if($integracoes->apagaBaseContatos()){
		echo "0";
	}else{
		echo "Erro ao excluir a base de oportunidades!";
	}	
}


if($operacao == "exportar"){
	
	// Definimos o nome do arquivo que será exportado
	$arquivo = 'contatos.csv';
	//Gravo em $resumo o resultado da busca
	$resumo = $integracoes->buscaContatos();
	
	$filename = "contatos.csv";
	$fp = fopen('php://output', 'w');
	
	$header[0] = 'ID RESPONSAVEL';
	$header[1] = 'NOME RESPONSAVEL';
	$header[2] = 'NOME';
	$header[3] = 'RAZAO SOCIAL';
	$header[4] = 'CNPJ';
	$header[5] = 'DATA CRIACAO';
	$header[6] = 'OBSERVACAO';
	$header[7] = 'ORIGEM';
	$header[8] = 'ATIVO';
	$header[9] = 'EMPRESA';
	$header[10] = 'TELEFONE';
	$header[11] = 'EMAIL';

	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename=' . $filename);
	fputcsv($fp, $header);
	
	foreach($resumo as $row){
		fputcsv($fp, $row);
	}
	exit();
}

?>