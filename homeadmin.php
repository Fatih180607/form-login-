<?php
session_start();

if (isset($_SESSION['role'])) {
  if($_SESSION["role"] <> "Admin"){
  header("Location: home.php");
  exit;  
  }
} else{
  header("Location:index.php");
}



try {
    $db = new PDO('sqlite:db/db.sqlite3');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = $db->query("SELECT ID,Nama_Produk, Deskripsi, Harga, Gambar FROM Produk");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
} 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="icon" type="image/png" href="gambar/removebg.png" />
    <link rel="stylesheet" href="homeadmin.css"/>
  </head>
  <body>
  <div class="Daftar_Produk">
    <h1>Daftar Produk</h1>   
    <button class="AddProductButton"><a href="addproductadmin.php">Add Product</a></button> 
    <div class="Navbar">
      <img class="LogoNavbar" src="gambar/removebg.png" alt="Logo" />
      <ul>
        <li class="Home">Home</li>
        <li><a href="orderadmin.php">Order</a></li>
      </ul>
      <a class="LogoutButton" href="logout.php">Log Out</a>
</div>
    <table class="tabel_produk">
      <thead>
        <tr>
          <th scope="col">Gambar Produk</th>
          <th scope="col">Nama</th>
          <th scope="col">Deskripsi</th>
          <th scope="col">Harga</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="row_produk">
    <?php
    foreach ($products as $product) {
        echo '<tr>';
        echo '<td><img src="' . htmlspecialchars($product['Gambar']) . '" alt="' . htmlspecialchars($product['Nama_Produk']) . '" class="product-image"></td>';
        echo '<td class="Nama_Produk_Table">' . htmlspecialchars($product['Nama_Produk']) . '</td>';
        echo '<td>' . htmlspecialchars($product['Deskripsi']) . '</td>';
        echo '<td> Price: Rp ' . number_format($product['Harga'], 0, ',', '.') . '</td>';
        echo '<td>';
        echo '<a href="deleteproduk.php?ID=' . htmlspecialchars($product['ID']) . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\')">';
        echo '<input class="ButtonLogin" type="button" value="Delete">';
        echo '</a>';
        echo '<a href="editproduk.php?ID=' . htmlspecialchars($product['ID']) . '">';
        echo '<input class="ButtonEdit" type="button" value="Edit">';
        echo '</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
</tbody>
    </table>
      </div>
  </body>
</html>
