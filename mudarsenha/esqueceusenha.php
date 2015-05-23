<?php 
	//session_start();
	//if( !isset($_SESSION['coduser']) ){
	//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
	//exit;
//	}
include("../config/config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Esqueceu a senha?</title>
	
	</head>
	
	
<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Processo Seletivo <?php echo $curos_config;?> / Pós-Graduação <br>
		MAT-UnB <?php echo $ano_config;?>
	</h2>
	<br>
	<br>
	<h3 align="center">
		Para definir uma nova senha, por favor, entre com o endereço<br>
		de e-mail informado no momento da criação da sua conta. 
	</h3>	
	<br>
	<br>
	
	<!-- Inicia Formulário -->
	
	<form name="mudarsenha" method="post" action="processa_esqueceu_senha.php">
	<?php
		if ( isset($_GET['email_invalido']) ){ 
			if ($_GET['email_invalido']==1){ echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
			 <span style=\"color:red\">O endereço de E-mail digitado não é válido ! </span> <br>";
			 }else{
				if ($_GET['email_invalido']==2){ echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
					<span style=\"color:red\">ERRO: O e-mail digitado não corresponde a nenhum usuário registrado no sistema.</span> <br>";
				}
			}
		}
	?>
	
	e-mail:<input autofocus type="text" name="email" size='40' maxlength="200">
	<input type="submit" name="botaomudarsenha" value="Obter nova Senha">
	<input type="reset" value="Limpar dados">
	
	</form>
</body>
