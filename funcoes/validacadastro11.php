<?php


function validacadastro11($cadas1){
	
	$resultadovalidacadastro1[0] = validanome($cadas1['name']);
	$resultadovalidacadastro1[1] = validanome($cadas1['firstname']);
	$resultadovalidacadastro1[2] = validaselect($cadas1['DiaNascimento']);
	$resultadovalidacadastro1[3] = validaselect($cadas1['MesNascimento']);
	$resultadovalidacadastro1[4] = validaselect($cadas1['AnoNascimento']);
	$resultadovalidacadastro1[5] = validaselect($cadas1['sexo']);
	$resultadovalidacadastro1[6] = validanome($cadas1['naturalidade']);
	$resultadovalidacadastro1[7] = validaselect($cadas1['UFNaturalidade']);
	$resultadovalidacadastro1[8] = validanome($cadas1['Nacionalidade']);
	$resultadovalidacadastro1[9] = validanome($cadas1['PaisNacionalidade']);
	$resultadovalidacadastro1[10] = validanome($cadas1['nome_pai']);
	$resultadovalidacadastro1[11] = validanome($cadas1['nome_mae']);
	$resultadovalidacadastro1[12] = validaidentidade($cadas1['adresse']);
	$resultadovalidacadastro1[13] = validaCEP($cadas1['CPEndereco']);
	$resultadovalidacadastro1[14] = validanome($cadas1['CityEndereco']);
	$resultadovalidacadastro1[15] = validaselect($cadas1['UFEndereco']);
	$resultadovalidacadastro1[16] = validanome($cadas1['country']);
	$resultadovalidacadastro1[17] = validanumero($cadas1['DDI_PhoneWork']);
	$resultadovalidacadastro1[18] = validanumero($cadas1['DDD_PhoneWork']);
	$resultadovalidacadastro1[19] = validanumero($cadas1['PhoneWork']);
	$resultadovalidacadastro1[20] = validanumero($cadas1['DDI_PhoneHome']);
	$resultadovalidacadastro1[21] = validanumero($cadas1['DDD_PhoneHome']);
	$resultadovalidacadastro1[22] = validanumero($cadas1['PhoneHome']);
	$resultadovalidacadastro1[23] = validanumero($cadas1['DDI_cel']);
	$resultadovalidacadastro1[24] = validanumero($cadas1['DDD_cel']);
	$resultadovalidacadastro1[25] = validanumero($cadas1['TelCelular']);
	$resultadovalidacadastro1[26] = validaemail($cadas1['mail1']);
	$resultadovalidacadastro1[27] = validaemail($cadas1['mail2']);
	$resultadovalidacadastro1[28] = validaCPF($cadas1['cpf']);
	$resultadovalidacadastro1[29] = validaidentidade($cadas1['identity']);
	$resultadovalidacadastro1[30] = validanome($cadas1['id_emissor']);
	$resultadovalidacadastro1[31] = validaselect($cadas1['EstadoEmissaoId']);
	$resultadovalidacadastro1[32] = validaselect($cadas1['DiaEmissaoId']);
	$resultadovalidacadastro1[33] = validaselect($cadas1['MesEmissaoId']);
	$resultadovalidacadastro1[34] = validaselect($cadas1['AnoEmissaoId']);
	
	
	
	return $resultadovalidacadastro1;
}

?>
