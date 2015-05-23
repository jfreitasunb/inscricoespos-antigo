<?php
session_start();

if( !isset($_SESSION['coduser']) )
	{
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
        exit;
 	}

$coduser=$_SESSION['coduser'];
$arquivopdf = $_SESSION['arquivo'];

 // $coduser = 1;
 // $arquivopdf = "Doutorado-68e6f6f815b50f474cf0dc22d4f400725.pdf";


include_once("../pgsql/pgsql.php");
include_once("../config/config.php");
//confirmainscricao($coduser,$arquivopdf);
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

	<h3 align="center">Cadastro - Página 4 de 4</h3>

<?php
// Define edital e data

$data = date("Y-m-d");
//

// funcoes auxiliares
include_once "../funcoes/gera_senha.php";
include_once "../funcoes/manda_mail_diferente_recomendante.php";
include_once "../funcoes/manda_primeiro_mail_recomendante.php";
include_once "../funcoes/inclusao_login_recomendante.php";
//

$query_verifica_finalizacao = pg_query ("select * from inscricao_pos_finaliza where coduser='$coduser' and edital='$edital_atual'");
$num_ocorrencias = pg_num_rows($query_verifica_finalizacao);

// Verificar o status de finalização

// Gera lista de recomendantes
$query_lista_recomendantes = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='$coduser' and edital='$edital_atual' ");
$lista_recomendantes = pg_fetch_assoc($query_lista_recomendantes);

// Criar conta recomendante 1

// Definimos algumas variáveis
$emailprofrecomendante1 = trim(stripslashes(strtolower($lista_recomendantes['emailprofrecomendante1'])));
$senha1 = gera_senha();

$emailprofrecomendante2 = trim(stripslashes(strtolower($lista_recomendantes['emailprofrecomendante2'])));
$senha2 = gera_senha();

$emailprofrecomendante3 = trim(stripslashes(strtolower($lista_recomendantes['emailprofrecomendante3'])));
$senha3 = gera_senha();

$programa = $lista_recomendantes['programa'];
//
echo "<br>";

// Função abaixo verifica se o recomendante1 existe senão cria conta
$cria_conta_recomendante1 = inclusao_login_recomendante($emailprofrecomendante1,$senha1);

if ($cria_conta_recomendante1 == "ja_existe"){
		$resultado_manda_email_diferente1 = manda_mail_diferente_recomendante($emailprofrecomendante1,$coduser,$programa,$edital_atual,$data_limite);
		if ($resultado_manda_email_diferente1 != "mensagem enviada"){
			echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante1."
				<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
				para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
		}else{
		echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante1." !</p>";
		}

}else{ 	if ($cria_conta_recomendante1 == "gravado"){
			$primeiro_email = manda_primeiro_mail_recomendante($emailprofrecomendante1,$senha1,$coduser,$programa,$data_limite);
			if ($primeiro_email != "mensagem enviada"){
				echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante1."
					<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
					para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
			}else{
				echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante1."!</p>";
			}
		}else{ if ($cria_conta_recomendante1 == "problema")
			echo "Problema de conexão com banco de dados. Favor tentar enviar sua inscrição novamente mais tarde.";
		}
}


// Função abaixo verifica se o recomendante2 existe senão cria conta
$cria_conta_recomendante2 = inclusao_login_recomendante($emailprofrecomendante2,$senha2);

if ($cria_conta_recomendante2 == "ja_existe"){
		$resultado_manda_email_diferente2 = manda_mail_diferente_recomendante($emailprofrecomendante2,$coduser,$programa,$edital_atual,$data_limite);

		if ($resultado_manda_email_diferente2 != "mensagem enviada"){
			echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante2."
				<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
				para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
		}else{
		echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante2."!</p>";
		}

}else{ 	if ($cria_conta_recomendante2 == "gravado"){
			$primeiro_email = manda_primeiro_mail_recomendante($emailprofrecomendante2,$senha2,$coduser,$programa,$data_limite);
			if ($primeiro_email != "mensagem enviada"){
				echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante2."
				<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
				para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
			}else{
				echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante2."!</p>";
			}
		}else{ if ($cria_conta_recomendante2 == "problema")
			echo "Problema de conexão com banco de dados. Favor tentar enviar sua inscrição novamente mais tarde.";
		}
}

// Função abaixo verifica se o recomendante3 existe senão cria conta
$cria_conta_recomendante3 = inclusao_login_recomendante($emailprofrecomendante3,$senha3);

if ($cria_conta_recomendante3 == "ja_existe"){
		$resultado_manda_email_diferente3 = manda_mail_diferente_recomendante($emailprofrecomendante3,$coduser,$programa,$edital_atual,$data_limite);

		if ($resultado_manda_email_diferente3 != "mensagem enviada"){
			echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante3."
				<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
				para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
		}else{
				echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante3."!</p>";
			}

}else{ 	if ($cria_conta_recomendante3 == "gravado"){
			$primeiro_email = manda_primeiro_mail_recomendante($emailprofrecomendante3,$senha3,$coduser,$programa,$data_limite);
			if ($primeiro_email != "mensagem enviada"){
			echo "<p> Problemas no envio de e-mail para o endereço ".$emailprofrecomendante3."
			<br> Por favor, <a href=\"novo-cadastroinscricao2.php\"> clique aqui </a>
			para verificar se o e-mail foi digitado corretamente e tente enviar novamente sua inscrição</p>";
			}else{
				echo "<p> Mensagem enviada com sucesso para ".$emailprofrecomendante3."!</p>";
			}
		}else{ if ($cria_conta_recomendante3 == "problema")
			echo "Problema de conexão com banco de dados. Favor tentar enviar sua inscrição novamente mais tarde.";
		}
}


if ($num_ocorrencias == 0) {
		//insere as informações de finalização no banco de dados
		$query_finaliza = pg_query("INSERT INTO inscricao_pos_finaliza (coduser,edital,data,finalizada)
									VALUES ('$coduser','$edital_atual','$data','sim') ");
		if ($query_finaliza) {
			echo "<p>Sua inscrição foi enviada com sucesso para nosso sistema.</br> Para saber informações sobre o recebimento das cartas de recomendação pelo nosso sistema,</br> efetue login novamente e clique no link informações sobre cartas de recomendação.</br>
			O MAT-UnB agradece seu interesse pelo nosso programa de Pós-graduação.</p>";
			include_once("../funcoes/confirma_inscricao.php");
			$envia_pdf_inscricao = confirmainscricao($coduser,$arquivopdf);
		}else {
			echo "Houve algum problema no envio, favor tentar novamente.";
		}
}else{
	echo"<p align=\"center\"> Sua inscrição foi enviada com sucesso para nosso sistema! </p>";
}	
echo "<br><br><br>";
echo "
	<p align=\"center\">
	<a href=\"../logout.php\"; title=\"Logout\"><img alt=\"Logout\" src=\"../imagens/sair.png\" border=\"0\" width=\"50\" /></a>
	</p>
	";
?>

