<html>
  <head>
    <meta charset="utf-8">
    <title>Relatório de Inscritos</title>

  </head>
  <body>

<?php

include_once("../../pgsql/pgsql.php"); 
include_once("../../config/config.php");

//$edital_atual="1-2014";
//$edital_anterior="2-2013";

// Gerando a lista de codusers a partir da tabela finaliza

$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='$edital_atual' and coduser <> '110' and coduser <> '592' and coduser <> '210' and coduser <> '1264' and coduser <> '561' and coduser <> '618' and coduser <> '1434' and coduser <> '1435'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
//var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){

$j = $i +1;

		$coduser=$tab_coduser[$i]['coduser'];
		$query_seleciona_programa = pg_query("select programa from inscricao_pos_contatos_recomendante where id_aluno = '".$coduser."' and edital = '".$edital_atual."'");
		$seleciona_programa = pg_fetch_assoc($query_seleciona_programa);
		$programa = $seleciona_programa['programa'];
		if ($programa <> "Verão"){
			echo "Inscrição: ".$j;
		//$coduser="711";

		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas31 = pg_fetch_assoc($query_carta_motivacao);
		
		//var_dump($cadas1);
		//var_dump($cadas2);
		//var_dump($cadas3);
			
		$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."'");

// Arrumando os nomes dos estados
$ufnatura = explode("_",$cadas1['ufnaturalidade']);
$cadas1['ufnaturalidade'] = $ufnatura[1];

$ufend = explode("_",$cadas1['ufendereco']);
$cadas1['ufendereco'] = $ufend[1];

$estadoemissao = explode("_",$cadas1['estadoemissaoid']);
$cadas1['estadoemissaoid'] = $ufend[1];

// Coloca o nome em formato padrão - Título (primeira letra de cada string maíuscula)
$nome =$cadas1['name']." ".$cadas1['firstname'];
$nome = ucwords(strtolower($nome));
$nome =str_replace(' ','',$nome);

echo "<h3 align=center> Cod: ".$coduser." - ".ucwords(strtolower($cadas1['name']))." ".ucwords(strtolower($cadas1['firstname']))." - ".$cadas3['programa']."</h3>";

// Calcula Idade
$data_nascimento = $cadas1['anonascimento']."-".$cadas1['mesnascimento']."-".$cadas1['dianascimento'];
if ($data_nascimento == "--"){ 
								$idade="N Info";
							}else{ 
								$idade = floor( (strtotime(date('Y-m-d')) - strtotime($data_nascimento)) / 31556926);
							}
// Arrumando e-mails

$cadas1['mail1'] = str_replace('_','\_',$cadas1['mail1']);
$cadas1['mail2'] = str_replace('_','\_',$cadas1['mail2']);
$cadas3['emailprofrecomendante1'] = str_replace('_','\_',$cadas3['emailprofrecomendante1']);
$cadas3['emailprofrecomendante2'] = str_replace('_','\_',$cadas3['emailprofrecomendante2']);
$cadas3['emailprofrecomendante3'] = str_replace('_','\_',$cadas3['emailprofrecomendante3']);
//echo $cadas1['mail1']."<br>".$cadas1['mail2'];


//echo "Cod: " .$coduser." - ".$cadas1['name']." ".$cadas1['firstname']." - ".$cadas3['programa'];
echo "<br> Data de Nascimento: ".$cadas1['dianascimento']."/".$cadas1['mesnascimento']."/".$cadas1['anonascimento'];
echo " Idade: ".$idade. " Sexo: ".$cadas1['sexo'];
echo "<br> Naturalidade: ".ucwords(strtolower($cadas1['naturalidade'])). " Estado: ".$cadas1['ufnaturalidade'];
echo "<br> Nacionalidade: ".ucwords(strtolower($cadas1['nacionalidade'])). " País: ".ucwords(strtolower($cadas1['paisnacionalidade']));
echo "<br> Nome do pai: ".ucwords(strtolower($cadas1['nome_pai']));
echo "<br> Nome da mãe: ".ucwords(strtolower($cadas1['nome_mae']));                 

echo "<h4>Endereço Pessoal</h4>";

echo "Endereço residencial: ".ucwords(strtolower($cadas1['adresse']))." CEP: ".$cadas1['cpendereco']." Cidade: ".ucwords(strtolower($cadas1['cityendereco']))."
Estado: ".$cadas1['ufendereco']." País: ".ucwords(strtolower($cadas1['country']));
echo "<br> Telefone comercial: +".$cadas1['ddi_phonework'].
"(".$cadas1['ddd_phonework'].")".$cadas1['phonework']." Telefone residencial: +".$cadas1['ddi_phonehome'].
"(".$cadas1['ddd_phonehome'].")".$cadas1['phonehome']." Telefone celular: +".$cadas1['ddi_cel'].
"(".$cadas1['ddd_cel'].")".$cadas1['telcelular']; 

echo "<br> E-mail principal: ".strtolower($cadas1['mail1']);
echo "<br> E-mail alternativo: ".strtolower($cadas1['mail2']);

echo "<h4>Documentos Pessoais</h4>"; 
echo "Número de CPF: ".$cadas1['cpf'];
echo"<br> Número de Identidade (ou Passaporte para estrangeiros): ".$cadas1['identity']."
Orgão emissor: ".$cadas1['id_emissor'];
echo "<br>";
echo " Estado: ".$estadoemissaoid[1]." Data de emissão: ".$cadas1['diaemissaoid'].
"/".$cadas1['mesemissaoid']."/".$cadas1['anoemissaoid'];

echo "<h4>Grau acadêmico mais alto obtido</h4>";

echo "Curso: ".ucwords(strtolower($cadas2['instrucaocurso']))." Grau: ".ucwords(strtolower($cadas2['instrucaograu'])).
" Instituição: ".ucwords(strtolower($cadas2['instrucaoinstituicao']));
echo "<br> Ano de Conclusão ou Previsão: ".$cadas2['instrucaoanoconclusao'];
// echo "<br> Experiência Profissional mais recente.
// Tem experiência: ".$cadas2['experienciatipo1']." ".$cadas2['experienciatipo2']." Instituição: ".ucwords(strtolower($cadas2['experienciainstituicao']))."
// Período - início: ".$cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano'].
// " fim: ".$cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano'];


