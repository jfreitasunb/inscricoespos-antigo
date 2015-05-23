	  <tr>
	  <td>Sexo: <select name="sexo">
			<OPTION value="masculino">Masculino
			<OPTION value="feminino">Feminino

          <tr>
            <td> Nome do pai:<input type=text name='nome_pai' maxlength=100 size=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
	  </tr>
          <tr>
            <td>Nome da m&atilde;e:<input type=text name='nome_mae' maxlength=100 size=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr>
            <td>Naturalidade: <input type=text name='naturalidade' maxlength=25>  Estado:<select name="UF_naturalidade">
			<?php // gera a lista de UF
			$res = pg_query("SELECT UF FROM estados order by UF");
			while($registro = pg_fetch_row($res)) //enquanto houver 				
				{
				$uf = $registro[0];  	// primeira coluna da tabela 
				echo "<option value='".$uf."'>".$uf."</option>";
				}
			?></select></td>
          </tr>
	  <tr>
            <td>Nacionalidade: <input type=text name='nacionalidade' maxlength=25></td>
	    <td>Pa&iacute;s: <input  type=text name='pais' maxlength=50></td>
	  </tr>
          <tr>
             <td>Estado : <select name="UF">
			<?php // gera a lista de UF
			$res = pg_query("SELECT UF,estado FROM estados order by estado");
			while($registro = pg_fetch_row($res)) //enquanto houver 				
				{
				$estado = $registro[1]; // primeira coluna da tabela 
				$uf = $registro[0];  	// primeira coluna da tabela 
				echo "<option value='".$uf."'>".$estado."</option>";
				}
			?></select>
             </td>
          </tr>
          <tr>
            <td>Telefone comercial : (<input type=text name='DI_phone_work' maxlength=2 size="2" onkeypress="return verif_touche(event);">)-<input type=text name='phone_work' maxlength=8 size="7" onkeypress="return verif_touche(event);">  Telefone residencial: (<input type=text name='DI_phone_home' maxlength=2 size="2" onkeypress="return verif_touche(event);">)-<input type=text name='phone_home' maxlength=8 size="7" onkeypress="return verif_touche(event);">  Telefone celular : (<input type=text name='DI_cel' maxlength=2 size="2" onkeypress="return verif_touche(event);">)-<input type=text name='celular' maxlength=8 size="7"  onkeypress="return verif_touche(event);">
           </td>
          </tr>
          </table></td></tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td class=header colspan=4 align=center>
              Documentos pessoais:
            </td>
          </tr>
          <tr>
            <td>N&uacute;mero de CPF: <input type=text name='cpf' maxlength=14 onkeypress="return verif_touche(event);" onkeyup="if(event.keyCode!=8 && event.keyCode!=13){this.value = saisie_cpf(this.value);}" onfocus="if(document.formu.matricul.value.length<6 && document.formu.matricul.value.length!0){document.formu.matricul.focus();}" >
            </td>
          <tr>
            <td>N&uacute;mero de Identidade: <input type=text name='identidade' maxlength=15>   &Oacute;rg&atilde;o emissor: <input type=text name='id_emissor' maxlength=15>  Estado: <select name="id_UF">
				<?php // gera a lista de UF
				$res = pg_query("SELECT UF FROM estados order by UF");
				while($registro = pg_fetch_row($res)) //enquanto houver 					
					{
					$uf = $registro[0];  	// primeira coluna da tabela 
					echo "<option value='".$uf."'>".$uf."</option>";
					}
				?></select>
            </td>
          </tr>
	  <tr>
  	  <td>Data de emiss&atilde;o:  <select name='id_dia'>
                                                        <?
                                                        $query_dias=pg_query("select dia from dias order by dia");
                                                        while ($dia=pg_fetch_row($query_dias))
                                                        {
                                                          echo "<option value='".$dia[0]."'>".$dia[0]."</option>";
                                                        }
                                                        ?>
                                                        </select>/
                                                        <select name='id_mes'>
                                                        <?
                                                        $query_meses=pg_query("select mes from meses order by mes");
                                                        while ($mes=pg_fetch_row($query_meses))
                                                        {
                                                          echo "<option value='".$mes[0]."'>".$mes[0]."</option>";
                                                        }
                                                        ?>
                                                        </select>/
                                                        <select name='id_ano'>
                                                        <?
                                                        for ($i=1930;$i<2020;$i++)
                                                        {
                                                          echo "<option value='".$i."'>".$i."</option>";
                                                        }
                                                        ?>
                                                        </select>
	</td>

	  </tr>

