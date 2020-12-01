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
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)" />
    <link rel="icon" type="image/png" href="img/burger-icon.png" />
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <header>
        <ul class="aiutiNascosti">
            <li><a href="#menu">Vai al menù</a></li>
            <li><a href="#contenutoGenerale">Vai al contenuto</a></li>
        </ul>
        <a href="index.html"><img id="logo" src="img/burger-icon.png"/></a>
        <h1>Burgheria Padovana</h1>
        <span class="apri-nav">
            <img onclick="apri_nav()" src="img/menu/hamburger.png" alt="apri menu"/>
        </span>
    </header>

    <nav class="nav">
        <span class="chiudi-nav">
            <img onclick="chiudi_nav()" src="img/menu/exit.png" alt="esci dal menu"/>
        </span>
        <ul id="menu">
            <li><a href="index.html" lang="en">HOME</a></li>
            <li id="currentLink">I NOSTRI BURGER</li>
            <li><a href="eventi.html">EVENTI</a></li>
            <li><a href="storia.html">STORIA</a></li>
            <li><a href="contatti.html">CONTATTI</a></li>
            <li><a href="login.php" lang="en">LOGIN</a></li>
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