<html>
  <header>
    <!link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
  <form method="POST" name="formu" action="escolhe_alunos_nivel_curso_2.php">
      <tr>
        <td class=header align=center>
          <h1>Inscricoess nos programa de pós-graduação MAT-UnB: criação/envio de nova senha</h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td>
     <b>Selecione o tipo de curso (seria o edital):</b>
<? /*	<select name=usuario>
	while($registro=pg_fetch_row($query_usuarios))
		{
		echo "<option value=\"".$registro[0]."\">".$registro[1]."</option>";
		}
 */?>
	<select name='curso'>
		<option value=0>-----</option>
		<option value="Mestrado">Mestrado</option>
		<option value="Doutorado">Doutorado</option>
	</select></td>
	  </tr>
	<tr><td>Curso de verão:	<select  name='verao'>
		<option value=1>Sim</option>
		<option value=0>Nao</option>
	</select></td></tr>
	</tr> 
	</table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit name='confirmar' value="Confirmar">
        </td>
      </form>
</table>
</body>
</html>

