<?php
$data = $_GET['cif'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$eliminar="DELETE FROM clientes WHERE cif='$data'";
mysql_query($eliminar);
header("Location: manage_cliente.php");

mysql_close($dp);
?>