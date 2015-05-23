<?php 
session_start();
include_once("../pgsql/pgsql.php");
// cria coduser:


function grava_cadastro_inscricao3($cadas3)
{
//define o usuário
$id_aluno = $_SESSION['coduser'];

//insere na tabela login e cria o coduser:
//echo "insert into inscricao_pos_login values(default,'".$usuario."',md5($senha),'candidato')";
//$pega_checa=pg_query("select coduser from inscricao_pos_login where login='".$usuario."'");
//$num_checa=pg_num_rows($pega_checa);


//	$insere_novo=pg_query("insert into inscricao_pos_login values(default,'".$usuario."',md5('".$senha."'),'candidato')") or die ("Problema de conexao.");

	//recupera o curso a qual a pessoa esta se candidatando:
	$pega_programa=pg_query("select cursopos,verao from inscricao_pos_dados_profissionais_candidato where id_aluno='".$id_aluno."'");

	if ($pega_programa) $devolve="ok"; else $devolve="erro banco";
	
	$vetor_programa=pg_fetch_row($pega_programa);


	if ( ($vetor_programa[0] == "0") AND ($vetor_programa[1] == "sim")  ){$programa ="Verão";}
	if ( ($vetor_programa[0] == "Mestrado") AND ($vetor_programa[1] == "sim")  ){$programa ="Mestrado e Verão";}
	if ( ($vetor_programa[0] == "Mestrado") AND ($vetor_programa[1] == "0")  ){$programa ="Mestrado";}
	if ( ($vetor_programa[0] == "Doutorado") AND ($vetor_programa[1] == "sim")  ){$programa ="Doutorado e Verão";}
	if ( ($vetor_programa[0] == "Doutorado") AND ($vetor_programa[1] == "0")  ){$programa ="Doutorado";}
	
	
		
	//cria frases para gravar na tabela de dados:
	$campos="(id_aluno,programa";
	$valores="('".$id_aluno."','".$programa."'";


	foreach($cadas3 as $key => $value)
		{
		if ( !($key == "Assinatura") and !($key =="MotivacaoProgramaPretendido") ){
		$campos.=",".strtolower($key);
			if (($value=="")or ($value=="nselecionado")) $valores.=",'0'"; else $valores.=",'".trim($value)."'";
		}
		}
	$campos.=")";
	$valores.=")";
		
	

	
	$grava_dados="insert into inscricao_pos_contatos_recomendante ".$campos." values ".$valores;


	$query_grava_dados=pg_query($grava_dados);
	if ($query_grava_dados) $devolve="ok"; else $devolve="erro banco";

		
	$query_grava_motivacoes=pg_query("insert into inscricao_pos_carta_motivacao (id_aluno,programa,motivacaoprogramapretendido,edital) values ('$id_aluno','$programa','$cadas3[MotivacaoProgramaPretendido]','$cadas3[edital]')");
	echo "$query_grava_motivacoes";
	
	if ($query_grava_motivacoes) $devolve="ok"; else $devolve="erro banco";
	
//pg_close($con);
	

	

return $devolve;
}

?>
