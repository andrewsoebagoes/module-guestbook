<?php

use Core\Page;
use Core\Request;
use Core\Database;
use Modules\Crud\Libraries\Repositories\CrudRepository;

// init table fields
$tableName  = 'gb_attendances';
$table      = tableFields($tableName);
$fields     = $table->getFields();
$module     = $table->getModule();
$success_msg = get_flash_msg('success');
$error_msg   = get_flash_msg('error');

// get data
$crudRepository = new CrudRepository($tableName);
$crudRepository->setModule($module);

if (Request::isMethod('POST')) {

    $db = new Database();

    $event_id       = $_GET['filter']['event_id'];
    $seat_number    = $_POST['seat_number'];

    if (!empty($seat_number)) {
        // Query untuk mendapatkan tamu dan informasi acara berdasarkan seat_number dan event_id
        $db->query = "SELECT gb_guests.*, gb_events.start_at, gb_events.end_at 
                      FROM gb_guests 
                      JOIN gb_events ON gb_events.id = gb_guests.event_id
                      WHERE gb_guests.seat_number = '$seat_number'
                      AND gb_guests.event_id = '$event_id'";

        // Eksekusi query dan ambil data tamu
        $guestData = $db->exec('single');
        // echo '<pre>';
        // print_r($_POST);
        // print_r($guestData);
        // die();

        // Jika tamu ditemukan
        if ($guestData) {
            // Dapatkan waktu saat ini
            $currentTime = date('Y-m-d H:i:s');

            // Periksa apakah waktu saat ini berada dalam rentang start_at dan end_at
            if ($currentTime >= $guestData->start_at && $currentTime <= $guestData->end_at) {
                // Periksa apakah tamu sudah melakukan scan sebelumnya
                $db->query = "SELECT * FROM gb_attendances
                              WHERE guest_id = '$guestData->id'";

                $attendance = $db->exec('single');

                // Jika belum ada data di gb_attendances untuk tamu tersebut, lakukan insert
                if (!$attendance) {
                    // Insert data ke tabel gb_attendances
                    $db->insert('gb_attendances', [
                        'guest_id' => $guestData->id,
                        'created_by' => auth()->id,
                        'created_at' => $currentTime
                    ]);

                    // Tampilkan pesan sukses
                    set_flash_msg(['success' => "Halo selamat datang $guestData->name"]);
                } else {
                    // Tampilkan pesan bahwa tamu sudah melakukan scan
                    set_flash_msg(['error' => "Tamu $guestData->name sudah melakukan scan sebelumnya"]);
                }
            } else {
                // Tampilkan pesan bahwa scan tidak diizinkan di luar waktu acara
                set_flash_msg(['error' => "Tidak dapat melakukan scan di luar waktu acara"]);
            }
        } else {
            // Tampilkan pesan bahwa tamu tidak terdaftar
            set_flash_msg(['error' => "Tamu tidak terdaftar"]);
        }
    } else {
        echo "QR Code kosong";
    }

    // Redirect ke halaman scan
    header('Location:' . routeTo('guestbook/scan', ['filter'=>['event_id' => $event_id]]));
    die();
}

// page section
$title = 'Scan';
Page::setActive("$module.$tableName");
Page::setTitle('Scan');
Page::setModuleName('Scan');
Page::setBreadcrumbs([
    [
        'url' => routeTo('/'),
        'title' => __('crud.label.home')
    ],
    [
        'url' => routeTo('crud/index', ['table' => $tableName]),
        'title' => $title
    ],
    [
        'title' => 'Index'
    ]
]);

Page::pushFoot("<script src='" . asset('assets/crud/js/crud.js') . "'></script>");
Page::pushFoot("<script src='" . asset('assets/guestbook/js/quagga.min.js') . "'></script>");
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>');
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>');

Page::pushHook('index');

return view('guestbook/views/scan', compact('fields', 'tableName', 'success_msg', 'error_msg', 'crudRepository'));
