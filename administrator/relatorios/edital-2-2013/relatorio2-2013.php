<?php

include_once("../pgsql/pgsql.php"); 


// Gerando a lista de codusers a partir da tabela finaliza

$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='2-2013'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){


//echo "<hr>Contador: ".$i."<hr>";

		$coduser=$tab_coduser[$i]['coduser'];
		//$coduser="479";

		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."' and edital='2-2013'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and edital='2-2013'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='".$coduser."' and edital='2-2013'");
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



$arquivotex = str_replace(' ','',$cadas3['programa'])."-".$coduser."-".$nome;
// Velho fo funciona na outra pasta $fo = fopen('../ficha_inscricao/'.$arquivotex.'.tex', 'w') or die("Nao foi possivel abrir o arquivo.");
$fo = fopen($arquivotex.'.tex', 'w') or die("Nao foi possivel abrir o arquivo.");

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
\\textbf{Programa Pretendido:} ".$cadas3['programa']."
\\\\
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

$textotex .="Código Identificador :".$id_prof1."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof1."' and edital='2-2013'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
$formu3 = pg_fetch_assoc($query_formu3);


$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\[0.3cm]	Avaliações: \\\\
		1) Excelente, \\ \\
		2) Bom,  \\ \\  
		3) Regular, \\ \\ 
		4) Insuficiente, \\ \\ 
		?) Não sabe.
\\\\
    Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico']."\\\\
    Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender']."\\\\
	Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar']."\\\\
	Criatividade (Creativity): ".$formu1['criatividade']."\\\\
	Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade']."\\\\ 
	Esforço, persistência (Effort, persistence): ".$formu1['esforco']."\\\\
	Expressão escrita (Written expression): ".$formu1['expressaoescrita']."\\\\
	Expressão oral (Oral expression): ".$formu1['expressaooral']."\\\\
	Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento']."\\\\[0.3cm]
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
	1) 5\% melhores, \\ \\
	2) 10\% melhores, \\ \\
	3) 25\% melhores, \\ \\
	4) 50\% melhores, \\ \\
	?) Não sabe (Don’t know) \\ \\
\\\\ 
	Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno']."
\\\\
	Como orientando (During advisory): ".$formu1['comoorientando']."";

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

$textotex .="Código Identificador :".$id_prof2."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof2."' and edital='2-2013' ");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof2."'");
$formu3 = pg_fetch_assoc($query_formu3);


$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\[0.3cm]	Avaliações: \\\\
		1) Excelente, \\ \\
		2) Bom,  \\ \\  
		3) Regular, \\ \\ 
		4) Insuficiente, \\ \\ 
		?) Não sabe.
\\\\
    Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico']."\\\\
    Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender']."\\\\
	Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar']."\\\\
	Criatividade (Creativity): ".$formu1['criatividade']."\\\\
	Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade']."\\\\ 
	Esforço, persistência (Effort, persistence): ".$formu1['esforco']."\\\\
	Expressão escrita (Written expression): ".$formu1['expressaoescrita']."\\\\
	Expressão oral (Oral expression): ".$formu1['expressaooral']."\\\\
	Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento']."\\\\[0.3cm]
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
	1) 5\% melhores, \\ \\
	2) 10\% melhores, \\ \\
	3) 25\% melhores, \\ \\
	4) 50\% melhores, \\ \\
	?) Não sabe (Don’t know) \\ \\
\\\\ 
	Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno']."
\\\\
	Como orientando (During advisory): ".$formu1['comoorientando']."";

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

$textotex .="Código Identificador :".$id_prof3."\\\\";

$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof3."' and edital='2-2013'");
$formu1 = pg_fetch_assoc($query_formu1);

$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
$formu3 = pg_fetch_assoc($query_formu3);


$textotex .="Conhece-o candidato há quanto tempo (For how long have you known the applicant)? 
\\ ".$formu1['tempoconhececandidato']."
\\\\ Conhece-o sob as seguintes circunstâncias: ".$formu1['circunstancia1']."\\ \\ ".$formu1['circunstancia2']."
	\\ \\ ".$formu1['circunstancia3']."\\ \\ ".$formu1['circunstancia4']." 
