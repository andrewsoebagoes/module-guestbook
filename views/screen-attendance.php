<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Attendance</title>
</head>

<body>
    <h1 id="guestName">Screen Attendance</h1>


    <script>
    async function showScreen() 
    {
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