<?php
include_once 'sql_scripts.php';

$category = getCategories(); // Kategorileri getir
session_start(); // Session başlatma
if (isset($_GET['urun'])) { // Eğer urun parametresi varsa
    $data = getUrun($_GET['urun']); // Ürün bilgilerini getir

    $urun = [
        'id' => $data['id'],
        'ad' => $data['urun_adi'],
        'aciklama' => $data['aciklama'],
        'fiyat' => $data['fiyat'],
        'adet' => $data['adet'],
        'gorsel_yolu' => $data['gorsel_yolu']
    ]; // Ürün bilgilerini diziye ata
} else {
    header("Location: index.php"); // Eğer urun parametresi yoksa anasayfaya yönlendir
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
    <link rel="stylesheet" href="css/iletisim.css">

    <style>
        .custom-button {
            display: inline-block;
            padding: 7px 20px;
            background-color: #0E3150;
            color: white;
            text-align: center;
            font-size: 14px;
            border: 2px solid #0E3150;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            transition: color 0.3s ease;
        }

        .custom-button:hover {
            background-color: white;
            color: #051C30;
        }

        .custom-input {
            padding: 7px;
            margin-left: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .custom-input:focus {
            border-color: #4CAF50;
            outline: none;
            /* Odaklandığında mavi çerçeveyi kaldırır */
        }
    </style>

    <style>
        .slideshow-container {
            position: relative;
            max-width: 100%;
            margin: auto;
        }

        .mySlides {
            display: none;
        }

        .mySlides img {
            width: 100%;
        }

        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        .items {
            display: flex;
            flex-wrap: wrap;
        }

        .item-box {
            border: 1px solid #ccc;
            padding: 16px;
            margin: 8px;
            width: calc(33.333% - 32px);
            box-sizing: border-box;
            text-align: center;
        }

        .item-img img {
            max-width: 100%;
            height: auto;
        }

        .ad-container img {
            width: 100%;
            height: auto;
        }

        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .main-ul {
            list-style-type: none;
            padding: 0;
        }

        .top-category {
            margin-bottom: 10px;
        }

        .top-category span {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .top-category span span {
            margin-right: 10px;
        }

        .sub-category {
            list-style-type: none;
            padding-left: 20px;
            display: none;
        }

        .sub-category li {
            margin-bottom: 5px;
        }

        .sub-category a {
            text-decoration: none;
            color: #FCCF95;
            transition: color 0.3s;
        }

        .sub-category a:hover {
            color: #f8f9fa;
        }
    </style>

    <title><?= $urun['ad'] ?> Ürünü Detayları</title>
</head>

<body>

    <div id="main">

        <?php include 'navbar.php'; ?>

        <div class="container">
            <?php include 'sidebar.php'; ?>
            <div class="content">

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-gap: 20px;">
                    <div>
                        <img src="<?= $urun['gorsel_yolu'] ?>" width="300" alt="">
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center;">

                        <div class="contact">
                            <div class="info">
                                <h2><?= $urun['ad'] ?></h2>
                                <hr />
                                <br>
                                <p><?= $urun['aciklama'] ?></p>
                                <br>
                                <h4>Fiyat: <?= $urun['fiyat'] ?> TL</h4>
                                <h4>Ürün Adedi: <?= $urun['adet'] ?></h4>

                                <br><br><br>
                                <?php

                                if (isset($_SESSION['user_id'])) { // Eğer kullanıcı giriş yapmışsa
                                    echo '<div class="form">
                                    <form action="islemler.php" name="sepete_ekle" method="POST">';
                                    if ($urun['adet'] >= 1) {
                                        echo '<label for="adet">Adet:</label><input class="custom-input" style="text-align: center;" type="number" id="adet" name="adet" min="1" max="' . $urun['adet'] . '" value="1" required>
                                        <input type="hidden" name="urun_id" value="' . $urun['id'] . '">
                                        <br><br>
                                        <button class="custom-button" name="sepete_ekle" type="submit">Sepete Ekle</button>';
                                    } else {
                                        echo '<p>Üzgünüz, bu ürün stoklarımızda tükenmiştir.</p>';
                                    }
                                    echo '</form>
                                </div>';
                                } else {
                                    echo '<div class="form">
                                    <p>Ürün eklemek için giriş yapmalısınız.</p> </div>';
                                }

                                ?>

                            </div>


                        </div>
                    </div>




                </div>


            </div>
        </div>


        <?php include 'footer.php'; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const sepete = urlParams.get('sepete_ok');

            if (sepete === '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Ürün Sepete Eklendi!',
                    showConfirmButton: false,
                    timer: 1500,
                    didClose: () => {
                        window.history.back(); // Bir önceki sayfaya geri dön
                    }
                });
            } else if (sepete === '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'Ürün Sepete Eklenemedi!',
                    showConfirmButton: false,
                    timer: 1500,
                    didClose: () => {
                        window.history.back(); // Bir önceki sayfaya geri dön
                    }
                });
            }
        });
    </script>



</body>

</html>