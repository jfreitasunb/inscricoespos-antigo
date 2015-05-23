<?php 

include_once("../pgsql/pgsql.php");

// cria coduser:


function update_cadastro_inscricao3($id_aluno,$cadas3,$edital_atual)
{

	//cria frases para gravar na tabela de dados:
	$campos="set ";
	foreach($cadas3 as $key => $value)
		{
           if (($value=="") or ($value=="nselecionado"))$valor=0; else $valor=$value;                
	       if ( !(strtolower($key) == "motivacaoprogramapretendido") AND !(strtolower($key) == "assinatura") ){
				if($campos=="set ") $campos.=strtolower($key)."='".trim($valor)."'"; else $campos.=", ".strtolower($key)."='".trim($valor)."'";
			}
		}
	
	//recupera o curso a qual a pessoa esta se candidatando:
	$pega_programa=pg_query("select cursopos,verao from inscricao_pos_dados_profissionais_candidato where id_aluno='".$id_aluno."' and edital='".$edital_atual."'");
	if ($pega_programa) $devolve="ok"; else $devolve="erro banco";
	
	$vetor_programa=pg_fetch_row($pega_programa);

	if ( ($vetor_programa[0] == "0") AND ($vetor_programa[1] == "sim")  ){$programa ="Verão";}
	if ( ($vetor_programa[0] == "Mestrado") AND ($vetor_programa[1] == "sim")  ){$programa ="Mestrado e Verão";}
	if ( ($vetor_programa[0] == "Mestrado") AND ($vetor_programa[1] == "0")  ){$programa ="Mestrado";}
	if ( ($vetor_programa[0] == "Doutorado") AND ($vetor_programa[1] == "sim")  ){$programa ="Doutorado e Verão";}
	if ( ($vetor_programa[0] == "Doutorado") AND ($vetor_programa[1] == "0")  ){$programa ="Doutorado";}
	//
	
	$campos .=", programa='".$programa."'";
	
	
	$query_update_dados="update inscricao_pos_contatos_recomendante ".$campos." where id_aluno='".$id_aluno."' and edital='".$edital_atual."'";
	$update_cadas3 = pg_query($query_update_dados);
	$update_motivacao = pg_query("update inscricao_pos_carta_motivacao 
		set programa='".$programa."', motivacaoprogramapretendido='".$cadas3['MotivacaoProgramaPretendido']."',
		edital='".$cadas3['edital']."' where id_aluno='".$id_aluno."' and edital='".$cadas3['edital']."'");
//	pg_close($con);

	if (($update_cadas3) AND ($update_motivacao) ) $devolve="ok"; else $devolve="erro banco";

return $devolve;
}
?>
