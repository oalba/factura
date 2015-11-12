<html>
<head>
<title>Editar cliente</title>
</head>
<body>
    <h1><u><i>Editar factura</i></u></h1>
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

$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$sql = "SELECT * FROM facturas WHERE cod_fac=$data";
$facs = mysql_query($sql);







$num_fila = 0; 
            echo "<table border=1>";
            echo "<tr bgcolor=\"bbbbbb\" align=center><th>Codigo</th><th>Fecha</th><th>Cliente</th><th>CIF</th><th>IVA %</th><th></th><th>Concepto</th><th>Cantidad</th><th>Precio</th></tr>";
            while ($row = mysql_fetch_assoc($facs)) {
                echo "<form enctype='multipart/form-data' action='edit_fac_act.php?cod_fac=$data' method='post'>";
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
            		echo "<option value='1' selected='selected' style='white-space:pre-wrap; width: 100px;'>Otro</option>";
            		$sqlc = "SELECT * FROM clientes";
            		$clis = mysql_query($sqlc);
            		while ($row4 = mysql_fetch_assoc($clis)) {
                		print("<option value='".$row4[direccion]."|".$row4[cif]."'>$row4[direccion]</option>");
            		}
        
        			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5'>$row[cliente]</textarea></td><td><input id='cif1' type='text' name='cif1' value='' style='display: none' disabled/></td>";
                }else{

                    $selec3 = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$row[cliente]'");
                    //while ($row5 = mysql_fetch_assoc($selec3)) {
                        //$direccion = $row5['direccion'];
                        //$cif = $row5['cif'];
                        $direccion = mysql_result($selec3,0,0);
                        $cif = mysql_result($selec3,0,1);
                        /*echo "<td>$direccion</td>";
                        echo "<td>$cif</td>";*/
                        //while ($row3 = mysql_fetch_assoc($selec3)) {
                            //echo "<td>$row3[direccion]</td>";
                            //echo "<td>$row3[cif]</td>";
                        //}
                        echo "<td><select name='cli1' onchange='changeCli(this)' style='white-space:pre-wrap; width: 100px;'>";
                		echo "<option value='1'>Otro</option>";
                		$sqld = "SELECT * FROM clientes";
                		$clis = mysql_query($sqld);
                		while ($row3 = mysql_fetch_assoc($clis)) {
                			if ($cif == $row3['cif']) {
                				print("<option value='".$row3[direccion]."|".$row3[cif]."' selected='selected'>$row3[direccion]</option>");
                			} else {
                				print("<option value='".$row3[direccion]."|".$row3[cif]."'>$row3[direccion]</option>");
                			}
                		}
            
            			echo "</select><br/><textarea id='cliente1' name='cliente1' rows='5' style='display: none'></textarea></td><td><input id='cif1' type='text' name='cif1' value='$cif' disabled/></td>";
                    //}

                }
                echo "<td><input type='number' name='iva' value='$row[IVA]' Style='width:40Px'/>%</td><th></th><th>Concepto</th><th>Cantidad</th><th>Precio</th>";
                echo "<td><input type='submit' name='guardarf' value='Guardar'/></td>";
				echo "</tr>";
				echo "</form>";
                $selec2 = mysql_query("SELECT concepto, cantidad, precio_u, orden FROM tener_f_c WHERE cod_fac=$data ORDER BY orden");
                //$nu = 1;
                $numResults = mysql_num_rows($selec2);
                $counter = 0;
                while ($row2 = mysql_fetch_assoc($selec2)) {
                    $concepto = $row2['concepto'];
                    $precio = $row2['precio_u'];
                    $orden = $row2['orden'];
                	//echo "<form enctype='multipart/form-data' action='edit_con_fac.php' method='post'>";
                    echo "<tr "; 
                    if ($num_fila%2==0) 
                        echo "bgcolor=#dddddd"; //si el resto de la división es 0 pongo un color 
                    else 
                        echo "bgcolor=#ddddff"; //si el resto de la división NO es 0 pongo otro color 
                    echo ">";
                    echo "<td colspan='5'>$orden</td>";
                    if (++$counter == $numResults) {
                        echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a></td>";
                    } elseif ($counter == 1) {
                        echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                    } else {
                        echo "<td><a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=subir&orden=$orden'><input type='button' value='Subir'></a><br/>";
                        echo "<a href='edit_con_fac_ord.php?cod_fac=$data&concepto=$concepto&accion=bajar&orden=$orden'><input type='button' value='Bajar'></a></td>";
                    }
                    
                    
                    echo "<td><textarea rows='3' cols='40' disabled>".$concepto."</textarea></td>";
                    //echo "<td>".$concepto."</td>";
                    echo "<td><input type='number' value=".$row2['cantidad']." Style='width:40Px' disabled/></td>";
                    //echo "<td>$row2[cantidad]</td>";
                    echo "<td><input type='number' step='any' Style='width:60Px' value='$precio' disabled/>€</td>";
                    echo "<td><a href='edit_con_fac.php?cod_fac=$data&concepto=$concepto'><input type='button' value='Editar'></a><br/>";
                    echo "<button onclick=\"seguro('".$row2['concepto']."',".$row['cod_fac'].",".$row2['orden'].");\">Eliminar</button></td>";
					echo "</tr>";
                }
                //echo "<td><button onclick=\"seguro($row[cod_con]);\">Delete</button></td>";
                //echo "</tr>";
                

                echo "<form enctype='multipart/form-data' action='add_con_fact_act.php?cod_fac=$data' method='post'>"; 
                echo "<tr><td colspan=6></td>";
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
/*function f5($data)
{
    header("Location: edit_factura.php?cod_fac=$data");
}*/
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
    //header("Refresh:0");
    f5($data);
}*/
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
f5($data);
//header("Location: edit_factura.php?cod_fac=$data");
}*/

mysql_close($dp);
?>
<br/>
<a href="manage_facturas.php"><input type="button" value="Atrás"></a>
</body>
</html>