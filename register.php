<?php

include_once 'sql_scripts.php';
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fontawseome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/form.css">
    <title>myshop kayıt ol</title>
</head>

<body>

    <div id="main">

        <?php include 'navbar.php'; ?>

        <div class="space"></div>

        <div class="form-container">
            <h2>Kayıt Ol</h2>

            <form id="registerForm" method="POST" action="islemler.php">

                <label for="fullname">Ad Soyad</label>
                <input id="fullname" name="fullname" type="text" placeholder="Ad Soyad" required/>

                <label for="phone">Telefon</label>
                <input id="phone" name="phone" type="text" placeholder="Telefon" required/>

                <label for="email">E-Posta</label>
                <input id="email" name="email" type="email" placeholder="E-Posta" required/>
                
                <label for="adress">Adres</label>
                <input id="adress" name="address" type="text" placeholder="Adres" required/>

                <label for="password">Şifre</label>
                <input id="password" name="password" type="password" placeholder="Şifre" required/>

                <div class="buttons">
                    <button type="submit" name="register" >Kayıt Ol</button>
                    <a href="login.php">Giriş Yap</a>
                </div>

            </form>
        </div>

        <div class="space"></div>

        <?php include 'footer.php';?>

    </div>



</body>

</html>