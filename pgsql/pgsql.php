<?
// Configuração do banco de dados postgres

$basededados="inscricao_pos";
$usuariob="pos";
$host="127.0.0.1";
$porta="5432";
$senha="estudos";

//isso deve estar dentro do connect.php
$parametros="dbname=$basededados host=$host port=$porta user=$usuariob ";
$parametros.="password=$senha";

if( !$con=pg_connect($parametros))
{
   echo '<font color="red">Ocorreu um erro de conexão com o banco de dados.</font>';

};
?>
