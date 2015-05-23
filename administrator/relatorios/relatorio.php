<?php

include_once("../../pgsql/pgsql.php");
include_once("../../config/config.php");
$arquivospdf = array();
$contapdf = 0;
$dir_atual = "edital-".$edital_atual;

$caminho_diretorio = "/home/PAGINAS/WWW/site-mat/inscricoespos/administrator/relatorios/".$dir_atual."/";
// Gerando a lista de codusers a partir da tabela finaliza
//exec("cd ".$caminho_diretorio."; pwd;");	

	if (!file_exists($dir_atual) and !is_dir($dir_atual)) {
    	mkdir($dir_atual, 0777);
    	exec("cp -R base-relatorios/* ".$dir_atual."");
    	exec("chmod 777 ".$dir_atual."");
    	//exec("cd /paginas/WWW/site-mat/inscricoespos/relatorios/edital-2-2014/; pwd; chmod 777 ".$arquivotex.".tex; pdflatex ".$arquivotex."; rm ".$arquivotex." *.log *.aux");
	}
exec("cd ".$caminho_diretorio."/; pwd;");
$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='$edital_atual' and coduser <> '110' and coduser <> '592' and coduser <> '564' and coduser <> '210' and coduser <> '1264' and coduser <> '561' and coduser <> '618' and coduser <> '1434' and coduser <> '1435'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
//var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){
echo "<hr>Inscri&ccedil&atildeo: ".$i."<hr>";

		$coduser=$tab_coduser[$i]['coduser'];
		//$coduser="1512";

		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='".$coduser."' and edital='$edital_atual'");
		$cadas31 = pg_fetch_assoc($query_carta_motivacao);
		
			
			
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
echo "<br> $nome";

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



//$arquivotex = str_replace(' ','',$cadas3['programa'])."-".$coduser."-".$nome;


if ($cadas2['cursopos']=="Doutorado") {
        if ($cadas2['areadoutorado']=="" or $cadas2['areadoutorado']=="0" or $cadas2['areadoutorado']=="nselecionado") {
                }else{
                        $arquivotex = str_replace(' ','',$cadas3['programa'])."-".$cadas2['areadoutorado']."-".$cadas1['ufendereco']."-".$coduser."-".$nome;
                }
}else{
        $arquivotex = str_replace(' ','',$cadas3['programa'])."-".$cadas1['ufendereco']."-".$coduser."-".$nome;
}


// Velho fo funciona na outra pasta $fo = fopen('../ficha_inscricao/'.$arquivotex.'.tex', 'w') or die("Nao foi possivel abrir o arquivo.");
$fo = fopen($dir_atual."/".$arquivotex.'.tex', 'w') or die("Nao foi possivel abrir o arquivo.");

$nome = $cadas1['name']." ".$cadas1['firstname'];


$textotex = "\\documentclass[11pt]{article}
\\usepackage{graphicx,color}
\\usepackage{pdfpages}
\\usepackage[brazil]{babel}
\\usepackage[utf8]{inputenc}
\\addtolength{\\hoffset}{-3cm} \\addtolength{\\textwidth}{6cm}
\\addtolength{\\voffset}{-.5cm} \\addtolength{\\textheight}{1cm}
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  To use Colors 
\\title{\\vspace*{-4cm} Ficha de Inscrição: \\\\";
$textotex .="Cod: ".$coduser."\\ \\ ";
$textotex .= $cadas1['name']." ".$cadas1['firstname'];
$textotex .="\\ \\ - \\ \\ ".$cadas3['programa'];
$textotex .=" 
 }
\\date{}

