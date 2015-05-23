<?php
session_start();

if( !isset($_SESSION['coduser']) )
	{
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
        exit;
 	}

$coduser=$_SESSION['coduser'];

include("../pgsql/pgsql.php");
include_once("../config/config.php");


if (!isset($_POST['continuar']))
{
?>
<html>
<header>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">

<h2 align="center">
		Cadastro para Processo Seletivo 
			<?php
			echo $curso_config;
			?>
			/ Pós-Graduação 
			<br>
			MAT-UnB 
			<?php echo $ano_config;?>
	</h2>

	<h3 align="center">
		Cadastro - Página 2 de 4
	</h3>
	
<table class=big>
         <tr>
        <td align=center>
               <title>Envio de anexos</title>
        <table class=form>


<form action="upload_de_anexos.php" method="post" enctype="multipart/form-data" OnSubmit="return champsok()">

	<tr><td colspan=2><b>Instruções para envio de arquivos: </b> 
	Os documentos necessários para efetivação de sua inscrição devem ser preparados da seguinte maneira:
	<br>  
	reuna em um único arquivo, no formato PDF ou JPG os seguintes documentos:
	carteira de identidade (frente e verso), CPF (frente e verso) e foto 3x4.
	<br> 
	OBS: não existe nenhum problema deste arquivo ter mais de uma página, contato que seu 
	tamanho seja inferior a 10Mb.
	<br>
	<br>
	O outro arquivo deve conter uma cópia escaneada do seu histórico Escolar. 
	Neste arquivo NÃO deve ser colocado nenhum outro tipo de comprovante.
	<br> 
	Ele deve conter apenas o Histórico da graduação e ou especialização se for o caso. 
	Este arquivo também deve ser em formato PDF ou JPG e pode ter mais 
	do que uma página, porém seu tamanho não poderá exceder o limite de 10Mb.
	<br>
	<br>
	<br>
	Caso tenha algum problema entrar em contato com posgrad@mat.unb.br 

	</td></tr>

		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
		<tr><td colspan=2><b>Escolha o arquivo de anexo para upload:</b></td></tr>

	<tr><td>Arquivo 1. Documentos pessoais (Identidade, CPF e foto):

					<?php  $verifica_up_documentos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."' and tipo='documentos'");
							$num_resultado_verifica_up_documentos = pg_num_rows($verifica_up_documentos);
							if ($num_resultado_verifica_up_documentos >=1){
								echo" <span style=\"color:red\"> Arquivo já enviado. Novo envio irá sobrescrever o arquivo. </span>";  
							}
					 ?>
			&nbsp &nbsp </td><td><input type=file name='arquivo[0]'></td></tr>
	<tr><td>Arquivo 2. Histórico Escolar: 

		<?php 	$verifica_up_historico=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."' and tipo='historico'");
				$num_resultado_verifica_up_historico = pg_num_rows($verifica_up_historico);
				if ($num_resultado_verifica_up_historico >=1){
								echo" <span style=\"color:red\"> Arquivo já enviado. Novo envio irá sobrescrever o arquivo. </span>";  
							}
		 ?>

		&nbsp &nbsp </td><td><input type=file name='arquivo[1]'></td></tr>
<tr> </tr>
<tr><td colspan=2 align=center> <br><br><input type="submit" name='continuar' value="Enviar documentos ou continuar" /></td></tr>
</form>
</table>
</td></tr>
</table>
<p>
				<a href="novo-cadastroinscricao2.php"> Voltar para página anterior </a>

				</p>
	<?php echo"
		<br>
		<p align=\"center\">
		<a href=\"../logout.php\"; title=\"Logout\"><img alt=\"Logout\" src=\"../imagens/sair.png\" border=\"0\" width=\"50\" /></a>
		</p>
		";
	?>
</body>
</html>


<?php
}

