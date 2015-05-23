<?php
// Define uma função que poderá ser usada para validar e-mails usando regexp
function validaemail($email) {
$conta = "^[a-zA-Z0-9/._-]+@";
$dominio = "[a-zA-Z0-9/._-]+.";
$extensao = "([a-zA-Z]{2,4})$";
$email = trim($email);

$pattern = $conta.$dominio.$extensao;

			if (ereg($pattern, $email)){
				$retornovalidaemail = 1;
				return $retornovalidaemail;
			} else{
				$retornovalidaemail = 0;
				return $retornovalidaemail;
			}
}
?>
