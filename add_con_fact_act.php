<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$data = $_GET['cod_fac'];
$cantidad = $_POST['cant2'];
$precio = $_POST['precio2'];
if ($_POST['concepto3'] == 1) {
    $concepto = $_POST['concepto2'];
}else{
    $conc = explode('|', $_POST['concepto3']);
    $concepto = $conc[0];
}
$concepto = trim(preg_replace('/\s\s+/', ' ', $concepto));
$gehitu="INSERT INTO tener_f_c (concepto,cod_fac,cantidad,precio_u) VALUES ('$concepto',$data,$cantidad,'$precio')";
mysql_query($gehitu);
header("Location: edit_factura.php?cod_fac=$data");
mysql_close($dp);

?>