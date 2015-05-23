<?php
 session_start();
 if( !isset($_SESSION['coduser']) ){
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
        exit;
 }

//if ( !(isset($_POST['carta_para_aluno'])) and !( isset($_SESSION['vindo_da2_para1']) )   ){
//	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=entrada_recomendante.php'>";
//	die();
//}
unset($_SESSION['vindo_da2_para1']);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Carta de Recomendação </title>
	</head>
<body>



	<h3 align="center">
		Carta de Recomendação - Página 1 de 3
	</h3>




<?php

	$dados=explode("_(",$_POST['carta_para_aluno']);

// Faz com que a variável nome_aluno esteja disponível em caso de refresh da página.
	if ( $dados[1]!=""  ){
		$nome_aluno=$dados[1];
	}else {
		$nome_aluno=$_SESSION['nome_aluno'];
	 }



	$formu1['id_prof'] =$_SESSION['coduser'];

// Faz com que as variável formu1['id_aluno'] na query abaixo esteja sempre definida.

	if ( $dados[0]!=""  ){
		$formu1['id_aluno']=$dados[0];
	}else {
		$formu1['id_aluno']=$_SESSION['id_aluno'];
	 }


// Faz com que as variável formu1['nivel']  na query abaixo esteja sempre definida.
	
	if ( $dados[2]!=""  ){	
		if (strtolower($dados[2])=="doutorado e verão"){
			$formu1['nivel']="doutorado";
			$formu1['verao']="verão";
		}elseif (strtolower($dados[2])=="mestrado e verão") {
			$formu1['nivel']="mestrado";
			$formu1['verao']="verão";
		}elseif (strtolower($dados[2])=="mestrado") {
			$formu1['nivel']="mestrado";
		}elseif (strtolower($dados[2])=="doutorado") {
			$formu1['nivel']="doutorado";
		}else{
			$formu1['verao']="verão";
		}
	}else{
		$formu1['nivel']=$_SESSION['nivel'];
	}

//	echo "prof: ".$formu1['id_prof']." aluno: ".$formu1['id_aluno']." prog.: ".$formu1['nivel'];

