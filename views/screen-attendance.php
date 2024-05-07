<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>

    </style>
</head>

<body>

    <?php if(!isset($_GET['id'])) : ?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div>
            <h2 class="mb-4 text-center">Pilih Acara</h2>
            <div class="row">
                <?php foreach ($acara as $acara) : ?>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-header">
                                <strong>

                                    <?= $acara->name; ?>
                                </strong>

                            </div>
                            <div class="card-body">
                                <p class="card-text mb-0">Mulai : <?= date('d-M-Y H:i', strtotime($acara->start_at)); ?></p>
                                <p class="card-text">Selesai : <?= date('d-M-Y H:i', strtotime($acara->end_at)); ?></p>
                                <a href="<?=routeTo('guestbook/screen-attendance?id='.$acara->id);?>" class="btn btn-outline-primary d-block">Pilih</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <?php endif ?>


    <h1 id="guestName"></h1>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script>
        async function showScreen() {
            document.querySelector('#guestName').innerHTML = ``
            try {
                const request = await fetch('<?= routeTo('guestbook/get-screen', ['id' => $_GET['id']]) ?>')
                const response = await request.json()
                const name = response.data.name
                document.querySelector('#guestName').innerHTML = `SELAMAT DATANG ${name}`
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