\\begin{document}
\\maketitle
\\vspace*{-1.5cm}
\\noindent Data de Nascimento:".$cadas1['dianascimento']."/".$cadas1['mesnascimento']."/".$cadas1['anonascimento']."
\\ \\ \\ Idade: ".$idade."   \\ \\ \\ Sexo: ".$cadas1['sexo']."
\\\\
Naturalidade: ".$cadas1['naturalidade']."  
\\ \\ \\  Estado: ".$cadas1['ufnaturalidade']."
\\ \\ \\  Nacionalidade: ".$cadas1['nacionalidade']."
\\ \\ \\ País: ".$cadas1['paisnacionalidade']."
\\\\        
Nome do pai : ".$cadas1['nome_pai']."
\\ \\ \\ Nome da mãe: ".$cadas1['nome_mae']."          
\\\\[0.2cm]                     
\\textbf{Endereço Pessoal} 
\\\\ 
\\noindent Endereço residencial: ".$cadas1['adresse']."
\\\\
        CEP: ".$cadas1['cpendereco']." 
\\ \\ \\ Cidade: ".$cadas1['cityendereco']." 
\\ \\ \\ Estado: ".$cadas1['ufendereco']." 
\\ \\ \\ País: ".$cadas1['country']."
\\\\		
		Telefone comercial : +".$cadas1['ddi_phonework']."(".$cadas1['ddd_phonework'].")".$cadas1['phonework']."
\\ \\ \\ Telefone residencial: +".$cadas1['ddi_phonehome']."(".$cadas1['ddd_phonehome'].")".$cadas1['phonehome']."
\\ \\ \\ Telefone celular : +".$cadas1['ddi_cel']."(".$cadas1['ddd_cel'].")".$cadas1['telcelular']."
\\\\
E-mail principal: ".$cadas1['mail1']."
\\ \\ \\ E-mail alternativo: ".$cadas1['mail2']." 
\\\\[0.2cm] 
\\textbf{Documentos Pessoais}
\\\\
\\noindent Número de CPF : ".$cadas1['cpf']."
\\ \\ \\ Número de Identidade (ou Passaporte para estrangeiros): ".$cadas1['identity']."
\\\\
Orgão emissor: ".$cadas1['id_emissor']."
\\ \\ \\ Estado: ".$cadas1['estadoemissaoid']."
\\ \\ \\ Data de emissão :".$cadas1['diaemissaoid']."/".$cadas1['mesemissaoid']."/".$cadas1['anoemissaoid']."
\\\\[0.3cm]
\\textbf{Grau acadêmico mais alto obtido}
\\\\	
Curso:".$cadas2['instrucaocurso']."
\\ \\ \\ Grau : ".$cadas2['instrucaograu']."
\\ \\ \\ Instituição : ".$cadas2['instrucaoinstituicao']."
\\\\			
Ano de Conclusão ou Previsão: ".$cadas2['instrucaoanoconclusao']."
\\\\ 
Experiência Profissional mais recente. \\ \\  
Tem experiência: ".$cadas2['experienciatipo1']." ".$cadas2['experienciatipo2']."  
\\ \\ \\ Instituição: ".$cadas2['experienciainstituicao']."
\\\\  
Período - início: ".$cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano']."
\\ \\ \\ fim: ".$cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano']."
\\\\[0.2cm] 
\\textbf{Programa Pretendido:} ".$cadas3['programa'];
if ($cadas2['cursopos']=="Doutorado") {
	if ($cadas2['areadoutorado']=="" or $cadas2['areadoutorado']=="0" or $cadas2['areadoutorado']=="nselecionado") {
		}else{
			$textotex .="\\ \\ \\ \\textbf{Área:} ".$cadas2['areadoutorado'];
		}
}
if ($cadas2['cursopos']=="0" or $cadas2['verao']=="sim") {
	$textotex .="\\\\ \\ \\textbf{Curso de Verão:} ".$cadas2['cursoverao'];

}
$textotex .="\\\\
Interesse em bolsa: ".$cadas2['interessebolsa']."
\\\\[0.3cm]		
\\textbf{Dados dos Recomendantes} 
\\\\
1- Nome: ".$cadas3['nomeprofrecomendante1']."
\\ \\ \\ \\  e-mail: ".$cadas3['emailprofrecomendante1']." 
\\\\
2- Nome: ".$cadas3['nomeprofrecomendante2']."
\\ \\ \\ \\ e-mail: ".$cadas3['emailprofrecomendante2']."
\\\\
3- Nome: ".$cadas3['nomeprofrecomendante3']."
\\ \\ \\ \\ e-mail: ".$cadas3['emailprofrecomendante3']."
\\\\[0.2cm]
Motivação e expectativa do candidato em relação ao programa pretendido:
\\\\".$cadas31['motivacaoprogramapretendido'];


