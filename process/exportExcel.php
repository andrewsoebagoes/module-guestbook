<?php 

use Core\Database;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database;
$event_id     = $_GET['filter']['event_id'];

// Membuat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan judul kolom
$sheet->setCellValue('A1', 'Acara');
$sheet->setCellValue('B1', 'Nama Tamu');
$sheet->setCellValue('C1', 'Tahun Lulus');
$sheet->setCellValue('D1', 'Tanggal Registrasi');
$sheet->setCellValue('E1', 'Nomor Kursi');
$sheet->setCellValue('F1', 'Waktu Hadir');

$db->query = "SELECT gb_events.name event_name, gb_guests.name guest_name, gb_guests.graduation_year, gb_guests.registration_date, gb_guests.seat_number, gb_attendances.created_at waktu_hadir
                FROM gb_attendances
                LEFT JOIN gb_guests ON gb_attendances.guest_id = gb_guests.id
                LEFT JOIN gb_events ON gb_guests.event_id = gb_events.id
                WHERE gb_events.id = '$event_id'
";

$dataAttendances = $db->exec('all');
// echo '<pre>';
// print_r($dataAttendances);
// die();

$row = 2;
foreach ($dataAttendances as $rowData) {
    $sheet->setCellValue('A' . $row, $rowData->event_name);
    $sheet->setCellValue('B' . $row, $rowData->guest_name);
    $sheet->setCellValue('C' . $row, $rowData->graduation_year);
    $sheet->setCellValue('D' . $row, $rowData->registration_date);
    $sheet->setCellValue('E' . $row, $rowData->seat_number);
    $sheet->setCellValue('F' . $row, $rowData->waktu_hadir);
    $row++;
}

// Membuat objek writer untuk menulis ke file Excel
$writer = new Xlsx($spreadsheet);
// Menyimpan file Excel
$filename = 'Data_Attendance.xlsx';
$writer->save($filename);

// Atur header untuk download file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

// Baca file Excel dan output ke browser
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

?>