<?php

function validainfrelevante($identidade){
	
		$identidade = convertem($identidade,0);
			
			
			if (preg_match('/^[\/,.a-z\d\s\ç\ã\á\à\â\é\ê\ẽ\í\ó\ô\ö\õ\ü\ú\ù-]{0,}$/i',$identidade)){
						
				$retornavalidaidentidade = 1;
				return $retornavalidaidentidade;
			}else{
				$retornavalidaidentidade = 0;
				return $retornavalidaidentidade;
			}
}
			
?>

