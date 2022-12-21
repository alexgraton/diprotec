<?php


$mysqli = new mysqli("localhost","root","","diprotec");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
/*
// Perform query
if ($result = $mysqli -> query("SELECT * FROM feedback")) {
  //echo "Returned rows are: " . $result -> id;
  
  echo'<pre>';
  print_r($result);
  echo'</pre>';
  // Free result set
  $result -> free_result();
}

*/
$sql = "SELECT retorno  FROM oportunidades limit 1 ";
$result = $mysqli -> query($sql);

// Associative array
$row = $result -> fetch_array(MYSQLI_ASSOC);

$a = $row['retorno'];
//echo $a;
$formatado = json_decode($a,true);

//echo $formatado;

echo'<pre>';
print_r($formatado);
echo'</pre>';
/*
  echo'<pre>';
  print_r($row['retorno']);
  echo'</pre>';
*/

$mysqli -> close();
/*
SELECT 
json_extract(retorno, "$.id") as idOportunidade, 
json_extract(retorno, "$.responsavel.id") as responsavelId,
json_extract(retorno, "$.responsavel.nome") as responsavelNome,
json_extract(retorno, "$.autor.id") as autorId,
json_extract(retorno, "$.autor.nome") as autorNome,
json_extract(retorno, "$.nome") as nomeOportunidade,
json_extract(retorno, "$.cliente.id") as clienteId,
json_extract(retorno, "$.cliente.cnpj") as clienteCnpj,
json_extract(retorno, "$.cliente.nome") as clienteNome,
COALESCE(json_extract(retorno, "$.cliente.telefone"),json_extract(retorno, "$.cliente.telefonePrincipal")) as clienteTelefone,
COALESCE(json_extract(retorno, "$.cliente.email"),json_extract(retorno, "$.cliente.email")) as clienteEmail,
json_extract(retorno, "$.codigo") as oportunidadeCodigo,
json_extract(retorno, "$.status") as oportunidadeStatus,
json_extract(retorno, "$.dataCriacao") as oportunidadeDataCriacao,
json_extract(retorno, "$.pipeline") as oportunidadeFunil,
json_extract(retorno, "$.funilVenda.id") as funilId,
json_extract(retorno, "$.funilVenda.nome") as funilNome,
json_extract(retorno, "$.etapa") as etapaId,
json_extract(retorno, "$.etapaAtual.nome") as etapaNome,
json_extract(retorno, "$.etapaAtual.descricao") as etapaDescricao,
json_extract(retorno, "$.observacao") as observação,
json_extract(retorno, "$.valorTotal") as valorTotal
FROM `oportunidades`;
*/
/* Function php for convert utf8 html to ansi */

public static function Utf8_ansi($valor='') {

    $utf8_ansi2 = array(
    "\u00c0" =>"À",
    "\u00c1" =>"Á",
    "\u00c2" =>"Â",
    "\u00c3" =>"Ã",
    "\u00c4" =>"Ä",
    "\u00c5" =>"Å",
    "\u00c6" =>"Æ",
    "\u00c7" =>"Ç",
    "\u00c8" =>"È",
    "\u00c9" =>"É",
    "\u00ca" =>"Ê",
    "\u00cb" =>"Ë",
    "\u00cc" =>"Ì",
    "\u00cd" =>"Í",
    "\u00ce" =>"Î",
    "\u00cf" =>"Ï",
    "\u00d1" =>"Ñ",
    "\u00d2" =>"Ò",
    "\u00d3" =>"Ó",
    "\u00d4" =>"Ô",
    "\u00d5" =>"Õ",
    "\u00d6" =>"Ö",
    "\u00d8" =>"Ø",
    "\u00d9" =>"Ù",
    "\u00da" =>"Ú",
    "\u00db" =>"Û",
    "\u00dc" =>"Ü",
    "\u00dd" =>"Ý",
    "\u00df" =>"ß",
    "\u00e0" =>"à",
    "\u00e1" =>"á",
    "\u00e2" =>"â",
    "\u00e3" =>"ã",
    "\u00e4" =>"ä",
    "\u00e5" =>"å",
    "\u00e6" =>"æ",
    "\u00e7" =>"ç",
    "\u00e8" =>"è",
    "\u00e9" =>"é",
    "\u00ea" =>"ê",
    "\u00eb" =>"ë",
    "\u00ec" =>"ì",
    "\u00ed" =>"í",
    "\u00ee" =>"î",
    "\u00ef" =>"ï",
    "\u00f0" =>"ð",
    "\u00f1" =>"ñ",
    "\u00f2" =>"ò",
    "\u00f3" =>"ó",
    "\u00f4" =>"ô",
    "\u00f5" =>"õ",
    "\u00f6" =>"ö",
    "\u00f8" =>"ø",
    "\u00f9" =>"ù",
    "\u00fa" =>"ú",
    "\u00fb" =>"û",
    "\u00fc" =>"ü",
    "\u00fd" =>"ý",
    "\u00ff" =>"ÿ");

    return strtr($valor, $utf8_ansi2);      

}
?>