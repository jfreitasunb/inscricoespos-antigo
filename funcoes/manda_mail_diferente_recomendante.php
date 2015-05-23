<?php 

function manda_mail_diferente_recomendante($mail_recomendante,$id_aluno,$programa,$edital,$data_limite)
{
	require_once "../lib/PHPMailer/PHPMailerAutoload.php";
	require "../config/config.php";
	
	$query_busca=pg_query("select name||' '||firstname as nome, cr.* from inscricao_pos_dados_candidato dc,inscricao_pos_contatos_recomendante cr where cr.edital='".$edital."' and cr.id_aluno=dc.id_aluno and dc.id_aluno='".$id_aluno."' and cr.programa='".$programa."'");

	$dados=pg_fetch_row($query_busca);
	//print_r($dados);
	for ($i=4;$i<9;$i=$i+2)
		{
			if ($dados[$i]==$mail_recomendante) $nome_recomendante=$dados[$i-1];
		}

	if (($nome_recomendante!="") and ($mail_recomendante!=""))
		{
			$nome_aluno=$dados[0];

			$texto="<div>
	Prezado(a) Prof(a). ".$nome_recomendante.",</div>
<div>
	&nbsp; &nbsp;Outro candidato solicita que o senhor(a) preencha uma nova carta de recomenda&ccedil;&atilde;o.</div>
<div>
	&nbsp; <span class='Apple-tab-span' style='white-space:pre'> </span>Para poder enviar a carta de recomenda&ccedil;&atilde;o do(a) aluno(a) ".$nome_aluno." para inscri&ccedil;&atilde;o no Programa de ".$programa." do MAT/UnB,</div>
<div>
	&nbsp; <span class='Apple-tab-span' style='white-space:pre'> </span>solicitamos que acesse o link <a href='http://www.mat.unb.br/inscricoespos'>http://www.mat.unb.br/inscricoespos</a>.</div>
<div>
	&nbsp; &nbsp;Utilize seu login e senha enviados em mail anterior. Caso tenha perdido sua senha basta clicar no link <a href='http://www.mat.unb.br/inscricoespos/mudarsenha/esqueceusenha.php'>http://www.mat.unb.br/inscricoespos/mudarsenha/esqueceusenha.php</a> para definir uma nova senha.</div>
<div>
	&nbsp; &nbsp;<span class='Apple-tab-span' style='white-space:pre'> </span>O envio desta carta pode ser feito at&eacute; o dia <strong>".$data_limite."</strong>.</div>
<div>
	&nbsp; &nbsp; Antecipadamente agradecemos,</div>
<div>
	&nbsp; &nbsp;Coordena&ccedil;&atilde;o de P&oacute;s-Gradua&ccedil;&atilde;o do MAT/UnB.</div>
"; 
			
			$texto=wordwrap($texto,70);
			$texto = mb_convert_encoding($texto,'ISO-8859-1','UTF-8');
			$reply_to = mb_convert_encoding("Pós-Graduação MAT/UnB",'ISO-8859-1','UTF-8');

			// mensagem:
			
			$subject = "Dados de acesso para recomendação do(a) aluno(a) ".$nome_aluno." para o Programa de ".$programa." do MAT/UnB";
			
			$subject = mb_convert_encoding($subject,'ISO-8859-1','UTF-8');
			
			$mail = new PHPMailer(); // defaults to using php "mail()"

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $email_host;

			$mail->Charset = 'UTF-8';

			$mail->IsHTML(true);
            $mail->ContentType = 'text/html';
            $mail->Body = $texto;

			$mail->AddReplyTo($email_from,$reply_to);

			$mail->SetFrom($email_from);

			$mail->AddAddress($mail_recomendante, $nome_recomendante);

			$mail->Subject    = $subject;

			//$mail->MsgHTML($texto);

			//echo $mail_recomendante.";\n".$subject." ;\n ".$texto." ;\n".$headers."<br>";
			//$res_mail=mail($mail_recomendante, mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'), $headers);
			if(!$mail->Send()) {
  				echo $mail->ErrorInfo;
			} else {
  				$devolve="mensagem enviada";
			}
		}else $devolve="Nao ha nome ou mail do recomendante";
	return $devolve;

}
?>
