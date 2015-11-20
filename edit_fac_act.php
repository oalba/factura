<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$data = $_GET['cod_fac'];
$cli = $_POST['cli1'];
$iva = $_POST['iva'];
$detalles = $_POST['detalles'];
$insfecha = date("Y-m-d",strtotime($_POST['fecha']));
//$direccion = trim(preg_replace('/\s\s+/', ' ', $direccion));
if ($_POST['cli1'] == 1) {
	$inscli = $_POST['cliente1'];
	$exi = "FALSE";
} else {
	$cli = explode('|', $_POST['cli1']);
    $inscli = $cli[1];
	$exi = "TRUE";
}

$aldatu="UPDATE facturas SET fecha='$insfecha',IVA=$iva,existe_cli=$exi,cliente='$inscli' WHERE cod_fac=$data";
mysql_query($aldatu);
//f5($data);
header("Location: edit_factura.php?cod_fac=$data");
mysql_close($dp);
?>