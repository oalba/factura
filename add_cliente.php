<html>
<head>
<title>Añadir cliente</title>
</head>
<body>
Añadir cliente: <br/><br/>
<form enctype='multipart/form-data' action='' method='post'>
Nombre: <input type="text" name="nombre"/><br/><br/>
CIF: <input type="text" name="cif"/><br/><br/>
Cuenta: <input type="number" name="cuenta"/><br/><br/>
<input type='submit' name='guardar' value='Guardar'/><br/>
</form>

<?php
if(isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $cif = $_POST['cif'];
    $cuenta = $_POST['cuenta'];

    $dp = mysql_connect("localhost", "root", "" );
	mysql_select_db("facturas", $dp);
	$anadir="INSERT INTO clientes(cif,nombre,cuenta) VALUES ('$cif','$nombre','$cuenta')";
	mysql_query($anadir);
	mysql_close($dp);
}
?>
</body>
</html>