// Primeira Carta de recomendação

$textotex .= "\\newpage";
// Se a carta for vazia passar para segunda carta
$textotex .="\\vspace*{-4cm}\\subsection*{Carta de Recomendação - ".$cadas3['nomeprofrecomendante1']."}";


$query_pega_idprof1 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante1']."'  ");
$coduser1=pg_fetch_row($query_pega_idprof1);
$id_prof1=$coduser1[0];

$textotex .="Código Identificador: ".$id_prof1."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof1."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
$formu3 = pg_fetch_assoc($query_formu3);

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

$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\	Avaliações:\\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & Excelente & Bom & Regular & Insuficiente & Não sabe \\\\
\\hline
Desempenho acadêmico & ".$marcadesempenhoacademico1." & ".$marcadesempenhoacademico2." & ".$marcadesempenhoacademico3." & ".$marcadesempenhoacademico4." & ".$marcadesempenhoacademico5."\\\\
\\hline
Capacidade de aprender novos conceitos & ".$marcacapacidadeaprender1." & ".$marcacapacidadeaprender2." & ".$marcacapacidadeaprender3." & ".$marcacapacidadeaprender4." & ".$marcacapacidadeaprender5."\\\\
\\hline
Capacidade de trabalhar sozinho & ".$marcacapacidadetrabalhar1." & ".$marcacapacidadetrabalhar2." & ".$marcacapacidadetrabalhar3." & ".$marcacapacidadetrabalhar4." & ".$marcacapacidadetrabalhar5."\\\\
\\hline
Criatividade & ".$marcacriatividade1." & ".$marcacriatividade2." & ".$marcacriatividade3." & ".$marcacriatividade4." & ".$marcacriatividade5."\\\\
\\hline
Curiosidade & ".$marcacuriosidade1." & ".$marcacuriosidade2." & ".$marcacuriosidade3." & ".$marcacuriosidade4." & ".$marcacuriosidade5."\\\\
\\hline
Esforço, persistência & ".$marcaesforco1." & ".$marcaesforco2." & ".$marcaesforco3." & ".$marcaesforco4." & ".$marcaesforco5."\\\\
\\hline
Expressão escrita & ".$marcaexpressaoescrita1." & ".$marcaexpressaoescrita2." & ".$marcaexpressaoescrita3." & ".$marcaexpressaoescrita4." & ".$marcaexpressaoescrita5."\\\\
\\hline
Expressão oral & ".$marcaexpressaooral1." & ".$marcaexpressaooral2." & ".$marcaexpressaooral3." & ".$marcaexpressaooral4." & ".$marcaexpressaooral5."\\\\
\\hline
Relacionamento com colegas & ".$marcarelacionamento1." & ".$marcarelacionamento2." & ".$marcarelacionamento3." & ".$marcarelacionamento4." & ".$marcarelacionamento5."\\\\
\\hline
\\end{tabular}\\\\
\\\\
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\\\
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & 5\% melhores & 10\% melhores & 25\% melhores & 50\% melhores & Não sabe \\\\
\\hline
Como aluno, em aulas & ".$marcacomoaluno1." & ".$marcacomoaluno2." & ".$marcacomoaluno3." & ".$marcacomoaluno4." & ".$marcacomoaluno5."\\\\
\\hline
Como orientando & ".$marcacomoorientando1." & ".$marcacomoorientando2." & ".$marcacomoorientando3." & ".$marcacomoorientando4." & ".$marcacomoorientando5."\\\\
\\hline
\\end{tabular}";

$textotex .= "
\\subsection*{Dados Recomendante} 
	Instituição (Institution): ".$formu3['instituicaorecomendante']."
\\\\ 
	Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante']."
	\\ \\ Área: ".$formu3['arearecomendante']."
	\\\\
	Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante']."
	\\ \\ 
	Instituição de obtenção deste grau : ".$formu3['instobtencaorecomendante']."
	\\\\ 
	Endereço institucional do recomendante: \\\\ ".$formu3['enderecorecomendante'];











