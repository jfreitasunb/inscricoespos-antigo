<?

function  manda_mail_login($coduser,$senha)
{
	require_once "../lib/PHPMailer/PHPMailerAutoload.php";
	require "../config/config.php";

	$query_mail=pg_query("select login, name||' '||firstname from inscricao_pos_login, inscricao_pos_dados_candidato where coduser='".$coduser."' and coduser=id_aluno");
	$mail0=pg_fetch_row($query_mail);
	$email=$mail0[0];
	$nome=$mail0[1];

	$texto="<div>
	Prezado(a) ".$nome.",</div>
<div>
	Sua conta foi criada com sucesso.</div>
<div>
	Seus dados para acesso ao site <a href='http://mat.unb.br/inscricoespos'>http://mat.unb.br/inscricoespos</a> são:</div>
<div style='margin-left: 40px;'>
	Login: ".$email."</div>
<div style='margin-left: 40px;'>
	Senha: ".$senha.".</div>
<div>
	Utilize estas informações no seu próximo login para completar sua inscrição.</div>
<div>
	Coordenação de Pós-Graduação do MAT-UnB.</div>
";
	$texto=wordwrap($texto,70);

	$texto = mb_convert_encoding($texto,'ISO-8859-1','UTF-8');

	$subject = "Inscricões no programa de pós-graduação do MAT/UnB: dados para login";

	$subject = mb_convert_encoding($subject,'ISO-8859-1','UTF-8');

	$reply_to = mb_convert_encoding("Pós-Graduação MAT/UnB",'ISO-8859-1','UTF-8');

	$mail = new PHPMailer(); // defaults to using php "mail()"

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $email_host;

	$mail->Charset = 'UTF-8';

	$mail->AddReplyTo($email_from,$reply_to);

	$mail->SetFrom($email_from);

	$mail->AddAddress($email, $nome);

	$mail->Subject    = $subject;

	$mail->MsgHTML($texto);

	if(!$mail->Send()) {
  		$devolve="problema no envio de mensagens";
	} else {
  		$devolve="mensagem enviada";
	}

	return $devolve;

}

?>
