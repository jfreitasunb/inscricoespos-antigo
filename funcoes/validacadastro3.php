<?php


function validacadastro3($cadas3){
	
	$resultadovalidacadastro3[0] = validanome($cadas3["NomeProfRecomendante1"]);
	$resultadovalidacadastro3[1] = validaemail($cadas3["EmailProfRecomendante1"]);
	$resultadovalidacadastro3[2] = validanome($cadas3["NomeProfRecomendante2"]);
	$resultadovalidacadastro3[3] = validaemail($cadas3["EmailProfRecomendante2"]);
	$resultadovalidacadastro3[4] = validanome($cadas3["NomeProfRecomendante3"]);
	$resultadovalidacadastro3[5] = validaemail($cadas3["EmailProfRecomendante3"]);
	$resultadovalidacadastro3[6] = validatexto($cadas3["MotivacaoProgramaPretendido"]);
	$resultadovalidacadastro3[7] = isset($cadas3["Assinatura"]);
	
	return $resultadovalidacadastro3;
}

?>
