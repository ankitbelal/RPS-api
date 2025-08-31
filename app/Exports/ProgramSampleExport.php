<?php

namespace App\Exports;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ProgramSampleExport
{
       protected $programs;

    public function __construct()
    {
    }
public function download($fileName = 'program_sample.xlsx')
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 1. Title: Result Processing System (merged B1:G5)
    $sheet->setCellValue('B1', 'Result Processing System');
    $sheet->mergeCells('B1:G5');
    $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(24)->getColor()->setARGB(Color::COLOR_WHITE);
    $sheet->getStyle('B1')->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF1976D2'); // blue background
    $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER);

    // 2. Warning notice (B6:G7)
    $sheet->setCellValue('B6', "⚠️ Please do NOT upload this sample file as it is. Fill in your own data. Program Code must be unique and description can be left empty.");
    $sheet->mergeCells('B6:G7');
    $sheet->getStyle('B6')->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_RED);
    $sheet->getStyle('B6')->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFEB3B'); // yellow
    $sheet->getStyle('B6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER)
        ->setWrapText(true);

    // 3. Headers (B8:G8)
    $headerRow = 8;
    $headers = ['code','name','duration_years','total_semesters','total_subjects','description'];
    $sheet->fromArray($headers, null, 'B'.$headerRow);

    // 4. Sample data starting from B9
    $sampleData = [
        ['BCA','Bacherlor of Computer Application',4,8,45,'IT program'],
        ['BBS','Bacherlor of Business Studies',4,8,40,'Business program'],
        ['BSc','Bacherlor of Science',4,8,50,'Science program'],
        ['BA','Bacherlor of Arts',4,8,42,'Arts program'],
        ['BEd','Bacherlor of Education',4,8,38,'Education program']
    ];
    $sheet->fromArray($sampleData, null, 'B'.($headerRow+1));

    // 5. Style headers: green background, white bold text, centered
    $sheet->getStyle('B'.$headerRow.':G'.$headerRow)->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_WHITE);
    $sheet->getStyle('B'.$headerRow.':G'.$headerRow)->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF4CAF50'); // green
    $sheet->getStyle('B'.$headerRow.':G'.$headerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER);

    // 6. Style data rows: light gray background, borders
    $dataStartRow = $headerRow + 1;
    $dataEndRow = 20;
    $sheet->getStyle('B'.$dataStartRow.':G'.$dataEndRow)->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFE0E0E0'); // light gray
    $sheet->getStyle('B'.$dataStartRow.':G'.$dataEndRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // 7. Auto-size columns
    foreach(range('B','G') as $col){
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 8. Write to browser
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$fileName.'"');
    $writer->save('php://output');
    exit;
}
}