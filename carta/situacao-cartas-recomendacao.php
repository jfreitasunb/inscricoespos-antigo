
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Situação das cartas de recomendação
	</h2>
	
<?php 
// Conecta no banco de dados.
include_once("../pgsql/pgsql.php");
include_once("../config/config.php");

//define o usuário e o número do edital

$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='$edital_atual' and coduser <> '110' and coduser <> '592'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
//var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){
$j = $i + 1;
echo "<hr>Inscrição: ".$j."<br>";

$coduser=$tab_coduser[$i]['coduser'];

$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
$cadas1 = pg_fetch_assoc($query_cadas1);

$nome =$cadas1['name']." ".$cadas1['firstname'];
$nome = ucwords(strtolower($nome));
$nome =str_replace(' ','',$nome);

echo "Nome: ".ucwords(strtolower($cadas1['name']))." ".ucwords(strtolower($cadas1['firstname']))."<br>";

// Pega dados de recomendação no banco de dados
$pega_nome_recomendante = pg_query ("select * from inscricao_pos_contatos_recomendante where id_aluno='$coduser' and edital='$edital_atual'");
$lista_recomendates = pg_fetch_assoc($pega_nome_recomendante);

// Define os e-mails dos recomendantes
$email1 = $lista_recomendates['emailprofrecomendante1'];
$email2 = $lista_recomendates['emailprofrecomendante2'];
$email3 = $lista_recomendates['emailprofrecomendante3'];

// Códigos dos recomendantes
$pega_id_recomendante1 = pg_query ("select coduser from inscricao_pos_login where login='$email1'");
$id_reco1 = pg_fetch_row($pega_id_recomendante1);
$id_recomendante1 = $id_reco1[0];

$pega_id_recomendante2 = pg_query ("select coduser from inscricao_pos_login where login='$email2'");
$id_reco2 = pg_fetch_row($pega_id_recomendante2);
$id_recomendante2 = $id_reco2[0];

$pega_id_recomendante3 = pg_query ("select coduser from inscricao_pos_login where login='$email3'");
$id_reco3 = pg_fetch_row($pega_id_recomendante3);
$id_recomendante3 = $id_reco3[0];

// Status das carta de recomendação
$pega_status_carta_prof1 = pg_query ("select completo from inscricao_pos_recomendacoes where id_prof='$id_recomendante1' and id_aluno='$coduser' and edital='$edital_atual'");
$status_car1 = pg_fetch_row($pega_status_carta_prof1);
$status_carta1 = $status_car1[0];

$pega_status_carta_prof2 = pg_query ("select completo from inscricao_pos_recomendacoes where id_prof='$id_recomendante2' and id_aluno='$coduser' and edital='$edital_atual'");
$status_car2 = pg_fetch_row($pega_status_carta_prof2);
$status_carta2 = $status_car2[0];

$pega_status_carta_prof3 = pg_query ("select completo from inscricao_pos_recomendacoes where id_prof='$id_recomendante3' and id_aluno='$coduser' and edital='$edital_atual'");
$status_car3 = pg_fetch_row($pega_status_carta_prof3);
$status_carta3 = $status_car3[0];



echo "Recomendante1: ".$lista_recomendates['nomeprofrecomendante1']." E-mail: ".$email1." Enviou a carta?";
if ($status_carta1 == "sim"){
	echo "<span style=\"color:#0000FF\"> Sim </span><br>";
}else{
	echo "<span style=\"color:#FF0000\"> Não </span><br>"; 
}

echo "Recomendante2: ".$lista_recomendates['nomeprofrecomendante2']." E-mail: ".$email2." Enviou a carta?";

if ($status_carta2 == "sim"){
	echo "<span style=\"color:#0000FF\"> Sim </span><br>";
}else{
	echo "<span style=\"color:#FF0000\"> Não </span><br>"; 
}

echo "Recomendante3: ".$lista_recomendates['nomeprofrecomendante3']." E-mail: ".$email3." Enviou a carta?";
if ($status_carta3 == "sim"){
	echo "<span style=\"color:#0000FF\"> Sim </span><br>";
}else{
	echo "<span style=\"color:#FF0000\"> Não </span><br>"; 
}



}
?>

	
</body>
</html>
