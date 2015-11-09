<?php
$data = $_GET['cod_con'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$eliminar="DELETE FROM conceptos WHERE cod_con=$data";
mysql_query($eliminar);
header("Location: manage_conce.php");

mysql_close($dp);
?>