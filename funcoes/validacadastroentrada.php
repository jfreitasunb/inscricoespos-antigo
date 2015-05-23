<?php


function validacadastro1($cadas1){
	
	$resultadovalidacadastro1[0] = validanome($cadas1[0]);
	$resultadovalidacadastro1[1] = validanome($cadas1[1]);
	$resultadovalidacadastro1[2] = validaselect($cadas1[2]);
	$resultadovalidacadastro1[3] = validaselect($cadas1[3]);
	$resultadovalidacadastro1[4] = validaselect($cadas1[4]);
	$resultadovalidacadastro1[5] = validaselect($cadas1[5]);
	$resultadovalidacadastro1[6] = validanome($cadas1[6]);
	$resultadovalidacadastro1[7] = validaselect($cadas1[7]);
	$resultadovalidacadastro1[8] = validanome($cadas1[8]);
	$resultadovalidacadastro1[9] = validanome($cadas1[9]);
	$resultadovalidacadastro1[10] = validanome($cadas1[10]);
	$resultadovalidacadastro1[11] = validanome($cadas1[11]);
	$resultadovalidacadastro1[12] = validaidentidade($cadas1[12]);
	$resultadovalidacadastro1[13] = validaCEP($cadas1[13]);
	$resultadovalidacadastro1[14] = validaidentidade($cadas1[14]);
	$resultadovalidacadastro1[15] = validaselect($cadas1[15]);
	$resultadovalidacadastro1[16] = validanome($cadas1[16]);
	$resultadovalidacadastro1[17] = validaddi($cadas1[17]);
	$resultadovalidacadastro1[18] = validanumero($cadas1[18]);
	$resultadovalidacadastro1[19] = validanumero($cadas1[19]);
	$resultadovalidacadastro1[20] = validaddi($cadas1[20]);
	$resultadovalidacadastro1[21] = validanumero($cadas1[21]);
	$resultadovalidacadastro1[22] = validanumero($cadas1[22]);
	$resultadovalidacadastro1[23] = validaddi($cadas1[23]);
	$resultadovalidacadastro1[24] = validanumero($cadas1[24]);
	$resultadovalidacadastro1[25] = validanumero($cadas1[25]);
	$resultadovalidacadastro1[26] = validaemail($cadas1[26]);
	$resultadovalidacadastro1[27] = validaemailalt($cadas1[27]);
	$resultadovalidacadastro1[28] = validaCPF($cadas1[28]);
	$resultadovalidacadastro1[29] = validaidentidade($cadas1[29]);
	$resultadovalidacadastro1[30] = validanome($cadas1[30]);
	$resultadovalidacadastro1[31] = validaselect($cadas1[31]);
	$resultadovalidacadastro1[32] = validaselect($cadas1[32]);
	$resultadovalidacadastro1[33] = validaselect($cadas1[33]);
	$resultadovalidacadastro1[34] = validaselect($cadas1[34]);
	$resultadovalidacadastro1[35] = validasenha($cadas1[35]);
	$resultadovalidacadastro1[36] = validasenha($cadas1[36]);
	
	return $resultadovalidacadastro1;
}

?>
