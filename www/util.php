
<?
function converteData($data){
$data_nova = implode(preg_match("~\/~", $data) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data) == 0 ? "-" : "/", $data)));
return $data_nova;
}

/*
Fun��o que converte Y-m-d para d/m/Y
Utilizado para manipular datas no formato Date do MySQL
exibindo no formato convencional.
*/
function dtPadrao($data) {
$data = trim($data);
if (strlen($data) < 10)
{
$rs = "";
}
else
{
$arr_data = explode(" ",$data);
$data_db = $arr_data[0];
$arr_data = explode("-",$data_db);
$data_form = $arr_data[2]."/".$arr_data[1]."/".$arr_data[0];
$rs = $data_form;
}
return $rs;
}

/*
Fun��o que converte d/m/Y para Y-m-d
Utilizado para inserir datas do tipo converncional em
campos tipo Date do MySQL
*/
function dtBanco($data) {
$data = trim($data);
if (strlen($data) != 10)
{
$rs = "";
}
else
{
$arr_data = explode("/",$data);
$data_banco = $arr_data[2]."-".$arr_data[1]."-".$arr_data[0];
$rs = $data_banco;
}
return $rs;
}

// C�digo Original/ Original Code by Woodys
// Converte formato do DATETIME do MySQL para um compreens�vel para os homens
// 2003-12-30 23:30:59 -> 30/12/2003 23:30:59
function mysql_datetime_para_humano($dt) {
        $yr=strval(substr($dt,0,4));
        $mo=strval(substr($dt,5,2));
        $da=strval(substr($dt,8,2));
        $hr=strval(substr($dt,11,2));
        $mi=strval(substr($dt,14,2));
        return date("d/m/Y H:i:s", mktime ($hr,$mi,0,$mo,$da,$yr));
}
// Converte formato DATE do MySQL para o humano
// 2003-12-30 -> 30/12/2003
function mysql_date_para_humano($dt) {
        if ($dt=="0000-00-00") return '';
        $yr=strval(substr($dt,0,4));
        $mo=strval(substr($dt,5,2));
        $da=strval(substr($dt,8,2));
        return date("d/m/Y", mktime (0,0,0,$mo,$da,$yr));
}



?>

