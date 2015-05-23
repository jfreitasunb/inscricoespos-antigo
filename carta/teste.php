<?php 
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Carta de Recomendação: seleção de candidatos </title>
	</head>
<body> 

	<?php  
	include_once "../pgsql/pgsql.php";
	$entradarec['id_prof'] = $_SESSION['coduser'];

//echo $entradarec['id_prof'];
	$query_estudantes=pg_query("select cr.*, dp.name||' '||dp.firstname as nome_aluno,login from inscricao_pos_dados_candidato dp, inscricao_pos_contatos_recomendante cr, inscricao_pos_login where dp.id_aluno=cr.id_aluno and coduser='".$entradarec['id_prof']."' and (emailprofrecomendante1=login or emailprofrecomendante2=login or emailprofrecomendante3=login)");

	$query_login=pg_query("select login from inscricao_pos_login where coduser='".$entradarec['id_prof']."'");
	$login=pg_fetch_row($query_login);
	$query_nome_prof=pg_query("select * from inscricao_pos_contatos_recomendante where emailprofrecomendante1='".$login[0]."' or emailprofrecomendante2='".$login[0]."' or emailprofrecomendante3='".$login[0]."' limit 1");
	$dados_prof=pg_fetch_row($query_nome_prof);
	for($i=3;$i<8;$i=$i+2)
		{
		if ($dados_prof[$i]==$login[0]) $nome_prof=$dados_prof[$i-1];
		}
	?>
	<form method="POST" action ="formulario1.php">
	<table>
	<tr><td colspan=2>Recomendante: <? echo $nome_prof;?>:</td></tr>
	<tr><td colspan=2>Escolha um candidato para preenchimento de sua carta de recomenda&ccedil;&otilde;es:</td></tr>
	<?
	while($registro=pg_fetch_row($query_estudantes))
		{
		$query_completo=pg_query("select completo from inscricao_pos_recomendacoes where id_prof='".$entradarec['id_prof']."' and id_aluno='".$registro[0]."' and nivel='".$registro[1]."'");
		if (pg_num_rows($query_completo)==0) $status_completo="(carta pendente)"; 
		else 
			{
			$completo=pg_fetch_row($query_completo);
			if ($completo[0]=="sim") $status_completo="(carta ja submetida)"; else $status_completo="(carta incompleta)";
			}
		echo "<tr><td><input type=radio name='carta_para_aluno' value=\"".$registro[0]."_(".$registro[1]."_(".$registro[8]."\"></td><td>".$registro[8]." (".$registro[1]."); ".$status_completo."</td></tr>";		
		}
	?>
	<tr><td colspan=2 align="center">
	<input type="submit" name="preencher" value="Submeter"></td></tr>
	</table>
	</form>
	</body>
	</html>
<?
pg_close($con);
?>



