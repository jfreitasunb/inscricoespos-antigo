<?php

function inclusao_login_recomendante($login,$senha)
{
$query_checa=pg_query("select * from inscricao_pos_login where login='".$login."'");
$num_checa=pg_num_rows($query_checa);

if($num_checa==0)
	{
	$query_insere="insert into inscricao_pos_login values(default,'".$login."',md5('".$senha."'),'recomendante')";
	$res_insere=pg_query($query_insere) or die ("Problema de conexao com o banco.");
	//echo $query_insere."<br>";
	if($res_insere) $devolve="gravado"; else $devolve="problema";
	}
	else $devolve="ja_existe";
return $devolve;
}

?>
