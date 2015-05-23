<?php 
session_start();

include_once("../pgsql/pgsql.php");

// cria coduser:


function update_cadastro_inscricao2($id_aluno,$cadas2)
{

	//cria frases para gravar na tabela de dados:
	$campos="set ";
	foreach($cadas2 as $key => $value)
		{
               if (($value=="") or ($value=="nselecionado"))$valor=0; else $valor=$value;                
	       if($campos=="set ") $campos.=strtolower($key)."='".$valor."'"; else $campos.=", ".strtolower($key)."='".trim($valor)."'";
		}
	
   
    $query_update_dados="update inscricao_pos_dados_profissionais_candidato ".$campos." where id_aluno='".$id_aluno."' and edital='".$cadas2['edital']."' ";
	$update_cadas2 = pg_query($query_update_dados);
//	pg_close($con);
	

	if ($update_cadas2) $devolve="ok"; else $devolve="erro banco";

return $devolve;
}
?>
