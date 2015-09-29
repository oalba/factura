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
            ->mergeCells('B12:E12');


$borderArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('E2:G6')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('A10:B10')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('C10:D10')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('E10:G10')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('A12')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B12:E12')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('F12')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('G12')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('A13:A41')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B13:E41')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('F13:F41')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('G13:G41')->applyFromArray($borderArray);

unset($borderArray);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);

$objPHPExcel->getActiveSheet()->getRowDimension(46)->setRowHeight(45);

$objPHPExcel->getActiveSheet()->getStyle('A1:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A12:G12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Britannic Bold')->setSize(13)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('Lucida Calligraphy')->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A4:A7')->getFont()->setName('Palatino Linotype')->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A12:G12')->getFont()->setName('Century')->setSize(10);

$objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$objPHPExcel->getActiveSheet()->getStyle('C10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);
$objPHPExcel->getActiveSheet()->getStyle('E10')->getFont()->setName('Centaur')->setSize(10)->setBold(true)->setItalic(true);

$objPHPExcel->getActiveSheet()->getStyle('A46')->getFont()->setName('Arial')->setSize(6); 
$objPHPExcel->getActiveSheet()->getStyle('A46')->getAlignment()->setWrapText(true);

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

            ->setCellValue('A43', 'Subtotal')
            ->setCellValue('C43', 'IVA 21%')
            ->setCellValue('E44', 'Total:')

            ->setCellValue('A46', 'De conformidad con la Ley Orgánica de Protección de Datos de Carácter Personal 15/1999, le recordamos que sus datos han sido incorporados en un fichero de datos de carácter personal del que es titular ******* **** *******, debidamente registrado ante la AEPD y cuya finalidad es de gestión de datos de clientes para tareas contable, fiscal y administrativas, Así mismo, le informamos que sus datos podrán ser cedidos, siempre protegiendo los datos adecuadamente, a: administración tributaria y bancos, cajas de ahorros y cajas rurales. Puede ejercitar sus derechos de Acceso, Rectificación, Cancelación y Oposición en ******* ** - *****, ******* (*********) o enviando un correo electrónico a *****.****@hotmail.com.');


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Factura');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


?>