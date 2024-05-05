<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8" />
        <title>Scan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <meta content="" name="description" /> -->

        <!-- App favicon -->
        <link rel="shortcut icon" href="http://localhost:8080/theme/assets/images/favicon.ico">

        <!-- Daterangepicker css -->
        <link rel="stylesheet" href="http://localhost:8080/theme/assets/vendor/daterangepicker/daterangepicker.css">

        <!-- Vector Map css -->
        <link rel="stylesheet" href="http://localhost:8080/theme/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

        <!-- Theme Config Js -->
        <script src="http://localhost:8080/theme/assets/js/config.js"></script>

        <!-- App css -->
        <link href="http://localhost:8080/theme/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="http://localhost:8080/theme/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <!-- fontawesome -->
        <link href="http://localhost:8080/theme/assets/css/all.min.css" rel="stylesheet">

        <link href="http://localhost:8080/theme/assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">


        <style>
            .logo-lg img {
                max-height: 65px !important;
                height: auto;
                max-width: 100%;
            }

            html[data-sidenav-size=condensed]:not([data-layout=topnav]) .wrapper .leftside-menu .logo,
            .leftside-menu {
                background-color: #FFF;
            }

            .container {
                width: 50%;
                height: 100vh;
                margin: auto;
                display: flex;
                justify-content: center;
                align-items: center;
               
            }

            .card{
                width: 100%;
            }
        </style>
    </head>
</head>

<body>
    <div class="container mt-3 justify-content-center">
        <div class="card">
            <div class="card-body" style="width: 100%;">
                <div class="alert alert-success" style="display: none;"></div>
                <div class="alert alert-danger" style="display: none;"></div>
                <?php if ($success_msg) : ?>
                <?php endif ?>
                <?php if ($error_msg) : ?>
                <?php endif ?>

                <h2 class=" text-center">Scan

                    <button class="btn btn-sm btn-scan btn-outline-success" data-toggle="modal" data-target="#scanModal" type="button">
                        <i class="mdi mdi-crop-free"></i>
                    </button>
                </h2>

                <form action="" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="qrcode_value" id="qrcode_value" class="form-control" placeholder="Scan Barcode">
                </form>
            </div>
        </div>

    </div>
    <!-- content -->
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

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>2024 © Vendor Name
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

    </div>


    <script src="http://localhost:8080/theme/assets/js/vendor.min.js"></script>

    <!-- Dashboard App js -->
    <!-- <script src="http://localhost:8080/theme/assets/js/pages/dashboard.js"></script> -->

    <!-- App js -->
    <script src="http://localhost:8080/theme/assets/js/app.min.js"></script>

    <!-- Datatables -->
    <script src="http://localhost:8080/theme/assets/js/datatables/datatables.min.js"></script>
    <script src="http://localhost:8080/theme/assets/js/datatables/datatables.bootstrap5.min.js"></script>
    <script src="http://localhost:8080/theme/assets/js/datatables-pagingtype/full_numbers_no_ellipses.js"></script>

    <script src='http://localhost:8080/assets/crud/js/crud.js'></script>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


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

            // $('#result').val('test');
            function onScanSuccess(decodedText, decodedResult) {
                $('#qrcode_value').val(decodedText);
                let id = decodedText;
                htmlscanner.clear().then(_ => {
                    $.ajax({
                        url: "<?php echo routeTo('guestbook/cekTamu') ?>",
                        method: 'POST',
                        data: {
                            _token: document.querySelector('[name=_token]').value,
                            qrcode_value: id
                        },
                        success: function(response) {
                            try {
                                if (typeof response === 'string') {
                                    response = JSON.parse(response);
                                }

                                const successMsgContainer = document.querySelector('.alert-success');
                                const errorMsgContainer = document.querySelector('.alert-danger');

                                // Reset pesan keberhasilan dan kesalahan
                                successMsgContainer.style.display = 'none';
                                errorMsgContainer.style.display = 'none';

                                if (response.success) {
                                    // successMsgContainer.innerHTML = response.message;
                                    // successMsgContainer.style.display = 'block';
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
                                    // errorMsgContainer.innerHTML = response.message;
                                    // errorMsgContainer.style.display = 'block';

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