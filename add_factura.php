<html>
<head><title>Añadir factura</title></head>
<body>
    <h1><u><i>Nueva factura</i></u></h1>
    <?php
    $dp = mysql_connect("localhost", "root", "" );
    mysql_select_db("facturas", $dp);
    ?>
<?php
    echo "
    <script type=\"text/javascript\">
    var nu = 2;
    function myFunction() {
        var ic = document.createTextNode('Cantidad: ');

        var ic1 = document.createElement('INPUT');
        ic1.setAttribute('type', 'number');
        ic1.setAttribute('name', 'cant'+nu);
        ic1.setAttribute('value', '1');
        ic1.setAttribute('Style', 'width:40Px');

        //---------------------------------------------

        var io = document.createTextNode(' Concepto: ');

        var io3 = document.createElement('select');
        //io3.id = 'mySelect';
        //io3.setAttribute('id', 'show'+nu);
        io3.setAttribute('name', 'conce'+nu);
        io3.setAttribute('style', 'white-space:pre-wrap; width: 250px;');
        io3.setAttribute('onchange', 'change(this,'+nu+')');

        var no = document.createElement('option');
        no.value = '';
        no.text = '';
        no.setAttribute('selected', 'selected');
        io3.appendChild(no);

        var yes = document.createElement('option');
        yes.value = '1';
        yes.text = 'Otro';
        io3.appendChild(yes);";

        $sql = 'SELECT * FROM conceptos';
        $cons = mysql_query($sql);
        while ($row = mysql_fetch_assoc($cons)) {
            echo "var abc = document.createElement('option');";
            echo "abc.value = '$row[concepto]|$row[precio]';";
            echo "abc.text = '$row[concepto]';";
            echo "io3.appendChild(abc);";
        }

        
        echo "
        //Create array of options to be added
        //var array = ['YES','NO'];
        //Create and append the options
        /*for (var i = 0; i < array.length; i++) {
            var option = document.createElement('option');
            option.value = array[i];
            option.text = array[i];
            if (array[i] == 'NO') {
                option.setAttribute('selected', 'selected');
            }
            io3.appendChild(option);
        }*/

        var io2 = document.createElement('TEXTAREA');
        io2.setAttribute('id', 'text_area'+nu);
        io2.setAttribute('name', 'concepto'+nu);
        io2.setAttribute('cols', '50');
        io2.setAttribute('rows', '1');
        io2.setAttribute('style', 'display: none');

        //---------------------------------------------

        var ip = document.createTextNode(' Precio: ');

        var ip3 = document.createElement('INPUT');
        ip3.setAttribute('type', 'number');
        ip3.setAttribute('id', 'precio'+nu);
        ip3.setAttribute('name', 'precio'+nu);
        ip3.setAttribute('step', 'any');
        ip3.setAttribute('Style', 'width:60Px');

        var ie = document.createTextNode('€');
        //var hr = document.createElement('HR');
        

        /*var wrapper = document.getElementById('divWrapper');
        wrapper.appendChild(hr);
        wrapper.appendChild(ic);
        wrapper.appendChild(ic1);
        wrapper.appendChild(io);
        wrapper.appendChild(io3);
        wrapper.appendChild(io2);
        wrapper.appendChild(ip);
        wrapper.appendChild(ip3);
        wrapper.appendChild(ie);*/

        var tr = document.createElement('TR');
        var td1 = document.createElement('TD');
        var td2 = document.createElement('TD');
        var td3 = document.createElement('TD');
        td1.appendChild(ic);
        td1.appendChild(ic1);
        td2.appendChild(io);
        td2.appendChild(io3);
        td2.appendChild(io2);
        td3.appendChild(ip);
        td3.appendChild(ip3);
        td3.appendChild(ie);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        var wrapper = document.getElementById('myTable');
        wrapper.appendChild(tr);

        nu = nu+1;
     }</script>";
 
    ?>

    <script type="text/javascript">
    function change(obj,nue) {
        var selectBox = obj;
        var nue = nue;
        var selected = selectBox.options[selectBox.selectedIndex].value;
        var sele = selected.split("|");
        var textarea = document.getElementById("text_area"+nue);

        if(sele[0] === "1"){
            textarea.style.display = "block";
        }
        else{
            textarea.style.display = "none";
        }
        document.getElementById("precio"+nue).value = sele[1];
    }

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

    <style type="text/css">
        table { border: 1px solid black; border-collapse: collapse }
        td { border: 1px solid black }
    </style>

    <form enctype="multipart/form-data" action="" method="post">
        Fecha: <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>"/><br><br>

        Nº de factura: <input type="number" name="num" required/><br><br>

        <label>Cliente:</label> 
        <select name="cli1" onchange="changeCli(this)" style="white-space:pre-wrap; width: 100px;">
            <option selected="selected"></option>
            <option value="1">Otro</option>
            <?php
            $sql = "SELECT * FROM clientes";
            $clis = mysql_query($sql);
            while ($row = mysql_fetch_assoc($clis)) {
                print("<option value='".$row[direccion]."|".$row[cif]."'>$row[direccion]</option>");
            }
        ?></select><input id="cif1" type="text" name="cif1" value="" style="display: none" disabled/><textarea id="cliente1" name="cliente1" rows="5" style="display: none"></textarea><br><br>

        Conceptos: 
        <table id="myTable">
            <tr>
                <td><label>Cantidad:</label> <input type="number" name="cant1" value="1" Style="width:40Px"/> </td>
                <td><label>Concepto:</label> 
                <select name="conce1" onchange="change(this,1)" style="white-space:pre-wrap; width: 250px;">
                    <option selected="selected"></option>
                    <option value="1">Otro</option>
                    <?php
                    $sql = "SELECT * FROM conceptos";
                    $cons = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($cons)) {
                        print("<option value='".$row[concepto]."|".$row[precio]."'>$row[concepto]</option>");
                    }
                    ?>
                </select><textarea id="text_area1" name="concepto1" rows="1" cols="50" style="display: none"></textarea></td>
                <td><label>Precio:</label> <input id="precio1" type="number" name="precio1" step="any" Style="width:60Px" value=""/>€</td>
            </tr>
        </table>
        <button type="button" onclick="myFunction()">Añadir</button><br><br>
        IVA: <input type="number" name="iva" value="21" Style="width:40Px"/><br><br>
        <input type="submit" name="crear" value="Crear"/>
    </form>