echo "<h4> Experiência Profissional mais recente.</h4>";
echo "<style type='text/css'>";
echo "table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}";
echo "table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:center;}";
echo "table.tftable tr {background-color:#d4e3e5;}";
echo "table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}";
echo "</style>";
echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th>Tipo de experência</th><th>Instituição</th><th>Início</th><th>Fim</th></tr>";
echo "<tr><td align='center'>".$cadas2['experienciatipo1']."</td><td align='center'>".$cadas2['experienciainstituicao']."</td><td align='center'>".$cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano']."</td><td align='center'>".$cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano']."</td></tr>";
echo "<tr><td align='center'>".$cadas2['experienciatipo2']."</td><td align='center'>".$cadas2['experienciainstituicao']."</td><td align='center'>".$cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano']."</td><td align='center'>".$cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano']."</td></tr>";
echo "</table>";

echo "<h4>Programa</h4>";

echo "Programa Pretendido: ".$cadas3['programa'] ;
if ($cadas2['cursopos']=="Doutorado") {
	if ($cadas2['areadoutorado']=="" or $cadas2['areadoutorado']=="0" or $cadas2['areadoutorado']=="nselecionado") {
		}else{
			echo " Área: ".$cadas2['areadoutorado'];
		}
}

if ($cadas2['cursopos']=="0" or $cadas2['verao']=="" or $cadas2['verao']=="sim") {
	echo "<br>";
	echo " Curso de Verão: ".$cadas2['cursoverao'];

}


echo "<br> Interesse em bolsa: ".$cadas2['interessebolsa'];
echo "<br> Dados dos Recomendantes:";
echo "<br> 1- Nome: ".ucwords(strtolower($cadas3['nomeprofrecomendante1']))." e-mail: ".strtolower($cadas3['emailprofrecomendante1']);
echo "<br> 2- Nome: ".ucwords(strtolower($cadas3['nomeprofrecomendante2']))." e-mail: ".strtolower($cadas3['emailprofrecomendante2']);
echo "<br> 3- Nome: ".ucwords(strtolower($cadas3['nomeprofrecomendante3']))." e-mail: ".strtolower($cadas3['emailprofrecomendante3']);

echo "<br>";
echo "<br>";

echo "<b> Motivação e expectativa do candidato em relação ao programa pretendido:</b> ".$cadas31['motivacaoprogramapretendido'];

echo "<h4>Primeira Carta de recomendação</h4>";

$query_pega_idprof1 = pg_query("select coduser from inscricao_pos_login where login='".stripslashes(strtolower($cadas3['emailprofrecomendante1']))."'  ");
$coduser1=pg_fetch_row($query_pega_idprof1);
$id_prof1=$coduser1[0];
//echo $cadas1['id_aluno'];
echo "Código Identificador: ".$id_prof1;
echo "<br> Nome do Recomendante: ".ucwords(strtolower($cadas3['nomeprofrecomendante1']));

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof1."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];

echo "<br>";

echo "<br> Avaliações:";

$marcadesempenhoacademico1 ="";
$marcadesempenhoacademico2 ="";
$marcadesempenhoacademico3 ="";
$marcadesempenhoacademico4 ="";
$marcadesempenhoacademico5 ="";
if ($formu1['desempenhoacademico']==1) {
	$marcadesempenhoacademico1 = "X";
}
elseif ($formu1['desempenhoacademico']==2) {
	$marcadesempenhoacademico2 = "X";
}
elseif ($formu1['desempenhoacademico']==3) {
	$marcadesempenhoacademico3 = "X";
}elseif ($formu1['desempenhoacademico']==4) {
	$marcadesempenhoacademico4 = "X";
}
elseif ($formu1['desempenhoacademico']=="naoinfo") {
	$marcadesempenhoacademico5 = "X";
}

$marcacapacidadeaprender1 ="";
$marcacapacidadeaprender2 ="";
$marcacapacidadeaprender3 ="";
$marcacapacidadeaprender4 ="";
$marcacapacidadeaprender5 ="";
if ($formu1['capacidadeaprender']==1) {
	$marcacapacidadeaprender1 = "X";
}
elseif ($formu1['capacidadeaprender']==2) {
	$marcacapacidadeaprender2 = "X";
}
elseif ($formu1['capacidadeaprender']==3) {
	$marcacapacidadeaprender3 = "X";
}elseif ($formu1['capacidadeaprender']==4) {
	$marcacapacidadeaprender4 = "X";
}
elseif ($formu1['capacidadeaprender']=="naoinfo") {
	$marcacapacidadeaprender5 = "X";
}

$marcacapacidadetrabalhar1 ="";
$marcacapacidadetrabalhar2 ="";
$marcacapacidadetrabalhar3 ="";
$marcacapacidadetrabalhar4 ="";
$marcacapacidadetrabalhar5 ="";

if ($formu1['capacidadetrabalhar']==1) {
	$marcacapacidadetrabalhar1 = "X";
}
elseif ($formu1['capacidadetrabalhar']==2) {
	$marcacapacidadetrabalhar2 = "X";
}
elseif ($formu1['capacidadetrabalhar']==3) {
	$marcacapacidadetrabalhar3 = "X";

}elseif ($formu1['capacidadetrabalhar']==4) {
	$marcacapacidadetrabalhar4 = "X";
}
elseif ($formu1['capacidadetrabalhar']=="naoinfo") {
	$marcacapacidadetrabalhar5 = "X";
}

$marcacriatividade1 ="";
$marcacriatividade2 ="";
$marcacriatividade3 ="";
$marcacriatividade4 ="";
$marcacriatividade5 ="";
if ($formu1['criatividade']==1) {
	$marcacriatividade1 = "X";
}
elseif ($formu1['criatividade']==2) {
	$marcacriatividade2 = "X";
}
elseif ($formu1['criatividade']==3) {
	$marcacriatividade3 = "X";
}elseif ($formu1['criatividade']==4) {
	$marcacriatividade4 = "X";
}
elseif ($formu1['criatividade']=="naoinfo") {
	$marcacriatividade5 = "X";
}

