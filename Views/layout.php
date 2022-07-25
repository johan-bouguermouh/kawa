<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/gij8hzs.css">
    <link rel="stylesheet" href="/kawa/public/style/main.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/kawa/public/assets/pictures/kawa_logo_color.svg">
    <script type="text/javaScript" src="/kawa/public/js/menuAdmin.js"></script>
    <script type="text/javaScript" src="/kawa/public/js/panier.js"></script>
    <script type="text/javaScript" src="/kawa/public/js/search.js"></script>
    <script type="text/javaScript" src="/kawa/public/js/carousel.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <title><?= $title ?></title>
</head>

<body>
    <header id="header">
        <?php require_once 'panier.php'; ?>
        <?php require_once 'header.php'; ?>
    </header>
    <main>
        
        <?= $pageContent ?>
    </main>
    <footer>
        <?php require_once 'footer.php'; ?>
    </footer>

    <script>
        AOS.init({
            duration: 2000,
        })
    </script>
</body>

</html>