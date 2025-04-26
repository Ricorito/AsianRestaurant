<?php
include('connect.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Kijelentkezés
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
    <title>Rólunk</title>

</head>
<body>
<!--header nyít-->
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
<!--header zár-->
<section class="rolunk2">
    <div class="rolunk2__hatter">
        <h2>Ázsia ízei: Ahol a keleti ízek találkoznak a magyar vendégszeretettel</h2>
    </div>
    <div class="rolunk2__tartalom">
        <p>
            Történetünk:<br>
            Az Ázsia ízei étterem 2015-ben nyitotta meg kapuit Szegeden, azzal a céllal, hogy a város lakóit és az idelátogatókat autentikus ázsiai ételekkel kápráztassa el. Az étterem alapítója, Minta János, maga is szenvedélyes Ázsia-rajongó, aki bejárta a kontinenst, hogy felfedezze a legfinomabb helyi specialitásokat. Ezeket a recepteket hozta el Szegedre, és az étterem konyháján a mai napig az eredeti ízvilágot tükrözik.
        </p>

        <p>
            Csapatunk:<br>
            Az Ázsia ízei csapata profi szakácsokból és felszolgálókból áll, akik mindannyian elkötelezettek amellett, hogy a vendégeknek a legjobb élményt nyújtsák. A konyhán a legfrissebb alapanyagokból készítik el az ételeket, a felszolgálók pedig kedvesek, figyelmesek és mindig készek segíteni a választásban.
        </p>

        <p>
            Célunk:<br>
            Célunk, hogy vendégeinknek egy ínycsiklandó utazásban legyen részük Ázsia ízei varázslatos világában. Szeretnénk, ha mindenki megtalálná nálunk a kedvenc ételét, legyen szó akár a thai currykről, a vietnami tésztalevesekről, a kínai dim sumról, vagy a japán sushitról.
        </p>
    </div>

    <section class="csapatunk">
        <h2>A csapatunk</h2>

        <div class="csapat__vezetok">
            <div class="csapat__tag">
                <img src="../img/munkas4.jpeg" alt="Alapító">
                <h3>Pogáts Gergely</h3>
                <p>Alapító és tulajdonos</p>
            </div>

            <div class="csapat__tag">
                <img src="../img/munkas3.jpg" alt="Főnök séf">
                <h3>Germán Martin</h3>
                <p>Étteremvezető</p>
            </div>
        </div>

    </section>
    <section class="rolunk2-mondtak">
        <h2>Rólunk mondták</h2>

        <div class="velemenyek">
            <div class="velemeny">
                <p>"Fantasztikus ételek, kedves kiszolgálás és hangulatos atmoszféra. Mindenkinek ajánlom, aki szereti az ázsiai konyhát!"</p>
                <p class="szerzo">- Nagy Anna</p>
            </div>

            <div class="velemeny">
                <p>"A thai curry isteni volt, a pad thai pedig tökéletesen fűszerezett. Biztosan visszatérünk!"</p>
                <p class="szerzo">- Szabó Péter</p>
            </div>

            <div class="velemeny">
                <p>"Nagyon kellemes meglepetés volt! A sushi friss és ízletes volt, a kiszolgálás pedig gyors és figyelmes."</p>
                <p class="szerzo">- Tóth Klára</p>
            </div>

            <div class="velemeny">
                <p>;"Már többször is voltunk itt, és mindig nagyon elégedettek voltunk. A választás bőséges, az árak pedig korrektek.";</p>
                <p class="szerzo">- Kovács család</p>
            </div>
        </div>
    </section>
</section>

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
</body>
</html>
