<div class="sidebar">
    <h3 id="kategoriler">Kategoriler</h3>
    <ul class="main-ul">
        <li class="top-category">

            <ul class="sub-category">
                <?php
                echo '<li><a href="urunler.php">Tüm Ürünler</a></li>';
                foreach ($category as $key => $value) { // Kategorileri listele
                    echo '<li><a href="urunler.php?kategori=' . $value['id'] . '">' . $value['kategori_adi'] . '</a></li>';
                }

                ?>
            </ul>
        </li>
    </ul>
</div>