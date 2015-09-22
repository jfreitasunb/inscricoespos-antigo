<?php
session_start();
include_once("../config/config.php");
?>


	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">

			<link rel="stylesheet" type="text/css" href="http://www.mat.unb.br/inscricoespos/css/common-stylesheet.css" />
		</head>

		<script type="text/javascript" src="../js/LiveValidation.js"></script>
		<script type="text/javascript" src="../js/remove_caracteres.js"></script>

		<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
			<h2 align="center">
				Cadastro para Processo Seletivo <?php echo $curso_config;?> / Pós-Graduação <br>
				MAT-UnB <?php echo $ano_config;?>
			</h2>

			<hr>
			

			<form method="POST" action="novo-proccadasentrada.php" 
			onsubmit="return window.confirm(&quot;Confirma o envio deste formulário.\n para o MAT-UnB?&quot;);">

			<?php 	
				
				if ( !(isset( $_SESSION['resvalcad1']))){ 
					for ($i=0; $i<37; $i++ ){ $resultadovalidacadastro1[$i]=1;} 
				}	else{
						$resultadovalidacadastro1 = $_SESSION['resvalcad1'];
					}
					
				if ( !(isset ($_SESSION['repopula'])) ){
					$repop =NULL; 
				} 	else{
						$repop = $_SESSION['repopula'];
					}

		 ?>
		
		<?php  if(isset( $_SESSION['resvalcad1'])){
					echo '<h2 align="center"> <span style="color:#FF0000">
					Atenção !Alguns campos obrigatórios não foram preenchido ou 
					<br>
					caracteres inválido como $,%,!# e etc... foram usados. 
					<br> Todos os campos que precisam ser corrigidos ou preenchidos estão destacados em vermelho.
					</span>
					</h2>';
				}  ?>



			<h2> Dados Pessoais.</h2>
			<p>

				<!-- O código abaixo estiliza o nome do campo  --> 
				<span style=" 
				<?php 
					if ($resultadovalidacadastro1[0] == 1){
						echo"";
					}else{
						echo "color:#FF0000; font-weight:bold";}
						?>
						">
						Nome: 
					</span> 


					<!-- O código abaixo estiliza a caixa de entrada de texto  --> 
					<input 
					style="<?php 
						if ($resultadovalidacadastro1[0] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"   
						type="text" id="nome" name="cadas1[name]" value="<?php echo $repop[0];?>" maxlength="60">
						&nbsp; &nbsp; &nbsp;

						<script type="text/javascript">
						var nome = new LiveValidation('nome');
						nome.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
						</script>





						<span style=" 
						<?php 
							if ($resultadovalidacadastro1[1] == 1){
								echo"";
							}else{
								echo "color:#FF0000; font-weight:bold";}
								?> ">
								Sobrenome : 
							</span>

							<input style="<?php 
								if ($resultadovalidacadastro1[1] == 1){
									echo'';
								}else{
									echo 'border:2px solid #FF0000';
								} ?>"  
								type="text" id="sobrenome" name="cadas1[firstname]" value="<?php echo $repop[1];?>" size="30" maxlength="60">
							</p>


							<script type="text/javascript">
							var sobrenome = new LiveValidation('sobrenome');
							sobrenome.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
							</script>

							<p> 

								<span> Data de Nascimento: </span>&nbsp &nbsp 

								Dia : 
								<select style="<?php 
									if ($resultadovalidacadastro1[2] == 1){
										echo'';
									}else{
										echo 'border:2px solid #FF0000'; 
								}
								?>"  
								name="cadas1[DiaNascimento]"  >
								<?php

								$dia=1;
								echo '<option  value="nselecionado"> --- </option>';
								do
								{
									echo '<option value='.$dia; if ($repop[2]== $dia ){echo" selected";} echo">".$dia."</option>";
									$dia++;
								} while ($dia<32);
								?>
							</select>

							Mês
							<select style="<?php
								if ($resultadovalidacadastro1[3] == 1){
									echo'';
								}else{
									echo 'border:2px solid #FF0000';
							} ?>" 
							name="cadas1[MesNascimento]" > 
							<?php
							$mes=01;
							echo '<option  value="nselecionado"> --- </option>';
							do
							{
								echo '<option value='.$mes; if ($repop[3]== $mes ){echo" selected";} echo">".$mes."</option>";
								$mes++;
							} while ($mes<13);
							?>
						</select>

						Ano
						<select style="<?php
						if ($resultadovalidacadastro1[4] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"   
						name="cadas1[AnoNascimento]" size="1">
						<?php
						$ano=1999;
						echo '<option  value="nselecionado"> ------</option>';
						do
						{
							echo '<option value='.$ano; if ($repop[4]== $ano ){echo" selected";} echo">".$ano."</option>";
							$ano--;
						} while ($ano>1946);
						?>
					</select>
					&nbsp &nbsp 


					<span style=" 
					<?php 
					if ($resultadovalidacadastro1[5] == 1){
						echo"";
					}else{
						echo "color:#FF0000; font-weight:bold";}
						?> ">
						Sexo: 
					</span> 


					<select style="<?php 
					if ($resultadovalidacadastro1[5] == 1){
						echo'';
					}else{
						echo 'border:2px solid #FF0000';
					} ?>" 
					name="cadas1[sexo]">
					<OPTION value="nselecionado"> ------------- </OPTION>
					<OPTION value="Masculino" <?php if($repop[5]=="Masculino"){echo"selected";}?> >Masculino </OPTION>
					<OPTION value="Feminino" <?php if($repop[5]=="Feminino"){echo"selected";}?> >Feminino </OPTION>
				</select>
				<br>
				<br>


				<span style=" 
				<?php 
				if ($resultadovalidacadastro1[6] == 1){
					echo"";
				}else{
					echo "color:#FF0000; font-weight:bold";}
					?> ">
					Naturalidade: 
				</span>


				<input style="<?php 
				if ($resultadovalidacadastro1[6] == 1){
					echo'';
				}else{
					echo 'border:2px solid #FF0000';
				} ?>" 
				type=text id="naturalidade" name="cadas1[naturalidade]" value="<?php echo $repop[6];?>" maxlength=25>  
				&nbsp &nbsp &nbsp

				<script type="text/javascript">
				var naturalidade = new LiveValidation('naturalidade');
				naturalidade.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
				</script>

				<span style=" 
				<?php if ($resultadovalidacadastro1[7] == 1){
					echo"";
				}else{
					echo "color:#FF0000; font-weight:bold";}
					?> ">
					Estado: 
				</span>
				&nbsp <select 
				style="<?php 
				if ($resultadovalidacadastro1[7] == 1){
					echo'';
				}else{
					echo 'border:2px solid #FF0000';
				} ?>"

				style=" text-align:center" name="cadas1[UFNaturalidade]">
				<option value="nselecionado" > ------ </option>
				<option value="UF_AC" <?php if ($repop[7]== "UF_AC" ){echo"selected";}?>  > AC </option>
				<option value="UF_AL" <?php if ($repop[7]== "UF_AL" ){echo"selected";}?> > AL </option>
				<option value="UF_AP" <?php if ($repop[7]== "UF_AP" ){echo"selected";}?> > AP </option>
				<option value="UF_AM" <?php if ($repop[7]== "UF_AM" ){echo"selected";}?> > AM </option>
				<option value="UF_BA" <?php if ($repop[7]== "UF_BA" ){echo"selected";}?> > BA </option>
				<option value="UF_CE" <?php if ($repop[7]== "UF_CE" ){echo"selected";}?> > CE </option>
				<option value="UF_DF" <?php if ($repop[7]== "UF_DF" ){echo"selected";}?> > DF </option>
				<option value="UF_ES" <?php if ($repop[7]== "UF_ES" ){echo"selected";}?> > ES </option>
				<option value="UF_GO" <?php if ($repop[7]== "UF_GO" ){echo"selected";}?> > GO </option>
				<option value="UF_MA" <?php if ($repop[7]== "UF_MA" ){echo"selected";}?> > MA </option>
				<option value="UF_MG" <?php if ($repop[7]== "UF_MG" ){echo"selected";}?> > MG </option>
				<option value="UF_MT" <?php if ($repop[7]== "UF_MT" ){echo"selected";}?> > MT </option>
				<option value="UF_MS" <?php if ($repop[7]== "UF_MS" ){echo"selected";}?> > MS </option>
				<option value="UF_PA" <?php if ($repop[7]== "UF_PA" ){echo"selected";}?> > PA </option>
				<option value="UF_PB" <?php if ($repop[7]== "UF_PB" ){echo"selected";}?> > PB </option>
				<option value="UF_PE" <?php if ($repop[7]== "UF_PE" ){echo"selected";}?> > PE </option>
				<option value="UF_PI" <?php if ($repop[7]== "UF_PI" ){echo"selected";}?> > PI </option>
				<option value="UF_PR" <?php if ($repop[7]== "UF_PR" ){echo"selected";}?> > PR </option>
				<option value="UF_RJ" <?php if ($repop[7]== "UF_RJ" ){echo"selected";}?> > RJ </option>
				<option value="UF_RN" <?php if ($repop[7]== "UF_RN" ){echo"selected";}?> > RN </option>
				<option value="UF_RO" <?php if ($repop[7]== "UF_RO" ){echo"selected";}?> > RO </option>
				<option value="UF_RR" <?php if ($repop[7]== "UF_RR" ){echo"selected";}?> > RR </option>
				<option value="UF_RS" <?php if ($repop[7]== "UF_RS" ){echo"selected";}?> > RS </option>
				<option value="UF_SC" <?php if ($repop[7]== "UF_SC" ){echo"selected";}?> > SC </option>
				<option value="UF_SE" <?php if ($repop[7]== "UF_SE" ){echo"selected";}?> > SE </option>
				<option value="UF_SP" <?php if ($repop[7]== "UF_SP" ){echo"selected";}?> > SP </option>
				<option value="UF_TO" <?php if ($repop[7]== "UF_TO" ){echo"selected";}?> > TO </option>
				<option value="UF_Outro" <?php if ($repop[7]== "UF_Outro" ){echo"selected";}?> > Outros </option>
			</select>

			<br>
			<br>

			<span style=" 
			<?php if ($resultadovalidacadastro1[8] == 1){
				echo"";
			}else{
				echo "color:#FF0000; font-weight:bold";}
				?> ">
				Nacionalidade: 
			</span>

			<input 
			style="<?php 
			if ($resultadovalidacadastro1[8] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>" 
			type=text id="nacionalidade" name="cadas1[Nacionalidade]" value="<?php echo $repop[8];?>" maxlength=25>
			&nbsp &nbsp &nbsp

			<script type="text/javascript">
			var nacionalidade = new LiveValidation('nacionalidade');
			nacionalidade.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
			</script>


			<span style=" 
			<?php if ($resultadovalidacadastro1[9] == 1){
				echo"";
			}else{
				echo "color:#FF0000; font-weight:bold";}
				?> ">
				Pa&iacute;s: 
			</span>

			<input  
			style="<?php 
			if ($resultadovalidacadastro1[9] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text id="country" name="cadas1[PaisNacionalidade]" value="<?php echo $repop[9];?>" maxlength=50>
			<br>
			<br>

			<script type="text/javascript">
			var country = new LiveValidation('country');
			country.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
			</script>

			<span style=" 
			<?php if ($resultadovalidacadastro1[10] == 1){
				echo"";
			}else{
				echo "color:#FF0000; font-weight:bold";}
				?> ">
				Nome do pai : &nbsp 
			</span>
			<input 
			style="<?php 
			if ($resultadovalidacadastro1[10] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text id="nome_pai" name="cadas1[nome_pai]" value="<?php echo $repop[10];?>" maxlength=100 size=60>
			<br>
			<br>

			<script type="text/javascript">
			var nome_pai = new LiveValidation('nome_pai');
			nome_pai.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
			</script>




			<span style=" 
			<?php if ($resultadovalidacadastro1[11] == 1){
				echo"";
			}else{
				echo "color:#FF0000; font-weight:bold";}
				?> ">
				Nome da mãe:
			</span>
			&nbsp <input 
			style="<?php 
			if ($resultadovalidacadastro1[11] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text id="nome_mae" name="cadas1[nome_mae]" value="<?php echo $repop[11];?>" maxlength=100 size=60>
			<br>          
			<br>

			<script type="text/javascript">
			var nome_mae = new LiveValidation('nome_mae');
			nome_mae.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
			</script>



			<p>  
				<h2> Endereço Pessoal </h2>
				<p>


					<p>
						<span style=" 
						<?php if ($resultadovalidacadastro1[12] == 1){
							echo"";
						}else{
							echo "color:#FF0000; font-weight:bold";}
							?> ">
							Endereço residencial:
						</span>
						<input 
						style="<?php 
						if ($resultadovalidacadastro1[12] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"
						type="text" id="endereco" name="cadas1[adresse]" value="<?php echo $repop[12];?>" size="61" maxlength="250">
					</p>    

					<script type="text/javascript">
					var endereco = new LiveValidation('endereco');
					endereco.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
					</script>

					<p> 
						<span style=" 
						<?php if ($resultadovalidacadastro1[13] == 1){
							echo"";
						}else{
							echo "color:#FF0000; font-weight:bold";}
							?> ">
							CEP:
						</span> 
						<input style="<?php 
						if ($resultadovalidacadastro1[13] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"
						type="text" id="cep" name="cadas1[CPEndereco]" value="<?php echo $repop[13];?>" maxlength="10">
						&nbsp; &nbsp; &nbsp;

						<script type="text/javascript">
						var cep = new LiveValidation('cep');
						cep.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
						</script>


						<span style=" 
						<?php if ($resultadovalidacadastro1[14] == 1){
							echo"";
						}else{
							echo "color:#FF0000; font-weight:bold";}
							?> ">
							Cidade:
						</span> 
						<input 
						style="<?php 
						if ($resultadovalidacadastro1[14] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"
						type="text" id="cidade" name="cadas1[CityEndereco]" value="<?php echo $repop[14];?>" maxlength="20">
						&nbsp; &nbsp; &nbsp;
						<br> <font size="2" color="gray">exemplo XXXXX-YYY</font>
						<br><br>

						<script type="text/javascript">
						var cidade = new LiveValidation('cidade');
						cidade.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
						</script>


						<span style=" 
						<?php if ($resultadovalidacadastro1[15] == 1){
							echo"";
						}else{
							echo "color:#FF0000; font-weight:bold";}
							?> ">
							Estado: 
						</span>
						&nbsp <select 
						style="<?php 
						if ($resultadovalidacadastro1[15] == 1){
							echo'';
						}else{
							echo 'border:2px solid #FF0000';
						} ?>"
						style=" text-align:center" name="cadas1[UFEndereco]">
						<option value="nselecionado" > ------ </option>
						<option value="UF_AC" <?php if ($repop[15]== "UF_AC" ){echo"selected";}?>  > AC </option>
						<option value="UF_AL" <?php if ($repop[15]== "UF_AL" ){echo"selected";}?> > AL </option>
						<option value="UF_AP" <?php if ($repop[15]== "UF_AP" ){echo"selected";}?> > AP </option>
						<option value="UF_AM" <?php if ($repop[15]== "UF_AM" ){echo"selected";}?> > AM </option>
						<option value="UF_BA" <?php if ($repop[15]== "UF_BA" ){echo"selected";}?> > BA </option>
						<option value="UF_CE" <?php if ($repop[15]== "UF_CE" ){echo"selected";}?> > CE </option>
						<option value="UF_DF" <?php if ($repop[15]== "UF_DF" ){echo"selected";}?> > DF </option>
						<option value="UF_ES" <?php if ($repop[15]== "UF_ES" ){echo"selected";}?> > ES </option>
						<option value="UF_GO" <?php if ($repop[15]== "UF_GO" ){echo"selected";}?> > GO </option>
						<option value="UF_MA" <?php if ($repop[15]== "UF_MA" ){echo"selected";}?> > MA </option>
						<option value="UF_MG" <?php if ($repop[15]== "UF_MG" ){echo"selected";}?> > MG </option>
						<option value="UF_MT" <?php if ($repop[15]== "UF_MT" ){echo"selected";}?> > MT </option>
						<option value="UF_MS" <?php if ($repop[15]== "UF_MS" ){echo"selected";}?> > MS </option>
						<option value="UF_PA" <?php if ($repop[15]== "UF_PA" ){echo"selected";}?> > PA </option>
						<option value="UF_PB" <?php if ($repop[15]== "UF_PB" ){echo"selected";}?> > PB </option>
						<option value="UF_PE" <?php if ($repop[15]== "UF_PE" ){echo"selected";}?> > PE </option>
						<option value="UF_PI" <?php if ($repop[15]== "UF_PI" ){echo"selected";}?> > PI </option>
						<option value="UF_PR" <?php if ($repop[15]== "UF_PR" ){echo"selected";}?> > PR </option>
						<option value="UF_RJ" <?php if ($repop[15]== "UF_RJ" ){echo"selected";}?> > RJ </option>
						<option value="UF_RN" <?php if ($repop[15]== "UF_RN" ){echo"selected";}?> > RN </option>
						<option value="UF_RO" <?php if ($repop[15]== "UF_RO" ){echo"selected";}?> > RO </option>
						<option value="UF_RR" <?php if ($repop[15]== "UF_RR" ){echo"selected";}?> > RR </option>
						<option value="UF_RS" <?php if ($repop[15]== "UF_RS" ){echo"selected";}?> > RS </option>
						<option value="UF_SC" <?php if ($repop[15]== "UF_SC" ){echo"selected";}?> > SC </option>
						<option value="UF_SE" <?php if ($repop[15]== "UF_SE" ){echo"selected";}?> > SE </option>
						<option value="UF_SP" <?php if ($repop[15]== "UF_SP" ){echo"selected";}?> > SP </option>
						<option value="UF_TO" <?php if ($repop[15]== "UF_TO" ){echo"selected";}?> > TO </option>
						<option value="UF_Outro" <?php if ($repop[15]== "UF_Outro" ){echo"selected";}?> > Outros </option>
					</select>
				</select>
				&nbsp; &nbsp; &nbsp;


				<span style=" 
				<?php if ($resultadovalidacadastro1[16] == 1){
					echo"";
				}else{
					echo "color:#FF0000; font-weight:bold";}
					?> ">
					País: 
				</span>
				<input 
				style="<?php 
				if ($resultadovalidacadastro1[16] == 1){
					echo'';
				}else{
					echo 'border:2px solid #FF0000';
				} ?>"
				type="text" id="country2" name="cadas1[country]" value="<?php echo $repop[16];?>" maxlength="20">

			</p>

			<script type="text/javascript">
			var country2 = new LiveValidation('country2');
			country2.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
			</script>





			<p>
				<span style=" 
				<?php if ( ($resultadovalidacadastro1[17] == 0)| ($resultadovalidacadastro1[18] == 0) |($resultadovalidacadastro1[19] == 0)    ){
					echo "color:#FF0000; font-weight:bold";
				}else{
					echo"";
				}
				?> ">
				Telefone comercial :
			</span>

			&nbsp DDI: <input 
			style="<?php 
			if ($resultadovalidacadastro1[17] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text placeholder="55" name="cadas1[DDI_PhoneWork]" value="<?php echo $repop[17];?>" maxlength=3 size="3" onkeypress="return verif_touche(event);">


			&nbsp DDD: <input 
			style="<?php 
			if ($resultadovalidacadastro1[18] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text id="codigo_ddd1" name="cadas1[DDD_PhoneWork]" value="<?php echo $repop[18];?>" maxlength=2 size="2" onkeypress="return verif_touche(event);">

			<script type="text/javascript">
			var codigo_ddd1 = new LiveValidation('codigo_ddd1');
			codigo_ddd1.add(Validate.Numericality, {
				onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
				);
			</script>

			&nbsp TEL: <input style="<?php 
			if ($resultadovalidacadastro1[19] == 1){
				echo'';
			}else{
				echo 'border:2px solid #FF0000';
			} ?>"
			type=text id="telcomercial" name="cadas1[PhoneWork]" value="<?php echo $repop[19];?>" maxlength=8 size="7"  onkeypress="return verif_touche(event);">  
			<br>
			<br>

			<script type="text/javascript">
			var telcomercial = new LiveValidation('telcomercial');
			telcomercial.add(Validate.Numericality, {
				onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
				);
			</script>

			<span style=" 
			<?php if ( ($resultadovalidacadastro1[20] == 0)| ($resultadovalidacadastro1[21] == 0) |($resultadovalidacadastro1[22] == 0)    ){
				echo "color:#FF0000; font-weight:bold";
			}else{
				echo"";
			}
			?> ">
			Telefone residencial: 
		</span>

		&nbsp DDI: <input style="<?php 
		if ($resultadovalidacadastro1[20] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		type=text placeholder="55" name="cadas1[DDI_PhoneHome]" value="<?php echo $repop[20];?>" maxlength=3 size="3" onkeypress="return verif_touche(event);">



		&nbsp DDD:<input style="<?php 
		if ($resultadovalidacadastro1[21] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		type=text id="codigo_ddd2" name="cadas1[DDD_PhoneHome]" value="<?php echo $repop[21];?>" maxlength=2 size="2" onkeypress="return verif_touche(event);">

		<script type="text/javascript">
		var codigo_ddd2 = new LiveValidation('codigo_ddd2');
		codigo_ddd2.add(Validate.Numericality, {
			onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
			);
		</script>


		&nbsp TEL:<input style="<?php 
		if ($resultadovalidacadastro1[22] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		type=text id="telresidencial" name="cadas1[PhoneHome]" value="<?php echo $repop[22];?>" maxlength=8 size="7"  onkeypress="return verif_touche(event);">  
		<br>
		<br>

		<script type="text/javascript">
		var telresidencial = new LiveValidation('telresidencial');
		telresidencial.add(Validate.Numericality, {
			onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
			);
		</script>

		<span style=" 
		<?php if ( ($resultadovalidacadastro1[23] == 0)| ($resultadovalidacadastro1[24] == 0) |($resultadovalidacadastro1[25] == 0)    ){
			echo "color:#FF0000; font-weight:bold";
		}else{
			echo"";
		}
		?> ">        
		Telefone celular : &nbsp
	</span>

	&nbsp DDI: <input style="<?php 
	if ($resultadovalidacadastro1[23] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>" 
	type=text placeholder="55" name="cadas1[DDI_cel]" value="<?php echo $repop[23];?>" maxlength=3 size="3" onkeypress="return verif_touche(event);">


	&nbsp DDD: <input style="<?php 
	if ($resultadovalidacadastro1[24] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	type=text id="codigo_ddd3" name="cadas1[DDD_cel]" value="<?php echo $repop[24];?>" maxlength=2 size="2" onkeypress="return verif_touche(event);">

	<script type="text/javascript">
	var codigo_ddd3 = new LiveValidation('codigo_ddd3');
	codigo_ddd3.add(Validate.Numericality, {
		onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
		);
	</script>


	&nbsp TEL: <input style="<?php 
	if ($resultadovalidacadastro1[25] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	type=text id="celular" name="cadas1[TelCelular]" value="<?php echo $repop[25];?>" maxlength=9 size="7"  onkeypress="return verif_touche(event);">

	</p>

	<script type="text/javascript">
	var celular = new LiveValidation('celular');
	celular.add(Validate.Numericality, {
		onlyInteger: true , notAnIntegerMessage: "Somente números!", notANumberMessage: "Somente números!"}
		);
	</script>

	<span style=" 
	<?php if ($resultadovalidacadastro1[26] == 1){
		echo"";
	}else{
		echo "color:#FF0000; font-weight:bold";}
		?> ">
		E-mail principal: 
	</span>

	<input style="<?php 
	if ($resultadovalidacadastro1[26] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	type="text" id="email1" name="cadas1[mail1]" value="<?php echo $repop[26];?>" maxlength="70">
	&nbsp; &nbsp; &nbsp;

	<script type="text/javascript">
	var email1 = new LiveValidation('email1');
	email1.add(Validate.Email);
	</script>

	<span style=" 
	<?php if ($resultadovalidacadastro1[27] == 1){
		echo"";
	}else{
		echo "color:#FF0000; font-weight:bold";}
		?> ">
		E-mail alternativo:
	</span>
	<input style="<?php 
	if ($resultadovalidacadastro1[27] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	type="text" id="email2" name="cadas1[mail2]" value="<?php echo $repop[27];?>" maxlength="70">
	<br>          
	<br>

	<script type="text/javascript">
	var email2 = new LiveValidation('email2');
	email2.add(Validate.Email);
	</script>


	<p>  
		<h2> Documentos Pessoais.</h2>
	</p>


	<p>
		<span style=" 
		<?php if ($resultadovalidacadastro1[28] == 1){
			echo"";
		}else{
			echo "color:#FF0000; font-weight:bold";}
			?> ">
			Número de CPF :
		</span>

		<input style="<?php 
		if ($resultadovalidacadastro1[28] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		type="text" id="cpf" name="cadas1[cpf]" value="<?php echo $repop[28];?>" maxlength="14">	
		<br>
		<br>

		<script type="text/javascript">
		var cpf = new LiveValidation('cpf');
		cpf.add( Validate.Numericality, {
			onlyInteger: true , notAnIntegerMessage: "O CPF deve conter somente números!", notANumberMessage: "O CPF deve conter somente números!"}
			);
		</script> 

		<span style=" 
		<?php if ($resultadovalidacadastro1[29] == 1){
			echo"";
		}else{
			echo "color:#FF0000; font-weight:bold";}
			?> ">
			Número de Identidade (ou Passaporte para estrangeiros):
		</span>
		<input style="<?php 
		if ($resultadovalidacadastro1[29] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		type="text" id="identidade" name="cadas1[identity]" value="<?php echo $repop[29];?>" maxlength="40">
		<br>
		<br>

		<script type="text/javascript">
		var identidade = new LiveValidation('identidade');
		identidade.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
		</script>

		<span style=" 
		<?php if ($resultadovalidacadastro1[30] == 1){
			echo"";
		}else{
			echo "color:#FF0000; font-weight:bold";}
			?> ">
			&Oacute;rg&atilde;o emissor: 
		</span>
		<input style="<?php 
		if ($resultadovalidacadastro1[30] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>" type=text id="emissor" name="cadas1[id_emissor]" value="<?php echo $repop[30];?>" maxlength=15>  
		&nbsp &nbsp

		<script type="text/javascript">
		var emissor = new LiveValidation('emissor');
		emissor.add(Validate.Presence, {failureMessage: "Não pode ser vazio!"});
                emissor.add(Validate.Length, {maximum:9});
		</script>


		<span style=" 
		<?php if ($resultadovalidacadastro1[31] == 1){
			echo"";
		}else{
			echo "color:#FF0000; font-weight:bold";}
			?> ">
			Estado: &nbsp 
		</span>

		<select style="<?php 
		if ($resultadovalidacadastro1[31] == 1){
			echo'';
		}else{
			echo 'border:2px solid #FF0000';
		} ?>"
		style=" text-align:center" name="cadas1[EstadoEmissaoId]">
		<option value="nselecionado" > ------ </option>
		<option value="UF_AC" <?php if ($repop[31]== "UF_AC" ){echo"selected";}?>  > AC </option>
		<option value="UF_AL" <?php if ($repop[31]== "UF_AL" ){echo"selected";}?> > AL </option>
		<option value="UF_AP" <?php if ($repop[31]== "UF_AP" ){echo"selected";}?> > AP </option>
		<option value="UF_AM" <?php if ($repop[31]== "UF_AM" ){echo"selected";}?> > AM </option>
		<option value="UF_BA" <?php if ($repop[31]== "UF_BA" ){echo"selected";}?> > BA </option>
		<option value="UF_CE" <?php if ($repop[31]== "UF_CE" ){echo"selected";}?> > CE </option>
		<option value="UF_DF" <?php if ($repop[31]== "UF_DF" ){echo"selected";}?> > DF </option>
		<option value="UF_ES" <?php if ($repop[31]== "UF_ES" ){echo"selected";}?> > ES </option>
		<option value="UF_GO" <?php if ($repop[31]== "UF_GO" ){echo"selected";}?> > GO </option>
		<option value="UF_MA" <?php if ($repop[31]== "UF_MA" ){echo"selected";}?> > MA </option>
		<option value="UF_MG" <?php if ($repop[31]== "UF_MG" ){echo"selected";}?> > MG </option>
		<option value="UF_MT" <?php if ($repop[31]== "UF_MT" ){echo"selected";}?> > MT </option>
		<option value="UF_MS" <?php if ($repop[31]== "UF_MS" ){echo"selected";}?> > MS </option>
		<option value="UF_PA" <?php if ($repop[31]== "UF_PA" ){echo"selected";}?> > PA </option>
		<option value="UF_PB" <?php if ($repop[31]== "UF_PB" ){echo"selected";}?> > PB </option>
		<option value="UF_PE" <?php if ($repop[31]== "UF_PE" ){echo"selected";}?> > PE </option>
		<option value="UF_PI" <?php if ($repop[31]== "UF_PI" ){echo"selected";}?> > PI </option>
		<option value="UF_PR" <?php if ($repop[31]== "UF_PR" ){echo"selected";}?> > PR </option>
		<option value="UF_RJ" <?php if ($repop[31]== "UF_RJ" ){echo"selected";}?> > RJ </option>
		<option value="UF_RN" <?php if ($repop[31]== "UF_RN" ){echo"selected";}?> > RN </option>
		<option value="UF_RO" <?php if ($repop[31]== "UF_RO" ){echo"selected";}?> > RO </option>
		<option value="UF_RR" <?php if ($repop[31]== "UF_RR" ){echo"selected";}?> > RR </option>
		<option value="UF_RS" <?php if ($repop[31]== "UF_RS" ){echo"selected";}?> > RS </option>
		<option value="UF_SC" <?php if ($repop[31]== "UF_SC" ){echo"selected";}?> > SC </option>
		<option value="UF_SE" <?php if ($repop[31]== "UF_SE" ){echo"selected";}?> > SE </option>
		<option value="UF_SP" <?php if ($repop[31]== "UF_SP" ){echo"selected";}?> > SP </option>
		<option value="UF_TO" <?php if ($repop[31]== "UF_TO" ){echo"selected";}?> > TO </option>
		<option value="UF_Outro" <?php if ($repop[31]== "UF_Outro" ){echo"selected";}?> > Outros </option>
	</select>
	<br>
	<br>

	<span style=" 
	<?php if ( ($resultadovalidacadastro1[32] == 0)| ($resultadovalidacadastro1[33] == 0) |($resultadovalidacadastro1[34] == 0)    ){
		echo "color:#FF0000; font-weight:bold";
	}else{
		echo"";
	}
	?> ">
	Data de emiss&atilde;o:
	</span> 
	&nbsp &nbsp 


	Dia
	<select style="<?php 
	if ($resultadovalidacadastro1[32] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	name="cadas1[DiaEmissaoId]" >
	<?php
	$dia=01;
	echo '<option  value="nselecionado"> --- </option>';
	do
	{
		echo '<option value='.$dia; if ($repop[32]== $dia ){echo" selected";} echo">".$dia."</option>";
		$dia++;
	} while ($dia<32);
	?>
	</select>

	Mês
	<select style="<?php 
	if ($resultadovalidacadastro1[33] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	name="cadas1[MesEmissaoId]" >
	<?php
	$mes=01;
	echo '<option  value="nselecionado"> --- </option>';
	do
	{
		echo '<option value='.$mes; if ($repop[33]== $mes ){echo" selected";} echo">".$mes."</option>";
		$mes++;
	} while ($mes<13);
	?>
	</select>

	Ano
	<select style="<?php 
	if ($resultadovalidacadastro1[34] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	name="cadas1[AnoEmissaoId]" size="1">
	<?php
	$ano=2012;
	echo '<option  value="nselecionado"> ------</option>';
	do
	{
		echo '<option value='.$ano; if ($repop[34]== $ano ){echo" selected";} echo">".$ano."</option>";
		$ano--;
	} while ($ano>1946);
	?>
	</select>
	</p>

	<br> 

	<p> <h2>Senha de Acesso ao Sistema </h2></p>


	<span style=" 
	<?php if ($resultadovalidacadastro1[35] == 1){
		echo"";
	}else{
		echo "color:#FF0000; font-weight:bold";}
		?> ">
		Escolha sua senha de acesso ao sistema do MAT-UnB:
	</span>
	<input style="<?php 
	if ($resultadovalidacadastro1[35] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"  
	type="password" id="senha" name="cadas1[senha]" value="<?php echo $repop[35];?>" maxlength="30">
	<br> (A senha escolhida deverá ser formada por mais de 4 caracteres, letras e números.)
	<br>          

	<script type="text/javascript">
	var senha = new LiveValidation('senha');
	senha.add( Validate.Length, {minimum: 4, tooShortMessage: "Senha muito curta!"});
	senha.add(Validate.Presence, {
		failureMessage: "Não pode ser vazio!"});
	</script>

	<span style=" 
	<?php if ($resultadovalidacadastro1[36] == 1){
		echo"";
	}else{
		echo "color:#FF0000; font-weight:bold";}
		?> ">
		Digite novamente a senha:
	</span>
	<input style="<?php 
	if ($resultadovalidacadastro1[36] == 1){
		echo'';
	}else{
		echo 'border:2px solid #FF0000';
	} ?>"
	type="password" id="confirma_senha" name="cadas1[senharedigitada]" value="<?php echo $repop[36];?>" maxlength="30">
	<br>          
	<br>

	<script type="text/javascript">
	var confirma_senha = new LiveValidation('confirma_senha');
	confirma_senha.add(Validate.Confirmation, {failureMessage:"Senha não combina!", match: 'senha'}
		);
	</script>


	<input type="hidden" name="modificacao" value="nao">
	<input type="hidden" name="OndeEstou" value="pag1">
	<p align="center"> 
		<input type="submit" name="rota" value="Criar conta"> 
	</p>
	</form>

	</body>
	</html>
