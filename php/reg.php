<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';

    // Regisztráció
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $role = 'user';

        $check_query = "SELECT * FROM `user` WHERE email=?";
        $check_stmt = mysqli_prepare($connection, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (empty($email) || empty($password) || empty($confirmPassword)) {
            echo "<script>alert('Kérem töltsön ki minden mezőt!');</script>";
        } elseif ($password != $confirmPassword) {
            echo "<script>alert('A jelszavak nem egyeznek!');</script>";
        } elseif (mysqli_stmt_num_rows($check_stmt) > 0) {
            echo "<script>alert('Ezzel az e-mail címmel már regisztráltak! Kérem, válasszon másikat.');</script>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO user (surname, firstname, email, address, phone, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($connection, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "sssssss", $surname, $firstname, $email, $address, $phone, $hashedPassword, $role);

            if (mysqli_stmt_execute($insert_stmt)) {
                echo "<script>alert('Sikeres regisztráció! Most már beléphet az oldalra!');</script>";
                echo '<meta http-equiv="refresh" content="0;url=../index.php">';
            } else {
                die(mysqli_error($connection));
            }

            mysqli_stmt_close($insert_stmt);
        }
    }
    // Bejelentkezés
    elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
        $email = ($_POST['email']);
        $password = ($_POST['password']);

        if (empty($email) || empty($password)) {
            echo "<script>alert('Nem adtál meg adatot!');</script>";
        } else {
            $sql = "SELECT * FROM user WHERE email=?";
            $stmt = mysqli_prepare($connection, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {

                    if (password_verify($password, $row['password'])) {
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['profile_picture'] = (empty($row['profile_picture'])) ? '../img/profilePictures/default.jpg' : $row['profile_picture'];
                        echo "<script>alert('Sikeres bejelentkezés! Az oldal rövid időn belül átirányít...'); window.location.href = '../index.php';</script>";
                        exit();
                    } else {
                        echo "<script>alert('Hibás jelszó!');</script>";
                    }
                } else {
                    echo "<script>alert('A felhasználó nem létezik!');</script>";
                }

                mysqli_stmt_close($stmt);
            }
        }
    }

    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo.png">
    <title>Ázsia Ízei Étterem | Bejelentkezés/Regisztráció</title>
    <style>
        @font-face {
            font-family: myFont;
            src: url("../fonts/asian.ttf");
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font-family: myFont, serif;
            background: url('../img/restaurant.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .auth-container {
            width: 50%;
            background: rgba(255, 255, 255, 0.7);
            padding: 0.5rem 2rem 1rem 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: .5rem;
        }

        input[type="email"], input[type="password"], input[type="text"], input[type="tel"]{
            width: 100%;
            padding: .5rem;
            margin-bottom: .5rem;
        }

        button {
            font-family: myFont, serif;
            background-color: rgba(116,28,34,1);
            color: white;
            padding: .5rem 1rem;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        button:hover {
            background-color: rgba(116,28,34,0.8);
        }


        .fade-in {
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(-50%);
            }
        }
        .fade-out {
            animation: fadeOut 1s forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(50%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hidden {
            display: none;
        }
        .h2class{
            color: rgba(116,28,34,1);
            font-size: 2rem;
            text-align: center;
        }
        #showRegister {
            color: rgba(116,28,34,1);
            text-decoration: underline;
            font-weight: bold;
        }
        #showLogin {
            color: rgba(116,28,34,1);
            text-decoration: underline;
            font-weight: bold;
        }
        .regisztracio{
            color: rgba(116,28,34,1);
            font-size: 2rem;
            text-align: center;
            text-transform: uppercase;
        }
        #foldal{
            color: rgba(116,28,34,1);
            text-decoration: underline;
            font-weight: bold;
            text-transform: uppercase;
        }
        footer {
            background: rgba(23,23,23,0.7);
            text-align: center;
            margin-top: 5rem;
            font-size: 1rem;
            color: white;
            margin-top: auto;
            width: 100%;
        }
        .auth-container {
            margin-top: auto;
            margin-bottom: auto;
        }
        .login-form img{
            display: block;
            object-fit: cover;
            border-radius:100px 5px 100px;
            border: 2px solid #000;
            width: 20%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="login-form fade-in" id="loginForm">
        <img src="../img/logo.png" alt="">
        <h2 class ="h2class">BEJELENTKEZÉS</h2>
        <form action="reg.php" method="POST">
            <input type="hidden" name="action" value="login">
            <div class="form-group">
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Jelszó:</label>
                <input type="password" id="loginPassword" name="password" required>
            </div>
            <button type="submit">Bejelentkezés</button>
            <p>Nincs még fiókod? <a href="#" id="showRegister">Regisztrálj</a></p>
            <a href="../index.php" id="foldal">Vissza a főoldalra.</a>
        </form>
    </div>

    <div class="registration-form hidden" id="registrationForm">
        <h2 class="regisztracio">Regisztráció</h2>
        <form action="reg.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="action" value="register">
                <label for="registerSurrName">Vezetéknév:</label>
                <input type="text" id="registerSurrName" name="surname" required>
            </div>

            <div class="form-group">
                <label for="registerFirstName">Keresztnév:</label>
                <input type="text" id="registerFirstName" name="firstname" required>
            </div>

            <div class="form-group">
                <label for="registerEmail">Email cím:</label>
                <input type="email" id="registerEmail" name="email" required>
            </div>

            <div class="form-group">
                <label for="registerAddress">Cím:</label>
                <input type="text" id="registerAddress" name="address" placeholder="Pl: 1056 Budapest, Táncsics utca 12." required>
            </div>

            <div class="form-group">
                <label for="registerPhone">Telefonszám:</label>
                <input type="text" id="registerPhone" name="phone" placeholder="Pl: +3670hívjálFelKedden." required>
            </div>

            <div class="form-group">
                <label for="registerPassword">Jelszó:</label>
                <input type="password" id="registerPassword" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Jelszó megerősítése:</label>
                <input type="password" id="confirmPassword" name="confirm_password" required>
            </div>

            <button type="submit">Regisztráció</button>
            <p>Van már fiókod? <a href="#" id="showLogin">Vissza</a></p>
        </form>
    </div>
</div>
<footer>
    <p>
        Minden jog fenntartva 2024 &copy; Designed by Martin Germán & Gergely Pogáts
    </p>
</footer>
<script>

    document.getElementById('showRegister').addEventListener('click', function(event) {
        event.preventDefault();
        transitionForms('loginForm', 'registrationForm');
    });

    document.getElementById('showLogin').addEventListener('click', function(event) {
        event.preventDefault();
        transitionForms('registrationForm', 'loginForm');
    });
    function transitionForms(hideFormId, showFormId) {
        var hideForm = document.getElementById(hideFormId);
        var showForm = document.getElementById(showFormId);

        hideForm.classList.add('fade-out');
        setTimeout(function() {
            hideForm.classList.add('hidden');
            hideForm.classList.remove('fade-out');

            showForm.classList.remove('hidden');
            showForm.classList.add('fade-in');
            setTimeout(() => showForm.classList.remove('fade-in'), 1000);
        }, 1000);
    }
</script>

</body>
</html>