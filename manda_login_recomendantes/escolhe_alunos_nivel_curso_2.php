<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body>

<?PHP

//include("../pgsql/pgsql.php");
include("../pgsql/pgsql.php");

$programa=$_POST['curso'];
$verao=$_POST['verao'];

//echo $programa;
//echo $verao;

if(($programa!="0") and ($verao=="0"))
{ 
$query_dados_0="select name||' '||firstname as nome, cr.* from inscricao_pos_dados_candidato dc,inscricao_pos_contatos_recomendante cr where cr.id_aluno=dc.id_aluno and cr.programa='".$programa."' order by nome";
//echo "a linha e:".$query_dados_0;
}

$query_dados=pg_query($query_dados_0) or die ("problema de conexao com o banco");
//echo $query_dados_0;
$dados=pg_fetch_all($query_dados);
//echo $dados[0]['mome'];

//nome_aluno | id_aluno | programa  | nomeprofrecomendante1 | emailprofrecomendante1 | nomeprofrecomendante2 | emailprofrecomendante2 | nomeprofrecomendante3 | emailprofrecomendante3

?>
<html>
  <header>
    <!link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
  <form method="POST" name="formu" action="manda_mail_recomendantes_alunos_selecionados.php">
      <tr>
        <td class=header align=center>
          <h1>Inscrições nos programa de pós-graduação do MAT-UnB: criação/envio de nova senha para recomendantes</h1>
        </td>
      </tr>
      <tr>
	<td align=center>
	<table class=form>
	<tr>
    	<td align=center><b>Selecionne</b></td><td align=center><b>Nome do candidato</b></td><td align=center><b>Curso pretendido</b></td><td align=center><b>Recomendante</b></td><td align=center><b>Mail recomendante</b></td>
	</tr>
<?
	$j=0;
	for ($i=0;$i<count($dados);$i++)
	{
	echo "<tr><td><input type=checkbox name='manda[".$j."]' value=\"".$dados[$i]['id_aluno']."_-_".$dados[$i]['emailprofrecomendante1']."\"></td><td>".$dados[$i]['nome']."</td><td>".$dados[$i]['programa']."</td><td>".$dados[$i]['nomeprofrecomendante1']."</td><td>".$dados[$i]['emailprofrecomendante1']."</td></tr>";
	$j=$j+1;
	echo "<tr><td><input type=checkbox name='manda[".$j."]' value=\"".$dados[$i]['id_aluno']."_-_".$dados[$i]['emailprofrecomendante2']."\"></td><td>".$dados[$i]['nome']."</td><td>".$dados[$i]['programa']."</td><td>".$dados[$i]['nomeprofrecomendante2']."</td><td>".$dados[$i]['emailprofrecomendante2']."</td></tr>";
	$j=$j+1;
	echo "<tr><td><input type=checkbox name='manda[".$j."]' value=\"".$dados[$i]['id_aluno']."_-_".$dados[$i]['emailprofrecomendante3']."\"></td><td>".$dados[$i]['nome']."</td><td>".$dados[$i]['programa']."</td><td>".$dados[$i]['nomeprofrecomendante3']."</td><td>".$dados[$i]['emailprofrecomendante3']."</td></tr>";
	$j=$j+1;
	}
 ?>
	</table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
	<input type=hidden name='programa' value="<? echo $programa;?>"> 
        <input type=submit name='selecionar' value="Confirmar">
        </td>
      </form>
</table>
</body>
</html>
<?
pg_close($con);
?>

</body>
</html>
