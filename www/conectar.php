<?php

$servidor='localhost'; //servidor padr�o = localhost
$bd='megacreddb'; //banco de dados
$usuario='megacreddb'; //usuario de autentica��o do banco de dados
$senha='mega1010'; //senha do usuario do banco de dados

//######################################################
$conectar = @mysql_connect($servidor,$usuario,$senha)
or die ("N�o foi poss�vel se conectar ao banco.");

mysql_select_db($bd)
or die ("N�o foi poss�vel encontrar o banco de dados.");
//######################################################


?>
