<html>
  <head>
    <meta charset="utf-8">
    <title>Relatório de Inscritos</title>

    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body>

<?php

include_once("../pgsql/pgsql.php"); 
include_once("../config/config.php");


// Gerando a lista de codusers a partir da tabela finaliza

$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='$edital_atual' and coduser <> '110' and coduser <> '592'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
//var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){

$j = $i +1;
echo "Inscrição: ".$j;

		$coduser=$tab_coduser[$i]['coduser'];
		//$coduser="469";

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

$estaoemissao = explode("_",$cadas1['estadoemissaoid']);
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
Orgão emissor: ".$cadas1['id_emissor']." Estado: ".$cadas1['estadoemissaoid']." Data de emissão:".$cadas1['diaemissaoid'].
"/".$cadas1['mesemissaoid']."/".$cadas1['anoemissaoid'];

echo "<h4>Grau acadêmico mais alto obtido</h4>";

echo "Curso: ".ucwords(strtolower($cadas2['instrucaocurso']))." Grau: ".ucwords(strtolower($cadas2['instrucaograu'])).
" Instituição: ".ucwords(strtolower($cadas2['instrucaoinstituicao']));
echo "<br> Ano de Conclusão ou Previsão: ".$cadas2['instrucaoanoconclusao'];
echo "<br> Experiência Profissional mais recente.
Tem experiência: ".$cadas2['experienciatipo1']." ".$cadas2['experienciatipo2']." Instituição: ".ucwords(strtolower($cadas2['experienciainstituicao']))."
Período - início: ".$cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano'].
" fim: ".$cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano'];

echo "<h4>Programa</h4>";

echo "Programa Pretendido: ".$cadas3['programa'] ;
if ($cadas2['cursopos']=="Doutorado") {
	if ($cadas2['areadoutorado']=="" or $cadas2['areadoutorado']=="0" or $cadas2['areadoutorado']=="nselecionado") {
		}else{
			echo " Área: ".$cadas2['areadoutorado'];
		}
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

$query_pega_idprof1 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante1']."'  ");
$coduser1=pg_fetch_row($query_pega_idprof1);
$id_prof1=$coduser1[0];

echo "Código Identificador: ".$id_prof1;

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof1."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];

echo "<br>";

echo "<br> Avaliações: 1) Excelente, 2) Bom, 3) Regular, 4) Insuficiente, ?) Não sabe.";
echo "<br> Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico'];
echo "<br> Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender'];
echo "<br> Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar'];
echo "<br> Criatividade (Creativity): ".$formu1['criatividade'];
echo "<br> Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade'];
echo "<br> Esforço, persistência (Effort, persistence): ".$formu1['esforco'];
echo "<br> Expressão escrita (Written expression): ".$formu1['expressaoescrita'];
echo "<br> Expressão oral (Oral expression): ".$formu1['expressaooral'];
echo "<br> Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento'];

echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";
echo "<br> 1) 5% melhores, 2) 10% melhores, 3) 25% melhores, 4) 50% melhores, ?) Não sabe (Don’t know)";
echo "<br> Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno'];
echo "<br> Como orientando (During advisory): ".$formu1['comoorientando'];

echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".$formu3['instituicaorecomendante'];
echo "<br> Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante'];
echo "<br> Área: ".$formu3['arearecomendante'];
echo "<br> Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante'];
echo "<br> Instituição de obtenção deste grau: ".$formu3['instobtencaorecomendante'];
echo "<br> Endereço institucional do recomendante: ".$formu3['enderecorecomendante'];


echo "<h4>Segunda Carta de recomendação</h4>";

$query_pega_idprof2 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante2']."'  ");
$coduser2=pg_fetch_row($query_pega_idprof2);
$id_prof2=$coduser2[0];

echo "Código Identificador: ".$id_prof2;

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof2."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof2."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];
echo "<br> Avaliações: 1) Excelente, 2) Bom, 3) Regular, 4) Insuficiente, ?) Não sabe.";

echo "<br>";

