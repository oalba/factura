<html>
<head>
<title>Editar cliente</title>
</head>
<body>
	<script type="text/javascript">
    function change(obj,pan) {
        var selectBox = obj;
        var pan = pan;
        var selected = selectBox.options[selectBox.selectedIndex].value;
        var sele = selected.split("|");
        var textarea = document.getElementById("text_area1");

        if(sele[0] === "1"){
            textarea.style.display = "block";
            document.getElementById("precio1").value = pan;
        }
        else{
            textarea.style.display = "none";
            document.getElementById("precio1").value = sele[1];
        }
    }
    </script>
<?php
$data = $_GET['cod_fac'];
$data2 = $_GET['concepto'];

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM facturas WHERE cod_fac=$data";
$facs = mysql_query($sql);







$num_fila = 0; 
            echo "<table border=1>";
            echo "<tr bgcolor=\"bbbbbb\" align=center><th>Codigo</th><th>Fecha</th><th>Cliente</th><th>CIF</th><th>IVA %</th><th>Concepto</th><th>Cantidad</th><th>Precio</th></tr>";
            while ($row = mysql_fetch_assoc($facs)) {
                echo "<form enctype='multipart/form-data' action='' method='post'>";
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                //,facturas.fecha as fecha, facturas.cliente as cliente, facturas.existe_cli as existe, facturas.iva as iva, tener_f_c.concepto as concepto, tener_f_c.cantidad as cantidad, tener_f_c.precio as precio
                echo ">";
                echo "<td>$row[cod_fac]</td>";
                $fecha = date_format(date_create_from_format('Y-m-d', $row['fecha']), 'd/m/Y');
                echo "<td><input type='date' name='fecha' value='$row[fecha]' disabled/></td>";
                $exis = "$row[existe_cli]";
                if ($exis==0) {
                    //echo "<td>$row[cliente]";

                    echo "<td><select name='cli1' onchange='changeCli(this)' disabled>";
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
                    echo "<td><select name='cli1' onchange='changeCli(this)' disabled>";
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
                echo "<td><input type='number' name='iva' value='$row[IVA]' Style='width:40Px' disabled/>%</td><th>Concepto</th><th>Cantidad</th><th>Precio</th>";
                //echo "<td><input type='submit' name='guardarf' value='Guardar'/></td>";
				echo "<td><a href=\"edit_factura.php?cod_fac=$data\"><input type=\"button\" value=\"Editar\"></a></td>";
                echo "</tr>";
				echo "</form>";
                $selec2 = mysql_query("SELECT concepto, cantidad, precio_u as precio FROM tener_f_c WHERE cod_fac='$row[cod_fac]'");
                //$nu = 1;
                while ($row2 = mysql_fetch_assoc($selec2)) {
                    if ($row2['concepto'] == $data2) {
                        
                        echo "<form enctype='multipart/form-data' action='' method='post'>";
                        echo "<tr "; 
                        if ($num_fila%2==0) 
                            echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                        else 
                            echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                        echo ">";
                        echo "<td colspan=5>";
                        echo "<td>";
                        echo "<select name='concepto' onchange='change(this,$row2[precio])'>";
                        echo "<option value='1' selected='selected'>Otro</option>";
                        $sql = "SELECT * FROM conceptos";
                        $cons = mysql_query($sql);
                        while ($row4 = mysql_fetch_assoc($cons)) {
                            print("<option value='".$row4[concepto]."|".$row4[precio]."'>$row4[concepto]</option>");
                        }
                        
                        echo "</select><br/><textarea name='concepto2' style='display: none'>aaa $row2[concepto]</textarea>";
                        
                        echo "<textarea id='text_area1' name='concepto1' rows='3' cols='40'>$row2[concepto]</textarea></td>";

                        /*echo "<select name='concepto' onchange='change(this,1)'>";
                        echo "<option value='1' selected='selected'>Otro</option>";
                        $sql = "SELECT * FROM conceptos";
                        $cons = mysql_query($sql);
                        while ($row = mysql_fetch_assoc($cons)) {
                            print("<option value='".$row[concepto]."|".$row[precio]."'>$row[concepto]</option>");
                        }
                        
                        echo "</select><textarea id='text_area1' name='concepto1' rows='1' cols='40'></textarea>";*/

                        //echo "<td><textarea name='concepto' rows='3' cols='40'>$row2[concepto]</textarea></td>";
                        echo "<td><input type='number' name='cant1' value='$row2[cantidad]' Style='width:40Px'/></td>";
                        echo "<td><input id='precio1' type='number' name='precio1' step='any' Style='width:60Px' value='$row2[precio]'/>€</td>";
                        echo "<td><input type='submit' name='guardarc' value='Guardar'/></td>";
                        //echo "<td><a href=\"edit_con_fac.php?cod_fac=$data&concepto='$row2[concepto]'\"><input type=\"button\" value=\"Editar\"></a></td>";
                        echo "</tr>";
                        echo "</form>";
                        //$nu++;
                    } else {
                        //echo "<form enctype='multipart/form-data' action='' method='post'>";
                        echo "<tr "; 
                        if ($num_fila%2==0) 
                            echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                        else 
                            echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                        echo ">";
                        echo "<td colspan=5></td>";
                        echo "<td><textarea  id='text_areas' name='conceptos' rows='3' cols='40' disabled>$row2[concepto]</textarea></td>";
                        echo "<td><input type='number' value='$row2[cantidad]' Style='width:40Px' disabled/></td>";
                        echo "<td><input type='number' step='any' Style='width:60Px' value='$row2[precio]' disabled/>€</td>";
                        echo "<td><a href=\"edit_con_fac.php?cod_fac=$data&concepto=$row2[concepto]\"><input type=\"button\" value=\"Editar\"></a></td>";
                        echo "</tr>";
                        //echo "</form>";
                    }
                    
                }
                //echo "<td>$row[precio]€</td>";
                //echo "<td><a href=\"edit_conce.php?concepto=$row[cod_con]\"><input type=\"button\" value=\"Editar\"></a></td>";
                //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
                //echo "</tr>";
                $num_fila++;
            }
            echo "</table>";

/*if(isset($_POST['guardarf'])){
//$tlf = $_POST['telephone'];
$cli = $_POST['cli1'];
$iva = $_POST['iva'];
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

$aldatu="UPDATE facturas SET fecha='$insfecha',IVA=$iva,existe_cli=$exi,cliente='$inscli' WHERE cod_fac=$data";
mysql_query($aldatu);
header("Refresh:0");
}*/

if(isset($_POST['guardarc'])){
    $concepto2 = $_POST['concepto2'];
    $cantidad = $_POST['cant1'];
    $precio = $_POST['precio1'];
	if ($_POST['concepto'] == 1) {
		$concepto = $_POST['concepto1'];
	} else {
		$conce = explode('|', $_POST['concepto']);
		$concepto =  $conce[0];
	}
	$aldatu="UPDATE tener_f_c SET concepto='$concepto',cantidad=$cantidad,precio_u='$precio' WHERE cod_fac=$data AND concepto='$concepto2'";
	mysql_query($aldatu);
	//header("Location: edit_factura.php?cod_fac=$data");
    header("Refresh:0");
}







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