if (isset($_POST['continuar']))
{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>


<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Cadastro para Processo Seletivo 
			<?php
			echo $curso_config;
			?>
			/ Pós-Graduação 
			<br>
			MAT-UnB 
			<?php echo $ano_config;?>
	</h2>

	<h3 align="center">Cadastro - Página 3 de 4</h3>


<?php

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../upload/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 *10; // 10Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif','pdf');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'N&atilde;o houve erro';
$_UP['erros'][1] = 'O arquivo no upload &eacute; maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'N&atilde;o foi feito o upload do arquivo';


for ($i=0;$i<2;$i++)
	{

	if ($_FILES['arquivo']['name'][$i]!="")
		{
		//############### CASO ESTEJA PRONTO PARA UPLOAD
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['arquivo']['error'][$i] != 0) 
			{
			die("N&atilde;o foi poss&iacute;vel fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error'][$i]]);
			exit; // Para a execução do script
			}
	 	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'][$i])));
		if (array_search($extensao, $_UP['extensoes']) === false) 
			{
			echo "<p><span style=\"color:red\"> Atençao ! </span> São aceitos apenas arquivos do tipo: pdf e jpg. 
			 <br>
			 Portanto o arquivo ".$_FILES['arquivo']['name'][$i]." não foi enviado para nossos servidores.
			 <br>
			 <a href=\"upload_de_anexos.php\"> 
			 Clique aqui para voltar a página anterior e enviar novo arquivo.</a>
			</p>";
			die();
			}

		// Faz a verificação do tamanho do arquivo
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size'][$i]) 
			{
			echo "O arquivo enviado &eacute; muito grande, envie arquivos de at&eacute; 2Mb.";
			}

		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
			else {
		// Primeiro verifica se deve trocar o nome do arquivo
				if ($_UP['renomeia'] == true) 
					{
		// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
					$data=date("Y-m-d");
					if ($i==0) {$nome_final = $coduser."_".$data."_documentos.".$extensao; $tipo="documentos";}
					if ($i==1) {$nome_final = $coduser."_".$data."_historico.".$extensao; $tipo="historico";}
					} else 
					{
		// Mantém o nome original do arquivo
					$nome_final = $_FILES['arquivo']['name'][$i];
					}

		// Depois verifica se é possível mover o arquivo para a pasta escolhida
				if (move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $_UP['pasta'] . $nome_final)) 
					{
		// Upload efetuado com sucesso, exibe uma mensagem e insere ponteiro na tabela

					// verfica qual arquivo foi enviado com sucesso e exibe a respectiva mensagem

					if ($i == 0){
									echo " <p> Upload dos documentos pessoais foi efetuado com sucesso! </p>";
									$doc_pessoais = 1;
					}

					if ($i == 1) {
									echo " <p> Upload do Histórico escolar foi efetuado com sucesso ! </p>"; 
									$hist_esco = 1;
					}

					$query_checa=pg_query("select * from inscricao_pos_anexos where nome_arquivo='".$nome_final."'");
					$num_checa=pg_num_rows($query_checa);
					if ($num_checa==0) 
						{
						$query_insere="insert into inscricao_pos_anexos values('".$coduser."','".$tipo."','".$nome_final."','".$data."')";
//						//echo $query_insere;
						$res_insere=pg_query($query_insere) or die ("Problemas de conexao com o banco de dados");
						}
					} else 
					{
		// Não foi possível fazer o upload, provavelmente a pasta está incorreta
					echo "N&atilde;o foi poss&iacute;vel enviar o arquivo, tente novamente";
					}

			     }

		}
	}

		$verifica_up_documentos=pg_query("select * from inscricao_pos_anexos where coduser='$coduser' and tipo='documentos'");
		$num_resultado_verifica_up_documentos = pg_num_rows($verifica_up_documentos);


		$verifica_up_historico=pg_query("select * from inscricao_pos_anexos where coduser='$coduser' and tipo='historico'");
		$num_resultado_verifica_up_historico = pg_num_rows($verifica_up_historico);



		if ($num_resultado_verifica_up_documentos == 0){
			echo" <br> <br> <p style=\"color:#FF0000\"> Atenção ! Seus documentos pessoais (RG,CPF e foto) não foram recebidos em nossos servidores. </p>
			Retorne a página anterior para fazer o envio do arquivo ou faça um novo login.";
		}
		if ($num_resultado_verifica_up_historico == 0){
			echo" <br> <br> <br> <br> <p style=\"color:#FF0000\"> Atenção ! Seus Histórico Escolar não foi recebido em nossos servidores. </p>
			Você poderá fazer este envio deste documento retornando a página anterior ou quando fizer um novo login.";
		}

		if ( ($num_resultado_verifica_up_documentos != 0) and ($num_resultado_verifica_up_historico != 0) ){

			//gerar o relatorio em tex
			include_once("gera_ficha_inscricao.php");
			$_SESSION['arquivo'] = $arquivotex.".pdf";

			//
		echo "<br> 
				<!-- 	<h3><p align=\"center\"> Visualize sua ficha de inscrição e aprove o envio para o MAT/UnB.
						</p>
						</h3>
				-->
				<span style=\"font-size:1.5em;\">
				<a href=\"../ficha_inscricao/".$arquivotex.".pdf\" target=\"_blank\"> 
				Clique aqui 
				</a>
				</span> 
				para visualizar sua ficha de inscrição com os dados fornecidos e arquivos anexados. 
				<br>
				Após verifição cuidadosa de que todos
				os dados fornecidos estão corretos, clique em enviar inscrição.
				<br>
				Caso seus documentos anexados não sejam visualizados corretamente, por favor, tente 
				reduzir o tamanho das figuras. Esta ficha de inscrição é feita em LaTeX e a visualização
				é mais nítida se seus documentos anexados forem no formato PDF, de tamanho no máximo A4.
				
				
				<br>
				<br>
				<b> Atenção</b> após o envio da inscrição:
				<ul>
				<li>nenhum dado na ficha de inscrição poderá ser modificado; </li>
				<li>todos os professores indicados para lhe fornecer carta de recomendação receberão e-mail com as instruções para ter acesso a área do site onde eles poderão enviar as carta de recomendação;</li>
				<li> após efetuar novo login no site você poderá verificar quais as cartas de recomendação já foram recebidas pelo nosso sistema.
				</ul> 
				</p>


				<form method=\"POST\" action=\"finaliza.php\">
				<p align=\"center\">
				<input type=\"submit\" name=\"envio\" value=\"Envio definitivo da Inscrição\">
				</p>
				</form>


				<p>
				<a href=\"upload_de_anexos.php\"> Voltar para página anterior </a>
				</p>
				";
				
	}
	echo"
	<p align=\"center\">
	<a href=\"../logout.php\"; title=\"Logout\"><img alt=\"Logout\" src=\"../imagens/sair.png\" border=\"0\" width=\"50\" /></a>
	</p>
	";

?>

</table>
</td></tr>
</table>
</body>
</html>

<?php

}
pg_close($con);
?>
</body>
</html>
