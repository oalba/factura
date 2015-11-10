<html>
<head>
<title>Administrar clientes</title>
</head>
<body>
	<h1><u><i>Administrar clientes</i></u></h1>
<form enctype="multipart/form-data" action="" method="post">
	Insertar dato: <br/>
	<textarea name="data" rows="3" cols="50" placeholder="CIF, Dirección o Cuenta"></textarea><br/><br/>
	Ordenar por: 
	<select name="orden">
		<option value="cif" selected>CIF</option>
		<option value="direccion">Dirección</option>
		<option value="cuenta">Cuenta</option>
	</select>
	<input type="submit" name="buscar" value="Buscar"/>
</form>
<?php 
if(isset($_POST['buscar'])){
$data = $_POST['data'];
$orden = $_POST['orden'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM clientes WHERE cif LIKE '%$data%' OR direccion LIKE '%$data%' OR cuenta LIKE '%$data%' ORDER BY $orden";
$conce = mysql_query($sql);

$conce2 = mysql_query($sql);
$zenbat = 0;
while ($row2 = mysql_fetch_assoc($conce2)) {
 $zenbat = $zenbat+1;
};
echo "$zenbat clientes en total.";

$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>CIF</th><th>Dirección</th><th>Cuenta</th></tr>";
while ($row = mysql_fetch_assoc($conce)) {
	echo "<tr "; 
   	if ($num_fila%2==0) 
      	echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
   	else 
      	echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
   	echo ">";
	echo "<td>$row[cif]</td>";
    echo "<td>$row[direccion]</td>";
    echo "<td>$row[cuenta]</td>";
	echo "<td><a href=\"edit_cliente.php?cif=$row[cif]\"><input type=\"button\" value=\"Editar\"></a></td>";
	echo "<td><button onclick=\"seguro('$row[cif]');\">Eliminar</button></td>";
	echo "</tr>";
	$num_fila++; 
};
echo "</table><br/>";
echo "¿No está aquí? <a href='add_cliente.php'><input type='button' value='Añadir'></a>";

mysql_close($dp);
}
?>
<script type="text/javascript">
function seguro($cif){
//var con = document.getElementById('cif').value;
confirmar=confirm("¿Seguro que desea eliminar el cliente con el CIF \"" + $cif + "\"?"); 
	if (confirmar) {
		// si pulsamos en aceptar
		alert('El cliente será eliminado.');
		window.location='delete_cliente.php?cif='+$cif;
		return true;
	}else{ 
		// si pulsamos en cancelar
		return false;
	}			
}
</script>
</body>
</html>