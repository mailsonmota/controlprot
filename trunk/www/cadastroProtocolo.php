<?php
require "conectar.php";

//inicio formulario
function formulario(){

echo "
<form method=\"POST\" name=\"cadastro\" onSubmit=\"return verificar()\" action=\"index.php?pagina=Novo\">
<table border=\"0\" align=center>
<tr>
  <td class=\"descCampo\" ><label for=\"cpfCnpjCliente\">Cpf/Cnpj:</label></td>
  <td><input type=\"text\" maxlength=\"18\" size=\"23\" name=\"cpfCnpjCliente\" id=\"cpfCnpjCliente\"></td>
  <td class=\"descCampo\" ><label for=\"nome\">Nome:</label></td>
  <td><input type=\"text\" maxlength=\"40\" size=\"43\" name=\"nome\" id=\"nome\"></td>
</tr>
<tr>
  <td class=\"descCampo\" ><label for=\"obs\">Obs:</label></td>
  <td colspan=4><input type=\"text\" maxlength=\"300\" size=\"82\" name=\"obs\" id=\"obs\"></td>
</tr>
<tr>
   <td colspan=4 align=\"right\"><input type=\"submit\" value=\"Incluir\" name=\"incluir\" >
</tr>
</table>
<br>

<p align=\"center\">...................................................................................................................................</p>

<div>
<table border=\"0\" width=\"650\" align=\"center\" class=\"tabItemProtocolo\">
<thead>
<tr>
    <th>Nome</th>
    <th>Cpf/Cnpj</th>
    <th width=\"10\">Tipo</th>
    <th >Obs</th>
</tr>
</thead>
";
        $sql = "select * from itemProtocolo A
            join
            protocolo B
            on A.codProtocolo = B.codProtocolo
            where A.codProtocolo ='".$_SESSION['codProtocolo']."'";
        $resultado = mysql_query($sql) or die ("erro sql".mysql_error());
        $total = mysql_num_rows($resultado);
        $_SESSION['total'] = $total;
        while ($linha = mysql_fetch_array($resultado)){
        echo "
        <tbody>
        <tr>
            <td class=\"resultCampo\">".$linha['nomeCliente']."</td>
            <td class=\"resultCampo\">".$linha['cpfCnpjCliente']."</td>
            <td class=\"resultCampo\" align=\"center\">".$linha['tipo']."</td>
            <td class=\"resultCampo\">".$linha['obs']."</td>
        </tr>";
        }

echo "
    <tr>
        <th colspan=4>Total Contratos: ".$total."</th>
    </tr>

</tbody>
</table>
</div>
<table border=\"0\" align=\"center\">
<thead>
    <tr>
        <td align=\"right\"><input type=\"submit\" value=\"Deletar\" name=\"deletar\" >
        <td align=\"right\"><input type=\"submit\" value=\"Gravar\" name=\"gravar\" >
        <td align=\"right\"><input type=\"submit\" value=\"Enviar\" name=\"enviar\" >
    </tr>
</thead>
<tbody>
</tbody>
</table>
</form>";
}
//fim formulario

//inicio formulario
function gravarCabecalho(){


if (isset($_SESSION['codProtocolo']) && !$_SESSION['codProtocolo']==""){

    }else{
        $sql2 = "select * from protocolo order by codProtocolo desc limit 1 ";//busca o ultimo cod que está no banco
        $resultado2 = mysql_query($sql2) or die ("erro sqlGravarCabecalho".mysql_error());
        $dado2 = mysql_fetch_assoc($resultado2);
        $codProtocolo = $dado2['codProtocolo']+1;//acrescenta + 1 no codigo que buscou do banco
        $_SESSION['codProtocolo'] = $codProtocolo;

$sql = "INSERT INTO protocolo (codProtocolo,dataCriacao,status,codUsuario,codEmpresa,quantidadeContratos) VALUES ('$codProtocolo',now(),'A','1','1','0')";
        $resultadosql = mysql_query($sql) or die ("erro sql GravarCabecalho 2".mysql_error());
}



};
//fim gravar