// Segunda Carta de recomendação

$textotex .= "\\newpage";
// Se a carta for vazia passar para segunda carta
$textotex .="\\vspace*{-4cm}\\subsection*{Carta de Recomendação - ".$cadas3['nomeprofrecomendante2']."}";

$query_pega_idprof2 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante2']."'  ");
$coduser2=pg_fetch_row($query_pega_idprof2);
$id_prof2=$coduser2[0];

echo "<hr>$id_prof2 <hr>";

$textotex .="Código Identificador: ".$id_prof2."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof2."' and edital='$edital_atual' ");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof2."'");
$formu3 = pg_fetch_assoc($query_formu3);
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

$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\Avaliações: \\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & Excelente & Bom & Regular & Insuficiente & Não sabe \\\\
\\hline
Desempenho acadêmico & ".$marcadesempenhoacademico1." & ".$marcadesempenhoacademico2." & ".$marcadesempenhoacademico3." & ".$marcadesempenhoacademico4." & ".$marcadesempenhoacademico5."\\\\
\\hline
Capacidade de aprender novos conceitos & ".$marcacapacidadeaprender1." & ".$marcacapacidadeaprender2." & ".$marcacapacidadeaprender3." & ".$marcacapacidadeaprender4." & ".$marcacapacidadeaprender5."\\\\
\\hline
Capacidade de trabalhar sozinho & ".$marcacapacidadetrabalhar1." & ".$marcacapacidadetrabalhar2." & ".$marcacapacidadetrabalhar3." & ".$marcacapacidadetrabalhar4." & ".$marcacapacidadetrabalhar5."\\\\
\\hline
Criatividade & ".$marcacriatividade1." & ".$marcacriatividade2." & ".$marcacriatividade3." & ".$marcacriatividade4." & ".$marcacriatividade5."\\\\
\\hline
Curiosidade & ".$marcacuriosidade1." & ".$marcacuriosidade2." & ".$marcacuriosidade3." & ".$marcacuriosidade4." & ".$marcacuriosidade5."\\\\
\\hline
Esforço, persistência & ".$marcaesforco1." & ".$marcaesforco2." & ".$marcaesforco3." & ".$marcaesforco4." & ".$marcaesforco5."\\\\
\\hline
Expressão escrita & ".$marcaexpressaoescrita1." & ".$marcaexpressaoescrita2." & ".$marcaexpressaoescrita3." & ".$marcaexpressaoescrita4." & ".$marcaexpressaoescrita5."\\\\
\\hline
Expressão oral & ".$marcaexpressaooral1." & ".$marcaexpressaooral2." & ".$marcaexpressaooral3." & ".$marcaexpressaooral4." & ".$marcaexpressaooral5."\\\\
\\hline
Relacionamento com colegas & ".$marcarelacionamento1." & ".$marcarelacionamento2." & ".$marcarelacionamento3." & ".$marcarelacionamento4." & ".$marcarelacionamento5."\\\\
\\hline
\\end{tabular}\\\\
\\\\
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\\\
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & 5\% melhores & 10\% melhores & 25\% melhores & 50\% melhores & Não sabe \\\\
\\hline
Como aluno, em aulas & ".$marcacomoaluno1." & ".$marcacomoaluno2." & ".$marcacomoaluno3." & ".$marcacomoaluno4." & ".$marcacomoaluno5."\\\\
\\hline
Como orientando & ".$marcacomoorientando1." & ".$marcacomoorientando2." & ".$marcacomoorientando3." & ".$marcacomoorientando4." & ".$marcacomoorientando5."\\\\
\\hline
\\end{tabular}";
$textotex .= "
\\subsection*{Dados Recomendante} 
	Instituição (Institution): ".$formu3['instituicaorecomendante']."
\\\\ 
	Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante']."
	\\ \\ Área: ".$formu3['arearecomendante']."
	\\\\
	Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante']."
	\\ \\ 
	Instituição de obtenção deste grau : ".$formu3['instobtencaorecomendante']."
	\\\\ 
	Endereço institucional do recomendante: \\\\ ".$formu3['enderecorecomendante'];


