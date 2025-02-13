<?php

include_once 'sql_scripts.php'; // SQL sorguları dosyası import edildi
session_start(); // Session başlatıldı

if (!isset($_SESSION['user_id'])) { // Eğer kullanıcı giriş yapmamışsa
    header("Location: login.php"); // login.php sayfasına yönlendir
    exit(); // işlemi sonlandır
}
if (!isset($_SESSION['admin'])) // Eğer kullanıcı admin değilse
{
    header("Location: index.php"); // index.php sayfasına yönlendir
    exit(); // işlemi sonlandır
}

$urunler = listLastProducts(); // Son eklenen ürünleri getir

// Sayfa numarasını al
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 20;
$offset = ($page - 1) * $records_per_page;

// Toplam kayıt sayısını al
$total_result = $conn->query("SELECT COUNT(*) AS total FROM siparis_gecmisi");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Verileri çek
$query = "SELECT siparis_gecmisi.id , uyeler.tam_ad AS uye , uyeler.tel_no AS uye_tel_no , uyeler.eposta AS uye_eposta  , urunler.urun_adi AS urun , siparis_gecmisi.adet FROM siparis_gecmisi LEFT JOIN uyeler ON siparis_gecmisi.uye_id = uyeler.id LEFT JOIN urunler ON siparis_gecmisi.urun_id = urunler.id LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($query);

// Toplam sayfa sayısını hesapla
$total_pages = ceil($total_records / $records_per_page);

?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Sitem</title>

    <style>
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

        table {

            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #0E3150;
            /* Koyu Mavi */
            color: #FCC78A;
            /* Altın Rengi */
            padding: 8px;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            background-color: #0E3150;
            /* Koyu Mavi */
            color: #FCC78A;
            /* Altın Rengi */
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #00008B;
        }

        .pagination a:hover {
            background-color: #0E3150;
            /* Koyu Mavi */
            color: #f2f2f2;
            /* Beyaz */
        }
    </style>
</head>

<body>

    <div id="main">

        <?php include 'navbar.php'; ?> <!-- navbar import edildi -->

        <div class="container">
            <?php include 'admin_sidebar.php'; ?> <!-- admin_sidebar import edildi -->



            <div class="content" style="padding: 15px;">

                <br><br><br>
                <h1>Sipariş Kayıtları</h1>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Sipariş ID</th>
                            <th>Üye</th>
                            <th>Telefon Numarası</th>
                            <th>E-posta</th>
                            <th>Ürün</th>
                            <th>Adet</th>
                            <!-- Diğer sütunlar -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); // Tabloya bilgiler işlenir. ?></td>
                                <td><?php echo htmlspecialchars($row['uye']); ?></td>
                                <td><?php echo htmlspecialchars($row['uye_tel_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['uye_eposta']); ?></td>
                                <td><?php echo htmlspecialchars($row['urun']); ?></td>
                                <td><?php echo htmlspecialchars($row['adet']); ?></td>
                                <!-- Diğer sütunlar -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Sayfalama Yapısı -->
                <div class="pagination">
                    <?php if ($page > 1) : ?>
                        <a href="?page=<?php echo $page - 1; ?>">Önceki</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages) : ?>
                        <a href="?page=<?php echo $page + 1; ?>">Sonraki</a>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <?php include 'footer.php'; ?> <!-- footer kısmı import edildi -->


    </div>

</body>

</html>