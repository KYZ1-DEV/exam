<?php
$host = 'localhost';
$dbname = 'toko_bunga'; 
$username = 'root'; 
$password = ''; 

try {


    echo password_hash('admin', algo: PASSWORD_DEFAULT);
    

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Mengatur mode error PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Menangkap error jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}
?>