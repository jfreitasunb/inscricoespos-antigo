<?php
session_start();
?>

<html>
<meta charset="utf-8"/>
<head><title>Processando Inscrição</title> </head>
<body>
<?php
include("../pgsql/pgsql.php");

// cria coduser:


function grava_cadastro_entrada($cadas1)
{


//define login e senha
$usuario=trim(strtolower($cadas1['mail1']));
$usuario2=trim(strtolower($cadas1['mail2']));
$cpf=$cadas1['cpf'];
$senha=$cadas1['senha'];


//echo $usuario."-".$usuario2."-".$senha;

//$pega_checa=pg_query("select id_aluno from inscricao_pos_dados_candidato 
//						where mail1='".$usuario."' or mail1='".$usuario2."' or 
//						mail2='".$usuario."' or mail2='".$usuario2."'");

$pega_checa=pg_query("select id_aluno from inscricao_pos_dados_candidato where mail1='".$usuario."' or cpf='".$cpf."'");

$num_checa=pg_num_rows($pega_checa);


if ($num_checa==0)
	{
	$pega_checa_login=pg_query("select coduser from inscricao_pos_login where login='".$usuario."' or login='".$usuario2."'");
	$num_login=pg_num_rows($pega_checa_login);
	
	
	if($num_login==0)
	{
	$insere_novo=pg_query("insert into inscricao_pos_login values(default,'".$usuario."',md5('".$senha."'),'candidato')") or die ("Erro EB1: Por favor tente mais tarde.");
	
	//recupera o codusder criado da tabela login:
	sleep(1);
	$pega_coduser=pg_query("select coduser from inscricao_pos_login where login='".$usuario."' and senha=md5('".$senha."')");
	$coduser0=pg_fetch_row($pega_coduser);
	$coduser=$coduser0[0];

	//cria frases para gravar na tabela de dados:
	$campos="(id_aluno";
	$valores="('".$coduser."'";

	foreach($cadas1 as $key => $value)
		{
		if ((strtolower($key)!="senha") and (strtolower($key)!="senharedigitada"))
			{ 
			$campos.=",".strtolower($key);
			if (($value=="")or ($value=="nselecionado")) $valores.=",'0'"; else $valores.=",'".$value."'";
			}
		}
	$campos.=")";
	$valores.=")";

	$grava_dados="insert into inscricao_pos_dados_candidato ".$campos." values ".$valores;
	$query_grava_dados=pg_query($grava_dados);
	pg_close($con);
	if ($query_grava_dados) $devolve="ok"; else $devolve="erro banco";
	}
	else $devolve="login ja existe";
	}
	else $devolve="login ja existe";

	$retorno[0] = $devolve;
	$retorno[1] = $coduser;

return $retorno;
}


//logica

// As funcoes abaixo sao usadas no processamento do cadastro
include_once "../funcoes/converteminuscula.php";
include_once "../funcoes/validacep.php";
include_once "../funcoes/validacpf.php";
include_once "../funcoes/validaemail.php";
include_once "../funcoes/validaidentidade.php";
include_once "../funcoes/validanome.php";
include_once "../funcoes/validanumero.php";
include_once "../funcoes/validaradio.php";
include_once "../funcoes/validaselect.php";
include_once "../funcoes/validatexto.php";
include_once "../funcoes/validaddi.php";
include_once "../funcoes/validaemailalt.php";
include_once "../funcoes/validanomealt.php";
include_once "../funcoes/validasenha.php";
include_once "../funcoes/manda_mail_login.php";


			$cadas1 = $_POST['cadas1'];
			$i=0;
				foreach  ($cadas1 as $campo => $valor){
						$pegacadas1[$i] = $valor ;
						$i = $i+1;	
					}
			
			
			include_once "../funcoes/validacadastroentrada.php";
			
			$resultadovalidacadastro1 = validacadastro1($pegacadas1);

			 
			$Teste11="aceita";
			foreach ($resultadovalidacadastro1 as $campo => $valor){
			        if ($valor == 0){
						$Teste11 = "Rejeita";}
			}
					
			if ( !("$pegacadas1[35]" == "$pegacadas1[36]")){
				 $Teste11="Rejeita";
				 $resultadovalidacadastro1[35] = 0;
				 $resultadovalidacadastro1[36] = 0;
			} 	
			
			if ( (strtolower($pegacadas1[8]) == "brasileira") and (trim($pegacadas1[28])=="") )
				{
					$Teste11 ="Rejeita";
					$resultadovalidacadastro1[28] =0;
				}
			
			
			$_SESSION['resvalcad1'] = $resultadovalidacadastro1;
			
			$_SESSION['repopula'] = $pegacadas1;
			
		
				
			if ( !($Teste11 =="Rejeita")  )
				{
					$resultadogravacao = grava_cadastro_entrada($cadas1);
					$res_manda_mail=manda_mail_login($resultadogravacao[1],$cadas1['senha']);
					

					$_SESSION['coduser'] = $resultadogravacao[1];
															
					if ($resultadogravacao[0] == "ok"){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=confirmacadastro.php'>";
					}
					if ($resultadogravacao[0] == "erro banco"){
						//session_destroy();
						echo "Erro EB1: Por favor, tente mais tarde novamente.";
					}
					if ($resultadogravacao[0] == "login ja existe"){
						//session_destroy();
						$cpf=$cadas1['cpf'];
						$query_pega_mail=pg_query("select mail1 from inscricao_pos_dados_candidato where cpf='".$cpf."'");
						$mailcadastrado = pg_fetch_all($query_pega_mail);
						$num_linhas = pg_num_rows($query_pega_mail);
						
						if ($num_linhas <> 0) {
							echo "<br><br><hr><p align=\"center\"> Sua conta não foi criada. <br>
						<span style=\"color:#FF0000; font-weight:bold\"> Erro: Usuário já existente.</span> <br>
						Você já está cadastrado no nosso sistema com o(s) seguinte(s) login(s):</p>";
						for ($i=0;$i < $num_linhas;$i++){
							$email=$mailcadastrado[$i]['mail1'];
							echo "<p align=\"center\"><span style=\"color:#FF0000; font-weight:bold\">".$email."</span>";
						}
						echo "<br> Para recuperar sua senha <span style=\"font-size:1em;\"> <a href=\"../mudarsenha/esqueceusenha.php\" target=\"_blank\">Clique aqui!</a></span>";
						echo "<hr>";
						}else{
						echo "<br><br><hr><p align=\"center\"> Sua conta não foi criada. <br>
						<span style=\"color:#FF0000; font-weight:bold\"> Erro: Usuário já existente.</span> <br>
						Caso você ainda não tenha criado esta conta entre em contato conosco por e-mail ou telefone.
						<hr></p>";
					}
					}
				
				}
				else{echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=novo-cadastroentrada.php'>";}

//session_destroy();
//setcookie();
?>

</body>
</html>
