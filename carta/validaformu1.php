<?php

function validaform1($formu1){
		
	$validformu1['nivel'] = validaradio($formu1['nivel']);	
	$validformu1['tempoconhececandidato']  = validaidentidade($formu1['tempoconhececandidato']);
	
	// Esta parte valida circunstância que o recomendante conhece candidato
	
	if ( (isset($formu1['circunstancia1'])) | (isset($formu1['circunstancia2'])) | (isset($formu1['circunstancia3'])) ){
			$validformu1['circunstancia'] = 1;
	}else{
			if (isset($formu1['circunstancia4'])){
			    $validformu1['circunstancia'] = validaidentidade($formu1['circunstanciaoutra']);
			}else{
				$validformu1['circunstancia'] =0;
			 }	
			
	 }
	// Fim valida circunstância.
	
	$validformu1['desempenhoacademico'] = validaradio($formu1['desempenhoacademico']);  
	$validformu1['capacidadeaprender'] = validaradio($formu1['capacidadeaprender']);
	$validformu1['capacidadetrabalhar'] = validaradio($formu1['capacidadetrabalhar']);
	$validformu1['criatividade'] = validaradio($formu1['criatividade']);
	$validformu1['curiosidade'] = validaradio($formu1['curiosidade']);
	$validformu1['esforco'] = validaradio($formu1['esforco']);
	$validformu1['expressaoescrita'] = validaradio($formu1['expressaoescrita']);
	$validformu1['expressaooral'] = validaradio($formu1['expressaooral']);
	$validformu1['relacionamento'] = validaradio($formu1['relacionamento']);
	
	return $validformu1;
} 

?>