echo "<br> Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico'];
echo "<br> Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender'];
echo "<br> Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar'];
echo "<br> Criatividade (Creativity): ".$formu1['criatividade'];
echo "<br> Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade'];
echo "<br> Esforço, persistência (Effort, persistence): ".$formu1['esforco'];
echo "<br> Expressão escrita (Written expression): ".$formu1['expressaoescrita'];
echo "<br> Expressão oral (Oral expression): ".$formu1['expressaooral'];
echo "<br> Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento'];

echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";
echo "<br> 1) 5% melhores, 2) 10% melhores, 3) 25% melhores, 4) 50% melhores, ?) Não sabe (Don’t know)";
echo "<br> Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno'];
echo "<br> Como orientando (During advisory): ".$formu1['comoorientando'];

echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".$formu3['instituicaorecomendante'];
echo "<br> Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante'];
echo "<br> Área: ".$formu3['arearecomendante'];
echo "<br> Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante'];
echo "<br> Instituição de obtenção deste grau: ".$formu3['instobtencaorecomendante'];
echo "<br> Endereço institucional do recomendante: ".$formu3['enderecorecomendante'];


echo "<h4>Terceira Carta de recomendação</h4>";

$query_pega_idprof3 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante3']."'  ");
$coduser3=pg_fetch_row($query_pega_idprof3);
$id_prof3=$coduser3[0];

echo "Código Identificador: ".$id_prof3;

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof3."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof3."'");
$formu3 = pg_fetch_assoc($query_formu3);


echo "<br> Conhece-o candidato há quanto tempo (For how long have you known the applicant)? ".$formu1['tempoconhececandidato'];
echo "<br> Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']." ".$formu1['circunstancia2'].
" ".$formu1['circunstancia3']." ".$formu1['circunstancia4'];
echo "<br> Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra'];
echo "<br> Avaliações: 1) Excelente, 2) Bom, 3) Regular, 4) Insuficiente, ?) Não sabe.";

echo "<br>";

echo "<br> Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico'];
echo "<br> Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender'];
echo "<br> Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar'];
echo "<br> Criatividade (Creativity): ".$formu1['criatividade'];
echo "<br> Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade'];
echo "<br> Esforço, persistência (Effort, persistence): ".$formu1['esforco'];
echo "<br> Expressão escrita (Written expression): ".$formu1['expressaoescrita'];
echo "<br> Expressão oral (Oral expression): ".$formu1['expressaooral'];
echo "<br> Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento'];

echo "<br>";

echo "<br> Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato: ".$formu1['antecedentesacademicos'];
echo "<br> Opinião sobre seu possível aproveitamento, se aceito no Programa: ".$formu1['possivelaproveitamento'];
echo "<br> Outras informações relevantes: ".$formu1['informacoesrelevantes'];
echo "<br> Entre os estudantes que já conheceu, você diria que o candidato está entre os:";
echo "<br> 1) 5% melhores, 2) 10% melhores, 3) 25% melhores, 4) 50% melhores, ?) Não sabe (Don’t know)";
echo "<br> Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno'];
echo "<br> Como orientando (During advisory): ".$formu1['comoorientando'];

echo "<br>";

echo "<br> Dados Recomendante";
echo "<br> Instituição (Institution): ".$formu3['instituicaorecomendante'];
echo "<br> Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante'];
echo "<br> Área: ".$formu3['arearecomendante'];
echo "<br> Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante'];
echo "<br> Instituição de obtenção deste grau: ".$formu3['instobtencaorecomendante'];
echo "<br> Endereço institucional do recomendante: ".$formu3['enderecorecomendante'];


echo "<h4>Documentos anexados</h4>";

$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."'");

while($registro=pg_fetch_row($query_arquivos)){
if ($registro[2]!=""){
					$ext = pathinfo($registro[2], PATHINFO_EXTENSION);
					if ($ext =="pdf"){
						echo "<br> <a href='../upload/$registro[2]'>$registro[2]</a>";
					}
		
					else{ if ( ($ext=="jpeg") or ($ext=="jpg") or ($ext=="png") ){ 
								 echo "<br> <a href='../upload/$registro[2]'>$registro[2]</a>";
							}
					} 

				}else{ echo "Faltam documentos obrigatórios.";}

}

echo "<hr>";
			
}
?>
</body>
</html>
