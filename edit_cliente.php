<html>
<head>
<title>Editar cliente</title>
</head>
<body>
	<h1><u><i>Editar cliente</i></u></h1>
<?php
$data = $_GET['cif'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM clientes WHERE cif='$data'";
$phones = mysql_query($sql);

$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>Dirección</th><th>Cuenta</th></tr>";
while ($row = mysql_fetch_assoc($phones)) {
	//echo "<form enctype='multipart/form-data' action='t_edit.php?telephone=$row[Telephone]' method='post'>";
	echo "<form enctype='multipart/form-data' action='' method='post'>";
	echo "<tr "; 
   	if ($num_fila%2==0) 
      	echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
   	else 
      	echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
   	echo ">";
    echo "<td><textarea name='direccion' rows='3' cols='50'>$row[direccion]</textarea></td>";
    echo "<td><input type='number' name='cuenta' step='any' value='$row[cuenta]'></td>";
	echo "<td><input type='submit' name='guardar' value='Guardar'/></td>";
	echo "</tr>";
	echo "</form>";
	$num_fila++; 
};
echo "</table>";

if(isset($_POST['guardar'])){
//$tlf = $_POST['telephone'];
$direccion = $_POST['direccion'];
$cuenta = $_POST['cuenta'];
//$direccion = trim(preg_replace('/\s\s+/', ' ', $direccion));

$aldatu="UPDATE clientes SET direccion='$direccion',cuenta='$cuenta' WHERE cif='$data'";
mysql_query($aldatu);
header("Refresh:0");
}
mysql_close($dp);
?>
<br/>
<a href="manage_cliente.php"><input type="button" value="Atrás"></a>
</body>
</html>