//inicio formulario
function gravarItemProtocolo(){
    $_SESSION['nome'] = $_POST['nome'];
    $_SESSION['cpfCnpjCliente'] = $_POST['cpfCnpjCliente'];
    $_SESSION['obs'] = $_POST['obs'];

    $sql_ver = "select * from itemProtocolo A
            join
            protocolo B
            on A.codProtocolo = B.codProtocolo
            where A.cpfCnpjCliente ='".$_SESSION['cpfCnpjCliente']."'";

    $resultado_ver = mysql_query($sql_ver);
    $linha_ver = mysql_num_rows($resultado_ver);

    if ($linha_ver>0){
        echo "<div class=msg><b>CPF/Cnpj já possui protocolo</b><br>";
            while ($linha = mysql_fetch_array($resultado_ver)){
                echo"Protocolo: ".$linha['codProtocolo']." - Enviado: ".$linha['dataEnvio']."<br>";
                }

        echo "<br>Deseja enviar como Novo ou Pendência?";
        echo "
        <form method=\"POST\" name=\"cadastro\" onSubmit=\"return verificar()\" action=\"index.php?pagina=Novo\">
        <table border=\"0\" align=\"center\">
         <thead>
         <tr>
            <td align=\"right\"><input type=\"submit\" value=\"Novo\" name=\"novo\" >
            <td align=\"right\"><input type=\"submit\" value=\"Pendência\" name=\"pendencia\" >
         </tr>
         </thead>
         <tbody>
         </tbody>
         </table>
         </form></div>";
                 }else{
                 $sql = "INSERT INTO itemProtocolo (cpfCnpjCliente,nomeCliente,tipo,codProtocolo,obs,dataPagamento,documento)
                 VALUES ('".$_SESSION['cpfCnpjCliente']."','".$_SESSION['nome']."','N','".$_SESSION['codProtocolo']."','".$_SESSION['obs']."','0000-00-00','nada')";
                 $resultadosql = mysql_query($sql) or die ("erro sql gravarItemProtocolo".mysql_error());
                    }
}
//fim formulario

function salvarProtocolo(){

$sql = "UPDATE protocolo SET status='S',quantidadeContratos='".$_SESSION['total']."'
           WHERE codProtocolo = '".$_SESSION['codProtocolo']."' ;";
$resultadosql = mysql_query($sql) or die ("erro sql salvarFormulario".mysql_error());
echo "<div class=\"msg\">Protocolo Salvo com sucesso</div>";
}

function enviarProtocolo(){
    $sql = "UPDATE protocolo SET status='E',quantidadeContratos='".$_SESSION['total']."', dataEnvio=now(),codUsuario='1',codEmpresa='1'
    WHERE codProtocolo = '".$_SESSION['codProtocolo']."' ;";
    $resultadosql = mysql_query($sql) or die ("erro sql salvarFormulario".mysql_error());
    echo "<div class=\"msg\">Protocolo Enviado<br>
    <b>Protocolo: ".$_SESSION['codProtocolo']."</b>
    </div>";


$_SESSION['codProtocolo']="";

}
function gravarItemProtocoloPendencia(){
    $sql =  $sql = "INSERT INTO itemProtocolo (cpfCnpjCliente,nomeCliente,tipo,codProtocolo,obs,dataPagamento,documento)
                 VALUES ('".$_SESSION['cpfCnpjCliente']."','".$_SESSION['nome']."','P','".$_SESSION['codProtocolo']."','".$_SESSION['obs']."','0000-00-00','nada')";
    $resultadosql = mysql_query($sql) or die ("erro sql gravarItemProtocoloPendencia ".mysql_error());
}
function gravarItemProtocoloNovo(){
    $sql =  $sql = "INSERT INTO itemProtocolo (cpfCnpjCliente,nomeCliente,tipo,codProtocolo,obs,dataPagamento,documento)
                 VALUES ('".$_SESSION['cpfCnpjCliente']."','".$_SESSION['nome']."','N','".$_SESSION['codProtocolo']."','".$_SESSION['obs']."','0000-00-00','nada')";
    $resultadosql = mysql_query($sql) or die ("erro sql gravarItemProtocoloNovo ".mysql_error());
}

function deletarProtocolo(){
    $sql = "DELETE FROM itemProtocolo WHERE codProtocolo='".$_SESSION['codProtocolo']."';";
    $resultadosql = mysql_query($sql) or die ("erro sql deletarItemProtocolo".mysql_error());

    $sql = "DELETE FROM protocolo WHERE codProtocolo='".$_SESSION['codProtocolo']."';";
    $resultadosql = mysql_query($sql) or die ("erro sql deletarItemProtocolo".mysql_error());

echo "<div class=\"msg\">Protocolo Deletado</div>";

$_SESSION['codProtocolo']="";
}

if(array_key_exists("enviar", $_POST)){
    enviarProtocolo();
    }
    if(array_key_exists("gravar", $_POST)){
        salvarProtocolo();
        formulario();
        }
        if (array_key_exists("incluir",$_POST)){
            gravarItemProtocolo();
            formulario();

            }
            if(array_key_exists("pendencia", $_POST)){
              gravarItemProtocoloPendencia();
              formulario();
              }
              if(array_key_exists("novo", $_POST)){
                gravarItemProtocoloNovo();
                formulario();
                }
                if(array_key_exists("deletar", $_POST)){
                    deletarProtocolo();
                    }
                    if ( !array_key_exists("enviar", $_POST) && !array_key_exists("gravar", $_POST)
                        && !array_key_exists("incluir",$_POST) && !array_key_exists("pendencia", $_POST)
                        && !array_key_exists("novo", $_POST) && !array_key_exists("deletar", $_POST)){
                           formulario();
                           gravarCabecalho();

                           }

?>