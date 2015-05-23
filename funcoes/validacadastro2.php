<?php


function validacadastro2($cadas2){
		
	$resultadovalidacadastro2[0] = validanome($cadas2["InstrucaoCurso"]);
	$resultadovalidacadastro2[1] = validaselect($cadas2["InstrucaoGrau"]);
	$resultadovalidacadastro2[2] = validanome($cadas2["InstrucaoInstituicao"]);
	
	$resultadovalidacadastro2[3] = validaselect($cadas2["InstrucaoAnoConclusao"]);
	
	// Inicio Verificando $resultadovalidacadastro2[4]
	if ( ( isset($cadas2["CursoPos"]) ) or ( ( isset($cadas2["Verao"]) ) ) ){ 
	$resultadovalidacadastro2[4] = 1;
	}else{
	$resultadovalidacadastro2[4] = 0;
	}


	
	if ($cadas2["Verao"] == "sim") {
		$resultadovalidacadastro2[5] = 1;
	}

	//var_dump($resultadovalidacadastro2);

	//break;
	// Fim Verificando $resultadovalidacadastro2[4]
	
	//Linha abaixo usada quando recebemos inscrições para o programa de doutorado.
	//$resultadovalidacadastro2[5] = 1;
	//usar validação acima quando não tiver doutorado
	
	//precisa ser arrumada para incluir verão e mestrado e verão.
	if ($cadas2["CursoPos"] == "Mestrado" || $cadas2["Verao"] == "sim") {
		$resultadovalidacadastro2[5] = 1;
	}else{
		$resultadovalidacadastro2[5] = validaselect($cadas2["AreaDoutorado"]);		
	}
	
	
	
	$resultadovalidacadastro2[6] = isset($cadas2["InteresseBolsa"]);


	return $resultadovalidacadastro2;
}

?>
