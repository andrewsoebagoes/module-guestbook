<?php

use Core\Page;
use Modules\Crud\Libraries\Repositories\CrudRepository;

// init table fields
$tableName  = 'gb_guests';
$table      = tableFields($tableName);
$fields     = $table->getFields();
$module     = $table->getModule();
$success_msg = get_flash_msg('success');
$error_msg   = get_flash_msg('error');

// get data
$crudRepository = new CrudRepository($tableName);
$crudRepository->setModule($module);

if(isset($_GET['draw']))
{
    return $crudRepository->dataTable($fields);
}

// page section
$title = _ucwords(__("$module.label.$tableName"));
Page::setActive("$module.$tableName");
Page::setTitle($title);
Page::setModuleName($title);
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
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>');
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>');

Page::pushHook('index');

return view('guestbook/views/index-guests', compact('fields', 'tableName', 'success_msg', 'error_msg', 'crudRepository'));