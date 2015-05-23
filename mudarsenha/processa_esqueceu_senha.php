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
	<title>Mudando Senha de Acesso</title>
	
	</head>
	
	
	<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Processo Seletivo <?php echo $curso_config;?> / Pós-Graduação <br>
		MAT-UnB <?php echo $ano_config;?>
	</h2>
	<br>
	<br>
	
	<?php 
	
	// Recebe endereço de e-mail da conta que terá o password redefinido.
	$email =trim($_POST['email']);
	// Cria conexão com banco de dados.
	include_once("../pgsql/pgsql.php");
	// Chama função para validar o e-mail digitado
	include_once("../funcoes/validaemail.php");
	// Valida o email digitado
	$resultado_valida_email = validaemail($email);
	// Se o e-mail digitado é valido verifica se ele existe no banco e pega o coduser do usuario
	if ($resultado_valida_email == 1){
		$busca_coduser_do_email = pg_query("select coduser from inscricao_pos_login where login='$email'");
		$numero_de_emails_encontrados = pg_num_rows($busca_coduser_do_email);
			if ($numero_de_emails_encontrados == 0){
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=esqueceusenha.php?email_invalido=2'>";
			}else{
					$pesca_coduser_do_email = pg_query("select coduser from inscricao_pos_login where login='$email'");
					$arraycoduser = pg_fetch_assoc($pesca_coduser_do_email);
					
					$coduser = $arraycoduser['coduser'];
					$codigo = md5($email.time());
					$ultima_mod = date("Y-m-d");
					
			
					$grava_codigo_mud_senha = pg_query("insert into inscricao_pos_muda_senha (coduser,codigo,email,ultima_mod) values ('$coduser','$codigo','$email','$ultima_mod')");
					
					require_once "../lib/PHPMailer/PHPMailerAutoload.php";

					if ($grava_codigo_mud_senha) {
						// Já que os dados foram gravados com sucesso vamos mandar o e-mail.
						$texto="Prezado(a) usuário(a) \n"; 
						$texto .="para escolher sua nova senha ";
						$texto .="clique no link abaixo:\n";
						$det = $coduser*4398050705407;
						$texto .="http://www.mat.unb.br/inscricoespos/mudarsenha/mudar_senha.php?cod=".$codigo."&det=".$det."\n";
						$texto .="e siga as intruções da página. \n";
						$texto .="Em caso de dúvidas entre em contato conosco em posgrad@mat.unb.br. \n";
						$texto .="Coordenação de Pós-Graduação do MAT/UnB."; 
						$texto=wordwrap($texto,70);

						$texto = mb_convert_encoding($texto,'ISO-8859-1','UTF-8');

						// mensagem:
						$subject = "Instruções para acesso ao sistema de inscrições do MAT/UnB";

						$subject = mb_convert_encoding($subject,'ISO-8859-1','UTF-8');
			
						$mail = new PHPMailer(); // defaults to using php "mail()"

						$mail->isSMTP();                                      // Set mailer to use SMTP
						$mail->Host = $email_host;

						$mail->Charset = 'UTF-8';

						$mail->AddReplyTo($email_from,"Pós-Graduação MAT/UnB");

						$mail->SetFrom($email_from);

						$mail->AddAddress($email);

						$mail->Subject    = $subject;

						$mail->MsgHTML($texto);

						if(!$mail->Send()) {
  							$devolve=" Houve algum problema no envio do e-mail ou erro de conexão com o banco de dados.";
							$devolve .="<br> Por favor, tente reiniciar sua senha mais tarde novamente."; 
							echo "<span style=\"color:red\">".$devolve."</span>";
						} else {
  							echo "Caro usuário(a) dentro de alguns instantes você receberá em sua caixa de e-mail <br> 
								uma mensagem com as instruções para redefinir sua senha de acesso.
							<br>
							<br>
							Caso não receba o e-mail com as instruções, por favor, entre em contato conosco pelo endereço 
							<br>
							posgrad@mat.unb.br
							<br>
							ou ligue para (61)-3107-6482 - falar com : Bruna ou Eliana.";
							echo "<br>
							<br>
							<p align=\"center\"> <a href=\"../index.php\">Página de Login</a> </p>";
						}

						// $res_mail=mail($email, mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'), $headers);
						// if ($res_mail){
						// 	echo "Caro usuário(a) dentro de alguns instantes você receberá em sua caixa de e-mail <br> 
						// 		uma mensagem com as instruções para redefinir sua senha de acesso.
						// 	<br>
						// 	<br>
						// 	Caso não receba o e-mail com as instruções, por favor, entre em contato conosco pelo endereço 
						// 	<br>
						// 	posgrad@mat.unb.br
						// 	<br>
						// 	ou ligue para (61)-3107-6482 - falar com : Bruna ou Eliana.";
						// 	echo "<br>
						// 	<br>
						// 	<p align=\"center\"> <a href=\"..\index.php\">Página de Login</a> </p>";
						// }else { $devolve=" Houve algum problema no envio do e-mail ou erro de conexão com o banco de dados.";
						// 		$devolve .="<br> Por favor, tente reiniciar sua senha mais tarde novamente."; 
						// 		echo "<span style=\"color:red\">".$devolve."</span>";
						// }
						
					}else{
							echo "<span style=\"color:red\"> Erro de conexão com banco de dados, favor tentar mais tarde novamente.</span>";
					}
			}
	}else{
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=esqueceusenha.php?email_invalido=1'>";
	}
		
	
	
	?>
	
</body>
