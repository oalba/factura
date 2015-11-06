<html>
<head>
<title>Editar cliente</title>
</head>
<body>
	<script type="text/javascript">
    function changeCli(obj) {
        var selectBox = obj;
        var selected = selectBox.options[selectBox.selectedIndex].value;
        var sele = selected.split("|");
        var textarea = document.getElementById("cliente1");
        var text = document.getElementById("cif1");

        if(sele[0] === "1"){
            textarea.style.display = "block";
            text.style.display = "none";
        }else if (sele[0] === ""){
            textarea.style.display = "none";
            text.style.display = "none";
        }else{
            textarea.style.display = "none";
            text.style.display = "block";
        }
        document.getElementById("cif1").value = sele[1];
    }
    </script>
<?php
$data = $_GET['cod_fac'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM facturas WHERE cod_fac=$data";
$facs = mysql_query($sql);







$num_fila = 0; 
            echo "<table border=1>";
            echo "<tr bgcolor=\"bbbbbb\" align=center><th>Codigo</th><th>Fecha</th><th>Cliente</th><th>CIF</th><th>IVA %</th><th>Concepto</th><th>Cantidad</th><th>Precio</th></tr>";
            while ($row = mysql_fetch_assoc($facs)) {
                $precio = 0;
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                //,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio as precio
                echo ">";
                echo "<td>$row[cod_fac]</td>";
                $fecha = date_format(date_create_from_format('Y-m-d', $row['fecha']), 'd/m/Y');
                echo "<td><input type='date' name='fecha' value='$row[fecha]'/></td>";
                $exis = "$row[existe_cli]";
                if ($exis==0) {
                    //echo "<td>$row[cliente]";

                    echo "<td><select name='cli1' onchange='changeCli(this)'>";
            		echo "<option value='1' selected='selected'>Otro</option>";
            		$sqlc = "SELECT * FROM clientes";
            		$clis = mysql_query($sqlc);
            		while ($row3 = mysql_fetch_assoc($clis)) {
                		print("<option value='".$row3[direccion]."|".$row3[cif]."'>$row3[direccion]</option>");
            		}
        
        			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5'>$row[cliente]</textarea></td><td><input id='cif1' type='text' name='cif1' value='' style='display: none' disabled/></td>";
                }else{

                    $selec3 = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    $direccion = mysql_result($selec3,0,0);
                    $cif = mysql_result($selec3,0,1);
                    /*echo "<td>$direccion</td>";
                    echo "<td>$cif</td>";*/
                    //while ($row3 = mysql_fetch_assoc($selec3)) {
                        //echo "<td>$row3[direccion]</td>";
                        //echo "<td>$row3[cif]</td>";
                    //}
                    echo "<td><select name='cli1' onchange='changeCli(this)'>";
            		echo "<option value='1'>Otro</option>";
            		$sqlc = "SELECT * FROM clientes";
            		$clis = mysql_query($sqlc);
            		while ($row3 = mysql_fetch_assoc($clis)) {
            			if ($cif == $row3['cif']) {
            				print("<option value='".$row3[direccion]."|".$row3[cif]."' selected='selected'>$row3[direccion]</option>");
            			} else {
            				print("<option value='".$row3[direccion]."|".$row3[cif]."'>$row3[direccion]</option>");
            			}
            		}
        
        			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5' style='display: none'></textarea></td><td><input id='cif1' type='text' name='cif1' value='$cif' disabled/></td>";

                }
                echo "<td><input type='number' name='iva' value='$row[IVA]' Style='width:40Px'/>%</td><th>Concepto</th><th>Cantidad</th><th>Precio</th><td><a href=\"edit_factura.php?cod_fac=$row[cod_fac]\"><input type=\"button\" value=\"Editar\"></a></td></tr>";
                $selec2 = mysql_query("SELECT concepto, cantidad, precio_u as precio FROM tener_f_c WHERE cod_fac='$row[cod_fac]'");
                while ($row2 = mysql_fetch_assoc($selec2)) {
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";
                    echo "<td colspan=5>";
                    echo "<td><textarea name='concepto' rows='3' cols='40'>$row2[concepto]</textarea></td>";

                    /*<select name="conce1" onchange="change(this,1)">
                    <option selected="selected"></option>
                    <option value="1">Otro</option>
                    <?php
                    $sql = "SELECT * FROM conceptos";
                    $cons = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($cons)) {
                        print("<option value='".$row[concepto]."|".$row[precio]."'>$row[concepto]</option>");
                    }
                    ?>
                </select><textarea id="text_area1" name="concepto1" rows="1" cols="50" style="display: none"></textarea>*/

                    echo "<td><input type='number' name='cant1' value='$row2[cantidad]' Style='width:40Px'/></td>";
                    echo "<td><input id='precio1' type='number' name='precio1' step='any' Style='width:60Px' value='$row2[precio]'/>€</td>";
                    echo "</tr>";
                }
                //echo "<td>$row[precio]€</td>";
                //echo "<td><a href=\"edit_conce.php?concepto=$row[cod_con]\"><input type=\"button\" value=\"Editar\"></a></td>";
                //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
                echo "</tr>";
                $num_fila++;
            }
            echo "</table>";










/*$num_fila = 0; 
echo "<table border=1>";
echo "<tr bgcolor=\"bbbbbb\" align=center><th>Dirección</th><th>Cuenta</th></tr>";
while ($row = mysql_fetch_assoc($facs)) {
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
}*/
mysql_close($dp);
?>
<br/>
<a href="manage_facturas.php"><input type="button" value="Atrás"></a>
</body>
</html>