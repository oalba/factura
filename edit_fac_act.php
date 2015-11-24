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
function IsChecked($chkname,$value){
    if(!empty($_POST[$chkname])){
        foreach($_POST[$chkname] as $chkval){
            if($chkval == $value){
                return true;
            }
        }
    }
    return false;
}

if (IsChecked('cuenta','laboral')){
	$laboral = "Nº Cta. Laboral: 11111";
}else{
	$laboral = NULL;
}

if (IsChecked('cuenta','kutxa')){
	$kutxa = "Nº Cta. Kutxa: 111111";
}else{
	$kutxa = NULL;
}

$aldatu="UPDATE facturas SET fecha='$insfecha',IVA=$iva,existe_cli=$exi,cliente='$inscli',cuenta_laboral='$laboral',cuenta_kutxa='$kutxa',detalles='$detalles' WHERE cod_fac=$data";
mysql_query($aldatu);
//f5($data);
header("Location: edit_factura.php?cod_fac=$data");
mysql_close($dp);
?>