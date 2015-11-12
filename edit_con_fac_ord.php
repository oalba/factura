<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$data = $_GET['cod_fac'];
$concepto = $_GET['concepto'];
$accion = $_GET['accion'];
$orden = $_GET['orden'];


echo $data;
echo $concepto;
echo $accion;
echo $orden;

if ($accion=="subir") {
	$neword = $orden-1;
	$update="UPDATE tener_f_c SET orden='$neword' WHERE cod_fac=$data AND concepto='$concepto'";
	$update2="UPDATE tener_f_c SET orden='$orden' WHERE cod_fac=$data AND orden='$neword'";
	mysql_query($update2);
	mysql_query($update);
	//mysql_query($update2);
} else {
	$neword = $orden+1;
	$update="UPDATE tener_f_c SET orden='$neword' WHERE cod_fac=$data AND concepto='$concepto'";
	$update2="UPDATE tener_f_c SET orden='$orden' WHERE cod_fac=$data AND orden='$neword'";
	mysql_query($update2);
	mysql_query($update);
	//mysql_query($update2);
}

header("Location: edit_factura.php?cod_fac=$data");

mysql_close($dp);

?>