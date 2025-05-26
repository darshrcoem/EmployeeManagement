<?php
$cakeDescription = 'Workwise360';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $cakeDescription ?>: <?= $this->fetch('title') ?></title>
    <link rel="icon" href="<?= $this->Url->image('favicon1.png') ?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
     body {
    margin: 0;
    padding: 0;
    background: url('/img/back123.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }


        .container {
            padding: 2rem;
            max-width: 960px;
            margin: auto;
        }

        .flash-message {
            background-color: #ffecb3;
            border-left: 5px solid #ffa000;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #222;
            color: #eee;
            margin-top: 2rem;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
     <link rel="stylesheet" href="/css/home.css">
</head>
<body>
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>
