<?php
include_once 'sql_scripts.php'; // SQL işlemleri için gerekli dosya
session_start(); // Session başlatma

if (isset($_SESSION["user_id"])) { // Eğer kullanıcı giriş yapmışsa
    $userid = $_SESSION["user_id"]; // Kullanıcı id'sini al
    $sepet = getGecmisSiparisler($userid); // Kullanıcının geçmiş siparişlerini getir
    $toplam = 0; // Toplam fiyatı sıfırla

    $u_data = getUser($userid); // Kullanıcı bilgilerini getir

    $userdata = [
        "fullname" => $u_data['tam_ad'],
        "phone" => $u_data['tel_no'],
        "email" => $u_data['eposta'],
        "adress" => $u_data['adres'],
        "password" => $u_data['sifre']
    ]; // Kullanıcı bilgilerini diziye ata
} else {
    header("Location: login.php"); // Kullanıcı giriş yapmamışsa login sayfasına yönlendir
    exit(); // İşlemi sonlandır
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fontawseome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/sepetim.css">
    <title>Profilim</title>
</head>

<body>

    <div id="main">

        <?php include 'navbar.php'; ?>

        <div class="space"></div>

        <div class="form-container">
            <h2>Bilgilerim</h2>

            <form id="update_info" name="update_info" action="islemler.php" method="post">


                <div style="display: flex;  grid-template-columns: repeat(2, 1fr); grid-gap: 30px;">
                    <div>
                        <input type="hidden" name="user_id" value="<?= $userid ?>">
                        <label style="display: block;" for="fullname">Ad Soyad</label>
                        <input style="display: block;" id="fullname" name="fullname" type="text" placeholder="Ad Soyad" value="<?= $userdata['fullname'] ?>" required />

                        <label style="display: block;" for="phone">Telefon</label>
                        <input style="display: block;" id="phone" name="phone" type="text" placeholder="Telefon" value="<?= $userdata['phone'] ?>" required />

                        <label style="display: block;" for="email">E-Posta</label>
                        <input style="display: block;" id="email" name="email" type="email" placeholder="E-Posta" value="<?= $userdata['email'] ?>" required />
                    </div>

                    <div>
                        <label style="display: block;" for="adress">Adres</label>
                        <input style="display: block;" id="adress" name="adress" type="text" placeholder="Adres" value="<?= $userdata['adress'] ?>" required />

                        <label style="display: block;" for="password">Şifre</label>
                        <input style="display: block;" id="password" name="password" type="password" placeholder="Şifre" value="<?= $userdata['password'] ?>" required />

                    </div>
                </div>



                <div class="buttons">
                    <button type="submit" name="update_info">Güncelle</button>
                </div>

            </form>
        </div>

        <div class="space"></div>

        <div class="content" style="margin: 50px;">
            <div class="sepetim-header">
                <h3 class="text-center"><i class="fas fa-shopping-cart"></i> Sipariş Geçmişi</h3>
            </div>

            <div class="sepetim">

                <?php

                if (empty($sepet)) { // Eğer sepet boşsa
                    echo '<div class="sepet-bos">
                        <i class="far fa-times-circle"></i>
                        <p> Sipariş Geçmişiniz Yok </p>
                    </div>';
                } else { // Eğer sepet doluysa
                    echo '<div class="sepet-table"><table><tbody>';
                    $toplam = 0;
                    foreach ($sepet as $key => $value) {
                        $toplam += getUrun($userid)['fiyat'] * $value['adet'];
                        echo '<tr><td>' . (array_search($value, $sepet) + 1) . '</td>
                            <td>' . getUrun($userid)['urun_adi'] . '</td>
                            <td>' . $value['adet'] . ' Adet</td>
                            <td>' . (getUrun($userid)['fiyat'] * $value['adet']) . ' &#8378;</td>
                            </tr>';
                    }

                    echo '</tbody></table></div>
                    </div>';
                }


                ?>


            </div>

            <div class="space"></div>

            <?php include 'footer.php'; ?>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> // Profil güncelleme işlemi sonucu mesajı gösterme
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const updateOk = urlParams.get('update_ok');

        if (updateOk === '1') {
            Swal.fire({
                icon: 'success',
                title: 'Profil Güncelleme Başarılı!',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    window.location.href = 'profile.php'; // Profil sayfasına yönlendir
                }
            });
        } else if (updateOk === '0') {
            Swal.fire({
                icon: 'error',
                title: 'Profil Güncelleme Başarısız!',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    window.location.href = 'profile.php'; // Profil sayfasına yönlendir
                }
            });
        }
    });
</script>



</body>

</html>