<?php 
	session_start();
 if( !isset($_SESSION['coduser']) ){
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../index.php'>";
        exit;
 }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="../js/LiveValidation.js"></script>
	<title> Carta de Recomendação </title>
	</head>
<body> 

	<?php  
	
	
	
	include_once "../pgsql/pgsql.php";
	include_once("../config/config.php");
	$edital=$edital_atual;
	
	$formu2['id_prof'] = $_SESSION['id_prof'];
	$formu2['id_aluno'] = $_SESSION['id_aluno'];
	$formu2['nivel'] = $_SESSION['nivel'];
		
	?>
	
	
	
	<h3 align="center">
		Carta de Recomendação - Página 2 de 3
	</h3>
	
	<?php 
		$marcarvermelho="color:#FF0000; font-weight:bold"; 
		$marcarnormal="color:black; font-weight:normal";
		//font-weight:bold
		// Pega o vetor de validação.
		
		if ( isset($_SESSION['validaform2']) ){
			$validaform2 = $_SESSION['validaform2'];
		}else{
			unset($validaform2) ;
		 }
		
		// Recupera os dados para repopulação do formulário.
		
		if( isset( $_SESSION['repopc2'])  ){
				$repopc2 = $_SESSION['repopc2'];
				$validacao = 1 ;
				foreach ($_SESSION['validaform2'] as $campo => $valor){
					if ($valor == 0){ 
					$validacao = 0;
					}
				}
				if ($validacao == 0){
								echo '<h2 align="center"> <span style="color:#FF0000">
									Atenção !Alguns campos obrigatórios não foram preenchido ou 
									<br>
									caracteres inválido como ;,$,%,!,# e etc... foram usados. 
									<br> Todos os campos que precisam ser corrigidos ou preenchidos estão destacados em vermelho.
									</span>
									</h2>';
				}
						
		}else{
						
			$pega_repopc2 = pg_query("select antecedentesacademicos,possivelaproveitamento,informacoesrelevantes,
										 comoaluno,comoorientando from inscricao_pos_recomendacoes 
										 where id_prof='".$formu2['id_prof']."' and 
										 id_aluno='".$formu2['id_aluno']."' and 
										 edital='$edital'");
			$num_pega_repopc2 = pg_num_rows($pega_repopc2);
			
			if ($num_pega_repopc2 == 1){
				$repopc2 = pg_fetch_assoc($pega_repopc2);
			
			}else{	
			
					$verifica_gravacao_carta_velha_2=pg_query("select * from inscricao_pos_recomendacoes 
						where id_prof='".$formu1['id_prof']."' and id_aluno='".$_SESSION['id_aluno']."' and edital='".$edital_anterior."'");
					$gravacao_carta_velha2 = pg_num_rows($verifica_gravacao_carta_velha2);
			
					if ($gravacao_carta_velha2 == 1){
					
						$query_pesca_formu_velho2 = pg_query("select antecedentesacademicos,possivelaproveitamento,informacoesrelevantes,
										 comoaluno,comoorientando 						
						from inscricao_pos_recomendacoes where id_aluno='".$formu2['id_aluno']."' and id_prof='".$formu2['id_prof']."' and edital='".$edital_anterior."' ");
						$repopc2 = pg_fetch_array($query_pesca_formu_velho2);
					}			
			}	
						
						
				 
		}
		 
		
	?>

	
	
	
	
	<form method="POST" action ="processacarta.php">
	
	<p> <span style="<?php if (!isset($validaform2))  echo $marcarnormal; else if ($validaform2['antecedentesacademicos']==0){echo $marcarvermelho;}?>">
		Dê-nos sua opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato <br>
		(Please give us your opinion about his/her academic, professional and/or technical background):
		</span>
	<br> 
	<textarea style="background:#EEE9E9" id = "antecedentesacademicos" name="formu2[antecedentesacademicos]" rows="7" cols="73" ><?php echo trim($repopc2["antecedentesacademicos"])?></textarea>
	</p>

	<script type="text/javascript">
		var antecedentesacademicos = new LiveValidation('antecedentesacademicos');
		antecedentesacademicos.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
		antecedentesacademicos.add( Validate.Exclusion, { within: [ '[' , ']', '(', ')', ';', '\\', '/', '-', '_', '!', '%', '#', '&', '*', '?', '{', '}' ], partialMatch: true } );
	</script>
	
	<p> <span style="<?php if (!isset($validaform2))  echo $marcarnormal; else if ($validaform2['possivelaproveitamento']==0){echo $marcarvermelho;}?>">
		Dê-nos sua opinião sobre o possível desempenho do candidato, se aceito no programa <br>
		(Please give us your opinion about his/her potential performance, if accepted into the Program):
		</span>
	<br> 
	<textarea style="background:#EEE9E9" id = "possivelaproveitamento" name="formu2[possivelaproveitamento]" rows="7" cols="73" ><?php echo trim($repopc2["possivelaproveitamento"])?></textarea>
	</p>

	<script type="text/javascript">
		var possivelaproveitamento = new LiveValidation('possivelaproveitamento');
		possivelaproveitamento.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
		possivelaproveitamento.add( Validate.Exclusion, { within: [ '[' , ']', '(', ')', ';', '\\', '/', '-', '_', '!', '%', '#', '&', '*', '?', '{', '}' ], partialMatch: true } );
	</script>
	
	<p>
		Outras informações relevantes (Other information you may consider relevant):
	<br>
	<textarea style="background:#EEE9E9" id = "informacoesrelevantes" name="formu2[informacoesrelevantes]" rows="7" cols="73" ><?php echo trim($repopc2["informacoesrelevantes"])?></textarea>
	</p>
	
	<script type="text/javascript">
		var informacoesrelevantes = new LiveValidation('informacoesrelevantes');
		informacoesrelevantes.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
		informacoesrelevantes.add( Validate.Exclusion, { within: [ '[' , ']', '(', ')', ';', '\\', '/', '-', '_', '!', '%', '#', '&', '*', '?', '{', '}' ], partialMatch: true } );
	</script>
	
	
	
	
	<p>
	Entre os estudantes que já conheceu, de que maneira você classificaria o candidato?
	<br>
	(Among all students you’ve already met, under the items below, you’d say that he/she is in the):

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
<tr><th></th><th>5% melhores (Top 5%)</th><th>10% melhores (Top 10%)</th><th>25% melhores(Top 25%)</th><th>50% melhores (Top 50%)</th><th>Não sabe (Don’t know)</th></tr>
<tr><td><span style="<?php if (!isset($validaform2))  echo $marcarnormal; else if ($validaform2['comoaluno']==0){echo $marcarvermelho;}?>">
Como aluno, em aulas (As student, in classes)</span></td><td align="center"><input type="radio" name="formu2[comoaluno]" <?php if ( $repopc2["comoaluno"] == "1"){echo"checked";}?> value="1" ></td><td align="center"><input type="radio" name="formu2[comoaluno]" <?php if ( $repopc2["comoaluno"] == "2"){echo"checked";}?> value="2" ></td><td align="center"><input type="radio" name="formu2[comoaluno]" <?php if ( $repopc2["comoaluno"] == "3"){echo"checked";}?> value="3" ></td><td align="center"><input type="radio" name="formu2[comoaluno]" <?php if ( $repopc2["comoaluno"] == "4"){echo"checked";}?> value="4" ></td><td align="center"><input type="radio" name="formu2[comoaluno]" <?php if ( $repopc2["comoaluno"] == "naoinfo"){echo"checked";}?> value="naoinfo" ></td></tr>
<tr><td><span style="<?php if (!isset($validaform2))  echo $marcarnormal; else if ($validaform2['comoorientando']==0){echo $marcarvermelho;}?>">
Como orientando (During advisory)</span></td><td align="center"><input type="radio" name="formu2[comoorientando]" <?php if ( $repopc2["comoorientando"] == "1"){echo"checked";}?>  value="1" ></td><td align="center"><input type="radio" name="formu2[comoorientando]" <?php if ( $repopc2["comoorientando"] == "2"){echo"checked";}?>  value="2" ></td><td align="center"><input type="radio" name="formu2[comoorientando]" <?php if ( $repopc2["comoorientando"] == "3"){echo"checked";}?>  value="3" ></td><td align="center"><input type="radio" name="formu2[comoorientando]" <?php if ( $repopc2["comoorientando"] == "4"){echo"checked";}?>  value="4" ></td><td align="center"><input type="radio" name="formu2[comoorientando]" <?php if ( $repopc2["comoorientando"] == "naoinfo"){echo"checked";}?>  value="naoinfo" ></td></tr>
</table>
	
	
	
	<p align="center">
	<input type="hidden" name="OndeEstou" value="pag2">
	<input type="hidden" name="formu2[id_aluno]" value="<?php echo $formu2['id_aluno'];?>">
	<input type="hidden" name="formu2[id_prof]" value="<?php echo $formu2['id_prof'];?>">
	<input type="hidden" name="formu2[nivel]" value="<?php echo $formu2['nivel'];?>">
	<input type="submit" name="rota" value="Salvar e Prosseguir">
	<input type="submit" name="rota" value="Salvar e Voltar à Página Anterior">
	</p>
	
	</form>
	
	
	</body>


</html>
