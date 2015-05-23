<?php 
	session_start();
	if( !isset($_SESSION['coduser']) ){
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
	exit;
 }
include_once("../config/config.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
	Cadastro para Processo Seletivo 
                        <?php
                        echo $curso_config;
                        ?>
                        / Pós-Graduação 
                        <br>
                        MAT-UnB 
                        <?php echo $ano_config;?>
	</h2>
	<h3 align="center">
		Informações sobre as cartas de recomendação.
	</h3>

<?php 
// Conecta no banco de dados.
include_once("../pgsql/pgsql.php");
include_once("../config/config.php");

//define o usuário e o número do edital
$coduser = $_SESSION['coduser'];


// Pega dados de recomendação no banco de dados
$pega_nome_recomendante = pg_query ("select * from inscricao_pos_contatos_recomendante where id_aluno='$coduser' and edital='$edital_atual'");
$lista_recomendates = pg_fetch_assoc($pega_nome_recomendante);

// Define os e-mails dos recomendantes
$email1 = trim(stripslashes(strtolower($lista_recomendates['emailprofrecomendante1'])));
$email2 = trim(stripslashes(strtolower($lista_recomendates['emailprofrecomendante2'])));
$email3 = trim(stripslashes(strtolower($lista_recomendates['emailprofrecomendante3'])));

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

/*
echo "<br>".$id_recomendante1."<br>";
echo "<br>".$id_recomendante2."<br>";
echo "<br>".$id_recomendante3."<br>";

echo "<br>".$status_carta1."<br>";
echo "<br>".$status_carta2."<br>";
echo "<br>".$status_carta3."<br>";
*/

//var_dump($lista_recomendates);

echo "<br>";
echo " Caro(a) candidato(a),<br><br>";
echo "O(A) professor(a) <span style=\"color:#FF0000\"> ".$lista_recomendates['nomeprofrecomendante1']."</span>";
if ($status_carta1 == "sim"){
	echo " já enviou a sua carta de recomendação.";
	echo "<br>";
}else{
	echo " ainda não enviou a sua carta de recomendação. <br>"; 
}
echo "<br />";
echo "O(A) professor(a) <span style=\"color:#FF0000\"> ".$lista_recomendates['nomeprofrecomendante2']."</span>";
if ($status_carta2 == "sim"){
	echo " já enviou a sua carta de recomendação.";
	echo "<br>";
}else{
	echo " ainda não enviou a sua carta de recomendação. <br>"; 
}
echo "<br />";
echo "O(A) professor(a) <span style=\"color:#FF0000\"> ".$lista_recomendates['nomeprofrecomendante3']."</span>";
if ($status_carta3 == "sim"){
	echo " já enviou a sua carta de recomendação.";
	echo "<br>";
}else{
	echo " ainda não enviou a sua carta de recomendação. <br>"; 
}

echo"<br><br><br>";
echo"
	<p align=\"center\">
	<a href=\"../logout.php\"; title=\"Logout\"><img alt=\"Logout\" src=\"../imagens/sair.png\" border=\"0\" width=\"50\" /></a>
	</p>
	";


?>

	
</body>
</html>
