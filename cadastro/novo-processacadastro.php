<?php 
    session_start();
?>

<html>
<meta charset="utf-8"/>
<head>
	<title>
     Processando Inscrição
 </title>

</head>
<body>
	<?php

    include_once("../config/config.php");


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
    include_once "../funcoes/inclusao_login_recomendante.php";
    include_once "../funcoes/gera_senha.php";
    include_once "../funcoes/manda_primeiro_mail_recomendante.php";
    include_once "../funcoes/validacadastro2.php";
    include_once "../funcoes/validacadastro3.php";


    $cadas2 = $_POST['cadas2'];


    $cadas3 = $_POST['cadas3'];

    $id_aluno = $_SESSION['coduser'];


    $resultadovalidacadastro2 = validacadastro2($cadas2);
    $resultadovalidacadastro3 = validacadastro3($cadas3);


    $_SESSION['repopula2'] = $cadas2;
    $_SESSION['repopula3'] = $cadas3;

  
    $_SESSION['resvalcad2'] = $resultadovalidacadastro2;
    $_SESSION['resvalcad3'] = $resultadovalidacadastro3;


    if (trim($cadas2["CursoPos"])=="Mestrado")
        {$resultadovalidacadastro2[5]=1;}

    
    $Teste21="aceita";
    foreach ($resultadovalidacadastro2 as $campo =>
        $valor){
        if (($valor == 0)|$valor ==false){
            $Teste21 = "Rejeita";}
        }

        $Teste31="aceita";
        foreach ($resultadovalidacadastro3 as $campo =>
            $valor){
            if (($valor == 0)|$valor ==false){
                $Teste31 = "Rejeita";}
            }


            if ( !($Teste21 =="Rejeita") && !($Teste31 =="Rejeita") ){

                include_once ("verificacad2existe.php");
                include_once ("verificacad3existe.php");


                if ( !(isset($cadas2["ExperienciaTipo1"])) ) { $cadas2["ExperienciaTipo1"]="0";}
                if ( !(isset($cadas2["ExperienciaTipo2"])) ) { $cadas2["ExperienciaTipo2"]="0";}
                if ( !(isset($cadas2["CursoPos"])) ) { $cadas2["CursoPos"]="0";}
                if ( !(isset($cadas2["Verao"])) ) { $cadas2["Verao"]="0";}
                if ( !(isset($cadas2["CursoVerao"])) ) { $cadas2["CursoVerao"]="0";}
                

                if  (verificacad2existe($id_aluno,$edital_atual) == "existe cadastro" || verificacad3existe($id_aluno,$edital_atual) == "existe cadastro"){
                    include_once("updatecadastro2.php");
                    include_once("updatecadastro3.php");

                    $resultadoupdatecad2 = update_cadastro_inscricao2($id_aluno,$cadas2);
                    
                    sleep(1);
                    $resultadoupdatecad3 = update_cadastro_inscricao3($id_aluno,$cadas3,$edital_atual);
                                
                    if ($resultadoupdatecad2 == "ok" && $resultadoupdatecad3 == "ok"){
                        echo "
                        <meta HTTP-EQUIV='Refresh' CONTENT='0;URL=upload_de_anexos.php'>
                        ";
                        break;
                    }

                    
                    if ($resultadoupdatecad2 == "erro banco" || $resultadoupdatecad3 == "erro banco"){
                        echo "	
                        <br>
                        <br>
                        <hr>
                        <p align=\"center\">
                        Erro EB1: Suas informações não foram recebidas. 
                        <br>
                        Por favor, tente enviar seus dados novamente mais tarde.
                        <hr>
                        </p>
                        ";
                        break;
                    }
                }else{
                    include_once("gravacadastroinscricao2.php");
                    include_once("gravacadastroinscricao3.php");


                    $resultadogravacaocad2 = grava_cadastro_inscricao2($cadas2);

                    $resultadogravacaocad3 = grava_cadastro_inscricao3($cadas3);
                     
                    if ($resultadogravacaocad2 == "ok" && $resultadogravacaocad3 == "ok"){
                        echo "
                        <meta HTTP-EQUIV='Refresh' CONTENT='0;URL=upload_de_anexos.php'>
                        ";
                        break;
                    }
                    if ($resultadogravacaocad2 == "erro banco" or $resultadoupdatecad3 == "erro banco"){
                        echo "
                        <br>
                        <br>
                        <hr>
                        <p align=\"center\">
                        Suas informações não foram recebidas. 
                        <br>
                        <span style=\"color:#FF0000; font-weight:bold\">
                        Erro de conexão com o banco de dados.
                        </span>

                        <br>
                        Por favor, tente enviar seus dados novamente mais tarde.
                        <hr>
                        </p>
                        ";
                        break;
                    }
                }
            }else{
                echo "
                <meta HTTP-EQUIV='Refresh' CONTENT='0;URL=novo-cadastroinscricao2.php'>
                ";
                break;
            }

            ?>




        </body>
        </html>
