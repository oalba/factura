<html>
<head>
<title>Añadir cliente</title>
</head>
<body>
Añadir cliente: <br/><br/>
<form enctype='multipart/form-data' action='' method='post'>
Dirección: <input type="text" name="direccion"/><br/><br/>
CIF: <input type="text" name="cif"/><br/><br/>
Cuenta: <input type="number" name="cuenta"/><br/><br/>
<input type='submit' name='guardar' value='Guardar'/><br/>
</form>

<?php
if(isset($_POST['guardar'])){
    $direccion = $_POST['direccion'];
    $cif = $_POST['cif'];
    $cuenta = $_POST['cuenta'];

    $dp = mysql_connect("localhost", "root", "" );
	mysql_select_db("facturas", $dp);

	$sql = "SELECT * FROM clientes WHERE cif='$cif'";
	$clis = mysql_query($sql);
	if (mysql_num_rows($clis) == 0){
        $anadir="INSERT INTO clientes(cif,direccion,cuenta) VALUES ('$cif','$direccion','$cuenta')";
		mysql_query($anadir);
        echo "Cliente añadido correctamente.<br/>";
    } else {
		echo "¡ERROR! Este cliente ya existe.";
        $num_fila = 0; 
        echo "<table border=1>";
        echo "<tr bgcolor=\"bbbbbb\" align=center><th>CIF</th><th>Dirección</th><th>Cuenta</th></tr>";
        while ($row = mysql_fetch_assoc($clis)) {
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
            //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
            echo "</tr>";
            $num_fila++;
        }
        echo "</table><br/>";
    }
	mysql_close($dp);

}
?>
</body>
</html>