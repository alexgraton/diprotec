<?php
require_once("model/MysqlDAOFactory.class.php");
include  'PHPExcel/Classes/PHPExcel.php';
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(0);
//Integracoes Mysql
$dao = new MysqlDAOFactory();
$integracoes = $dao->getIntegracoesDAO();
$ultPaginaOportunidades = $integracoes->ultPaginaOportunidades();
$operacao = $_GET['operacao'];

if($operacao == 'atualizar'){
	$erro = false;
	$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDY5MDgzNzksImV4cCI6MTY3ODQ0NDM0MCwidXNlckxvZ2luIjoiYWxleC5ncmF0b25AZGlwcm90ZWMuY29tLmJyIiwidXNlcklkIjoiMTAxMzA5IiwidXN1YXJpb01hc3RlcklkIjoiOTc4NjUifQ.Yhgabhxkmzjn3CiA4xrxQLf1srP6OIjQNuS_Zx16tv0';
	$msgErro = '';
	$pagina = $ultPaginaOportunidades;
	$pagina ++;
	$bufferPagina = $pagina;
	
	while (true){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://app.nectarcrm.com.br/crm/api/1/oportunidades/?api_token='.$token.'&page='.$pagina);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		$formatado = json_decode($response,true);
		
		if(empty($formatado)){
			 break;
		}
		foreach($formatado as $key => $value) {
			$retorno = (json_encode($value));
			$retorno = addslashes($retorno);
			if(!$integracoes->insereOportunidades($retorno,$pagina)){
				$erro = true;
				$msgErro .= 'erro ao inserir oportunidades';
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
	if($integracoes->apagaBaseOportunidades()){
		echo "0";
	}else{
		echo "Erro ao excluir a base de oportunidades!";
	}	
}

if($operacao == 'a'){
	
		echo "0";
}

if($operacao == "exportar"){
	
	// Definimos o nome do arquivo que será exportado
	$arquivo = 'Oportunidades.xls';
	//Gravo em $resumo o resultado da busca
	$resumo = $integracoes->buscaOportunidades();
	
	//Inicia a tabela
	$html = '';
	$html .= '<table border="1">';
	//Inicia o cabeçalho da planilha
	$html .= '<tr>';
	$html .= "<td><b>ID OPORTUNIDADE</b></td>";
	$html .= "<td><b>RESPONSAVEL ID</b></td>";
	$html .= "<td><b>RESPONSAVEL NOME</b></td>";
	$html .= "<td><b>AUTOR ID</b></td>";
	$html .= "<td><b>AUTOR NOME</b></td>";
	$html .= "<td><b>NOME OPORTUNIDADE</b></td>";
	$html .= "<td><b>CLIENTE ID</b></td>";
	$html .= "<td><b>CLIENTE CNPJ</b></td>";
	$html .= "<td><b>CLIENTE NOME</b></td>";
	$html .= "<td><b>CLIENTE TELEFONE</b></td>";
	$html .= "<td><b>CLIENTE EMAIL</b></td>";
	$html .= "<td><b>OPORTUNIDADE CODIGO</b></td>";
	$html .= "<td><b>OPORTUNIDADE STATUS</b></td>";
	$html .= "<td><b>OPORTUNIDADE DATA CRIACAO</b></td>";
	$html .= "<td><b>OPORTUNIDADE FUNIL</b></td>";
	$html .= "<td><b>FUNIL ID</b></td>";
	$html .= "<td><b>FUNIL NOME</b></td>";
	$html .= "<td><b>ETAPA ID</b></td>";
	$html .= "<td><b>ETAPA NOME</b></td>";
	$html .= "<td><b>ETAPA DESCRICAO</b></td>";
	$html .= "<td><b>OBSERVACAO</b></td>";
	$html .= "<td><b>VALOR TOTAL</b></td>";
	$html .= '</tr>';
	
	//Preenche o conteúdo das celulas
	foreach($resumo as $rs){
		if($rs["idOportunidade"] != ''){
			$html .= '<tr>';		
				$html .= '<td>'.$rs["idOportunidade"].'</td>';	
				$html .= '<td>'.$rs["responsavelId"].'</td>';		
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["responsavelNome"]))).'</td>';		
				$html .= '<td>'.$rs["autorId"].'</td>';		
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["autorNome"]))).'</td>';		
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["nomeOportunidade"]))).'</td>';		
				$html .= '<td>'.$rs["clienteId"].'</td>';	
				$html .= '<td>'.str_replace('"','',$rs["clienteCnpj"]).'</td>';		
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["clienteNome"]))).'</td>';		
				$html .= '<td>'.str_replace('"','',$rs["clienteTelefone"]).'</td>';		
				$html .= '<td>'.str_replace('"','',$rs["clienteEmail"]).'</td>';		
				$html .= '<td>'.str_replace('"','',$rs["oportunidadeCodigo"]).'</td>';		
				$html .= '<td>'.str_replace('"','',$rs["oportunidadeStatus"]).'</td>';	
				$html .= '<td>'.str_replace('"','',$rs["oportunidadeDataCriacao"]).'</td>';		
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["oportunidadeFunil"]))).'</td>';		
				$html .= '<td>'.$rs["funilId"].'</td>';
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["funilNome"]))).'</td>';
				$html .= '<td>'.$rs["etapaId"].'</td>';
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["etapaNome"]))).'</td>';
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["etapaDescricao"]))).'</td>';	
				$html .= '<td>'.str_replace('"','',utf8_decode(Utf8_ansi($rs["observação"]))).'</td>';
				$html .= '<td>'.$rs["valorTotal"].'</td>';
			$html .= '</tr>';
		}
	}
	//Fecha a tabela
	$html .= '</table>';
	// Configurações header para forçar o download
	header ("Expires: Wed, 11 Nov 2028 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
	// Envia o conteúdo do arquivo
	echo $html;
	exit;		
	
}



?>