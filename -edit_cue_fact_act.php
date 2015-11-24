<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$data = $_GET['cod_fac'];

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

$aldatu="UPDATE facturas SET cuenta_laboral='$laboral',cuenta_kutxa='$kutxa' WHERE cod_fac=$data";
mysql_query($aldatu);

header("Location: edit_factura.php?cod_fac=$data");

mysql_close($dp);

?>