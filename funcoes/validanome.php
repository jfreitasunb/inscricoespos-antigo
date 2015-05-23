<?php

function validanome($nome){ 
	
		
			$string = convertem($nome,0);
			if (preg_match('/^[a-z\d\s\ç\ã\á\à\â\é\ê\ẽ\í\ó\ô\ö\õ\ü\ú\ù]{2,}$/i', $string)){
				$verificacao1 = 1;
				}else{ 
				$verificacao1 = 0;
				}
			
			if (preg_match('/[0-9]/',$string)){
				$verificacao2 = 0;
			}else{
				$verificacao2 = 1;
			}	
			
			if ( strlen($nome)>= 2){
			   $verificacao3 =1 ;
		     }else{
				$verificacao3 =0 ;
			 } 
				
			if ($verificacao1*$verificacao2*$verificacao3 ==1){
				$retornavalidanome = 1;
				return $retornavalidanome;
			}else{
				$retornavalidanome = 0;
				return $retornavalidanome;
			}
}
?>
