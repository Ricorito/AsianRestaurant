<?php
include('php/connect.php');
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
    header('Location: index.php');
    exit();
}

$LOGGED_IN = isset($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Ázsia Ízei Étterem</title>
</head>
<body>
<!----------------------- HEADER nyit----------------------->
<header>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.php"><img src="img/logo.png" alt=""></a>
            </div>
            <nav>
                <div class="btn">
                    <i class="fas fa-times close-btn"></i>
                </div>
                <ul>
                    <li><a href="index.php">Főoldal</a></li>
                    <li><a href="php/etlep.php">Étlap</a></li>
                    <li><a href="<?php echo ($LOGGED_IN == 1) ? 'php/rendeles.php' : 'php/reg.php'; ?>">Rendelés</a></li>
                    <li><a href="php/rolunk.php">Rólunk</a></li>
                    <?php if ($LOGGED_IN == 1): ?>
                        <li id="profil-link"><a href="php/profil.php">Profil</a></li>
                        <li><a href="?logout=1" class="login">Kijelentkezés</a></li>
                    <?php else: ?>
                        <li id="profil-link" style="display: none;"><a href="php/profil.php">Profil</a></li>
                        <li><a href="php/reg.php" class="login">Bejelentkezés</a></li>
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

<!----------------------- Üdvözlő LAP nyit----------------------->
<main id="showcase">
    <div class="container">
        <div class="content">
            <img src="img/logo.png" class="showcase-img" alt="">
            <h2>Üdvözöllek az Ázsia Ízei étterem oldalán</h2>
            <h3><q>Ízek, melyek átölelik Ázsiát</q></h3>
        </div>
    </div>
</main>

<!----------------------- Üdvözlő LAP zár----------------------->
<hr>
<!----------------------- Kedvenc ételek nyit----------------------->

<aside id="favorite_food">
    <div class="container">
        <div class="favorite_content">
            <div class="left_side_content">
                <div class="headings">
                    <h3><a href="/php/etlep.php">Az étlapról </a></h3>
                    <h2>Kedvenc ételeitek</h2>
                </div>
                <div class="img_content">
                    <div class="imgs">
                        <img src="img/thai_etelek/pad%20thai.jpeg" alt="">
                        <div class="content_for_img">
                            <h4>Pad thai</h4>
                            <p> A Pad Thai-unk egy kézzel készített ínyencség, ahol a tökéletesen pirított rizstészta találkozik a friss zöldségekkel,
                                a lágyan sült tojással és a választás szerinti tenger gyümölcseivel vagy csirkével, mindet összekötve saját, gazdag ízvilágú pad thai szószunkkal.
                                Ez az étel a hagyományos thai konyha esszenciáját hozza el az Ön tányérjára, minden egyes falatban a frissesség és az autentikus ízek harmóniáját kínálva.
                            </p>
                        </div>
                    </div>
                    <div class="price">
                        <p> 2980
                        </p>
                    </div>
                </div>
                <div class="img_content">
                    <div class="imgs">
                        <img src="img/japan_etelek/miso%20ramen.jpeg" alt="">
                        <div class="content_for_img">
                            <h4>Ramen</h4>
                            <p> A Ramenünk egy gazdag és kiegyensúlyozott tál, amelyben a lassan főzött, ízgazdag húsleves öleli körbe a frissen készült,
                                rugalmas tésztát, kiegészülve szeletelt hússal, tökéletesen főtt tojással, friss zöldségekkel és egy kevés zöldhagymával.
                                Ez az étel egy utazás a japán konyha szívébe, ahol minden egyes kanál tele van rétegzett ízekkel és textúrákkal,
                                így teremtve egy maradandó étkezési élményt.
                            </p>
                        </div>
                    </div>
                    <div class="price">
                        <p> 2980</p>
                    </div>
                </div>
                <div class="img_content">
                    <div class="imgs">
                        <img src="img/kinai_etelek/dim%20sum.jpg" alt="">
                        <div class="content_for_img">
                            <h4>Dim Sum</h4>
                            <p> A Dim Sum-unk egy igazi ínyenc válogatás, amely aprólékosan készített, gőzölt és sült falatkákat tartalmaz, többek között hússal,
                                tenger gyümölcseivel és zöldségekkel töltött tésztákat, ízesített rizsgombócokat és friss zöldségroládokat.
                                Minden darab a kézműves készítés művészetét tükrözi, így ízletes betekintést nyújtva a hagyományos kínai teaházi kultúrába.
                            </p>
                        </div>
                    </div>
                    <div class="price">
                        <p> 2980</p>
                    </div>
                </div>
            </div>
            <div class="right_side_content">
                <div class="img_right_side">
                    <a href="/php/etlep.php">
                        <img src="img/etlap.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
        </div>
</aside>

<!----------------------- Kedvenc ételek zár----------------------->
<hr>
<!----------------------- RÓLUNK ételek nyit----------------------->
<aside id="about_us">
    <div class="container">
        <div class="about_content">
            <div class="about_right_side_content">
                <div class="about_headings">
                    <h3><a href="/php/rolunk.php">Rólunk</a></h3>
                </div>
                <div class="about_content_for_img">
                    <table style="width:100%; border-collapse: collapse;">
                        <tr>
                            <th style="text-align: right; padding: 1rem; font-size: 3rem;">Történetünk</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #7A4A12; padding: 1rem; background-color: #F9F6F1;">
                                <p>Az Ázsia Ízei Étterem története Budapest szívében veszi kezdetét az 1970-as években, ahol Levente, egy fiatal és kalandvágyó magyar séf, életre hívja ezt a különleges éttermet.
                                    Levente inspirációját nagyapjától, Gábortól örökölte, aki a korai 20. században gyakran utazott Ázsiába, és ott megismerkedett egy különleges személlyel, Lijian(Lee) bácsival, akitől az ázsiai konyha titkait tanulhatta meg. Gábor és Lijian barátsága különleges volt; a két férfi kultúráját és tudását ötvözve különleges recepteket alkottak. Gábor, hazatérve Magyarországra, ezeket a recepteket és történeteket megosztotta Leventével, aki már gyermekkorában elvarázsolódott az ázsiai kultúra és ízek világától.</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="about_imgs">
                    <img src="img/story/gabor_lee.jpg" alt="Gábor és Lee bácsi">
                    <p class="image_caption">Szőlősi Gábor és Lee bácsi (Chun-Se Lijian) 1932.október 16.</p>
                </div>
                <div class="about_content_for_img">
                    <table style="width:100%; border-collapse: collapse;">
                        <tr>
                            <th style="text-align: right; padding: 1rem; font-size: 3rem;">Éttermünkröl</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #7A4A12; padding: 1rem; background-color: #F9F6F1;">
                                <p>Gábor hosszú ázsiai utazásai során mélyrehatóan megismerte a helyi konyhákat, és e tudás birtokában tért vissza Budapestre, hogy megnyissa az "Ázsia Ízei Éttermet". Az étterem hamar hírnevet szerzett autentikus ízeivel, amelyeket Levente maga varázsolt a tányérokra, miközben a berendezés is tükrözte az ázsiai utazások inspirálta eleganciát és stílust.
                                    A bambusz asztalok, a színes papírlámpások, és a falakon díszelgő keleti relikviák egy kis darabot hoztak Ázsiából Magyarország szívébe.</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="about_imgs">
                    <img src="img/story/restaurant_outside.jpg" alt="Restaurant">
                    <p class="image_caption">Ázsia Ízei Étterem</p>
                </div>
                <div class="about_content_for_img">
                    <table style="width:100%; border-collapse: collapse;">
                        <tr>
                            <th style="text-align: right; padding: 1rem; font-size: 3rem;">Jelenkor</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #7A4A12; padding: 1rem; background-color: #F9F6F1;">
                        <p>Az "Ázsia Ízei Étterem" ma Szőlősi Levente vezetése alatt áll, aki nagyapja, az alapító Szőlősi Gábor örökségét viszi tovább.
                            Levente újító szellemmel és tisztelettel ötvözi a hagyományos ázsiai konyhát modern elemekkel, így az étterem menüje egy igazi gasztronómiai utazásra invitálja a vendégeket. Az étlapon szerepelnek a klasszikus ázsiai ételek, mint a miso leves, a pad thai, és a kacsa pekingi módra, valamint új, izgalmas kreációk is, amelyek Levente saját kulináris felfedezéseiből születtek.
                            A csapat, amely az "Ázsia Ízei Étterem" sikerét nap mint nap alapozza meg, magában foglalja a tehetséges és szenvedélyes séfeket, akik Levente mellett dolgoznak, hogy a lehető legfinomabb ételeket készítsék el. Az étterem személyzete, a konyhától a felszolgálásig, elkötelezett amellett, hogy minden vendég számára felejthetetlen élményt nyújtsanak.
                            Az "Ázsia Ízei Étterem" így nem csak a kiváló ételeiről, hanem a barátságos, családias légköréről is ismert, ahol mindenki otthon érezheti magát.</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="about_imgs">
                    <img src="img/story/staff.jpg" alt="staff">
                    <p class="image_caption">Középen Szőlősi Levente(tulajdonos-chef), balra Li Mengyi(chef), jobbra Lee Min-hyeong(sous-chef)</p>
                </div>


            </div>
        </div>
    </div>
</aside>

<!----------------------- RÓLUNK ételek zár----------------------->
<hr>
<!----------------------- NYITVATARTÁS/NAPI ajánlat nyit----------------------->

<div id="deal_open">
    <div class="container">
        <h3 class="normal_heading-1">Kiszállítás</h3>
        <h2 class="main_heading">már 990 HUF-tól</h2>
        <div class="card_content">
            <div class="cards">
                <img src="img/japan_etelek/Grilezett%20pácolt%20makréla.png" alt="">
                <h3 class="normal_heading-1">Napi ajánlat</h3>

                <h4>Grilezett Pácolt Makréla</h4>
                <p> A grillezett pácolt makréla egy omlós, ízletes fogás, amelyet a különleges pácolási eljárás tesz ellenállhatatlanná, így garantáltan minden ínyenc szívét megdobogtatja.
                    Ez a fogás tökéletes választás azok számára, akik szeretik az omlós halat és a kifinomult ízek harmóniáját.</p>
                <p class="price">Csak 4000 HUF + választható köret.</p>
            </div>

        </div>
    </div>
</div>


<!----------------------- NYITVATARTÁS/NAPI ajánlat zár----------------------->

<!----------------------- FOOTER NYIT----------------------->
<section id ="footer">
    <div class ="container">
        <div class ="footer_container">
            <div class ="rolunk">
                <h2><img src="img/logo.png" alt=""></h2>
                <p>
                    Az "Ázsia Ízei Étterem" ott kezdődik, ahol a hagyomány találkozik a kreativitással.
                    Merüljön el velünk az ázsiai konyha mélységeiben, ahol minden tál egy új történetet mesél.
                </p>
                <a href="php/rolunk.php">Tovább...</a>
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
<script src="js/script.js" type="module"></script>
</body>
</html>
