<?php
include_once("../../pgsql/pgsql.php");

include_once("../../config/config.php");

$filename = "candidatos.csv";
$fp = fopen('php://output', 'w');

$query_coduser_finaliza = pg_query("select coduser from inscricao_pos_finaliza where edital='1-2015' and coduser <> '110' and coduser <> '592' and coduser <> '210' and coduser <> '1264' and coduser <> '561' and coduser <> '618' and coduser <> '1434' and coduser <> '1435'");
$tab_coduser = pg_fetch_all($query_coduser_finaliza);
//var_dump($tab_coduser);
$num_linhas = pg_num_rows($query_coduser_finaliza);

for ($i=0;$i < $num_linhas;$i++){
    $query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
    $cadas1 = pg_fetch_assoc($query_cadas1);
    
    $query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."' and edital='1-2015'");
    $cadas2 = pg_fetch_assoc($query_cadas2);
    
print_r($query_cadas1);
die();
// while ($row = mysql_fetch_row($result)) {
// 	$header[] = $row[0];
// }	
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
//fputcsv($fp, $header);

$num_column = count($header);		
$query = "SELECT * FROM toy";
$result = mysql_query($query);
while($row = mysql_fetch_row($result)) {
	fputcsv($fp, $row);
}
}
exit;
?>