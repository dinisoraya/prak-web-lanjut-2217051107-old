<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://kit.fontawesome.com/66aa7c98b3.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="card">
        <div class="img-bx">
            <img src="{{ asset('assets/img/diginigi.jpg') }}" alt="img" />
        </div>
        <div class="content">
            <div class="detail">
                <h2>
                    <div class="row">
                        <span>Nama</span><span>: <?= $nama ?></span>
                    </div>
                    <div class="row">
                        <span>NPM</span><span>: <?= $npm ?></span>
                    </div>
                    <div class="row">
                        <span>Kelas</span><span>: <?= $kelas ?></span>
                    </div>
                </h2>
            </div>
        </div>
    </div>

</body>

</html>