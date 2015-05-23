<?php 
	session_start();
 if( !isset($_SESSION['coduser']) ){
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.html'>";
        exit;
 }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Carta de Recomendação: seleção de candidatos </title>
	</head>
	
	<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
        <h2 align="center">
                Processo Seletivo da Pós-Graduação <br>
                MAT-UnB <?php echo date("Y")+1;?>
        </h2>

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
	<br>
	<br>
	<form method="POST" action ="formulario1.php">
	<table cellpadding="5px" cellspacing="1">
	<tr><td colspan=2>Recomendante: <? echo $nome_prof;?>.</td></tr>
	<tr><td colspan=2>Escolha um candidato para preenchimento de sua carta de recomenda&ccedil;&otilde;es:</td></tr>
	<?
	while($registro=pg_fetch_row($query_estudantes))
		{
		$query_completo=pg_query("select completo from inscricao_pos_recomendacoes where id_prof='".$entradarec['id_prof']."' and id_aluno='".$registro[0]."' and nivel='".strtolower($registro[1])."'");
		if (pg_num_rows($query_completo)==0) {$status_completo="(carta pendente)";$disabled="";} 
		else 
			{
			$completo=pg_fetch_row($query_completo);
			if ($completo[0]=="sim") {$status_completo="&nbsp (carta já submetida)";$disabled="disabled=disabled";} else {$status_completo="&nbsp <span style=\"color:red\">(carta incompleta ou nao enviada) </span>";$disabled="";}
			}
		echo "<tr><td><input type=radio name='carta_para_aluno' value=\"".$registro[0]."_(".$registro[1]."_(".$registro[8]."\" ".$disabled."></td><td>".$registro[8]." (".$registro[1]."); ".$status_completo."</td></tr>";		
		}
	?>
	<tr><td colspan=2 align="center">
	<br> <input type="submit" name="preencher" value="Escrever Carta"></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr<td colspan=2>
	</td></tr>
	</table>
<?
echo"
        <p align=\"center\">
        <a href=\"../logout.php\"; title=\"Logout\"><img alt=\"Logout\" src=\"../imagens/sair.png\" border=\"0\" width=\"50\" /></a>
        </p>
        ";
?>

	</form>

	<br>
	<br>
	<b>*Instruções:</b> Para preencher a carta de recomendações basta selecionar um aluno e clicar
	no botão <b>Escrever carta</b>.

	<br> A carta é composta por 3 formulários. 
	<br> Não é necessário preencher todos os formulário de uma vez. 
	<br> A cada login o sistema recupera os dados dos formulários que foram preenchidos completamente
	<br> e os campos podem ser editados enquanto o sr(a) não clicar no botão <b>Enviar Carta</b>, 
	que está no último formulário.
	<br> A navegação pelo formulário é feita através dos botões que se encontram no final do formulário
	<br> que indicam opções de salvar e prosseguir para a página seguinte ou salvar e retornar a página anterior.
	<br> Para ter certeza que sua carta foi enviada com sucesso basta verificar se ao lado do nome do aluno, 
	<br> nesta página, aparece a mensagem <b> carta já submetida </b>.
	</body>
	</html>
<?
pg_close($con);
?>



