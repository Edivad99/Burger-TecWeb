<!DOCTYPE html>
<html lang="it" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menù | Burgheria Padovana</title>

    <meta name="title" content="Menù | Burgheria Padovana" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Albiero Fincato Panighel Tossuto" />
    <meta name="language" content="italian it" />

    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/print.css" media="print">
    <link rel="icon" type="image/png" href="img/burger-icon.png" />
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>
    <script type="text/javascript" src="./js/script.js"></script>
</head>

<body>
    <header>
        <ul class="aiutiNascosti">
            <li><a href="#menu">Vai al menù</a></li>
            <li><a href="#contenutoGenerale">Vai al contenuto</a></li>
        </ul>
        <span>
            <img id="logo" src="img/burger-icon.png"/>
        </span>
        <h1>Burgheria Padovana</h1>
        <span class="apri-nav">
            <img onclick="apri_nav()" class="open-button" src="img/menu/hamburger.png" alt="apri menu"/>
        </span>
    </header>

    <nav class="nav">
        <span class="chiudi-nav">
            <img onclick="chiudi_nav()" class="close-button" src="img/menu/exit.png" alt="esci dal menu"/>
        </span>
        <ul id="menu">
            <li class="elemento-menu"><a href="index.html" lang="en">HOME</a></li>
            <li id="currentLink" class="elemento-menu">I NOSTRI BURGER</li>
            <li class="elemento-menu"><a href="eventi.html">EVENTI</a></li>
            <li class="elemento-menu"><a href="storia.html">STORIA</a></li>
            <li class="elemento-menu"><a href="contatti.html">CONTATTI</a></li>
            <li class="elemento-menu"><a href="login.php" lang="en">LOGIN</a></li>
        </ul>
    </nav>

    <nav id="breadcrumb">
        <p>Ti trovi in: <a id="linkBreadcrumb" href="index.html" lang="en">Home</a> > I nostri burger</p>
    </nav>

    <div id="contenutoGenerale">
    </div>
    <footer>
        <ul>
            <li>Via Luigi Luzzati, 10 Padova</li>
            <li><abbr title="Telefono">Tel</abbr>: <a id="tel" href="tel:+393453434225">+39 3453434225</a></li>
            <li><abbr title="Partita IVA">P.IVA</abbr> 17935620231</li>
        </ul>
        <!-- TODO: Validazioni immagini verso la fine-->
    </footer>
</body>

</html>