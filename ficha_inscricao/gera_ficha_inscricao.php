<?php

include_once("../pgsql/pgsql.php"); 

				
			
		//$coduser="110";
		$coduser=$_SESSION['coduser'];


		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."' and edital='1-2013'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."' and edital='1-2013'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='".$coduser."' and edital='1-2013'");
		$cadas31 = pg_fetch_assoc($query_carta_motivacao);
		
			
			
		$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."'");

// Retirar esta linha após a fase de testes
echo "<br><br><br><br>".$coduser."<br><br><br>";
//


// Arrumando os nomes dos estados
$ufnatura = explode("_",$cadas1['ufnaturalidade']);
$cadas1['ufnaturalidade'] = $ufnatura[1];

$ufend = explode("_",$cadas1['ufendereco']);
$cadas1['ufendereco'] = $ufend[1];

$estaoemissao = explode("_",$cadas1['estadoemissaoid']);
$cadas1['estadoemissaoid'] = $ufend[1];


// Arrumando e-mails

$cadas1['mail1'] = str_replace('_','\_',$cadas1['mail1']);
$cadas1['mail2'] = str_replace('_','\_',$cadas1['mail2']);
$cadas3['emailprofrecomendante1'] = str_replace('_','\_',$cadas3['emailprofrecomendante1']);
$cadas3['emailprofrecomendante2'] = str_replace('_','\_',$cadas3['emailprofrecomendante2']);
$cadas3['emailprofrecomendante3'] = str_replace('_','\_',$cadas3['emailprofrecomendante3']);
//echo $cadas1['mail1']."<br>".$cadas1['mail2'];


$arquivotex = $coduser.md5($cadas1['name']).".tex";
$fo = fopen($arquivotex, 'w') or die("Nao foi possivel abrir o arquivo.");

$nome = $cadas1['name']." ".$cadas1['firstname'];



$textotex = "\\documentclass[11pt]{article}
\\usepackage{graphicx,color}
\\usepackage{pdfpages}
\\usepackage[brazil]{babel}
\\usepackage[utf8]{inputenc}
\\addtolength{\\hoffset}{-3cm} \\addtolength{\\textwidth}{6cm}
\\addtolength{\\voffset}{-.5cm} \\addtolength{\\textheight}{1cm}
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  To use Colors 
\\title{\\vspace*{-4cm} Ficha de Inscrição de \\\\";
$textotex .= $cadas1['name']." ".$cadas1['firstname'];
$textotex .= " - Identificador: ";
$textotex .= $coduser;
$textotex .=" 
 }
\\date{}

\\begin{document}
\\maketitle
\\vspace*{-1.5cm}
\\noindent Data de Nascimento:".$cadas1['dianascimento']."/".$cadas1['mesnascimento']."/".$cadas1['anonascimento']."
\\ \\ \\ Sexo: ".$cadas1['sexo']."
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
\\textbf{Programa Pretendido:} ".$cadas2['cursopos']."
\\ \\ \\ Área : ".$cadas2['areadoutorado']."
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
Fim.
\end{center}
\\end{document}";

//$textotex = utf8_decode($textotex);
echo $textotex;
fwrite($fo, $textotex); 
//echo "<br><br><br><br><br> Estou aqui";
fclose($fo);
//$i=10;
//$nome_arquivo = "testando".$i.".tex";
//echo $nome_arquivo;
echo "<br><br><br><br>".$arquivotex;
exec('pdflatex '.$arquivotex) or die("Nao foi executar o tex.");
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../cadastro/upload_de_anexos.php'>";

?>
