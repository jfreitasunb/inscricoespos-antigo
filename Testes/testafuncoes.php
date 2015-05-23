<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php

include "converteminuscula.php";
include "validacep.php";
include "validacpf.php";
include "validaemail.php";
include "validanome.php";
include "validaidentidade.php";
include "validatexto.php";
include "validanumero.php";
include "validaselect.php";
include "validaradio.php";


$cep = $_POST["cep"];
$cpf = $_POST["cpf"];
$nome =$_POST["nome"];
$email = $_POST["email"];
$InstrucaoGrau =$_POST["InstrucaoGrau"];
$identidade = $_POST["identidade"];
$InteresseBolsa =$_POST["InteresseBolsa"];
$obs =$_POST["obs"];
$numeros = $_POST["numeros"];


echo $cep."<br>".$cpf."<br>".$email."<br>".$nome."<br>".$InstrucaoGrau
."<br>".$identidade."<br>".$InteresseBolsa."<br>".$obs."<br>".$numeros;



echo "<p></p>";
echo "<br>".validaCEP($cep);
echo "<br>".validaCPF($cpf);
echo "<br>".validaemail($email);
echo "<br>".validanome($nome);
echo "<br>".validaidentidade($identidade);
echo "<br>".validaselect($InstrucaoGrau);
echo "<br>".validatexto($obs);
echo "<br>".validanumero($numeros)."<br>";
 

?>

</body>
</html>
