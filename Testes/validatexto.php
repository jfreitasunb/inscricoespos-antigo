<?php

function validatexto($obs){
	
	
			$obs = convertem($obs,0);
			

			if (preg_match('/^[,.a-z\d\s\ç\ã\á\à\â\é\ê\ẽ\í\ó\ô\ö\õ\ü\ú\ù-]{4,}$/i',$obs)){
						
				$retornavalidatexto = 1;
				return $retornavalidatexto;
			}else{
				$retornavalidatexto = 0;
				return $retornavalidatexto;
			}
}
			
?>



