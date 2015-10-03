<html>
<head>
<title>Añadir cliente</title>
</head>
<body>
Añadir cliente: <br/><br/>
<form enctype='multipart/form-data' action='' method='post'>
Nombre: <input type="text" name="nombre"/><br/><br/>
Dirección:<br/><textarea name='direccion' rows="5"></textarea><br/><br/>
Teléfono: <input type="number" name="telefono"/><br/><br/>
Email: <input type="text" name="email"/><br/><br/>
Mas datos: <br/><textarea name='datos' rows="5"></textarea><br/><br/>
<input type='submit' name='guardar' value='Guardar'/><br/>
</form>

<?php
if(isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $dir = $_POST['direccion'];
    $tlf = $_POST['telefono'];
    $email = $_POST['email'];
    $datos = $_POST['datos'];

    $dp = mysql_connect("localhost", "root", "" );
	mysql_select_db("facturas", $dp);
	$anadir="INSERT INTO clientes(nombre,direccion,telefono,email,datos) VALUES ('$nombre','$dir','$tlf','$email','$datos')";
	mysql_query($anadir);
	mysql_close($dp);
}
?>
</body>
</html>