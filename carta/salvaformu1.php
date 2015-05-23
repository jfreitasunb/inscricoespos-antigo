<?php

include_once "../pgsql/pgsql.php";

function salvaformu1($formu1,$edital){
	
	$verifica_gravacao_carta1=pg_query("select * from inscricao_pos_recomendacoes 
			where id_prof='".$formu1['id_prof']."' and id_aluno='".$formu1['id_aluno']."' and edital='".$edital."'");
	
	$gravacao_carta1 = pg_num_rows($verifica_gravacao_carta1);
	
	if ( $gravacao_carta1 == 1 ){
		$result_gravacao = pg_query("update inscricao_pos_recomendacoes set 
					nivel ='".$formu1['nivel']."',
					tempoconhececandidato='".$formu1['tempoconhececandidato']."',
					circunstancia1='".$formu1['circunstancia1']."',
					circunstancia2='".$formu1['circunstancia2']."',
					circunstancia3='".$formu1['circunstancia3']."',
					circunstancia4='".$formu1['circunstancia4']."',
					circunstanciaoutra='".$formu1['circunstanciaoutra']."',
					desempenhoacademico='".$formu1['desempenhoacademico']."',
					capacidadeaprender='".$formu1['capacidadeaprender']."',
					capacidadetrabalhar='".$formu1['capacidadetrabalhar']."',
					criatividade='".$formu1['criatividade']."',
					curiosidade='".$formu1['curiosidade']."',
					esforco='".$formu1['esforco']."',
					expressaoescrita='".$formu1['expressaoescrita']."',
					expressaooral='".$formu1['expressaooral']."',
					relacionamento='".$formu1['relacionamento']."'
					where id_prof='".$formu1['id_prof']."' and id_aluno='".$formu1['id_aluno']."' and edital='".$edital."' ");
		
	}else {
	   $result_gravacao = pg_query("insert into inscricao_pos_recomendacoes  
					(id_prof,id_aluno,nivel,tempoconhececandidato,circunstancia1,circunstancia2,circunstancia3,circunstancia4,
					circunstanciaoutra,desempenhoacademico,capacidadeaprender,capacidadetrabalhar,criatividade,
					curiosidade,esforco,expressaoescrita,expressaooral,relacionamento,edital) 
					values 
					('".$formu1['id_prof']."',
					'".$formu1['id_aluno']."',
					'".$formu1['nivel']."',
					'".$formu1['tempoconhececandidato']."',
					'".$formu1['circunstancia1']."',
					'".$formu1['circunstancia2']."',
					'".$formu1['circunstancia3']."',
					'".$formu1['circunstancia4']."',
					'".$formu1['circunstanciaoutra']."',
					'".$formu1['desempenhoacademico']."',
					'".$formu1['capacidadeaprender']."',
					'".$formu1['capacidadetrabalhar']."',
					'".$formu1['criatividade']."',
					'".$formu1['curiosidade']."',
					'".$formu1['esforco']."',
					'".$formu1['expressaoescrita']."',
					'".$formu1['expressaooral']."',
					'".$formu1['relacionamento']."',
					'".$edital."')");
	 }
	return $result_gravacao;
}

?>
