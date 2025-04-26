<?php
include('connect.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Értékelés
if (isset($_POST['save'])) {
    $uID = mysqli_real_escape_string($connection, $_POST['uID']);
    $ratedIndex = mysqli_real_escape_string($connection, $_POST['ratedIndex']);
    $ratedIndex++;

    if (empty($uID)) {
        if (mysqli_query($connection, "INSERT INTO stars (rateIndex) VALUES ('$ratedIndex')")) {
            $sql = mysqli_query($connection, "SELECT id FROM stars ORDER BY id DESC LIMIT 1");
            if ($sql) {
                $uData = mysqli_fetch_assoc($sql);
                $uID = $uData['id'];
            }
        }
    } else {
        mysqli_query($connection, "UPDATE stars SET rateIndex='$ratedIndex' WHERE id='$uID'");
    }

    exit(json_encode(array('id' => $uID)));
}

$sql = mysqli_query($connection, "SELECT id FROM stars");
$numR = mysqli_num_rows($sql);

$sql = mysqli_query($connection, "SELECT SUM(rateIndex) AS total FROM stars");
$rData = mysqli_fetch_assoc($sql);
$total = $rData['total'];
$avg = ($numR > 0) ? $total / $numR : 0;
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
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png">
    <title>Ázsia Ízei Étterem</title>
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

<!----------------------- RENDELÉS LAP nyit----------------------->
<div class="order-page-container">

    <h2>Kiszállítási cím</h2>
    <form id="orderForm" class="order-form">
        <div class="form-group-order">
            <input type="text" id="deliveryAddress" placeholder="Pl: 1056 Budapest Fő tér 12." required>
        </div>
        <div class="form-group-order">
            <input type="tel" id="phoneNumber" placeholder="Pl: +3670...">
        </div>

        <div class="special-instructions">
            <h3>Megjegyzés</h3>
            <textarea id="specialInstructions" placeholder="Pl.: Allergia információ, extra csípős, stb..."></textarea>
        </div>

        <div class="estimated-delivery">
            <h3>Várható Szállítási Idő</h3>
            <p>A rendeléstől számított 45-60 percen belül.</p>
        </div>

        <button type="submit" class="submit-btn-order">Rendelés leadása</button>
    </form>
    <div id="timer" class="timer"></div>

    <div id="ratingModal">
        <div class="rating">
            <h2>Kérjük, értékelje a szolgáltatásunkat!</h2>
            <div id="stars" class="stars">
                <i class="fa fa-star fa-4x" data-index="0"></i>
                <i class="fa fa-star fa-4x" data-index="1"></i>
                <i class="fa fa-star fa-4x" data-index="2"></i>
                <i class="fa fa-star fa-4x" data-index="3"></i>
                <i class="fa fa-star fa-4x" data-index="4"></i>
            </div>
            <button onclick="closeModal()">Bezárás</button>
        </div>
    </div>

</div>

<!----------------------- RENDELÉS LAP zár----------------------->
<hr>
<!----------------------- Kedvenc ételek nyit----------------------->

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
                <p>SZEGED - Király utca 420.</p>
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
<script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script>
    var ratedIndex = -1, uID = 0;

    $(document).ready(function () {
        resetStarColors();

        if (localStorage.getItem('ratedIndex') != null) {
            setStars(parseInt(localStorage.getItem('ratedIndex')));
            uID = localStorage.getItem('uID');
        }

        $('.fa-star').on('click', function () {
            ratedIndex = parseInt($(this).data('index'));
            localStorage.setItem('ratedIndex', ratedIndex);
            saveToTheDB();
        });

        $('.fa-star').mouseover(function () {
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            setStars(currentIndex);
        });

        $('.fa-star').mouseleave(function () {
            resetStarColors();
            if (ratedIndex != -1)
                setStars(ratedIndex);
        });
    });

    function saveToTheDB() {
        $.ajax({
            url: "rendeles.php",
            method: "POST",
            dataType: 'json',
            data: {
                save: 1,
                uID: uID,
                ratedIndex: ratedIndex
            }, success: function (r) {
                uID = r.id;
                localStorage.setItem('uID', uID);
            }
        });
    }

    function setStars(max) {
        for (var i=0; i <= max; i++)
            $('.fa-star:eq('+i+')').css('color', 'yellow');
    }

    function resetStarColors() {
        $('.fa-star').css('color', 'white');
    }
</script>
<script>
    //Számláló
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Rendelés leadva! Dőlj hátra és várj.');
        document.getElementById('timer').style.display = 'inline-block';

        const duration = 10;
        startTimer(duration);
    });
    function startTimer(duration) {
        var timer = duration, seconds;
        var intervalId = setInterval(function () {
            seconds = parseInt(timer % 60, 10);
            seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById('timer').textContent = "00:" + seconds;

            if (--timer < 0) {
                clearInterval(intervalId);
                document.getElementById('timer').textContent = 'A rendelés kiszállítva!';
                showModal();
            }
        }, 1000);
    }

    function showModal() {
        document.getElementById('ratingModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('ratingModal').style.display = 'none';

    }

</script>
</body>
</html>
