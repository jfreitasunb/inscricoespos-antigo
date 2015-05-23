
<?php


 // $coduser = 1;
 // $arquivopdf = "Doutorado-68e6f6f815b50f474cf0dc22d4f400725.pdf";


include_once("../pgsql/pgsql.php");
include_once("../config/config.php");
include_once("../funcoes/confirma_inscricao.php");
//confirmainscricao($coduser,$arquivopdf);

$coduser = '1434';
$query_pega_mail=pg_query("select login from inscricao_pos_login where coduser='".$coduser."'");
$query_pega_nome=pg_query("select name||' '||firstname from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");

$pega_nome = pg_fetch_assoc($query_pega_nome);

//var_dump($pega_nome);

echo $pega_nome[0]."<br>";
echo $pega_mail."<br>";

?>

