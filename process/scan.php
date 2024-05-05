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

if(Request::isMethod('POST'))
{

    $db = new Database();
  
    // print_r($_POST);
    // die();
    
    $qrcode_value = $_POST['qrcode_value'];
    
    if (!empty($qrcode_value)) {
        
        $db->query = "SELECT * FROM gb_guests WHERE qrcode_value = '$qrcode_value'";
        $qrcode = $db->exec('single');
        // print_r($qrcode);
        // die();

        // Periksa hasil
        if ($qrcode) {
            
            $db->insert('gb_attendances', [
                'guest_id' => $qrcode->id,
                'created_by' => $qrcode->id
            ]);
            
            set_flash_msg(['success'=>"Data berhasil di scan"]);

        } else {
            set_flash_msg(['error'=>"Tamu tidak terdaftar"]);
        }
    } else {
        echo "QR Code kosong";
    }


    header('Location: /guestbook/scan');


    die();
}

// page section
$title = _ucwords(__("$module.label.$tableName"));
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

Page::pushFoot("<script src='".asset('assets/crud/js/crud.js')."'></script>");
Page::pushFoot("<script src='".asset('assets/guestbook/js/quagga.min.js')."'></script>");
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>');
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>');

Page::pushHook('index');

return view('guestbook/views/scan', compact('fields', 'tableName', 'success_msg', 'error_msg', 'crudRepository'));