$marcacuriosidade1 ="";
$marcacuriosidade2 ="";
$marcacuriosidade3 ="";
$marcacuriosidade4 ="";
$marcacuriosidade5 ="";
if ($formu1['curiosidade']==1) {
	$marcacuriosidade1 = "X";
}
elseif ($formu1['curiosidade']==2) {
	$marcacuriosidade2 = "X";
}
elseif ($formu1['curiosidade']==3) {
	$marcacuriosidade3 = "X";
}elseif ($formu1['curiosidade']==4) {
	$marcacuriosidade4 = "X";
}
elseif ($formu1['curiosidade']=="naoinfo") {
	$marcacuriosidade5 = "X";
}

$marcaesforco1 ="";
$marcaesforco2 ="";
$marcaesforco3 ="";
$marcaesforco4 ="";
$marcaesforco5 ="";
if ($formu1['esforco']==1) {
	$marcaesforco1 = "X";
}
elseif ($formu1['esforco']==2) {
	$marcaesforco2 = "X";
}
elseif ($formu1['esforco']==3) {
	$marcaesforco3 = "X";
}elseif ($formu1['esforco']==4) {
	$marcaesforco4 = "X";
}
elseif ($formu1['esforco']=="naoinfo") {
	$marcaesforco5 = "X";
}

$marcaexpressaoescrita1 ="";
$marcaexpressaoescrita2 ="";
$marcaexpressaoescrita3 ="";
$marcaexpressaoescrita4 ="";
$marcaexpressaoescrita5 ="";
if ($formu1['expressaoescrita']==1) {
	$marcaexpressaoescrita1 = "X";
}
elseif ($formu1['expressaoescrita']==2) {
	$marcaexpressaoescrita2 = "X";
}
elseif ($formu1['expressaoescrita']==3) {
	$marcaexpressaoescrita3 = "X";
}elseif ($formu1['expressaoescrita']==4) {
	$marcaexpressaoescrita4 = "X";
}
elseif ($formu1['expressaoescrita']=="naoinfo") {
	$marcaexpressaoescrita5 = "X";
}

$marcaexpressaooral1 ="";
$marcaexpressaooral2 ="";
$marcaexpressaooral3 ="";
$marcaexpressaooral4 ="";
$marcaexpressaooral5 ="";
if ($formu1['expressaooral']==1) {
	$marcaexpressaooral1 = "X";
}
elseif ($formu1['expressaooral']==2) {
	$marcaexpressaooral2 = "X";
}
elseif ($formu1['expressaooral']==3) {
	$marcaexpressaooral3 = "X";
}elseif ($formu1['expressaooral']==4) {
	$marcaexpressaooral4 = "X";
}
elseif ($formu1['expressaooral']=="naoinfo") {
	$marcaexpressaooral5 = "X";
}

$marcarelacionamento1 ="";
$marcarelacionamento2 ="";
$marcarelacionamento3 ="";
$marcarelacionamento4 ="";
$marcarelacionamento5 ="";
if ($formu1['relacionamento']==1) {
	$marcarelacionamento1 = "X";
}
elseif ($formu1['relacionamento']==2) {
	$marcarelacionamento2 = "X";
}
elseif ($formu1['relacionamento']==3) {
	$marcarelacionamento3 = "X";
}elseif ($formu1['relacionamento']==4) {
	$marcarelacionamento4 = "X";
}
elseif ($formu1['relacionamento']=="naoinfo") {
	$marcarelacionamento5 = "X";
}

echo "<style type='text/css'>";
echo "table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}";
echo "table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:center;}";
echo "table.tftable tr {background-color:#d4e3e5;}";
echo "table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}";
echo "</style>";
echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>Excelente</th><th>Bom</th><th>Regular</th><th>Insuficiente</th><th>Não sabe</th></tr>";
echo "<tr><td>Desempenho acadêmico</td><td align='center'>".$marcadesempenhoacademico1."</td><td align='center'>".$marcadesempenhoacademico2."</td><td align='center'>".$marcadesempenhoacademico3."</td><td align='center'>".$marcadesempenhoacademico4."</td><td align='center'>".$marcadesempenhoacademico5."</td></tr>";
echo "<tr><td>Capacidade de aprender novos conceitos</td><td align='center'>".$marcacapacidadeaprender1."</td><td align='center'>".$marcacapacidadeaprender2."</td><td align='center'>".$marcacapacidadeaprender3."</td><td align='center'>".$marcacapacidadeaprender4."</td><td align='center'>".$marcacapacidadeaprender5."</td></tr>";
echo "<tr><td>Capacidade de trabalhar sozinho</td><td align='center'>".$marcacapacidadetrabalhar1."</td><td align='center'>".$marcacapacidadetrabalhar2."</td><td align='center'>".$marcacapacidadetrabalhar3."</td><td align='center'>".$marcacapacidadetrabalhar4."</td><td align='center'>".$marcacapacidadetrabalhar5."</td></tr>";
echo "<tr><td>Criatividade</td><td align='center'>".$marcacriatividade1."</td><td align='center'>".$marcacriatividade2."</td><td align='center'>".$marcacriatividade3."</td><td align='center'>".$marcacriatividade4."</td><td align='center'>".$marcacriatividade5."</td></tr>";
echo "<tr><td>Curiosidade, interesse</td><td align='center'>".$marcacuriosidade1."</td><td align='center'>".$marcacuriosidade2."</td><td align='center'>".$marcacuriosidade3."</td><td align='center'>".$marcacuriosidade4."</td><td align='center'>".$marcacuriosidade5."</td></tr>";
echo "<tr><td>Esforço, persistência</td><td align='center'>".$marcaesforco1."</td><td align='center'>".$marcaesforco2."</td><td align='center'>".$marcaesforco3."</td><td align='center'>".$marcaesforco4."</td><td align='center'>".$marcaesforco5."</td></tr>";
echo "<tr><td>Expressão escrita</td><td align='center'>".$marcaexpressaoescrita1."</td><td align='center'>".$marcaexpressaoescrita2."</td><td align='center'>".$marcaexpressaoescrita3."</td><td align='center'>".$marcaexpressaoescrita4."</td><td align='center'>".$marcaexpressaoescrita5."</td></tr>";
echo "<tr><td>Expressão oral</td><td align='center'>".$marcaexpressaooral1."</td><td align='center'>".$marcaexpressaooral2."</td><td align='center'>".$marcaexpressaooral3."</td><td align='center'>".$marcaexpressaooral4."</td><td align='center'>".$marcaexpressaooral5."</td></tr>";
echo "<tr><td>Relacionamento com colegas</td><td align='center'>".$marcarelacionamento1."</td><td align='center'>".$marcarelacionamento2."</td><td align='center'>".$marcarelacionamento3."</td><td align='center'>".$marcarelacionamento4."</td><td align='center'>".$marcarelacionamento5."</td></tr>";
echo "</table>";


echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";
$marcacomoaluno1 ="";
$marcacomoaluno2 ="";
$marcacomoaluno3 ="";
$marcacomoaluno4 ="";
$marcacomoaluno5 ="";
if ($formu1['comoaluno']==1) {
$marcacomoaluno1 = "X";
}
elseif ($formu1['comoaluno']==2) {
$marcacomoaluno2 = "X";
}
elseif ($formu1['comoaluno']==3) {
$marcacomoaluno3 = "X";
}elseif ($formu1['comoaluno']==4) {
$marcacomoaluno4 = "X";
}
elseif ($formu1['comoaluno']=="naoinfo") {
$marcacomoaluno5 = "X";
}

$marcacomoorientando1 ="";
$marcacomoorientando2 ="";
$marcacomoorientando3 ="";
$marcacomoorientando4 ="";
$marcacomoorientando5 ="";
if ($formu1['comoorientando']==1) {
	$marcacomoorientando1 = "X";
}
elseif ($formu1['comoorientando']==2) {
	$marcacomoorientando2 = "X";
}
elseif ($formu1['comoorientando']==3) {
	$marcacomoorientando3 = "X";
}elseif ($formu1['comoorientando']==4) {
	$marcacomoorientando4 = "X";
}
elseif ($formu1['comoorientando']=="naoinfo") {
	$marcacomoorientando5 = "X";
}

echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>5% melhores</th><th>10% melhores</th><th>25% melhores</th><th>50% melhores</th><th>Não sabe</th></tr>";
echo "<tr><td>Como aluno, em aulas</td><td align='center'>".$marcacomoaluno1."</td><td align='center'>".$marcacomoaluno2."</td><td align='center'>".$marcacomoaluno3."</td><td align='center'>".$marcacomoaluno4."</td><td align='center'>".$marcacomoaluno5."</td></tr>";
echo "<tr><td>Como orientando</td><td align='center'>".$marcacomoorientando1."</td><td align='center'>".$marcacomoorientando2."</td><td align='center'>".$marcacomoorientando3."</td><td align='center'>".$marcacomoorientando4."</td><td align='center'>".$marcacomoorientando5."</td></tr>";
echo "</table>";
echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".$formu3['instituicaorecomendante'];
echo "<br> Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante'];
echo "<br> Área: ".ucwords(strtolower($formu3['arearecomendante']));
echo "<br> Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante'];
echo "<br> Instituição de obtenção deste grau: ".$formu3['instobtencaorecomendante'];
echo "<br> Endereço institucional do recomendante: ".$formu3['enderecorecomendante'];


echo "<h4>Segunda Carta de recomendação</h4>";

$query_pega_idprof2 = pg_query("select coduser from inscricao_pos_login where login='".stripslashes(strtolower($cadas3['emailprofrecomendante2']))."'  ");
$coduser2=pg_fetch_row($query_pega_idprof2);
$id_prof2=$coduser2[0];

echo "Código Identificador: ".$id_prof2;
echo "<br> Nome do Recomendante: ".ucwords(strtolower($cadas3['nomeprofrecomendante2']));

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof2."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof2."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];
echo "<br> Avaliações:";

$marcadesempenhoacademico1 ="";
$marcadesempenhoacademico2 ="";
$marcadesempenhoacademico3 ="";
$marcadesempenhoacademico4 ="";
$marcadesempenhoacademico5 ="";
if ($formu1['desempenhoacademico']==1) {
	$marcadesempenhoacademico1 = "X";
}
elseif ($formu1['desempenhoacademico']==2) {
	$marcadesempenhoacademico2 = "X";
}
elseif ($formu1['desempenhoacademico']==3) {
	$marcadesempenhoacademico3 = "X";
}elseif ($formu1['desempenhoacademico']==4) {
	$marcadesempenhoacademico4 = "X";
}
elseif ($formu1['desempenhoacademico']=="naoinfo") {
	$marcadesempenhoacademico5 = "X";
}

$marcacapacidadeaprender1 ="";
$marcacapacidadeaprender2 ="";
$marcacapacidadeaprender3 ="";
$marcacapacidadeaprender4 ="";
$marcacapacidadeaprender5 ="";
if ($formu1['capacidadeaprender']==1) {
	$marcacapacidadeaprender1 = "X";
}
elseif ($formu1['capacidadeaprender']==2) {
	$marcacapacidadeaprender2 = "X";
}
elseif ($formu1['capacidadeaprender']==3) {
	$marcacapacidadeaprender3 = "X";
}elseif ($formu1['capacidadeaprender']==4) {
	$marcacapacidadeaprender4 = "X";
}
elseif ($formu1['capacidadeaprender']=="naoinfo") {
	$marcacapacidadeaprender5 = "X";
}

$marcacapacidadetrabalhar1 ="";
$marcacapacidadetrabalhar2 ="";
$marcacapacidadetrabalhar3 ="";
$marcacapacidadetrabalhar4 ="";
$marcacapacidadetrabalhar5 ="";
if ($formu1['capacidadetrabalhar']==1) {
	$marcacapacidadetrabalhar1 = "X";
}
elseif ($formu1['capacidadetrabalhar']==2) {
	$marcacapacidadetrabalhar2 = "X";
}
elseif ($formu1['capacidadetrabalhar']==3) {
	$marcacapacidadetrabalhar3 = "X";
}elseif ($formu1['capacidadetrabalhar']==4) {
	$marcacapacidadetrabalhar4 = "X";
}
elseif ($formu1['capacidadetrabalhar']=="naoinfo") {
	$marcacapacidadetrabalhar5 = "X";
}

