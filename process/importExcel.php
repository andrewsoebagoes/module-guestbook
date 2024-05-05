<?php 

use Core\Database;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$db = new Database;

$event_id     = $_GET['event_id'];

// echo '<pre>';
// print_r($_POST);
// print_r($_FILES);
// die();

if (isset($_FILES['file_excel'])) {
    $file = $_FILES['file_excel'];
    
    // Jenis file yang diizinkan
    $allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'];
    
    if (!in_array($file['type'], $allowedTypes)) {
        die('File harus berupa file Excel (.xls, .xlsx) atau file CSV (.csv)');
    }


    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    if (in_array($fileExtension, ['xls', 'xlsx'])) {
        $spreadsheet = IOFactory::load($file['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator(2) as $row) {
            $name = $sheet->getCell('A' . $row->getRowIndex())->getValue();
            $graduation_year = $sheet->getCell('B' . $row->getRowIndex())->getValue();
            $registration_date = $sheet->getCell('C' . $row->getRowIndex())->getValue();
            $seat_number = $sheet->getCell('D' . $row->getRowIndex())->getValue();
            $qrcode_value = $sheet->getCell('E' . $row->getRowIndex())->getValue();

            if (is_numeric($registration_date)) {
                $baseDate = new DateTime('1900-01-01');
                $baseDate->add(new DateInterval('P' . ($registration_date - 2) . 'D'));
                $registration_date = $baseDate->format('Y-m-d');
            } else {
                $registration_date = date('Y-m-d', strtotime($registration_date));
            }

            $db->insert('gb_guests', [
                'event_id'          => $event_id,
                'name'              => $name,
                'graduation_year'   => $graduation_year,
                'registration_date' => date('Y-m-d', strtotime($registration_date)),
                'seat_number'       => $seat_number,
                'qrcode_value'      => $qrcode_value
            ]);

            $db->exec();
        }
    }
       
    set_flash_msg(['success'=> 'Data berhasil di Import']);
    header('Location: /guestbook/index-guests?filter[event_id]=' . urlencode($event_id));

} else {
    echo 'Silakan unggah file Excel atau CSV.';
}







?>