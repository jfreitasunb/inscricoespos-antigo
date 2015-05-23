<?php

include_once "../pgsql/pgsql.php";

function salvaformu3($formu3,$completo,$edital){
	
	$verifica_gravacao_carta3=pg_query("select * from inscricao_pos_dados_pessoais_recomendante 
			where id_prof='".$formu3['id_prof']."'");
	
	$gravacao_carta3 = pg_num_rows($verifica_gravacao_carta3);
	
	if ( $gravacao_carta3 == 1 ){
		$result_gravacao = pg_query("update inscricao_pos_dados_pessoais_recomendante set 
					id_prof='".$formu3['id_prof']."',
					nomerecomendante='".$formu3['nomerecomendante']."',
					instituicaorecomendante ='".$formu3['instituicaorecomendante']."',
					titulacaorecomendante='".$formu3['titulacaorecomendante']."',
					arearecomendante='".$formu3['arearecomendante']."',
					anoobtencaorecomendante='".$formu3['anoobtencaorecomendante']."',
					instobtencaorecomendante='".$formu3['instobtencaorecomendante']."',
					enderecorecomendante='".$formu3['enderecorecomendante']."'
					where id_prof='".$formu3['id_prof']."'");
		
	}else {
	   $result_gravacao = pg_query("insert into inscricao_pos_dados_pessoais_recomendante
					(id_prof,nomerecomendante,instituicaorecomendante,titulacaorecomendante,
					arearecomendante,anoobtencaorecomendante,instobtencaorecomendante,enderecorecomendante) 
					values 
					('".$formu3['id_prof']."',
					'".$formu3['nomerecomendante']."',
					'".$formu3['instituicaorecomendante']."',
					'".$formu3['titulacaorecomendante']."',
					'".$formu3['arearecomendante']."',
					'".$formu3['anoobtencaorecomendante']."',
					'".$formu3['instobtencaorecomendante']."',
					'".$formu3['enderecorecomendante']."')");
	 


	}

		$grava_finalizacao = pg_query("update inscricao_pos_recomendacoes 
		set completo ='".$completo."' 
		where id_prof='".$formu3['id_prof']."' and id_aluno='".$formu3['id_aluno']."' and edital='".$edital."'");


	
	return $result_gravacao;
}

?>