$marcacriatividade1 ="";
$marcacriatividade2 ="";
$marcacriatividade3 ="";
$marcacriatividade4 ="";
$marcacriatividade5 ="";
if ($formu1['criatividade']==1) {
	$marcacriatividade1 = "X";
}
elseif ($formu1['criatividade']==2) {
	$marcacriatividade2 = "X";
}
elseif ($formu1['criatividade']==3) {
	$marcacriatividade3 = "X";
}elseif ($formu1['criatividade']==4) {
	$marcacriatividade4 = "X";
}
elseif ($formu1['criatividade']=="naoinfo") {
	$marcacriatividade5 = "X";
}

$marcacuriosidade1 ="";
$marcacuriosidade2 ="";
$marcacuriosidade3 ="";
$marcacuriosidade4 ="";
$marcacuriosidade5 ="";
if ($formu1['curiosidade']==1) {
	$marcacuriosidade1 = "X";
}
elseif ($formu1['curiosidade']==2) {
	$marcacuriosidade2 = "X";
}
elseif ($formu1['curiosidade']==3) {
	$marcacuriosidade3 = "X";
}elseif ($formu1['curiosidade']==4) {
	$marcacuriosidade4 = "X";
}
elseif ($formu1['curiosidade']=="naoinfo") {
	$marcacuriosidade5 = "X";
}

$marcaesforco1 ="";
$marcaesforco2 ="";
$marcaesforco3 ="";
$marcaesforco4 ="";
$marcaesforco5 ="";
if ($formu1['esforco']==1) {
	$marcaesforco1 = "X";
}
elseif ($formu1['esforco']==2) {
	$marcaesforco2 = "X";
}
elseif ($formu1['esforco']==3) {
	$marcaesforco3 = "X";
}elseif ($formu1['esforco']==4) {
	$marcaesforco4 = "X";
}
elseif ($formu1['esforco']=="naoinfo") {
	$marcaesforco5 = "X";
}

$marcaexpressaoescrita1 ="";
$marcaexpressaoescrita2 ="";
$marcaexpressaoescrita3 ="";
$marcaexpressaoescrita4 ="";
$marcaexpressaoescrita5 ="";
if ($formu1['expressaoescrita']==1) {
	$marcaexpressaoescrita1 = "X";
}
elseif ($formu1['expressaoescrita']==2) {
	$marcaexpressaoescrita2 = "X";
}
elseif ($formu1['expressaoescrita']==3) {
	$marcaexpressaoescrita3 = "X";
}elseif ($formu1['expressaoescrita']==4) {
	$marcaexpressaoescrita4 = "X";
}
elseif ($formu1['expressaoescrita']=="naoinfo") {
	$marcaexpressaoescrita5 = "X";
}

$marcaexpressaooral1 ="";
$marcaexpressaooral2 ="";
$marcaexpressaooral3 ="";
$marcaexpressaooral4 ="";
$marcaexpressaooral5 ="";
if ($formu1['expressaooral']==1) {
	$marcaexpressaooral1 = "X";
}
elseif ($formu1['expressaooral']==2) {
	$marcaexpressaooral2 = "X";
}
elseif ($formu1['expressaooral']==3) {
	$marcaexpressaooral3 = "X";
}elseif ($formu1['expressaooral']==4) {
	$marcaexpressaooral4 = "X";
}
elseif ($formu1['expressaooral']=="naoinfo") {
	$marcaexpressaooral5 = "X";
}

$marcarelacionamento1 ="";
$marcarelacionamento2 ="";
$marcarelacionamento3 ="";
$marcarelacionamento4 ="";
$marcarelacionamento5 ="";
if ($formu1['relacionamento']==1) {
	$marcarelacionamento1 = "X";
}
elseif ($formu1['relacionamento']==2) {
	$marcarelacionamento2 = "X";
}
elseif ($formu1['relacionamento']==3) {
	$marcarelacionamento3 = "X";
}elseif ($formu1['relacionamento']==4) {
	$marcarelacionamento4 = "X";
}
elseif ($formu1['relacionamento']=="naoinfo") {
	$marcarelacionamento5 = "X";
}

echo "<style type='text/css'>";
echo "table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}";
echo "table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:center;}";
echo "table.tftable tr {background-color:#d4e3e5;}";
echo "table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}";
echo "</style>";
echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>Excelente</th><th>Bom</th><th>Regular</th><th>Insuficiente</th><th>Não sabe</th></tr>";
echo "<tr><td>Desempenho acadêmico</td><td align='center'>".$marcadesempenhoacademico1."</td><td align='center'>".$marcadesempenhoacademico2."</td><td align='center'>".$marcadesempenhoacademico3."</td><td align='center'>".$marcadesempenhoacademico4."</td><td align='center'>".$marcadesempenhoacademico5."</td></tr>";
echo "<tr><td>Capacidade de aprender novos conceitos</td><td align='center'>".$marcacapacidadeaprender1."</td><td align='center'>".$marcacapacidadeaprender2."</td><td align='center'>".$marcacapacidadeaprender3."</td><td align='center'>".$marcacapacidadeaprender4."</td><td align='center'>".$marcacapacidadeaprender5."</td></tr>";
echo "<tr><td>Capacidade de trabalhar sozinho</td><td align='center'>".$marcacapacidadetrabalhar1."</td><td align='center'>".$marcacapacidadetrabalhar2."</td><td align='center'>".$marcacapacidadetrabalhar3."</td><td align='center'>".$marcacapacidadetrabalhar4."</td><td align='center'>".$marcacapacidadetrabalhar5."</td></tr>";
echo "<tr><td>Criatividade</td><td align='center'>".$marcacriatividade1."</td><td align='center'>".$marcacriatividade2."</td><td align='center'>".$marcacriatividade3."</td><td align='center'>".$marcacriatividade4."</td><td align='center'>".$marcacriatividade5."</td></tr>";
echo "<tr><td>Curiosidade, interesse</td><td align='center'>".$marcacuriosidade1."</td><td align='center'>".$marcacuriosidade2."</td><td align='center'>".$marcacuriosidade3."</td><td align='center'>".$marcacuriosidade4."</td><td align='center'>".$marcacuriosidade5."</td></tr>";
echo "<tr><td>Esforço, persistência</td><td align='center'>".$marcaesforco1."</td><td align='center'>".$marcaesforco2."</td><td align='center'>".$marcaesforco3."</td><td align='center'>".$marcaesforco4."</td><td align='center'>".$marcaesforco5."</td></tr>";
echo "<tr><td>Expressão escrita</td><td align='center'>".$marcaexpressaoescrita1."</td><td align='center'>".$marcaexpressaoescrita2."</td><td align='center'>".$marcaexpressaoescrita3."</td><td align='center'>".$marcaexpressaoescrita4."</td><td align='center'>".$marcaexpressaoescrita5."</td></tr>";
echo "<tr><td>Expressão oral</td><td align='center'>".$marcaexpressaooral1."</td><td align='center'>".$marcaexpressaooral2."</td><td align='center'>".$marcaexpressaooral3."</td><td align='center'>".$marcaexpressaooral4."</td><td align='center'>".$marcaexpressaooral5."</td></tr>";
echo "<tr><td>Relacionamento com colegas</td><td align='center'>".$marcarelacionamento1."</td><td align='center'>".$marcarelacionamento2."</td><td align='center'>".$marcarelacionamento3."</td><td align='center'>".$marcarelacionamento4."</td><td align='center'>".$marcarelacionamento5."</td></tr>";
echo "</table>";

echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";

$marcacomoaluno1 ="";
$marcacomoaluno2 ="";
$marcacomoaluno3 ="";
$marcacomoaluno4 ="";
$marcacomoaluno5 ="";
if ($formu1['comoaluno']==1) {
$marcacomoaluno1 = "X";
}
elseif ($formu1['comoaluno']==2) {
$marcacomoaluno2 = "X";
}
elseif ($formu1['comoaluno']==3) {
$marcacomoaluno3 = "X";
}elseif ($formu1['comoaluno']==4) {
$marcacomoaluno4 = "X";
}
elseif ($formu1['comoaluno']=="naoinfo") {
$marcacomoaluno5 = "X";
}

$marcacomoorientando1 ="";
$marcacomoorientando2 ="";
$marcacomoorientando3 ="";
$marcacomoorientando4 ="";
$marcacomoorientando5 ="";
if ($formu1['comoorientando']==1) {
	$marcacomoorientando1 = "X";
}
elseif ($formu1['comoorientando']==2) {
	$marcacomoorientando2 = "X";
}
elseif ($formu1['comoorientando']==3) {
	$marcacomoorientando3 = "X";
}elseif ($formu1['comoorientando']==4) {
	$marcacomoorientando4 = "X";
}
elseif ($formu1['comoorientando']=="naoinfo") {
	$marcacomoorientando5 = "X";
}

echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>5% melhores</th><th>10% melhores</th><th>25% melhores</th><th>50% melhores</th><th>Não sabe</th></tr>";
echo "<tr><td>Como aluno, em aulas</td><td align='center'>".$marcacomoaluno1."</td><td align='center'>".$marcacomoaluno2."</td><td align='center'>".$marcacomoaluno3."</td><td align='center'>".$marcacomoaluno4."</td><td align='center'>".$marcacomoaluno5."</td></tr>";
echo "<tr><td>Como orientando</td><td align='center'>".$marcacomoorientando1."</td><td align='center'>".$marcacomoorientando2."</td><td align='center'>".$marcacomoorientando3."</td><td align='center'>".$marcacomoorientando4."</td><td align='center'>".$marcacomoorientando5."</td></tr>";
echo "</table>";
echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".$formu3['instituicaorecomendante'];
echo "<br> Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante'];
echo "<br> Área: ".ucwords(strtr(strtolower($formu3['arearecomendante']),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ"));
echo "<br> Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante'];
echo "<br> Instituição de obtenção deste grau: ".$formu3['instobtencaorecomendante'];
echo "<br> Endereço institucional do recomendante: ".$formu3['enderecorecomendante'];


echo "<h4>Terceira Carta de recomendação</h4>";

$query_pega_idprof3 = pg_query("select coduser from inscricao_pos_login where login='".stripslashes(strtolower($cadas3['emailprofrecomendante3']))."'  ");
$coduser3=pg_fetch_row($query_pega_idprof3);
$id_prof3=$coduser3[0];

echo "Código Identificador: ".$id_prof3;
echo "<br> Nome do Recomendante: ".ucwords(strtolower($cadas3['nomeprofrecomendante3']));

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof3."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof3."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];
echo "<br> Avaliações:";

$marcadesempenhoacademico1 ="";
$marcadesempenhoacademico2 ="";
$marcadesempenhoacademico3 ="";
$marcadesempenhoacademico4 ="";
$marcadesempenhoacademico5 ="";
if ($formu1['desempenhoacademico']==1) {
	$marcadesempenhoacademico1 = "X";
}
elseif ($formu1['desempenhoacademico']==2) {
	$marcadesempenhoacademico2 = "X";
}
elseif ($formu1['desempenhoacademico']==3) {
	$marcadesempenhoacademico3 = "X";
}elseif ($formu1['desempenhoacademico']==4) {
	$marcadesempenhoacademico4 = "X";
}
elseif ($formu1['desempenhoacademico']=="naoinfo") {
	$marcadesempenhoacademico5 = "X";
}

$marcacapacidadeaprender1 ="";
$marcacapacidadeaprender2 ="";
$marcacapacidadeaprender3 ="";
$marcacapacidadeaprender4 ="";
$marcacapacidadeaprender5 ="";
if ($formu1['capacidadeaprender']==1) {
	$marcacapacidadeaprender1 = "X";
}
elseif ($formu1['capacidadeaprender']==2) {
	$marcacapacidadeaprender2 = "X";
}
elseif ($formu1['capacidadeaprender']==3) {
	$marcacapacidadeaprender3 = "X";
}elseif ($formu1['capacidadeaprender']==4) {
	$marcacapacidadeaprender4 = "X";
}
elseif ($formu1['capacidadeaprender']=="naoinfo") {
	$marcacapacidadeaprender5 = "X";
}

$marcacapacidadetrabalhar1 ="";
$marcacapacidadetrabalhar2 ="";
$marcacapacidadetrabalhar3 ="";
$marcacapacidadetrabalhar4 ="";
$marcacapacidadetrabalhar5 ="";
if ($formu1['capacidadetrabalhar']==1) {
	$marcacapacidadetrabalhar1 = "X";
}
elseif ($formu1['capacidadetrabalhar']==2) {
	$marcacapacidadetrabalhar2 = "X";
}
elseif ($formu1['capacidadetrabalhar']==3) {
	$marcacapacidadetrabalhar3 = "X";
}elseif ($formu1['capacidadetrabalhar']==4) {
	$marcacapacidadetrabalhar4 = "X";
}
elseif ($formu1['capacidadetrabalhar']=="naoinfo") {
	$marcacapacidadetrabalhar5 = "X";
}

$marcacriatividade1 ="";
$marcacriatividade2 ="";
$marcacriatividade3 ="";
$marcacriatividade4 ="";
$marcacriatividade5 ="";
if ($formu1['criatividade']==1) {
	$marcacriatividade1 = "X";
}
elseif ($formu1['criatividade']==2) {
	$marcacriatividade2 = "X";
}
elseif ($formu1['criatividade']==3) {
	$marcacriatividade3 = "X";
}elseif ($formu1['criatividade']==4) {
	$marcacriatividade4 = "X";
}
elseif ($formu1['criatividade']=="naoinfo") {
	$marcacriatividade5 = "X";
}

$marcacuriosidade1 ="";
$marcacuriosidade2 ="";
$marcacuriosidade3 ="";
$marcacuriosidade4 ="";
$marcacuriosidade5 ="";
if ($formu1['curiosidade']==1) {
	$marcacuriosidade1 = "X";
}
elseif ($formu1['curiosidade']==2) {
	$marcacuriosidade2 = "X";
}
elseif ($formu1['curiosidade']==3) {
	$marcacuriosidade3 = "X";
}elseif ($formu1['curiosidade']==4) {
	$marcacuriosidade4 = "X";
}
elseif ($formu1['curiosidade']=="naoinfo") {
	$marcacuriosidade5 = "X";
}

$marcaesforco1 ="";
$marcaesforco2 ="";
$marcaesforco3 ="";
$marcaesforco4 ="";
$marcaesforco5 ="";
if ($formu1['esforco']==1) {
	$marcaesforco1 = "X";
}
elseif ($formu1['esforco']==2) {
	$marcaesforco2 = "X";
}
elseif ($formu1['esforco']==3) {
	$marcaesforco3 = "X";
}elseif ($formu1['esforco']==4) {
	$marcaesforco4 = "X";
}
elseif ($formu1['esforco']=="naoinfo") {
	$marcaesforco5 = "X";
}

$marcaexpressaoescrita1 ="";
$marcaexpressaoescrita2 ="";
$marcaexpressaoescrita3 ="";
$marcaexpressaoescrita4 ="";
$marcaexpressaoescrita5 ="";
if ($formu1['expressaoescrita']==1) {
	$marcaexpressaoescrita1 = "X";
}
elseif ($formu1['expressaoescrita']==2) {
	$marcaexpressaoescrita2 = "X";
}
elseif ($formu1['expressaoescrita']==3) {
	$marcaexpressaoescrita3 = "X";
}elseif ($formu1['expressaoescrita']==4) {
	$marcaexpressaoescrita4 = "X";
}
elseif ($formu1['expressaoescrita']=="naoinfo") {
	$marcaexpressaoescrita5 = "X";
}

$marcaexpressaooral1 ="";
$marcaexpressaooral2 ="";
$marcaexpressaooral3 ="";
$marcaexpressaooral4 ="";
$marcaexpressaooral5 ="";
if ($formu1['expressaooral']==1) {
	$marcaexpressaooral1 = "X";
}
elseif ($formu1['expressaooral']==2) {
	$marcaexpressaooral2 = "X";
}
elseif ($formu1['expressaooral']==3) {
	$marcaexpressaooral3 = "X";
}elseif ($formu1['expressaooral']==4) {
	$marcaexpressaooral4 = "X";
}
elseif ($formu1['expressaooral']=="naoinfo") {
	$marcaexpressaooral5 = "X";
}

$marcarelacionamento1 ="";
$marcarelacionamento2 ="";
$marcarelacionamento3 ="";
$marcarelacionamento4 ="";
$marcarelacionamento5 ="";
if ($formu1['relacionamento']==1) {
	$marcarelacionamento1 = "X";
}
elseif ($formu1['relacionamento']==2) {
	$marcarelacionamento2 = "X";
}
elseif ($formu1['relacionamento']==3) {
	$marcarelacionamento3 = "X";
}elseif ($formu1['relacionamento']==4) {
	$marcarelacionamento4 = "X";
}
elseif ($formu1['relacionamento']=="naoinfo") {
	$marcarelacionamento5 = "X";
}


echo "<style type='text/css'>";
echo "table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}";
echo "table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:center;}";
echo "table.tftable tr {background-color:#d4e3e5;}";
echo "table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}";
echo "</style>";
echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>Excelente</th><th>Bom</th><th>Regular</th><th>Insuficiente</th><th>Não sabe</th></tr>";
echo "<tr><td>Desempenho acadêmico</td><td align='center'>".$marcadesempenhoacademico1."</td><td align='center'>".$marcadesempenhoacademico2."</td><td align='center'>".$marcadesempenhoacademico3."</td><td align='center'>".$marcadesempenhoacademico4."</td><td align='center'>".$marcadesempenhoacademico5."</td></tr>";
echo "<tr><td>Capacidade de aprender novos conceitos</td><td align='center'>".$marcacapacidadeaprender1."</td><td align='center'>".$marcacapacidadeaprender2."</td><td align='center'>".$marcacapacidadeaprender3."</td><td align='center'>".$marcacapacidadeaprender4."</td><td align='center'>".$marcacapacidadeaprender5."</td></tr>";
echo "<tr><td>Capacidade de trabalhar sozinho</td><td align='center'>".$marcacapacidadetrabalhar1."</td><td align='center'>".$marcacapacidadetrabalhar2."</td><td align='center'>".$marcacapacidadetrabalhar3."</td><td align='center'>".$marcacapacidadetrabalhar4."</td><td align='center'>".$marcacapacidadetrabalhar5."</td></tr>";
echo "<tr><td>Criatividade</td><td align='center'>".$marcacriatividade1."</td><td align='center'>".$marcacriatividade2."</td><td align='center'>".$marcacriatividade3."</td><td align='center'>".$marcacriatividade4."</td><td align='center'>".$marcacriatividade5."</td></tr>";
echo "<tr><td>Curiosidade, interesse</td><td align='center'>".$marcacuriosidade1."</td><td align='center'>".$marcacuriosidade2."</td><td align='center'>".$marcacuriosidade3."</td><td align='center'>".$marcacuriosidade4."</td><td align='center'>".$marcacuriosidade5."</td></tr>";
echo "<tr><td>Esforço, persistência</td><td align='center'>".$marcaesforco1."</td><td align='center'>".$marcaesforco2."</td><td align='center'>".$marcaesforco3."</td><td align='center'>".$marcaesforco4."</td><td align='center'>".$marcaesforco5."</td></tr>";
echo "<tr><td>Expressão escrita</td><td align='center'>".$marcaexpressaoescrita1."</td><td align='center'>".$marcaexpressaoescrita2."</td><td align='center'>".$marcaexpressaoescrita3."</td><td align='center'>".$marcaexpressaoescrita4."</td><td align='center'>".$marcaexpressaoescrita5."</td></tr>";
echo "<tr><td>Expressão oral</td><td align='center'>".$marcaexpressaooral1."</td><td align='center'>".$marcaexpressaooral2."</td><td align='center'>".$marcaexpressaooral3."</td><td align='center'>".$marcaexpressaooral4."</td><td align='center'>".$marcaexpressaooral5."</td></tr>";
echo "<tr><td>Relacionamento com colegas</td><td align='center'>".$marcarelacionamento1."</td><td align='center'>".$marcarelacionamento2."</td><td align='center'>".$marcarelacionamento3."</td><td align='center'>".$marcarelacionamento4."</td><td align='center'>".$marcarelacionamento5."</td></tr>";
echo "</table>";


echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";

$marcacomoaluno1 ="";
$marcacomoaluno2 ="";
$marcacomoaluno3 ="";
$marcacomoaluno4 ="";
$marcacomoaluno5 ="";
if ($formu1['comoaluno']==1) {
$marcacomoaluno1 = "X";
}
elseif ($formu1['comoaluno']==2) {
$marcacomoaluno2 = "X";
}
elseif ($formu1['comoaluno']==3) {
$marcacomoaluno3 = "X";
}elseif ($formu1['comoaluno']==4) {
$marcacomoaluno4 = "X";
}
elseif ($formu1['comoaluno']=="naoinfo") {
$marcacomoaluno5 = "X";
}

$marcacomoorientando1 ="";
$marcacomoorientando2 ="";
$marcacomoorientando3 ="";
$marcacomoorientando4 ="";
$marcacomoorientando5 ="";
if ($formu1['comoorientando']==1) {
	$marcacomoorientando1 = "X";
}
elseif ($formu1['comoorientando']==2) {
	$marcacomoorientando2 = "X";
}
elseif ($formu1['comoorientando']==3) {
	$marcacomoorientando3 = "X";
}elseif ($formu1['comoorientando']==4) {
	$marcacomoorientando4 = "X";
}
elseif ($formu1['comoorientando']=="naoinfo") {
	$marcacomoorientando5 = "X";
}
echo "<table id='tfhover' class='tftable' border='1'>"; 
echo "<tr><th></th><th>5% melhores</th><th>10% melhores</th><th>25% melhores</th><th>50% melhores</th><th>Não sabe</th></tr>";
echo "<tr><td>Como aluno, em aulas</td><td align='center'>".$marcacomoaluno1."</td><td align='center'>".$marcacomoaluno2."</td><td align='center'>".$marcacomoaluno3."</td><td align='center'>".$marcacomoaluno4."</td><td align='center'>".$marcacomoaluno5."</td></tr>";
echo "<tr><td>Como orientando</td><td align='center'>".$marcacomoorientando1."</td><td align='center'>".$marcacomoorientando2."</td><td align='center'>".$marcacomoorientando3."</td><td align='center'>".$marcacomoorientando4."</td><td align='center'>".$marcacomoorientando5."</td></tr>";
echo "</table>";
echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".ucwords(strtolower($formu3['instituicaorecomendante']));
echo "<br> Grau acadêmico mais alto obtido: ".ucwords(strtolower($formu3['titulacaorecomendante']));
echo "<br> Área: ".ucwords(strtolower($formu3['arearecomendante']));
echo "<br> Ano de obtenção deste grau: ".ucwords(strtolower($formu3['anoobtencaorecomendante']));
echo "<br> Instituição de obtenção deste grau: ".ucwords(strtolower($formu3['instobtencaorecomendante']));
echo "<br> Endereço institucional do recomendante: ".ucwords(strtolower($formu3['enderecorecomendante']));

//ucwords(strtolower($cadas3['nomeprofrecomendante3']))
echo "<h4>Documentos anexados</h4>";

//$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."' order by data DESC");

$query_arquivos=pg_query("SELECT  distinct * from inscricao_pos_anexos where data = (select max(data) from inscricao_pos_anexos where coduser = '".$coduser."') and coduser = '".$coduser."' limit 2");
//$query_arquivos=pg_query("SELECT  * from inscricao_pos_anexos where data = (select max(data) from inscricao_pos_anexos where coduser = '".$coduser."') and coduser = '".$coduser."'");
while($registro=pg_fetch_row($query_arquivos)){
if ($registro[2]!=""){
					$ext = pathinfo($registro[2], PATHINFO_EXTENSION);
					if ($ext =="pdf"){
						echo "<br> <a href='../../upload/$registro[2]'>$registro[2]</a>";
					}
		
					else{ if ( ($ext=="jpeg") or ($ext=="jpg") or ($ext=="png") ){ 
								 echo "<br> <a href='../../upload/$registro[2]'>$registro[2]</a>";
							}
					} 

				}else{ echo "Faltam documentos obrigatórios.";}

}

echo "<hr>";
}
}
?>
</body>
</html>
