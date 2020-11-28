<!DOCTYPE html>
<html lang="it" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Burgheria Padovana</title>

    <!-- Non sono sicuro se sulla pagina di login bisgona mettere queste informazioni-->
    <meta name="title" content="Login | Burgheria Padovana" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Albiero Fincato Panighel Tossuto" />
    <meta name="language" content="italian it" />

    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/print.css" media="print">
    <link rel="icon" type="image/png" href="img/burger-icon.png" />
    <!--<link rel="stylesheet" type="text/css" href="css/style_small_lavoro.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>-->
</head>

<body>
    <header>
        <ul class="aiutiNascosti">
            <li><a href="#menu">Vai al menù</a></li>
            <li><a href="#contenutoGenerale">Vai al contenuto</a></li>
        </ul>
        <img id="logo" src="img/burger-icon.png"/>
        <h1>Burgheria Padovana</h1>
    </header>

    <nav id="menu">
        <ul>
            <li><a href="index.html" lang="en">HOME</a></li>
            <li><a href="menu.php">I NOSTRI BURGER</a></li>
            <li><a href="eventi.html">EVENTI</a></li>
            <li><a href="storia.html">STORIA</a></li>
            <li><a href="contatti.html">CONTATTI</a></li>
            <li id="currentLink" lang="en">LOGIN</li>
        </ul>
    </nav>

    <nav id="breadcrumb">
        <p>Ti trovi in: <span lang="en">Login</span></p>
    </nav>

    <div id="contenutoGenerale">
        <form action="" method="post">
            <label for="user" lang="en">Username:</label>
            <input type="text" name="usr" id="user" autocomplete="username"/>
            <label for="pwd" lang="en">Password:</label>
            <input type="password" name="pwd" id="pwd" autocomplete="current-password"/>
            <input type="submit" value="Login"/>
        </form>
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