// Guarda as quatro principais variáveis na sessao.

	$_SESSION['id_prof'] = $formu1['id_prof'];
	$_SESSION['id_aluno'] = $formu1['id_aluno'];
	$_SESSION['nivel'] = $formu1['nivel'];
	$_SESSION['nome_aluno'] = $nome_aluno;
	
	
	include_once "../pgsql/pgsql.php";
	include_once("../config/config.php");

	$edital=$edital_atual;
	

	?>


	


	<?php
		$marcarvermelho="color:#FF0000; font-weight:bold"; 
		$marcarnormal="color:black; font-weight:normal";
		//font-weight:bold
		// Pega o vetor de validação.

		if ( isset($_SESSION['validaform1']) ){
			$validaform1 = $_SESSION['validaform1'];
		}else{
			unset($validaform1) ;
		 }


		// Recupera os dados para repopulação do formulário.
		$verifica_gravacao_carta1=pg_query("select * from inscricao_pos_recomendacoes 
				where id_prof='".$formu1['id_prof']."' and id_aluno='".$_SESSION['id_aluno']."' and edital='".$edital."'");
		$gravacao_carta1 = pg_num_rows($verifica_gravacao_carta1);

		if ($gravacao_carta1 == 1 ){
			 $query_pesca_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$formu1['id_aluno']."' and id_prof='".$formu1['id_prof']."' and edital='".$edital."' ");
			 $repopc1 = pg_fetch_array($query_pesca_formu1);
		}else{	
			
					$verifica_gravacao_carta_velha=pg_query("select * from inscricao_pos_recomendacoes 
						where id_prof='".$formu1['id_prof']."' and id_aluno='".$_SESSION['id_aluno']."' and edital='".$edital_anterior."'");
					$gravacao_carta_velha = pg_num_rows($verifica_gravacao_carta_velha);
			
					if ($gravacao_carta_velha == 1){
					
						$query_pesca_formu_velho = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$formu1['id_aluno']."' and id_prof='".$formu1['id_prof']."' and edital='".$edital_anterior."' ");
						$repopc1 = pg_fetch_array($query_pesca_formu_velho);
					}else{
			
			
							if(isset( $_SESSION['validaform1'])){
										echo '<h2 align="center"> <span style="color:#FF0000">
										Atenção !Alguns campos obrigatórios não foram preenchido ou 
										<br>
										caracteres inválido como $,%,!# e etc... foram usados. 
										<br> Todos os campos que precisam ser corrigidos ou preenchidos estão destacados em vermelho.
										</span>
										</h2>';

										$repopc1 = $_SESSION['repopc1'];
							}else{
									$pega_repopc1 = pg_query("select nivel,tempoconhececandidato,circunstancia1,circunstancia2,circunstancia3,
                                                circunstancia4,circunstanciaoutra,desempenhoacademico,capacidadeaprender,
                                                capacidadetrabalhar,criatividade,curiosidade,esforco,expressaoescrita,
                                                expressaooral,relacionamento from inscricao_pos_recomendacoes where id_prof='".$formu1['id_prof']."' and id_aluno='".$formu1['id_aluno']."' and nivel='".$formu1['nivel']."'");
									$repopc1 = pg_fetch_assoc($pega_repopc1);
							}
					}
		}

	?>




	<form method="POST" action ="processacarta.php">
	<p> <span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if($validaform1['nivel']==0) {echo $marcarvermelho;} ?>">
		Candidato a que programa (Applicant to which level) ?
		</span>
	<br>
	
	<input type="checkbox" name="formu1[nivel]" <?php if ( $formu1["nivel"] == "mestrado"){echo"checked";}  ?> value="mestrado" disabled='disabled' > Mestrado (Master's)
	<input type="checkbox" name="formu1[nivel]" <?php if ( $formu1["nivel"] == "doutorado"){echo"checked";}  ?> value="doutorado" disabled='disabled'> Doutorado (PhD)
	<input type="checkbox" name="formu1[verao]" <?php if ( $formu1["verao"] == "verão"){echo"checked";}  ?> value="verao" disabled='disabled'> Verão (Summer Course)
	</p>


	<p>
	Nome do candidato (Applicant’s name):
	<br>
	<input type="text" size="35" maxlength="256" name="nome" readonly value="<? echo $nome_aluno;?>">
	</p>

	<p>
	<span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['tempoconhececandidato']==0){echo $marcarvermelho;}?>">
	Conhece-o há quanto tempo (For how long have you known the applicant)?
	</span>
	<br>
	<input type="text" size="35" maxlength="50" name="formu1[tempoconhececandidato]" value="<?php echo trim($repopc1["tempoconhececandidato"])?>" size="50" maxlength="90">
    <br>
	</p>


	<p>
	<span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['circunstancia']==0){echo $marcarvermelho;}?>">
	Conhece-o sob que circunstâncias (Under which circumstances have you known the applicant)?
	</span>
	<br>
	<input type="checkbox" name="formu1[circunstancia1]" <?php if ( $repopc1["circunstancia1"] == "aulas"){echo"checked";}?> value="aulas" > Aulas &nbsp &nbsp
	<input type="checkbox" name="formu1[circunstancia2]" <?php if ( $repopc1["circunstancia2"] == "orientacao"){echo"checked";}?> value="orientacao" > Orientação &nbsp &nbsp
	<input type="checkbox" name="formu1[circunstancia3]" <?php if ( $repopc1["circunstancia3"] == "seminarios"){echo"checked";}?> value="seminarios" > Seminários &nbsp &nbsp
	<input type="checkbox" name="formu1[circunstancia4]" <?php if ( $repopc1["circunstancia4"] == "outra"){echo"checked";}?> value="outra" > 
	Outra. Qual (Other.Which)? 
	<input type="text" size="35" maxlength="256" value="<?php echo trim($repopc1["circunstanciaoutra"])?>" name="formu1[circunstanciaoutra]">
	</p>
	<br>





	<p>
	Procure avaliá-lo sob os itens abaixo (Try to evaluate the applicant under the items below):
	
	<!-- Row Highlight Javascript -->