<?php
if(isset($_POST['crear'])){
    $fecha = date_format(date_create_from_format('Y-m-d', $_POST['fecha']), 'd/m/Y');
    $insfecha = date("Y-m-d",strtotime($_POST['fecha']));
    $numero = $_POST['num'];
    $cli1 = $_POST['cli1'];
    $iva = $_POST['iva'];

    $comprobar = "SELECT * FROM facturas WHERE cod_fac=$numero";
    $compro = mysql_query($comprobar);
    if (mysql_num_rows($compro) != 0){
        echo "¡ERROR! La factura con este código ya existe.";
    }else{
        if ($_POST['cli1'] == 1) {
            $cliente = $_POST['cliente1'];
            $inscli = $_POST['cliente1'];
            $existe = "FALSE";
        }else{
            $cli = explode('|', $_POST['cli1']);
            $cliente = $cli[0]."\n".$cli[1];
            $inscli = $cli[1];
            $existe = "TRUE";
        }


        //$a = 1;
        for ($i=1; $i<=41; $i++){

            if (isset($_POST['cant'.$i])){

                if ($_POST['conce'.$i] == 1) {
                    $concepto = $_POST['concepto'.$i];
                }else{
                    $conc = explode('|', $_POST['conce'.$i]);
                    $concepto = $conc[0];
                }
                $concepto = trim(preg_replace('/\s\s+/', ' ', $concepto));

                $canti = $_POST['cant'.$i];
                $preci = $_POST['precio'.$i];

                $insertcon = "INSERT INTO tener_f_c (orden,concepto,cod_fac,cantidad,precio_u) VALUES ($i,'$concepto',$numero,$canti,'$preci')";
                mysql_query($insertcon);
            }
            //$a++;
        }

        $insertfac = "INSERT INTO facturas (cod_fac,fecha,IVA,existe_cli,cliente) VALUES ($numero,'$insfecha',$iva,$existe,'$inscli')";
        mysql_query($insertfac);
    }

}

mysql_close($dp);
?>
</body>
</html>