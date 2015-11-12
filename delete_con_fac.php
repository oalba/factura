<?php
$data = $_GET['cod_fac'];
$data2 = $_GET['concepto'];
$data3 = $_GET['orden'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$orde="SELECT orden FROM tener_f_c WHERE cod_fac=$data AND orden > $data3 ORDER BY orden";
$orden=mysql_query($orde);
while ($row=mysql_fetch_assoc($orden)) {
	$oldord=$row['orden'];
	$neword=$oldord-1;
	$update="UPDATE tener_f_c SET orden='$neword' WHERE cod_fac=$data AND orden='$oldord'";
	mysql_query($update);
}

$eliminar="DELETE FROM tener_f_c WHERE cod_fac=$data AND concepto='$data2'";
mysql_query($eliminar);
header("Location: edit_factura.php?cod_fac=$data");

mysql_close($dp);
?>