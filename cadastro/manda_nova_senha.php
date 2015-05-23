<?

function  manda_mail_login($coduser,$senha)
{
$query_mail=pg_query("select login, name||' '||firstname from inscricao_pos_login, inscricao_pos_dados_candidato where coduser='".$coduser."' and coduser=id_aluno");
$mail0=pg_fetch_row($query_mail);
$email=$mail0[0];
$nome=$mail0[1];
$texto="Prezado(a) ".$nome.",\n Seu login é: ".$email."; \n Sua senha é: ".$senha.". \n";
$texto=wordwrap($texto,70);
//echo $email;

// mensagem:
$subject = "Inscricões no program de pós-graduação do MAT/UnB: dados para login"; 
//$headers = "De: coordenacao de pós-graduacao do Departamento de Matemática da Universidade de Brasília - MAT/UnB";

//echo $mail.";\n".$subject." ;\n ".$texto." ;\n".$headers;
$res_mail=mail($email, $subject, $texto,"FROM: posgrad@mat.unb.br \r\n");
if ($res_mail) $devolve="mensagem enviada"; else $devolve="problema no envio de mensagens";

return $devolve;

}

?>
