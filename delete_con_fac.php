<?php
$data = $_GET['cod_fac'];
$data2 = $_GET['concepto'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$eliminar="DELETE FROM tener_f_c WHERE cod_fac=$data AND concepto='$data2'";
mysql_query($eliminar);
header("Location: edit_factura.php?cod_fac=$data");

mysql_close($dp);
?>