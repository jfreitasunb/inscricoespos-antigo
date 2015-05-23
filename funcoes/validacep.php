<?php
// função para validar cep...
function validaCEP($cep)
{
$cep = trim($cep);
$avaliaCep = ereg("^[0-9]{5}-[0-9]{3}$", $cep);
if($avaliaCep != true)
{
$error = 0;
return $error;
}
else
{
$mensagem = 1;
return $mensagem;
}
} // fim da função
?>
