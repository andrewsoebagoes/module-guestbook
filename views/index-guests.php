<?php get_header() ?>
<style>
    table td img {
        max-width: 150px;
    }
</style>
<div class="card">
    <div class="card-header d-flex flex-grow-1 align-items-center">
        <p class="h4 m-0"><?php get_title() ?></p>
        <div class="right-button ms-auto">
            <?= $crudRepository->additionalButtonBeforeCreate() ?>
            <?php if (is_allowed(parsePath(routeTo('guestbook/create-guests')), auth()->id)) : ?>
                <!-- <a href="#" class="btn btn-info btn-sm">
                    <i class="fa-solid fa-download"></i> Import Excel
                </a> -->

                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa-solid fa-download"></i> Import Excel

                </button>


                <a href="<?= routeTo('guestbook/create-guests', $_GET['filter']) ?>" class="btn btn-success btn-sm">
                    <i class="fa-solid fa-plus"></i> <?= __('crud.label.create') ?>
                </a>
            <?php endif ?>
            <?= $crudRepository->additionalButtonAfterCreate() ?>
        </div>
    </div>
    <div class="card-body">
        <?php if ($success_msg) : ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php endif ?>
        <?php if ($error_msg) : ?>
            <div class="alert alert-danger"><?= $error_msg ?></div>
        <?php endif ?>
        <div class="table-responsive table-hover table-sales">
            <table class="table table-bordered datatable-crud" style="width:100%">
                <thead>
                    <tr>
                        <th width="20px">#</th>
                        <?php
                        foreach ($fields as $field) :
                            $label = $field;
                            if (is_array($field)) {
                                $label = $field['label'];
                            }
                            $label = _ucwords($label);
                        ?>
                            <th><?= $label ?></th>
                        <?php endforeach ?>
                        <th class="text-right">
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File Excel</h5>
                <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=routeTo('guestbook/importExcel',$_GET['filter']);?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                    <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".xls, .csv, .xlsx">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php get_footer() ?>

<script>

function startScan() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#area-scan')
            },
            decoder: {
                readers: ["ean_reader"],
                multiple: false
            },
            locate: false
        }, function(err) {
            if (err) {
                console.log(err);
                return
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
        });

        Quagga.onDetected(function(data) {

            // Panggil stopScan() jika ingin menghentikan pemindaian setelah satu deteksi
            $('#area-scan').prop('hidden', true);
            $('#btn-scan-action').prop('hidden', false);
            $('.barcode-result').prop('hidden', false);
            $('.barcode-result-text').html(data.codeResult.code);
            $('.kode_barang_error').prop('hidden', true);

            next();
            // close();

        });
        stopScan();
    };



    function next() {
        const qrcode_value = $('.barcode-result-text').text();

        $.ajax({
            url: "<?php echo routeTo('guestbook/cekTamu') ?>",
            method: "POST",
            data: {
                _token: document.querySelector('[name=_token]').value,
                qrcode_value: qrcode_value,
            },
            success: function(response) {
                console.log(response);
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                const successMsgContainer = document.querySelector('.alert-success');
                const errorMsgContainer = document.querySelector('.alert-danger');

                // Reset pesan keberhasilan dan kesalahan
                successMsgContainer.style.display = 'none';
                errorMsgContainer.style.display = 'none';


                if (response.success) {
                    successMsgContainer.innerHTML = response.message;
                    successMsgContainer.style.display = 'block';
                    // Tindakan lain, misalnya menyegarkan halaman atau elemen tertentu
                    //window.location.reload(); // untuk menyegarkan halaman

                    $('.barcode-result-text').text('');
                    const closeButton = document.querySelector('.close-btn');
                    // Tekan tombol close secara otomatis untuk menutup modal
                    if (closeButton) {
                        closeButton.click();
                    }

                } else {
                    // Jika tidak berhasil, Anda bisa menampilkan pesan error
                    //window.location.reload(); // untuk menyegarkan halaman
                    errorMsgContainer.innerHTML = response.message;
                    errorMsgContainer.style.display = 'block';
                    close();
                    stopScan();
                    const closeButton = document.querySelector('.close-btn');
                    // Tekan tombol close secara otomatis untuk menutup modal
                    if (closeButton) {
                        closeButton.click();
                    }
                }

            },
            error: function(xhr, status, error) {
                console.error(`Error: ${error}`);
            }

        });
    }

    $(document).on('click', '.btn-continue', function(e) {
        e.stopPropagation();
        // next(); 
    });

    $(document).on('click', '.btn-scan', function() {
        scan();
    });


    function scan() {
        $('#area-scan').prop('hidden', false);
        $('#btn-scan-action').prop('hidden', true);
        $('.barcode-result').prop('hidden', true);
        $('.barcode-result-text').html('');
        $('.kode_barang_error').prop('hidden', true);
        startScan();
    };

    $(document).on('click', '.btn-repeat', function() {
        $('#area-scan').prop('hidden', false);
        $('#btn-scan-action').prop('hidden', true);
        $('.barcode-result').prop('hidden', true);
        $('.barcode-result-text').html('');
        $('.kode_barang_error').prop('hidden', true);
        startScan();
    });

    function stopScan() {
        Quagga.stop();
        // $(".btn-scan").trigger("click");
    }

    function close() {

        $('#area-scan').prop('hidden', true);
        $('#btn-scan-action').prop('hidden', true);
        $('.barcode-result').prop('hidden', true);
        $('.barcode-result-text').html('');
        $('.kode_barang_error').prop('hidden', true);
        stopScan();

    }
</script>