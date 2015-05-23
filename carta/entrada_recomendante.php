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
	<title> Carta de Recomendação: seleção de candidatos </title>
	</head>
	
	<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
        <h2 align="center">
                Processo Seletivo da Pós-Graduação <br>
                MAT-UnB <?php echo $ano_config;?>
        </h2>

	<?php  
	include_once "../pgsql/pgsql.php";
	

	$entradarec['id_prof'] = $_SESSION['coduser'];
	$edital=$edital_atual;
	
	
	
	//Pega e-mail recomendante
	$query_emailrecomendante=pg_query("select login from inscricao_pos_login where coduser='".$entradarec['id_prof']."'");
	$emailrecomendante=pg_fetch_row($query_emailrecomendante);
	$login = $emailrecomendante[0];
	
	
	//Pega nome professor recomendante
	$query_nomerecomendante = pg_query("select nomerecomendante from inscricao_pos_dados_pessoais_recomendante 
										where id_prof='".$entradarec['id_prof']."'");
	$vetor_nomerecomendante = pg_fetch_row($query_nomerecomendante);
	$nomerecomendante = $vetor_nomerecomendante[0];
	
	
	// Pega os codusers de todos os alunos que pediram carta para este recomendante
	$query_lista_estudantes=pg_query("select id_aluno 
									from inscricao_pos_contatos_recomendante 
									where 
									(edital='$edital') and 
									(emailprofrecomendante1='$login' or emailprofrecomendante2='$login' 
										or emailprofrecomendante3='$login')");
	
	$lista_estudantes = pg_fetch_all($query_lista_estudantes);
	
	// Não sei porque isto é necessário quando se vem da página anterior para esta ...
	unset($id_aluno);
	// Fim não sei porque que o comando acima esta sendo necessário para as coisas funcionarem.
	
	
	// Guarda em um vetor os nomes, coduser e programa de todos os alunos que pediram carta para este recomendante
	foreach ($lista_estudantes as $key => $value){
		//id do aluno
		$id_aluno[$key] = $value['id_aluno'];
				
		$pega_nome = pg_query("select name||' '||firstname as nome from inscricao_pos_dados_candidato 
								where id_aluno='$id_aluno[$key]'");
		$array_nome = pg_fetch_assoc($pega_nome);
		// nome do candidato
		$nome[$key] = $array_nome["nome"];


		$pega_programa = pg_query("select programa from inscricao_pos_contatos_recomendante 
									where id_aluno='$id_aluno[$key]' and edital='$edital'");
		$array_programa = pg_fetch_assoc($pega_programa);
		// Programa pretendido pelo candidato 
		$programa[$key] = $array_programa["programa"];
		
		//echo "<br> Nome do cara: ".$nome[$key]." identificador: ".$id_aluno[$key]." candidato ao programa(s) de : ".$programa[$key]."<br>";
	}
	?>
	
	
	<br>
	<br>
	<form method="POST" action ="formulario1.php">
	<table cellpadding="5px" cellspacing="1">
	<tr><td colspan=2> <?php if ($nomerecomendante ==""){echo "Caro(a) professor(a),";}else{echo "Caro(a) ".trim($nomerecomendante).",";}?></td></tr>
	<tr><td colspan=2>escolha um candidato para preenchimento de sua carta de recomenda&ccedil;&otilde;es:</td></tr>
	
	
	<?php
	foreach ($lista_estudantes as $key => $value){
		
		$query_completo=pg_query("select completo from inscricao_pos_recomendacoes 
			where id_prof='".$entradarec['id_prof']."' and id_aluno='".$id_aluno[$key]."' and edital='".$edital."'");
		if (pg_num_rows($query_completo)==0) {$status_completo="<span style=\"color:red\">(Carta pendente)</span>";$disabled="";
		}else{
			$completo=pg_fetch_row($query_completo);
			if ($completo[0]=="sim") {$status_completo="&nbsp (Carta já submetida)";$disabled="disabled=disabled";
			}else{
				$status_completo="&nbsp <span style=\"color:red\">(Carta incompleta ou nao enviada) </span>";$disabled="";
			}
		}
		echo"<tr>
		<td><input type=radio name='carta_para_aluno' value=\"".$id_aluno[$key]."_(".$nome[$key]."_(".$programa[$key]."\" ".$disabled."></td>
		<td>".$nome[$key]." - Progama: ".$programa[$key].". ".$status_completo."</td></tr>";		
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



