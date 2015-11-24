<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$numero = $_GET['cod_fac'];
$selfac = mysql_query("SELECT fecha,cliente,existe_cli,IVA,cuenta_laboral,cuenta_kutxa,detalles FROM facturas WHERE cod_fac=$numero");
$fecha = mysql_result($selfac,0,0);
$fecha = date_format(date_create_from_format('Y-m-d', $fecha), 'd/m/Y');
$cli1 = mysql_result($selfac,0,1);
$excli = mysql_result($selfac,0,2);
$iva = mysql_result($selfac,0,3);
$laboral = mysql_result($selfac,0,4);
$kutxa = mysql_result($selfac,0,5);
$detalles = mysql_result($selfac,0,6);

//while ($row = mysql_fetch_assoc($selfac)) {
    //$fecha = $row['fecha'];
    //$cli1 = $row['cliente'];
    //$excli = $row['existe_cli'];
    //$iva = $row['IVA'];

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Madrid');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$worksheet = $objPHPExcel->getActiveSheet();

//Margin
$objPHPExcel->getActiveSheet()
    ->getPageMargins()->setTop(0.39);
$objPHPExcel->getActiveSheet()
    ->getPageMargins()->setBottom(0.39);
//$objPHPExcel->getActiveSheet()
//    ->getPageMargins()->setRight(0.75);
//$objPHPExcel->getActiveSheet()
//    ->getPageMargins()->setLeft(0.75);

//Hide lines - Ocultar lineas
$objPHPExcel->getActiveSheet()
    ->setShowGridlines(false);


//Uniendo celdas - Merge Cells
$arrayMerges = array('E2:G6','A51:G51','A1:C2','A3:C3','A4:C4','A5:C5','A6:C6','A7:C7','B15:E15','F49:G49','A11:G11','A12:G13');

foreach ($arrayMerges as &$valor) {
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($valor);
}

unset($valor);

//Añadiendo bordes - Adding borders
$borderArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$arrayBordes = array('E2:G6', 'A10:B10', 'C10:E10', 'F10:G10', 'A15', 'B15:E15', 'F15', 'G15', 'A16:A46', 'B16:E46', 'F16:F46', 'G16:G46', 'A11:G11', 'A12:G13');

foreach ($arrayBordes as &$valor) {
    $worksheet->getStyle($valor)->applyFromArray($borderArray);
}

unset($valor);

unset($borderArray);

//Añadiendo lineas de puntos - Adding dotted lines
$worksheet->getStyle('A16:G46')->getBorders()->getHorizontal()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
$worksheet->getStyle('F49:G49')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

//Cambiando tamaño de las celdas - Changing cells dimensions
$worksheet->getColumnDimension('A')->setWidth(11);
$worksheet->getColumnDimension('B')->setWidth(13);
$worksheet->getColumnDimension('C')->setWidth(11);
$worksheet->getColumnDimension('D')->setWidth(15);
$worksheet->getColumnDimension('E')->setWidth(13);
$worksheet->getColumnDimension('G')->setWidth(11);

$worksheet->getRowDimension(51)->setRowHeight(45);
//$worksheet->getRowDimension(51)->setRowHeight(-1);
//$excel->getActiveSheet()->getRowDimension($_row_number)->setRowHeight(-1);

