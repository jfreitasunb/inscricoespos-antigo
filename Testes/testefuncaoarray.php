<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body>

<?php

function validacadastro1($cadas1){
	if ($cadas1['name'] == "Leandro"){
		$retorno[0] = "Bom nome" ;
	} else {
		$retorno[0] = "Deu algum pau" ;
	}
	
	if ($cadas1['firstname'] == "Martins Cioletti"){
		$retorno[1] = "Você acerta mesmo hein !" ;
	} else {
		$retorno[1] = "Deu outro pau Zé-dend'água." ;
	}
	return $retorno;
}

$cadas1['name'] ="Leandro";
$cadas1['firstname'] ="Martins Cioletti";

$resultado = validacadastro1($cadas1);
echo $resultado[0]." ".$resultado[1];


?>

</body>
</html>
