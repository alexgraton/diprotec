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
json_extract(retorno, "$.observacao") as observa????o,
json_extract(retorno, "$.valorTotal") as valorTotal
FROM `oportunidades`;
*/
/* Function php for convert utf8 html to ansi */

public static function Utf8_ansi($valor='') {

    $utf8_ansi2 = array(
    "\u00c0" =>"??",
    "\u00c1" =>"??",
    "\u00c2" =>"??",
    "\u00c3" =>"??",
    "\u00c4" =>"??",
    "\u00c5" =>"??",
    "\u00c6" =>"??",
    "\u00c7" =>"??",
    "\u00c8" =>"??",
    "\u00c9" =>"??",
    "\u00ca" =>"??",
    "\u00cb" =>"??",
    "\u00cc" =>"??",
    "\u00cd" =>"??",
    "\u00ce" =>"??",
    "\u00cf" =>"??",
    "\u00d1" =>"??",
    "\u00d2" =>"??",
    "\u00d3" =>"??",
    "\u00d4" =>"??",
    "\u00d5" =>"??",
    "\u00d6" =>"??",
    "\u00d8" =>"??",
    "\u00d9" =>"??",
    "\u00da" =>"??",
    "\u00db" =>"??",
    "\u00dc" =>"??",
    "\u00dd" =>"??",
    "\u00df" =>"??",
    "\u00e0" =>"??",
    "\u00e1" =>"??",
    "\u00e2" =>"??",
    "\u00e3" =>"??",
    "\u00e4" =>"??",
    "\u00e5" =>"??",
    "\u00e6" =>"??",
    "\u00e7" =>"??",
    "\u00e8" =>"??",
    "\u00e9" =>"??",
    "\u00ea" =>"??",
    "\u00eb" =>"??",
    "\u00ec" =>"??",
    "\u00ed" =>"??",
    "\u00ee" =>"??",
    "\u00ef" =>"??",
    "\u00f0" =>"??",
    "\u00f1" =>"??",
    "\u00f2" =>"??",
    "\u00f3" =>"??",
    "\u00f4" =>"??",
    "\u00f5" =>"??",
    "\u00f6" =>"??",
    "\u00f8" =>"??",
    "\u00f9" =>"??",
    "\u00fa" =>"??",
    "\u00fb" =>"??",
    "\u00fc" =>"??",
    "\u00fd" =>"??",
    "\u00ff" =>"??");

    return strtr($valor, $utf8_ansi2);      

}
?>