 <?php 
session_start();

include_once("../pgsql/pgsql.php");
// cria coduser:


function grava_cadastro_inscricao2($cadas2)
{
//define o usuário
$id_aluno = $_SESSION['coduser'];

//insere na tabela login e cria o coduser:
//echo "insert into inscricao_pos_login values(default,'".$usuario."',md5($senha),'candidato')";
//$pega_checa=pg_query("select coduser from inscricao_pos_login where login='".$usuario."'");
//$num_checa=pg_num_rows($pega_checa);


//	$insere_novo=pg_query("insert into inscricao_pos_login values(default,'".$usuario."',md5('".$senha."'),'candidato')") or die ("Problema de conexao.");

	//recupera o codusder criado da tabela login:
	//$pega_coduser=pg_query("select coduser from inscricao_pos_login where login='".$usuario."' and senha=md5('".$senha."')");
	//$coduser0=pg_fetch_row($pega_coduser);
	//$coduser=$coduser0[0];

	//cria frases para gravar na tabela de dados:
	//$campos="(id_aluno";
	//$valores="('".$id_aluno."'";

	//foreach($cadas2 as $key => $value)
	//	{
	//	$campos.=",".strtolower($key);
	//		if (($value=="")or ($value=="nselecionado")) $valores.=",'0'"; else $valores.=",'".$value."'";
	//	}
	// $campos.=")";
	// $valores.=")";
	// echo "<br>";


$query_grava_dados = pg_query("insert into inscricao_pos_dados_profissionais_candidato 
(id_aluno,instrucaocurso,instrucaograu,
instrucaoinstituicao,instrucaoanoconclusao,experienciatipo1,
experienciatipo2,experienciainstituicao,experienciaperiodoiniciosemestre,
experienciaperiodoinicioano,experienciaperiodofimsemestre,experienciaperiodofimano,
cursopos,verao,cursoverao,areadoutorado,interessebolsa,edital) 
values (
'".$id_aluno."','".$cadas2['InstrucaoCurso']."','".$cadas2['InstrucaoGrau']."',
'".$cadas2['InstrucaoInstituicao']."','".$cadas2['InstrucaoAnoConclusao']."','".$cadas2['ExperienciaTipo1']."',
'".$cadas2['ExperienciaTipo2']."','".$cadas2['ExperienciaInstituicao']."','".$cadas2['ExperienciaPeriodoInicioSemestre']."',
'".$cadas2['ExperienciaPeriodoInicioAno']."','".$cadas2['ExperienciaPeriodoFimSemestre']."','".$cadas2['ExperienciaPeriodoFimAno']."',
'".$cadas2['CursoPos']."','".$cadas2['Verao']."','".$cadas2['CursoVerao']."','".$cadas2['AreaDoutorado']."',
'".$cadas2['InteresseBolsa']."','".$cadas2['edital']."') ");


//	$grava_dados="insert into inscricao_pos_dados_profissionais_candidato ".$campos." values ".$valores;
//echo $grava_dados;
//	$query_grava_dados=pg_query($grava_dados);
	//pg_close($con);
 	
	if ($query_grava_dados) $devolve="ok"; else $devolve="erro banco";
	

return $devolve;
}
?>
