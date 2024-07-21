<?php

include_once 'sql_scripts.php'; // Veritabanı fonksiyonlarını içeren dosya import edildi
session_start(); // Session başlatıldı


// Login (Giriş) işlemi (POST ile gelen veriler alındı. Login adında post var mı kontrol edildi. Var ise giriş işlemi yapılacak.)
if (isset($_POST["login"])) {

    $email = $_POST["email"]; // POST ile gelen eposta alındı
    $password = $_POST["password"]; // POST ile gelen şifre alındı 

    $sql = "SELECT * FROM uyeler WHERE eposta = '$email' AND sifre = '$password'"; 
    // Veritabanından eposta ve şifre kontrolü yapılacak sorgu oluşturuldu
    $result = $conn->query($sql); // Sorgu çalıştırıldı

    if ($result->num_rows == 1) { // Eğer sorgu sonucunda 1 satır dönerse
        
        $sonuc = $result->fetch_assoc(); // Sorgu sonucu alındı

        $_SESSION["user_id"] = $sonuc["id"]; // Session'a kullanıcı id'si eklendi

        if ($sonuc["yetki"] == 1) { // Eğer kullanıcı yetkisi 1 ise admin paneline yönlendirilecek
            $_SESSION["admin"] = true; // Admin paneline erişim izni verildi
            echo "Admin Girişi Başarılı 3 sn içinde yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='admin_paneli.php'>buraya</a> tıklayın.";
            // 3 saniye sonra admin paneline yönlendirileceği belirtildi
            header("Refresh: 3; url=admin_paneli.php"); // 3 saniye sonra admin paneline yönlendirilecek
            exit(); // İşlemi sonlandır
        } else {
            echo "Giriş Başarılı 3 sn içinde anasayfaya yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='index.php'>buraya</a> tıklayın.";
            // 3 saniye sonra anasayfaya yönlendirileceği belirtildi
            header("Refresh: 3; url=index.php"); // 3 saniye sonra anasayfaya yönlendirilecek
            exit(); // İşlemi sonlandır
        }
    } else { // Eğer sorgu sonucunda 1 satır dönmezse

        echo "Giriş Başarısız 3 sn içinde giriş ekranına yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='login.php'>buraya</a> tıklayın.";
        // 3 saniye sonra giriş ekranına yönlendirileceği belirtildi
        header("Refresh: 3; url=login.php"); // 3 saniye sonra giriş ekranına yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}

// Logout (Çıkış) işlemi (GET ile gelen veriler alındı. Logout adında get var mı kontrol edildi. Var ise çıkış işlemi yapılacak.)
if (isset($_GET["logout"])) {
    session_destroy(); // Session sonlandırıldı
    echo "Çıkış Yapıldı. 3 sn içinde anasayfaya yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='index.php'>buraya</a> tıklayın.";
    // 3 saniye sonra anasayfaya yönlendirileceği belirtildi
    header("Refresh: 3; url=index.php"); // 3 saniye sonra anasayfaya yönlendirilecek
    exit(); // İşlemi sonlandır
}


// Register (Kayıt) işlemi (POST ile gelen veriler alındı. Register adında post var mı kontrol edildi. Var ise kayıt işlemi yapılacak.)
if (isset($_POST["register"])) {

    $fullname = $_POST["fullname"]; // POST ile gelen tam ad alındı
    $phone = $_POST["phone"]; // POST ile gelen telefon numarası alındı
    $email = $_POST["email"]; // POST ile gelen eposta alındı
    $address = $_POST["address"]; // POST ile gelen adres alındı
    $password = $_POST["password"]; // POST ile gelen şifre alındı

    $sql = "INSERT INTO uyeler (tam_ad, tel_no, eposta, adres, sifre) VALUES ('$fullname', '$phone', '$email', '$address', '$password')"; 
    // Veritabanına kayıt yapılacak sorgu oluşturuldu

    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        $uye_id = $conn->insert_id; // Eklenen kaydın id'si alındı
        $sepet_sql = "INSERT INTO sepet (uye_id) VALUES ('$uye_id')"; // Üye için sepet oluşturulacak sorgu oluşturuldu
        if ($conn->query($sepet_sql) === TRUE) { // Eğer sepet oluşturma sorgusu başarılı ise
            echo "Kayıt Başarılı 3 sn içinde giriş ekranına yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='login.php'>buraya</a> tıklayın.";
            // 3 saniye sonra giriş ekranına yönlendirileceği belirtildi
            header("Refresh: 3; url=login.php"); // 3 saniye sonra giriş ekranına yönlendirilecek
            exit(); // İşlemi sonlandır
        } else {
            // Eğer sepet oluşturma sorgusu başarısız ise

            $sql = "DELETE FROM uyeler WHERE id = '$id'"; // Üye kaydı silinecek sorgu oluşturuldu
            $conn->query($sql); // Üye kaydı silindi. Sorgu çalıştırıldı

            $sepet_sql = "DELETE FROM sepet WHERE uye_id = '$id'"; // Üye için oluşturulan sepet silinecek sorgu oluşturuldu
            $conn->query($sepet_sql); // Üye için oluşturulan sepet silindi. Sorgu çalıştırıldı

            echo "Kayıt Başarısız 3 sn içinde kayıt ekranına yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='register.php'>buraya</a> tıklayın.";
            // 3 saniye sonra kayıt ekranına yönlendirileceği belirtildi
            header("Refresh: 3; url=register.php"); // 3 saniye sonra kayıt ekranına yönlendirilecek
            exit(); // İşlemi sonlandır
        }
    } else {
        // Eğer sorgu başarısız ise
        echo "Kayıt Başarısız 3 sn içinde kayıt ekranına yönlendiriliyorsunuz.<br>Otomatik yönlendirme olmazsa <a href='register.php'>buraya</a> tıklayın.";
        // 3 saniye sonra kayıt ekranına yönlendirileceği belirtildi
        header("Refresh: 3; url=register.php"); // 3 saniye sonra kayıt ekranına yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}


// Session kontrolü (Eğer kullanıcı giriş yapmamışsa login.php sayfasına yönlendirilecek)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Kullanıcı giriş yapmamışsa login.php sayfasına yönlendirilecek
    exit(); // İşlemi sonlandır
}

// Sepetten ürün çıkarma. (GET ile gelen veriler alınır. Sepetten çıkarılacak ürün id'si alınır. Ürün sepetten çıkarılır.)
if (isset($_GET["sepetten_cikar"]) && isset($_GET["sepet_id"]) && isset($_GET["urun_id"]) && isset($_GET["item_id"])) {
    $item_id = $_GET["item_id"]; // GET ile gelen item id alındı
    $urun_id = $_GET["urun_id"]; // GET ile gelen ürün id alındı
    $sepet_id = $_GET["sepet_id"]; // GET ile gelen sepet id alındı

    $sql = "DELETE FROM sepet_ogeleri WHERE urun_id = '$urun_id' AND sepet_id = '$sepet_id' AND id = '$item_id'";
    // Sepetten ürün çıkarılacak sorgu oluşturuldu
    $conn->query($sql); // Sepetten ürün çıkarıldı. Sorgu çalıştırıldı

    header("location: sepetim.php"); // Sepetim sayfasına yönlendirilecek
    exit(); // İşlemi sonlandır
}

// Sepete ürün ekleme. (POST ile gelen veriler alınır. Sepete eklenecek ürün id'si ve adeti alınır. Ürün sepete eklenir.)
if (isset($_POST["sepete_ekle"])) {
    $urun_id = $_POST["urun_id"]; // POST ile gelen ürün id alındı
    $adet = $_POST["adet"]; // POST ile gelen adet alındı
    $uye_id = $_SESSION["user_id"]; // Session'dan kullanıcı id alındı

    $sql = "Select * from sepet where uye_id = '$uye_id'"; // Üyenin sepet id'sini alacak sorgu oluşturuldu
    $result = $conn->query($sql); // Sorgu çalıştırıldı
    $sepet_id = $result->fetch_assoc()['id']; // Sepet id alındı

    $sql = "INSERT INTO sepet_ogeleri (sepet_id, urun_id, adet) VALUES ('$sepet_id', '$urun_id', '$adet')";
    // Sepete ürün eklenecek sorgu oluşturuldu
    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        header("location: " . $_SERVER['HTTP_REFERER'] . "&sepete_ok=1"); // Ürün sepete eklendi. Önceki sayfaya yönlendirilecek
        exit(); // İşlemi sonlandır
    } else { // Eğer sorgu başarısız ise
        header("location: " . $_SERVER['HTTP_REFERER'] . "&sepete_ok=0"); // Ürün sepete eklenemedi. Önceki sayfaya yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}


// Sepeti boşaltma. (POST ile gelen veriler alınır. Kullanıcının idsi kullanılarak sepeti boşaltılır.)
if (isset($_POST["del_cart"])) {
    $uye_id = $_SESSION["user_id"]; // Session'dan kullanıcı id alındı
    $sepet_id = getSepetID($uye_id); // Kullanıcının sepet id'si alındı

    $sql = "DELETE FROM sepet_ogeleri WHERE sepet_id = '$sepet_id'"; // Sepet boşaltılacak sorgu oluşturuldu
    $conn->query($sql); // Sepet boşaltıldı. Sorgu çalıştırıldı

    header("location: sepetim.php"); // Sepetim sayfasına yönlendirilecek
    exit(); // İşlemi sonlandır
}



// Alışverişi tamamlama. (POST ile gelen veriler alınır. Kullanıcının sepeti alışveriş geçmişine eklenir.)
if (isset($_POST["ok_card"])) {

    $uye_id = $_SESSION["user_id"]; // Session'dan kullanıcı id alındı
    $sepet_id = getSepetID($uye_id); // Kullanıcının sepet id'si alındı

    $sql = "Select * from sepet_ogeleri where sepet_id = '$sepet_id'"; // Sepetteki ürünler alınacak sorgu oluşturuldu
    $result = $conn->query($sql); // Sorgu çalıştırıldı
    $sepet = array(); // Sepetteki ürünlerin tutulacağı dizi oluşturuldu
    while ($row = $result->fetch_assoc()) { // Sorgu sonucunda dönen veriler alınır
        $sepet[] = $row; // Sepetteki ürünler diziye eklenir
    }

    foreach ($sepet as $key => $value) { // Sepetteki ürünler döngü ile alınır
        $urun_id = $value['urun_id']; // Ürün id alınır
        $adet = $value['adet']; // Ürün adeti alınır
        $sql = "INSERT INTO siparis_gecmisi (uye_id, urun_id, adet) VALUES ('$uye_id', '$urun_id', '$adet')";
        // Alışveriş geçmişine eklenecek sorgu oluşturuldu
        $conn->query($sql); // Alışveriş geçmişine eklendi. Sorgu çalıştırıldı

        $sql = "UPDATE urunler SET  adet = adet - '$adet' WHERE id = '$urun_id'"; // Ürün adeti güncellenecek sorgu oluşturuldu
        $conn->query($sql); // Ürün adeti güncellendi. Sorgu çalıştırıldı
        echo $sql; // Sorgu yazdırıldı
    }

    $sql = "DELETE FROM sepet_ogeleri WHERE sepet_id = '$sepet_id'"; // Sepet boşaltılacak sorgu oluşturuldu

    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        header("location: sepetim.php?alisveris_ok=1"); // Alışveriş başarılı. Sepetim sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    } else {
        header("location: sepetim.php?alisveris_ok=0"); // Alışveriş başarısız. Sepetim sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}



// Kullanıcı bilgilerini güncelleme (POST ile gelen veriler alınır. Kullanıcı bilgileri güncellenir.)
if (isset($_POST["update_info"])) {

    $uye_id = $_SESSION["user_id"]; // Session'dan kullanıcı id alındı
    $fullname = $_POST["fullname"]; // POST ile gelen tam ad alındı
    $phone = $_POST["phone"]; // POST ile gelen telefon numarası alındı
    $email = $_POST["email"]; // POST ile gelen eposta alındı
    $address = $_POST["adress"]; // POST ile gelen adres alındı
    $password = $_POST["password"]; // POST ile gelen şifre alındı

    $sql = "UPDATE uyeler SET tam_ad = '$fullname', tel_no = '$phone', eposta = '$email', adres = '$address', sifre = '$password' WHERE id = '$uye_id'";
    // Kullanıcı bilgilerini güncelleyecek sorgu oluşturuldu
    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise

        header("location: profile.php?update_ok=1"); // Kullanıcı bilgileri güncellendi. Profil sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    } else {
        header("location: profile.php?update_ok=0"); // Kullanıcı bilgileri güncellenemedi. Profil sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}



// Ürün Silme (POST ile gelen veriler alınır. Ürün id'si alınır. Ürün silinir.)
if (isset($_POST["del_product"])) {
    $urun_id = $_POST["urun_id"]; // POST ile gelen ürün id alındı

    $sql = "SELECT gorsel_yolu FROM urunler WHERE id = '$urun_id'"; // Ürünün resminin yolunu alacak sorgu oluşturuldu
    $result = $conn->query($sql); // Sorgu çalıştırıldı
    $file_path = $result->fetch_assoc()['gorsel_yolu']; // Ürün resminin yolu alındı

    
    if (file_exists($file_path)) { // Dosya var mı kontrol et
        
        if (unlink($file_path)) { // Dosyayı sil ve başarı durumunu kontrol et
            echo "Dosya başarıyla silindi.";
        } else {
            echo "Dosya silinirken bir hata oluştu.";
        }
    }

    $sql = "DELETE FROM urunler WHERE id = '$urun_id'"; // Ürün silinecek sorgu oluşturuldu
    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        header("location: urun_yonetimi.php?del_ok=1"); // Ürün silindi. Ürün yönetimi sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    } else { // Eğer sorgu başarısız ise
        header("location: urun_yonetimi.php?del_ok=0"); // Ürün silinemedi. Ürün yönetimi sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    }
}


// Ürün Ekleme (POST ile gelen veriler alınır. Ürün bilgileri alınır. Ürün veritabanına eklenir.)
if (isset($_POST["add_product"])) {
    $product_name = $_POST["product_name"]; // POST ile gelen ürün adı alındı
    $description = $_POST["description"]; // POST ile gelen açıklama alındı
    $price = $_POST["price"]; // POST ile gelen fiyat alındı
    $category = $_POST["category"]; // POST ile gelen kategori alındı
    $quantity = $_POST["quantity"]; // POST ile gelen adet alındı

    // Dosya yükleme işlemi
    $target_dir = "gorseller/"; // Dosyanın kaydedileceği klasör
    $target_file = $target_dir . (date("d_m_Y")) . "_" . basename($_FILES["image"]["name"]); // Dosyanın tam yolu
    $uploadOk = 1; 
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Dosya uzantısı alındı

    // Dosya yükleme kontrolü
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Dosya başarıyla yüklendi.";
    } else {
        echo "Dosya yüklenirken bir hata oluştu.";
        exit(); // İşlemi sonlandır
    }

    // Veritabanına kayıt
    $image_path = $target_file; // Resmin yolunu değişkene ata
    $sql = "INSERT INTO urunler (urun_adi, aciklama, fiyat, kategori, adet, gorsel_yolu) VALUES ('$product_name', '$description', '$price', '$category', '$quantity', '$image_path')";
    // Ürün eklenecek sorgu oluşturuldu
    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        header("location: urun_yonetimi.php?add_ok=1"); // Ürün eklendi. Ürün yönetimi sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    } else {
        header("location: urun_yonetimi.php?add_ok=0");
        exit();
    }
}


// Ürün Güncelleme (POST ile gelen veriler alınır. Ürün bilgileri alınır. Ürün veritabanında güncellenir.)
if (isset($_POST["edit_product"])) {
    $product_name = $_POST["product_name"]; // POST ile gelen ürün adı alındı
    $description = $_POST["description"]; // POST ile gelen açıklama alındı
    $price = $_POST["price"]; // POST ile gelen fiyat alındı
    $category = $_POST["category"]; // POST ile gelen kategori alındı
    $quantity = $_POST["quantity"]; // POST ile gelen adet alındı
    $urun_id = $_POST["urun_id"]; // POST ile gelen ürün id alındı


    // Veritabanına kayıt
    $sql = "UPDATE urunler SET urun_adi = '$product_name', aciklama = '$description', fiyat = '$price', kategori = '$category', adet = '$quantity' WHERE id = '$urun_id'";
    // Ürün güncellenecek sorgu oluşturuldu
    if ($conn->query($sql) === TRUE) { // Eğer sorgu başarılı ise
        header("location: urun_yonetimi.php?edit_ok=1"); // Ürün güncellendi. Ürün yönetimi sayfasına yönlendirilecek
        exit(); // İşlemi sonlandır
    } else {
        header("location: urun_yonetimi.php?edit_ok=0");
        exit();
    }
}
