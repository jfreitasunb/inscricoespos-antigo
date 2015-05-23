<?php 
session_start();
 if( !isset($_SESSION['coduser']) ){
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
        exit;
 }
include_once("../config/config.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Carta de Recomendação: seleção de candidatos </title>
	</head>
	
	<body style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
        <h2 align="center">
                Processo Seletivo da Pós-Graduação <br>
                MAT-UnB <?php echo $ano_config;?>
        </h2>


<?php
$IrPara=$_POST["rota"];
$OndeEstava=$_POST["OndeEstou"];


include_once "../funcoes/converteminuscula.php";
include_once "../funcoes/validaemail.php";
include_once "../funcoes/validanome.php";
include_once "../funcoes/validanumero.php";
include_once "../funcoes/validaradio.php";
include_once "../funcoes/validaselect.php";
include_once "../funcoes/validatexto.php";
include_once "../funcoes/validaemailalt.php";
include_once "../funcoes/validanomealt.php";
include_once "../funcoes/validaidentidade.php";
include_once "../funcoes/validainfrelevante.php";
include_once "salvaformu1.php";
include_once "salvaformu2.php";
include_once "salvaformu3.php";



$edital=$edital_atual;



switch ($IrPara)
{

case "Página Inicial":
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=entrada_recomendante.php'>";
break;


case "Salvar e Voltar à Página Anterior":
	if ($OndeEstava == "pag3"){
		$formu3=$_POST['formu3'];
		salvaformu3($formu3,"nao");
		unset($_SESSION['repopc2']);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario2.php'>";
	}else{  
		$formu2=$_POST['formu2'];
		salvaformu2($formu2,$edital);
		unset($_SESSION['validaform1']);
		$_SESSION['vindo_da2_para1'] ='1';
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario1.php'>";
	}
break;

case "Salvar e Prosseguir":
	if ($OndeEstava == "pag1"){
			
			include "validaformu1.php";
//			include "salvaformu1.php";
			
			$formu1=$_POST['formu1'];
			$result_validacao = validaform1($formu1);

			$_SESSION['validaform1'] = validaform1($formu1);
			$_SESSION['repopc1'] = $formu1;
			
			
			$validacao = 1;
			// Verifica se o formulário 1 foi completamente validado.
			foreach ($result_validacao as $campo => $valor){
					if ($valor == 0){ 
					//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario1.php'>";
					$validacao = 0;
					}
			}
			

			if ($validacao == 0){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario1.php'>";
			}else{
					salvaformu1($formu1,$edital);
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario2.php'>";
			 }
			// Vai inserir ou fazer update dos dados recebidos do formulario 1.
			
		
	
	}else{ 
			include "validaformu2.php";
//			include "salvaformu2.php";
			
			$formu2=$_POST['formu2'];
			$result_validacao = validaform2($formu2);

			$_SESSION['validaform2'] = validaform2($formu2);
			$_SESSION['repopc2'] = $formu2;
			
			$validacao = 1;
			// Verifica se o formulário 1 foi completamente validado.
			foreach ($result_validacao as $campo => $valor){
					if ($valor == 0){ 
					$validacao = 0;
					}
			}
			
			if ($validacao == 0){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario2.php'>";
			}else{
					salvaformu2($formu2,$edital);
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario3.php'>";
			 }
	 }
break;



case"Enviar Carta":
			include "validaformu3.php";
//			include "salvaformu3.php";
			
			$formu3=$_POST['formu3'];
			$result_validacao = validaform3($formu3);

			$_SESSION['validaform3'] = validaform3($formu3);
			$_SESSION['repopc3'] = $formu3;
			
			$validacao = 1;
			// Verifica se o formulário 1 foi completamente validado.
			foreach ($result_validacao as $campo => $valor){
					if ($valor == 0){ 
					$validacao = 0;
					}
			}
				
			if ($validacao == 0){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=formulario3.php'>";
			}else{
					salvaformu3($formu3,"sim",$edital);
					echo "Carta enviada para nossos servidores com sucesso !<br>
						Dentro de alguns segundos o sr.(a) será redirecionado para a tela inicial.";
					unset($_SESSION['id_aluno']);
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=entrada_recomendante.php'>";
			 }
break;
}
?>
</body>
</html>