\\\\ Conheçe o candidato sob outras circunstâncias: ".$formu1['circunstanciaoutra']."
\\\\[0.3cm]	Avaliações: \\\\
		1) Excelente, \\ \\
		2) Bom,  \\ \\  
		3) Regular, \\ \\ 
		4) Insuficiente, \\ \\ 
		?) Não sabe.
\\\\
    Desempenho acadêmico (Academic achievements): ".$formu1['desempenhoacademico']."\\\\
    Capacidade de aprender novos conceitos (Ability to learn new concepts): ".$formu1['capacidadeaprender']."\\\\
	Capacidade de trabalhar sozinho (Ability to work independently): ".$formu1['capacidadetrabalhar']."\\\\
	Criatividade (Creativity): ".$formu1['criatividade']."\\\\
	Curiosidade, interesse (Curiosity, interest): ".$formu1['curiosidade']."\\\\ 
	Esforço, persistência (Effort, persistence): ".$formu1['esforco']."\\\\
	Expressão escrita (Written expression): ".$formu1['expressaoescrita']."\\\\
	Expressão oral (Oral expression): ".$formu1['expressaooral']."\\\\
	Relacionamento com colegas (Relationship with colleagues): ".$formu1['relacionamento']."\\\\[0.3cm]
\\textbf{Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:}
\\\\".$formu1['antecedentesacademicos']."\\\\
\\textbf{Opinião sobre seu possível aproveitamento, se aceito no Programa:}
\\\\".$formu1['possivelaproveitamento']."\\\\ 
\\textbf{Outras informações relevantes:} \\\\".$formu1['informacoesrelevantes']."
\\\\[0.3cm]
\\textbf{Entre os estudantes que já conheceu, você diria que o candidato está entre os:}
\\\\
	1) 5\% melhores, \\ \\
	2) 10\% melhores, \\ \\
	3) 25\% melhores, \\ \\
	4) 50\% melhores, \\ \\
	?) Não sabe (Don’t know) \\ \\
\\\\ 
	Como aluno, em aulas (As student, in classes): ".$formu1['comoaluno']."
\\\\
	Como orientando (During advisory): ".$formu1['comoorientando']."";

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
$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."'");

while($registro=pg_fetch_row($query_arquivos)){
				
				if ($registro[2]!=""){
					$ext = pathinfo($registro[2], PATHINFO_EXTENSION);
					if ($ext =="pdf"){
						$textotex .= "\\includepdf[pages={-},offset=35mm 0mm]{../upload/".$registro[2]."}";

					}else{ if ( ($ext=="jpeg") or ($ext=="jpg") or ($ext=="png") ){ 
							
								$textotex .="	
\\begin{figure}[!htb]
\\includegraphics{../upload/".$registro[2]."}
\\end{figure}";
							}
					} 

				}else{ $textotex .="\\\\ \\textbf{Faltam documentos obrigatórios.}\\\\";}
			
			
}

$textotex .=" 
\\begin{center}
Anexos.
\end{center}
\\end{document}";

//$textotex = utf8_decode($textotex);
//echo $textotex;
fwrite($fo, $textotex);
echo "<br><br><br><br><br> $textotex";
fclose($fo);
sleep(10);

//exec("cd /paginas/WWW/site-mat/inscricoespos/ficha_inscricao/; pwd; chmod 777 ".$arquivotex.".tex; pdflatex ".$arquivotex."; rm ".$arquivotex." *.log *.aux");
exec("cd /paginas/WWW/site-mat/inscricoespos/relatorio-edital-2-2013/; pwd; chmod 777 ".$arquivotex.".tex; pdflatex ".$arquivotex." .tex");
//echo $resultadocompila;
//exec('pdflatex ../ficha_inscricao/'.$arquivotex);
}
echo "<hr> Cheguei no final do arquivo";



?>
