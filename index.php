<?php 
require_once 'koneksi.php';

"PHP TAG": {
	"prefix": "php",
	"body": [
		"<?php $1",
		"$0",
		"?>"
	]
	},

	
	"inline echo": {
	"prefix": "phpp",
	"body": "<?= $$1; ?>"
	},

	"php-n": {
	"prefix": "ph",
	"body": "<?php "
	},
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Toko Bunga</title>
    
</head>
<body>

</body>
</html>






	<!-- DOMPdf -->

<?php
require '../../koneksi.php';
require '../../libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$peminjaman = "SELECT t.id_transaksi,a.nisnip, a.nama, b.judul, t.tanggal_pinjam, t.tanggal_kembali, t.denda
                FROM transaksi t
                JOIN anggota a ON t.id_anggota = a.id_anggota
                JOIN buku b ON t.id_buku = b.id_buku
                WHERE t.denda = 0.00
                ORDER BY t.id_transaksi DESC";
$stmtPeminjaman = $pdo->query($peminjaman);

ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Transaksi Peminjaman</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: cadetblue;
            color: #fff;
        }
        .container {
            max-width: 960px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Data Transaksi Peminjaman</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>NIS/NIP</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Batas Pengembalian</th>
                    
                </tr>
            </thead>
            <tbody>
                    
                <?php while ($transaksi = $stmtPeminjaman->fetch(PDO::FETCH_ASSOC)): ?>
                    
                    <tr>
                        <td><?= $transaksi['id_transaksi'] ?></td>
                        <td><?= $transaksi['nisnip'] ?></td>
                        <td><?= $transaksi['nama'] ?></td>
                        <td><?= $transaksi['judul'] ?></td>
                        <td><?= $transaksi['tanggal_pinjam'] ?></td>
                        <td><?= $transaksi['tanggal_kembali'] ?></td>

                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$html = ob_get_clean();

// Generate PDF with Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("laporan_transaksi.pdf", ["Attachment" => 0]);
?>






<!-- Misal -->

<?php
 require 'koneksi.php';
 session_start();

 
 if (isset($_GET['pesan'])) {
     $success = $_GET['pesan'];
     $url = strtok("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?');
 }
 
 

if (isset($_SESSION['peran'])) {
       if ($_SESSION['peran'] == 'admin' || $_SESSION['peran'] == 'pelanggan') {
                header('location:'.$_SESSION['peran'].'.php');
                exit;
       }else {
                header('location: logout.php');
                exit;
       }
}





if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $nama_pengguna = $_POST['nama_pengguna'];
        $kata_sandi = $_POST['kata_sandi'];

        $stmt = $pdo->prepare('SELECT * FROM pengguna where nama_pengguna = :nama_pengguna');
        $stmt->bindParam(':nama_pengguna', $nama_pengguna);
        $stmt->execute();

        $pengguna = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pengguna) {
                if (password_verify($kata_sandi,$pengguna['kata_sandi'])) {
                        $_SESSION['id_pengguna'] = $pengguna['id'];
                        $_SESSION['peran'] = $pengguna['peran'];

                        if ($_SESSION['peran'] == 'admin' || $_SESSION['peran'] == 'pelanggan') {
                                header('location:'.$_SESSION['peran'].'.php');
                                exit;
                       }else {
                               $error = 'Kesalahan Sistem,Peran tidak ditemukan';
                       }

                        $success = "Kata sandi benar";
                }else {
                        $error = "Kata sandi salah";
                }

        }else {
                $error = "Pengguna Tidak Ditemukan !";   
        }

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <?php if (isset($url)): ?>
        <script>
                history.replaceState(null, null, "<?= $url ?>");
        </script>
<?php endif; ?>
</head>
<body>


<div class="container" style="margin-top: 300px;">
        <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                        <div class="card border-0 shadow-lg rounded">
                                <div class="card-header bg-white border-0 p-4">
                                        <h4 class="text-center">Login Aplikasi</h4>
                                </div>


                                <div class="card-body">
                                        <?php if (isset($error)) : ?>
                                                <div class="alert alert-danger" role="alert">
                                                        <?= $error ?? ''; ?>
                                                </div>

                                        <?php endif; ?>

                                        <?php if (isset($success)) : ?>
                                                <div class="alert alert-success" role="alert">
                                                        <?= $success ?? ''; ?>
                                                </div>
                                        <?php endif; ?>

                                                    

                                        <form action="" method="post">
                                                
                                        <div class="mb-3">
                                                <label for="nama_pengguna" class="label-form">Nama Pengguna</label>
                                                <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" placeholder="Masukan Nama Pengguna">
                                        </div>

                                        <div class="mb-3">
                                                <label for="nama_pengguna" class="label-form">Kata Sandi</label>
                                                <input type="password" name="kata_sandi" id="kata_sandi" class="form-control" placeholder="Masukan Kata Sandi Anda">
                                        </div>
                                        <div class="mt-3 d-flex justify-content-end">
                                                <a href="register.php" class="nav-link mt-2">Daftar akun?</a>
                                                <button class="btn btn-primary ms-3" type="submit">Masuk</button>
                                                </div>



                                        </form>
                                </div>
        




                        </div>
                </div>
        </div>
</div>


        


</body>
</html>


