
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" type="text/css" href="http://www.mat.unb.br/inscricoespos-completo/css/common-stylesheet.css" />
  </head>


<?php
$i = 1;
	echo "<hr><h2 align='center'>Candidatos selecionados para o Mestrado</h2><hr>";
	foreach (glob("selecionados-mestrado/*.pdf") as $arquivo) {
		$parte = explode("/", $arquivo);
		print $i.") <a href='$arquivo'>$parte[1]</a><br>";
		$i++;
	}
?>

</html>