<script type="text/javascript">
	window.onload=function(){
	var tfrow = document.getElementById('tfhover').rows.length;
	var tbRow=[];
	for (var i=1;i<tfrow;i++) {
		tbRow[i]=document.getElementById('tfhover').rows[i];
		tbRow[i].onmouseover = function(){
		  this.style.backgroundColor = '#ffffff';
		};
		tbRow[i].onmouseout = function() {
		  this.style.backgroundColor = '#d4e3e5';
		};
	}
};
</script>

<style type="text/css">
table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:center;}
table.tftable tr {background-color:#d4e3e5;}
table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
</style>

<table id="tfhover" class="tftable" border="1">
<tr><th></th><th>Excelente (Excellent)</th><th>Bom (Good)</th><th>Regular (Regular)</th><th>Insuficiente (Insufficient)</th><th>Não sabe (Don’t know)</th></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['desempenhoacademico']==0){echo $marcarvermelho;}?>">
Desempenho acadêmico (Academic achievements)</span></td><td align="center"><input type="radio" name="formu1[desempenhoacademico]" <?php if ( $repopc1["desempenhoacademico"] == "1"){echo"checked";}?> value="1" ></td><td align="center"><input type="radio" name="formu1[desempenhoacademico]" <?php if ( $repopc1["desempenhoacademico"] == "2"){echo"checked";}?> value="2" ></td><td align="center"><input type="radio" name="formu1[desempenhoacademico]" <?php if ( $repopc1["desempenhoacademico"] == "3"){echo"checked";}?> value="3" ></td><td align="center"><input type="radio" name="formu1[desempenhoacademico]" <?php if ( $repopc1["desempenhoacademico"] == "4"){echo"checked";}?> value="4" ></td><td align="center"><input type="radio" name="formu1[desempenhoacademico]" <?php if ( $repopc1["desempenhoacademico"] == "naoinfo"){echo"checked";}?> value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['capacidadeaprender']==0){echo $marcarvermelho;}?>">
Capacidade de aprender novos conceitos (Ability to learn new concepts)</span></td><td align="center"><input type="radio" name="formu1[capacidadeaprender]" <?php if ( $repopc1["capacidadeaprender"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[capacidadeaprender]" <?php if ( $repopc1["capacidadeaprender"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[capacidadeaprender]" <?php if ( $repopc1["capacidadeaprender"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[capacidadeaprender]" <?php if ( $repopc1["capacidadeaprender"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[capacidadeaprender]" <?php if ( $repopc1["capacidadeaprender"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['capacidadetrabalhar']==0){echo $marcarvermelho;}?>">
Capacidade de trabalhar sozinho (Ability to work independently)</td></span></td><td align="center"><input type="radio" name="formu1[capacidadetrabalhar]" <?php if ( $repopc1["capacidadetrabalhar"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[capacidadetrabalhar]" <?php if ( $repopc1["capacidadetrabalhar"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[capacidadetrabalhar]" <?php if ( $repopc1["capacidadetrabalhar"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[capacidadetrabalhar]" <?php if ( $repopc1["capacidadetrabalhar"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[capacidadetrabalhar]" <?php if ( $repopc1["capacidadetrabalhar"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['criatividade']==0){echo $marcarvermelho;}?>">
Criatividade (Creativity)</span></td><td align="center"><input type="radio" name="formu1[criatividade]" <?php if ( $repopc1["criatividade"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[criatividade]" <?php if ( $repopc1["criatividade"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[criatividade]" <?php if ( $repopc1["criatividade"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[criatividade]" <?php if ( $repopc1["criatividade"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[criatividade]" <?php if ( $repopc1["criatividade"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['curiosidade']==0){echo $marcarvermelho;}?>">
Curiosidade, interesse (Curiosity, interest)</span></td><td align="center"><input type="radio" name="formu1[curiosidade]" <?php if ( $repopc1["curiosidade"] == "1"){echo"checked";}?>   value="1" ></td><td align="center"><input type="radio" name="formu1[curiosidade]" <?php if ( $repopc1["curiosidade"] == "2"){echo"checked";}?>   value="2" ></td><td align="center"><input type="radio" name="formu1[curiosidade]" <?php if ( $repopc1["curiosidade"] == "3"){echo"checked";}?>   value="3" ></td><td align="center"><input type="radio" name="formu1[curiosidade]" <?php if ( $repopc1["curiosidade"] == "4"){echo"checked";}?>   value="4" ></td><td align="center"><input type="radio" name="formu1[curiosidade]" <?php if ( $repopc1["curiosidade"] == "naoinfo"){echo"checked";}?> value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['esforco']==0){echo $marcarvermelho;}?>">
Esforço, persistência (Effort, persistence)</span></td><td align="center"><input type="radio" name="formu1[esforco]" <?php if ( $repopc1["esforco"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[esforco]" <?php if ( $repopc1["esforco"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[esforco]" <?php if ( $repopc1["esforco"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[esforco]" <?php if ( $repopc1["esforco"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[esforco]" <?php if ( $repopc1["esforco"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['expressaoescrita']==0){echo $marcarvermelho;}?>">
Expressão escrita (Written expression)</span>	</td><td align="center"><input type="radio" name="formu1[expressaoescrita]" <?php if ( $repopc1["expressaoescrita"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[expressaoescrita]" <?php if ( $repopc1["expressaoescrita"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[expressaoescrita]" <?php if ( $repopc1["expressaoescrita"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[expressaoescrita]" <?php if ( $repopc1["expressaoescrita"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[expressaoescrita]" <?php if ( $repopc1["expressaoescrita"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['expressaooral']==0){echo $marcarvermelho;}?>">
Expressão oral (Oral expression)</span>	</td><td align="center"><input type="radio" name="formu1[expressaooral]" <?php if ( $repopc1["expressaooral"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[expressaooral]" <?php if ( $repopc1["expressaooral"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[expressaooral]" <?php if ( $repopc1["expressaooral"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[expressaooral]" <?php if ( $repopc1["expressaooral"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[expressaooral]" <?php if ( $repopc1["expressaooral"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform1))  echo $marcarnormal; else if ($validaform1['relacionamento']==0){echo $marcarvermelho;}?>">
Relacionamento com colegas (Relationship with colleagues)</span></td><td align="center"><input type="radio" name="formu1[relacionamento]" <?php if ( $repopc1["relacionamento"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu1[relacionamento]" <?php if ( $repopc1["relacionamento"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu1[relacionamento]" <?php if ( $repopc1["relacionamento"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu1[relacionamento]" <?php if ( $repopc1["relacionamento"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu1[relacionamento]" <?php if ( $repopc1["relacionamento"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
</table>


	<p align="center">
	<input type="hidden" name="OndeEstou" value="pag1">
	<input type="hidden" name="formu1[id_aluno]" value="<?php echo $formu1['id_aluno'];?>">
	<input type="hidden" name="formu1[id_prof]" value="<?php echo $formu1['id_prof'];?>">
	<input type="hidden" name="formu1[nivel]" value="<?php echo $formu1['nivel'];?>">
	<input type="submit" name="rota" value="Salvar e Prosseguir">
	<input type="submit" name="rota" value="Página Inicial">


	</p>

	</form>


	</body>


</html>

