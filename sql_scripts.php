<?php

include_once 'connection.php';

function listProducts($is_logined = false) // Ürünleri listeleme fonksiyonu
{
    global $conn; // connection.php dosyasındaki $conn değişkenini kullan
    // Ürünleri seçme sorgusu
    $sql = "SELECT * FROM urunler";
    $result = $conn->query($sql);

    // Sonuçları diziye dönüştürme
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row; // Dizinin sonuna yeni bir eleman olarak verileri ekle
        }
    }

    // Diziyi geri döndürme
    return $products;
}

function listLastProducts($is_logined = false) // Son eklenen 5 ürünü listeleme fonksiyonu
{
    global $conn; // connection.php dosyasındaki $conn değişkenini kullan
    // Ürünleri seçme sorgusu
    $sql = "SELECT * FROM urunler ORDER BY id DESC LIMIT 5";
    $result = $conn->query($sql);

    // Sonuçları diziye dönüştürme
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Diziyi geri döndürme
    return $products;
}

function listProductsByCategory($kategori) // Kategoriye göre ürünleri listeleme fonksiyonu
{
    global $conn; // connection.php dosyasındaki $conn değişkenini kullan
    // Ürünleri seçme sorgusu
    $sql = "SELECT * FROM urunler WHERE kategori = $kategori";
    $result = $conn->query($sql);

    // Sonuçları diziye dönüştürme
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Diziyi geri döndürme
    return $products;
}

function getCategories() { // Kategorileri listeleme fonksiyonu
    global $conn; // connection.php dosyasındaki $conn değişkenini kullan
    $categories = array(); // Kategorileri tutacak dizi

    $sql = "SELECT id, kategori_adi FROM kategoriler";
    $result = $conn->query($sql); // Sorguyu çalıştır

    if ($result->num_rows > 0) { // Eğer sonuçlar varsa
        while($row = $result->fetch_assoc()) { // Sonuçları diziye dönüştür
            $categories[] = $row;
        }
    }

    return $categories;
}

function getCategoriName($id) { // Kategori adını alma fonksiyonu
    global $conn; // connection.php dosyasındaki $conn değişkenini kullan
    $category_name = ""; // Kategorileri adını tutacak değişken

    $sql = "SELECT kategori_adi FROM kategoriler WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $category_name = $row['kategori_adi']; // Kategori adını değişkene ata
        }
    }

    return $category_name;
}

function listSepetItems($uye_id) { // Sepet öğelerini listeleme fonksiyonu 
    // Bağlantıyı gerçekleştir
   global $conn;
    // Sepet öğelerini sepet ID'si ile eşleştirerek listele
    $query = "SELECT * FROM sepet_ogeleri WHERE sepet_id IN (SELECT id FROM sepet WHERE uye_id = $uye_id)";
     $result = mysqli_query($conn, $query);
     $sepet_items = mysqli_fetch_all($result, MYSQLI_ASSOC); // Sonuçları diziye dönüştür

    // Sepet öğelerini listele
     return $sepet_items;

}

function getSepetID($uye_id) { // Sepet ID'sini alma fonksiyonu
    global $conn;
    $sepet_id = 0; // Sepet ID'sini tutacak değişken

    $sql = "SELECT id FROM sepet WHERE uye_id = $uye_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sepet_id = $row['id']; // Sepet ID'sini değişkene ata
        }
    }

    // Sepet ID'sini geri döndür
    return $sepet_id;
}

function getUrun($id) { // Ürün bilgilerini alma fonksiyonu
    global $conn;
 

    $sql = "SELECT * FROM urunler where id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $urunler = $row; // Ürün bilgilerini değişkene ata
        }
    }

    return $urunler; // Ürün bilgilerini geri döndür
}

function getGecmisSiparisler($uye_id) { // Geçmiş siparişleri alma fonksiyonu
    global $conn;
    $gecmis_siparisler = array(); // Geçmiş siparişleri tutacak dizi

     $sql = "SELECT * FROM siparis_gecmisi WHERE uye_id = $uye_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gecmis_siparisler[] = $row; // Geçmiş siparişleri dizisine ekle
        }
    }

    return $gecmis_siparisler; // Geçmiş siparişleri dizisini geri döndür
}


function getUser($id) { // Kullanıcı bilgilerini alma fonksiyonu
    global $conn;
 

    $sql = "SELECT * FROM uyeler where id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users = $row; // Kullanıcı bilgilerini değişkene ata
        }
    }

    return $users; // Kullanıcı bilgilerini geri döndür
}