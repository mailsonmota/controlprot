<?php
session_start();
if(!isset($_SESSION["loginIndex"])){
echo "<script language=\"JavaScript\">
document.location=\"index.php\";
</script>";
exit;}

echo "<h4>Ol�, ".$_SESSION['nomeIndex']."</h4>";?>

