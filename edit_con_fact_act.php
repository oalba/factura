<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$data = $_GET['cod_fac'];
$concepto2 = $_POST['concepto2'];
$cantidad = $_POST['cant1'];
$precio = $_POST['precio1'];
if ($_POST['concepto3'] == 1) {
	$concepto = $_POST['concepto1'];
} else {
	$conce = explode('|', $_POST['concepto3']);
	$concepto =  $conce[0];
}
$aldatu="UPDATE tener_f_c SET concepto='$concepto',cantidad=$cantidad,precio_u='$precio' WHERE cod_fac=$data AND concepto='$concepto2'";
mysql_query($aldatu);

header("Location: edit_factura.php?cod_fac=$data");

mysql_close($dp);

?>