// Terceira Carta de recomendação

$textotex .= "\\newpage";

$textotex .="\\vspace*{-4cm}\\subsection*{Carta de Recomendação - ".$cadas3['nomeprofrecomendante3']."}";

$query_pega_idprof3 = pg_query("select coduser from inscricao_pos_login 
								where login='".$cadas3['emailprofrecomendante3']."'  ");
$coduser3=pg_fetch_row($query_pega_idprof3);
$id_prof3=$coduser3[0];

$textotex .="Código Identificador: ".$id_prof3."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof3."' and edital='$edital_atual'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof3."'");
$formu3 = pg_fetch_assoc($query_formu3);

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

$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\Avaliações: \\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & Excelente & Bom & Regular & Insuficiente & Não sabe \\\\
\\hline
Desempenho acadêmico & ".$marcadesempenhoacademico1." & ".$marcadesempenhoacademico2." & ".$marcadesempenhoacademico3." & ".$marcadesempenhoacademico4." & ".$marcadesempenhoacademico5."\\\\
\\hline
Capacidade de aprender novos conceitos & ".$marcacapacidadeaprender1." & ".$marcacapacidadeaprender2." & ".$marcacapacidadeaprender3." & ".$marcacapacidadeaprender4." & ".$marcacapacidadeaprender5."\\\\
\\hline
Capacidade de trabalhar sozinho & ".$marcacapacidadetrabalhar1." & ".$marcacapacidadetrabalhar2." & ".$marcacapacidadetrabalhar3." & ".$marcacapacidadetrabalhar4." & ".$marcacapacidadetrabalhar5."\\\\
\\hline
Criatividade & ".$marcacriatividade1." & ".$marcacriatividade2." & ".$marcacriatividade3." & ".$marcacriatividade4." & ".$marcacriatividade5."\\\\
\\hline
Curiosidade & ".$marcacuriosidade1." & ".$marcacuriosidade2." & ".$marcacuriosidade3." & ".$marcacuriosidade4." & ".$marcacuriosidade5."\\\\
\\hline
Esforço, persistência & ".$marcaesforco1." & ".$marcaesforco2." & ".$marcaesforco3." & ".$marcaesforco4." & ".$marcaesforco5."\\\\
\\hline
Expressão escrita & ".$marcaexpressaoescrita1." & ".$marcaexpressaoescrita2." & ".$marcaexpressaoescrita3." & ".$marcaexpressaoescrita4." & ".$marcaexpressaoescrita5."\\\\
\\hline
Expressão oral & ".$marcaexpressaooral1." & ".$marcaexpressaooral2." & ".$marcaexpressaooral3." & ".$marcaexpressaooral4." & ".$marcaexpressaooral5."\\\\
\\hline
Relacionamento com colegas & ".$marcarelacionamento1." & ".$marcarelacionamento2." & ".$marcarelacionamento3." & ".$marcarelacionamento4." & ".$marcarelacionamento5."\\\\
\\hline
\\end{tabular}\\\\
\\\\
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\\\
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
\\begin{tabular}{|l|c|c|c|c|c|}
\\hline
 & 5\% melhores & 10\% melhores & 25\% melhores & 50\% melhores & Não sabe \\\\
\\hline
Como aluno, em aulas & ".$marcacomoaluno1." & ".$marcacomoaluno2." & ".$marcacomoaluno3." & ".$marcacomoaluno4." & ".$marcacomoaluno5."\\\\
\\hline
Como orientando & ".$marcacomoorientando1." & ".$marcacomoorientando2." & ".$marcacomoorientando3." & ".$marcacomoorientando4." & ".$marcacomoorientando5."\\\\
\\hline
\\end{tabular}";
$textotex .= "
\\subsection*{Dados Recomendante} 
	Instituição (Institution): ".$formu3['instituicaorecomendante']."
\\\\ 
	Grau acadêmico mais alto obtido: ".$formu3['titulacaorecomendante']."
	\\ \\ Área: ".$formu3['arearecomendante']."
	\\\\
	Ano de obtenção deste grau: ".$formu3['anoobtencaorecomendante']."
	\\ \\ 
	Instituição de obtenção deste grau : ".$formu3['instobtencaorecomendante']."
	\\\\ 
	Endereço institucional do recomendante: \\\\ ".$formu3['enderecorecomendante'];





//  Final do trecho das cartas de recomendação 



// Esta query esta repetida. Verificar se realmente precisamos dela
$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."' order by data DESC");

