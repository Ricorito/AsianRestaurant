<?php
include('connect.php');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kijelentkezés kezelése
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
    // Vissza a főoldalra
    header('Location: ../index.php');
    exit();
}
// Adatmódosítás kezelése
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['surname']) && isset($_POST['firstname'])) {
    $email = $_SESSION['email'];
    $newSurname = $_POST['surname'];
    $newFirstname = $_POST['firstname'];


    $updateQuery = "UPDATE user SET surname = ?, firstname = ? WHERE email = ?";
    $updateStmt = mysqli_prepare($connection, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "sss", $newSurname, $newFirstname, $email);
        $result = mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        if ($result) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Hiba történt az adatok frissítése során.";
        }
    } else {
        echo "Hiba történt az adatbázis művelet során.";
    }
}

// Profilkép frissítése
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $uploadDir = '../img/profilePictures/';

    $fileExtension = strtolower(pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION));
    $hashedFileName = md5($email) . '.' . $fileExtension;
    $targetFilePath = $uploadDir . $hashedFileName;

    $check = getimagesize($_FILES['profilePicture']['tmp_name']);
    if($check !== false) {
        if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFilePath)) {

            $updatePictureQuery = "UPDATE user SET profile_picture = ? WHERE email = ?";
            $stmt = mysqli_prepare($connection, $updatePictureQuery);
            mysqli_stmt_bind_param($stmt, "ss", $targetFilePath, $email);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['profile_picture'] = $targetFilePath;
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Hiba a feltöltés során!";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Hiba a feltöltés során!";
        }
    } else {
        echo "A kiválasztott fájl nem megfelelő formátumú! A formátum csak: jpg, jpeg, png lehet.";
    }
}
// Jelszó módosítás kezelése
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $email = $_SESSION['email'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    //Jelszó ellenőrzés
    $query = "SELECT password FROM user WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (password_verify($currentPassword, $hashedPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE user SET password = ? WHERE email = ?";
        $updateStmt = mysqli_prepare($connection, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "ss", $newHashedPassword, $email);
        if (mysqli_stmt_execute($updateStmt)) {
            echo "Jelszó sikeresen módosítva!";
        } else {
            echo "Hiba a jelszó frissítése közben.";
        }
        mysqli_stmt_close($updateStmt);
    } else {
        echo "A jelenlegi jelszó helytelen.";
    }
}

$LOGGED_IN = isset($_SESSION['email']);

$userData = [];
if ($LOGGED_IN) {
    $email = $_SESSION['email'];

    // Felhasználói adatok kiECHO-zása az oldalra.
    $query = "SELECT surname, firstname, email, address, phone, role, LOGGED_IN FROM user WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
        }

        mysqli_stmt_close($stmt);
    }
}

// Profil törlése/Profilkép törlése
if (isset($_POST['deleteProfile'])) {
    $email = $_SESSION['email'];

    $profilePicQuery = "SELECT profile_picture FROM user WHERE email = ?";
    $stmt = mysqli_prepare($connection, $profilePicQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $profilePicPath);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!empty($profilePicPath) && file_exists($profilePicPath)) {
        unlink($profilePicPath);
    }


    $deleteQuery = "DELETE FROM user WHERE email = ?";
    $stmt = mysqli_prepare($connection, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    if (mysqli_stmt_execute($stmt)) {
        session_unset();
        session_destroy();
        header('Location: ../index.php');
        exit();
    } else {
        echo "Hiba!";
    }
}
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

<!----------------------- PROFILE LAP nyit----------------------->
<section class="profile-section">
    <!-- Felhasználói adatok és profil kép -->
    <div id="userInfo">
        <!-- Profilkép megjelenítése; alapértelmezett kép, ha nincs beállítva -->
        <img src="<?php echo (isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../img/profilePictures/default.jpg') . '?v=' . time(); ?>" alt="Profilkép" class="profile-pic">
        <!-- Profilkép frissítés űrlap -->
        <form method="post" action="profil.php" enctype="multipart/form-data">
            <h2>Profilkép frissítése</h2>
            <input type="file" name="profilePicture" accept="image/*">
            <input type="submit" value="Kép frissítése">
        </form>
    </div>

    <!-- Személyes adatok frissítése -->
    <div class="update1">
        <form method="post" action="profil.php">
            <h2>Adatmódosítás</h2>
            <fieldset class="update1_field">
                <label>Vezetéknév:
                    <input type="text" name="surname" value="<?php echo htmlspecialchars($userData['surname']); ?>">
                </label>
                <label>Keresztnév:
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($userData['firstname']); ?>">
                </label>
                <label>E-mail cím:
                    <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>">
                </label>
                <label>
                    <input type="checkbox"> Hírlevél
                </label>
                <label>
                    <input type="checkbox"> Adatok publikálása
                </label>
                <label>
                    <input type="checkbox"> Kosár emlékeztető
                </label>
            </fieldset>
            <input type="submit" value="Adatok mentése">
            <input type="reset" value="Adatok törlése">
        </form>
    </div>

    <!-- Jelszó frissítése -->
    <div class="update2">
        <form method="post" action="profil.php">
            <h2>Jelszó módosítása</h2>
            <fieldset class="update2_field">
                <label>Régi jelszó:
                    <input type="password" ></label>
                <label>Új jelszó:
                    <input type="password"></label>
                <label>Új jelszó(ismét):
                    <input type="password"></label>
            </fieldset>
            <input type="submit" value="Mentés">
        </form>
    </div>

    <!-- Számlázási és szállítási adatok -->
    <fieldset class="update3_field">
        <legend class="legend_update">Számlázási adatok</legend>
        <br>
        <label for="name">Név:</label>
        <input type="text" id="name" placeholder="" value="Germán Martin">
        <label for="address">Cím:</label>
        <input type="text" id="address" name="address" value="Kossuth utca 57">
    </fieldset>
            <fieldset class="update3_field">
                <legend class="legend_update">Átvételi adatok</legend>
                <br>
                <label for="name">Név:</label>
                    <input type="text" id="name_for" placeholder="<?php echo htmlspecialchars($userData['surname'] . ' ' . $userData['firstname']); ?>">
                <label for="address">Város:</label>
                    <input type="text" id="address_for" placeholder="<?php echo htmlspecialchars($userData['address']); ?>">
            </fieldset>
            <input type="submit" value="Adatok módosítása">
            <hr>
            <!-- Profil törlése -->
            <form method="post" action="profil.php">
                <button type="submit" name="deleteProfile" id="deleteUserInfo" style="margin-top: 1rem; margin-bottom:0; color: white; margin-left: 300px;" onclick="return confirmDeletion()">💀 PROFIL TÖRLÉSE 💀</button>
            </form>
</section>

<!----------------------- PROFILE LAP zár----------------------->

<hr>

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
    function confirmDeletion() {
        return confirm("Biztosan törölni akarod a profilodat? Ez a kérés nem visszavonható!");
    }
</script>
</body>
</html>
