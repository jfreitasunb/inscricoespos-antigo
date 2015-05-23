<?php

include_once("../pgsql/pgsql.php"); 

		$coduser="479";

		
		$query_cadas3 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$coduser."' and id_prof='498'");
		$cadas3 = pg_fetch_assoc($query_cadas3);

		/*$result_gravacao = pg_query("insert into inscricao_pos_recomendacoes  
					(id_prof,id_aluno,nivel,tempoconhececandidato,circunstancia1,circunstancia2,circunstancia3,circunstancia4,
					circunstanciaoutra,desempenhoacademico,capacidadeaprender,capacidadetrabalhar,criatividade,
					curiosidade,esforco,expressaoescrita,expressaooral,relacionamento,edital) 
					values 
					('".$cadas3['id_prof']."',
					'".$cadas3['id_aluno']."',
					'".$cadas3['nivel']."',
					'".$cadas3['tempoconhececandidato']."',
					'".$cadas3['circunstancia1']."',
					'".$cadas3['circunstancia2']."',
					'".$cadas3['circunstancia3']."',
					'".$cadas3['circunstancia4']."',
					'".$cadas3['circunstanciaoutra']."',
					'".$cadas3['desempenhoacademico']."',
					'".$cadas3['capacidadeaprender']."',
					'".$cadas3['capacidadetrabalhar']."',
					'".$cadas3['criatividade']."',
					'".$cadas3['curiosidade']."',
					'".$cadas3['esforco']."',
					'".$cadas3['expressaoescrita']."',
					'".$cadas3['expressaooral']."',
					'".$cadas3['relacionamento']."',
					'2-2013')");*/
					
					$result_gravacao = pg_query("update inscricao_pos_recomendacoes set 
					antecedentesacademicos ='".$cadas3['antecedentesacademicos']."',
					possivelaproveitamento='".$cadas3['possivelaproveitamento']."',
					informacoesrelevantes='".$cadas3['informacoesrelevantes']."',
					comoaluno='".$cadas3['comoaluno']."',
					comoorientando='".$cadas3['comoorientando']."'
					where id_prof='".$cadas3['id_prof']."' and id_aluno='".$cadas3['id_aluno']."' and edital='2-2013'");
	 
var_dump($cadas3);


?>
