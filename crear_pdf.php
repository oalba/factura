<?php
$dp = mysql_connect("localhost", "root", "" );
mysql_select_db("facturas", $dp);

$numero = $_GET['cod_fac'];
$selfac = mysql_query("SELECT fecha,cliente,existe_cli,IVA FROM facturas WHERE cod_fac=$numero");
$fecha = mysql_result($selfac,0,0);
$fecha = date_format(date_create_from_format('Y-m-d', $fecha), 'd/m/Y');
$cli1 = mysql_result($selfac,0,1);
$excli = mysql_result($selfac,0,2);
$iva = mysql_result($selfac,0,3);

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
require_once dirname(__FILE__) . '/phpexcel/Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/phpexcel/Classes/PHPExcel/Writer/PDF.php';

//  Change these values to select the Rendering library that you wish to use
//      and its directory location on your server
$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
//$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
//$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
$rendererLibrary = 'tcPDF5.9';
//$rendererLibrary = 'tcpdf';
//$rendererLibrary = 'mPDF.php';
//$rendererLibrary = 'mPDF5.4';
//$rendererLibrary = 'mPDF6.0';
//$rendererLibrary = 'mPDF';
//$rendererLibrary = 'domPDF0.6.0beta3';
$rendererLibraryPath = dirname(__FILE__) . '/phpexcel/Classes/PHPExcel/Writer/PDF/' . $rendererLibrary;



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$worksheet = $objPHPExcel->getActiveSheet();

//Uniendo celdas - Merge Cells
$arrayMerges = array('E2:G6','A46:G46','A1:C2','A3:C3','A4:C4','A5:C5','A6:C6','A7:C7','B12:E12','F44:G44');

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

$arrayBordes = array('E2:G6', 'A10:B10', 'C10:E10', 'F10:G10', 'A12', 'B12:E12', 'F12', 'G12', 'A13:A41', 'B13:E41', 'F13:F41', 'G13:G41');

foreach ($arrayBordes as &$valor) {
    $worksheet->getStyle($valor)->applyFromArray($borderArray);
}

unset($valor);

unset($borderArray);

//Añadiendo lineas de puntos - Adding dotted lines
$worksheet->getStyle('A13:G41')->getBorders()->getHorizontal()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
$worksheet->getStyle('F44:G44')->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

//Cambiando tamaño de las celdas - Changing cells dimensions
$worksheet->getColumnDimension('A')->setWidth(11);
$worksheet->getColumnDimension('B')->setWidth(13);
$worksheet->getColumnDimension('C')->setWidth(11);
$worksheet->getColumnDimension('D')->setWidth(13);
$worksheet->getColumnDimension('E')->setWidth(13);
$worksheet->getColumnDimension('G')->setWidth(11);

$worksheet->getRowDimension(46)->setRowHeight(45);
//$worksheet->getRowDimension(46)->setRowHeight(-1);
//$excel->getActiveSheet()->getRowDimension($_row_number)->setRowHeight(-1);

//Centrando texto - Text alignement
$worksheet->getStyle('A1:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('A12:G12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('B2:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('A13:G41')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('F44')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$worksheet->getStyle('B10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$worksheet->getStyle('G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$worksheet->getStyle('A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E44')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$worksheet->getStyle('E2:G6')->getAlignment()->setWrapText(true);
$worksheet->getStyle('A46')->getAlignment()->setWrapText(true);
$worksheet->getStyle('A13:G41')->getAlignment()->setWrapText(true);

//Cambiando tipo de letra, tamaño, ... - Changing letter type, size, ...
$worksheet->getStyle('A1')->getFont()->setName('Britannic Bold')->setSize(13)->setBold(true);
$worksheet->getStyle('A3')->getFont()->setName('Lucida Calligraphy')->setSize(10);
$worksheet->getStyle('A4:A7')->getFont()->setName('Palatino Linotype')->setSize(10);
$worksheet->getStyle('A12:G12')->getFont()->setName('Century')->setSize(10);

$worksheet->getStyle('A10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('F10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
//$worksheet->getStyle('E10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);

$worksheet->getStyle('A46')->getFont()->setName('Arial')->setSize(6); 

//Dando formato al texto - Formating text
$worksheet->getStyle('G10')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
$worksheet->getStyle('A13:A41')->getNumberFormat()->setFormatCode('0');
$worksheet->getStyle('F13:G41')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('A44')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('C44')->getNumberFormat()->setFormatCode('0.00€');
$worksheet->getStyle('F44')->getNumberFormat()->setFormatCode('0.00€');

//Añadiendo datos por defecto - Adding default data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'MANTENIMIENTO DEL HOGAR')
            ->setCellValue('A3', '******* **** *******')
            ->setCellValue('A4', 'Telf: *** *** ***  - *** *** ***')
            ->setCellValue('A5', '******* *****, ** ***** *******')
            ->setCellValue('A6', 'D.N.I **.***.***-*')
            ->setCellValue('A7', 'E-mail: *****.****@hotmail.com');

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
            /*->setCellValue('E10', 'Método de pago: ')
            ->setCellValue('F10', $pago)*/
            ->setCellValue('F10', 'Fecha: ')
            ->setCellValue('G10', $fecha)

            ->setCellValue('A12', 'Cantidad')
            ->setCellValue('B12', 'Concepto')
            ->setCellValue('F12', 'Precio')
            ->setCellValue('G12', 'Importe');

            //$a = 1;
            $i=13;
            $conce = mysql_query("SELECT * FROM tener_f_c WHERE cod_fac=$numero ORDER BY orden");
            while ($row2 = mysql_fetch_assoc($conce)) {
                $concepto = $row2['concepto'];
                $cantidad = $row2['cantidad'];
                $precio = $row2['precio_u'];
                //for ($i=13; $i<=41; $i++){

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
                        
                    for ($t=1; $t<=30; $t++){
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

            for ($u=13; $u<=41; $u++){
                $vaca = $worksheet->getCell('A'.$u)->getValue();
                $vacf = $worksheet->getCell('F'.$u)->getValue();
                if (($vaca!=0||$vaca!="")||($vacf!=0||$vacf!="")){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$u, '=A'.$u.'*F'.$u);
                }
            }

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A43', 'Subtotal')
            ->setCellValue('A44', '=SUM(G13:G41)')
            ->setCellValue('C43', 'IVA '.$iva.'%')
            ->setCellValue('C44', '=A44*'.$iva.'%')
            ->setCellValue('E44', 'TOTAL:')
            ->setCellValue('F44', '=A44+C44')

            ->setCellValue('A46', 'De conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');

//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&6&ArialDe conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');
// Rename worksheet
$worksheet->setTitle('Factura');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);

// Save PDF file
if (!PHPExcel_Settings::setPdfRendererName(
        $rendererName,
        $rendererLibraryPath
    )) {
    die(
        'NOTICE: Please set the '.$rendererName.' and '.$rendererLibraryPath .'values' .
        '<br />' .
        'at the top of this script as appropriate for your directory structure'
    );
}


header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="'.$numero.'.pdf"');
header('Cache-Control: max-age=0');

//$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "PDF");

$objWriter->save('C:\facturas/'.$numero.'.pdf');
//$objWriter->save('php://output');

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;

//}

mysql_close($dp);
header("Location: manage_facturas.php");
?>