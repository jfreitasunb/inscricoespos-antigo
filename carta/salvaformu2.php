<?php

include_once "../pgsql/pgsql.php";

function salvaformu2($formu2,$edital){
	
	$result_gravacao = pg_query("update inscricao_pos_recomendacoes set 
					antecedentesacademicos ='".$formu2['antecedentesacademicos']."',
					possivelaproveitamento='".$formu2['possivelaproveitamento']."',
					informacoesrelevantes='".$formu2['informacoesrelevantes']."',
					comoaluno='".$formu2['comoaluno']."',
					comoorientando='".$formu2['comoorientando']."'
					where id_prof='".$formu2['id_prof']."' and id_aluno='".$formu2['id_aluno']."' and edital='$edital'");
		
		return $result_gravacao;
}

?>
