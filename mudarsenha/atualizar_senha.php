<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<?php
include("../config/config.php");
?>
<html>
	<SCRIPT TYPE="text/javascript" SRC="verifynotify.js"></SCRIPT>
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


<?php 

$coduser = $_POST['coduser'];
$codigo = $_POST['codigo'];
$det = $coduser*4398050705407;

if ($_POST['novasenha'] != $_POST['confirmasenha']){
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=mudar_senha.php?errovalida=1&cod=$codigo&det=$det'>";
}else{

	include("../funcoes/validasenha.php");

	$novasenha = $_POST['novasenha'];
	$resultado_valida_novasenha = validasenha($novasenha);

	if ($resultado_valida_novasenha == 0){
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=mudar_senha.php?errovalida=2&cod=$codigo&det=$det'>";
	}else{
		// Já que passamos as duas validações, vamos fazer o update da senha!

		// Chama o banco de dados. 
		include_once("../pgsql/pgsql.php");

		$nova_senha_criptografada = md5($novasenha);

		$atualiza_senha = pg_query("update inscricao_pos_login set senha='$nova_senha_criptografada' where coduser='$coduser'");
		$query_email = pg_query("select login from inscricao_pos_login where coduser='$coduser'");

		$pesca_email = pg_fetch_assoc($query_email);
		$email = $pesca_email['login'];

		if ($atualiza_senha){ 
				echo "Senha atualizada com sucesso !<br> Em breve, você será redirecionado para a página de login.";
				// Aqui mandar um e-mail com as informações de login do usuário
				$texto="Prezado(a) usuário(a) \n"; 
						$texto .="você acaba de reiniciar sua senha.";
						$texto .=" Ao acessar a página :\n";
						$texto .="inscricoespos/ \n";
						$texto .="use os seguintes dados para efetuar seu login \n \n";
						$texto .="nome de usuário: ".$email." \n";
						$texto .="senha: ".$novasenha."\n \n";
						$texto .="Coordenação de Pós-Graduação do MAT/UnB.";
						$texto=wordwrap($texto,70);
						// mensagem:
						$subject = "Dados para login no site de inscrições do MAT/UnB";
						$headers = "FROM: posgrad@mat.unb.br";

						$res_mail=mail($email, mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'), $headers);
		
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='4;URL=../index.php'>";
		}else{ 
			echo "Erro de conexão com o banco de dados, favor tentar mais tarde novamente.";
		}
	}
}
?>


</body>
</html>
