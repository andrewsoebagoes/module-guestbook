<?php get_header() ?>
<style>
    table td img {
        max-width: 150px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="alert alert-success" style="display: none;"></div>
        <div class="alert alert-danger" style="display: none;"></div>
        <?php if ($success_msg) : ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php endif ?>
        <?php if ($error_msg) : ?>
            <div class="alert alert-danger"><?= $error_msg ?></div>
        <?php endif ?>
        <div class="table-responsive table-hover table-sales">

            
            <button class="btn btn-lg btn-scan btn-outline-success d-block mb-3 text-center" data-toggle="modal" data-target="#scanModal" type="button">
                <i class="mdi mdi-crop-free"></i> Scan Barcode
            </button>
          

            <form action="" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="qrcode_value" id="qrcode_value" class="form-control" placeholder="Scan Barcode">
                <input type="text" name="seat_number" id="seat_number" class="form-control" placeholder="Nomor Kursi">
                <button type="submit" class="btn btn-success mt-3">Kirim</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Scan Barcode</h5>
                <button type="button" class="close close-btn btn btn-sm btn-outline-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger kode_barang_error" role="alert" hidden="">
                            <i class="mdi mdi-information-outline"></i> Tamu tidak terdaftar
                        </div>
                    </div>

                    <!-- <div class="col-md-12 text-center" id="area-scan" willReadFrequently="true">
                    </div> -->
                    <div id="my-qr-reader">
                    </div>

                    <div class="col-12 barcode-result" hidden="">
                        <h5 class="font-weight-bold">Hasil</h5>
                        <div class="form-border">
                            <p class="barcode-result-text"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="btn-scan-action" hidden="">
                <button type="button" class="btn btn-primary btn-sm font-weight-bold rounded-0 btn-continue">Lanjutkan</button>
                <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold rounded-0 btn-repeat">Ulangi</button>
            </div>
        </div>
    </div>
</div>



<?php get_footer() ?>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Skrip untuk menginisialisasi Html5Qrcode
    $(document).on('click', '.btn-scan', function() {
        scan();
    });

    function scan() {
        const htmlscanner = new Html5QrcodeScanner("my-qr-reader", {
            fps: 10,
            qrbox: 250
        });

        // Fungsi yang akan dipanggil saat QR code berhasil di-scan
        function onScanSuccess(decodedText, decodedResult) {
            $('#qrcode_value').val(decodedText);
            let id = decodedText;
            htmlscanner.clear().then(_ => {
                $.ajax({
                    url: "<?php echo routeTo('guestbook/cekTamu') ?>",
                    method: 'POST',
                    data: {
                        _token: document.querySelector('[name=_token]').value,
                        qrcode_value: id,
                        event_id: <?= $_GET['filter']['event_id'] ?>
                    },
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response.success) {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: response.message,
                                    icon: "success"
                                });
                                $('.barcode-result-text').text('');
                                const closeButton = document.querySelector('.close-btn');
                                if (closeButton) {
                                    closeButton.click();
                                }
                            } else {
                                Swal.fire({
                                    title: "Gagal!",
                                    text: response.message,
                                    icon: "error"
                                });
                                const closeButton = document.querySelector('.close-btn');
                                if (closeButton) {
                                    closeButton.click();
                                }
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(`Error: ${xhr.responseText}`);
                    }
                });
            }).catch(error => {
                alert('something wrong');
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }


        htmlscanner.render(onScanSuccess);
    }

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