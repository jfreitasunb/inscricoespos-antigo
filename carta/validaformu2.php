<?php

function validaform2($formu2){
		
		
	$validformu2['antecedentesacademicos']  = validaidentidade($formu2['antecedentesacademicos']);
	$validformu2['possivelaproveitamento']  = validaidentidade($formu2['possivelaproveitamento']);
	$validformu2['informacoesrelevantes']  = validainfrelevante($formu2['informacoesrelevantes']);
	
	
	$validformu2['comoaluno'] = validaradio($formu2['comoaluno']);  
	$validformu2['comoorientando'] = validaradio($formu2['comoorientando']);
	
	return $validformu2;
} 

?>
