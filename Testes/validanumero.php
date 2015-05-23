<?php

		function validanumero ($numeros) {
		
				if ( !(preg_match( '/[^0-9]/' ,$numeros ) )  ){
						
						$retornovalidanumero = 1;
						return $retornovalidanumero;
						
						}else{
						
						$retornovalidanumero = 0;
						return $retornovalidanumero;
					}
					
}	
?>
