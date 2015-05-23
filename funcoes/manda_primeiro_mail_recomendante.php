<?php 

function manda_primeiro_mail_recomendante($mail_recomendante,$senha_recomendante,$id_aluno,$programa,$data_limite)
{
	require_once "../lib/PHPMailer/PHPMailerAutoload.php";
	require "../config/config.php";
	$query_busca=pg_query("select name||' '||firstname as nome, cr.* 
							from inscricao_pos_dados_candidato dc,inscricao_pos_contatos_recomendante cr 
							where 
							cr.id_aluno=dc.id_aluno and dc.id_aluno='".$id_aluno."' and cr.programa='".$programa."'");

	$dados=pg_fetch_row($query_busca);
	//print_r($dados);
	for ($i=4;$i<9;$i=$i+2)
		{
			if ($dados[$i]==$mail_recomendante) {
				$nome_recomendante=$dados[$i-1];
			}
		}

	if (($nome_recomendante!="") and ($mail_recomendante!="")){

		$nome_aluno=$dados[0];
		
		$texto="<div>
	Prezado(a) Prof(a). ".$nome_recomendante.",</div>
<div>
	Para poder enviar a carta de recomendação do(a) aluno(a) ".$nome_aluno." para inscriçãoo no Programa de ".$programa." do MAT/UnB, solicitamos que acesse o link</div>
<div style='margin-left: 40px;'>
	<a href='http://mat.unb.br/inscricoespos'>http://www.mat.unb.br/inscricoespos</a></div>
<div>
	Seus dados para acesso ao preenchimento da carta são:</div>
<div style='margin-left: 40px;'>
	Login: ".$mail_recomendante."</div>
<div style='margin-left: 40px;'>
	Senha : ".$senha_recomendante."</div>
<div>
	O envio desta carta pode ser feito até o dia <strong>".$data_limite."</strong></div>
<div>
	Antecipadamente agradecemos,</div>
<div>
	Coordenação de Pós-Graduação do MAT/UnB.</div>

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

		$mail->AddReplyTo($email_from,$reply_to);

		$mail->SetFrom($email_from);

		$mail->AddAddress($mail_recomendante, $nome_recomendante);

		$mail->Subject    = $subject;

		$mail->MsgHTML($texto);

		//echo $mail_recomendante.";\n".$subject." ;\n ".$texto." ;\n".$headers."<br>";
		//$res_mail=mail($mail_recomendante, mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'), $headers);
		if(!$mail->Send()) {
				$devolve="problema no envio de mensagens";
		} else {
				$devolve="mensagem enviada";
		}
	}
	else $devolve="Nao ha nome ou mail do recomendante";
	return $devolve;

}

?>