//Centrando texto - Text alignement
$worksheet->getStyle('A1:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('A15:G15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('B2:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('A16:G46')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('F49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$worksheet->getStyle('A11:G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$worksheet->getStyle('A12:G13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$worksheet->getStyle('B10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$worksheet->getStyle('G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$worksheet->getStyle('A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E2:G6')->getAlignment()->setWrapText(true);
$worksheet->getStyle('A51')->getAlignment()->setWrapText(true);
$worksheet->getStyle('A16:G46')->getAlignment()->setWrapText(true);
$worksheet->getStyle('A12:G13')->getAlignment()->setWrapText(true);

//Cambiando tipo de letra, tamaño, ... - Changing letter type, size, ...
$worksheet->getStyle('A1')->getFont()->setName('Britannic Bold')->setSize(13)->setBold(true);
$worksheet->getStyle('A3')->getFont()->setName('Lucida Calligraphy')->setSize(10);
$worksheet->getStyle('A4:A7')->getFont()->setName('Palatino Linotype')->setSize(10);
$worksheet->getStyle('A15:G15')->getFont()->setName('Century')->setSize(10);

$worksheet->getStyle('A10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('F10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('A11:G11')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('A12:G13')->getFont()->setName('Calibri')->setSize(11);
//$worksheet->getStyle('E10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);

$worksheet->getStyle('A51')->getFont()->setName('Arial')->setSize(6); 

//Dando formato al texto - Formating text
$worksheet->getStyle('G10')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
$worksheet->getStyle('A16:A46')->getNumberFormat()->setFormatCode('0');
$worksheet->getStyle('F16:G46')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('A49')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('C49')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('F49')->getNumberFormat()->setFormatCode('0.00€');

//Añadiendo datos por defecto - Adding default data
$objPHPExcel->setActiveSheetIndex(0)
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ->setCellValue('A1', 'MANTENIMIENTO DEL HOGAR')
            ->setCellValue('A3', '******* **** *******')
            ->setCellValue('A4', 'Telf: *** *** ***  - *** *** ***')
            ->setCellValue('A5', '******* *****, ** ***** *******')
            ->setCellValue('A6', 'D.N.I **.***.***-*')
            ->setCellValue('A7', 'E-mail: *****.****@hotmail.com');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($excli == 0) {
                $cliente = $cli1;
            }else{
                $cli = mysql_query("SELECT direccion,cif FROM clientes WHERE cif='$cli1'");
                $direccion = mysql_result($cli,0,0);
                $cif = mysql_result($cli,0,1);
                $cliente = $direccion."\n".$cif;
            }

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E2', $cliente)

            ->setCellValue('A10', 'Factura Nº: ')
            ->setCellValue('B10', $numero)

            ->setCellValue('A11', 'Detalles:');
            if ($detalles != NULL) {
                //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B45:E45');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12', $detalles);
            }

$objPHPExcel->setActiveSheetIndex(0)
            /*->setCellValue('E10', 'Método de pago: ')
            ->setCellValue('F10', $pago)*/
            ->setCellValue('F10', 'Fecha: ')
            ->setCellValue('G10', $fecha)

            ->setCellValue('A15', 'Cantidad')
            ->setCellValue('B15', 'Concepto')
            ->setCellValue('F15', 'Precio')
            ->setCellValue('G15', 'Importe');

            //$a = 1;
            $i=16;
            $conce = mysql_query("SELECT * FROM tener_f_c WHERE cod_fac=$numero ORDER BY orden");
            while ($row2 = mysql_fetch_assoc($conce)) {
                $concepto = $row2['concepto'];
                $cantidad = $row2['cantidad'];
                $precio = $row2['precio_u'];
                //for ($i=16; $i<=46; $i++){

                //if (isset($_POST['cant'.$a])){

                /*if ($_POST['conce'.$a] == 1) {
                    $concepto = $_POST['concepto'.$a];
                }else{
                    $conc = explode('|', $_POST['conce'.$a]);
                    $concepto = $conc[0];
                }*/
                $concepto = trim(preg_replace('/\s\s+/', ' ', $concepto));
                //$concepto = str_replace("\n"," ",$concepto);
                $letras = strlen($concepto); //47

                if ($letras > 47){
                        
                    for ($t=1; $t<=34; $t++){
                        if ($letras > (47*$t)){
                             $s = $i + $t;
                        }
                    }

                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':A'.$s);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':E'.$s);
                    //$worksheet->getStyle('B'.$i)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$i.':F'.$s);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$i.':G'.$s);

                    //$canti = $_POST['cant'.$a];
                    //$preci = $_POST['precio'.$a];

                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$i, $cantidad)
                                ->setCellValue('B'.$i, '    '.$concepto)
                                ->setCellValue('F'.$i, $precio);

                    $i++;
                } elseif ($letras != 0) {
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':E'.$i);

                    //$canti = $_POST['cant'.$a];
                    //$preci = $_POST['precio'.$a];

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i, $cantidad)
                        ->setCellValue('B'.$i, '    '.$concepto)
                        ->setCellValue('F'.$i, $precio);
                }
                //}
                //$a++;
                $i++;
            }

            for ($u=16; $u<=46; $u++){
                //$worksheet->getRowDimension($u)->setRowHeight(14);
                $vaca = $worksheet->getCell('A'.$u)->getValue();
                $vacf = $worksheet->getCell('F'.$u)->getValue();
                if (($vaca!=0||$vaca!="")||($vacf!=0||$vacf!="")){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$u, '=A'.$u.'*F'.$u);
                }
            }
            if ($laboral != NULL) {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B44:E44');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B44', $laboral);
            }
            if ($kutxa != NULL) {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B45:E45');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B45', $kutxa);
            }

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A48', 'Subtotal')
            ->setCellValue('A49', '=SUM(G16:G46)')
            ->setCellValue('C48', 'IVA '.$iva.'%')
            ->setCellValue('C49', '=A49*'.$iva.'%')
            ->setCellValue('E49', 'TOTAL:')
            ->setCellValue('F49', '=A49+C49')

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ->setCellValue('A51', 'De conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//No esta permitido un footer tan largp
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&6&ArialDe conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&6&ArialDe conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');


//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&6&ArialDe conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');
// Rename worksheet
$worksheet->setTitle('Factura');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
//$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$objWriter->save('C:\facturas/'.$numero.'.xlsx');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//$callEndTime = microtime(true);
//$callTime = $callEndTime - $callStartTime;
//echo "La factura ".$numero.".xlsx se ha creado correctamente.";

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;

//}

mysql_close($dp);
header("Location: manage_facturas.php");
?>