<?php
//include_once("../pgsql/pgsql.php");

function verificacad3existe($id_aluno,$edital){

		$pega_cad_existe=pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$id_aluno."' and edital='".$edital."'");
		$num_cad_existe=pg_num_rows($pega_cad_existe);

		if ($num_cad_existe == 0){ $retorno = "nao existe";}else{$retorno = "existe cadastro";}

		return $retorno; 
}		
?>


