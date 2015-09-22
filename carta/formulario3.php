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
		<script type="text/javascript" src="../js/remove_caracteres.js"></script>
	<title> Carta de Recomendação </title>
	</head>
<body> 

	<?php  
	include_once "../pgsql/pgsql.php";
	include_once "../config/config.php";
	
	$formu3['id_prof'] = $_SESSION['id_prof'];
	$formu3['id_aluno'] = $_SESSION['id_aluno'];
	$formu3['nivel'] = $_SESSION['nivel'];
	?>
	
	<?php 
		$marcarvermelho="color:#FF0000; font-weight:bold"; 
		$marcarnormal="color:black; font-weight:normal";
		//font-weight:bold
		// Pega o vetor de validação.
		
		if ( isset($_SESSION['validaform3']) ){
			$validaform3 = $_SESSION['validaform3'];
		}else{
			unset($validaform3) ;
		 }
		
		// Recupera os dados para repopulação do formulário.
		
		if( isset( $_SESSION['repopc3'])  ){
				$repopc3 = $_SESSION['repopc3'];
				$validacao = 1 ;
				foreach ($_SESSION['validaform3'] as $campo => $valor){
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
						
		}else {
						$pega_repopc3 = pg_query("select nomerecomendante,instituicaorecomendante,titulacaorecomendante,
										 arearecomendante,anoobtencaorecomendante,instobtencaorecomendante,
										 enderecorecomendante from inscricao_pos_dados_pessoais_recomendante 
										 where id_prof='".$formu3['id_prof']."'");
						$repopc3 = pg_fetch_assoc($pega_repopc3);
				 }
		 
		
	?>

	
	
	
	<h3 align="center">
		Carta de Recomendação - Página 3 de 3
	</h3>
	
	<form method="POST" action ="processacarta.php">
	
	<p> 
		<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['nomerecomendante']==0){echo $marcarvermelho;}?>">
		Nome do recomendante (Recommender’s name):
		</span>
	<br> 
	<input type="text" size="50" maxlength="256" value="<?php echo trim($repopc3["nomerecomendante"])?>" name="formu3[nomerecomendante]" ">
	</p>
	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['instituicaorecomendante']==0){echo $marcarvermelho;}?>">
	Instituição (Institution):
	</span>
	<br> 
	<input type="text" size="70" maxlength="256" value="<?php echo trim($repopc3["instituicaorecomendante"])?>" name="formu3[instituicaorecomendante]" ">
	</p>
	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['titulacaorecomendante']==0){echo $marcarvermelho;}?>">
	Grau acadêmico mais alto obtido (Highest academic degree obtained):
	</span>
	<br> 
	<select name="formu3[titulacaorecomendante]" size="1">
	<option <?php if ( $repopc3["titulacaorecomendante"] == "nselecionado"){echo "selected";}?> value="nselecionado"> Selecione uma opção:</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "doutor"){echo"selected";}?> value="doutor"> Doutor</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "mestre"){echo"selected";}?> value="mestre"> Mestre</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "especialista"){echo"selected";}?> value="especialista"> Especialista</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "bacharel"){echo"selected";}?> value="bacharel"> Bacharel</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "licenciado"){echo"selected";}?> value="licenciado"> Licenciado</option>
	<option <?php if ( $repopc3["titulacaorecomendante"] == "outro"){echo"selected";}?> value="outro"> Outro</option>
	</select>
	</p>
	
	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['arearecomendante']==0){echo $marcarvermelho;}?>">
	Em que área (In which area):
	</span>
	<br>
	<input type="text" size="70" maxlength="256" value="<?php echo trim($repopc3["arearecomendante"])?>" name="formu3[arearecomendante]" ">
	</p>
	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['anoobtencaorecomendante']==0){echo $marcarvermelho;}?>">
	Ano de obtenção deste grau (Year when it was obtained):
	</span>
	<select     
			name="formu3[anoobtencaorecomendante]" size="1">
			<?php
			$ano_titulacao;
			echo '<option  value="nselecionado"> ------</option>';
			do
			{
			echo '<option value='.$ano_titulacao; if ($repopc3['anoobtencaorecomendante']== $ano_titulacao ){echo" selected";} echo">".$ano_titulacao."</option>";
			$ano_titulacao--;
			} while ($ano_titulacao>1920);
			?>
		</select>
	</p>
	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['instobtencaorecomendante']==0){echo $marcarvermelho;}?>">
	Instituição de obtenção deste grau (Institution where it was obtained):
	</span>
	<br>
	<input type="text" size="70" maxlength="256" value="<?php echo trim($repopc3["instobtencaorecomendante"])?>" name="formu3[instobtencaorecomendante]" ">
	</p>

	
	<p>
	<span style="<?php if (!isset($validaform3))  echo $marcarnormal; else if ($validaform3['enderecorecomendante']==0){echo $marcarvermelho;}?>">
	Endereço institucional do recomendante (Recommender’s institutional address):
	</span>
	<br> 
	<textarea style="background:white" name="formu3[enderecorecomendante]" rows="3" cols="70" " ><?php echo trim($repopc3["enderecorecomendante"])?></textarea>
	</p>

<p align="center">
	<input type="hidden" name="OndeEstou" value="pag3">
	<input type="hidden" name="formu3[id_aluno]" value="<?php echo $formu3['id_aluno'];?>">
	<input type="hidden" name="formu3[id_prof]" value="<?php echo $formu3['id_prof'];?>">
	<input type="hidden" name="formu3[nivel]" value="<?php echo $formu3['nivel'];?>">
	<input type="submit" name="rota" value="Enviar Carta">
	<input type="submit" name="rota" value="Salvar e Voltar à Página Anterior">
	</p>

</form>


</body>
</html>
