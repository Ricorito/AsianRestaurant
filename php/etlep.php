<?php
include('connect.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == '1' && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $updateLoggedOutStatusQuery = "UPDATE user SET LOGGED_IN = 0 WHERE email = ?";
    $updateStmt = mysqli_prepare($connection, $updateLoggedOutStatusQuery);
    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "s", $email);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    }
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

$LOGGED_IN = isset($_SESSION['email']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png">
    <title>Étlap</title>
</head>
<body>
<!----------------------- HEADER nyit----------------------->
<header>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../img/logo.png" alt=""></a>
            </div>
            <nav>
                <div class="btn">
                    <i class="fas fa-times close-btn"></i>
                </div>
                <ul>
                    <li><a href="../index.php">Főoldal</a></li>
                    <li><a href="../php/etlep.php">Étlap</a></li>
                    <li><a href="<?php echo ($LOGGED_IN == 1) ? '../php/rendeles.php' : '../php/reg.php'; ?>">Rendelés</a></li>
                    <li><a href="../php/rolunk.php">Rólunk</a></li>
                    <?php if ($LOGGED_IN == 1): ?>
                        <li id="profil-link"><a href="../php/profil.php">Profil</a></li>
                        <li><a href="?logout=1" class="login">Kijelentkezés</a></li>
                    <?php else: ?>
                        <li id="profil-link" style="display: none;"><a href="../php/profil.php">Profil</a></li>
                        <li><a href="../php/reg.php" class="login">Bejelentkezés</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="btn">
                <i class="fas fa-bars menu-btn"></i>
            </div>
        </div>
    </div>
</header>
<!----------------------- HEADER zár----------------------->

<!----------------------- ETLEP NYIT----------------------->
<section class="ételek">

    <div class ="képek">
        <img class ="shop-item-image" src="../img/kinai_etelek/szerencse%20sertéscsülök.jpeg" alt="">
        <h4 class="leiras">Szerencse sertéscsülök</h4> <blockquote> kívül ropogós, belül szaftos, ínycsiklandó ízekkel.<br><span class="shop-item-price"> 3200 Ft</span></blockquote>
        <?php if ($LOGGED_IN): ?>
            <button class="btn btn primary shop-item-button" type="button">Kosárba</button>
        <?php else: ?>
            <button class="btn btn primary" type="button" onclick="alert('Kérjük, jelentkezzen be!');">Kosárba</button>
        <?php endif; ?>
    </div>
    <div class ="képek">
        <img class ="shop-item-image" src="../img/japan_etelek/avokádó%20temaki.jpeg" alt="">
        <h4 class="leiras">Avokádós temaki</h4><blockquote> Friss avokádó és ízletes töltelék tökéletesen göngyölve.<br><span class="shop-item-price"> 4200 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class ="képek">
        <img class ="shop-item-image" src="../img/japan_etelek/csirkés%20curyy%20rizzsel.jpeg" alt="">
        <h4 class="leiras">Csirkés curry rízzsel</h4><blockquote>Fűszeres csirkemell és krémes curry mártás a könnyed rizs mellett.<br> <span class="shop-item-price">3600 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class  ="képek">
        <img class ="shop-item-image" src="../img/japan_etelek/Garasu.jpeg" alt="">
        <h4 class="leiras">Garasu</h4><blockquote> Ízletes és ropogós snack, mely a japán konyhából ismert.<br><span class="shop-item-price"> 2990 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class ="képek">
        <img class ="shop-item-image" src="../img/kinai_etelek/Ge-shan%20csirke%20combból.jpeg" alt="">
        <h4 class="leiras">Ge-shan csirke combból</h4><blockquote> Csirkecomb, melyet jellegzetes fűszerekkel és szósszal ízesítenek.<br><span class="shop-item-price"> 5000 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class ="képek">
        <img class ="shop-item-image" src="../img/japan_etelek/érlelt%20szójabab.png" alt="">
        <h4 class="leiras">Érlelt szójabab</h4><blockquote> Gazdag ízű és textúrájú<br> <span class="shop-item-price">2500 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class  ="képek">
        <img class ="shop-item-image" src="../img/kinai_etelek/vaslapon%20sült%20marha.jpeg" alt="">
        <h4 class="leiras">Vaslapon sült marha</h4><blockquote>Ropogósra sütött marhahús, melyet egy forró vaslapon készítűnk.<br><span class="shop-item-price"> 4500 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
    <div class ="képek">
        <img class ="shop-item-image" src="../img/kinai_etelek/Miss%20mocha.jpeg" alt="">
        <h4 class="leiras">Miss Mocha</h4> <blockquote> Csokoládés-kávés desszert. <br> <span class="shop-item-price">1690 Ft</span></blockquote>
        <button class="btn btn primary shop-item-button" type="button" <?php echo $LOGGED_IN ? '' : 'data-logged-in="0"'; ?>>Kosárba</button>
    </div>
</section>

<!----------------------- ETLEP ZAR----------------------->

<!----------------------- KOSAR NYIT----------------------->
<section class="content-section" id="sticky-cart">
    <h2 class="section-header">Kosár</h2>
    <div class="cart-row">
        <span class="cart-item cart-header cart-column">TERMÉK</span>
        <span class="cart-price cart-header cart-column">ÁR</span>
        <span class="cart-quantity cart-header cart-column">MENNYISÉG</span>
    </div>
    <div class="cart-items">

    </div>
    <div class="cart-total">
        <strong class="cart-total-title">ÖSSZESEN</strong>
        <span class="cart-total-price">0 FT</span>
    </div>
    <button class="btn btn-primary btn-purchase" type="button">MEGRENDELEM</button>
</section>

<!----------------------- KOSAR ZAR----------------------->

<!----------------------- FOOTER NYIT----------------------->
<section id ="footer">
    <div class ="container">
        <div class ="footer_container">
            <div class ="rolunk">
                <h2><img src="../img/logo.png" alt=""></h2>
                <p>
                    Az "Ázsia Ízei Étterem" ott kezdődik, ahol a hagyomány találkozik a kreativitással.
                    Merüljön el velünk az ázsiai konyha mélységeiben, ahol minden tál egy új történetet mesél.
                </p>
                <a href="rolunk.php">Tovább...</a>
            </div>

            <div class ="nyitvatartas">
                <h2>Nyitvatartás</h2>
                <p class="napok">H: <span>----8:30 - 21:00----</span></p>
                <p class="napok">K: <span>----8:30 - 21:00----</span></p>
                <p class="napok">SZ: <span>----8:30 - 21:00----</span></p>
                <p class="napok">CS: <span>----8:30 - 21:00----</span></p>
                <p class="napok">P: <span>----9:30 - 23:00----</span></p>
                <p class="napok">SZ: <span>----9:30 - 23:00----</span></p>
                <p class="napok">V: <span>----ZÁRVA----</span></p>
            </div>
            <div class ="kapcsolat">
                <h2>Kapcsolat</h2>
                <p>06-70-hívjál-kedden</p>
                <p class="cim">Cím</p>
                <p>BUDAPEST - Király utca 420.</p>
                <p class="email">Email cím</p>
                <p>azsia.izeietterem@gmail.com</p>
                <i class="fab fa-instagram fa-2x"></i>
                <i class="fab fa-facebook-f fa-2x"></i>
                <i class="fab fa-tiktok fa-2x"></i>
            </div>
        </div>
    </div>
</section>
<!----------------------- FOOTER ZÁR----------------------->
<footer>
    <p>
        Minden jog fenntartva 2024 &copy; Designed by Martin Germán & Gergely Pogáts
    </p>
</footer>
<script src="../js/script.js" type="module"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.shop-item-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const loggedIn = e.target.dataset.loggedIn === 'false' ? false : true;
                if (!loggedIn) {
                    alert('"Ups! A kosárba helyezés előtt be kell jelentkezned.');
                    e.preventDefault();
                }
            });
        });
    });
</script>
</body>
</html>