while($registro=pg_fetch_row($query_arquivos)){
				
				if ($registro[2]!=""){
					$ext = pathinfo($registro[2], PATHINFO_EXTENSION);
					if ($ext =="pdf"){
						$textotex .= "\\includepdf[pages={-},offset=35mm 0mm]{/home/PAGINAS/WWW/site-mat/inscricoespos/upload/".$registro[2]."}";

					}else{ if ( ($ext=="jpeg") or ($ext=="jpg") or ($ext=="png") ){ 
							
								$textotex .="	
\\begin{figure}[!htb]
\\includegraphics{/home/PAGINAS/WWW/site-mat/inscricoespos/upload/".$registro[2]."}
\\end{figure}";
							}
					} 

				}else{ $textotex .="\\\\ \\textbf{Faltam documentos obrigatórios.}\\\\";}
			
			
}

$textotex .=" 
\\begin{center}
Anexos.
\\end{center}
\\end{document}";

//$textotex = utf8_decode($textotex);
//echo $textotex;
fwrite($fo, $textotex);
echo "<br><br><br><br><br> $textotex";
fclose($fo);
//sleep(10);

$arquivospdf[] = $arquivotex;

//$erropdf = fopen("/vagrant/www/inscricoespos/administrator/relatorios/".$dir_atual."/erropdf.txt","wb");
//exec("cd /paginas/WWW/site-mat/inscricoespos/relatorios/edital-2-2014/; pwd; chmod 777 ".$arquivotex.".tex; pdflatex ".$arquivotex."; rm ".$arquivotex." *.log *.aux");
exec("cd ".$caminho_diretorio."; pwd; chmod 777 ".$arquivotex.".tex; pdflatex ".$arquivotex." .tex");

// Primeiro vamos ter certeza de que o arquivo existe e pode ser alterado

//echo $resultadocompila;
//exec('pdflatex ../ficha_inscricao/'.$arquivotex);
}
echo "<hr> Cheguei no final do arquivo";


sleep(300);

$filename = $caminho_diretorio."erropdf.txt";
if (is_writable($filename)) {

 // Em nosso exemplo, nós vamos abrir o arquivo $filename
 // em modo de adição. O ponteiro do arquivo estará no final
 // do arquivo, e é pra lá que $conteudo irá quando o 
 // escrevermos com fwrite().
    if (!$handle = fopen($filename, 'a')) {
         echo "Não foi possível abrir o arquivo ($filename)";
         exit;
    }

    // Escreve $conteudo no nosso arquivo aberto.
    foreach ($arquivospdf as $key) {
    	if (!file_exists($caminho_diretorio.$key.".pdf")) {
    		$contapdf = $contapdf + 1;
    		if (fwrite($handle, $key.".tex\n") === FALSE) {
        		echo "Não foi possível escrever no arquivo ($filename)";
        		exit;
    		}
    	}
    }
    fclose($handle);

} else {
    echo "O arquivo $filename não pode ser alterado";
}


echo '<h2 align="center"> <span style="color:#FF0000">Houveram '.$num_linhas.' inscri&ccedil;&otilde;es para o edital '.$edital_atual.'.<br>
Desse total, existem '.$contapdf.' arquivos pdf que n&atilde;o foram gerados.<br>
Verifique o arquivo erropdf.txt no diret&oacute;rio '.$caminho_diretorio.' para 
saber quais est&atilde;o faltando!</span></h2>';

//echo "Verifique o arquivo erropdf.txt no diretório ".$caminho_diretorio."para verificar se existe algum pdf que não foi gerado!";

?>
