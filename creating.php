<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$worksheet = $objPHPExcel->getActiveSheet();

$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A46:G46')
            ->mergeCells('A1:C2')
            ->mergeCells('A3:C3')
            ->mergeCells('A4:C4')
            ->mergeCells('A5:C5')
            ->mergeCells('A6:C6')
            ->mergeCells('A7:C7')
            ->mergeCells('E2:G2')
            ->mergeCells('E3:G3')
            ->mergeCells('E4:G4')
            ->mergeCells('E5:G5')
            ->mergeCells('E6:G6')
            ->mergeCells('F10:G10')
            ->mergeCells('B12:E12')
            ->mergeCells('F44:G44');


$borderArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$worksheet->getStyle('E2:G6')->applyFromArray($borderArray);
$worksheet->getStyle('A10:B10')->applyFromArray($borderArray);
$worksheet->getStyle('C10:D10')->applyFromArray($borderArray);
$worksheet->getStyle('E10:G10')->applyFromArray($borderArray);
$worksheet->getStyle('A12')->applyFromArray($borderArray);
$worksheet->getStyle('B12:E12')->applyFromArray($borderArray);
$worksheet->getStyle('F12')->applyFromArray($borderArray);
$worksheet->getStyle('G12')->applyFromArray($borderArray);
$worksheet->getStyle('A13:A41')->applyFromArray($borderArray);
$worksheet->getStyle('B13:E41')->applyFromArray($borderArray);
$worksheet->getStyle('F13:F41')->applyFromArray($borderArray);
$worksheet->getStyle('G13:G41')->applyFromArray($borderArray);

unset($borderArray);

$worksheet->getColumnDimension('A')->setWidth(11);
$worksheet->getColumnDimension('B')->setWidth(13);
$worksheet->getColumnDimension('C')->setWidth(11);
$worksheet->getColumnDimension('D')->setWidth(13);
$worksheet->getColumnDimension('E')->setWidth(13);

$worksheet->getRowDimension(46)->setRowHeight(45);

$worksheet->getStyle('A1:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$worksheet->getStyle('A12:G12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$worksheet->getStyle('A1')->getFont()->setName('Britannic Bold')->setSize(13)->setBold(true);
$worksheet->getStyle('A3')->getFont()->setName('Lucida Calligraphy')->setSize(10);
$worksheet->getStyle('A4:A7')->getFont()->setName('Palatino Linotype')->setSize(10);
$worksheet->getStyle('A12:G12')->getFont()->setName('Century')->setSize(10);

$worksheet->getStyle('A10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('C10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$worksheet->getStyle('E10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);

$worksheet->getStyle('A46')->getFont()->setName('Arial')->setSize(6); 
$worksheet->getStyle('A46')->getAlignment()->setWrapText(true);

$worksheet->getStyle('F13:G41')->getNumberFormat()->setFormatCode('0.00€');

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'MANTENIMIENTO DEL HOGAR')
            ->setCellValue('A3', '******* **** *******')
            ->setCellValue('A4', 'Telf: *** *** ***  - *** *** ***')
            ->setCellValue('A5', '******* *****, ** ***** *******')
            ->setCellValue('A6', 'D.N.I **.***.***-*')
            ->setCellValue('A7', 'E-mail: *****.****@hotmail.com')

            ->setCellValue('A10', 'Fecha: ')
            ->setCellValue('C10', 'Factura Nº: ')
            ->setCellValue('E10', 'Método de pago: ')

            ->setCellValue('A12', 'Cantidad')
            ->setCellValue('B12', 'Concepto')
            ->setCellValue('F12', 'Precio')
            ->setCellValue('G12', 'Importe')
            ->setCellValue('A13', '3')
            ->setCellValue('F13', '2.52');

            for ($i=13; $i<=41; $i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, '=A'.$i.'*F'.$i);
            }

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A43', 'Subtotal')
            ->setCellValue('C43', 'IVA 21%')
            ->setCellValue('E44', 'Total:')

            ->setCellValue('A46', 'De conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');


// Rename worksheet
$worksheet->setTitle('Factura');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('Factura.xlsx');
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


?>