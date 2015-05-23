<?
function  confirmainscricao($coduser,$arquivopdf)
{
$query_pega_mail=pg_query("select login from inscricao_pos_login where coduser='".$coduser."'");
$query_pega_nome=pg_query("select name||' '||firstname from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
$mail0=pg_fetch_row($query_pega_mail);
$nome0=pg_fetch_row($query_pega_nome);
$email=$mail0[0];
$nome=$nome0[0];

$texto="Prezado(a) ".$nome.",\n \n Sua inscrição foi recebida com sucesso em nosso sistema. \n Para verificar se suas cartas
de recomendação já foram enviadas, efetue o login no site www.mat.unb.br/inscricoespos utilizando os dados enviados anteriormente.\n \n
Coordenação de pós-graduação MAT-UnB.";

$texto=wordwrap($texto,70);

$texto = mb_convert_encoding($texto,'ISO-8859-1','UTF-8');

$subject = "Inscrição no Programa de Pós-graduação do MAT/UnB";

$subject = mb_convert_encoding($subject,'ISO-8859-1','UTF-8');


//para envia a mensagem sem o anexo comentar o trecho abaixo
//require('libphp-phpmailer/class.phpmailer.php');
require_once "../lib/PHPMailer/PHPMailerAutoload.php";
require "../config/config.php";

$mail = new PHPMailer(); // defaults to using php "mail()"

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $email_host;

$mail->Charset = 'UTF-8';

$mail->AddReplyTo($email_from,"Pós-Graduação MAT/UnB");

$mail->SetFrom($email_from);

//$mail->AddReplyTo("name@yourdomain.com","First Last");

//$address = "whoto@otherdomain.com";
$mail->AddAddress($email, $nome);

$mail->Subject    = $subject;

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($texto);

$mail->AddAttachment("../ficha_inscricao/".$arquivopdf,"Ficha de Inscricao.pdf");      // attachment
// $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo $mail->ErrorInfo;
} else {
  echo "Foi enviado para seu endereço de e-mail uma cópia da sua ficha de inscrição!</br>";
}


//até a linha acima



//echo $email;

// mensagem:
//$headers = "De: coordenacao de pós-graduacao do Departamento de Matemática da Universidade de Brasília - MAT/UnB";

//echo $mail.";\n".$subject." ;\n ".$texto." ;\n".$headers;
//$res_mail=mail($email, $subject, $texto,"FROM: posgrad@mat.unb.br \r\n");
//if ($res_mail) $devolve="mensagem enviada"; else $devolve="problema no envio de mensagens";

//return $devolve;

}

?>
