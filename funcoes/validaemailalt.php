<?php
// Define uma função que poderá ser usada para validar e-mails usando regexp
function validaemailalt($email) {
$conta = "^[a-zA-Z0-9/._-]+@";
$dominio = "[a-zA-Z0-9/._-]+.";
$extensao = "([a-zA-Z]{2,4})$";

$pattern = $conta.$dominio.$extensao;

$email = trim($email); 
		      
		if (!($email == "" )){

					if (ereg($pattern, $email)){
						$retornovalidaemailalt = 1;
						return $retornovalidaemailalt;
					} else{
						$retornovalidaemailalt = 0;
						return $retornovalidaemailalt;
						}
        }



		else{
					
					$retornovalidaemailalt = 1;
						return $retornovalidaemailalt;

		}
}		
?>
