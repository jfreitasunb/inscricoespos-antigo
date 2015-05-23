<?php

		function validasenha ($senha) {
		
			if ( (strlen($senha)>=4) & (preg_match('/(([a-z]+)([0-9]+)|([0-9]+)([a-z]+))/i',"$senha")) ) {
						
						$retornovalidasenha = 1;
						return $retornovalidasenha;
						
			}else{
						$retornovalidasenha = 0;
						return $retornovalidasenha;
					}
}
?>
