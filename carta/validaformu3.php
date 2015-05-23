<?php

function validaform3($formu3){
		
		
	$validformu3['nomerecomendante']  = validaidentidade($formu3['nomerecomendante']);
	$validformu3['instituicaorecomendante']  = validaidentidade($formu3['instituicaorecomendante']);
	$validformu3['titulacaorecomendante']  = validaselect($formu3['titulacaorecomendante']);
	$validformu3['arearecomendante']  = validaidentidade($formu3['arearecomendante']);
	$validformu3['anoobtencaorecomendante']  = validaselect($formu3['anoobtencaorecomendante']);
	
	$validformu3['instobtencaorecomendante'] = validaidentidade($formu3['instobtencaorecomendante']);  
	$validformu3['enderecorecomendante'] = validaidentidade($formu3['enderecorecomendante']);
	
	return $validformu3;
} 

?>
