<html>
<head>
<title>Editar cliente</title>
</head>
<body>
    <h1><u><i>Editar factura</i></u></h1>
	<script type="text/javascript">
    function change(obj,num,pan) {
        var selectBox = obj;
        var num = num;
        var pan = pan;
        var selected = selectBox.options[selectBox.selectedIndex].value;
        var sele = selected.split("|");
        var textarea = document.getElementById("text_area"+num);

        if(sele[0] === "1"){
            textarea.style.display = "block";
            document.getElementById("precio"+num).value = pan;
        }
        else{
            textarea.style.display = "none";
            document.getElementById("precio"+num).value = sele[1];
        }
    }

    function seguro($con,$fac,$ord){
    //var con = document.getElementById('cod_con').value;
    confirmar=confirm("¿Seguro que desea eliminar el concepto \"" + $con + "\" de la factura \"" + $fac + "\"?");
        if (confirmar) {
            // si pulsamos en aceptar
            alert('El concepto será eliminado.');
            window.location='delete_con_fac.php?concepto='+$con+'&cod_fac='+$fac+'&orden='+$ord;
            return true;
        }else{ 
            // si pulsamos en cancelar
            return false;
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
            echo "<tr bgcolor=\"bbbbbb\" align=center><th>Codigo</th><th>Fecha</th><th>Cliente</th><th>CIF</th><th>IVA %</th></tr>";
            while ($row = mysql_fetch_assoc($facs)) {
                echo "<form enctype='multipart/form-data' action='' method='post'>";
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                echo ">";
                echo "<td>$row[cod_fac]</td>";
                $fecha = date_format(date_create_from_format('Y-m-d', $row['fecha']), 'd/m/Y');
                echo "<td><input type='date' name='fecha' value='$row[fecha]' disabled/></td>";
                $exis = "$row[existe_cli]";
                if ($exis==0) {
                    echo "<td><select name='cli1' onchange='changeCli(this)' style='white-space:pre-wrap; width: 100px;' disabled>";
            		echo "<option value='1' selected='selected'>Otro</option>";
            		$sqlc = "SELECT * FROM clientes";
            		$clis = mysql_query($sqlc);
            		while ($row3 = mysql_fetch_assoc($clis)) {
                		print("<option value='".$row3[direccion]."|".$row3[cif]."'>$row3[direccion]</option>");
            		}
        
        			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5' disabled>$row[cliente]</textarea></td><td><input id='cif1' type='text' name='cif1' value='' style='display: none' disabled/></td>";
                }else{

                    $selec3 = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    $direccion = mysql_result($selec3,0,0);
                    $cif = mysql_result($selec3,0,1);
                    echo "<td><select name='cli1' onchange='changeCli(this)' style='white-space:pre-wrap; width: 100px;' disabled>";
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
        
        			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5' style='display: none' disabled></textarea></td><td><input id='cif1' type='text' name='cif1' value='$cif' disabled/></td>";

                }
                echo "<td><input type='number' name='iva' value='$row[IVA]' Style='width:40Px' disabled/>%</td>";
				echo "<td rowspan=3><a href=\"edit_factura.php?cod_fac=$data\"><input type=\"button\" value=\"Editar\"></a></td>";
                echo "</tr>";

                echo "<tr ";
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd>"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff>"; //si el resto de la división NO es 0 pongo otro color 
                echo "<td colspan=5>";
                echo "Detalles:<br/>";
                if ($row['detalles'] != NULL) {
                    echo "<textarea name='detalles' rows='3' cols='60' disabled>$row[detalles]</textarea>";
                } else {
                    echo "<textarea name='detalles' rows='3' cols='60' disabled></textarea>";
                }
                echo "</td>";

                //echo "<td><a href='edit_det_fac.php?cod_fac=$data'><input type='button' value='Editar'></a></td>";
                echo "</tr>";

                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd>"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff>"; //si el resto de la división NO es 0 pongo otro color 
                echo "<td colspan=5>";
                if ($row['cuenta_laboral'] != NULL) {
                    echo "<input type='checkbox' name='cuenta[]' value='laboral' checked='checked' disabled/>";
                } else {
                    echo "<input type='checkbox' name='cuenta[]' value='laboral' disabled/>";
                }
                echo "Nº Cta. Laboral: 11111<br/>";
                if ($row['cuenta_kutxa'] != NULL) {
                    echo "<input type='checkbox' name='cuenta[]' value='kutxa' checked='checked' disabled/>";
                } else {
                    echo "<input type='checkbox' name='cuenta[]' value='kutxa' disabled/>";
                }
                echo "Nº Cta. Kutxa: 111111";
                echo "</td>";

                //echo "<td><a href='edit_cue_fac.php?cod_fac=$data'><input type='button' value='Editar'></a></td>";
                echo "</tr>";
                echo "</form>";
                echo "</table>";

                echo "<br/>";

                echo "<table border=1>";
                echo "<tr bgcolor=\"bbbbbb\" align=center><th colspan=2>Orden</th><th>Concepto</th><th>Cantidad</th><th>Precio</th></tr>";
                
                $selec2 = mysql_query("SELECT concepto, cantidad, precio_u as precio, orden FROM tener_f_c WHERE cod_fac='$data' ORDER BY orden");
                $numResults = mysql_num_rows($selec2);
                $counter = 0;
                while ($row2 = mysql_fetch_assoc($selec2)) {
                    $concepto = $row2['concepto'];
                    $orden = $row2['orden'];
                    if ($row2['concepto'] == $data2) {
                        echo "<form enctype='multipart/form-data' action='edit_con_fact_act.php?cod_fac=$data' method='post'>";

                        echo "<tr "; 
                        if ($num_fila%2==0) 
                            echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                        else 
                            echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                        echo ">";

                        echo "<td>$orden</td>";
                        if (++$counter == $numResults) {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a></td>";
                        } elseif ($counter == 1) {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                        } else {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a><br/>";
                            echo "<a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                        }
                        //echo "<td>";
                        echo "<td><select name='concepto3' onchange='change(this,1,$row2[precio])' style='white-space:pre-wrap; width: 250px;'>";
                        echo "<option value='1' selected='selected'>Otro</option>";
                        $sql2 = "SELECT * FROM conceptos";
                        $cons = mysql_query($sql2);
                        while ($row4 = mysql_fetch_assoc($cons)) {
                            print("<option value='".$row4['concepto']."|".$row4['precio']."'>$row4[concepto]</option>");
                        }
                        
                        echo "</select><br/>";
                        echo "<textarea id='text_area1' name='concepto1' rows='3' cols='40'>$row2[concepto]</textarea><textarea name='concepto2' style='display: none'>$row2[concepto]</textarea>";
                        echo "</td>";
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
                        echo "<td>$orden</td>";
                        if (++$counter == $numResults) {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a></td>";
                        } elseif ($counter == 1) {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                        } else {
                            echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a><br/>";
                            echo "<a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                        }

                        echo "<td><textarea rows='3' cols='40' disabled>$row2[concepto]</textarea></td>";
                        echo "<td><input type='number' value='$row2[cantidad]' Style='width:40Px' disabled/></td>";
                        echo "<td><input type='number' step='any' Style='width:60Px' value='$row2[precio]' disabled/>€</td>";
                        echo "<td><a href=\"edit_con_fac.php?cod_fac=$data&concepto=$row2[concepto]\"><input type=\"button\" value=\"Editar\"></a><br/>";
                        echo "<button onclick=\"seguro('".$row2['concepto']."',".$row['cod_fac'].",".$row2['orden'].");\">Eliminar</button></td>";
                        echo "</tr>";
                        //echo "</form>";
                    }
                    
                }
                //echo "<td>$row[precio]€</td>";
                //echo "<td><a href=\"edit_conce.php?concepto=$row[cod_con]\"><input type=\"button\" value=\"Editar\"></a></td>";
                //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
                //echo "</tr>";

                echo "<form enctype='multipart/form-data' action='add_con_fact_act.php?cod_fac=$data' method='post'>"; 
                echo "<tr "; 
                if ($num_fila%2==0) 
                    echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                else 
                    echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                echo "><td colspan=2></td>";
                echo "<td><select name='concepto3' onchange='change(this,2,0)' style='white-space:pre-wrap; width: 250px;'>";
                echo "<option selected='selected'></option>";
                echo "<option value='1'>Otro</option>";
                $sql3 = "SELECT * FROM conceptos";
                $adcons = mysql_query($sql3);
                while ($row6 = mysql_fetch_assoc($adcons)) {
                    echo "<option value='"
                        .$row6['concepto'].
                        "|"
                        .$row6['precio'].
                        "'>$row6[concepto]</option>";
                }
                        
                echo "</select><br/>";
                echo "<textarea id='text_area2' name='concepto2' rows='3' cols='40' style='display: none'></textarea>";
                echo "</td>";
                echo "<td><input type='number' name='cant2' value='1' Style='width:40Px'/></td>";
                echo "<td><input id='precio2' type='number' name='precio2' step='any' Style='width:60Px' value=''/>€</td>";
                echo "<td><input type='submit' name='addc' value='Añadir'/></td>";
                echo "</tr>";
                echo "</form>";

                $num_fila++;
            }
            echo "</table>";

/*if(isset($_POST['addc'])){
    $cantidad = $_POST['cant2'];
    $precio = $_POST['precio2'];
    if ($_POST['concepto3'] == 1) {
        $concepto = $_POST['concepto2'];
    }else{
        $conc = explode('|', $_POST['concepto3']);
        $concepto = $conc[0];
    }
    $concepto = trim(preg_replace('/\s\s+/', ' ', $concepto));
    $gehitu="INSERT INTO tener_f_c (concepto,cod_fac,cantidad,precio_u) VALUES ('$concepto',$data,$cantidad,'$precio')";
    mysql_query($gehitu);
    header("Location: edit_factura.php?cod_fac=$data");
}*/

/*if(isset($_POST['guardarc'])){
    $concepto2 = $_POST['concepto2'];
    $cantidad = $_POST['cant1'];
    $precio = $_POST['precio1'];
	if ($_POST['concepto3'] == 1) {
		$concepto = $_POST['concepto1'];
	} else {
		$conce = explode('|', $_POST['concepto3']);
		$concepto =  $conce[0];
	}
	$aldatu="UPDATE tener_f_c SET concepto='$concepto',cantidad=$cantidad,precio_u='$precio' WHERE cod_fac=$data AND concepto='$concepto2'";
	mysql_query($aldatu);

    //header("Location: manage_facturas.php");
	header("Location: edit_factura.php?cod_fac=$data");
    //header("Refresh:0");
}*/

mysql_close($dp);
?>
<br/>
<a href="manage_facturas.php"><input type="button" value="Atrás"></a>
</body>
</html>