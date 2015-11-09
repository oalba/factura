<?php
$data = $_GET['cod_fac'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$eliminar="DELETE FROM tener_f_c WHERE cod_fac=$data";
mysql_query($eliminar);
$eliminar2="DELETE FROM facturas WHERE cod_fac=$data";
mysql_query($eliminar2);
header("Location: manage_facturas.php");

mysql_close($dp);
?>