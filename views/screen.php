<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Screen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?= asset('assets/guestbook/screen/css/bootstrap.min.css') ?>">
    <link type="text/css" rel="stylesheet" href="<?= asset('assets/guestbook/screen/fonts/font-awesome/css/font-awesome.min.css') ?>">
    <link type="text/css" rel="stylesheet" href="<?= asset('assets/guestbook/screen/fonts/flaticon/font/flaticon.css') ?>">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="<?= asset('assets/guestbook/screen/img/favicon.ico"') ?>" type="image/x-icon">

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?= asset('assets/guestbook/screen/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="<?= asset('assets/guestbook/screen/css/skins/default.css') ?>">

</head>

<body id="top">
    <div class="page_loader"></div>

    <div class="login-5">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12 bg-img">
                    <div class="lines">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <?php if (isset($_GET['id'])) : ?>
                        <div class="info">
                            <div class="name_wrap" id="guestName">
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="container d-flex justify-content-center align-items-center vh-100">
                            <div>
                                <h1 class="mb-4 text-center" style="color: blue;">Pilih Acara</h1>
                                <div class="row">
                                    <?php foreach ($acara as $acara) : ?>
                                        <div class="col">
                                            <div class="card text-center" style="width: 18rem;">
                                                <div class="card-header text-primary">
                                                    <strong>
                                                        <?= $acara->name; ?>
                                                    </strong>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text mb-0">Mulai : <?= date('d-M-Y H:i', strtotime($acara->start_at)); ?></p>
                                                    <p class="card-text">Selesai : <?= date('d-M-Y H:i', strtotime($acara->end_at)); ?></p>
                                                    <a href="<?= routeTo('guestbook/screen?id=' . $acara->id); ?>" class="btn btn-outline-primary d-block">Pilih</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Login 5 section end -->

    <!-- External JS libraries -->
    <script src="<?= asset('assets/guestbook/screen/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/guestbook/screen/js/popper.min.js') ?>"></script>
    <script src="<?= asset('assets/guestbook/screen/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Custom JS Script -->
    <script>
        async function showScreen() {
            document.querySelector('#guestName').innerHTML = ``
            try {
                const request = await fetch('<?= routeTo('guestbook/get-screen', ['id' => $_GET['id']]) ?>')
                const response = await request.json()
                const name = response.data.name
                const guestNameElement = document.querySelector('#guestName');
                guestNameElement.innerHTML = `<h1><span>Selamat Datang</span> ${name}</h1>`;
                setTimeout(showScreen, 10000);
                return;
            } catch (error) {

            }

            setTimeout(showScreen, 5000);
        }

        showScreen()
    </script>

</body>

</html>