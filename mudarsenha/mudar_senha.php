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
	<SCRIPT TYPE="text/javascript" SRC="../verifynotify.js"></SCRIPT>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Redefinir Senha</title>
	
	</head>
	
	
<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Processo Seletivo <?php echo $curso_config;?> / Pós-Graduação <br>
		MAT-UnB <?php echo $ano_config;?>
	</h2>
	<br>
	<br>
	<h3 align="center">
		Redefinir Senha.
	</h3>	
	<br>
	<br>
	
	
	<?php  
	$codigo = $_GET['cod'];
	$coduser = $_GET['det']/4398050705407;
	$errovalida =$_GET['errovalida'];
	if (isset($errovalida) ){
		$codigo =$_GET['cod'];
		$coduser = $_GET['det']/4398050705407;
	}

	// Cria conexão com banco de dados.
	include_once("../pgsql/pgsql.php");
	
	// Verifica solicitação de mudança de senha
	$pesca_solicitacao = pg_query("select * from inscricao_pos_muda_senha where coduser='$coduser' and codigo='$codigo'");
	$num_pesca_solicitacao = pg_num_rows ($pesca_solicitacao);
	if ( $num_pesca_solicitacao >= 1) {
		}else{
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=erro_mudar_senha.php'>";
		}
	
	// Mensagem de validação de senha digitada
	if ( isset($errovalida) ){
		if ($errovalida == 1){echo "<span style=\"color:red\"> Senhas digitadas não coincidem, favor digitá-las novamente. <br></span>";}
		if ($errovalida == 2){echo "<span style=\"color:red\"> A senha deve conter pelo menos 4 caracteres com letras e números. <br></span>";}
	}
	?>
	
	<br>
	<!-- Inicia Formulário -->
	<form name="mudarsenha" method="post" action="atualizar_senha.php">
	
	<table>
	<tr>
	<td>Escolha sua nova senha:</td>
	<td><input autofocus type="password" name="novasenha" maxlength="30" onKeyUp="verify.check()">
		&nbsp &nbsp (A senha escolhida deverá ser formada por mais de 4 caracteres e deve conter letras e números.)
	</td>
    </tr>
    
    <tr>
    <td>Confirme a nova senha:</td>
    <td><input type="password" name="confirmasenha" onKeyUp="verify.check()"></td>
    </tr>
	</table>	
	<DIV ID="password_result">&nbsp;</DIV>
	
	<p align="center">
	<input type="submit" name="botaomudarsenha" value="Mudar Senha">
	<input type="reset" value="Limpar dados">
	<input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
	<input type="hidden" name="coduser" value="<?php echo $coduser; ?>">
	</p>
	</form>
	<script type="text/javascript">
		verify = new verifynotify();
		verify.field1 = document.mudarsenha.novasenha;
		verify.field2 = document.mudarsenha.confirmasenha;
		verify.result_id = "password_result";
		verify.match_html = "<SPAN STYLE=\"color:blue\">As senhas digitadas são identicas!<\/SPAN>";
		verify.nomatch_html = "<SPAN STYLE=\"color:red\">As senhas digitadas não são iguais.<\/SPAN>";

		// Update the result message
		verify.check();
	</script>
	
</body>
