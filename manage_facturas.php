<html>
<head><title>Buscar factura</title></head>
<body>
    <?php
    $dp = mysql_connect("localhost", "root", "" );
    mysql_select_db("facturas", $dp);
    ?>
 
    <script type="text/javascript">
    function change(obj) {
        var selectBox = obj;
        var selected = selectBox.options[selectBox.selectedIndex].value;
        var textarea = document.getElementById("text_area");

        if(selected === "1"){
            textarea.style.display = "block";
        }
        else{
            textarea.style.display = "none";
        }
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
        <input type="checkbox" name="buscar[]" value="fecha">Fecha: <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>"/><br><br>

        <input type="checkbox" name="buscar[]" value="numero">Nº de factura: <input type="number" name="num"/><br><br>

        <input type="checkbox" name="buscar[]" value="cliente"><label>Cliente:</label> 
        <select name="cli1" onchange="changeCli(this)">
            <option selected="selected"></option>
            <option value="1">Otro</option>
            <?php
            $sql = "SELECT * FROM clientes";
            $clis = mysql_query($sql);
            while ($row = mysql_fetch_assoc($clis)) {
                print("<option value='".$row[direccion]."|".$row[cif]."'>$row[direccion]</option>");
            }
            ?></select><input id="cif1" type="text" name="cif1" value="" style="display: none" disabled/><textarea id="cliente1" name="cliente1" rows="5" style="display: none"></textarea><br><br>

        <input type="checkbox" name="buscar[]" value="concepto">
        <label>Concepto:</label> 
            <select name="conce" onchange="change(this)">
                <option selected="selected"></option>
                <option value="1">Otro</option>
                <?php
                    $sql = "SELECT * FROM conceptos";
                    $cons = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($cons)) {
                        print("<option value='".$row[concepto]."'>$row[concepto]</option>");
                    }
                ?>
            </select><textarea id="text_area" name="concepto" rows="1" cols="50" style="display: none"></textarea><br><br>
        <input type="checkbox" name="buscar[]" value="iva">IVA: <input type="number" name="iva" value="21" Style="width:40Px"/><br><br>
        <input type="submit" name="buscar1" value="Buscar"/>
    </form>
    <?php
    if(isset($_POST['buscar1'])){
        $sele = "";
        $buscar = $_POST['buscar'];

        function IsChecked($chkname,$value){
            if(!empty($_POST[$chkname])){
                foreach($_POST[$chkname] as $chkval){
                    if($chkval == $value){
                        return true;
                    }
                }
            }
            return false;
        }

        /*if ($_POST['buscar'][0] == "fecha"){
            $fecha = date_format(date_create_from_format('Y-m-d', $_POST['fecha']), 'd/m/Y');
            $self = "SELECT * FROM facturas WHERE fecha=$fecha";
            if(count($sele)==0){
                array_push($sele, "");
            } else {

            }
        }*/
        if (IsChecked('buscar','numero')){
            $numero = $_POST['num'];
            $selnu = "SELECT * FROM facturas WHERE cod_fac=$numero";
            if($sele == ""){
                $sele = $selnu;
            } else {
                $sele = $sele." UNION ".$selnu;
            }
        }
        /*if ($_POST['buscar'][1] == "numero"){
            $numero = $_POST['num'];
            $selnu = "SELECT * FROM facturas WHERE cod_fac=$numero";
            if(count($sele)==0){
                array_push($sele, $selnu);
            } else {
                array_push($sele, " UNION " $selnu);
            }
        }*/
        if (IsChecked('buscar','concepto')){
            $concepto = $_POST['conce'];
            $selcon = "SELECT * FROM facturas WHERE cod_fac=(SELECT cod_fac FROM tener_f_c WHERE concepto='$concepto')";
            if($sele == ""){
                $sele = $selcon;
            } else {
                $sele = $sele." UNION ".$selcon;
            }
        }
        if (IsChecked('buscar','iva')){
            $iva = $_POST['iva'];
            $seliv = "SELECT * FROM facturas WHERE IVA=$iva";
            if($sele == ""){
                $sele = $seliv;
            } else {
                $sele = $sele." UNION ".$seliv;
            }
        }
        echo $sele;
    }
    ?>
</body>
</html>